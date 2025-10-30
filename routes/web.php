<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return "Cache cleared!";
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'loginSubmit'])->name('login.submit');
    });
    Route::middleware(['auth:admin'])->group(function () {

        Route::get('logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('profile', [AdminAuthController::class, 'profile'])->name('profile');
        Route::post('profile-update', [AdminAuthController::class, 'profile_update'])->name('profile.update');
        Route::middleware(['permission:View dashboard'])->group(function () {
            Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        }); 

        Route::middleware(['permission:Create Employee'])->group(function () {
            Route::get('create-employee', [EmployeeController::class, 'create_employee'])->name('create.employee');
            Route::post('employee-store', [EmployeeController::class, 'employee_store'])->name('employee.store');
        });
        Route::middleware(['permission:View Employee'])->group(function () {
            Route::get('employee-list', [EmployeeController::class, 'employee_list'])->name('employee.list');
        });
        Route::middleware(['permission:Edit Employee'])->group(function () {
            Route::get('employee-edit/{id}', [EmployeeController::class, 'employee_edit'])->name('employee.edit');
            Route::post('employee-update', [EmployeeController::class, 'employee_update'])->name('employee.update');
        });
        Route::middleware(['permission:Delete Employee'])->group(function () {
            Route::delete('employee-delete/{id}', [EmployeeController::class, 'employee_delete'])->name('employee.delete');
        });


        Route::middleware(['permission:View Roles'])->group(function () {
            Route::get('/roles', [RoleController::class, 'role_list'])->name('roles.list');
        });    
        Route::middleware(['permission:Edit Roles'])->group(function () {
            Route::get('/roles-edit/{id}', [RoleController::class, 'role_edit'])->name('roles.edit');
            Route::post('/roles-update', [RoleController::class, 'role_update'])->name('roles.update');
        });
      
        Route::middleware(['permission:View Permissions'])->group(function () {
            Route::get('/permissions', [PermissionController::class, 'permissions_list'])->name('permissions.list');
        });
        Route::middleware(['permission:Create Permissions'])->group(function () {
            Route::get('/create-permissions', [PermissionController::class, 'permissions_create'])->name('permissions.create');
            Route::post('/permissions-store', [PermissionController::class, 'permissions_store'])->name('permissions.store');
        });
        Route::middleware(['permission:Edit Permissions'])->group(function () {
            Route::get('/permissions-edit/{id}', [PermissionController::class, 'permissions_edit'])->name('permissions.edit');
            Route::post('/permissions-update', [PermissionController::class, 'permissions_update'])->name('permissions.update');
        });        
    });
});



Route::get('/', [HomeController::class, 'index'])->name('front.index');
