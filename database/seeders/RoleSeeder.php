<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() {
    \App\Models\Role::insert([
        ['name' => 'super_admin', 'label' => 'Super Admin'],
        ['name' => 'company_admin', 'label' => 'Company Admin'], // [cite: 13]
        ['name' => 'support_user', 'label' => 'Support User'],
        ['name' => 'normal_user', 'label' => 'Normal User'],
    ]);
}
}
