<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\RegisteredAdminController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;

// guest
Route::get('/login' , [AuthenticatedSessionController::class , 'create'])->name('admin.login.form');
Route::post('/login' , [AuthenticatedSessionController::class , 'store'])->name('admin.login');
Route::post('/logout' , [AuthenticatedSessionController::class , 'destroy'])->name('admin.logout');
Route::get('/register' , [RegisteredAdminController::class , 'create'])->name('admin.register.form');
Route::post('/register' , [RegisteredAdminController::class , 'store'])->name('admin.register');

Route::get('/forgot-password' , [PasswordResetLinkController::class , 'create'])->name('admin.password.request');
Route::post('/forgot-password' , [PasswordResetLinkController::class , 'store'])->name('admin.password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
->name('admin.password.reset');

Route::post('reset-password', [NewPasswordController::class, 'store'])
->name('admin.password.update');





Route::group(['middleware' =>'auth.admin'] , function()
{
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->name('admin.password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::get('dashboard' , function()
    {
        return view('admin.views.dashboard');
    })->name('admin.dashboard');
});
