<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/**
 * Routes for role and permission management.
 * These routes are protected by the 'role:super-admin|admin' middleware,
 * meaning only users with the 'super-admin' or 'admin' roles can access them.
 */
Route::group(['middleware' => ['role:super-admin|admin']], function () {

    /**
     * Permission Management Routes
     */
    Route::resource('permissions', PermissionController::class); // CRUD routes for permissions
    Route::get('permissions/{permissionId}/delete', [PermissionController::class, 'destroy']);  // Custom delete route for permissions


    /**
     * Role Management Routes
     */
    Route::resource('roles', RoleController::class);  // CRUD routes for roles
    Route::get('roles/{roleId}/delete', [RoleController::class, 'destroy']);  // Custom delete route for roles
    Route::get('roles/{roleId}/give-permissions', [RoleController::class, 'addPermissionToRole']);   // Form to add permissions to a role
    Route::put('roles/{roleId}/give-permissions', [RoleController::class, 'givePermissionToRole']);  // Process adding permissions to a role


    /**
     * User Management Routes
     */
    Route::resource('users', UserController::class);   // CRUD routes for users
    Route::get('users/{userId}/delete', [UserController::class, 'destroy']);  // Custom delete route for users
});

/**
 * Redirect root URL to /dashboard.
 */
Route::get('/', function () {
    return redirect('/dashboard');
});


/**
 * Dashboard Route
 * Protected by 'auth' and 'verified' middleware.
 * Only accessible to authenticated and verified users.
 */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/**
 * Profile Management Routes
 * Grouped under 'auth' middleware to ensure only authenticated users can access them.
 */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/**
 * Authentication Routes
 * Automatically included from the 'auth.php' routes file.
 */
require __DIR__ . '/auth.php';
