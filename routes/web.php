<?php

use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Home Page
Route::get('/', function () {
    $packages = Package::where('is_active', true)->orderBy('investment_amount', 'asc')->get();
    $totalMembers = User::where('role', 'user')->count();
    $totalManaged = User::where('role', 'user')->sum('balance');
    $totalYieldsPaid = \App\Models\YieldDistribution::sum('profit_earned');
    $referralRate = (float) \App\Models\Setting::get('referral_commission_percent', 5.00);

    return view('welcome', compact('packages', 'totalMembers', 'totalManaged', 'totalYieldsPaid', 'referralRate'));
})->name('home');

// ================= INVESTOR / USER PAGES =================
Route::middleware(['auth', 'verified'])->group(function () {
    
    // 1. Investor Dashboard Overview
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        $user = auth()->user()->load(['activePackage', 'deposits.package', 'yieldDistributions', 'withdrawals']);
        $packages = Package::where('is_active', true)->get();
        $recentYields = $user->yieldDistributions()->latest()->take(5)->get();
        $recentDeposits = $user->deposits()->latest()->take(5)->get();
        $recentWithdrawals = $user->withdrawals()->latest()->take(5)->get();

        return view('dashboard', compact('user', 'packages', 'recentYields', 'recentDeposits', 'recentWithdrawals'));
    })->name('dashboard');

    // 2. Investment Plans Page
    Route::get('/investments', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.packages.index');
        }
        $packages = Package::where('is_active', true)->get();
        return view('investments.index', compact('packages'));
    })->name('investments.index');
    Route::post('/investments/deposit', [\App\Http\Controllers\DepositController::class, 'store'])->name('investments.deposit');

    // 3. Wallet & Cashout Page
    Route::get('/wallet', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.reserves.index');
        }
        $user = auth()->user();
        $withdrawals = $user->withdrawals()->latest()->get();
        return view('wallet.index', compact('user', 'withdrawals'));
    })->name('wallet.index');
    Route::post('/wallet/cashout', [\App\Http\Controllers\WalletController::class, 'requestCashout'])->name('wallet.cashout');

    // 4. Referral Network Page
    Route::get('/referrals', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.users.index');
        }
        return view('referrals.index');
    })->name('referrals.index');

    // 5. Notifications Page
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

    // 6. User Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================= ADMIN CONSOLE PAGES =================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // 1. System Overview Page
    Route::get('/dashboard', function () {
        $users = User::where('role', '!=', 'admin')->latest()->get();
        $packages = Package::latest()->get();
        $pendingDeposits = \App\Models\DepositRequest::with(['user', 'package'])->where('status', 'pending')->latest()->get();
        $allDeposits = \App\Models\DepositRequest::with(['user', 'package'])->latest()->take(10)->get();
        $pendingWithdrawals = \App\Models\WithdrawalRequest::with('user')->where('status', 'pending')->latest()->get();
        $totalCompoundingPool = User::where('role', 'user')->sum('balance');
        $total24hDistributed = \App\Models\YieldDistribution::whereDate('created_at', today())->sum('profit_earned');

        return view('admin.dashboard', compact(
            'users', 
            'packages', 
            'pendingDeposits', 
            'allDeposits', 
            'pendingWithdrawals', 
            'totalCompoundingPool',
            'total24hDistributed'
        ));
    })->name('dashboard');

    // Deposit Management & Approval Page
    Route::get('/deposits', [\App\Http\Controllers\Admin\DepositApprovalController::class, 'index'])->name('deposits.index');
    Route::post('/deposits/{deposit}/approve', [\App\Http\Controllers\Admin\DepositApprovalController::class, 'approve'])->name('deposits.approve');
    Route::post('/deposits/{deposit}/reject', [\App\Http\Controllers\Admin\DepositApprovalController::class, 'reject'])->name('deposits.reject');

    // Withdrawal Approval Controls
    Route::post('/withdrawals/{withdrawal}/approve', [\App\Http\Controllers\Admin\WithdrawalApprovalController::class, 'approve'])->name('withdrawals.approve');
    Route::post('/withdrawals/{withdrawal}/reject', [\App\Http\Controllers\Admin\WithdrawalApprovalController::class, 'reject'])->name('withdrawals.reject');

    // 24h Compounding ROI Batch Trigger
    Route::post('/daily-roi/trigger', [\App\Http\Controllers\Admin\DailyRoiController::class, 'trigger'])->name('daily-roi.trigger');

    // 2. User Management Page
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::post('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // 3. Package Management Page
    Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
    Route::post('/packages', [PackageController::class, 'store'])->name('packages.store');
    Route::put('/packages/{package}', [PackageController::class, 'update'])->name('packages.update');
    Route::delete('/packages/{package}', [PackageController::class, 'destroy'])->name('packages.destroy');

    // 4. Notifications & Broadcast System
    Route::get('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'store'])->name('notifications.store');
    Route::delete('/notifications/{notification}', [\App\Http\Controllers\Admin\NotificationController::class, 'destroy'])->name('notifications.destroy');

    // 5. Reserves & Vaults Page
    Route::get('/reserves', function () {
        return view('admin.reserves.index');
    })->name('reserves.index');

    // 6. Admin Settings & Configuration Page (with General, Password, Commissions & Credentials)
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
    Route::get('/profile', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('profile.index');

    // 7. Platform Content Management System (CMS)
    Route::get('/content', [\App\Http\Controllers\Admin\CmsController::class, 'index'])->name('cms.index');
    Route::post('/content', [\App\Http\Controllers\Admin\CmsController::class, 'update'])->name('cms.update');
    Route::post('/content/reset', [\App\Http\Controllers\Admin\CmsController::class, 'reset'])->name('cms.reset');
});

require __DIR__.'/auth.php';
