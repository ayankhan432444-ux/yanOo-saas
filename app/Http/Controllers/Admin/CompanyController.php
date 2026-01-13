<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\AuditLog; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB; // Transaction handling ke liye
use Carbon\Carbon;

class CompanyController extends Controller {
    
    /**
     * View all companies (Requirement 2.1)
     * Base for Super Admin Dashboard
     */
    public function index()
    {
        Gate::authorize('manage_platform'); //

        // Eager loading users taake frontend par admin email display ho sake
        $companies = Company::with(['users' => function($query) {
            $query->limit(1); 
        }])->latest()->get();

        return response()->json([
            'status' => 'success',
            'data' => $companies
        ]);
    }

    /**
     * Approve or Reject (Requirement 3.3)
     * Handles status change & audit logging
     */
    public function updateStatus(Request $request, $id)
    {
        Gate::authorize('manage_platform'); 

        $request->validate([
            'status' => 'required|in:pending,approved,rejected,suspended'
        ]);

        try {
            // DB Transaction taake status update aur audit log dono save hon ya dono fail hon
            return DB::transaction(function() use ($request, $id) {
                $company = Company::findOrFail($id);
                $oldStatus = $company->status;
                
                // Update company status
                $company->status = $request->status;

                // Requirement 3.3: Approval removes trial limitations / unlocks features
                if ($request->status === 'approved' && $oldStatus !== 'approved') {
                    // Start full trial period upon approval
                    $company->trial_ends_at = Carbon::now()->addDays(7);
                }

                $company->save();

                // Requirement 8: Create Audit Log entry
                AuditLog::create([
                    'event' => "company_{$request->status}",
                    'user_name' => auth()->user()->name, 
                    'description' => "Company '{$company->name}' status changed from '{$oldStatus}' to '{$request->status}' by Super Admin.",
                    'company_id' => $company->id 
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => "Node protocol updated: Company is now {$request->status}",
                    'company' => $company
                ]);
            });

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }
}