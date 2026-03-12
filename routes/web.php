<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Super Admin Controllers
use App\Http\Controllers\SuperAdmin\DashboardController as SADashboardController;
use App\Http\Controllers\SuperAdmin\GymController as SAGymController;

// Gym Admin Controllers
use App\Http\Controllers\GymAdmin\DashboardController as GADashboardController;
use App\Http\Controllers\GymAdmin\MemberController as GAMemberController;
use App\Http\Controllers\GymAdmin\ExpiringSoonController as GAExpiringSoonController;
use App\Http\Controllers\GymAdmin\ExpiredController as GAExpiredController;
use App\Http\Controllers\GymAdmin\InactiveMemberController as GAInactiveMemberController;
use App\Http\Controllers\GymAdmin\RevenueController as GARevenueController;
use App\Http\Controllers\GymAdmin\StaffController as GAStaffController;
use App\Http\Controllers\GymAdmin\AttendanceController as GAAttendanceController;
use App\Http\Controllers\GymAdmin\ExpenseController as GAExpenseController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'superadmin') {
        return redirect()->route('superadmin.dashboard');
    }
    return redirect()->route('gym.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Super Admin Routes
Route::middleware(['auth', 'superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SADashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/chart', [SADashboardController::class, 'chartData'])->name('dashboard.chart');
    Route::resource('gyms', SAGymController::class);
    Route::post('/gyms/{gym}/status', [SAGymController::class, 'toggleStatus'])->name('gyms.status');
    Route::post('/gyms/{gym}/payments', [SAGymController::class, 'addPayment'])->name('gyms.payment');
});

// Gym Admin Routes
Route::middleware(['auth', 'gym_admin', 'active_gym'])->group(function () {
    Route::get('/gym/dashboard', [GADashboardController::class, 'index'])->name('gym.dashboard');
    Route::post('/members/bulk-delete', [GAMemberController::class, 'bulkDestroy'])->name('members.bulkDestroy');
    Route::resource('members', GAMemberController::class);
    Route::post('/members/{member}/mark-paid', [GAMemberController::class, 'markAsPaid'])->name('members.markPaid');
    Route::post('/members/{member}/reactivate', [GAMemberController::class, 'reactivate'])->name('members.reactivate');
    Route::get('/expiring-soon', [GAExpiringSoonController::class, 'index'])->name('expiring-soon');
    Route::get('/expired', [GAExpiredController::class, 'index'])->name('expired');
    Route::get('/inactive-members', [GAInactiveMemberController::class, 'index'])->name('inactive-members');
    Route::get('/revenue', [GARevenueController::class, 'index'])->name('revenue.index');
    Route::post('/revenue/chart', [GARevenueController::class, 'chartData'])->name('revenue.chart');
    
    Route::resource('staff', GAStaffController::class)->except(['create', 'edit', 'show']);
    Route::post('/staff/{staff}/pay', [GAStaffController::class, 'paySalary'])->name('staff.pay');
    
    Route::get('/attendance', [GAAttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [GAAttendanceController::class, 'store'])->name('attendance.store');

    // Expenses
    Route::resource('expenses', GAExpenseController::class)->except(['create', 'edit', 'show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
