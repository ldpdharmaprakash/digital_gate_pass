<?php

namespace App\Http\Controllers;

use App\Models\Gatepass;
use Illuminate\Http\Request;

class QRVerificationController extends Controller
{
    /**
     * Show QR verification page for gatepass
     */
    public function verify($id)
    {
        $gatepass = Gatepass::with(['student.user', 'student.department', 'college'])
            ->findOrFail($id);
            
        return view('qr.verify', compact('gatepass'));
    }
    
    /**
     * API endpoint for QR verification
     */
    public function verifyApi(Request $request)
    {
        $gatepassId = $request->input('gatepass_id');
        
        if (!$gatepassId) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gatepass ID required'
            ], 400);
        }
        
        $gatepass = Gatepass::with(['student.user', 'student.department', 'college'])
            ->find($gatepassId);
            
        if (!$gatepass) {
            return response()->json([
                'status' => 'invalid',
                'message' => 'Gatepass not found'
            ]);
        }
        
        return response()->json([
            'status' => 'valid',
            'message' => 'Gatepass verified successfully',
            'data' => [
                'gatepass_id' => $gatepass->id,
                'student_name' => $gatepass->student->user->name,
                'register_number' => $gatepass->student->register_number,
                'department' => $gatepass->student->department->name,
                'gatepass_date' => $gatepass->gatepass_date->format('M d, Y'),
                'out_time' => $gatepass->out_time->format('h:i A'),
                'in_time' => $gatepass->in_time->format('h:i A'),
                'status' => $gatepass->status,
                'is_final_approved' => $gatepass->isFinalApproved(),
                'college' => $gatepass->college->college_name,
                'reason' => $gatepass->reason
            ]
        ]);
    }
}
