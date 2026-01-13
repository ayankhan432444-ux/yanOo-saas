<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'event',
        'description',
        'ip_address'
    ];

    // Optional: Link to User so we can show names in the log
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}