<?php

namespace App\Http\Controllers;

use App\Models\Gatepass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:student');
    }

    /**
     * Get student record or create one if it doesn't exist
     */
    private function getOrCreateStudent()
    {
        $user = Auth::user();
        $student = $user->student;

        if (!$student) {
            // Create a basic student record
            $student = Student::create([
                'user_id' => $user->id,
                'department_id' => 1, // Default department - should be updated
                'register_number' => 'TEMP' . $user->id,
                'semester' => 1,
                'section' => 'A',
                'hosteller' => 'no',
                'parent_name' => 'Pending',
                'parent_phone' => '0000000000',
                'address' => 'Pending',
            ]);
        }

        return $student;
    }

    public function dashboard()
    {
        $student = $this->getOrCreateStudent();
        $student->load(['user', 'department']);
        
        $totalGatepasses = $student->gatepasses()->count();
        $pendingGatepasses = $student->pendingGatepasses()->count();
        $approvedGatepasses = $student->approvedGatepasses()->count();
        $rejectedGatepasses = $student->rejectedGatepasses()->count();

        $recentGatepasses = $student->gatepasses()
            ->with(['student.user', 'student.department'])
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact(
            'totalGatepasses',
            'pendingGatepasses',
            'approvedGatepasses',
            'rejectedGatepasses',
            'recentGatepasses'
        ));
    }

    public function profile()
    {
        $student = $this->getOrCreateStudent();
        $student->load(['user', 'department']);
        return view('student.profile', compact('student'));
    }

    public function createGatepass()
    {
        $student = $this->getOrCreateStudent();
        return view('student.gatepass.create', compact('student'));
    }

    public function storeGatepass(Request $request)
    {
        $request->validate([
            'gatepass_date' => 'required|date|after_or_equal:today',
            'out_time' => 'required|date_format:H:i',
            'in_time' => 'required|date_format:H:i|after:out_time',
            'reason' => 'required|string|max:500'
        ]);

        $student = $this->getOrCreateStudent();

        $existingGatepass = Gatepass::where('student_id', $student->id)
            ->where('college_id', $this->getCurrentCollegeId())
            ->where('gatepass_date', $request->gatepass_date)
            ->whereIn('status', ['pending', 'staff_approved', 'hod_approved', 'final_approved'])
            ->first();

        if ($existingGatepass) {
            return back()->with('error', 'You already have an active gatepass for this date.');
        }

        $gatepass = Gatepass::create([
            'student_id' => $student->id,
            'college_id' => $this->getCurrentCollegeId(),
            'gatepass_date' => $request->gatepass_date,
            'out_time' => $request->gatepass_date . ' ' . $request->out_time,
            'in_time' => $request->gatepass_date . ' ' . $request->in_time,
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        // Send email notifications to all relevant authorities
        $this->sendGatepassNotificationsToAll($gatepass);
        
        // Send acknowledgment email to student
        $this->sendSubmissionAcknowledgment($gatepass);

        return redirect()->route('student.gatepasses.index')
            ->with('success', 'Gatepass request submitted successfully!');
    }

    public function indexGatepasses(Request $request)
    {
        $student = $this->getOrCreateStudent();
        
        $query = $student->gatepasses()
            ->with(['student.user', 'student.department']);
        
        // Apply filters if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date_from')) {
            $query->whereDate('gatepass_date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('gatepass_date', '<=', $request->date_to);
        }
        
        $gatepasses = $query->latest()->paginate(10);

        return view('student.gatepass.index', compact('gatepasses'));
    }

    public function showGatepass(Gatepass $gatepass)
    {
        // Check if the gatepass belongs to the authenticated student
        if ($gatepass->student_id !== Auth::user()->student->id) {
            abort(403, 'This action is unauthorized.');
        }
        
        $gatepass->load(['student.user', 'student.department']);
        return view('student.gatepass.show', compact('gatepass'));
    }

    public function downloadGatepass(Gatepass $gatepass)
    {
        // Check if the gatepass belongs to the authenticated student
        if ($gatepass->student_id !== Auth::user()->student->id) {
            abort(403, 'This action is unauthorized.');
        }
        
        // Check if gatepass is approved
        if (!$gatepass->isFinalApproved()) {
            return back()->with('error', 'Only approved gatepasses can be downloaded.');
        }
        
        // Get theme color from college
        $primaryColor = Auth::user()->college->primary_color ?? '#3B82F6';
        
        // Generate base64 images for PDF (handle missing files)
        $watermarkBase64 = $this->imageToBase64(public_path('images/watermark.png'));
        $logoBase64 = $this->imageToBase64(public_path('images/logo.png'));
        
        // Use default avatar if student photo doesn't exist
        $studentPhotoPath = public_path('images/avatars/' . $gatepass->student->id . '.jpg');
        if (!file_exists($studentPhotoPath)) {
            // Use inline SVG as default avatar
            $studentPhotoBase64 = 'data:image/svg+xml;base64,' . base64_encode(
                '<svg width="120" height="150" xmlns="http://www.w3.org/2000/svg"><rect width="120" height="150" fill="#f3f4f6"/><circle cx="60" cy="45" r="20" fill="#9ca3af"/><path d="M60 75c-22 0-40 18-40 40v10h80v-10c0-22-18-40-40-40z" fill="#9ca3af"/></svg>'
            );
        } else {
            $studentPhotoBase64 = $this->imageToBase64($studentPhotoPath);
        }
        
        // Generate QR code for this specific gatepass
        $qrCode = null;
        if ($gatepass->isFinalApproved()) {
            try {
                $qrUrl = route('gatepass.qr.show', $gatepass->id);
                $qrApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=" . urlencode($qrUrl) . "&format=png&margin=2&ecc=H&color=000000&bgcolor=FFFFFF";
                
                // Download QR code image
                $qrImageData = file_get_contents($qrApiUrl);
                if ($qrImageData !== false) {
                    $qrCode = 'data:image/png;base64,' . base64_encode($qrImageData);
                }
            } catch (\Exception $e) {
                $qrCode = null;
            }
        }
        
        // Generate PDF
        $pdf = \PDF::loadView('student.gatepass.pdf', compact(
            'gatepass', 
            'primaryColor',
            'watermarkBase64',
            'logoBase64', 
            'studentPhotoBase64',
            'qrCode'
        ));
        
        return $pdf->download('gatepass-' . $gatepass->id . '.pdf');
    }

    protected function getCurrentCollegeId()
    {
        return Auth::user()->college_id;
    }
    
    /**
     * Convert image file to base64 string
     */
    private function imageToBase64($imagePath)
    {
        if (!file_exists($imagePath)) {
            return null;
        }
        
        $imageData = file_get_contents($imagePath);
        return 'data:image/png;base64,' . base64_encode($imageData);
    }

    /**
     * Send gatepass notifications to all relevant authorities
     */
    private function sendGatepassNotificationsToAll(Gatepass $gatepass)
    {
        try {
            $recipients = [];
            
            // Always send to staff/class teacher
            $staff = $this->findNotificationRecipient($gatepass, 'staff');
            if ($staff) {
                $recipients[] = ['user' => $staff, 'type' => 'staff'];
                \Log::info('Found staff recipient: ' . $staff->name . ' (' . $staff->email . ')');
            } else {
                \Log::warning('No staff recipient found for college ID: ' . $gatepass->college_id);
            }
            
            // Always send to HOD
            $hod = $this->findNotificationRecipient($gatepass, 'hod');
            if ($hod) {
                $recipients[] = ['user' => $hod, 'type' => 'hod'];
                \Log::info('Found HOD recipient: ' . $hod->name . ' (' . $hod->email . ')');
            } else {
                \Log::warning('No HOD recipient found for college ID: ' . $gatepass->college_id . ', department ID: ' . ($gatepass->student->department_id ?? 'null'));
            }
            
            // Send to warden if student is hosteller or if warden exists
            $warden = $this->findNotificationRecipient($gatepass, 'warden');
            if ($warden && ($gatepass->student->hosteller === 'yes' || $warden)) {
                $recipients[] = ['user' => $warden, 'type' => 'warden'];
                \Log::info('Found warden recipient: ' . $warden->name . ' (' . $warden->email . ')');
            } else {
                \Log::info('No warden recipient found or student not hosteller. Hosteller status: ' . ($gatepass->student->hosteller ?? 'unknown'));
            }
            
            // Send to security for information
            $security = $this->findNotificationRecipient($gatepass, 'security');
            if ($security) {
                $recipients[] = ['user' => $security, 'type' => 'security'];
                \Log::info('Found security recipient: ' . $security->name . ' (' . $security->email . ')');
            } else {
                \Log::warning('No security recipient found for college ID: ' . $gatepass->college_id);
            }
            
            // Send emails to all recipients
            foreach ($recipients as $recipient) {
                \Log::info('Attempting to send email to: ' . $recipient['user']->email . ' (' . $recipient['type'] . ')');
                \Mail::to($recipient['user']->email)->send(
                    new \App\Mail\GatepassNotificationMail($gatepass, $recipient['user'], $recipient['type'])
                );
                \Log::info('Email sent successfully to: ' . $recipient['user']->email);
            }
            
            \Log::info('Gatepass notifications sent to ' . count($recipients) . ' recipients');
            
        } catch (\Exception $e) {
            \Log::error('Failed to send gatepass notifications: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Find appropriate notification recipient
     */
    private function findNotificationRecipient(Gatepass $gatepass, string $approvalType): ?\App\Models\User
    {
        // Special handling for DHARMAPRAKASH STUDENT
        if ($gatepass->student->user->name === 'DHARMAPRAKASH STUDENT') {
            return $this->findDharmaprakashRecipient($approvalType);
        }
        
        $query = \App\Models\User::where('role', $approvalType)
                                ->where('college_id', $gatepass->college_id)
                                ->where('is_active', true);
        
        // For HOD, filter by department
        if ($approvalType === 'hod' && $gatepass->student->department) {
            $query->where('department_id', $gatepass->student->department_id);
        }
        
        return $query->first();
    }
    
    /**
     * Find specific recipient for DHARMAPRAKASH STUDENT
     */
    private function findDharmaprakashRecipient(string $approvalType): ?\App\Models\User
    {
        $recipients = [
            'staff' => 'DHARMAPRAKASH L',
            'hod' => 'DHARMAPRAKASH HOD', 
            'warden' => 'DHARMAPRAKASH WARDEN',
            'security' => 'SECURITY OFFICER'
        ];
        
        if (isset($recipients[$approvalType])) {
            return \App\Models\User::where('name', $recipients[$approvalType])
                                   ->where('is_active', true)
                                   ->first();
        }
        
        return null;
    }

    /**
     * Send submission acknowledgment to student
     */
    private function sendSubmissionAcknowledgment(Gatepass $gatepass)
    {
        try {
            \Mail::to($gatepass->student->user->email)->send(
                new \App\Mail\GatepassAcknowledgmentMail(
                    $gatepass, 
                    $gatepass->student->user, 
                    'submitted', 
                    $gatepass->student->user
                )
            );
            
            \Log::info('Submission acknowledgment sent to student: ' . $gatepass->student->user->email);
            
        } catch (\Exception $e) {
            \Log::error('Failed to send submission acknowledgment: ' . $e->getMessage());
        }
    }
}
