<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Controller Imports
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\MessageController; 
use App\Http\Controllers\Admin\CompanyController; 
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AuditLogController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/invite/accept/{token}', [InvitationController::class, 'accept']);

/*
|--------------------------------------------------------------------------
| Protected Routes (Sanctum Authenticated)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum'])->group(function () {

    // --- SHARED USER DATA ---
    Route::get('/user', function (Request $request) {
        return $request->user()->load('company', 'role');
    });

    /*
    |----------------------------------------------------------------------
    | TENANT ROUTES (Multi-tenancy Enforced)
    |----------------------------------------------------------------------
    */
    Route::middleware(['tenancy'])->group(function () {
        
        // Dashboard
        Route::get('/dashboard', function () {
            return response()->json(['message' => 'Connection established with Tenant Node.']);
        });

        // Team Management
        Route::get('/team', function (Request $request) {
            return $request->user()->company->users()->with('role')->get();
        });

        // ✅ FIX: Route renamed to match frontend fetch URL
        // Frontend is looking for /api/team/invite
        Route::post('/team/invite', [InvitationController::class, 'store']); 

        // File Storage
        Route::post('/files/upload', [FileController::class, 'upload']);
        Route::get('/files', [FileController::class, 'index']);           
        Route::delete('/files/{id}', [FileController::class, 'destroy']); 
        
        // Audit Logs
        Route::get('/audit-logs', [AuditLogController::class, 'index']);

        // Support Messaging
        Route::get('/messages', [MessageController::class, 'index']); 
        Route::post('/messages', [MessageController::class, 'store']); 

        // Subscription & Billing
        Route::get('/plans', [SubscriptionController::class, 'index']); 
        Route::post('/subscribe', [SubscriptionController::class, 'subscribe']); 
        Route::post('/subscription/change', [SubscriptionController::class, 'changePlan']); 
        Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel']); 
        Route::get('/invoices', [SubscriptionController::class, 'invoices']); 
    });

    /*
    |----------------------------------------------------------------------
    | SUPER ADMIN ROUTES
    |----------------------------------------------------------------------
    */
    Route::prefix('admin')->group(function () {
        Route::get('/companies', [CompanyController::class, 'index']);
        // Approved/Rejected Status Updates
        Route::post('/companies/{id}/status', [CompanyController::class, 'updateStatus']);
    });
});