<?php

use Illuminate\Support\Facades\Route;

// 1. Login Page (Public)
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/register-view', function () {
    return view('register');
});
// 2. Trial Status Page (Public - JS checks token)
Route::get('/trial-status', function () {
    return view('trial-status');
});

// 3. Dashboard Page (Public - JS checks token)
Route::get('/dashboard-view', function () {
    return view('dashboard');
});
Route::get('/billing-view', function () {
    return view('billing');
});
Route::get('/team-view', function () {
    return view('team');
});
Route::get('/files-view', function () {
    return view('files');
});
// Support Messaging Page
Route::get('/support-view', function () {
    return view('support');
});
Route::get('/plans-view', function () {
    return view('plans');
});

// Audit Logs Page
Route::get('/audit-view', function () {
    return view('audit');
});
Route::get('/super-admin', function () {
    return view('super-admin');
});