<x-app-layout>
    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-natural-darkCard via-[#141E18] to-natural-darkCard p-6 sm:p-7 rounded-3xl border border-natural-darkBorder shadow-dark-card flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="space-y-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-natural-forest/30 text-natural-mint text-xs font-bold border border-natural-moss/40">
                    <span class="w-2 h-2 rounded-full bg-natural-sage animate-pulse"></span>
                    <span>Automated 24h Yield Distribution Active</span>
                </div>
                <h2 class="font-serif font-bold text-2xl sm:text-3xl text-white">Investment Growth Packages</h2>
                <p class="text-xs text-natural-textMuted max-w-xl">
                    Select your Binance payment channel, package tier, and deposit to start continuous daily compounding.
                </p>
            </div>
            <div class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-2xl bg-amber-400/10 border border-amber-400/30 text-amber-300 text-xs font-bold font-mono">
                <i class="fa-solid fa-shield-check"></i> Escrow Secured
            </div>
        </div>

        <!-- ================= CASHIER DEPOSIT CARD (FAITHFUL TO REFERENCE SCREENSHOT) ================= -->
        <div class="bg-[#0B0F0D] rounded-3xl p-5 sm:p-7 border border-amber-500/30 shadow-2xl space-y-5 relative overflow-hidden" id="cashierSection">
            
            <!-- Ambient Glow -->
            <div class="absolute -top-24 -right-24 w-72 h-72 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- 1. Payment Methods * -->
            <div class="space-y-2.5">
                <div class="flex items-center gap-1.5">
                    <span class="text-xs font-bold uppercase tracking-wider text-stone-200 font-sans">Payment Methods</span>
                    <span class="text-amber-400 font-bold">*</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    
                    <!-- Method 1: Binance Pay (QR) - Selected Default -->
                    <button type="button" onclick="selectPaymentMethod('binance_qr', this)" class="payment-method-btn relative p-3.5 rounded-2xl bg-gradient-to-r from-[#17261E] to-[#121E18] border-2 border-amber-400 text-left transition flex items-center justify-between group shadow-md" data-method="binance_qr">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-400/20 text-amber-400 border border-amber-400/30 flex items-center justify-center font-bold text-base shrink-0">
                                <i class="fa-solid fa-qrcode"></i>
                            </div>
                            <div>
                                <div class="font-bold text-white text-xs sm:text-sm">Binance Pay-QR</div>
                                <div class="text-[10px] text-natural-textMuted">Instant App Scan</div>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[10px] font-bold font-mono shadow-sm">
                            +100% Free
                        </span>
                        <!-- Corner Checkmark -->
                        <div class="check-icon absolute bottom-1.5 right-1.5 text-amber-400 text-xs">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    </button>

                    <!-- Method 2: Binance Pay ID -->
                    <button type="button" onclick="selectPaymentMethod('binance_id', this)" class="payment-method-btn relative p-3.5 rounded-2xl bg-[#141916] border border-white/[0.08] hover:border-amber-400/50 text-left transition flex items-center justify-between group" data-method="binance_id">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center font-bold text-base shrink-0">
                                <i class="fa-solid fa-id-card"></i>
                            </div>
                            <div>
                                <div class="font-bold text-white text-xs sm:text-sm">Binance Pay ID</div>
                                <div class="text-[10px] text-natural-textMuted">Direct Internal Transfer</div>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-white/[0.06] text-amber-300 text-[10px] font-bold font-mono">
                            0% Fee
                        </span>
                        <div class="check-icon absolute bottom-1.5 right-1.5 text-amber-400 text-xs hidden">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    </button>

                    <!-- Method 3: Binance USDT (BEP-20) -->
                    <button type="button" onclick="selectPaymentMethod('binance_bep20', this)" class="payment-method-btn relative p-3.5 rounded-2xl bg-[#141916] border border-white/[0.08] hover:border-amber-400/50 text-left transition flex items-center justify-between group" data-method="binance_bep20">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-400/10 text-amber-300 border border-amber-400/20 flex items-center justify-center font-bold text-base shrink-0">
                                <i class="fa-solid fa-cubes"></i>
                            </div>
                            <div>
                                <div class="font-bold text-white text-xs sm:text-sm">Binance USDT</div>
                                <div class="text-[10px] text-natural-textMuted">BEP-20 Network</div>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded-full bg-white/[0.06] text-amber-300 text-[10px] font-bold font-mono">
                            BSC Fast
                        </span>
                        <div class="check-icon absolute bottom-1.5 right-1.5 text-amber-400 text-xs hidden">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    </button>

                </div>
            </div>

            <!-- 2. Select channel * -->
            <div class="space-y-2.5">
                <div class="flex items-center gap-1.5">
                    <span class="text-xs font-bold uppercase tracking-wider text-stone-200 font-sans">Select channel</span>
                    <span class="text-amber-400 font-bold">*</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                    <!-- Channel 1: Active Gold -->
                    <button type="button" onclick="selectChannel('QR-9 (Binance Pay Scan)', this)" class="channel-btn relative py-3 px-3 rounded-xl bg-gradient-to-b from-[#F5D061] to-[#DFA427] text-slate-950 font-bold text-xs flex items-center justify-center gap-1.5 shadow-md transition cursor-pointer">
                        <span>QR-9</span>
                        <div class="channel-check absolute bottom-1 right-1.5 text-slate-950 text-[10px]">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    </button>

                    <!-- Channel 2 -->
                    <button type="button" onclick="selectChannel('QR-17 (Binance Pay ID)', this)" class="channel-btn relative py-3 px-3 rounded-xl bg-[#141916] border border-white/[0.08] text-stone-300 hover:text-white hover:border-amber-400/50 font-bold text-xs flex items-center justify-center gap-1.5 transition cursor-pointer">
                        <span>QR-17</span>
                        <div class="channel-check absolute bottom-1 right-1.5 text-slate-950 text-[10px] hidden">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    </button>

                    <!-- Channel 3 -->
                    <button type="button" onclick="selectChannel('QR-10 (BEP-20 BSC)', this)" class="channel-btn relative py-3 px-3 rounded-xl bg-[#141916] border border-white/[0.08] text-stone-300 hover:text-white hover:border-amber-400/50 font-bold text-xs flex items-center justify-center gap-1.5 transition cursor-pointer">
                        <span>QR-10</span>
                        <div class="channel-check absolute bottom-1 right-1.5 text-slate-950 text-[10px] hidden">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    </button>

                    <!-- Channel 4 -->
                    <button type="button" onclick="selectChannel('QR-2 (Web3 Fast)', this)" class="channel-btn relative py-3 px-3 rounded-xl bg-[#141916] border border-white/[0.08] text-stone-300 hover:text-white hover:border-amber-400/50 font-bold text-xs flex items-center justify-center gap-1.5 transition cursor-pointer">
                        <span>QR-2</span>
                        <div class="channel-check absolute bottom-1 right-1.5 text-slate-950 text-[10px] hidden">
                            <i class="fa-solid fa-check"></i>
                        </div>
                    </button>
                </div>
            </div>

            <!-- 3. Deposit Amount Min: 100 Max: 20000 -->
            <div class="space-y-3 pt-1">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5">
                        <span class="text-xs font-bold uppercase tracking-wider text-stone-200 font-sans">Deposit Amount</span>
                        <span class="text-amber-400 font-bold">*</span>
                    </div>
                    <span class="text-xs text-natural-textMuted font-mono">
                        Min: <strong class="text-white">{{ number_format($packages->min('investment_amount') ?? 100, 0) }}</strong> &nbsp; Max: <strong class="text-white">{{ number_format($packages->max('investment_amount') ?? 20000, 0) }}</strong>
                    </span>
                </div>

                <!-- Custom Amount Input Field with Pencil Icon (Screenshot Style) -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-natural-textMuted">
                        <i class="fa-solid fa-pen text-xs text-amber-400"></i>
                        <span class="ml-2 font-mono text-sm font-bold text-amber-400">$</span>
                    </div>
                    <input type="number" step="0.01" min="1" id="depositAmountInput" oninput="onAmountTyped(this.value)" value="{{ $packages->first()?->investment_amount ?? 500 }}" placeholder="500" class="w-full bg-[#131915] border border-white/[0.12] rounded-xl pl-12 pr-4 py-3 text-base sm:text-lg font-mono font-bold text-white placeholder-stone-500 focus:border-amber-400 focus:outline-none transition shadow-inner">
                </div>

                <!-- Quick Selection Buttons Grid (Exactly matching the Reference Image with Top Floating Badges) -->
                @php
                    $presets = [
                        ['amount' => 100, 'badge' => '+30', 'rate' => 1.80, 'name' => 'Sprout Starter'],
                        ['amount' => 200, 'badge' => '+60', 'rate' => 1.80, 'name' => 'Sprout Plus'],
                        ['amount' => 300, 'badge' => '+90', 'rate' => 1.80, 'name' => 'Sprout Prime'],
                        ['amount' => 500, 'badge' => '+150', 'rate' => 2.20, 'name' => 'Seedling Growth'],
                        ['amount' => 1000, 'badge' => '+319', 'rate' => 2.50, 'name' => 'Bloom Signature'],
                        ['amount' => 2000, 'badge' => '+619', 'rate' => 2.50, 'name' => 'Bloom Plus'],
                        ['amount' => 3000, 'badge' => '+939', 'rate' => 2.50, 'name' => 'Bloom Prime'],
                        ['amount' => 5000, 'badge' => '+1098', 'rate' => 3.50, 'name' => 'Forest Premier'],
                        ['amount' => 10000, 'badge' => '+2198', 'rate' => 3.50, 'name' => 'Forest High'],
                        ['amount' => 20000, 'badge' => '+3198', 'rate' => 4.20, 'name' => 'Evergreen Institutional'],
                    ];
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-3">
                    @foreach ($presets as $idx => $item)
                        @php
                            $isSelected = ($item['amount'] == ($packages->first()?->investment_amount ?? 500));
                        @endphp
                        <button type="button" 
                                onclick="selectPresetAmount({{ $item['amount'] }}, {{ $item['rate'] }}, '{{ $item['name'] }}', this)" 
                                class="preset-btn relative pt-4 pb-3 px-3 rounded-xl {{ $isSelected ? 'bg-gradient-to-b from-[#F5D061] to-[#DFA427] text-slate-950 font-bold shadow-lg' : 'bg-[#141A16] hover:bg-[#1A221E] border border-white/[0.08] text-white' }} flex flex-col items-center justify-center transition group text-center cursor-pointer"
                                data-amount="{{ $item['amount'] }}"
                                data-rate="{{ $item['rate'] }}"
                                data-name="{{ $item['name'] }}">
                            
                            <!-- Floating Badge Overlapping Top Center Border -->
                            <span class="preset-badge absolute -top-2.5 px-2.5 py-0.5 rounded-md {{ $isSelected ? 'bg-[#FF8A00] text-black font-extrabold' : 'bg-[#1877F2] text-white font-bold' }} text-[10px] font-mono tracking-tight shadow-md">
                                {{ $item['badge'] }}
                            </span>

                            <div class="font-mono text-base font-bold">
                                {{ $item['amount'] }}
                            </div>

                            <div class="text-[9px] {{ $isSelected ? 'text-slate-900 font-semibold' : 'text-stone-400' }} truncate max-w-full">
                                {{ $item['name'] }} (+{{ number_format($item['rate'], 2) }}%)
                            </div>

                            <!-- Bottom-Right Checkmark for selected item -->
                            <div class="preset-check absolute bottom-1 right-1.5 text-slate-950 text-[10px] {{ $isSelected ? '' : 'hidden' }}">
                                <i class="fa-solid fa-check"></i>
                            </div>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- 4. Deposit Event * with Timer Ribbon (Reference Style) -->
            <div class="space-y-2 pt-1">
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-stone-200 font-sans">Deposit Event</span>
                    <span class="text-amber-400 font-bold">*</span>
                    <div class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-gradient-to-r from-amber-600 via-amber-500 to-amber-700 text-slate-950 font-mono text-[11px] font-bold shadow-sm">
                        <i class="fa-regular fa-clock text-[10px]"></i>
                        <span id="countdownTimer">10:21:42</span>
                    </div>
                </div>

                <!-- Event Promo Card with Checkmark -->
                <div class="relative p-3.5 rounded-xl bg-gradient-to-r from-[#211E13] via-[#1A251D] to-[#121B15] border border-amber-500/50 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-amber-300 text-xs sm:text-sm">
                            24h Continuous Compounding Active
                        </div>
                        <div class="text-[11px] text-stone-300">
                            Yield calculates continuously on your entire available balance. Locked for 30 days for maximum exponential growth.
                        </div>
                    </div>
                    <div class="w-6 h-6 rounded-lg bg-amber-400 text-slate-950 flex items-center justify-center text-xs font-bold shrink-0">
                        <i class="fa-solid fa-check"></i>
                    </div>
                </div>
            </div>

            <!-- 5. Warning Notice (Roman Urdu & English from Reference Image) -->
            <div class="p-3 rounded-xl bg-[#1A1408] border border-amber-600/40 text-xs text-amber-200/90 flex items-start gap-2.5">
                <span class="text-amber-400 text-sm mt-0.5 shrink-0">⚠️</span>
                <div class="text-[11px] leading-relaxed">
                    <strong class="text-amber-300">QR Code sirf ek deposit ke liye use hota hai!</strong><br>
                    Har deposit ke liye naya transaction proof / Pay ID submit karein. Admin verify kar ke aapka package foran activate kar de ga.
                </div>
            </div>

            <!-- 6. Large Gold Action Button (Reference Gold Gradient Button) -->
            <button type="button" onclick="openDepositModal()" class="w-full py-4 rounded-xl font-extrabold text-sm uppercase tracking-wider text-slate-950 bg-gradient-to-b from-[#FBD561] via-[#F5B82E] to-[#D89824] hover:brightness-110 transition shadow-xl flex items-center justify-center gap-2 cursor-pointer">
                <span>Deposit</span>
            </button>

        </div>

    </div>

    <!-- Hidden Form to Post Deposit Request to Server -->
    <form id="realDepositSubmitForm" method="POST" action="{{ route('investments.deposit') }}" class="hidden">
        @csrf
        <input type="hidden" name="package_id" id="formPackageId">
        <input type="hidden" name="amount" id="formAmount">
        <input type="hidden" name="payment_method" id="formPaymentMethod">
        <input type="hidden" name="binance_pay_id" id="formBinancePayId">
        <input type="hidden" name="transaction_proof" id="formTransactionProof">
    </form>

    <!-- Interactive JavaScript Engine -->
    <script>
        const packageData = @json($packages);
        let selectedGateway = 'Binance Pay (QR)';
        let selectedChannel = 'QR-9 (Binance Pay Scan)';
        let currentPackage = packageData.length > 0 ? packageData[0] : null;
        let currentRate = 2.20;
        let currentPlanName = 'Seedling Growth';

        const binancePayId = '829104812';
        const binanceBscAddress = '0x7a250d5630B4cF539739dF2C5dAcb4c659F2488D';

        // Live Countdown Timer
        let secondsLeft = 10 * 3600 + 21 * 60 + 42;
        setInterval(() => {
            if (secondsLeft > 0) {
                secondsLeft--;
                const h = String(Math.floor(secondsLeft / 3600)).padStart(2, '0');
                const m = String(Math.floor((secondsLeft % 3600) / 60)).padStart(2, '0');
                const s = String(secondsLeft % 60).padStart(2, '0');
                const timerEl = document.getElementById('countdownTimer');
                if (timerEl) timerEl.innerText = `${h}:${m}:${s}`;
            }
        }, 1000);

        function selectPaymentMethod(method, btn) {
            document.querySelectorAll('.payment-method-btn').forEach(b => {
                b.classList.remove('border-2', 'border-amber-400', 'bg-gradient-to-r', 'from-[#17261E]', 'to-[#121E18]');
                b.classList.add('border', 'border-white/[0.08]', 'bg-[#141916]');
                const check = b.querySelector('.check-icon');
                if (check) check.classList.add('hidden');
            });

            btn.classList.remove('border-white/[0.08]', 'bg-[#141916]');
            btn.classList.add('border-2', 'border-amber-400', 'bg-gradient-to-r', 'from-[#17261E]', 'to-[#121E18]');
            const check = btn.querySelector('.check-icon');
            if (check) check.classList.remove('hidden');

            if (method === 'binance_qr') {
                selectedGateway = 'Binance Pay (QR)';
            } else if (method === 'binance_id') {
                selectedGateway = 'Binance Pay ID';
            } else {
                selectedGateway = 'Binance USDT (BEP-20)';
            }
        }

        function selectChannel(ch, btn) {
            document.querySelectorAll('.channel-btn').forEach(b => {
                b.classList.remove('bg-gradient-to-b', 'from-[#F5D061]', 'to-[#DFA427]', 'text-slate-950');
                b.classList.add('bg-[#141916]', 'text-stone-300', 'border', 'border-white/[0.08]');
                const check = b.querySelector('.channel-check');
                if (check) check.classList.add('hidden');
            });

            btn.classList.remove('bg-[#141916]', 'text-stone-300', 'border', 'border-white/[0.08]');
            btn.classList.add('bg-gradient-to-b', 'from-[#F5D061]', 'to-[#DFA427]', 'text-slate-950');
            const check = btn.querySelector('.channel-check');
            if (check) check.classList.remove('hidden');

            selectedChannel = ch;
        }

        function selectPresetAmount(amount, rate, name, btn) {
            document.getElementById('depositAmountInput').value = amount;
            currentRate = rate;
            currentPlanName = name;

            // Find matching package object
            let matched = packageData.find(p => p.investment_amount <= amount);
            if (matched) currentPackage = matched;

            document.querySelectorAll('.preset-btn').forEach(b => {
                b.classList.remove('bg-gradient-to-b', 'from-[#F5D061]', 'to-[#DFA427]', 'text-slate-950', 'shadow-lg');
                b.classList.add('bg-[#141A16]', 'text-white', 'border', 'border-white/[0.08]');
                
                const subtitle = b.querySelector('.text-\\[9px\\]');
                if (subtitle) {
                    subtitle.classList.remove('text-slate-900', 'font-semibold');
                    subtitle.classList.add('text-stone-400');
                }
                const badge = b.querySelector('.preset-badge');
                if (badge) {
                    badge.classList.remove('bg-[#FF8A00]', 'text-black', 'font-extrabold');
                    badge.classList.add('bg-[#1877F2]', 'text-white', 'font-bold');
                }
                const check = b.querySelector('.preset-check');
                if (check) check.classList.add('hidden');
            });

            if (btn) {
                btn.classList.remove('bg-[#141A16]', 'text-white', 'border', 'border-white/[0.08]');
                btn.classList.add('bg-gradient-to-b', 'from-[#F5D061]', 'to-[#DFA427]', 'text-slate-950', 'shadow-lg');
                
                const subtitle = btn.querySelector('.text-\\[9px\\]');
                if (subtitle) {
                    subtitle.classList.remove('text-stone-400');
                    subtitle.classList.add('text-slate-900', 'font-semibold');
                }
                const badge = btn.querySelector('.preset-badge');
                if (badge) {
                    badge.classList.remove('bg-[#1877F2]', 'text-white', 'font-bold');
                    badge.classList.add('bg-[#FF8A00]', 'text-black', 'font-extrabold');
                }
                const check = btn.querySelector('.preset-check');
                if (check) check.classList.remove('hidden');
            }
        }

        function onAmountTyped(val) {
            const amount = parseFloat(val);
            if (isNaN(amount) || amount <= 0) return;

            let matched = packageData[0];
            for (let pkg of packageData) {
                if (amount >= pkg.investment_amount) {
                    matched = pkg;
                }
            }
            if (matched) {
                currentPackage = matched;
                currentRate = matched.daily_commission_percent;
                currentPlanName = matched.name;
            }
        }

        function openDepositModal() {
            const amount = parseFloat(document.getElementById('depositAmountInput').value) || 500;
            const pkgId = currentPackage ? currentPackage.id : (packageData[0] ? packageData[0].id : 1);

            Swal.fire({
                title: `Binance Deposit - $${amount.toFixed(2)} USD`,
                html: `
                    <div class="text-left space-y-4 text-xs font-sans">
                        <div class="p-3.5 rounded-2xl bg-natural-darkPaper border border-amber-500/30 flex items-center justify-between">
                            <div>
                                <div class="text-natural-textMuted text-[10px]">Tier: <strong>${currentPlanName}</strong> (+${currentRate}% / day)</div>
                                <div class="font-mono text-xl font-bold text-amber-400">$${amount.toFixed(2)} USD</div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-amber-400/20 border border-amber-400/30 text-amber-300 font-bold text-xs flex items-center gap-1.5">
                                <i class="fa-solid fa-bolt"></i> 0% Fee
                            </span>
                        </div>

                        <!-- Binance QR Code Box -->
                        <div class="p-4 rounded-2xl bg-[#0B120E] border border-amber-500/30 flex flex-col items-center justify-center text-center space-y-2">
                            <div class="w-36 h-36 bg-white p-2 rounded-xl flex items-center justify-center shadow-lg relative">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=${encodeURIComponent('binance://pay?id=' + binancePayId + '&amount=' + amount)}" alt="Binance Pay QR Code" class="w-full h-full object-contain">
                            </div>
                            <span class="text-[11px] text-amber-300 font-bold font-mono">Scan with Binance App</span>
                        </div>

                        <!-- Binance Pay ID Box -->
                        <div class="space-y-1">
                            <label class="text-[10px] uppercase font-bold text-natural-textMuted tracking-wider font-mono">
                                Official Binance Pay ID:
                            </label>
                            <div class="flex items-center gap-2 p-2.5 rounded-xl bg-natural-darkPaper border border-natural-darkBorder font-mono text-[11px] text-white">
                                <span class="flex-1 font-bold text-amber-300">${binancePayId}</span>
                                <button type="button" onclick="navigator.clipboard.writeText('${binancePayId}'); toastr.success('Binance Pay ID copied!');" class="px-3 py-1.5 rounded-lg bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold uppercase text-[10px] shrink-0 transition">
                                    Copy Pay ID
                                </button>
                            </div>
                        </div>

                        <!-- User Proof Input Field -->
                        <div class="space-y-1 pt-1 border-t border-white/[0.08]">
                            <label class="text-[11px] font-bold text-amber-300 font-mono">
                                Your Binance Pay ID / Transaction TxID (Proof) *:
                            </label>
                            <input type="text" id="userBinanceTxProof" placeholder="e.g. 98210481 or TxID from Binance app..." class="w-full bg-[#0F1813] border border-amber-500/50 rounded-xl px-3.5 py-2.5 text-xs text-white font-mono placeholder-stone-500 focus:outline-none focus:border-amber-400">
                            <span class="text-[10px] text-natural-textMuted block">Admin will cross-check this ID on Binance before activating your package.</span>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#23352B',
                confirmButtonText: 'Mene Payment Kr Di (Submit Deposit)',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    popup: 'verdant-swal-popup',
                    title: 'verdant-swal-title',
                    htmlContainer: 'verdant-swal-html',
                    confirmButton: 'px-6 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-950',
                    cancelButton: 'px-5 py-3 rounded-xl text-xs font-bold uppercase tracking-wider text-natural-textMuted'
                }
            }).then((res) => {
                if (res.isConfirmed) {
                    const proof = document.getElementById('userBinanceTxProof')?.value || 'Pending Verification';

                    document.getElementById('formPackageId').value = pkgId;
                    document.getElementById('formAmount').value = amount;
                    document.getElementById('formPaymentMethod').value = selectedGateway;
                    document.getElementById('formBinancePayId').value = proof;
                    document.getElementById('formTransactionProof').value = proof;

                    document.getElementById('realDepositSubmitForm').submit();
                }
            });
        }
    </script>
</x-app-layout>