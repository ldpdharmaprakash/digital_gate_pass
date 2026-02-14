<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class College extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'primary_color',
        'secondary_color',
        'address',
        'phone',
        'email',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function gatepasses()
    {
        return $this->hasMany(Gatepass::class);
    }

    public function students()
    {
        return $this->hasManyThrough(Student::class, User::class);
    }

    public function staff()
    {
        return $this->hasManyThrough(Staff::class, User::class);
    }

    public function hods()
    {
        return $this->hasManyThrough(Hod::class, User::class);
    }

    public function wardens()
    {
        return $this->hasManyThrough(Warden::class, User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
