<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
{
    // Rule: Who can manage the whole platform? (Super Admin only)
    Gate::define('manage_platform', function (User $user) {
        return $user->role->name === 'super_admin';
    });

    // Rule: Who can manage company settings? (Super Admin & Company Admin)
    Gate::define('manage_company', function (User $user) {
        return in_array($user->role->name, ['super_admin', 'company_admin']);
    });

    // Rule: Who can upload files? (Everyone EXCEPT Normal User)
    Gate::define('upload_files', function (User $user) {
        return in_array($user->role->name, ['super_admin', 'company_admin', 'support_user']);
    });
    }
}
