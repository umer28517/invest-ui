<x-app-layout>
    <div class="space-y-6 max-w-7xl mx-auto">

        <!-- ================= EXECUTIVE ACTION HEADER ================= -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-1">
            <div>
                <h2 class="font-serif font-bold text-xl sm:text-2xl text-white">System Administration Console</h2>
                <p class="text-xs text-natural-textMuted font-mono">Live Operations & Automated 24h Compounding Engine</p>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" onclick="confirmTriggerDailyRoi()" class="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:brightness-110 transition shadow-md flex items-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-bolt text-xs"></i>
                    <span>Trigger 24h ROI Batch</span>
                </button>
            </div>
        </div>

        <!-- Hidden Form for 24h Compounding Distribution Trigger -->
        <form id="dailyRoiTriggerForm" method="POST" action="{{ route('admin.daily-roi.trigger') }}" class="hidden">
            @csrf
        </form>

        <!-- ================= 4 PRIMARY INSTITUTIONAL METRICS ================= -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <!-- 1. Total Compounding Pool (Escrow Cold Storage) -->
            <div class="bg-natural-darkCard rounded-3xl p-6 border border-natural-darkBorder shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider font-mono">Escrow Cold Storage</span>
                <div class="text-2xl sm:text-3xl font-serif font-bold text-natural-mint font-mono">${{ number_format($totalCompoundingPool, 2) }}</div>
                <div class="text-[11px] text-natural-sage font-semibold flex items-center gap-1 font-mono">
                    <i class="fa-solid fa-shield-check"></i> Total Active Compounding Pool
                </div>
            </div>

            <!-- 2. Total Registered Users -->
            <div class="bg-natural-darkCard rounded-3xl p-6 border border-natural-darkBorder shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider font-mono">Total Registered Users</span>
                <div class="text-2xl sm:text-3xl font-serif font-bold text-white font-mono">{{ $users->count() }} Accounts</div>
                <div class="text-[11px] text-natural-sage font-semibold flex items-center gap-1 font-mono">
                    <i class="fa-solid fa-circle text-[8px] text-natural-sage"></i> {{ $users->where('is_active', true)->count() }} Active Investors
                </div>
            </div>

            <!-- 3. Pending Queue -->
            <div class="bg-natural-darkCard rounded-3xl p-6 border {{ ($pendingDeposits->count() + $pendingWithdrawals->count()) > 0 ? 'border-amber-500/50 bg-[#16160F]' : 'border-natural-darkBorder' }} shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider font-mono">Pending Operator Queue</span>
                <div class="text-2xl sm:text-3xl font-serif font-bold text-amber-400 font-mono">
                    {{ $pendingDeposits->count() + $pendingWithdrawals->count() }} Requests
                </div>
                <div class="text-[11px] text-amber-300 font-semibold flex items-center gap-1 font-mono">
                    <i class="fa-solid fa-clock"></i> {{ $pendingDeposits->count() }} Deposits &bull; {{ $pendingWithdrawals->count() }} Cashouts
                </div>
            </div>

            <!-- 4. 24h Distributed Yield -->
            <div class="bg-natural-darkCard rounded-3xl p-6 border border-natural-darkBorder shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider font-mono">24h Distributed Yield</span>
                <div class="text-2xl sm:text-3xl font-serif font-bold text-natural-mint font-mono">${{ number_format($total24hDistributed, 2) }}</div>
                <div class="text-[11px] text-natural-textMuted font-mono">
                    Compounded on Total Balances
                </div>
            </div>
        </div>

        <!-- ================= SECTION: PENDING ACTION QUEUES (IF ANY) ================= -->
        @if ($pendingDeposits->isNotEmpty() || $pendingWithdrawals->isNotEmpty())
            <div class="bg-natural-darkCard rounded-3xl border border-amber-500/40 shadow-dark-card p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-natural-darkBorder pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-400/20 text-amber-400 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-bell"></i>
                        </div>
                        <div>
                            <h3 class="font-serif font-bold text-lg text-white">Action Required: Pending Approvals</h3>
                            <p class="text-xs text-natural-textMuted">Deposits and withdrawals waiting for administrative settlement</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.deposits.index') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 transition font-mono">
                            View All In Deposits Tab →
                        </a>
                    </div>
                </div>

                <!-- Quick Deposits Queue -->
                @if ($pendingDeposits->isNotEmpty())
                    <div class="space-y-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-300 font-mono">Pending Binance Deposits ({{ $pendingDeposits->count() }})</span>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-natural-textPrimary font-mono">
                                <tbody class="divide-y divide-natural-darkBorder">
                                    @foreach ($pendingDeposits->take(3) as $deposit)
                                        <tr class="hover:bg-natural-darkPaper/40 transition">
                                            <td class="py-3 font-sans">
                                                <div class="font-bold text-white">{{ $deposit->user->name }}</div>
                                                <div class="text-[11px] text-natural-textMuted font-mono">{{ $deposit->user->email }}</div>
                                            </td>
                                            <td class="py-3 text-amber-300 font-bold">
                                                {{ $deposit->package->name }} (+{{ number_format($deposit->daily_rate, 2) }}%/d)
                                            </td>
                                            <td class="py-3 font-bold text-white text-sm">
                                                ${{ number_format($deposit->amount, 2) }}
                                            </td>
                                            <td class="py-3">
                                                <span class="bg-natural-darkPaper px-2 py-1 rounded-lg border border-white/[0.06] text-amber-300 font-bold">
                                                    {{ $deposit->binance_pay_id }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-right">
                                                <div class="inline-flex items-center gap-1.5 justify-end">
                                                    <form method="POST" action="{{ route('admin.deposits.approve', $deposit->id) }}" class="inline-block" onsubmit="return confirm('Approve deposit of ${{ $deposit->amount }} for {{ $deposit->user->name }}?')">
                                                        @csrf
                                                        <button type="submit" title="Approve Deposit" class="w-7 h-7 rounded-lg bg-emerald-500/20 hover:bg-emerald-500 text-emerald-400 hover:text-slate-950 border border-emerald-500/40 flex items-center justify-center transition shadow-xs cursor-pointer">
                                                            <i class="fa-solid fa-check text-xs"></i>
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('admin.deposits.reject', $deposit->id) }}" class="inline-block" onsubmit="return confirm('Reject deposit?')">
                                                        @csrf
                                                        <button type="submit" title="Reject Deposit" class="w-7 h-7 rounded-lg bg-rose-500/20 hover:bg-rose-500 text-rose-300 hover:text-white border border-rose-500/40 flex items-center justify-center transition shadow-xs cursor-pointer">
                                                            <i class="fa-solid fa-xmark text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                <!-- Quick Cashouts / Withdrawals Queue -->
                @if ($pendingWithdrawals->isNotEmpty())
                    <div class="space-y-2 {{ $pendingDeposits->isNotEmpty() ? 'pt-4 border-t border-natural-darkBorder' : '' }}">
                        <span class="text-xs font-bold uppercase tracking-wider text-rose-300 font-mono flex items-center gap-1.5">
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i> Pending Binance Cashouts ({{ $pendingWithdrawals->count() }})
                        </span>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-xs text-natural-textPrimary font-mono">
                                <tbody class="divide-y divide-natural-darkBorder">
                                    @foreach ($pendingWithdrawals as $withdrawal)
                                        <tr class="hover:bg-natural-darkPaper/40 transition">
                                            <td class="py-3 font-sans">
                                                <div class="font-bold text-white">{{ $withdrawal->user->name }}</div>
                                                <div class="text-[11px] text-natural-textMuted font-mono">{{ $withdrawal->user->email }}</div>
                                            </td>
                                            <td class="py-3 text-amber-300 font-bold">
                                                {{ $withdrawal->payout_method }}
                                            </td>
                                            <td class="py-3 font-bold text-emerald-400 text-sm">
                                                ${{ number_format($withdrawal->amount, 2) }}
                                                @if ($withdrawal->fee_amount > 0)
                                                    <div class="text-[10px] text-amber-300 font-normal">Net Pay: ${{ number_format($withdrawal->net_amount, 2) }} (-${{ number_format($withdrawal->fee_amount, 2) }})</div>
                                                @endif
                                            </td>
                                            <td class="py-3">
                                                <span class="bg-natural-darkPaper px-2 py-1 rounded-lg border border-white/[0.06] text-white font-bold font-mono">
                                                    {{ $withdrawal->destination_account }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-right">
                                                <div class="inline-flex items-center gap-1.5 justify-end">
                                                    <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal->id) }}" class="inline-block" onsubmit="return confirm('Approve and settle payout of ${{ $withdrawal->amount }} for {{ $withdrawal->user->name }}?')">
                                                        @csrf
                                                        <button type="submit" title="Approve & Settle Payout" class="w-7 h-7 rounded-lg bg-emerald-500/20 hover:bg-emerald-500 text-emerald-400 hover:text-slate-950 border border-emerald-500/40 flex items-center justify-center transition shadow-xs cursor-pointer">
                                                            <i class="fa-solid fa-check text-xs"></i>
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal->id) }}" class="inline-block" onsubmit="return confirm('Reject cashout and refund ${{ $withdrawal->amount }} to {{ $withdrawal->user->name }}?')">
                                                        @csrf
                                                        <button type="submit" title="Reject & Refund" class="w-7 h-7 rounded-lg bg-rose-500/20 hover:bg-rose-500 text-rose-300 hover:text-white border border-rose-500/40 flex items-center justify-center transition shadow-xs cursor-pointer">
                                                            <i class="fa-solid fa-xmark text-xs"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- ================= ACTIVE INVESTOR TIERS & COMPOUNDING AUDIT ================= -->
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder shadow-dark-card p-6 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-natural-darkBorder pb-4">
                <div>
                    <h3 class="font-serif font-bold text-lg text-white">Active Investors & Package Subscriptions</h3>
                    <p class="text-xs text-natural-textMuted">Live view of each investor's package tier, active compounding balance, and daily percentage payout</p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-amber-400 hover:text-amber-300 transition font-mono">
                        User Management Directory ({{ $users->count() }}) →
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-natural-textPrimary font-sans">
                    <thead class="text-natural-textMuted uppercase font-mono tracking-wider border-b border-natural-darkBorder text-[11px]">
                        <tr>
                            <th class="pb-3">Investor</th>
                            <th class="pb-3">Active Tier</th>
                            <th class="pb-3">Daily Rate</th>
                            <th class="pb-3">Compounding Balance</th>
                            <th class="pb-3">Est. 24h Dividend</th>
                            <th class="pb-3">30-Day Lock</th>
                            <th class="pb-3 text-right">Investor Dossier</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-darkBorder">
                        @forelse ($users->take(10) as $u)
                            @php
                                $effRate = $u->effective_daily_rate;
                                $effPkg = $u->effective_package;
                                $isUpgraded = $u->is_tier_upgraded;
                                $estYield = ($u->balance * ($effRate ?: 0)) / 100;
                            @endphp
                            <tr class="hover:bg-natural-darkPaper/40 transition">
                                <td class="py-3.5">
                                    <div class="font-bold text-white">{{ $u->name }}</div>
                                    <div class="text-[11px] text-natural-textMuted font-mono">{{ $u->email }}</div>
                                </td>
                                <td class="py-3.5 font-mono">
                                    @if ($effRate > 0)
                                        <div class="font-bold text-amber-300 flex items-center gap-1.5">
                                            <span>{{ $effPkg?->name ?? 'Active Growth Tier' }}</span>
                                            @if ($isUpgraded)
                                                <span class="text-[9px] bg-amber-400 text-slate-950 font-bold px-1 rounded uppercase tracking-wider">Auto-Upgraded</span>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-stone-500">Unfunded / Inactive</span>
                                    @endif
                                </td>
                                <td class="py-3.5 font-mono">
                                    @if ($effRate > 0)
                                        <span class="text-natural-mint font-bold">+{{ number_format($effRate, 2) }}% / d</span>
                                    @else
                                        <span class="text-stone-500">0.00%</span>
                                    @endif
                                </td>
                                <td class="py-3.5 font-mono font-bold text-white text-sm">
                                    ${{ number_format($u->balance, 2) }}
                                </td>
                                <td class="py-3.5 font-mono text-natural-mint font-bold">
                                    @if ($estYield > 0)
                                        +${{ number_format($estYield, 2) }}
                                    @else
                                        <span class="text-stone-500">$0.00</span>
                                    @endif
                                </td>
                                <td class="py-3.5 font-mono text-[11px]">
                                    @if ($u->isCapitalLocked())
                                        <span class="inline-flex items-center gap-1 text-amber-300 font-bold bg-amber-950/40 border border-amber-500/30 px-2 py-0.5 rounded-md text-[10px]">
                                            <i class="fa-solid fa-lock text-[9px]"></i> {{ $u->daysRemainingLocked() }}d left
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-emerald-400 font-bold bg-emerald-950/40 border border-emerald-500/30 px-2 py-0.5 rounded-md text-[10px]">
                                            <i class="fa-solid fa-lock-open text-[9px]"></i> Unlocked
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 text-right font-mono">
                                    <a href="{{ route('admin.users.show', $u) }}" class="px-3 py-1.5 rounded-xl bg-amber-400/20 hover:bg-amber-400/30 border border-amber-400/40 text-amber-300 text-xs font-bold transition inline-flex items-center gap-1.5">
                                        <i class="fa-solid fa-file-invoice text-xs"></i>
                                        <span>Full Audit & Logs →</span>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-xs text-natural-textMuted font-mono">
                                    No registered investors found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function confirmTriggerDailyRoi() {
            Swal.fire({
                title: 'Trigger 24h Compounding ROI Batch',
                html: '<p class="text-xs text-natural-textMuted">This will compute daily percentage returns on the <strong>total available balance</strong> of every active investor and credit profits directly to their balances.</p>',
                icon: 'question',
                iconColor: '#f59e0b',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#23352B',
                confirmButtonText: 'Yes, Execute 24h Compounding',
                cancelButtonText: 'Cancel',
                customClass: {
                    popup: 'verdant-swal-popup',
                    title: 'verdant-swal-title',
                    htmlContainer: 'verdant-swal-html'
                }
            }).then((res) => {
                if (res.isConfirmed) {
                    document.getElementById('dailyRoiTriggerForm').submit();
                }
            });
        }
    </script>
</x-app-layout>