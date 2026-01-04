<?php

namespace App\Services;

use App\Models\Gatepass;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use PDF;

class GatepassNotificationService
{
    /**
     * Send notification to staff and HOD when a new gatepass is created
     */
    public function notifyNewGatepass(Gatepass $gatepass)
    {
        $student = $gatepass->student;
        $department = $student->department;
        
        // Get staff members for the department
        $staffMembers = User::whereHas('staff', function($query) use ($department) {
            $query->where('department_id', $department->id);
        })->get();
        
        // Get HOD for the department
        $hod = User::whereHas('hod', function($query) use ($department) {
            $query->where('department_id', $department->id);
        })->first();
        
        // Send email to staff members
        foreach ($staffMembers as $staff) {
            Mail::to($staff->email)->send(new \App\Mail\NewGatepassRequest($gatepass, $staff));
        }
        
        // Send email to HOD
        if ($hod) {
            Mail::to($hod->email)->send(new \App\Mail\NewGatepassRequest($gatepass, $hod));
        }
    }
    
    /**
     * Send notification to student when gatepass is approved
     */
    public function notifyGatepassApproved(Gatepass $gatepass, $approvedBy, $approvalType)
    {
        $student = $gatepass->student->user;
        
        // Generate PDF
        $pdf = $this->generateGatepassPDF($gatepass);
        
        // Send email with PDF attachment
        Mail::to($student->email)->send(new \App\Mail\GatepassApproved($gatepass, $approvedBy, $approvalType, $pdf));
    }
    
    /**
     * Send notification to student when gatepass is rejected
     */
    public function notifyGatepassRejected(Gatepass $gatepass, $rejectedBy, $rejectionType)
    {
        $student = $gatepass->student->user;
        
        Mail::to($student->email)->send(new \App\Mail\GatepassRejected($gatepass, $rejectedBy, $rejectionType));
    }
    
    /**
     * Generate PDF for gatepass
     */
    private function generateGatepassPDF(Gatepass $gatepass)
    {
        // Load all relationships needed for the PDF
        $gatepass->load([
            'student.user',
            'student.department',
            'staffApprovedBy',
            'hodApprovedBy',
            'wardenApprovedBy'
        ]);

        $pdf = PDF::loadView('student.gatepass.pdf', compact('gatepass'));
        
        return $pdf;
    }
}
