<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CompanyService;

class RegisterController extends Controller {
    protected $service;

    public function __construct(CompanyService $service) {
        $this->service = $service;
    
    }public function register(Request $request)
    {
        // ... (Validation logic here) ...

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // 1. Create Company
            $company = \App\Models\Company::create([
                'name' => $request->company_name,
                'status' => 'pending', 
                'trial_ends_at' => now()->addDays(7)
            ]);

            // 2. Create User
            $role = \App\Models\Role::where('name', 'company_admin')->first();
            $user = \App\Models\User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'company_id' => $company->id,
                'role_id' => $role ? $role->id : 2
            ]);

            \Illuminate\Support\Facades\DB::commit();

            // 👇 THIS IS THE MISSING PART 👇
            $token = $user->createToken('API Token')->plainTextToken;

            return response()->json([
                'message' => 'Registration successful. 7-Day Trial Started.',
                'token' => $token, // <--- Add this line!
                'data' => [
                    'company' => $company,
                    'user' => $user
                ]
            ]);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json(['message' => 'Registration failed: ' . $e->getMessage()], 500);
        }
    }
}