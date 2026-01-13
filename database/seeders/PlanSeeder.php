<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    \App\Models\Plan::insert([
        [
            'name' => 'Basic Plan',
            'slug' => 'basic-monthly',
            'price' => 10.00,
            'duration' => 'monthly',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Pro Plan',
            'slug' => 'pro-monthly',
            'price' => 30.00,
            'duration' => 'monthly',
            'created_at' => now(),
            'updated_at' => now(),
        ],
        [
            'name' => 'Enterprise Plan',
            'slug' => 'enterprise-yearly',
            'price' => 300.00,
            'duration' => 'yearly',
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ]);
}
}
