<x-app-layout>
    <div class="space-y-6">

        <!-- Compact Header -->
        <div class="pb-1">
            <h2 class="font-serif font-bold text-xl sm:text-2xl text-white">Cold Storage Escrow Reserves</h2>
            <p class="text-xs text-natural-textMuted font-mono">Air-gapped multi-sig escrow & hot liquidity pools</p>
        </div>

        <!-- 3 Vault Allocations -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-natural-darkCard p-6 rounded-3xl border border-natural-darkBorder shadow-dark-card space-y-3">
                <span class="text-xs font-bold text-natural-textMuted uppercase">USDT Pool (TRC-20 & ERC-20)</span>
                <div class="text-2xl font-serif font-bold text-white">$24,500,000.00</div>
                <div class="text-xs text-natural-textMuted font-mono truncate">TXYZ910248...kL832</div>
                <div class="text-[11px] text-emerald-400 font-bold flex items-center gap-1.5 pt-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span> Air-Gapped Multi-Sig
                </div>
            </div>

            <div class="bg-natural-darkCard p-6 rounded-3xl border border-natural-darkBorder shadow-dark-card space-y-3">
                <span class="text-xs font-bold text-natural-textMuted uppercase">BTC Reserve Custody</span>
                <div class="text-2xl font-serif font-bold text-white">142.50 BTC ($12.3M)</div>
                <div class="text-xs text-natural-textMuted font-mono truncate">bc1qar0s91...3m29</div>
                <div class="text-[11px] text-amber-300 font-bold flex items-center gap-1.5 pt-1">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></span> Institutional Cold Storage
                </div>
            </div>

            <div class="bg-natural-darkCard p-6 rounded-3xl border border-natural-darkBorder shadow-dark-card space-y-3">
                <span class="text-xs font-bold text-natural-textMuted uppercase">Instant Cashout Hot Pool</span>
                <div class="text-2xl font-serif font-bold text-natural-mint">$1,250,000.00</div>
                <div class="text-xs text-natural-sage font-semibold">Ready for $10 Min Payouts</div>
                <div class="text-[11px] text-natural-mint font-bold flex items-center gap-1.5 pt-1">
                    <span class="w-2 h-2 rounded-full bg-natural-sage animate-pulse"></span> 24/7 Automated Settlement
                </div>
            </div>
        </div>

        <!-- Security & Audit Info -->
        <div class="bg-natural-darkCard rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-dark-card space-y-4">
            <h3 class="font-serif font-bold text-lg text-white">Security & Multi-Party Computation (MPC) Protocols</h3>
            <p class="text-xs text-natural-textMuted leading-relaxed">
                Transactions out of primary escrow require 3 out of 5 institutional signatures from geographically distributed hardware security modules (HSMs). The hot wallet maintaining the automated $10 minimum withdrawal ceiling holds a strict float of 5% of assets under management.
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 pt-2">
                <div class="p-4 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder">
                    <div class="text-[11px] text-natural-textMuted uppercase font-mono">Consensus</div>
                    <div class="text-sm font-bold text-white mt-1">3-of-5 Multi-Sig</div>
                </div>
                <div class="p-4 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder">
                    <div class="text-[11px] text-natural-textMuted uppercase font-mono">Audit Standard</div>
                    <div class="text-sm font-bold text-emerald-400 mt-1">CertiK Verified</div>
                </div>
                <div class="p-4 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder">
                    <div class="text-[11px] text-natural-textMuted uppercase font-mono">Insurance Tier</div>
                    <div class="text-sm font-bold text-amber-300 mt-1">$50M Lloyd's Policy</div>
                </div>
                <div class="p-4 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder">
                    <div class="text-[11px] text-natural-textMuted uppercase font-mono">Settlement Speed</div>
                    <div class="text-sm font-bold text-natural-mint mt-1">Instant (< 3 mins)</div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
