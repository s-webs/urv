<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', [\App\Http\Controllers\GuestController::class, 'reception'])->name('reception');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');

    Route::post('/attendance/check-in', [\App\Http\Controllers\AttendancesController::class, 'checkIn'])->name('attendance.check-in');


    Route::get('/check', [\App\Http\Controllers\CheckController::class, 'check'])->name('page.check');
});
