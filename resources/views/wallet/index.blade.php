<x-app-layout>
    @php
        $withdrawable = $user->getWithdrawableBalance();
        $canWithdraw = $withdrawable >= 10;
    @endphp
    <div class="space-y-6">

        <!-- 30-Day Capital Lock Alert Banner (if locked) -->
        @if ($user->isCapitalLocked())
            <div class="bg-gradient-to-r from-amber-950/60 via-[#261E10] to-amber-950/40 p-5 sm:p-6 rounded-3xl border border-amber-500/40 shadow-xl space-y-2">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[10px] font-bold uppercase tracking-wider font-mono">
                        <i class="fa-solid fa-lock text-[9px]"></i> 30-Day Principal Lock Active
                    </span>
                    <span class="text-xs text-amber-300 font-mono font-bold">
                        {{ $user->daysRemainingLocked() }} day(s) remaining until {{ $user->locked_until->format('M d, Y') }}
                    </span>
                </div>
                <h3 class="text-white font-serif font-bold text-lg">Base Deposit Locked (${{ number_format($user->locked_principal, 2) }} USD) • Daily Profit Withdrawable Anytime</h3>
                <p class="text-xs text-amber-200/90 leading-relaxed max-w-3xl">
                    Your base deposited capital of <strong>${{ number_format($user->locked_principal, 2) }} USD</strong> is locked for 30 days to facilitate continuous compounding. 
                    <strong class="text-white">Daily Profit:</strong> You can withdraw all accrued daily profits earned on top of your base capital anytime ($10 minimum limit)!
                    Current withdrawable profit: <strong class="text-natural-mint font-mono">${{ number_format($withdrawable, 2) }} USD</strong>.
                </p>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Left: Cashout Form -->
            <div class="lg:col-span-7 bg-natural-darkCard rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-dark-card space-y-6">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-natural-forest/30 border border-natural-moss/40 text-natural-mint text-xs font-bold">
                        <i class="fa-solid fa-circle-check text-natural-sage"></i> Instant Payouts • Low $10.00 Minimum
                    </div>
                    <h2 class="font-serif font-bold text-2xl sm:text-3xl text-white">Request Instant Withdrawal</h2>
                    <p class="text-xs text-natural-textMuted">Withdraw available profit or unlocked balance to your verified Binance Pay ID or BEP-20 address.</p>
                </div>

                <form method="POST" action="{{ route('wallet.cashout') }}" class="space-y-4">
                    @csrf

                    <div>
                        <div class="flex justify-between text-xs mb-1.5">
                            <span class="font-bold text-natural-textPrimary">Total Compounding Balance</span>
                            <span class="text-natural-sage font-mono font-bold text-sm">${{ number_format($user->balance, 2) }} USD</span>
                        </div>
                        @if ($user->isCapitalLocked())
                            <div class="flex justify-between text-xs mb-1 text-natural-textMuted font-mono">
                                <span>Base Locked Principal:</span>
                                <span class="text-amber-400 font-bold">${{ number_format($user->locked_principal, 2) }} USD</span>
                            </div>
                            <div class="flex justify-between text-xs mb-2 font-mono">
                                <span class="text-white font-bold">Withdrawable Profit Balance:</span>
                                <span class="text-natural-mint font-bold">${{ number_format($withdrawable, 2) }} USD</span>
                            </div>
                        @endif
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-natural-textMuted font-bold font-mono">$</span>
                            <input type="number" 
                                   name="amount" 
                                   id="withdrawAmount" 
                                   min="10" 
                                   max="{{ $withdrawable }}" 
                                   step="0.01" 
                                   value="{{ $canWithdraw ? min(50, $withdrawable) : 10 }}" 
                                   {{ $canWithdraw ? 'required' : 'disabled' }} 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl pl-8 pr-4 py-3.5 text-sm font-mono text-white focus:border-amber-400 focus:outline-none transition {{ $canWithdraw ? '' : 'opacity-50 cursor-not-allowed' }}">
                        </div>
                        <div class="flex items-center justify-between text-[11px] pt-1">
                            <span class="text-natural-mint font-semibold flex items-center gap-1">
                                <i class="fa-solid fa-check text-[10px]"></i> Minimum withdrawal limit is $10.00 USD.
                            </span>
                            @if (($withdrawalFeePercent ?? 0) > 0)
                                <span class="text-amber-300 font-mono font-bold">
                                    Fee: {{ number_format($withdrawalFeePercent, 2) }}% (Net Payout)
                                </span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5 font-mono">Binance Payout Method</label>
                        <select name="payout_method" id="withdrawMethod" {{ $canWithdraw ? 'required' : 'disabled' }} class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 text-xs text-white focus:border-amber-400 focus:outline-none transition {{ $canWithdraw ? '' : 'opacity-50 cursor-not-allowed' }}">
                            <option value="Binance Pay ID">Binance Pay ID (Direct Internal 0% Fee)</option>
                            <option value="Binance USDT (BEP-20)">Binance USDT - BNB Smart Chain (BEP-20)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5 font-mono">Destination Account / Pay ID / Wallet Address</label>
                        <input type="text" 
                               name="destination_account" 
                               id="withdrawWallet" 
                               placeholder="e.g. 829104812 or 0x..." 
                               {{ $canWithdraw ? 'required' : 'disabled' }} 
                               class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 text-xs font-mono text-white placeholder-natural-textMuted/40 focus:border-amber-400 focus:outline-none transition {{ $canWithdraw ? '' : 'opacity-50 cursor-not-allowed' }}">
                    </div>

                    @if ($canWithdraw)
                        <button type="submit" class="w-full py-4 rounded-2xl font-bold text-xs uppercase tracking-wider text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:brightness-105 transition shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Submit Binance Cashout Request (${{ number_format($withdrawable, 2) }} Available)</span>
                        </button>
                    @else
                        <button type="button" disabled class="w-full py-4 rounded-2xl font-bold text-xs uppercase tracking-wider text-slate-400 bg-stone-800 border border-stone-700 cursor-not-allowed flex items-center justify-center gap-2">
                            <i class="fa-solid fa-lock"></i>
                            @if ($user->isCapitalLocked())
                                <span>Base Locked • Accrued Profit (${{ number_format($withdrawable, 2) }} / $10 Min)</span>
                            @else
                                <span>Minimum Cashout is $10.00 USD</span>
                            @endif
                        </button>
                    @endif
                </form>
            </div>

            <!-- Right: Rules & Verification Info -->
            <div class="lg:col-span-5 space-y-5">
                <div class="bg-natural-darkCard rounded-3xl p-6 border border-natural-darkBorder shadow-dark-card space-y-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-400/20 text-amber-400 flex items-center justify-center font-bold">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3 class="font-serif font-bold text-lg text-white">Institutional Cashout Rules</h3>
                    <ul class="text-xs text-natural-textMuted space-y-3 font-mono">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-check text-natural-sage mt-0.5 shrink-0"></i>
                            <span><strong>30-Day Lock Term:</strong> Deposited funds compound daily for 30 days before withdrawals unlock.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-check text-natural-sage mt-0.5 shrink-0"></i>
                            <span><strong>$10.00 Minimum Limit:</strong> Request cashouts anytime starting at just $10.00 once unlocked.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-circle-check text-natural-sage mt-0.5 shrink-0"></i>
                            <span><strong>Binance Pay Priority:</strong> 0% transaction deductions when settling via Binance Pay ID.</span>
                        </li>
                    </ul>
                </div>

                <div class="bg-natural-darkCard rounded-3xl p-6 border border-natural-darkBorder shadow-dark-card space-y-2">
                    <div class="text-xs text-natural-textMuted font-mono">Lifetime Total Withdrawn</div>
                    <div class="text-3xl font-serif font-bold text-natural-mint">${{ number_format($user->withdrawn_total, 2) }}</div>
                    <div class="text-[11px] text-natural-textMuted">Successfully processed and transferred to your destination.</div>
                </div>
            </div>

        </div>

        <!-- User Withdrawal History Table -->
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder shadow-dark-card p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-natural-darkBorder pb-4">
                <div>
                    <h3 class="font-serif font-bold text-lg text-white">Your Cashout History</h3>
                    <p class="text-xs text-natural-textMuted">Recent withdrawal requests and settlement statuses</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-natural-textPrimary font-mono">
                    <thead class="text-natural-textMuted uppercase tracking-wider border-b border-natural-darkBorder text-[11px]">
                        <tr>
                            <th class="pb-3">Request ID</th>
                            <th class="pb-3">Amount</th>
                            <th class="pb-3">Payout Method</th>
                            <th class="pb-3">Destination</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-darkBorder">
                        @forelse ($withdrawals as $w)
                            <tr class="hover:bg-natural-darkPaper/40 transition">
                                <td class="py-3 text-white">#WTH-{{ $w->id }}</td>
                                <td class="py-3 font-bold text-amber-300">
                                    ${{ number_format($w->amount, 2) }}
                                    @if ($w->fee_amount > 0)
                                        <div class="text-[10px] text-natural-textMuted font-mono font-normal">Net: ${{ number_format($w->net_amount, 2) }} (-{{ $w->fee_percent }}%)</div>
                                    @endif
                                </td>
                                <td class="py-3 text-natural-textMuted">{{ $w->payout_method }}</td>
                                <td class="py-3 text-white truncate max-w-xs">{{ $w->destination_account }}</td>
                                <td class="py-3">
                                    @if ($w->isPending())
                                        <span class="px-2 py-0.5 rounded-full bg-amber-400/20 text-amber-300 text-[10px] font-bold">Pending Review</span>
                                    @elseif ($w->isApproved())
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 text-[10px] font-bold">Paid</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-rose-500/20 text-rose-300 text-[10px] font-bold">Rejected</span>
                                    @endif
                                </td>
                                <td class="py-3 text-right text-natural-textMuted text-[11px]">
                                    {{ $w->created_at->format('M d, Y H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-xs text-natural-textMuted">
                                    No cashout requests yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>