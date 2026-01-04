<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
        'register_number',
        'semester',
        'section',
        'hosteller',
        'parent_name',
        'parent_phone',
        'address',
    ];

    protected $casts = [
        'hosteller' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function gatepasses()
    {
        return $this->hasMany(Gatepass::class);
    }

    public function pendingGatepasses()
    {
        return $this->gatepasses()->where('status', 'pending');
    }

    public function approvedGatepasses()
    {
        return $this->gatepasses()->whereIn('status', ['final_approved']);
    }

    public function rejectedGatepasses()
    {
        return $this->gatepasses()->whereIn('status', ['staff_rejected', 'hod_rejected', 'warden_rejected', 'final_rejected']);
    }
}
