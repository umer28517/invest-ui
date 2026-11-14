<x-app-layout>
    <div class="space-y-6">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-1">
            <div>
                <h2 class="font-serif font-bold text-xl sm:text-2xl text-white">Deposit Requests Management</h2>
                <p class="text-xs text-natural-textMuted font-mono">Pending Verification & Proof Settlements</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-natural-textMuted hover:text-white bg-natural-darkPaper border border-natural-darkBorder transition flex items-center gap-1.5">
                    <i class="fa-solid fa-chart-line text-[11px]"></i> Overview
                </a>
            </div>
        </div>

        <!-- 4 Metric Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <div class="bg-natural-darkCard rounded-3xl p-6 border {{ $pendingCount > 0 ? 'border-amber-500/50 bg-[#16160F]' : 'border-natural-darkBorder' }} shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider">Pending Verification</span>
                <div class="text-2xl sm:text-3xl font-serif font-bold text-amber-400">{{ $pendingCount }} Requests</div>
                <div class="text-[11px] text-amber-300/80 font-mono flex items-center gap-1">
                    <i class="fa-solid fa-clock"></i> Requires admin cross-check
                </div>
            </div>

            <div class="bg-natural-darkCard rounded-3xl p-6 border border-natural-darkBorder shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider">Approved Deposits</span>
                <div class="text-2xl sm:text-3xl font-serif font-bold text-natural-mint">{{ $approvedCount }} Tiers</div>
                <div class="text-[11px] text-natural-sage font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-circle-check"></i> Actively Compounding
                </div>
            </div>

            <div class="bg-natural-darkCard rounded-3xl p-6 border border-natural-darkBorder shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider">Rejected Submissions</span>
                <div class="text-2xl sm:text-3xl font-serif font-bold text-rose-400">{{ $rejectedCount }} Requests</div>
                <div class="text-[11px] text-natural-textMuted font-mono">
                    Unconfirmed or Invalid Tx
                </div>
            </div>

            <div class="bg-natural-darkCard rounded-3xl p-6 border border-natural-darkBorder shadow-dark-card space-y-2">
                <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider">Total Approved Volume</span>
                <div class="text-2xl sm:text-3xl font-serif font-bold text-white">${{ number_format($totalApprovedVolume, 2) }}</div>
                <div class="text-[11px] text-natural-sage font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-shield-check"></i> In Escrow Yield Pool
                </div>
            </div>
        </div>

        <!-- Filter Tabs & Main Table -->
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder shadow-dark-card p-6 space-y-5">
            
            <!-- Filter Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-natural-darkBorder pb-4">
                <div class="inline-flex items-center gap-1.5 p-1 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder">
                    <a href="{{ route('admin.deposits.index', ['status' => 'all']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'all' ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-natural-textMuted hover:text-white' }}">
                        All Deposits
                    </a>
                    <a href="{{ route('admin.deposits.index', ['status' => 'pending']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $status === 'pending' ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-natural-textMuted hover:text-white' }}">
                        <span>Pending</span>
                        @if ($pendingCount > 0)
                            <span class="px-1.5 py-0.2 rounded-full {{ $status === 'pending' ? 'bg-slate-950 text-amber-300' : 'bg-amber-400 text-slate-950' }} text-[10px] font-mono font-extrabold">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>
                    <a href="{{ route('admin.deposits.index', ['status' => 'approved']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'approved' ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-natural-textMuted hover:text-white' }}">
                        Approved
                    </a>
                    <a href="{{ route('admin.deposits.index', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ $status === 'rejected' ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-natural-textMuted hover:text-white' }}">
                        Rejected
                    </a>
                </div>

                <div class="text-xs text-natural-textMuted font-mono">
                    Showing <strong class="text-white">{{ $deposits->total() }}</strong> total deposit record(s)
                </div>
            </div>

            <!-- Table of Deposits -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-natural-textPrimary font-sans">
                    <thead class="text-natural-textMuted uppercase font-mono tracking-wider border-b border-natural-darkBorder text-[11px]">
                        <tr>
                            <th class="pb-3">ID / Date</th>
                            <th class="pb-3">Investor</th>
                            <th class="pb-3">Package Tier</th>
                            <th class="pb-3">Amount (USD)</th>
                            <th class="pb-3">Binance Pay Proof / TxID</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-darkBorder">
                        @forelse ($deposits as $dep)
                            <tr class="hover:bg-natural-darkPaper/40 transition">
                                
                                <!-- ID / Date -->
                                <td class="py-4 font-mono text-natural-textMuted text-[11px]">
                                    <div class="font-bold text-white">#DEP-{{ $dep->id }}</div>
                                    <div>{{ $dep->created_at->format('M d, Y') }}</div>
                                    <div class="text-[10px] text-stone-500">{{ $dep->created_at->format('H:i:s') }}</div>
                                </td>

                                <!-- Investor -->
                                <td class="py-4">
                                    <div class="font-bold text-white text-sm">{{ $dep->user->name }}</div>
                                    <div class="text-[11px] text-natural-textMuted font-mono">{{ $dep->user->email }}</div>
                                    <div class="text-[10px] text-natural-sage font-mono">User ID: #{{ $dep->user->id }}</div>
                                </td>

                                <!-- Package Tier -->
                                <td class="py-4">
                                    <div class="font-bold text-amber-300">{{ $dep->package->name }}</div>
                                    <div class="text-[10px] text-natural-mint font-mono">+{{ number_format($dep->daily_rate, 2) }}% / day</div>
                                    <div class="text-[10px] text-natural-textMuted">Compounding Base</div>
                                </td>

                                <!-- Amount -->
                                <td class="py-4 font-mono">
                                    <div class="text-base font-bold text-white">${{ number_format($dep->amount, 2) }}</div>
                                    <div class="text-[10px] text-amber-400 font-mono">USD</div>
                                </td>

                                <!-- Binance Proof / Pay ID -->
                                <td class="py-4">
                                    <div class="space-y-1">
                                        <div class="inline-flex items-center gap-1.5 bg-[#0F1813] border border-amber-500/30 px-2.5 py-1 rounded-lg text-amber-300 font-mono font-bold text-xs">
                                            <span>{{ $dep->binance_pay_id ?: 'No Proof Submitted' }}</span>
                                            @if ($dep->binance_pay_id)
                                                <button type="button" onclick="navigator.clipboard.writeText('{{ $dep->binance_pay_id }}'); toastr.success('Proof copied!');" class="text-natural-textMuted hover:text-white transition ml-1" title="Copy">
                                                    <i class="fa-regular fa-copy text-[10px]"></i>
                                                </button>
                                            @endif
                                        </div>
                                        <div class="text-[10px] text-natural-textMuted font-mono">
                                            Via: {{ $dep->payment_method }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Status Badge -->
                                <td class="py-4">
                                    @if ($dep->isPending())
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-400/20 text-amber-300 text-[11px] font-bold border border-amber-400/30">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span> Pending Review
                                        </span>
                                    @elseif ($dep->isApproved())
                                        <div class="space-y-0.5">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-[11px] font-bold border border-emerald-500/30">
                                                <i class="fa-solid fa-check text-[10px]"></i> Approved
                                            </span>
                                            <div class="text-[10px] text-natural-sage font-mono">30-Day Lock Active</div>
                                        </div>
                                    @else
                                        <div class="space-y-0.5">
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-rose-500/20 text-rose-300 text-[11px] font-bold border border-rose-500/30">
                                                <i class="fa-solid fa-xmark text-[10px]"></i> Rejected
                                            </span>
                                            @if ($dep->rejection_reason)
                                                <div class="text-[10px] text-rose-300/70 truncate max-w-xs">{{ $dep->rejection_reason }}</div>
                                            @endif
                                        </div>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="py-4 text-right">
                                    @if ($dep->isPending())
                                        <div class="inline-flex items-center gap-1.5">
                                            <!-- Approve Icon Button -->
                                            <form method="POST" action="{{ route('admin.deposits.approve', $dep->id) }}" onsubmit="return confirm('Approve deposit of ${{ $dep->amount }} USD for {{ $dep->user->name }}?\n\nThis will:\n1. Credit ${{ $dep->amount }} to compounding balance\n2. Activate {{ $dep->package->name }} (+{{ $dep->daily_rate }}%/day)\n3. Enforce 30-day capital lock')">
                                                @csrf
                                                <button type="submit" title="Approve Deposit" class="w-8 h-8 rounded-xl bg-emerald-500/20 hover:bg-emerald-500 text-emerald-400 hover:text-slate-950 border border-emerald-500/40 flex items-center justify-center transition shadow-xs cursor-pointer">
                                                    <i class="fa-solid fa-check text-xs"></i>
                                                </button>
                                            </form>

                                            <!-- Reject Icon Button -->
                                            <form method="POST" action="{{ route('admin.deposits.reject', $dep->id) }}" onsubmit="return confirm('Reject this deposit request?')">
                                                @csrf
                                                <button type="submit" title="Reject Deposit" class="w-8 h-8 rounded-xl bg-rose-500/20 hover:bg-rose-500 text-rose-300 hover:text-white border border-rose-500/40 flex items-center justify-center transition shadow-xs cursor-pointer">
                                                    <i class="fa-solid fa-xmark text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="text-xs text-natural-textMuted font-mono">
                                            Settled {{ $dep->updated_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-xs text-natural-textMuted font-mono">
                                    <div class="space-y-1">
                                        <i class="fa-solid fa-inbox text-2xl text-stone-600 block mb-2"></i>
                                        <div>No deposit requests found in this filter category.</div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($deposits->hasPages())
                <div class="pt-4 border-t border-natural-darkBorder">
                    {{ $deposits->links() }}
                </div>
            @endif

        </div>

    </div>
</x-app-layout>