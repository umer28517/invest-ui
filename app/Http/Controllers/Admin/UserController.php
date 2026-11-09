<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display the user management page (investors/users only, excluding admins).
     */
    public function index(): View
    {
        $users = User::with('activePackage')->where('role', '!=', 'admin')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Display a comprehensive investor dossier / audit profile.
     */
    public function show(User $user): View
    {
        if ($user->isAdmin()) {
            return redirect()->route('admin.users.index')->with('error', 'Administrator profiles are managed under Operator Profile.');
        }

        $user->load(['activePackage', 'deposits.package', 'yieldDistributions', 'withdrawals', 'referrals']);

        $totalDeposited = $user->deposits()->where('status', 'approved')->sum('amount');
        $totalProfitEarned = $user->yieldDistributions()->sum('profit_earned');
        $todayProfit = $user->yieldDistributions()->whereDate('created_at', today())->sum('profit_earned');
        $referralCount = $user->referrals()->count();
        $totalWithdrawn = (float) $user->withdrawn_total;

        return view('admin.users.show', compact(
            'user',
            'totalDeposited',
            'totalProfitEarned',
            'todayProfit',
            'referralCount',
            'totalWithdrawn'
        ));
    }

    /**
     * Toggle active/deactive status of a user.
     */
    public function toggleStatus(Request $request, User $user): RedirectResponse
    {
        if ($user->isAdmin() || $user->id === $request->user()->id) {
            return redirect()->route('admin.users.index')->with('error', 'Administrator accounts cannot be modified here.');
        }

        $user->is_active = ! $user->is_active;
        $user->save();

        $actionText = $user->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.users.index')->with('status', "User {$user->name} has been {$actionText} successfully.");
    }

    /**
     * Delete a user account.
     */
    public function destroy(Request $request, User $user): RedirectResponse
    {
        if ($user->isAdmin() || $user->id === $request->user()->id) {
            return redirect()->route('admin.users.index')->with('error', 'Administrator accounts cannot be deleted.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')->with('status', "Investor account '{$name}' deleted successfully.");
    }
}
