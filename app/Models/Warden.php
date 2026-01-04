<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warden extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'employee_id',
        'hostel_type',
        'qualifications',
        'appointment_date',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'hostel_type' => 'string',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pendingGatepasses()
    {
        return Gatepass::where('status', 'hod_approved')
            ->whereHas('student', function ($query) {
                $query->where('hosteller', 'yes');
            });
    }

    public function approvedGatepasses()
    {
        return Gatepass::where('warden_approved_by', $this->user_id);
    }

    public function hostellerGatepasses()
    {
        return Gatepass::whereHas('student', function ($query) {
            $query->where('hosteller', 'yes');
        });
    }
}
