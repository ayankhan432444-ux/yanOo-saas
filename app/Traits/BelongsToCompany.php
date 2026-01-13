<?php

namespace App\Traits;

use App\Models\Company;
use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth; // <--- CRITICAL IMPORT

trait BelongsToCompany
{
    protected static function bootBelongsToCompany()
    {
        static::addGlobalScope(new TenantScope);

        // Auto-assign company_id on creation
        static::creating(function ($model) {
            // FIX: Use Auth::check() instead of auth()->check()
            if (Auth::check()) {
                $user = Auth::user(); // FIX: Use Auth::user()
                
                // Check if user has a company_id safely
                if ($user->company_id) {
                    $model->company_id = $user->company_id;
                }
            }
        });
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}