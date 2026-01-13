<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable; // <--- 1. IMPORT THIS (For Stripe)
use App\Models\Company; 
use App\Models\Role;    

class User extends Authenticatable
{
    // 2. ADD 'Billable' HERE 👇
    use HasApiTokens, HasFactory, Notifiable, Billable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'role_id',
    ];

    // Relationship: A user belongs to ONE company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Relationship: A user has ONE role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Helper to check role name safely
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }
}