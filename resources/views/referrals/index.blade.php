<x-app-layout>
    @php
        $refCommission = (float) \App\Models\Setting::get('referral_commission_percent', 5.00);
    @endphp
    <div class="space-y-6">

        <!-- Header Card -->
        <div class="bg-natural-darkCard p-6 sm:p-8 rounded-3xl border border-natural-darkBorder shadow-dark-card space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="px-3 py-1 rounded-full bg-amber-950/60 border border-amber-600/30 text-amber-300 text-xs font-bold font-mono">Passive Commission Engine</span>
                    <h2 class="font-serif font-bold text-2xl sm:text-3xl text-white mt-2">3-Tier Affiliate Circle</h2>
                    <p class="text-xs text-natural-textMuted mt-1">Earn {{ number_format($refCommission, 1) }}% daily matching referral commission on 24-hour yield earned by your active downline team.</p>
                </div>

                <div class="p-4 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder text-center sm:text-right">
                    <span class="text-xs text-natural-textMuted block font-mono">Active Referral Rate:</span>
                    <span class="text-2xl font-serif font-bold text-amber-300 font-mono">+{{ number_format($refCommission, 2) }}% / day</span>
                </div>
            </div>

            <!-- Referral Link Widget -->
            <div class="p-4 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="space-y-0.5">
                    <div class="text-xs font-bold text-white">Your Dedicated Referral Link</div>
                    <div class="text-[11px] text-natural-textMuted">Share this invite URL with your network to earn instant commission bonuses.</div>
                </div>

                <div class="flex items-center gap-2">
                    <div class="px-4 py-2.5 rounded-xl bg-natural-darkCard border border-natural-darkBorder text-xs text-natural-mint font-mono truncate max-w-xs sm:max-w-md">
                        {{ url('/register') }}?ref={{ Auth::user()->referral_code }}
                    </div>
                    <button type="button" onclick="copyRefLink('{{ url('/register') }}?ref={{ Auth::user()->referral_code }}')" class="px-4 py-2.5 rounded-xl bg-natural-forest hover:bg-natural-moss text-white text-xs font-bold transition shrink-0 flex items-center gap-1.5 shadow-natural-btn">
                        <i class="fa-solid fa-copy"></i>
                        <span id="copyBtnText">Copy Link</span>
                    </button>
                </div>
            </div>

            <!-- 3 Tiers Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                <div class="p-5 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder space-y-1">
                    <div class="text-xs font-bold text-natural-sage">Tier 1 • Direct Invites</div>
                    <div class="text-3xl font-serif font-bold text-white">7.0%</div>
                    <div class="text-[11px] text-natural-textMuted">Instant matching bonus on every deposit made by your direct invites.</div>
                </div>

                <div class="p-5 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder space-y-1">
                    <div class="text-xs font-bold text-natural-mint">Tier 2 • Secondary Network</div>
                    <div class="text-3xl font-serif font-bold text-white">3.0%</div>
                    <div class="text-[11px] text-natural-textMuted">Earned from investments made by contacts invited by your Tier 1 partners.</div>
                </div>

                <div class="p-5 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder space-y-1">
                    <div class="text-xs font-bold text-amber-300">Tier 3 • Community Yield</div>
                    <div class="text-3xl font-serif font-bold text-white">1.0%</div>
                    <div class="text-[11px] text-natural-textMuted">Passive matching pool bonus from tertiary network volume.</div>
                </div>
            </div>
        </div>

        <!-- Downline Team Table -->
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder shadow-dark-card p-6 space-y-4">
            <h3 class="font-serif font-bold text-lg text-white">Your Downline Team Members</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-[#0A100D] text-natural-textMuted uppercase font-mono tracking-wider border-b border-natural-darkBorder text-[11px]">
                        <tr>
                            <th class="p-3.5">Investor Name</th>
                            <th class="p-3.5">Tier Level</th>
                            <th class="p-3.5">Active Package</th>
                            <th class="p-3.5">Total Commission Credited</th>
                            <th class="p-3.5 text-right">Account Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-darkBorder">
                        <tr class="hover:bg-natural-darkPaper/60 transition">
                            <td class="p-3.5 font-bold text-white flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-natural-forest/40 text-natural-mint flex items-center justify-center font-bold text-xs">
                                    M
                                </div>
                                <span>Marcus Vance</span>
                            </td>
                            <td class="p-3.5">
                                <span class="px-2.5 py-0.5 rounded-full bg-natural-forest/40 text-natural-mint text-[10px] font-bold border border-natural-moss/40">Tier 1 (7%)</span>
                            </td>
                            <td class="p-3.5 text-natural-textMuted font-mono">Bloom Signature ($1,000)</td>
                            <td class="p-3.5 text-amber-300 font-bold font-mono">+$70.00</td>
                            <td class="p-3.5 text-right text-emerald-400 font-semibold">Active</td>
                        </tr>
                        <tr class="hover:bg-natural-darkPaper/60 transition">
                            <td class="p-3.5 font-bold text-white flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-lg bg-natural-forest/40 text-natural-mint flex items-center justify-center font-bold text-xs">
                                    A
                                </div>
                                <span>Aisha Al-Mansoor</span>
                            </td>
                            <td class="p-3.5">
                                <span class="px-2.5 py-0.5 rounded-full bg-natural-forest/40 text-natural-mint text-[10px] font-bold border border-natural-moss/40">Tier 1 (7%)</span>
                            </td>
                            <td class="p-3.5 text-natural-textMuted font-mono">Seedling Starter ($500)</td>
                            <td class="p-3.5 text-amber-300 font-bold font-mono">+$35.00</td>
                            <td class="p-3.5 text-right text-emerald-400 font-semibold">Active</td>
                        </tr>
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
                btn.innerText = 'Copy Link';
            }, 2000);
        }
    </script>
</x-app-layout>
