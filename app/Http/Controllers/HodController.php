<?php

namespace App\Http\Controllers;

use App\Models\Gatepass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:hod');
    }

    public function dashboard()
    {
        $hod = Auth::user()->hod;
        
        $totalRequests = $hod->pendingGatepasses()->count();
        $approvedToday = $hod->approvedGatepasses()
            ->whereDate('hod_approved_at', today())
            ->count();
        $rejectedToday = Gatepass::where('hod_approved_by', Auth::id())
            ->whereIn('status', ['hod_rejected'])
            ->whereDate('updated_at', today())
            ->count();

        $departmentStats = [
            'total' => $hod->departmentGatepasses()->count(),
            'pending' => $hod->departmentGatepasses()->pending()->count(),
            'approved' => $hod->departmentGatepasses()->finalApproved()->count(),
            'rejected' => $hod->departmentGatepasses()->rejected()->count(),
        ];

        $pendingGatepasses = $hod->pendingGatepasses()
            ->with(['student', 'student.department', 'student.user', 'staffApprovedBy'])
            ->latest()
            ->take(5)
            ->get();

        $recentApprovals = $hod->approvedGatepasses()
            ->with(['student', 'student.department'])
            ->latest('hod_approved_at')
            ->take(5)
            ->get();

        return view('hod.dashboard', compact(
            'totalRequests',
            'approvedToday',
            'rejectedToday',
            'departmentStats',
            'pendingGatepasses',
            'recentApprovals'
        ));
    }

    public function pendingGatepasses()
    {
        $hod = Auth::user()->hod;
        $pendingGatepasses = $hod->pendingGatepasses()
            ->with(['student', 'student.department', 'student.user', 'staffApprovedBy'])
            ->latest()
            ->paginate(10);

        return view('hod.gatepass.pending', compact('pendingGatepasses'));
    }

    public function approveGatepass(Request $request, Gatepass $gatepass)
    {
        if (!$gatepass->canBeApprovedByHod()) {
            return back()->with('error', 'This gatepass cannot be approved at this stage.');
        }

        $request->validate([
            'action' => 'required|in:approve,reject',
            'remarks' => 'nullable|string|max:500'
        ]);

        if ($request->action === 'approve') {
            $gatepass->update([
                'status' => $gatepass->student->hosteller === 'yes' ? 'hod_approved' : 'final_approved',
                'hod_remarks' => $request->remarks,
                'hod_approved_at' => now(),
                'hod_approved_by' => Auth::id(),
                'final_approved_at' => $gatepass->student->hosteller === 'no' ? now() : null,
            ]);

            $message = $gatepass->student->hosteller === 'yes' 
                ? 'Gatepass approved and forwarded to Warden!' 
                : 'Gatepass approved successfully!';
        } else {
            $gatepass->update([
                'status' => 'hod_rejected',
                'hod_remarks' => $request->remarks,
                'hod_approved_at' => now(),
                'hod_approved_by' => Auth::id()
            ]);

            $message = 'Gatepass rejected!';
        }

        return back()->with('success', $message);
    }

    public function departmentGatepasses()
    {
        $hod = Auth::user()->hod;
        $gatepasses = $hod->departmentGatepasses()
            ->with(['student', 'student.department', 'student.user'])
            ->latest()
            ->paginate(10);

        return view('hod.gatepass.department', compact('gatepasses'));
    }

    public function approvedGatepasses()
    {
        $hod = Auth::user()->hod;
        $approvedGatepasses = $hod->approvedGatepasses()
            ->with(['student', 'student.department'])
            ->latest('hod_approved_at')
            ->paginate(10);

        return view('hod.gatepass.approved', compact('approvedGatepasses'));
    }

    public function reports()
    {
        $hod = Auth::user()->hod;
        
        $monthlyStats = $hod->departmentGatepasses()
            ->selectRaw('MONTH(gatepass_date) as month, COUNT(*) as count')
            ->whereYear('gatepass_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $statusStats = [
            'pending' => $hod->departmentGatepasses()->pending()->count(),
            'staff_approved' => $hod->departmentGatepasses()->staffApproved()->count(),
            'hod_approved' => $hod->departmentGatepasses()->hodApproved()->count(),
            'final_approved' => $hod->departmentGatepasses()->finalApproved()->count(),
            'rejected' => $hod->departmentGatepasses()->rejected()->count(),
        ];

        return view('hod.reports', compact('monthlyStats', 'statusStats'));
    }

    public function profile()
    {
        $hod = Auth::user()->hod->load(['user', 'department']);
        return view('hod.profile', compact('hod'));
    }
}
