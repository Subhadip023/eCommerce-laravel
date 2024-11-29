<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('users', UserController::class);
    Route::post('users/{user}/role/create', [UserController::class, 'assignRole'])->name('user.addRole')->middleware('permission:manage users');
    Route::PUT('users/{user}/role/update', [UserController::class, 'updateRole'])->name('user.updateRole')->middleware('permission:manage users');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('role', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});




require __DIR__ . '/auth.php';
