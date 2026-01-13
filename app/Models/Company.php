<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'business_type',
        'status',          // 'pending', 'active', 'rejected'
        'trial_ends_at',
        'file_limit',      // New: Default 10, Pro 100
        'plan_name'        // New: 'Basic' ya 'Pro'
    ];

    protected $casts = [
        'trial_ends_at' => 'datetime',
    ];

    // Relationship: A company has many users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // New Relationship: A company has many files
    public function files()
    {
        return $this->hasMany(File::class);
    }

    /**
     * Helper: Check karein ke storage kitni use ho chuki hai
     */
    public function getStorageUsageAttribute()
    {
        $count = $this->files()->count();
        return [
            'used' => $count,
            'total' => $this->file_limit ?? 10, // Agar null ho to default 10
            'percentage' => ($count / ($this->file_limit ?: 10)) * 100
        ];
    }
}