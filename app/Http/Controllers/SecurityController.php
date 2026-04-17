<?php

namespace App\Http\Controllers;

use App\Models\Gatepass;
use App\Models\User;
use App\Models\Student;
use App\Models\SecurityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SecurityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:security');
    }

    public function dashboard()
    {
        $today = now()->format('Y-m-d');
        
        // Fixed dashboard logic
        $pendingGatepasses = Gatepass::where('status', 'pending')->count();
        $approvedGatepasses = Gatepass::where('status', 'final_approved')->count();
        $rejectedGatepasses = Gatepass::where('status', 'like', '%rejected')->count();
        
        // Recent gatepasses for today
        $recentGatepasses = Gatepass::with(['student.user'])
            ->whereDate('gatepass_date', $today)
            ->latest()
            ->take(5)
            ->get();
            
        // Today's entry/exit statistics
        $todayExits = SecurityLog::whereDate('created_at', $today)
            ->where('action', 'exit')
            ->count();
        $todayEntries = SecurityLog::whereDate('created_at', $today)
            ->where('action', 'entry')
            ->count();

        return view('security.dashboard', compact(
            'pendingGatepasses', 
            'approvedGatepasses', 
            'rejectedGatepasses',
            'recentGatepasses',
            'todayExits',
            'todayEntries'
        ));
    }

    public function verifyGatepass(Request $request)
    {
        $request->validate([
            'gatepass_id' => 'required|string',
        ]);

        $gatepassId = $request->gatepass_id;
        
        // Try to find by ID or QR code
        $gatepass = Gatepass::with(['student.user', 'student.department'])
            ->where('id', $gatepassId)
            ->orWhere('qr_code', $gatepassId)
            ->first();

        if (!$gatepass) {
            return response()->json([
                'success' => false,
                'message' => 'Gatepass not found!'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'gatepass' => $gatepass,
            'student' => $gatepass->student,
            'status' => $gatepass->status,
            'status_text' => $this->getStatusText($gatepass->status)
        ]);
    }

    public function scanQR()
    {
        return view('security.scan');
    }

    public function markExit(Request $request)
    {
        $request->validate([
            'gatepass_id' => 'required|exists:gatepasses,id',
        ]);

        $gatepass = Gatepass::findOrFail($request->gatepass_id);
        
        // Check if gatepass is approved
        if ($gatepass->status !== 'final_approved') {
            return response()->json([
                'success' => false,
                'message' => 'Only approved gatepasses can be marked for exit!'
            ], 400);
        }

        // Check if student already has pending exit
        if (SecurityLog::hasPendingExit($gatepass->student_id)) {
            return response()->json([
                'success' => false,
                'message' => 'Student already has a pending exit. Mark entry first!'
            ], 400);
        }

        // Create exit log
        SecurityLog::create([
            'gatepass_id' => $gatepass->id,
            'student_id' => $gatepass->student_id,
            'verified_by' => Auth::id(),
            'action' => 'exit',
            'exit_time' => now(),
            'ip_address' => $request->ip(),
            'location' => $request->location ?? 'Main Gate',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Exit marked successfully!'
        ]);
    }

    public function markEntry(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $studentId = $request->student_id;
        
        // Find pending exit log
        $pendingExit = SecurityLog::getLastExit($studentId);
        
        if (!$pendingExit) {
            return response()->json([
                'success' => false,
                'message' => 'No pending exit found for this student!'
            ], 400);
        }

        // Update the exit log with entry time
        $pendingExit->update([
            'entry_time' => now(),
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Entry marked successfully!'
        ]);
    }

    public function index()
    {
        $gatepasses = Gatepass::with(['student.user', 'student.department'])->latest()->paginate(10);
        return view('security.gatepasses.index', compact('gatepasses'));
    }

    public function pending()
    {
        $gatepasses = Gatepass::where('status', 'pending')->with(['student.user', 'student.department'])->latest()->paginate(10);
        return view('security.gatepasses.pending', compact('gatepasses'));
    }

    public function approved()
    {
        $gatepasses = Gatepass::where('status', 'final_approved')->with(['student.user', 'student.department'])->latest()->paginate(10);
        return view('security.gatepasses.approved', compact('gatepasses'));
    }

    public function rejected()
    {
        $gatepasses = Gatepass::where('status', 'like', '%rejected')->with(['student.user', 'student.department'])->latest()->paginate(10);
        return view('security.gatepasses.rejected', compact('gatepasses'));
    }

    public function logs()
    {
        $logs = SecurityLog::with(['gatepass', 'student.user', 'verifiedBy'])
            ->latest()
            ->paginate(20);
            
        return view('security.logs', compact('logs'));
    }

    private function getStatusText($status)
    {
        $statusMap = [
            'pending' => 'Pending Approval',
            'staff_approved' => 'Staff Approved',
            'staff_rejected' => 'Staff Rejected',
            'hod_approved' => 'HOD Approved',
            'hod_rejected' => 'HOD Rejected',
            'warden_approved' => 'Warden Approved',
            'warden_rejected' => 'Warden Rejected',
            'final_approved' => 'Final Approved',
        ];

        return $statusMap[$status] ?? 'Unknown';
    }
}
