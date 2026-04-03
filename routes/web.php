<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\VerifyCodeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\GoogleAuthController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUsersController;

use App\Http\Controllers\AgentController;
use App\Http\Controllers\UserProfileController;

/*
|--------------------------------------------------------------------------
| AUTH PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/auth');
});

/*
|--------------------------------------------------------------------------
| REGISTER + VERIFY CODE
|--------------------------------------------------------------------------
*/
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/verify-code', [VerifyCodeController::class, 'show'])->name('verify.code.form');
Route::post('/verify-code', [VerifyCodeController::class, 'verify'])->name('verify.code.check');

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/
Route::post('/login', [LoginController::class, 'login'])->name('login.store');

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| GOOGLE AUTH
|--------------------------------------------------------------------------
*/
Route::get('/auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

/*
|--------------------------------------------------------------------------
| USER DASHBOARD + PROFILE
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');

Route::get('/profile', [UserProfileController::class, 'show'])->name('user.profile');
Route::post('/profile', [UserProfileController::class, 'update'])->name('user.profile.update');

/*
|--------------------------------------------------------------------------
| AGENT DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/agent/dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| ADMIN CONFIRMATIONS
|--------------------------------------------------------------------------
*/
Route::get('/admin/confirmations', [AdminController::class, 'index'])->name('admin.confirmations');
Route::post('/admin/confirmations/{id}/accept', [AdminController::class, 'accept'])->name('admin.accept');
Route::post('/admin/confirmations/{id}/reject', [AdminController::class, 'reject'])->name('admin.reject');

/*
|--------------------------------------------------------------------------
| ADMIN - CREATE ACCOUNTS
|--------------------------------------------------------------------------
*/
Route::get('/admin/users', [AdminUsersController::class, 'index'])->name('admin.users');

Route::post('/admin/users/create-admin', [AdminUsersController::class, 'storeAdmin'])
    ->name('admin.users.storeAdmin');

Route::post('/admin/users/create-agent', [AdminUsersController::class, 'storeAgent'])
    ->name('admin.users.storeAgent');

/*
|--------------------------------------------------------------------------
| ADMIN - LISTE DES ACCOUNTS
|--------------------------------------------------------------------------
*/
Route::get('/admin/accounts', [AdminUsersController::class, 'accountsList'])->name('admin.accounts');

Route::post('/admin/accounts/delete/{id}', [AdminUsersController::class, 'delete'])
    ->name('admin.accounts.delete');

use App\Http\Controllers\Admin\CategoryController;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show']);
});
use App\Http\Controllers\Auth\GoogleController;

Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

use App\Http\Controllers\UserTicketController;

Route::prefix('user')->name('user.')->group(function () {
   Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');


    Route::get('/tickets/create', [UserTicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [UserTicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets', [UserTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/history', [UserTicketController::class, 'history'])->name('tickets.history');
});
