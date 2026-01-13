<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EnforceTenancy
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // 1. SUPER ADMIN BYPASS
        $role = $user->role;
        $roleName = is_object($role) ? $role->name : $role;

        if ($roleName === 'super_admin') {
            return $next($request);
        }

        // 2. REGULAR USERS: Check Company
        if (!$user->company) {
            return response()->json(['error' => 'No valid company assigned.'], 403);
        }

        $company = $user->company;

        // 3. Status Check (Adding 'approved' for your DB sync)
        if ($company->status === 'rejected') {
            return response()->json(['error' => 'Access Denied: Rejected.'], 403);
        }

        // ✅ FIX: 'subscribed()' method hata diya taake crash na ho
        // Aapke DB mein status 'approved' hai, isliye isay yahan add kiya hai
        if ($company->status === 'active' || $company->status === 'approved') {
            return $next($request);
        }

        // 4. Trial Logic
        if (!$company->trial_ends_at || Carbon::now()->greaterThan($company->trial_ends_at)) {
            return response()->json([
                'error' => 'Trial Expired.',
                'redirect_to' => '/billing-view' 
            ], 402);
        }

        return $next($request);
    }
}