<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'gatepass_id',
        'student_id',
        'verified_by',
        'action',
        'exit_time',
        'entry_time',
        'notes',
        'ip_address',
        'location',
    ];

    protected $casts = [
        'exit_time' => 'datetime',
        'entry_time' => 'datetime',
    ];

    /**
     * Get the gatepass that owns this security log.
     */
    public function gatepass(): BelongsTo
    {
        return $this->belongsTo(Gatepass::class);
    }

    /**
     * Get the student that owns this security log.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the security user who verified this log.
     */
    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check if student has exited without entry
     */
    public static function hasPendingExit(int $studentId): bool
    {
        return static::where('student_id', $studentId)
            ->where('action', 'exit')
            ->whereNull('entry_time')
            ->exists();
    }

    /**
     * Get last exit log for student
     */
    public static function getLastExit(int $studentId): ?self
    {
        return static::where('student_id', $studentId)
            ->where('action', 'exit')
            ->whereNull('entry_time')
            ->latest()
            ->first();
    }
}
