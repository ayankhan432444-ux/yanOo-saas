<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use App\Models\Role; // Ensure this is imported!
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CompanyService
{
    public function registerCompany(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Create Company
            $company = Company::create([
                'name' => $data['company_name'],
                'business_type' => $data['business_type'],
                'status' => 'pending',
                'trial_ends_at' => Carbon::now()->addDays(7),
            ]);

            // 2. Get Role ID (Fix: Ensure RoleSeeder was run)
            $role = Role::where('name', 'company_admin')->firstOrFail();

            // 3. Create User
            $user = User::create([
                'name' => $data['admin_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'company_id' => $company->id,
                'role_id' => $role->id,
            ]);

            return ['company' => $company, 'user' => $user];
        });
    }
}