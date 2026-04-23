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
use App\Http\Controllers\UserTicketController;
use App\Http\Controllers\Admin\CategoryController;

use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\NotificationsController;

use App\Http\Controllers\AgentProfileController;
use App\Http\Controllers\AgentSettingsController;
use App\Http\Controllers\AgentNotificationsController;

use App\Http\Controllers\AdminAgentChatController;
use App\Http\Controllers\AdminSettingsController;

use App\Http\Controllers\AdminNotificationsController;


/*
|--------------------------------------------------------------------------
| AUTH PAGE
|--------------------------------------------------------------------------
*/
Route::get('/auth', function () {
    return view('auth');
})->name('auth');

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
| AGENT
|--------------------------------------------------------------------------
*/
Route::prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', [AgentController::class, 'dashboard'])->name('dashboard');

    Route::get('/tickets', [AgentController::class, 'tickets'])->name('tickets.index');
    Route::get('/tickets/{ticket}', [AgentController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/messages', [AgentController::class, 'storeMessage'])->name('tickets.messages.store');
    Route::post('/tickets/{ticket}/assign-to-me', [AgentController::class, 'assignToMe'])->name('tickets.assign');
    Route::post('/tickets/{ticket}/status', [AgentController::class, 'updateStatus'])->name('tickets.status');
});

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

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show']);
});

/*
|--------------------------------------------------------------------------
| USER TICKETS
|--------------------------------------------------------------------------
*/
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');

    Route::get('/tickets/create', [UserTicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [UserTicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets', [UserTicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/history', [UserTicketController::class, 'history'])->name('tickets.history');
    Route::get('/tickets/{ticket}', [UserTicketController::class, 'show'])->name('tickets.show');
    Route::post('/tickets/{ticket}/messages', [UserTicketController::class, 'storeMessage'])->name('tickets.messages.store');
});


Route::get('/forgot-password', [ForgotPasswordController::class, 'showRequestForm'])->name('password.forgot.form');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendCode'])->name('password.forgot.send');

Route::get('/forgot-password/verify-code', [ForgotPasswordController::class, 'showCodeForm'])->name('password.code.form');
Route::post('/forgot-password/verify-code', [ForgotPasswordController::class, 'verifyCode'])->name('password.code.verify');

Route::get('/reset-password/new', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset.form');
Route::post('/reset-password/new', [ForgotPasswordController::class, 'resetPassword'])->name('password.reset.update');

Route::get('/user/settings', [UserSettingsController::class, 'index'])->name('user.settings');
Route::post('/user/settings/password', [UserSettingsController::class, 'updatePassword'])->name('user.settings.password.update');

Route::get('/user/notifications', [NotificationsController::class, 'index'])->name('user.notifications');
Route::post('/user/notifications/{notification}/read', [NotificationsController::class, 'markAsRead'])->name('user.notifications.read');
Route::post('/user/notifications/read-all', [NotificationsController::class, 'markAllAsRead'])->name('user.notifications.readAll');


Route::get('/agent/profile', [AgentProfileController::class, 'show'])->name('agent.profile');
Route::post('/agent/profile', [AgentProfileController::class, 'update'])->name('agent.profile.update');

Route::get('/agent/settings', [AgentSettingsController::class, 'show'])->name('agent.settings');
Route::post('/agent/settings/password', [AgentSettingsController::class, 'updatePassword'])->name('agent.settings.password.update');


Route::get('/agent/notifications', [AgentNotificationsController::class, 'index'])->name('agent.notifications');
Route::post('/agent/notifications/{notification}/read', [AgentNotificationsController::class, 'markAsRead'])->name('agent.notifications.read');
Route::post('/agent/notifications/read-all', [AgentNotificationsController::class, 'markAllAsRead'])->name('agent.notifications.readAll');

Route::get('/agent/history', [AgentController::class, 'history'])->name('agent.history');
Route::get('/agent/reports', [AgentController::class, 'reports'])->name('agent.reports');

Route::get('/agent/chat-admin/{adminUser?}', [AdminAgentChatController::class, 'agentIndex'])->name('agent.chat.index');
Route::post('/agent/chat-admin/{adminUser}', [AdminAgentChatController::class, 'agentSend'])->name('agent.chat.send');

Route::get('/admin/chat-agents/{agentUser?}', [AdminAgentChatController::class, 'adminIndex'])->name('admin.chat.index');
Route::post('/admin/chat-agents/{agentUser}', [AdminAgentChatController::class, 'adminSend'])->name('admin.chat.send');


Route::get('/admin/settings', [AdminSettingsController::class, 'show'])->name('admin.settings');
Route::post('/admin/settings/password', [AdminSettingsController::class, 'updatePassword'])->name('admin.settings.password.update');

Route::get('/admin/notifications', [AdminNotificationsController::class, 'index'])->name('admin.notifications');
Route::post('/admin/notifications/{notification}/read', [AdminNotificationsController::class, 'markAsRead'])->name('admin.notifications.read');
Route::post('/admin/notifications/read-all', [AdminNotificationsController::class, 'markAllAsRead'])->name('admin.notifications.readAll');