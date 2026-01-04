<?php

namespace App\Http\Controllers;

use App\Models\Gatepass;
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
        $student = Auth::user()->student;
        
        $totalGatepasses = $student->gatepasses()->count();
        $pendingGatepasses = $student->pendingGatepasses()->count();
        $approvedGatepasses = $student->approvedGatepasses()->count();
        $rejectedGatepasses = $student->rejectedGatepasses()->count();

        $recentGatepasses = $student->gatepasses()
            ->with(['student', 'student.department'])
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
            ->where('gatepass_date', $request->gatepass_date)
            ->whereIn('status', ['pending', 'staff_approved', 'hod_approved', 'final_approved'])
            ->first();

        if ($existingGatepass) {
            return back()->with('error', 'You already have an active gatepass for this date.');
        }

        Gatepass::create([
            'student_id' => $student->id,
            'gatepass_date' => $request->gatepass_date,
            'out_time' => $request->gatepass_date . ' ' . $request->out_time,
            'in_time' => $request->gatepass_date . ' ' . $request->in_time,
            'reason' => $request->reason,
            'status' => 'pending'
        ]);

        return redirect()->route('student.gatepasses.index')
            ->with('success', 'Gatepass request submitted successfully!');
    }

    public function indexGatepasses()
    {
        $student = Auth::user()->student;
        $gatepasses = $student->gatepasses()
            ->with(['student.department'])
            ->latest()
            ->paginate(10);

        return view('student.gatepass.index', compact('gatepasses'));
    }

    public function showGatepass(Gatepass $gatepass)
    {
        if ($gatepass->student_id !== Auth::user()->student->id) {
            abort(403);
        }

        return view('student.gatepass.show', compact('gatepass'));
    }

    public function downloadGatepass(Gatepass $gatepass)
    {
        if ($gatepass->student_id !== Auth::user()->student->id || !$gatepass->isFinalApproved()) {
            abort(403);
        }

        return $this->generatePDF($gatepass);
    }

    private function generatePDF(Gatepass $gatepass)
    {
        $student = $gatepass->student;
        $qrCode = $this->generateQRCode($gatepass);

        $data = [
            'gatepass' => $gatepass,
            'student' => $student,
            'qrCode' => $qrCode
        ];

        $pdf = \PDF::loadView('pdf.gatepass', $data);
        
        return $pdf->download("gatepass_{$gatepass->id}.pdf");
    }

    private function generateQRCode(Gatepass $gatepass)
    {
        $data = "Gatepass ID: {$gatepass->id}\n";
        $data .= "Student: {$gatepass->student->user->name}\n";
        $data .= "Register No: {$gatepass->student->register_number}\n";
        $data .= "Date: {$gatepass->gatepass_date}\n";
        $data .= "Out Time: {$gatepass->out_time->format('H:i')}\n";
        $data .= "In Time: {$gatepass->in_time->format('H:i')}\n";
        $data .= "Status: {$gatepass->status}";

        $qrCode = new \BaconQrCode\Writer(
            new \BaconQrCode\Renderer\ImageRenderer(
                new \BaconQrCode\Renderer\RendererStyle\RendererStyle(200),
                new \BaconQrCode\Renderer\Image\SvgImageBackEnd()
            )
        );

        return base64_encode($qrCode->writeString($data));
    }
}
