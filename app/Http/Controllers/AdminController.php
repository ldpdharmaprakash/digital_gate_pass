<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Hod;
use App\Models\Warden;
use App\Models\Gatepass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'students' => User::where('role', 'student')->count(),
            'staff' => User::where('role', 'staff')->count(),
            'hods' => User::where('role', 'hod')->count(),
            'wardens' => User::where('role', 'warden')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'departments' => Department::count(),
            'total_gatepasses' => Gatepass::count(),
            'pending_gatepasses' => Gatepass::pending()->count(),
            'approved_gatepasses' => Gatepass::finalApproved()->count(),
            'rejected_gatepasses' => Gatepass::rejected()->count(),
        ];

        $recentGatepasses = Gatepass::with(['student.user', 'student.department'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentGatepasses'));
    }

    public function users()
    {
        $users = User::with(['student.department', 'student.user', 'staff.department', 'staff.user', 'hod.department', 'hod.user', 'warden.user'])
            ->latest()
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        $departments = Department::where('is_active', true)->get();
        return view('admin.users.create', compact('departments'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:student,staff,hod,warden,admin',
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required_if:role,student,staff,hod|exists:departments,id',
            'register_number' => 'required_if:role,student|string|max:50|unique:students',
            'semester' => 'required_if:role,student|string|max:20',
            'hosteller' => 'required_if:role,student|in:yes,no',
            'parent_name' => 'required_if:role,student|string|max:255',
            'parent_phone' => 'required_if:role,student|string|max:20',
            'employee_id' => 'required_if:role,staff,hod,warden|string|max:50|unique:staff|unique:hods|unique:wardens',
            'designation' => 'required_if:role,staff,hod|string|max:255',
            'hostel_type' => 'required_if:role,warden|in:boys,girls,mixed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
        ]);

        if ($request->role === 'student') {
            Student::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id,
                'register_number' => $request->register_number,
                'semester' => $request->semester,
                'hosteller' => $request->hosteller,
                'parent_name' => $request->parent_name,
                'parent_phone' => $request->parent_phone,
            ]);
        } elseif ($request->role === 'staff') {
            Staff::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id,
                'employee_id' => $request->employee_id,
                'designation' => $request->designation,
                'joining_date' => now(),
            ]);
        } elseif ($request->role === 'hod') {
            Hod::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id,
                'employee_id' => $request->employee_id,
                'appointment_date' => now(),
            ]);
        } elseif ($request->role === 'warden') {
            Warden::create([
                'user_id' => $user->id,
                'employee_id' => $request->employee_id,
                'hostel_type' => $request->hostel_type,
                'appointment_date' => now(),
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    public function departments()
    {
        $departments = Department::withCount(['students', 'staff', 'hods'])
            ->latest()
            ->paginate(10);

        return view('admin.departments.index', compact('departments'));
    }

    public function createDepartment()
    {
        return view('admin.departments.create');
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments',
            'description' => 'nullable|string',
            'head_name' => 'nullable|string|max:255',
        ]);

        Department::create($request->all());

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department created successfully!');
    }

    public function reports()
    {
        $monthlyStats = Gatepass::selectRaw('MONTH(gatepass_date) as month, COUNT(*) as count')
            ->whereYear('gatepass_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $departmentStats = Department::withCount(['gatepasses'])
            ->get();

        $roleStats = [
            'students' => User::where('role', 'student')->count(),
            'staff' => User::where('role', 'staff')->count(),
            'hods' => User::where('role', 'hod')->count(),
            'wardens' => User::where('role', 'warden')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];

        return view('admin.reports', compact('monthlyStats', 'departmentStats', 'roleStats'));
    }

    public function downloadReport()
    {
        $gatepasses = Gatepass::with(['student.user', 'student.department'])
            ->latest()
            ->get();

        $pdf = PDF::loadView('admin.reports_pdf', compact('gatepasses'));
        return $pdf->download('system-gatepass-report.pdf');
    }

    public function exportGatepasses(Request $request)
    {
        $request->validate([
            'format' => 'required|in:pdf,excel',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'nullable|in:pending,staff_approved,hod_approved,final_approved,rejected',
        ]);

        $gatepasses = Gatepass::with(['student', 'student.department'])
            ->when($request->date_from, function ($query) use ($request) {
                return $query->whereDate('gatepass_date', '>=', $request->date_from);
            })
            ->when($request->date_to, function ($query) use ($request) {
                return $query->whereDate('gatepass_date', '<=', $request->date_to);
            })
            ->when($request->department_id, function ($query) use ($request) {
                return $query->whereHas('student', function ($q) use ($request) {
                    $q->where('department_id', $request->department_id);
                });
            })
            ->when($request->status, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->latest()
            ->get();

        if ($request->format === 'pdf') {
            return $this->exportPDF($gatepasses);
        } else {
            return $this->exportExcel($gatepasses);
        }
    }

    private function exportPDF($gatepasses)
    {
        $data = ['gatepasses' => $gatepasses];
        $pdf = \PDF::loadView('admin.exports.gatepasses-pdf', $data);
        
        return $pdf->download('gatepasses-report.pdf');
    }

    private function exportExcel($gatepasses)
    {
        // Simple CSV export for now
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=gatepasses-report.csv',
        ];

        $callback = function () use ($gatepasses) {
            $file = fopen('php://output', 'w');
            
            fputcsv($file, ['ID', 'Student', 'Register No', 'Department', 'Date', 'Out Time', 'In Time', 'Status']);
            
            foreach ($gatepasses as $gatepass) {
                fputcsv($file, [
                    $gatepass->id,
                    $gatepass->student->user->name,
                    $gatepass->student->register_number,
                    $gatepass->student->department->name,
                    $gatepass->gatepass_date,
                    $gatepass->out_time->format('H:i'),
                    $gatepass->in_time->format('H:i'),
                    $gatepass->status
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function profile()
    {
        $admin = Auth::user();
        return view('admin.profile', compact('admin'));
    }
}
