<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController;
use App\Models\UserDosen;
use App\Models\UserStaff;
use Illuminate\Support\Facades\Route;

// Model Binding
Route::model('user', UserDosen::class);
Route::model('staff', UserStaff::class);

Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Welcome/Management Portal
Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

// API Routes untuk Attendance
Route::middleware(['auth'])->group(function () {
    Route::get('/api/attendance/data', [WelcomeController::class, 'getAttendanceData'])->name('attendance.get');
    Route::post('/api/attendance/record', [WelcomeController::class, 'recordAttendance'])->name('attendance.record');
    Route::post('/api/status/update', [WelcomeController::class, 'updateStatus'])->name('status.update');
});

// User listing pages
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/dosen/index', [UserController::class, 'dosen'])->name('users.dosen');
Route::get('/users/staff/index', [UserController::class, 'staff'])->name('users.staff');

// Dosen CRUD
Route::get('/dosen/create', [UserController::class, 'create'])->name('dosen.create');
Route::post('/dosen/store', [UserController::class, 'store'])->name('dosen.store');
Route::get('/dosen/{user}/edit', [UserController::class, 'edit'])->name('dosen.edit');
Route::put('/dosen/{user}', [UserController::class, 'update'])->name('dosen.update');
Route::delete('/dosen/{user}', [UserController::class, 'destroy'])->name('dosen.destroy');

// Staff CRUD
Route::get('/staff/create', [UserController::class, 'create'])->name('staff.create');
Route::post('/staff/store', [UserController::class, 'store'])->name('staff.store');
Route::get('/staff/{staff}/edit', [UserController::class, 'edit'])->name('staff.edit');
Route::put('/staff/{staff}', [UserController::class, 'update'])->name('staff.update');
Route::delete('/staff/{staff}', [UserController::class, 'destroy'])->name('staff.destroy');

// Generic user resource routes
Route::resource('users', UserController::class)->except(['show', 'index']);
