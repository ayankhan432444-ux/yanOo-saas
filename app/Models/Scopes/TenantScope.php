<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth; // <--- ADD THIS IMPORT

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Use Auth::check() instead of auth()->check()
        if (Auth::check()) {
            $user = Auth::user();

            // Safety check: ensure role exists before checking name
            if ($user->role && $user->role->name === 'super_admin') {
                return;
            }

            // Everyone else ONLY sees their company data
            if ($user->company_id) {
                $builder->where('company_id', $user->company_id);
            }
        }
    }
}