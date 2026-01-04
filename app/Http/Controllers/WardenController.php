<?php

namespace App\Http\Controllers;

use App\Models\Gatepass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WardenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:warden');
    }

    public function dashboard()
    {
        $warden = Auth::user()->warden->load(['user']);
        
        $totalRequests = $warden->pendingGatepasses()->count();
        $approvedToday = $warden->approvedGatepasses()
            ->whereDate('warden_approved_at', today())
            ->count();
        $rejectedToday = Gatepass::where('warden_approved_by', Auth::id())
            ->whereIn('status', ['warden_rejected'])
            ->whereDate('updated_at', today())
            ->count();

        $hostellerStats = [
            'total' => $warden->hostellerGatepasses()->count(),
            'pending' => $warden->hostellerGatepasses()->pending()->count(),
            'approved' => $warden->hostellerGatepasses()->finalApproved()->count(),
            'rejected' => $warden->hostellerGatepasses()->rejected()->count(),
        ];

        $pendingGatepasses = $warden->pendingGatepasses()
            ->with(['student.user', 'student.department', 'hodApprovedBy'])
            ->latest()
            ->take(5)
            ->get();

        $recentApprovals = $warden->approvedGatepasses()
            ->with(['student.user', 'student.department'])
            ->latest('warden_approved_at')
            ->take(5)
            ->get();

        return view('warden.dashboard', compact(
            'totalRequests',
            'approvedToday',
            'rejectedToday',
            'hostellerStats',
            'pendingGatepasses',
            'recentApprovals'
        ));
    }

    public function pendingGatepasses()
    {
        $warden = Auth::user()->warden;
        $pendingGatepasses = $warden->pendingGatepasses()
            ->with(['student', 'student.department', 'student.user', 'hodApprovedBy'])
            ->latest()
            ->paginate(10);

        return view('warden.gatepass.pending', compact('pendingGatepasses'));
    }

    public function approveGatepass(Request $request, Gatepass $gatepass)
    {
        if (!$gatepass->canBeApprovedByWarden()) {
            return back()->with('error', 'This gatepass cannot be approved at this stage.');
        }

        $request->validate([
            'action' => 'required|in:approve,reject',
            'remarks' => 'nullable|string|max:500'
        ]);

        if ($request->action === 'approve') {
            $gatepass->update([
                'status' => 'final_approved',
                'warden_remarks' => $request->remarks,
                'warden_approved_at' => now(),
                'warden_approved_by' => Auth::id(),
                'final_approved_at' => now(),
                'qr_code' => 'GP-' . strtoupper(uniqid())
            ]);

            return back()->with('success', 'Gatepass approved successfully!');
        } else {
            $gatepass->update([
                'status' => 'warden_rejected',
                'warden_remarks' => $request->remarks,
                'warden_approved_at' => now(),
                'warden_approved_by' => Auth::id()
            ]);

            return back()->with('success', 'Gatepass rejected!');
        }
    }

    public function hostellerGatepasses()
    {
        $warden = Auth::user()->warden;
        $gatepasses = $warden->hostellerGatepasses()
            ->with(['student', 'student.department', 'student.user'])
            ->latest()
            ->paginate(10);

        return view('warden.gatepass.hostellers', compact('gatepasses'));
    }

    public function approvedGatepasses()
    {
        $warden = Auth::user()->warden;
        $approvedGatepasses = $warden->approvedGatepasses()
            ->with(['student', 'student.department'])
            ->latest('warden_approved_at')
            ->paginate(10);

        return view('warden.gatepass.approved', compact('approvedGatepasses'));
    }

    public function verification()
    {
        return view('warden.verification');
    }

    public function verifyGatepass(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string'
        ]);

        $gatepass = Gatepass::where('qr_code', $request->qr_code)
            ->with(['student', 'student.department', 'student.user'])
            ->first();

        if (!$gatepass) {
            return back()->with('error', 'Invalid QR code!');
        }

        if (!$gatepass->isFinalApproved()) {
            return back()->with('error', 'Gatepass is not approved!');
        }

        if ($gatepass->gatepass_date->lt(today())) {
            return back()->with('error', 'Gatepass has expired!');
        }

        return view('warden.verification-result', compact('gatepass'));
    }

    public function showGatepass(Gatepass $gatepass)
    {
        // Check if gatepass belongs to a hosteller
        if ($gatepass->student->hosteller !== 'yes') {
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

        return view('warden.gatepass.show', compact('gatepass'));
    }

    public function reports()
    {
        $warden = Auth::user()->warden;
        
        $monthlyStats = $warden->hostellerGatepasses()
            ->selectRaw('MONTH(gatepass_date) as month, COUNT(*) as count')
            ->whereYear('gatepass_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $statusStats = [
            'pending' => $warden->hostellerGatepasses()->pending()->count(),
            'hod_approved' => $warden->hostellerGatepasses()->hodApproved()->count(),
            'final_approved' => $warden->hostellerGatepasses()->finalApproved()->count(),
            'rejected' => $warden->hostellerGatepasses()->rejected()->count(),
        ];

        return view('warden.reports', compact('monthlyStats', 'statusStats'));
    }

    public function downloadReport()
    {
        $warden = Auth::user()->warden;
        
        $gatepasses = $warden->hostellerGatepasses()
            ->with(['student.user', 'student.department'])
            ->latest()
            ->get();

        $pdf = PDF::loadView('warden.reports_pdf', compact('gatepasses'));
        return $pdf->download('hosteller-gatepass-report.pdf');
    }

    public function profile()
    {
        $warden = Auth::user()->warden->load(['user']);
        return view('warden.profile', compact('warden'));
    }
}
