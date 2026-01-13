<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Run the RoleSeeder FIRST (so roles exist)
        $this->call(RoleSeeder::class);

        // 2. Create a Super Admin User (Optional, but useful)
        // We fetch the ID safely instead of guessing '1'
        $role = \App\Models\Role::where('name', 'super_admin')->first();

        \App\Models\User::create([
            'name' => 'Super Admin',
            'email' => 'admin@saas.com',
            'password' => bcrypt('password123'),
            'role_id' => $role->id,
        ]);
        
        // Note: We removed the default User::factory() call that was causing the error
    }
}