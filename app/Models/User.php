<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'phone',
        'is_active',
        'college_id',
        'gender',
        'institute_id',
        'qr_token',
        'qr_token_generated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'qr_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'qr_token_generated_at' => 'datetime',
    ];

    public function college()
    {
        return $this->belongsTo(College::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function hod()
    {
        return $this->hasOne(Hod::class);
    }

    public function warden()
    {
        return $this->hasOne(Warden::class);
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }

    public function isHod()
    {
        return $this->role === 'hod';
    }

    public function isWarden()
    {
        return $this->role === 'warden';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function gatepassesApprovedByStaff()
    {
        return $this->hasMany(Gatepass::class, 'staff_approved_by');
    }

    public function gatepassesApprovedByHod()
    {
        return $this->hasMany(Gatepass::class, 'hod_approved_by');
    }

    public function gatepassesApprovedByWarden()
    {
        return $this->hasMany(Gatepass::class, 'warden_approved_by');
    }

    /**
     * Generate QR token for user
     */
    public function generateQRToken()
    {
        $this->qr_token = (string) \Illuminate\Support\Str::uuid();
        $this->qr_token_generated_at = now();
        $this->save();
        
        return $this->qr_token;
    }

    /**
     * Get QR login URL for user
     */
    public function getQRLoginUrl()
    {
        if (!$this->qr_token) {
            $this->generateQRToken();
        }
        
        return url('/auth/qr/' . $this->qr_token);
    }

    /**
     * Get QR token or generate if missing
     */
    public function getQRToken()
    {
        if (!$this->qr_token) {
            $this->generateQRToken();
        }
        
        return $this->qr_token;
    }

    /**
     * Boot method to auto-generate QR token on user creation
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if (!$user->qr_token) {
                $user->generateQRToken();
            }
        });
    }
}
