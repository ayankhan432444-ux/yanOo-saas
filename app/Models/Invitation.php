<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'email',
        'role_name',
        'token',
        'status',
        'expires_at' // ✅ Ye lazmi add karein taake link expire ho sakay
    ];

    // Optional: Dates ko carbon instances mein convert karne ke liye
    protected $casts = [
        'expires_at' => 'datetime',
    ];
}