<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 3.1 Company Registration Logic
    public function register(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255', 
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'business_type' => 'required|string' 
        ]);

        return DB::transaction(function () use ($request) {
            // Create Company with Pending Status
            $company = Company::create([
                'name' => $request->company_name,
                'business_type' => $request->business_type,
                'status' => 'pending', 
                'trial_ends_at' => now()->addDays(7) // 7-Day Trial
            ]);

            // Create Admin User linked to Company
            $user = User::create([
                'company_id' => $company->id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => 2, // Company Admin
            ]);

            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'message' => 'Registration successful! 7-Day Trial Started.',
                'token' => $token,
                'trial_expires_at' => $company->trial_ends_at
            ], 201);
        });
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->with('role')->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        // ✅ FIX: SUPER ADMIN BYPASS (Line 73 Prevention)
        // Super Admin ki company nahi hoti, isliye usey foran allow karein
        $roleName = is_object($user->role) ? $user->role->name : $user->role;
        
        if ($roleName === 'super_admin') {
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json([
                'message' => 'Super Admin Login successful',
                'user' => $user,
                'token' => $token,
                'redirect' => '/super-admin'
            ]);
        }

        // ✅ REGULAR USER CHECK: Ensure Company exists
        $company = $user->company;
        if (!$company) {
            return response()->json(['message' => 'Account Error: No company node assigned.'], 403);
        }

        // --- RULE 3.2: Auto Expiry Check ---
        if ($company->status === 'pending' && now()->greaterThan($company->trial_ends_at)) {
            return response()->json([
                'message' => 'Your trial has expired. Please upgrade your plan to login.'
            ], 403); 
        }

        // --- RULE 3.3: Rejection Check ---
        if ($company->status === 'rejected') {
            return response()->json(['message' => 'Access Denied: Company Rejected.'], 403);
        }

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
            'redirect' => '/dashboard-view'
        ]);
    }
}