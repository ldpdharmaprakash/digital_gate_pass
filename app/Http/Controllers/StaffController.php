<?php

namespace App\Http\Controllers;

use App\Models\Gatepass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:staff');
    }

    public function dashboard()
    {
        $staff = Auth::user()->staff;
        
        $totalRequests = $staff->pendingGatepasses()->count();
        $approvedToday = $staff->approvedGatepasses()
            ->whereDate('staff_approved_at', today())
            ->count();
        $rejectedToday = Gatepass::where('staff_approved_by', Auth::id())
            ->whereIn('status', ['staff_rejected'])
            ->whereDate('updated_at', today())
            ->count();

        $pendingGatepasses = $staff->pendingGatepasses()
            ->with(['student', 'student.department', 'student.user'])
            ->latest()
            ->take(5)
            ->get();

        $recentApprovals = $staff->approvedGatepasses()
            ->with(['student', 'student.department'])
            ->latest('staff_approved_at')
            ->take(5)
            ->get();

        return view('staff.dashboard', compact(
            'totalRequests',
            'approvedToday',
            'rejectedToday',
            'pendingGatepasses',
            'recentApprovals'
        ));
    }

    public function pendingGatepasses()
    {
        $staff = Auth::user()->staff;
        $pendingGatepasses = $staff->pendingGatepasses()
            ->with(['student', 'student.department', 'student.user'])
            ->latest()
            ->paginate(10);

        return view('staff.gatepass.pending', compact('pendingGatepasses'));
    }

    public function approveGatepass(Request $request, Gatepass $gatepass)
    {
        if (!$gatepass->canBeApprovedByStaff()) {
            return back()->with('error', 'This gatepass cannot be approved at this stage.');
        }

        $request->validate([
            'action' => 'required|in:approve,reject',
            'remarks' => 'nullable|string|max:500'
        ]);

        $staff = Auth::user()->staff;

        if ($request->action === 'approve') {
            $gatepass->update([
                'status' => 'staff_approved',
                'staff_remarks' => $request->remarks,
                'staff_approved_at' => now(),
                'staff_approved_by' => Auth::id()
            ]);

            return back()->with('success', 'Gatepass approved successfully!');
        } else {
            $gatepass->update([
                'status' => 'staff_rejected',
                'staff_remarks' => $request->remarks,
                'staff_approved_at' => now(),
                'staff_approved_by' => Auth::id()
            ]);

            return back()->with('success', 'Gatepass rejected!');
        }
    }

    public function approvedGatepasses()
    {
        $staff = Auth::user()->staff;
        $approvedGatepasses = $staff->approvedGatepasses()
            ->with(['student', 'student.department'])
            ->latest('staff_approved_at')
            ->paginate(10);

        return view('staff.gatepass.approved', compact('approvedGatepasses'));
    }

    public function students()
    {
        $staff = Auth::user()->staff;
        $students = $staff->assignedStudents()
            ->with(['user', 'department'])
            ->paginate(10);

        return view('staff.students.index', compact('students'));
    }

    public function studentGatepasses(Student $student)
    {
        $staff = Auth::user()->staff;
        
        if ($student->department_id !== $staff->department_id) {
            abort(403);
        }

        $gatepasses = $student->gatepasses()
            ->with(['student.department'])
            ->latest()
            ->paginate(10);

        return view('staff.students.gatepasses', compact('student', 'gatepasses'));
    }

    public function profile()
    {
        $staff = Auth::user()->staff->load(['user', 'department']);
        return view('staff.profile', compact('staff'));
    }
}
