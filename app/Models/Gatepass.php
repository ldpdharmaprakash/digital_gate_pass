<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gatepass extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'college_id',
        'gatepass_date',
        'out_time',
        'in_time',
        'reason',
        'status',
        'staff_remarks',
        'hod_remarks',
        'warden_remarks',
        'staff_approved_at',
        'hod_approved_at',
        'warden_approved_at',
        'final_approved_at',
        'staff_approved_by',
        'hod_approved_by',
        'warden_approved_by',
        'staff_rejected_by',
        'hod_rejected_by',
        'warden_rejected_by',
        'staff_rejected_at',
        'hod_rejected_at',
        'warden_rejected_at',
        'qr_code',
        'is_active',
    ];

    protected $casts = [
        'gatepass_date' => 'date',
        'out_time' => 'datetime',
        'in_time' => 'datetime',
        'staff_approved_at' => 'datetime',
        'hod_approved_at' => 'datetime',
        'warden_approved_at' => 'datetime',
        'final_approved_at' => 'datetime',
        'staff_rejected_at' => 'datetime',
        'hod_rejected_at' => 'datetime',
        'warden_rejected_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function staffApprovedBy()
    {
        return $this->belongsTo(User::class, 'staff_approved_by');
    }

    public function hodApprovedBy()
    {
        return $this->belongsTo(User::class, 'hod_approved_by');
    }

    public function wardenApprovedBy()
    {
        return $this->belongsTo(User::class, 'warden_approved_by');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isStaffApproved()
    {
        return $this->status === 'staff_approved';
    }

    public function isHodApproved()
    {
        return $this->status === 'hod_approved';
    }

    public function isFinalApproved()
    {
        return $this->status === 'final_approved';
    }

    public function isRejected()
    {
        return in_array($this->status, ['staff_rejected', 'hod_rejected', 'warden_rejected', 'final_rejected']);
    }

    public function canBeApprovedByStaff()
    {
        return $this->status === 'pending';
    }

    public function canBeApprovedByHod()
    {
        return $this->status === 'staff_approved';
    }

    public function canBeApprovedByWarden()
    {
        return $this->status === 'hod_approved' && $this->student->hosteller === 'yes';
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeStaffApproved($query)
    {
        return $query->where('status', 'staff_approved');
    }

    public function scopeHodApproved($query)
    {
        return $query->where('status', 'hod_approved');
    }

    public function scopeFinalApproved($query)
    {
        return $query->where('status', 'final_approved');
    }

    public function scopeRejected($query)
    {
        return $query->whereIn('status', ['staff_rejected', 'hod_rejected', 'warden_rejected', 'final_rejected']);
    }

    /**
     * Check if gatepass is expired (in_time has passed)
     */
    public function isExpired()
    {
        return now()->isAfter($this->in_time);
    }

    /**
     * Check if gatepass is currently active (not expired and approved)
     */
    public function isActive()
    {
        return $this->isFinalApproved() && !$this->isExpired();
    }

    /**
     * Check if user can change their decision (re-approve rejected or reject approved)
     */
    public function canUserChangeDecision(User $user)
    {
        $userRole = $user->role;
        $currentStatus = $this->status;

        return match($userRole) {
            'staff' => in_array($currentStatus, ['staff_rejected', 'staff_approved']),
            'hod' => in_array($currentStatus, ['hod_rejected', 'hod_approved', 'staff_approved']),
            'warden' => in_array($currentStatus, ['warden_rejected', 'warden_approved', 'hod_approved']),
            'admin' => true, // Admin can change any decision
            default => false
        };
    }

    /**
     * Get the next approval step based on current status
     */
    public function getNextApprovalStep()
    {
        return match($this->status) {
            'pending' => 'staff',
            'staff_approved' => 'hod',
            'hod_approved' => 'warden',
            'staff_rejected' => 'staff', // Can be re-approved by staff
            'hod_rejected' => 'staff', // Can be re-started from staff
            'warden_rejected' => 'staff', // Can be re-started from staff
            default => null
        };
    }

    /**
     * Reset gatepass to previous state for re-approval
     */
    public function resetForReApproval(User $user)
    {
        $userRole = $user->role;
        
        match($userRole) {
            'staff' => [
                'status' => 'pending',
                'staff_approved_by' => null,
                'staff_approved_at' => null,
                'staff_remarks' => null,
                'staff_rejected_by' => null,
                'staff_rejected_at' => null,
            ],
            'hod' => [
                'status' => 'staff_approved',
                'hod_approved_by' => null,
                'hod_approved_at' => null,
                'hod_remarks' => null,
                'hod_rejected_by' => null,
                'hod_rejected_at' => null,
            ],
            'warden' => [
                'status' => 'hod_approved',
                'warden_approved_by' => null,
                'warden_approved_at' => null,
                'warden_remarks' => null,
                'warden_rejected_by' => null,
                'warden_rejected_at' => null,
            ],
            default => null
        };
        
        $this->save();
    }

    /**
     * Auto-expire gatepasses that have passed their in_time
     */
    public static function expireExpiredGatepasses()
    {
        $expired = self::where('status', 'final_approved')
                      ->where('in_time', '<', now())
                      ->get();

        foreach ($expired as $gatepass) {
            $gatepass->update([
                'status' => 'expired',
                'is_active' => false
            ]);
            
            // Send notification to student about expiration
            \Mail::to($gatepass->student->user->email)->send(
                new \App\Mail\GatepassExpiredMail($gatepass)
            );
        }

        return $expired->count();
    }
}
