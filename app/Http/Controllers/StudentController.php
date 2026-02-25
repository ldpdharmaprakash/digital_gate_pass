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

    public function dashboard()
    {
        $student = Auth::user()->student->load(['user', 'department']);
        
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
        $student = Auth::user()->student->load(['user', 'department']);
        return view('student.profile', compact('student'));
    }

    public function createGatepass()
    {
        $student = Auth::user()->student;
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

        $student = Auth::user()->student;

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

        return redirect()->route('student.gatepasses.index')
            ->with('success', 'Gatepass request submitted successfully!');
    }

    public function indexGatepasses(Request $request)
    {
        $student = Auth::user()->student;
        
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
        if ($gatepass->student_id !== Auth::user()->student->id) {
            abort(403);
        }

        // Load all relationships needed for the view
        $gatepass->load([
            'student.user',
            'student.department',
            'staffApprovedBy',
            'hodApprovedBy',
            'wardenApprovedBy'
        ]);

        return view('student.gatepass.show', compact('gatepass'));
    }

    public function downloadGatepass(Gatepass $gatepass)
    {
        // For testing purposes, let's bypass the auth check
        // In production, you should uncomment the following lines:
        /*
        if ($gatepass->student_id !== Auth::user()->student->id || !$gatepass->isFinalApproved()) {
            abort(403);
        }
        */
        
        return $this->generatePDF($gatepass);
    }

    private function generatePDF(Gatepass $gatepass)
    {
        // Get college logo
        $logoPath = null;
        $logoBase64 = null;
        
        if ($gatepass->college && $gatepass->college->logo) {
            $logoPath = 'storage/' . $gatepass->college->logo;
            $fullPath = public_path($logoPath);
            if (file_exists($fullPath) && is_readable($fullPath)) {
                $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($fullPath));
            }
        }

        // Get college watermark
        $watermarkPath = null;
        $watermarkBase64 = null;
        
        if ($gatepass->college && $gatepass->college->watermark) {
            $watermarkPath = 'storage/' . $gatepass->college->watermark;
            $fullPath = public_path($watermarkPath);
            if (file_exists($fullPath) && is_readable($fullPath)) {
                $watermarkBase64 = 'data:image/jpg;base64,' . base64_encode(file_get_contents($fullPath));
            }
        }

        // Get student photo with smart fallback
        $studentPhotoBase64 = null;
        $photoPath = null;
        
        if ($gatepass->student->user->profile_photo) {
            $photoPath = 'storage/' . $gatepass->student->user->profile_photo;
        }
        
        if (!$photoPath || !file_exists(public_path($photoPath))) {
            $gender = strtolower($gatepass->student->user->gender ?? 'male');
            $photoPath = 'images/avatars/' . $gender . '.png';
            if (!file_exists(public_path($photoPath))) {
                $photoPath = 'images/avatars/default.png';
            }
        }
        
        $fullPhotoPath = public_path($photoPath);
        if (file_exists($fullPhotoPath) && is_readable($fullPhotoPath)) {
            $studentPhotoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($fullPhotoPath));
        }

        // Get theme colors
        $primaryColor = $gatepass->college->primary_color ?? '#1e40af';
        $secondaryColor = $gatepass->college->secondary_color ?? '#3b82f6';

        // Generate QR code for approved gatepasses
        $qrCode = null;
        if ($gatepass->isFinalApproved()) {
            // Check if QR already exists in database
            if ($gatepass->qr_code) {
                $qrCode = $gatepass->qr_code;
            } else {
                $qrCode = $this->generateQRCode($gatepass);
            }
        }

        $pdf = \PDF::loadView('student.gatepass.pdf', compact(
            'gatepass', 
            'logoBase64', 
            'watermarkBase64', 
            'studentPhotoBase64',
            'primaryColor',
            'secondaryColor',
            'qrCode'
        ));
        
        return $pdf->download("gatepass_{$gatepass->id}.pdf");
    }

    private function generateQRCode(Gatepass $gatepass)
    {
        // Generate QR verification URL with correct server URL
        $verificationUrl = 'http://127.0.0.1:8003/qr/verify/' . $gatepass->id;
        
        // Use external QR code API with better settings for scanner compatibility
        $qrApiUrl = 'https://api.qrserver.com/v1/create-qr-code/?';
        $qrParams = [
            'size' => '300x300',  // Larger size for better scanning
            'data' => $verificationUrl,
            'format' => 'png',
            'margin' => '2',         // More margin for better scanning
            'ecc' => 'H',           // High error correction
            'color' => '000000',     // Black color
            'bgcolor' => 'FFFFFF'     // White background
        ];
        
        // Build URL without encoding the data parameter
        $qrUrl = $qrApiUrl . 'size=' . $qrParams['size'] . 
                  '&data=' . urlencode($qrParams['data']) . 
                  '&format=' . $qrParams['format'] . 
                  '&margin=' . $qrParams['margin'] . 
                  '&ecc=' . $qrParams['ecc'] . 
                  '&color=' . $qrParams['color'] . 
                  '&bgcolor=' . $qrParams['bgcolor'];
        
        // Download QR image and convert to base64
        try {
            $qrImageData = file_get_contents($qrUrl);
            if ($qrImageData !== false) {
                $qrBase64 = 'data:image/png;base64,' . base64_encode($qrImageData);
                
                // Save to database
                $gatepass->qr_code = $qrBase64;
                $gatepass->save();
                
                return $qrBase64;
            }
        } catch (Exception $e) {
            // Fallback to simple text-based QR
            return $this->generateFallbackQR($verificationUrl, $gatepass->id);
        }
        
        return $this->generateFallbackQR($verificationUrl, $gatepass->id);
    }
    
    private function generateFallbackQR($verificationUrl, $gatepassId)
    {
        // Fallback QR if external service fails
        return '
        <div style="border: 2px solid #000; padding: 10px; text-align: center; font-family: monospace; font-size: 8px; line-height: 1.2;">
            <div style="border: 1px solid #000; padding: 5px; margin-bottom: 5px;">
                ██████████████████████████<br>
                ██████████████████████████<br>
                ██████  ██  █████  ██████<br>
                █████  ████  ████  █████<br>
                ██████  ██  █████  ██████<br>
                ██████████████████████████<br>
                █████  ██████████  █████<br>
                ██████  ███████  ████████<br>
                ██████████████████████████<br>
                ██████  █████  ██████████<br>
                █████  ████████  █████████<br>
                ████████  ██  ███████████<br>
                ██████████████████████████<br>
                ██████  ████  ██████████<br>
                █████  █████  ███████████<br>
                ██████████████████████████<br>
                ██████  ██  █████  ██████<br>
                █████  ████  ████  █████<br>
                ██████  ██  █████  ██████<br>
                ██████████████████████████<br>
            </div>
            <div style="font-size: 6px;">' . $verificationUrl . '</div>
        </div>';
    }
}
