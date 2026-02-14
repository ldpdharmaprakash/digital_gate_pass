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
}
