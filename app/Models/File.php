<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',  
        'filename',
        'path'
    ];
    
    // Optional: Agar aap chahte hain ke File se User ka data mile
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}