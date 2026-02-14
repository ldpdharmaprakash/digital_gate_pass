<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'head_name',
        'is_active',
        'college_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }

    public function hods()
    {
        return $this->hasMany(Hod::class);
    }

    public function gatepasses()
    {
        return $this->hasManyThrough(Gatepass::class, Student::class);
    }
}
