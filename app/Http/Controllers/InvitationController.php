<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invitation;
use App\Models\AuditLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;

class InvitationController extends Controller
{
    public function store(Request $request)
    {
        // 1. Authorization Check
        Gate::authorize('manage_company'); 

        $request->validate([
            'email' => 'required|email|unique:users,email',
            'role' => 'in:company_admin,support_user,normal_user'
        ]);

        $user = $request->user();
        
        // 🛑 CRITICAL FIX: Ensure user has a company
        // Agar company null hogi (jaise Super Admin ki hoti hai), toh ye block crash hone se bachayega.
        if (!$user->company_id) {
            return response()->json([
                'message' => 'Transmission Refused: No company node linked to this account.'
            ], 403);
        }

        $company = $user->company;

        // 2. Multi-tenant Quota Check (Section 3.2)
        // Trial companies (Pending/Approved) are limited to 2 total members
        if ($company->status === 'pending' || $company->status === 'approved') { 
            $currentTeam = \App\Models\User::where('company_id', $company->id)->count();
            $pendingInvites = Invitation::where('company_id', $company->id)
                                        ->where('status', 'pending')->count();
            
            if (($currentTeam + $pendingInvites) >= 2) {
                return response()->json([
                    'message' => 'Trial Limit Reached! Upgrade for more node seats.'
                ], 403);
            }
        }

        // 3. Database Transaction for Data Integrity
        return DB::transaction(function () use ($request, $user, $company) {
            
            // Create the Invitation
            $invitation = Invitation::create([
                'company_id' => $company->id,
                'email' => $request->email,
                'role_name' => $request->role ?? 'normal_user',
                'token' => Str::random(32),
                'status' => 'pending',
                'expires_at' => now()->addHours(24)
            ]);

            // ✅ FIX: Use 'description' column (Verified via Tinker)
            AuditLog::create([
                'company_id' => $company->id,
                'user_id' => $user->id,
                'event' => 'user_invited', 
                'description' => 'Node invite transmitted to: ' . $request->email 
            ]);

            return response()->json([
                'message' => 'Invitation Successfully Transmitted!',
                'invitation_link' => url('/invite/accept/' . $invitation->token)
            ]);
        });
    }
}