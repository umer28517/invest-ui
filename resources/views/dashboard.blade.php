<x-app-layout>
    <div class="space-y-12 max-w-7xl mx-auto pb-16">

        <!-- ================= FLASH NOTIFICATIONS ================= -->
        @if (session('status'))
            <div class="p-4 rounded-2xl bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-xs sm:text-sm font-semibold flex items-center gap-3 shadow-lg">
                <i class="fa-solid fa-circle-check text-emerald-400 text-base shrink-0"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="p-4 rounded-2xl bg-rose-950/60 border border-rose-500/40 text-rose-300 text-xs sm:text-sm font-semibold flex items-center gap-3 shadow-lg">
                <i class="fa-solid fa-triangle-exclamation text-rose-400 text-base shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 rounded-2xl bg-rose-950/60 border border-rose-500/40 text-rose-300 text-xs sm:text-sm font-semibold space-y-1 shadow-lg">
                <div class="flex items-center gap-2 font-bold">
                    <i class="fa-solid fa-circle-xmark text-rose-400"></i>
                    <span>Please correct the errors below:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-0.5 pl-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $effectiveRate = $user->effective_daily_rate;
            $effectivePkg = $user->effective_package;
            $isUpgraded = $user->is_tier_upgraded;
            $dailyEstYield = ($user->balance * ($effectiveRate ?: 0)) / 100;
            $maxWithdrawable = $user->getWithdrawableBalance();
        @endphp

        <!-- ================= SECTION 1: TOP INVESTOR STATS & MASTER OVERVIEW ================= -->
        <section id="overview" class="space-y-6 scroll-mt-20">
            
            <!-- Master Greeting & Lock Status Header -->
            <div class="bg-gradient-to-br from-[#122019] via-[#0E1813] to-[#0A120E] text-white rounded-3xl p-6 sm:p-8 relative overflow-hidden shadow-2xl border border-natural-moss/40">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-white/[0.08] pb-6">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-amber-400 to-amber-500 text-slate-950 flex items-center justify-center font-bold text-lg shadow-lg shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="text-[11px] uppercase tracking-wider text-natural-textMuted font-mono flex items-center gap-2">
                                <span>{{ cms('dashboard.header.investor_badge', 'Verified Investor') }}</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span class="text-emerald-400 lowercase font-sans">active account</span>
                            </div>
                            <h1 class="font-serif font-bold text-xl sm:text-2xl text-white">
                                {{ cms('dashboard.header.welcome_text', 'Welcome back') }}, {{ $user->name }}
                            </h1>
                        </div>
                    </div>

                    <!-- Escrow Lock Status Pill -->
                    <div>
                        @if ($user->isCapitalLocked())
                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-amber-400/15 border border-amber-400/30 text-amber-300 text-xs font-bold font-mono shadow-sm">
                                <i class="fa-solid fa-lock text-[11px]"></i>
                                <span>45-Day Escrow Lock ({{ $user->daysRemainingLocked() }}d remaining)</span>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 text-xs font-bold font-mono shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>Capital Unlocked ($10 Min Cashout)</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- 4 High-Impact Metric Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-6">
                    
                    <!-- Card 1: Total Active Balance -->
                    <div class="bg-black/35 backdrop-blur-md p-5 rounded-2xl border border-white/[0.08] space-y-3 flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] text-natural-textMuted uppercase font-bold tracking-wider font-mono block">
                                {{ cms('dashboard.balance.title', 'Total Active Balance') }}
                            </span>
                            <div class="text-3xl font-serif font-extrabold text-white tracking-tight mt-1">
                                ${{ number_format($user->balance, 2) }}
                                <span class="text-xs font-sans font-normal text-natural-textMuted">USD</span>
                            </div>
                            <p class="text-[10px] text-natural-sage font-mono mt-1">
                                <i class="fa-solid fa-rotate text-[9px]"></i> 24h compounding balance
                            </p>
                        </div>
                        <div class="flex items-center gap-2 pt-2 border-t border-white/[0.06]">
                            <a href="#deposit" class="flex-1 py-2 px-2 rounded-xl text-center font-bold text-[11px] uppercase tracking-wider text-slate-950 bg-amber-400 hover:bg-amber-300 transition shadow-sm">
                                Deposit
                            </a>
                            <a href="#cashout" class="flex-1 py-2 px-2 rounded-xl text-center font-bold text-[11px] uppercase tracking-wider text-white bg-white/[0.08] hover:bg-white/[0.15] border border-white/[0.12] transition">
                                Cashout
                            </a>
                        </div>
                    </div>

                    <!-- Card 2: Total Earnings -->
                    <div class="bg-black/35 backdrop-blur-md p-5 rounded-2xl border border-white/[0.08] space-y-3 flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] text-natural-textMuted uppercase font-bold tracking-wider font-mono block">
                                Total Profit Earned
                            </span>
                            <div class="text-3xl font-serif font-extrabold text-natural-mint tracking-tight mt-1 font-mono">
                                +${{ number_format($totalEarnings, 2) }}
                            </div>
                            <p class="text-[10px] text-natural-mintText font-mono mt-1">
                                Expected: +${{ number_format($dailyEstYield, 2) }} / day
                            </p>
                        </div>
                        <div class="text-[11px] text-natural-textMuted font-mono pt-2 border-t border-white/[0.06] flex items-center justify-between">
                            <span>Withdrawn:</span>
                            <span class="text-white font-bold">${{ number_format($user->withdrawn_total, 2) }}</span>
                        </div>
                    </div>

                    <!-- Card 3: Referral Network -->
                    <div class="bg-black/35 backdrop-blur-md p-5 rounded-2xl border border-white/[0.08] space-y-3 flex flex-col justify-between">
                        <div>
                            <span class="text-[11px] text-natural-textMuted uppercase font-bold tracking-wider font-mono block">
                                {{ cms('dashboard.referral.title', '3-Tier Referral Link') }}
                            </span>
                            <div class="text-3xl font-serif font-extrabold text-amber-400 tracking-tight mt-1 font-mono">
                                {{ $referralCount }}
                                <span class="text-xs font-sans font-normal text-natural-textMuted">Partner(s)</span>
                            </div>
                            <p class="text-[10px] text-amber-300/80 font-mono mt-1">
                                Direct Commission: {{ number_format($referralRate, 1) }}%
                            </p>
                        </div>
                        <div class="pt-2 border-t border-white/[0.06]">
                            <button type="button" onclick="copyRefLink('{{ url('/register') }}?ref={{ $user->referral_code }}')" class="w-full py-1.5 px-2 rounded-xl text-center font-bold text-[11px] text-white bg-natural-forest hover:bg-natural-moss transition flex items-center justify-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-copy text-[10px]"></i>
                                <span id="quickCopyBtnText">Copy Invite Link</span>
                            </button>
                        </div>
                    </div>

                    <!-- Card 4: Current Growth Plan -->
                    <div class="bg-black/35 backdrop-blur-md p-5 rounded-2xl border border-white/[0.08] space-y-3 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="text-[11px] text-natural-textMuted uppercase font-bold tracking-wider font-mono block">Active Package</span>
                                @if ($isUpgraded)
                                    <span class="text-[9px] font-bold text-amber-300 bg-amber-950/80 border border-amber-500/40 px-1.5 py-0.5 rounded font-mono">
                                        Auto-Upgraded
                                    </span>
                                @endif
                            </div>
                            <div class="text-2xl font-serif font-bold text-white tracking-tight mt-1 truncate">
                                {{ $effectivePkg?->name ?? $user->activePackage?->name ?? 'Ready to Invest' }}
                            </div>
                            <p class="text-[10px] text-natural-sage font-mono mt-1">
                                Rate: +{{ number_format($effectiveRate ?: 0, 2) }}% daily profit
                            </p>
                        </div>
                        <div class="text-[11px] text-natural-textMuted font-mono pt-2 border-t border-white/[0.06] flex items-center justify-between">
                            <span>Withdrawable Now:</span>
                            <span class="text-emerald-400 font-bold">${{ number_format($maxWithdrawable, 2) }}</span>
                        </div>
                    </div>

                </div>

            </div>

        </section>

        <!-- ================= SECTION: 24-HOUR AI ARBITRAGE TRADE TERMINAL ================= -->
        <section id="trade" class="space-y-6 scroll-mt-20">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 border-b border-natural-darkBorder pb-4">
                <div>
                    <span class="text-xs font-mono font-bold text-amber-400 uppercase tracking-widest flex items-center gap-1.5">
                        <i class="fa-solid fa-chart-line"></i> Quantum Liquidity Engine
                    </span>
                    <h2 class="font-serif font-bold text-2xl sm:text-3xl text-white mt-1">
                        24-Hour AI Arbitrage Trade Terminal
                    </h2>
                    <p class="text-xs sm:text-sm text-natural-textMuted max-w-2xl mt-0.5">
                        Initiate a 30-minute AI algorithmic trade session every 24 hours. Your balance is safely frozen in live liquidity pools during the 30-minute execution window, yielding randomized dynamic returns upon completion.
                    </p>
                </div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-amber-400/10 border border-amber-400/30 text-amber-300 text-xs font-mono font-bold">
                    <i class="fa-solid fa-bolt"></i> 30-Minute Cycle Window
                </div>
            </div>

            <!-- Trade Terminal Card -->
            <div class="bg-gradient-to-br from-[#0F1914] via-[#0C1410] to-[#080E0B] rounded-3xl p-6 sm:p-8 border border-amber-500/30 shadow-2xl relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

                @php
                    $isTradeRunning = $user->isTradeRunning();
                    $activeTradeSession = $user->activeTradeSession();
                    $canUserTrade = $user->canTrade();
                    $secondsToNextTrade = $user->secondsUntilNextTrade();
                    $tradeSecsRemaining = $activeTradeSession ? $activeTradeSession->secondsRemaining() : 0;
                    $tradeRangeText = ($user->activePackage?->trade_profit_range_text ?? '+1.75% – 2.00%');
                @endphp

                @if ($isTradeRunning && $activeTradeSession)
                    <!-- STATE 1: TRADE CURRENTLY RUNNING (30-MIN BALANCE FREEZE) -->
                    <div class="space-y-6 relative z-10">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-4 rounded-2xl bg-amber-400/10 border border-amber-400/30">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-400/20 text-amber-400 flex items-center justify-center font-bold text-lg animate-spin">
                                    <i class="fa-solid fa-rotate"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-mono font-bold text-amber-300 uppercase tracking-wider">
                                        Live Algorithmic Trade in Progress
                                    </div>
                                    <div class="text-sm font-bold text-white mt-0.5">
                                        Active Balance Frozen in Liquidity Pools for 30 Minutes
                                    </div>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="text-[10px] font-mono text-natural-textMuted uppercase block">Trade Profit Target</span>
                                <span class="text-lg font-mono font-extrabold text-amber-300">+{{ $activeTradeSession->rate_percent }}%</span>
                            </div>
                        </div>

                        <!-- Big Live 30-Min Countdown Clock -->
                        <div class="bg-black/50 rounded-2xl p-6 border border-white/[0.08] text-center space-y-3">
                            <span class="text-xs font-mono uppercase tracking-widest text-natural-textMuted font-bold block">
                                Trade Settlement Countdown (30:00 Cycle)
                            </span>
                            <div id="tradeCountdownDisplay" class="text-4xl sm:text-6xl font-mono font-extrabold text-white tracking-wider">
                                --:--
                            </div>
                            <p class="text-xs text-natural-sage font-mono">
                                Frozen Capital: <strong>${{ number_format($activeTradeSession->amount, 2) }} USD</strong> &bull; Completes in approx 30 minutes
                            </p>

                            <!-- Progress Bar -->
                            <div class="w-full bg-natural-darkBorder rounded-full h-2 overflow-hidden mt-2">
                                <div id="tradeProgressBar" class="bg-gradient-to-r from-amber-400 to-emerald-400 h-2 rounded-full transition-all duration-1000" style="width: 50%;"></div>
                            </div>
                        </div>

                        <!-- Auto-Settlement / Manual Claim Form -->
                        <div class="flex items-center justify-center pt-2">
                            <form method="POST" action="{{ route('trades.settle') }}" id="settleTradeForm">
                                @csrf
                                <button type="submit" id="claimTradeProfitBtn" class="px-8 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 bg-amber-400 hover:bg-amber-300 transition shadow-lg flex items-center gap-2 cursor-pointer">
                                    <i class="fa-solid fa-hand-holding-dollar text-sm"></i>
                                    <span>Check & Settle Completed Trade</span>
                                </button>
                            </form>
                        </div>
                    </div>

                @elseif ($canUserTrade)
                    <!-- STATE 2: 24-HOUR COUNTDOWN COMPLETE -> READY TO EXECUTE TRADE! -->
                    <div class="space-y-6 relative z-10">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-black/40 p-5 rounded-2xl border border-white/[0.08] space-y-1">
                                <span class="text-[10px] text-natural-textMuted uppercase font-mono font-bold block">Capital for Trade</span>
                                <div class="text-2xl font-serif font-extrabold text-white font-mono">
                                    ${{ number_format($user->balance, 2) }} <span class="text-xs font-normal text-natural-textMuted">USD</span>
                                </div>
                                <p class="text-[10px] text-emerald-400 font-mono">100% Active Compounding Principal</p>
                            </div>

                            <div class="bg-black/40 p-5 rounded-2xl border border-white/[0.08] space-y-1">
                                <span class="text-[10px] text-natural-textMuted uppercase font-mono font-bold block">30m Trade Profit Range</span>
                                <div class="text-2xl font-serif font-extrabold text-natural-mint font-mono">
                                    {{ $tradeRangeText }}
                                </div>
                                <p class="text-[10px] text-natural-textMuted font-mono">Randomly calculated per session</p>
                            </div>

                            <div class="bg-black/40 p-5 rounded-2xl border border-white/[0.08] space-y-1">
                                <span class="text-[10px] text-natural-textMuted uppercase font-mono font-bold block">Execution Term</span>
                                <div class="text-2xl font-serif font-extrabold text-amber-300 font-mono">
                                    30 Minutes
                                </div>
                                <p class="text-[10px] text-amber-400/80 font-mono">Temporary Balance Freeze Window</p>
                            </div>
                        </div>

                        <!-- Big Action Button to Initiate Trade -->
                        <div class="p-5 rounded-2xl bg-emerald-950/30 border border-emerald-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div>
                                <h4 class="text-sm font-bold text-white flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    <span>24-Hour Cycle Complete — Arbitrage Session Available!</span>
                                </h4>
                                <p class="text-xs text-natural-textMuted mt-1">
                                    Clicking Execute will freeze your balance for exactly 30 minutes. Upon completion, your balance unfreezes with randomized {{ $tradeRangeText }} yield added.
                                </p>
                            </div>
                            <form method="POST" action="{{ route('trades.execute') }}" class="shrink-0">
                                @csrf
                                <button type="submit" class="px-8 py-4 rounded-xl font-bold text-xs sm:text-sm uppercase tracking-wider text-slate-950 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:brightness-110 transition shadow-xl flex items-center gap-2 cursor-pointer">
                                    <i class="fa-solid fa-bolt text-sm"></i>
                                    <span>Execute 30m Trade Now</span>
                                </button>
                            </form>
                        </div>
                    </div>

                @elseif ($user->active_package_id === null && ! $user->deposits()->where('status', 'approved')->exists())
                    <!-- STATE 3: NO ACTIVE PACKAGE YET -->
                    <div class="p-6 rounded-2xl bg-black/40 border border-white/[0.08] text-center space-y-3 relative z-10">
                        <div class="w-12 h-12 rounded-2xl bg-natural-darkPaper text-natural-sage border border-natural-darkBorder flex items-center justify-center mx-auto text-xl">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <h4 class="font-serif font-bold text-lg text-white">Active Package Required to Unlock Trading</h4>
                        <p class="text-xs text-natural-textMuted max-w-md mx-auto">
                            Subscribe to any of the 7 investment tiers below to activate your account and start triggering 24-hour algorithmic trade sessions.
                        </p>
                        <a href="#packages" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-950 bg-amber-400 hover:bg-amber-300 transition shadow-sm">
                            <span>View Investment Packages</span>
                            <i class="fa-solid fa-arrow-down text-[10px]"></i>
                        </a>
                    </div>

                @else
                    <!-- STATE 4: 24-HOUR COOLING PERIOD ACTIVE -->
                    <div class="space-y-5 relative z-10">
                        <div class="p-6 rounded-2xl bg-black/40 border border-white/[0.08] text-center space-y-3">
                            <span class="text-xs font-mono uppercase tracking-widest text-natural-textMuted font-bold block">
                                24-Hour Trade Cooling Period Active
                            </span>
                            <div id="coolingCountdownDisplay" class="text-3xl sm:text-5xl font-mono font-extrabold text-amber-300 tracking-wider">
                                --:--:--
                            </div>
                            <p class="text-xs text-natural-textMuted font-mono">
                                Next 30-minute trade session opens automatically once the countdown reaches zero.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-mono">
                            <div class="p-4 rounded-xl bg-natural-darkPaper border border-natural-darkBorder flex items-center justify-between">
                                <span class="text-natural-textMuted">Expected Trade Yield:</span>
                                <span class="text-natural-mint font-bold">{{ $tradeRangeText }}</span>
                            </div>
                            <div class="p-4 rounded-xl bg-natural-darkPaper border border-natural-darkBorder flex items-center justify-between">
                                <span class="text-natural-textMuted">Session Duration:</span>
                                <span class="text-white font-bold">30 Minutes Freeze</span>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </section>

        <!-- ================= SECTION 2: INVESTMENT PACKAGES SLIDER & TIERS ================= -->
        <section id="packages" class="space-y-6 scroll-mt-20">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 border-b border-natural-darkBorder pb-4">
                <div>
                    <span class="text-xs font-mono font-bold text-natural-mint uppercase tracking-widest flex items-center gap-1.5">
                        <i class="fa-solid fa-layer-group"></i> Sustainable Growth Plans
                    </span>
                    <h2 class="font-serif font-bold text-2xl sm:text-3xl text-white mt-1">
                        Investment Packages & Daily Compounding Tiers
                    </h2>
                    <p class="text-xs sm:text-sm text-natural-textMuted max-w-2xl mt-0.5">
                        Select a package tier to view its guaranteed daily percentage profit. Clicking any plan automatically configures your deposit cashier below.
                    </p>
                </div>
                <div class="text-xs font-mono text-natural-sage font-semibold shrink-0">
                    <i class="fa-solid fa-clock-rotate-left"></i> Credited Every 24h
                </div>
            </div>

            <!-- Packages Slider / Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
                @forelse ($packages as $pIndex => $pkg)
                    @php
                        $isFeatured = $pIndex === 1;
                        $termDays = 30;
                        $projectedProfit = $pkg->daily_commission_percent * $termDays;
                    @endphp
                    <div class="bg-natural-darkCard rounded-3xl p-6 border transition-all duration-300 flex flex-col justify-between relative group hover:border-natural-sage {{ $isFeatured ? 'border-2 border-natural-forest shadow-dark-card scale-[1.02]' : 'border-natural-darkBorder' }}">
                        @if ($isFeatured)
                            <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 rounded-full bg-natural-forest text-natural-mint text-[10px] font-bold uppercase tracking-wider font-mono border border-natural-moss/50 shadow-md">
                                Popular Plan
                            </div>
                        @endif

                        <div class="space-y-4">
                            <!-- Tier Level & Price -->
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-natural-darkPaper text-natural-sage border border-natural-darkBorder">
                                    Tier {{ sprintf('%02d', $pIndex + 1) }}
                                </span>
                                <span class="text-xs font-mono text-natural-textMuted">
                                    Min. ${{ number_format($pkg->min_withdrawal_limit ?: 10, 0) }} Cashout
                                </span>
                            </div>

                            <div>
                                <h3 class="font-serif font-bold text-xl text-white">{{ $pkg->name }}</h3>
                                <p class="text-[11px] text-natural-textMuted mt-1 line-clamp-2">
                                    {{ $pkg->description ?: 'Automated 24-hour compounding daily returns with full escrow capital protection.' }}
                                </p>
                            </div>

                            <!-- Big Rate Box -->
                            <div class="bg-natural-darkPaper p-4 rounded-2xl border border-natural-darkBorder space-y-1">
                                <div class="text-2xl sm:text-3xl font-serif font-bold text-natural-mint font-mono">
                                    {{ $pkg->daily_profit_range_text }}
                                    <span class="text-xs font-sans font-medium text-natural-textMuted">/ day</span>
                                </div>
                                <div class="text-xs text-natural-textPrimary font-mono font-semibold">
                                    Dynamic Daily Return (24h Random Range)
                                </div>
                            </div>

                            <!-- Package Specs Table -->
                            <ul class="space-y-2.5 text-xs text-natural-textPrimary font-mono pt-1">
                                <li class="flex items-center justify-between pb-2 border-b border-natural-darkBorder/60">
                                    <span class="text-natural-textMuted font-sans">Price Range:</span>
                                    <span class="font-bold text-white">{{ $pkg->price_range_text }}</span>
                                </li>
                                <li class="flex items-center justify-between pb-2 border-b border-natural-darkBorder/60">
                                    <span class="text-natural-textMuted font-sans">Payout Cycle:</span>
                                    <span class="text-natural-sage font-bold">Every 24 Hours</span>
                                </li>
                                <li class="flex items-center justify-between pb-2 border-b border-natural-darkBorder/60">
                                    <span class="text-natural-textMuted font-sans">Capital Lock:</span>
                                    <span class="text-white font-bold">45 Days Escrow</span>
                                </li>
                                <li class="flex items-center justify-between pb-2 border-b border-natural-darkBorder/60">
                                    <span class="text-natural-textMuted font-sans">Referral Commission:</span>
                                    <span class="text-amber-400 font-bold">+{{ number_format($pkg->referral_commission_percent ?? 5.00, 0) }}% 1-Time</span>
                                </li>
                                <li class="flex items-center justify-between">
                                    <span class="text-natural-textMuted font-sans">Daily Profit Cashout:</span>
                                    <span class="text-natural-mint font-bold">Anytime ($10 Min)</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-6 mt-4 border-t border-natural-darkBorder">
                            <button type="button" 
                                    onclick="selectPackageForDeposit({{ $pkg->id }}, '{{ addslashes($pkg->name) }}', {{ (float)$pkg->effective_min_investment }}, {{ (float)$pkg->effective_max_investment }}, '{{ addslashes($pkg->price_range_text) }}')"
                                    class="w-full py-3 rounded-xl font-bold text-xs uppercase tracking-wider {{ $isFeatured ? 'bg-natural-forest text-white hover:bg-natural-moss shadow-natural-btn' : 'bg-natural-darkPaper text-natural-textPrimary hover:bg-natural-darkCard hover:text-white border border-natural-darkBorder' }} transition flex items-center justify-center gap-2 cursor-pointer">
                                <span>Select & Deposit</span>
                                <i class="fa-solid fa-arrow-down text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 p-8 text-center bg-natural-darkCard rounded-3xl border border-natural-darkBorder text-natural-textMuted">
                        No active investment packages available at the moment.
                    </div>
                @endforelse
            </div>

        </section>

        <!-- ================= SECTION 3: DEPOSIT CAPITAL CASHIER ================= -->
        <section id="deposit" class="space-y-6 scroll-mt-20">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 border-b border-natural-darkBorder pb-4">
                <div>
                    <span class="text-xs font-mono font-bold text-amber-400 uppercase tracking-widest flex items-center gap-1.5">
                        <i class="fa-solid fa-wallet"></i> Binance Pay Cashier
                    </span>
                    <h2 class="font-serif font-bold text-2xl sm:text-3xl text-white mt-1">
                        Deposit Capital & Activate Compounding
                    </h2>
                    <p class="text-xs sm:text-sm text-natural-textMuted max-w-2xl mt-0.5">
                        Transfer the package amount via Binance Pay QR Scan or Pay ID, then submit your transaction reference proof below.
                    </p>
                </div>
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-400/10 border border-amber-400/30 text-amber-300 text-xs font-mono font-bold">
                    <i class="fa-solid fa-receipt"></i> 2.0% Deposit Processing Fee
                </div>
            </div>

            <!-- Cashier Card Form Container -->
            <div class="bg-[#0B0F0D] rounded-3xl p-6 sm:p-8 border border-amber-500/30 shadow-2xl space-y-7 relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-80 h-80 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

                <!-- 1. Payment Methods Selection -->
                <div class="space-y-3 relative z-10">
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-200">
                        1. Select Binance Payment Method <span class="text-amber-400">*</span>
                    </label>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <button type="button" onclick="setCashierMethod('Binance Pay (QR)', this)" class="deposit-method-btn relative p-4 rounded-2xl bg-gradient-to-r from-[#17261E] to-[#121E18] border-2 border-amber-400 text-left transition flex items-center justify-between group shadow-md" data-method="Binance Pay (QR)">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-400/20 text-amber-400 border border-amber-400/30 flex items-center justify-center font-bold text-base shrink-0">
                                    <i class="fa-solid fa-qrcode"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-white text-xs sm:text-sm">Binance Pay (QR)</div>
                                    <div class="text-[10px] text-natural-textMuted">Instant Mobile Scan</div>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[10px] font-bold font-mono">Free</span>
                        </button>

                        <button type="button" onclick="setCashierMethod('Binance Pay ID', this)" class="deposit-method-btn relative p-4 rounded-2xl bg-[#141916] border border-white/[0.08] hover:border-amber-400/50 text-left transition flex items-center justify-between group" data-method="Binance Pay ID">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center font-bold text-base shrink-0">
                                    <i class="fa-solid fa-id-card"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-white text-xs sm:text-sm">Binance Pay ID</div>
                                    <div class="text-[10px] text-natural-textMuted">Internal User Transfer</div>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded-full bg-white/[0.06] text-amber-300 text-[10px] font-bold font-mono">0% Fee</span>
                        </button>

                        <button type="button" onclick="setCashierMethod('Binance USDT (BEP-20)', this)" class="deposit-method-btn relative p-4 rounded-2xl bg-[#141916] border border-white/[0.08] hover:border-amber-400/50 text-left transition flex items-center justify-between group" data-method="Binance USDT (BEP-20)">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-400/10 text-amber-300 border border-amber-400/20 flex items-center justify-center font-bold text-base shrink-0">
                                    <i class="fa-solid fa-cubes"></i>
                                </div>
                                <div>
                                    <div class="font-bold text-white text-xs sm:text-sm">Binance USDT</div>
                                    <div class="text-[10px] text-natural-textMuted">BEP-20 Fast Network</div>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded-full bg-white/[0.06] text-amber-300 text-[10px] font-bold font-mono">BSC Fast</span>
                        </button>
                    </div>
                </div>

                <!-- 2. Transfer Credentials Display Box -->
                <div class="bg-natural-darkPaper rounded-2xl p-5 border border-natural-darkBorder space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-natural-darkBorder">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-building-columns text-amber-400 text-sm"></i>
                            <span class="text-xs font-bold text-white">Official Operations Pay Address</span>
                        </div>
                        <span class="text-[10px] font-mono text-emerald-400 bg-emerald-950/60 border border-emerald-500/30 px-2 py-0.5 rounded-full">
                            Verified Escrow Account
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                        <div>
                            <span class="text-[10px] text-natural-textMuted font-mono uppercase block mb-1">Binance Pay ID:</span>
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-extrabold text-lg text-white bg-black/40 px-3.5 py-2 rounded-xl border border-natural-darkBorder">
                                    829104812
                                </span>
                                <button type="button" onclick="copyText('829104812', 'Pay ID Copied!')" class="px-3 py-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold text-xs transition flex items-center gap-1.5 shadow-sm">
                                    <i class="fa-regular fa-copy"></i>
                                    <span>Copy</span>
                                </button>
                            </div>
                        </div>

                        <div>
                            <span class="text-[10px] text-natural-textMuted font-mono uppercase block mb-1">Account Merchant Name:</span>
                            <div class="font-mono text-sm font-bold text-stone-200">
                                VERDANT WEALTH OPS (Institutional)
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $userHasActivePackage = $user->active_package_id !== null || $user->deposits()->whereIn('status', ['pending', 'approved'])->exists();
                @endphp

                @if ($userHasActivePackage)
                    <div class="p-4 rounded-2xl bg-amber-400/10 border border-amber-400/30 flex items-start gap-3">
                        <i class="fa-solid fa-lock text-amber-400 mt-0.5 text-base"></i>
                        <div>
                            <h4 class="text-xs font-bold text-white uppercase tracking-wider font-mono">Single Package Policy Active</h4>
                            <p class="text-xs text-natural-textMuted mt-0.5">
                                You currently hold an active investment plan (<strong>{{ $user->activePackage?->name ?? 'Active Package' }}</strong>). Each member is permitted one active package at a time.
                            </p>
                        </div>
                    </div>
                @endif

                <!-- 3. Deposit Submission Form -->
                <form method="POST" action="{{ route('investments.deposit') }}" class="space-y-6 pt-2">
                    @csrf
                    <input type="hidden" name="payment_method" id="selectedPaymentMethodInput" value="Binance Pay (QR)">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        
                        <!-- Select Package -->
                        <div>
                            <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">
                                Select Package Tier <span class="text-amber-400">*</span>
                            </label>
                            <select name="package_id" id="depositPackageSelect" onchange="syncSelectedPackage()" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs sm:text-sm text-white focus:border-amber-400 focus:outline-none transition">
                                @foreach ($packages as $pkg)
                                    <option value="{{ $pkg->id }}" 
                                            data-min="{{ $pkg->effective_min_investment }}" 
                                            data-max="{{ $pkg->effective_max_investment }}" 
                                            data-range="{{ $pkg->price_range_text }}" 
                                            data-rate="{{ $pkg->daily_profit_range_text }}">
                                        {{ $pkg->name }} — {{ $pkg->price_range_text }} ({{ $pkg->daily_profit_range_text }}/day)
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Amount Input -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold text-natural-textPrimary">
                                    Investment Capital ($ USD) <span class="text-amber-400">*</span>
                                </label>
                                <span class="text-[11px] font-mono text-amber-300" id="allowedRangeHint">
                                    Range: {{ $packages->first()?->price_range_text ?? '$100.00 – $200.00' }}
                                </span>
                            </div>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-natural-textMuted font-bold">$</span>
                                <input type="number" 
                                       step="0.01" 
                                       name="amount" 
                                       id="depositAmountInput" 
                                       value="{{ $packages->first()?->effective_min_investment ?? 100.00 }}" 
                                       min="{{ $packages->first()?->effective_min_investment ?? 1 }}" 
                                       max="{{ $packages->first()?->effective_max_investment ?? 50000 }}" 
                                       required 
                                       class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl pl-8 pr-4 py-3 text-xs sm:text-sm font-mono font-bold text-white focus:border-amber-400 focus:outline-none transition">
                            </div>
                        </div>

                        <!-- Binance Pay ID / Sender ID -->
                        <div>
                            <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">
                                Your Binance Pay ID / Account <span class="text-natural-textMuted font-normal">(Optional)</span>
                            </label>
                            <input type="text" 
                                   name="binance_pay_id" 
                                   placeholder="e.g. 592819482" 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs sm:text-sm text-white focus:border-amber-400 focus:outline-none transition">
                        </div>

                        <!-- Transaction Proof / TxID -->
                        <div>
                            <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">
                                Binance Order ID or TxID Proof <span class="text-amber-400">*</span>
                            </label>
                            <input type="text" 
                                   name="transaction_proof" 
                                   required 
                                   placeholder="e.g. 2948102948120 or blockchain hash" 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs sm:text-sm text-white focus:border-amber-400 focus:outline-none transition">
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full py-4 rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider text-slate-950 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:brightness-110 transition shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                            <i class="fa-solid fa-shield-check text-base"></i>
                            <span>Submit Deposit for Operator Verification</span>
                        </button>
                        <p class="text-[11px] text-center text-natural-textMuted mt-2">
                            Once approved, your compounding balance activates immediately and starts 24h daily ROI distributions.
                        </p>
                    </div>

                </form>

            </div>

        </section>

        <!-- ================= SECTION 4: WALLET & CASHOUT TERMINAL ================= -->
        <section id="cashout" class="space-y-6 scroll-mt-20">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 border-b border-natural-darkBorder pb-4">
                <div>
                    <span class="text-xs font-mono font-bold text-emerald-400 uppercase tracking-widest flex items-center gap-1.5">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Instant Liquidity Desk
                    </span>
                    <h2 class="font-serif font-bold text-2xl sm:text-3xl text-white mt-1">
                        Wallet & Cashout Terminal
                    </h2>
                    <p class="text-xs sm:text-sm text-natural-textMuted max-w-2xl mt-0.5">
                        Cash out anytime once your accrued profits reach $10.00. Principal is protected by the 30-day escrow lock.
                    </p>
                </div>
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-natural-forest/30 border border-natural-moss/40 text-natural-mint text-xs font-mono font-bold">
                    <i class="fa-solid fa-circle-check text-natural-sage"></i> Minimum Cashout: $10.00 USD
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Withdrawable Balance & Cashout Form (7 Cols) -->
                <div class="lg:col-span-7 bg-natural-darkCard rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-dark-card space-y-6">
                    
                    <!-- Balance Summary Pill -->
                    <div class="bg-natural-darkPaper rounded-2xl p-5 border border-natural-darkBorder space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-natural-textMuted uppercase font-bold tracking-wider font-mono">Available for Cashout</span>
                            <span class="text-xs font-mono px-2.5 py-0.5 rounded-full {{ $maxWithdrawable >= 10 ? 'bg-emerald-950 text-emerald-300 border border-emerald-500/30' : 'bg-stone-800 text-stone-400' }}">
                                {{ $maxWithdrawable >= 10 ? 'Eligible for Payout' : 'Minimum $10 Needed' }}
                            </span>
                        </div>
                        <div class="text-3xl sm:text-4xl font-serif font-extrabold text-emerald-400 font-mono">
                            ${{ number_format($maxWithdrawable, 2) }}
                            <span class="text-xs font-sans text-natural-textMuted font-normal">USD</span>
                        </div>

                        @if ($user->isCapitalLocked())
                            <div class="text-xs text-amber-300/90 font-mono bg-amber-950/30 p-2.5 rounded-xl border border-amber-600/30 flex items-center gap-2">
                                <i class="fa-solid fa-lock text-[10px] shrink-0"></i>
                                <span>Base principal (${{ number_format($user->locked_principal, 2) }}) locked for 45 days. Accrued daily profits withdrawable anytime.</span>
                            </div>
                        @endif
                    </div>

                    @php
                        $userHasActivePkg = $user->active_package_id !== null || $user->deposits()->where('status', 'approved')->exists();
                        $canWithdraw = $userHasActivePkg && $maxWithdrawable >= 10;
                    @endphp

                    @if (! $userHasActivePkg)
                        <div class="p-4 rounded-2xl bg-rose-950/40 border border-rose-500/40 flex items-start gap-3">
                            <i class="fa-solid fa-lock text-rose-400 mt-0.5 text-base"></i>
                            <div>
                                <h4 class="text-xs font-bold text-rose-300 uppercase tracking-wider font-mono">Active Package Required to Cashout</h4>
                                <p class="text-xs text-natural-textMuted mt-0.5">
                                    You must maintain at least one active investment package to withdraw funds or referral commissions. You can continue inviting friends to earn commissions, but cashout requires an active package.
                                </p>
                                <a href="#packages" class="inline-block mt-2 text-xs text-amber-400 font-bold underline font-mono">Activate an Investment Package &rarr;</a>
                            </div>
                        </div>
                    @endif

                    <!-- Cashout Request Form -->
                    <form method="POST" action="{{ route('wallet.cashout') }}" class="space-y-5">
                        @csrf

                        <!-- Payout Method -->
                        <div>
                            <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">
                                Select Payout Destination Method <span class="text-amber-400">*</span>
                            </label>
                            <select name="payout_method" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs sm:text-sm text-white focus:border-natural-sage focus:outline-none transition">
                                <option value="Binance Pay ID">Binance Pay ID (Zero Blockchain Gas Fee)</option>
                                <option value="Binance USDT (BEP-20)">Binance USDT (BEP-20 Network)</option>
                            </select>
                        </div>

                        <!-- Destination Account / Pay ID -->
                        <div>
                            <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">
                                Destination Binance Pay ID or BEP-20 Address <span class="text-amber-400">*</span>
                            </label>
                            <input type="text" 
                                   name="destination_account" 
                                   required 
                                   placeholder="Enter your Binance Pay ID or 0x... wallet address" 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs sm:text-sm text-white focus:border-natural-sage focus:outline-none transition font-mono">
                        </div>

                        <!-- Amount Input -->
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="text-xs font-bold text-natural-textPrimary">
                                    Withdrawal Amount ($ USD) <span class="text-amber-400">*</span>
                                </label>
                                <button type="button" onclick="setCashoutMax({{ $maxWithdrawable }})" class="text-[10px] text-natural-sage font-bold font-mono hover:underline">
                                    [MAX: ${{ number_format($maxWithdrawable, 2) }}]
                                </button>
                            </div>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-natural-textMuted font-bold">$</span>
                                <input type="number" 
                                       step="0.01" 
                                       name="amount" 
                                       id="cashoutAmountInput" 
                                       oninput="updateCashoutFee(this.value, {{ $withdrawalFeePercent }})"
                                       min="10" 
                                       max="{{ $maxWithdrawable }}" 
                                       placeholder="10.00" 
                                       required 
                                       class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl pl-8 pr-4 py-3 text-xs sm:text-sm font-mono font-bold text-white focus:border-natural-sage focus:outline-none transition">
                            </div>
                        </div>

                        <!-- Fee Calculation Breakdown -->
                        <div class="bg-black/30 p-3.5 rounded-xl border border-natural-darkBorder text-xs font-mono space-y-1.5">
                            <div class="flex justify-between text-natural-textMuted">
                                <span>Platform Fee ({{ number_format($withdrawalFeePercent, 2) }}%):</span>
                                <span id="cashoutFeeDisplay" class="text-amber-300">$0.00</span>
                            </div>
                            <div class="flex justify-between font-bold text-white pt-1 border-t border-natural-darkBorder">
                                <span>Estimated Net Received:</span>
                                <span id="cashoutNetDisplay" class="text-emerald-400 text-sm">$0.00</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" 
                                {{ $maxWithdrawable < 10 ? 'disabled' : '' }} 
                                class="w-full py-4 rounded-2xl font-bold text-xs sm:text-sm uppercase tracking-wider text-white transition shadow-natural-btn flex items-center justify-center gap-2 {{ $maxWithdrawable >= 10 ? 'bg-natural-forest hover:bg-natural-moss cursor-pointer' : 'bg-stone-800 text-stone-500 cursor-not-allowed opacity-60' }}">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            <span>Submit Cashout Request ($10 Min)</span>
                        </button>
                    </form>

                </div>

                <!-- Right: Recent Withdrawals Table (5 Cols) -->
                <div class="lg:col-span-5 bg-natural-darkCard rounded-3xl p-6 sm:p-7 border border-natural-darkBorder shadow-dark-card space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-natural-darkBorder">
                        <h3 class="font-serif font-bold text-base text-white">Recent Cashout Requests</h3>
                        <span class="text-[10px] font-mono text-natural-sage">{{ $recentWithdrawals->count() }} Record(s)</span>
                    </div>

                    <div class="space-y-3 max-h-[460px] overflow-y-auto pr-1">
                        @forelse ($recentWithdrawals as $w)
                            <div class="p-3.5 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder space-y-2">
                                <div class="flex items-center justify-between">
                                    <span class="font-mono font-bold text-white text-sm">${{ number_format($w->amount, 2) }}</span>
                                    @if ($w->status === 'approved')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-emerald-950 text-emerald-300 border border-emerald-500/30">Settled</span>
                                    @elseif ($w->status === 'rejected')
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-rose-950 text-rose-300 border border-rose-500/30">Rejected</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-amber-950 text-amber-300 border border-amber-500/30">Pending Review</span>
                                    @endif
                                </div>
                                <div class="text-[11px] text-natural-textMuted font-mono flex items-center justify-between">
                                    <span>{{ $w->payout_method }}</span>
                                    <span>{{ $w->created_at->format('M d, H:i') }}</span>
                                </div>
                                @if ($w->fee_amount > 0)
                                    <div class="text-[10px] text-natural-textMuted font-mono flex items-center justify-between pt-1 border-t border-natural-darkBorder/60">
                                        <span>Fee: ${{ number_format($w->fee_amount, 2) }}</span>
                                        <span class="text-emerald-400 font-bold">Net: ${{ number_format($w->net_amount, 2) }}</span>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-10 text-xs text-natural-textMuted font-mono">
                                No previous cashout requests yet.
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </section>

        <!-- ================= SECTION 5: 3-TIER REFERRAL HUB ================= -->
        <section id="referrals" class="space-y-6 scroll-mt-20">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 border-b border-natural-darkBorder pb-4">
                <div>
                    <span class="text-xs font-mono font-bold text-amber-300 uppercase tracking-widest flex items-center gap-1.5">
                        <i class="fa-solid fa-share-nodes"></i> Community Growth & Affiliates
                    </span>
                    <h2 class="font-serif font-bold text-2xl sm:text-3xl text-white mt-1">
                        3-Tier Referral Network
                    </h2>
                    <p class="text-xs sm:text-sm text-natural-textMuted max-w-2xl mt-0.5">
                        Earn instant deposit commissions on your referrals plus recurring percentages of their daily compounding profits.
                    </p>
                </div>
            </div>

            <!-- Referral Link Card -->
            <div class="bg-gradient-to-r from-natural-darkCard via-[#15231B] to-natural-darkCard rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-dark-card space-y-6">
                
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <span class="text-xs font-bold text-white uppercase tracking-wider font-mono">Your Exclusive Partner Link</span>
                        <p class="text-xs text-natural-textMuted">Share this link. Anyone who registers will be permanently linked as your downline.</p>
                    </div>

                    <div class="flex items-center gap-2 w-full md:w-auto">
                        <div class="px-4 py-2.5 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-xs text-natural-mint font-mono truncate max-w-md">
                            {{ url('/register') }}?ref={{ $user->referral_code }}
                        </div>
                        <button type="button" onclick="copyRefLink('{{ url('/register') }}?ref={{ $user->referral_code }}')" class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 text-xs font-bold transition shrink-0 flex items-center gap-1.5 shadow-sm cursor-pointer">
                            <i class="fa-solid fa-copy"></i>
                            <span id="hubCopyBtnText">Copy Link</span>
                        </button>
                    </div>
                </div>

                <!-- 3 Tier Tiers Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    
                    <!-- Tier 1 -->
                    <div class="bg-natural-darkPaper p-5 rounded-2xl border border-natural-moss/40 space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-natural-mint font-mono uppercase">Level 1: Direct</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-natural-forest/60 text-natural-mint">
                                {{ number_format($referralRate, 1) }}% Instant
                            </span>
                        </div>
                        <div class="text-2xl font-serif font-bold text-white font-mono">{{ $referralCount }} Member(s)</div>
                        <p class="text-[11px] text-natural-textMuted">Anyone who signs up directly via your invite link (+1.5% daily yield matching).</p>
                    </div>

                    <!-- Tier 2 -->
                    <div class="bg-natural-darkPaper p-5 rounded-2xl border border-natural-darkBorder space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-white font-mono uppercase">Level 2: Extended</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-white/[0.08] text-stone-300">
                                3.0% Instant
                            </span>
                        </div>
                        <div class="text-2xl font-serif font-bold text-white font-mono">Tier 2 Active</div>
                        <p class="text-[11px] text-natural-textMuted">Members invited by your direct referrals (+0.8% daily yield matching).</p>
                    </div>

                    <!-- Tier 3 -->
                    <div class="bg-natural-darkPaper p-5 rounded-2xl border border-natural-darkBorder space-y-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold text-white font-mono uppercase">Level 3: Community</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-white/[0.08] text-stone-300">
                                1.0% Instant
                            </span>
                        </div>
                        <div class="text-2xl font-serif font-bold text-white font-mono">Tier 3 Active</div>
                        <p class="text-[11px] text-natural-textMuted">Third generation partners in your community network (+0.4% daily matching).</p>
                    </div>

                </div>

            </div>

        </section>

        <!-- ================= SECTION 6: ACCOUNT ACTIVITY & TRANSACTION LEDGER ================= -->
        <section id="activity" class="space-y-6 scroll-mt-20">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-3 border-b border-natural-darkBorder pb-4">
                <div>
                    <span class="text-xs font-mono font-bold text-natural-sage uppercase tracking-widest flex items-center gap-1.5">
                        <i class="fa-solid fa-clock-rotate-left"></i> Verified Ledger
                    </span>
                    <h2 class="font-serif font-bold text-2xl sm:text-3xl text-white mt-1">
                        Recent Account Activity & Yield History
                    </h2>
                    <p class="text-xs sm:text-sm text-natural-textMuted max-w-2xl mt-0.5">
                        Track your automatic 24-hour daily compounding profits, deposit approvals, and cashout settlements.
                    </p>
                </div>
            </div>

            <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder p-6 sm:p-8 space-y-6 shadow-dark-card">
                
                <!-- Daily ROI Yields Table -->
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="font-serif font-bold text-lg text-white">24h Daily Profit Distributions</h3>
                        <span class="text-[11px] font-mono text-natural-mint font-semibold">Credited Every 24 Hours</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs font-mono">
                            <thead>
                                <tr class="text-natural-textMuted border-b border-natural-darkBorder">
                                    <th class="py-3 px-3">Date & Time</th>
                                    <th class="py-3 px-3">Daily Yield Rate</th>
                                    <th class="py-3 px-3">Profit Credited</th>
                                    <th class="py-3 px-3">Running Balance</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-natural-darkBorder/60">
                                @forelse ($recentYields as $yield)
                                    <tr class="hover:bg-natural-darkPaper/40 transition">
                                        <td class="py-3 px-3 text-white">{{ $yield->created_at->format('M d, Y H:i') }}</td>
                                        <td class="py-3 px-3 text-natural-sage font-bold">+{{ number_format($yield->daily_rate, 2) }}%</td>
                                        <td class="py-3 px-3 text-natural-mint font-bold">+${{ number_format($yield->profit_earned, 2) }}</td>
                                        <td class="py-3 px-3 text-white">${{ number_format($yield->resulting_balance, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-6 text-center text-natural-textMuted font-sans">
                                            No daily yield distributions recorded yet. Daily returns begin upon deposit approval.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Recent Deposits Table -->
                <div class="space-y-3 pt-6 border-t border-natural-darkBorder">
                    <div class="flex items-center justify-between">
                        <h3 class="font-serif font-bold text-lg text-white">Deposit Submissions</h3>
                        <span class="text-[11px] font-mono text-amber-400">Binance Pay Verification</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs font-mono">
                            <thead>
                                <tr class="text-natural-textMuted border-b border-natural-darkBorder">
                                    <th class="py-3 px-3">Date</th>
                                    <th class="py-3 px-3">Package Tier</th>
                                    <th class="py-3 px-3">Amount</th>
                                    <th class="py-3 px-3">Proof Reference</th>
                                    <th class="py-3 px-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-natural-darkBorder/60">
                                @forelse ($recentDeposits as $dep)
                                    <tr class="hover:bg-natural-darkPaper/40 transition">
                                        <td class="py-3 px-3 text-white">{{ $dep->created_at->format('M d, Y') }}</td>
                                        <td class="py-3 px-3 text-natural-mint font-bold">{{ $dep->package?->name ?? 'Standard' }}</td>
                                        <td class="py-3 px-3 text-white font-bold">${{ number_format($dep->amount, 2) }}</td>
                                        <td class="py-3 px-3 text-natural-textMuted truncate max-w-[150px]">{{ $dep->transaction_proof ?? $dep->binance_pay_id ?? 'N/A' }}</td>
                                        <td class="py-3 px-3">
                                            @if ($dep->status === 'approved')
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-950 text-emerald-300 border border-emerald-500/30">Approved</span>
                                            @elseif ($dep->status === 'rejected')
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-rose-950 text-rose-300 border border-rose-500/30">Rejected</span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-950 text-amber-300 border border-amber-500/30">Pending Approval</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-6 text-center text-natural-textMuted font-sans">
                                            No deposit records found. Select a package above to deposit.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </section>

    </div>

    <!-- ================= JAVASCRIPT INTERACTIONS ================= -->
    <script>
        function copyText(text, successMsg) {
            navigator.clipboard.writeText(text);
            if (typeof toastr !== 'undefined') {
                toastr.success(successMsg || 'Copied to clipboard!');
            } else {
                alert(successMsg || 'Copied!');
            }
        }

        function copyRefLink(link) {
            navigator.clipboard.writeText(link);
            const quickBtn = document.getElementById('quickCopyBtnText');
            const hubBtn = document.getElementById('hubCopyBtnText');
            if (quickBtn) quickBtn.innerText = 'Copied!';
            if (hubBtn) hubBtn.innerText = 'Copied!';
            setTimeout(() => {
                if (quickBtn) quickBtn.innerText = 'Copy Invite Link';
                if (hubBtn) hubBtn.innerText = 'Copy Link';
            }, 2000);
            if (typeof toastr !== 'undefined') {
                toastr.success('Referral invitation link copied to clipboard!');
            }
        }

        function selectPackageForDeposit(pkgId, pkgName, minAmt, maxAmt, rangeText) {
            const select = document.getElementById('depositPackageSelect');
            const input = document.getElementById('depositAmountInput');
            const hint = document.getElementById('allowedRangeHint');
            if (select) {
                select.value = pkgId;
            }
            if (input) {
                input.value = minAmt;
                input.min = minAmt;
                input.max = maxAmt;
            }
            if (hint) {
                hint.innerText = `Range: ${rangeText}`;
            }
            const depositSection = document.getElementById('deposit');
            if (depositSection) {
                depositSection.scrollIntoView({ behavior: 'smooth' });
            }
            if (typeof toastr !== 'undefined') {
                toastr.info(`Selected ${pkgName} (${rangeText}) for deposit.`);
            }
        }

        function syncSelectedPackage() {
            const select = document.getElementById('depositPackageSelect');
            const input = document.getElementById('depositAmountInput');
            const hint = document.getElementById('allowedRangeHint');
            if (select && input) {
                const opt = select.options[select.selectedIndex];
                const minAmt = parseFloat(opt.getAttribute('data-min')) || 1;
                const maxAmt = parseFloat(opt.getAttribute('data-max')) || 999999;
                const rangeText = opt.getAttribute('data-range') || `$${minAmt} – $${maxAmt}`;

                input.value = minAmt;
                input.min = minAmt;
                input.max = maxAmt;

                if (hint) {
                    hint.innerText = `Range: ${rangeText}`;
                }
            }
        }

        function setCashierMethod(methodName, btnElem) {
            document.querySelectorAll('.deposit-method-btn').forEach(btn => {
                btn.className = 'deposit-method-btn relative p-4 rounded-2xl bg-[#141916] border border-white/[0.08] hover:border-amber-400/50 text-left transition flex items-center justify-between group';
            });
            btnElem.className = 'deposit-method-btn relative p-4 rounded-2xl bg-gradient-to-r from-[#17261E] to-[#121E18] border-2 border-amber-400 text-left transition flex items-center justify-between group shadow-md';
            const hiddenInput = document.getElementById('selectedPaymentMethodInput');
            if (hiddenInput) {
                hiddenInput.value = methodName;
            }
        }

        function setCashoutMax(maxAmount) {
            const input = document.getElementById('cashoutAmountInput');
            if (input) {
                input.value = maxAmount;
                const feePercent = {{ $withdrawalFeePercent }};
                updateCashoutFee(maxAmount, feePercent);
            }
        }

        function updateCashoutFee(amountVal, feePercent) {
            const amount = parseFloat(amountVal) || 0;
            const fee = (amount * feePercent) / 100;
            const net = Math.max(0, amount - fee);

            const feeDisplay = document.getElementById('cashoutFeeDisplay');
            const netDisplay = document.getElementById('cashoutNetDisplay');
            if (feeDisplay) {
                feeDisplay.innerText = `$${fee.toFixed(2)}`;
            }
            if (netDisplay) {
                netDisplay.innerText = `$${net.toFixed(2)}`;
            }
        }

        // Trade 30-Minute Live Countdown
        let tradeSecsRemaining = {{ $tradeSecsRemaining ?? 0 }};
        const tradeDisplay = document.getElementById('tradeCountdownDisplay');
        const tradeBar = document.getElementById('tradeProgressBar');
        if (tradeDisplay && tradeSecsRemaining > 0) {
            const totalDuration = 1800; // 30 minutes
            const updateTradeClock = () => {
                if (tradeSecsRemaining <= 0) {
                    tradeDisplay.innerText = "00:00 (Ready to Settle)";
                    if (tradeBar) tradeBar.style.width = "100%";
                    setTimeout(() => {
                        document.getElementById('settleTradeForm')?.submit();
                    }, 1500);
                    return;
                }
                const m = Math.floor(tradeSecsRemaining / 60);
                const s = tradeSecsRemaining % 60;
                tradeDisplay.innerText = `${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
                if (tradeBar) {
                    const elapsed = totalDuration - tradeSecsRemaining;
                    const pct = Math.min(100, Math.max(0, (elapsed / totalDuration) * 100));
                    tradeBar.style.width = `${pct}%`;
                }
                tradeSecsRemaining--;
                setTimeout(updateTradeClock, 1000);
            };
            updateTradeClock();
        }

        // 24-Hour Cooling Countdown
        let coolingSecs = {{ $secondsToNextTrade ?? 0 }};
        const coolingDisplay = document.getElementById('coolingCountdownDisplay');
        if (coolingDisplay && coolingSecs > 0) {
            const updateCoolingClock = () => {
                if (coolingSecs <= 0) {
                    coolingDisplay.innerText = "00:00:00 — Ready to Trade!";
                    window.location.reload();
                    return;
                }
                const h = Math.floor(coolingSecs / 3600);
                const m = Math.floor((coolingSecs % 3600) / 60);
                const s = coolingSecs % 60;
                coolingDisplay.innerText = `${String(h).padStart(2, '0')}:${String(m).padStart(2, '0')}:${String(s).padStart(2, '0')}`;
                coolingSecs--;
                setTimeout(updateCoolingClock, 1000);
            };
            updateCoolingClock();
        }
    </script>
</x-app-layout>
