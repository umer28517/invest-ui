<x-app-layout>
    <div class="space-y-6 max-w-6xl mx-auto">

        <!-- ================= CLEAN MASTER BALANCE & YIELD CARD ================= -->
        <div class="bg-gradient-to-br from-[#122019] via-[#0E1813] to-[#0A120E] text-white rounded-3xl p-6 sm:p-8 relative overflow-hidden shadow-2xl border border-natural-moss/40">
            
            <!-- Ambient Subtle Background Glow -->
            <div class="absolute -top-20 -right-20 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-6">
                
                <!-- Top Row: Greeting & Lock Status Badge -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-white/[0.08] pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-400 text-slate-950 flex items-center justify-center font-bold text-base shadow-md shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-[11px] uppercase tracking-wider text-natural-textMuted font-mono">{{ cms('dashboard.header.investor_badge', 'Verified Investor') }}</div>
                            <h2 class="font-serif font-bold text-lg sm:text-xl text-white">{{ cms('dashboard.header.welcome_text', 'Welcome back') }}, {{ Auth::user()->name }}</h2>
                        </div>
                    </div>

                    <!-- Lock / Unlock Pill -->
                    <div>
                        @if ($user->isCapitalLocked())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-400/15 border border-amber-400/30 text-amber-300 text-xs font-bold font-mono">
                                <i class="fa-solid fa-lock text-[10px]"></i>
                                <span>30-Day Lock Active ({{ $user->daysRemainingLocked() }}d remaining)</span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs font-bold font-mono">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>Capital Unlocked ($10 Min Cashout)</span>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Middle Row: Big Clean Balance & Primary Actions -->
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                    <div class="space-y-1">
                        <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider font-mono">{{ cms('dashboard.balance.title', 'Total Active Balance') }}</span>
                        <div class="text-3xl sm:text-5xl font-serif font-extrabold text-white tracking-tight">
                            ${{ number_format($user->balance, 2) }} <span class="text-sm font-sans font-normal text-natural-textMuted">USD</span>
                        </div>
                        <p class="text-[11px] text-natural-sage font-mono">
                            <i class="fa-solid fa-shield-check"></i> {{ cms('dashboard.balance.subtitle', 'Compounds automatically every 24 hours on your total balance') }}
                        </p>
                    </div>

                    <!-- 2 Main Action Buttons -->
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('investments.index') }}" class="px-6 py-3.5 rounded-2xl font-extrabold text-xs uppercase tracking-wider text-slate-950 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:brightness-110 transition shadow-lg flex items-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-plus text-sm"></i>
                            <span>{{ cms('dashboard.deposit.button', 'Deposit Capital') }}</span>
                        </a>
                        <a href="{{ route('wallet.index') }}" class="px-6 py-3.5 rounded-2xl font-bold text-xs uppercase tracking-wider text-white bg-white/[0.06] hover:bg-white/[0.12] border border-white/[0.15] transition flex items-center gap-2">
                            <i class="fa-solid fa-arrow-up-right-from-square text-sm text-natural-mint"></i>
                            <span>{{ cms('dashboard.cashout.button', 'Cashout ($10 Min)') }}</span>
                        </a>
                    </div>
                </div>

                <!-- Bottom Metrics Strip: 3 Clean Secondary Figures -->
                @php
                    $effectiveRate = $user->effective_daily_rate;
                    $effectivePkg = $user->effective_package;
                    $isUpgraded = $user->is_tier_upgraded;
                    $dailyEstYield = ($user->balance * ($effectiveRate ?: 0)) / 100;
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-2">
                    
                    <!-- 24h Daily Yield -->
                    <div class="bg-black/30 backdrop-blur-sm p-4 rounded-2xl border border-white/[0.06] space-y-1">
                        <span class="text-[10px] text-natural-textMuted uppercase font-mono tracking-wider block">24h Daily Yield</span>
                        <div class="text-xl font-serif font-bold text-natural-mint font-mono">
                            +${{ number_format($dailyEstYield, 2) }} <span class="text-[11px] font-sans text-natural-textMuted">/ day</span>
                        </div>
                        <div class="text-[10px] text-natural-sage font-mono">
                            Rate: +{{ number_format($effectiveRate ?: 0, 2) }}% daily
                        </div>
                    </div>

                    <!-- Active Package Tier -->
                    <div class="bg-black/30 backdrop-blur-sm p-4 rounded-2xl border border-white/[0.06] space-y-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] text-natural-textMuted uppercase font-mono tracking-wider block">Current Package Tier</span>
                            @if ($isUpgraded)
                                <span class="text-[9px] font-bold text-amber-300 bg-amber-950/80 border border-amber-500/40 px-1.5 py-0.5 rounded font-mono">
                                    <i class="fa-solid fa-bolt text-[8px]"></i> Auto-Upgraded
                                </span>
                            @endif
                        </div>
                        <div class="text-xl font-serif font-bold text-amber-300 truncate">
                            {{ $effectivePkg?->name ?? $user->activePackage?->name ?? 'Ready to Invest' }}
                        </div>
                        <div class="text-[10px] text-natural-textMuted font-mono">
                            @if ($isUpgraded)
                                <span class="text-amber-200">Balance reached higher tier threshold (+{{ number_format($effectiveRate, 2) }}%/d)</span>
                            @elseif ($effectiveRate > 0)
                                Active 24h Compounding (+{{ number_format($effectiveRate, 2) }}%/d)
                            @else
                                Deposit $100+ to Activate
                            @endif
                        </div>
                    </div>

                    <!-- Total Withdrawn -->
                    <div class="bg-black/30 backdrop-blur-sm p-4 rounded-2xl border border-white/[0.06] space-y-1">
                        <span class="text-[10px] text-natural-textMuted uppercase font-mono tracking-wider block">Total Withdrawn</span>
                        <div class="text-xl font-serif font-bold text-white font-mono">
                            ${{ number_format($user->withdrawn_total, 2) }}
                        </div>
                        <div class="text-[10px] text-natural-textMuted font-mono">
                            {{ $user->withdrawals()->count() }} Completed Cashout(s)
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- ================= COMPACT AFFILIATE LINK BAR ================= -->
        <div class="bg-natural-darkCard rounded-2xl p-4 sm:p-5 border border-natural-darkBorder shadow-dark-card flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-amber-400/20 text-amber-400 flex items-center justify-center font-bold text-xs shrink-0">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-white">{{ cms('dashboard.referral.title', '3-Tier Referral Link') }}</span>
                    <span class="text-[11px] text-natural-textMuted block sm:inline sm:ml-2">{{ cms('dashboard.referral.subtitle', 'Earn instant referral bonus plus residual yield matching.') }}</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <div class="px-3.5 py-2 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-xs text-natural-mint font-mono truncate max-w-xs">
                    {{ url('/register') }}?ref={{ Auth::user()->referral_code }}
                </div>
                <button type="button" onclick="copyRefLink('{{ url('/register') }}?ref={{ Auth::user()->referral_code }}')" class="px-4 py-2 rounded-xl bg-natural-forest hover:bg-natural-moss text-white text-xs font-bold transition shrink-0 flex items-center gap-1.5 shadow-natural-btn">
                    <i class="fa-solid fa-copy"></i>
                    <span id="copyBtnText">Copy</span>
                </button>
            </div>
        </div>

        <!-- ================= CLEAN ACTIVITY LOGS ================= -->
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder shadow-dark-card p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-natural-darkBorder pb-4">
                <div>
                    <h3 class="font-serif font-bold text-lg text-white">{{ cms('dashboard.activity.title', 'Recent Account Activity') }}</h3>
                    <p class="text-xs text-natural-textMuted">{{ cms('dashboard.activity.subtitle', 'Latest 24h profit distributions, deposits, and cashout transactions') }}</p>
                </div>
                <span class="text-xs text-natural-sage font-mono flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-natural-sage animate-pulse"></span> Live Feed
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs font-mono">
                    <thead class="text-natural-textMuted uppercase tracking-wider border-b border-natural-darkBorder text-[11px]">
                        <tr>
                            <th class="pb-3">Type</th>
                            <th class="pb-3">Description</th>
                            <th class="pb-3">Amount</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-darkBorder">
                        
                        <!-- Yield Distributions -->
                        @foreach ($recentYields as $yield)
                            <tr class="hover:bg-natural-darkPaper/40 transition">
                                <td class="py-3.5 text-white font-sans font-bold flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-natural-forest/40 text-natural-mint flex items-center justify-center text-[10px]">
                                        <i class="fa-solid fa-bolt"></i>
                                    </div>
                                    <span>24h Yield</span>
                                </td>
                                <td class="py-3.5 text-natural-textMuted font-mono">
                                    +{{ number_format($yield->rate_percent, 2) }}% on ${{ number_format($yield->starting_balance, 2) }}
                                </td>
                                <td class="py-3.5 text-natural-mint font-bold">+${{ number_format($yield->profit_earned, 2) }}</td>
                                <td class="py-3.5">
                                    <span class="px-2 py-0.5 rounded-full bg-natural-forest/40 text-natural-mint text-[10px] font-bold">Compounded</span>
                                </td>
                                <td class="py-3.5 text-right text-natural-textMuted text-[11px]">{{ $yield->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach

                        <!-- Deposit Requests -->
                        @foreach ($recentDeposits as $dep)
                            <tr class="hover:bg-natural-darkPaper/40 transition">
                                <td class="py-3.5 text-white font-sans font-bold flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-amber-400/20 text-amber-400 flex items-center justify-center text-[10px]">
                                        <i class="fa-solid fa-arrow-down"></i>
                                    </div>
                                    <span>Deposit</span>
                                </td>
                                <td class="py-3.5 text-natural-textMuted font-mono">
                                    {{ $dep->package->name }} ({{ $dep->payment_method }})
                                </td>
                                <td class="py-3.5 text-amber-300 font-bold">+${{ number_format($dep->amount, 2) }}</td>
                                <td class="py-3.5">
                                    @if ($dep->isApproved())
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-bold">Approved</span>
                                    @elseif ($dep->isPending())
                                        <span class="px-2 py-0.5 rounded-full bg-amber-400/20 text-amber-300 text-[10px] font-bold">Pending Review</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-300 text-[10px] font-bold">Rejected</span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right text-natural-textMuted text-[11px]">{{ $dep->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach

                        <!-- Withdrawals -->
                        @foreach ($recentWithdrawals as $wth)
                            <tr class="hover:bg-natural-darkPaper/40 transition">
                                <td class="py-3.5 text-white font-sans font-bold flex items-center gap-2">
                                    <div class="w-6 h-6 rounded-lg bg-sky-500/20 text-sky-400 flex items-center justify-center text-[10px]">
                                        <i class="fa-solid fa-arrow-up"></i>
                                    </div>
                                    <span>Cashout</span>
                                </td>
                                <td class="py-3.5 text-natural-textMuted font-mono">
                                    {{ $wth->payout_method }}
                                </td>
                                <td class="py-3.5 text-rose-300 font-bold">-${{ number_format($wth->amount, 2) }}</td>
                                <td class="py-3.5">
                                    @if ($wth->isApproved())
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-bold">Settled</span>
                                    @elseif ($wth->isPending())
                                        <span class="px-2 py-0.5 rounded-full bg-amber-400/20 text-amber-300 text-[10px] font-bold">In Review</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-300 text-[10px] font-bold">Refunded</span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right text-natural-textMuted text-[11px]">{{ $wth->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach

                        @if ($recentYields->isEmpty() && $recentDeposits->isEmpty() && $recentWithdrawals->isEmpty())
                            <tr>
                                <td colspan="5" class="py-8 text-center text-natural-textMuted font-mono">
                                    No activity recorded yet. Deposit to start daily compounding.
                                </td>
                            </tr>
                        @endif

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function copyRefLink(link) {
            navigator.clipboard.writeText(link);
            const btn = document.getElementById('copyBtnText');
            btn.innerText = 'Copied!';
            toastr.success('Referral link copied to clipboard!');
            setTimeout(() => {
                btn.innerText = 'Copy';
            }, 2000);
        }
    </script>
</x-app-layout>