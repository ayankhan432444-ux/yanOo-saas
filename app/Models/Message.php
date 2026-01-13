<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    // Mass assignment ke liye fields
    protected $fillable = ['company_id', 'user_id', 'message', 'is_read'];

    /**
     * Relationship: Aik message aik user ka hota hai
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}