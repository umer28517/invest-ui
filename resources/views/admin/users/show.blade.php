<x-app-layout>
    <div class="space-y-6">

        <!-- Back Link & Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-natural-darkCard via-[#16201B] to-natural-darkCard p-6 sm:p-7 rounded-3xl border border-natural-darkBorder shadow-dark-card">
            <div class="space-y-1.5">
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.users.index') }}" class="text-xs font-mono text-natural-sage hover:text-white transition flex items-center gap-1">
                        <i class="fa-solid fa-arrow-left text-[10px]"></i> User Management
                    </a>
                    <span class="text-stone-500">•</span>
                    <span class="text-xs text-natural-textMuted font-mono">User ID: #{{ $user->id }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center font-bold text-base shadow-md">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h1 class="font-serif font-bold text-xl sm:text-2xl text-white">{{ $user->name }}</h1>
                        <p class="text-xs text-natural-textMuted font-mono">{{ $user->email }} &bull; {{ $user->phone ?? 'No Phone' }}</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-2.5">
                @if ($user->is_active)
                    <span class="px-3 py-1.5 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-xs font-bold font-mono flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Active Account
                    </span>
                @else
                    <span class="px-3 py-1.5 rounded-xl bg-rose-500/20 border border-rose-500/30 text-rose-300 text-xs font-bold font-mono flex items-center gap-1.5">
                        <i class="fa-solid fa-ban text-[10px]"></i> Deactivated
                    </span>
                @endif

                <!-- Activate / Deactivate Form -->
                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                    @csrf
                    @if ($user->is_active)
                        <button type="submit" onclick="return confirm('Deactivate this investor?')" class="px-3.5 py-1.5 rounded-xl bg-rose-950/40 hover:bg-rose-900/60 border border-rose-600/40 text-rose-300 text-xs font-bold transition">
                            Deactivate
                        </button>
                    @else
                        <button type="submit" onclick="return confirm('Activate this investor?')" class="px-3.5 py-1.5 rounded-xl bg-natural-forest hover:bg-natural-moss text-white text-xs font-bold transition">
                            Activate
                        </button>
                    @endif
                </form>
            </div>
        </div>

        <!-- 6 Executive KPI Dossier Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            
            <!-- 1. Total Compounding Available Balance -->
            <div class="bg-natural-darkCard rounded-3xl p-5 sm:p-6 border border-amber-500/30 shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider font-mono">Current Available Balance</span>
                <div class="text-3xl font-serif font-bold text-amber-400 font-mono">${{ number_format($user->balance, 2) }}</div>
                <div class="text-xs text-natural-textMuted flex items-center justify-between pt-1 border-t border-natural-darkBorder font-mono">
                    <span>Effective Tier:</span>
                    <strong class="text-white">{{ $user->effective_package?->name ?? $user->activePackage?->name ?? 'None' }} @if ($user->is_tier_upgraded)<span class="text-amber-400 text-[10px]">(Auto-Upgraded)</span>@endif</strong>
                </div>
            </div>

            <!-- 2. Active Yield Rate -->
            <div class="bg-natural-darkCard rounded-3xl p-5 sm:p-6 border border-natural-darkBorder shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider font-mono">Daily Yield Commission</span>
                <div class="text-3xl font-serif font-bold text-natural-mint font-mono">+{{ number_format($user->effective_daily_rate, 2) }}% <span class="text-xs text-natural-textMuted font-sans">/ day</span></div>
                <div class="text-xs text-natural-textMuted flex items-center justify-between pt-1 border-t border-natural-darkBorder font-mono">
                    <span>Est. Next 24h Yield:</span>
                    <strong class="text-natural-mint">+${{ number_format(($user->balance * $user->effective_daily_rate) / 100, 2) }} USD</strong>
                </div>
            </div>

            <!-- 3. 30-Day Capital Lock Status -->
            <div class="bg-natural-darkCard rounded-3xl p-5 sm:p-6 border border-natural-darkBorder shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider font-mono">30-Day Capital Lock Status</span>
                @if ($user->isCapitalLocked())
                    <div class="text-xl font-serif font-bold text-amber-300 font-mono flex items-center gap-2">
                        <i class="fa-solid fa-lock text-sm"></i>
                        <span>{{ $user->daysRemainingLocked() }} Days Remaining</span>
                    </div>
                    <div class="text-[11px] text-amber-200/80 font-mono pt-1 border-t border-natural-darkBorder flex justify-between">
                        <span>Locked Base: ${{ number_format($user->locked_principal, 2) }}</span>
                        <span class="text-natural-mint">Profit: ${{ number_format($user->getWithdrawableBalance(), 2) }}</span>
                    </div>
                @else
                    <div class="text-xl font-serif font-bold text-emerald-400 font-mono flex items-center gap-2">
                        <i class="fa-solid fa-lock-open text-sm"></i>
                        <span>Unlocked for Cashout</span>
                    </div>
                    <div class="text-[11px] text-natural-textMuted font-mono pt-1 border-t border-natural-darkBorder">
                        Eligible for $10 minimum withdrawal
                    </div>
                @endif
            </div>

            <!-- 4. Total Approved Deposits -->
            <div class="bg-natural-darkCard rounded-3xl p-5 sm:p-6 border border-natural-darkBorder shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider font-mono">Total Capital Deposited</span>
                <div class="text-2xl sm:text-3xl font-serif font-bold text-white font-mono">${{ number_format($totalDeposited, 2) }}</div>
                <div class="text-[11px] text-natural-textMuted font-mono pt-1 border-t border-natural-darkBorder">
                    Across {{ $user->deposits()->where('status', 'approved')->count() }} confirmed Binance transfer(s)
                </div>
            </div>

            <!-- 5. Total Daily Profit Earned -->
            <div class="bg-natural-darkCard rounded-3xl p-5 sm:p-6 border border-natural-darkBorder shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider font-mono">Total Yield Profit Earned</span>
                <div class="text-2xl sm:text-3xl font-serif font-bold text-natural-mint font-mono">+${{ number_format($totalProfitEarned, 2) }}</div>
                <div class="text-[11px] text-natural-sage font-mono pt-1 border-t border-natural-darkBorder flex justify-between">
                    <span>Earned Today:</span>
                    <strong>+${{ number_format($todayProfit, 2) }} USD</strong>
                </div>
            </div>

            <!-- 6. Total Withdrawn & Referrals -->
            <div class="bg-natural-darkCard rounded-3xl p-5 sm:p-6 border border-natural-darkBorder shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider font-mono">Total Capital Withdrawn</span>
                <div class="text-2xl sm:text-3xl font-serif font-bold text-white font-mono">${{ number_format($totalWithdrawn, 2) }}</div>
                <div class="text-[11px] text-natural-textMuted font-mono pt-1 border-t border-natural-darkBorder flex justify-between">
                    <span>Referral Team:</span>
                    <strong class="text-amber-300">{{ $referralCount }} Investor(s)</strong>
                </div>
            </div>

        </div>

        <!-- Interactive Detailed History Tabs (Clean Layout) -->
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder shadow-dark-card p-6 space-y-5" x-data="{ activeTab: 'yields' }">
            
            <!-- Tabs Strip -->
            <div class="flex items-center gap-2 border-b border-natural-darkBorder pb-3 overflow-x-auto">
                <button type="button" @click="activeTab = 'yields'" :class="activeTab === 'yields' ? 'bg-amber-400 text-slate-950 font-bold' : 'text-natural-textMuted hover:text-white bg-natural-darkPaper'" class="px-4 py-2 rounded-xl text-xs transition cursor-pointer font-mono">
                    <i class="fa-solid fa-chart-line mr-1"></i> Daily Profit Logs ({{ $user->yieldDistributions->count() }})
                </button>
                <button type="button" @click="activeTab = 'deposits'" :class="activeTab === 'deposits' ? 'bg-amber-400 text-slate-950 font-bold' : 'text-natural-textMuted hover:text-white bg-natural-darkPaper'" class="px-4 py-2 rounded-xl text-xs transition cursor-pointer font-mono">
                    <i class="fa-solid fa-money-bill-transfer mr-1"></i> Deposits & Proofs ({{ $user->deposits->count() }})
                </button>
                <button type="button" @click="activeTab = 'withdrawals'" :class="activeTab === 'withdrawals' ? 'bg-amber-400 text-slate-950 font-bold' : 'text-natural-textMuted hover:text-white bg-natural-darkPaper'" class="px-4 py-2 rounded-xl text-xs transition cursor-pointer font-mono">
                    <i class="fa-solid fa-arrow-up-right-from-square mr-1"></i> Cashouts ({{ $user->withdrawals->count() }})
                </button>
                <button type="button" @click="activeTab = 'referrals'" :class="activeTab === 'referrals' ? 'bg-amber-400 text-slate-950 font-bold' : 'text-natural-textMuted hover:text-white bg-natural-darkPaper'" class="px-4 py-2 rounded-xl text-xs transition cursor-pointer font-mono">
                    <i class="fa-solid fa-users mr-1"></i> Referral Network ({{ $user->referrals->count() }})
                </button>
            </div>

            <!-- Tab 1: Daily Profit Logs -->
            <div x-show="activeTab === 'yields'" class="space-y-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs font-mono">
                        <thead class="text-natural-textMuted uppercase tracking-wider border-b border-natural-darkBorder text-[11px]">
                            <tr>
                                <th class="pb-3">Timestamp</th>
                                <th class="pb-3">Starting Balance</th>
                                <th class="pb-3">Applied Rate</th>
                                <th class="pb-3">Profit Credited</th>
                                <th class="pb-3 text-right">New Compounding Balance</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-natural-darkBorder">
                            @forelse ($user->yieldDistributions as $dist)
                                <tr class="hover:bg-natural-darkPaper/40 transition">
                                    <td class="py-3 text-natural-textMuted">{{ $dist->created_at->format('M d, Y H:i:s') }}</td>
                                    <td class="py-3 text-white font-bold">${{ number_format($dist->starting_balance, 2) }}</td>
                                    <td class="py-3 text-amber-300 font-bold">+{{ number_format($dist->rate_percent, 2) }}% / d</td>
                                    <td class="py-3 text-natural-mint font-bold">+${{ number_format($dist->profit_earned, 2) }}</td>
                                    <td class="py-3 text-right font-bold text-white">${{ number_format($dist->new_balance, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-natural-textMuted">No daily yield distributions credited to this user yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab 2: Deposits & Proofs -->
            <div x-show="activeTab === 'deposits'" class="space-y-4" style="display: none;">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs font-mono">
                        <thead class="text-natural-textMuted uppercase tracking-wider border-b border-natural-darkBorder text-[11px]">
                            <tr>
                                <th class="pb-3">ID / Date</th>
                                <th class="pb-3">Package Tier</th>
                                <th class="pb-3">Amount</th>
                                <th class="pb-3">Binance Proof / Pay ID</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-natural-darkBorder">
                            @forelse ($user->deposits as $dep)
                                <tr class="hover:bg-natural-darkPaper/40 transition">
                                    <td class="py-3 text-natural-textMuted">
                                        <div class="text-white font-bold">#DEP-{{ $dep->id }}</div>
                                        <div>{{ $dep->created_at->format('M d, Y H:i') }}</div>
                                    </td>
                                    <td class="py-3 font-bold text-amber-300">{{ $dep->package->name }} (+{{ number_format($dep->daily_rate, 2) }}%)</td>
                                    <td class="py-3 font-bold text-white">${{ number_format($dep->amount, 2) }}</td>
                                    <td class="py-3">
                                        <span class="bg-natural-darkPaper px-2 py-1 rounded-lg border border-white/[0.06] text-amber-300 font-bold">
                                            {{ $dep->binance_pay_id }}
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        @if ($dep->isPending())
                                            <span class="px-2 py-0.5 rounded-full bg-amber-400/20 text-amber-300 text-[10px] font-bold">Pending Review</span>
                                        @elseif ($dep->isApproved())
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-bold">Approved</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-300 text-[10px] font-bold">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-right">
                                        @if ($dep->isPending())
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <form method="POST" action="{{ route('admin.deposits.approve', $dep->id) }}" class="inline-block" onsubmit="return confirm('Approve deposit now?')">
                                                    @csrf
                                                    <button type="submit" title="Approve Deposit" class="w-7 h-7 rounded-lg bg-emerald-500/20 hover:bg-emerald-500 text-emerald-400 hover:text-slate-950 border border-emerald-500/40 flex items-center justify-center transition shadow-xs cursor-pointer">
                                                        <i class="fa-solid fa-check text-xs"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.deposits.reject', $dep->id) }}" class="inline-block" onsubmit="return confirm('Reject deposit?')">
                                                    @csrf
                                                    <button type="submit" title="Reject Deposit" class="w-7 h-7 rounded-lg bg-rose-500/20 hover:bg-rose-500 text-rose-300 hover:text-white border border-rose-500/40 flex items-center justify-center transition shadow-xs cursor-pointer">
                                                        <i class="fa-solid fa-xmark text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-natural-textMuted text-[10px]">Settled</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-natural-textMuted">No deposit submissions found for this account.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab 3: Cashouts -->
            <div x-show="activeTab === 'withdrawals'" class="space-y-4" style="display: none;">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs font-mono">
                        <thead class="text-natural-textMuted uppercase tracking-wider border-b border-natural-darkBorder text-[11px]">
                            <tr>
                                <th class="pb-3">ID / Date</th>
                                <th class="pb-3">Amount</th>
                                <th class="pb-3">Destination Account</th>
                                <th class="pb-3">Payout Method</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-natural-darkBorder">
                            @forelse ($user->withdrawals as $wth)
                                <tr class="hover:bg-natural-darkPaper/40 transition">
                                    <td class="py-3 text-natural-textMuted">
                                        <div class="text-white font-bold">#WTH-{{ $wth->id }}</div>
                                        <div>{{ $wth->created_at->format('M d, Y H:i') }}</div>
                                    </td>
                                    <td class="py-3 font-bold text-amber-300">${{ number_format($wth->amount, 2) }}</td>
                                    <td class="py-3 text-white truncate max-w-xs">{{ $wth->destination_account }}</td>
                                    <td class="py-3 text-natural-textMuted">{{ $wth->payout_method }}</td>
                                    <td class="py-3">
                                        @if ($wth->isPending())
                                            <span class="px-2 py-0.5 rounded-full bg-amber-400/20 text-amber-300 text-[10px] font-bold">Pending Review</span>
                                        @elseif ($wth->isApproved())
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-bold">Paid</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-300 text-[10px] font-bold">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-right">
                                        @if ($wth->isPending())
                                            <div class="inline-flex items-center gap-1.5 justify-end">
                                                <form method="POST" action="{{ route('admin.withdrawals.approve', $wth->id) }}" class="inline-block" onsubmit="return confirm('Confirm payout?')">
                                                    @csrf
                                                    <button type="submit" title="Settle & Transfer" class="w-7 h-7 rounded-lg bg-emerald-500/20 hover:bg-emerald-500 text-emerald-400 hover:text-slate-950 border border-emerald-500/40 flex items-center justify-center transition shadow-xs cursor-pointer">
                                                        <i class="fa-solid fa-check text-xs"></i>
                                                    </button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.withdrawals.reject', $wth->id) }}" class="inline-block" onsubmit="return confirm('Reject & Refund?')">
                                                    @csrf
                                                    <button type="submit" title="Reject & Refund" class="w-7 h-7 rounded-lg bg-rose-500/20 hover:bg-rose-500 text-rose-300 hover:text-white border border-rose-500/40 flex items-center justify-center transition shadow-xs cursor-pointer">
                                                        <i class="fa-solid fa-xmark text-xs"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-natural-textMuted text-[10px]">Settled</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-natural-textMuted">No cashout requests found for this investor.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tab 4: Referral Network -->
            <div x-show="activeTab === 'referrals'" class="space-y-4" style="display: none;">
                <div class="flex items-center justify-between border-b border-natural-darkBorder pb-3">
                    <span class="text-xs text-natural-textMuted font-mono">
                        Referral Code: <strong class="text-amber-300 font-bold">{{ $user->referral_code }}</strong>
                    </span>
                    <span class="text-xs text-natural-sage font-mono">
                        {{ $user->referrals->count() }} Registered Downline User(s)
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs font-mono">
                        <thead class="text-natural-textMuted uppercase tracking-wider border-b border-natural-darkBorder text-[11px]">
                            <tr>
                                <th class="pb-3">Downline Investor</th>
                                <th class="pb-3">Email</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3 text-right">Registered Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-natural-darkBorder">
                            @forelse ($user->referrals as $ref)
                                <tr class="hover:bg-natural-darkPaper/40 transition">
                                    <td class="py-3 text-white font-bold">{{ $ref->name }}</td>
                                    <td class="py-3 text-natural-textMuted">{{ $ref->email }}</td>
                                    <td class="py-3">
                                        @if ($ref->is_active)
                                            <span class="text-emerald-400 font-bold text-[10px]">Active</span>
                                        @else
                                            <span class="text-rose-400 font-bold text-[10px]">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-right text-natural-textMuted">{{ $ref->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-natural-textMuted">No downline referrals registered under this account yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
</x-app-layout>