<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hod extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'employee_id',
        'qualifications',
        'appointment_date',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function departmentGatepasses()
    {
        return $this->department->gatepasses();
    }

    public function pendingGatepasses()
    {
        return $this->departmentGatepasses()->where('status', 'staff_approved');
    }

    public function approvedGatepasses()
    {
        return Gatepass::where('hod_approved_by', $this->user_id);
    }
}
