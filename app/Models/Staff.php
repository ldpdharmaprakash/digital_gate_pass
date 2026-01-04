<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'employee_id',
        'designation',
        'type',
        'qualifications',
        'joining_date',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'type' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function assignedStudents()
    {
        return $this->department->students();
    }

    public function pendingGatepasses()
    {
        return $this->assignedStudents()->gatepasses()->where('status', 'pending');
    }

    public function approvedGatepasses()
    {
        return Gatepass::where('staff_approved_by', $this->user_id);
    }
}
