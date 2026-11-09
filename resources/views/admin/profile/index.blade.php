<x-app-layout>
    <div class="space-y-6">

        <!-- Compact Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-1">
            <div>
                <h2 class="font-serif font-bold text-xl sm:text-2xl text-white">System Settings & Configuration</h2>
                <p class="text-xs text-natural-textMuted font-mono">Operator Details & Master administrative contact info, credentials, and commission percentages</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-natural-textMuted hover:text-white bg-natural-darkPaper border border-natural-darkBorder transition flex items-center gap-1.5 font-mono">
                    <i class="fa-solid fa-chart-line text-[11px]"></i> Overview
                </a>
            </div>
        </div>

        <!-- Settings Sub-Tabs Navigation (Bootstrap Style Nav Tabs) -->
        <div class="border-b border-natural-darkBorder">
            <nav class="flex space-x-2 sm:space-x-3 overflow-x-auto" aria-label="Settings Tabs">
                
                <!-- Tab 1: General Settings Button -->
                <button type="button" 
                        id="tab-btn-general" 
                        onclick="switchSettingsTab('general')"
                        class="settings-tab-btn py-3 px-4 sm:px-6 border-b-2 font-mono font-bold text-xs sm:text-sm rounded-t-xl transition flex items-center gap-2 cursor-pointer whitespace-nowrap border-amber-400 text-amber-300 bg-amber-950/25">
                    <i class="fa-solid fa-user-gear text-xs"></i>
                    <span>General Settings</span>
                </button>

                <!-- Tab 2: Security & Password Button -->
                <button type="button" 
                        id="tab-btn-security" 
                        onclick="switchSettingsTab('security')"
                        class="settings-tab-btn py-3 px-4 sm:px-6 border-b-2 font-mono font-bold text-xs sm:text-sm rounded-t-xl transition flex items-center gap-2 cursor-pointer whitespace-nowrap border-transparent text-natural-textMuted hover:text-white hover:border-natural-darkBorder">
                    <i class="fa-solid fa-key text-xs"></i>
                    <span>Security & Password</span>
                </button>

                <!-- Tab 3: Commission & Credentials Button -->
                <button type="button" 
                        id="tab-btn-commissions" 
                        onclick="switchSettingsTab('commissions')"
                        class="settings-tab-btn py-3 px-4 sm:px-6 border-b-2 font-mono font-bold text-xs sm:text-sm rounded-t-xl transition flex items-center gap-2 cursor-pointer whitespace-nowrap border-transparent text-natural-textMuted hover:text-white hover:border-natural-darkBorder">
                    <i class="fa-solid fa-percent text-xs"></i>
                    <span>Commission & Credentials</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-400 text-slate-950 font-bold font-sans">Rates</span>
                </button>

            </nav>
        </div>

        <!-- ================= TAB PANES CONTAINER ================= -->
        <div class="pt-2">

            <!-- ================= PANE 1: GENERAL SETTINGS ================= -->
            <div id="settings-pane-general" class="settings-tab-pane space-y-6">
                <div class="max-w-3xl bg-natural-darkCard rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-dark-card space-y-6">
                    <div class="flex items-center gap-3 pb-4 border-b border-natural-darkBorder">
                        <div class="w-10 h-10 rounded-xl bg-amber-950/60 text-amber-400 border border-amber-600/30 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                        <div>
                            <h3 class="font-serif font-bold text-lg text-white">General Administrator Profile</h3>
                            <p class="text-xs text-natural-textMuted font-mono">Operator Details & Master administrative contact info</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                        @csrf
                        @method('patch')

                        <div>
                            <label for="admin_name" class="block text-xs font-bold text-natural-textPrimary mb-1.5 font-mono">Master Administrator Name</label>
                            <input id="admin_name" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white focus:border-amber-400 focus:outline-none transition">
                            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-400" />
                        </div>

                        <div>
                            <label for="admin_email_profile" class="block text-xs font-bold text-natural-textPrimary mb-1.5 font-mono">Official Administrator Email</label>
                            <input id="admin_email_profile" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white focus:border-amber-400 focus:outline-none transition">
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-400" />
                        </div>

                        <div>
                            <label for="admin_phone_profile" class="block text-xs font-bold text-natural-textPrimary mb-1.5 font-mono">Emergency Phone Number</label>
                            <input id="admin_phone_profile" type="text" name="phone" value="{{ old('phone', Auth::user()->phone) }}" placeholder="+1 555 019 2831" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white focus:border-amber-400 focus:outline-none transition">
                            <x-input-error :messages="$errors->get('phone')" class="mt-1 text-xs text-rose-400" />
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="px-6 py-3.5 rounded-2xl font-bold text-xs uppercase tracking-wider text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:brightness-105 transition shadow-md flex items-center justify-center gap-2 cursor-pointer font-mono">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Save General Settings</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ================= PANE 2: SECURITY & PASSWORD ================= -->
            <div id="settings-pane-security" class="settings-tab-pane space-y-6 hidden">
                <div class="max-w-3xl bg-natural-darkCard rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-dark-card space-y-6">
                    <div class="flex items-center gap-3 pb-4 border-b border-natural-darkBorder">
                        <div class="w-10 h-10 rounded-xl bg-amber-950/60 text-amber-400 border border-amber-600/30 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h3 class="font-serif font-bold text-lg text-white">Master Account Security</h3>
                            <p class="text-xs text-natural-textMuted font-mono">Update operator password to safeguard financial controls</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                        @csrf
                        @method('put')

                        <div>
                            <label for="admin_current_password" class="block text-xs font-bold text-natural-textPrimary mb-1.5 font-mono">Current Password</label>
                            <input id="admin_current_password" type="password" name="current_password" required autocomplete="current-password" placeholder="••••••••" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white focus:border-amber-400 focus:outline-none transition">
                            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 text-xs text-rose-400" />
                        </div>

                        <div>
                            <label for="admin_password" class="block text-xs font-bold text-natural-textPrimary mb-1.5 font-mono">New Master Password</label>
                            <input id="admin_password" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 characters" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white focus:border-amber-400 focus:outline-none transition">
                            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 text-xs text-rose-400" />
                        </div>

                        <div>
                            <label for="admin_password_confirmation" class="block text-xs font-bold text-natural-textPrimary mb-1.5 font-mono">Confirm New Password</label>
                            <input id="admin_password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat new password" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white focus:border-amber-400 focus:outline-none transition">
                            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1 text-xs text-rose-400" />
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="px-6 py-3.5 rounded-2xl font-bold text-xs uppercase tracking-wider text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:brightness-105 transition shadow-md flex items-center justify-center gap-2 cursor-pointer font-mono">
                                <i class="fa-solid fa-lock"></i>
                                <span>Update Master Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ================= PANE 3: COMMISSION & CREDENTIALS ================= -->
            <div id="settings-pane-commissions" class="settings-tab-pane space-y-6 hidden">
                <div class="max-w-4xl bg-natural-darkCard rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-dark-card space-y-8">
                    
                    <div class="flex items-center gap-3 pb-4 border-b border-natural-darkBorder">
                        <div class="w-10 h-10 rounded-xl bg-amber-950/60 text-amber-400 border border-amber-600/30 flex items-center justify-center font-bold">
                            <i class="fa-solid fa-sliders"></i>
                        </div>
                        <div>
                            <h3 class="font-serif font-bold text-lg text-white">Platform Commission Rates & API Credentials</h3>
                            <p class="text-xs text-natural-textMuted font-mono">Configure daily referral yield match, withdrawal fees, and Binance connectivity</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
                        @csrf

                        <!-- Section 1: Financial Commission Rates -->
                        <div class="space-y-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-md bg-amber-400 text-slate-950 text-[10px] font-bold uppercase tracking-wider font-mono">
                                    Commission Rates
                                </span>
                                <span class="text-xs text-white font-bold font-serif">Yield Matching & Cashout Fee Engine</span>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <!-- 1. Daily Referral Matching % -->
                                <div class="bg-natural-darkPaper p-5 rounded-2xl border border-natural-darkBorder space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label for="ref_commission" class="text-xs font-bold text-white flex items-center gap-1.5 font-mono">
                                            <i class="fa-solid fa-users text-amber-400"></i>
                                            <span>Daily Referral Commission (%)</span>
                                        </label>
                                        <span class="text-[10px] text-amber-300 font-mono font-bold">On Downline Yield</span>
                                    </div>
                                    <div class="relative">
                                        <input type="number" 
                                               step="0.01" 
                                               min="0" 
                                               max="100" 
                                               name="referral_commission_percent" 
                                               id="ref_commission" 
                                               value="{{ old('referral_commission_percent', $referralCommission) }}" 
                                               required 
                                               class="w-full bg-natural-darkCard border border-natural-darkBorder rounded-xl pl-4 pr-10 py-3 text-sm font-mono text-white focus:border-amber-400 focus:outline-none transition">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-natural-textMuted font-bold font-mono">%</span>
                                    </div>
                                </div>

                                <!-- 2. Withdrawal Processing Fee % -->
                                <div class="bg-natural-darkPaper p-5 rounded-2xl border border-natural-darkBorder space-y-3">
                                    <div class="flex items-center justify-between">
                                        <label for="with_fee" class="text-xs font-bold text-white flex items-center gap-1.5 font-mono">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-rose-400"></i>
                                            <span>Withdrawal Fee Percentage (%)</span>
                                        </label>
                                        <span class="text-[10px] text-rose-300 font-mono font-bold">Deducted on Cashout</span>
                                    </div>
                                    <div class="relative">
                                        <input type="number" 
                                               step="0.01" 
                                               min="0" 
                                               max="100" 
                                               name="withdrawal_fee_percent" 
                                               id="with_fee" 
                                               value="{{ old('withdrawal_fee_percent', $withdrawalFee) }}" 
                                               required 
                                               class="w-full bg-natural-darkCard border border-natural-darkBorder rounded-xl pl-4 pr-10 py-3 text-sm font-mono text-white focus:border-amber-400 focus:outline-none transition">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-natural-textMuted font-bold font-mono">%</span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Section 2: Binance Connectivity & API Credentials -->
                        <div class="space-y-4 pt-4 border-t border-natural-darkBorder">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-md bg-amber-400/20 text-amber-300 border border-amber-500/30 text-[10px] font-bold uppercase tracking-wider font-mono">
                                    Binance Gateway
                                </span>
                                <span class="text-xs text-white font-bold font-serif">API Payout Connectivity Credentials</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div class="sm:col-span-2">
                                    <label for="binance_key" class="block text-xs font-bold text-natural-textPrimary mb-1.5 font-mono">Binance Pay Merchant ID / API Key</label>
                                    <input id="binance_key" type="text" name="binance_api_key" value="{{ old('binance_api_key', $binanceApiKey) }}" placeholder="e.g. bnc_live_9a810f2c91823719" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs font-mono text-white placeholder-natural-textMuted/40 focus:border-amber-400 focus:outline-none transition">
                                    <p class="text-[10px] text-natural-textMuted font-mono mt-1">Found in Binance Merchant & Pay developer settings</p>
                                </div>

                                <div>
                                    <label for="binance_secret" class="block text-xs font-bold text-natural-textPrimary mb-1.5 font-mono">Binance Secret Key</label>
                                    <input id="binance_secret" type="password" name="binance_api_secret" value="{{ old('binance_api_secret', $binanceApiSecret) }}" placeholder="••••••••••••••••••••••••" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs font-mono text-white placeholder-natural-textMuted/40 focus:border-amber-400 focus:outline-none transition">
                                </div>

                                <div>
                                    <label for="binance_env" class="block text-xs font-bold text-natural-textPrimary mb-1.5 font-mono">Gateway Environment</label>
                                    <select id="binance_env" name="binance_environment" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs text-white focus:border-amber-400 focus:outline-none transition font-mono">
                                        <option value="sandbox" {{ $binanceEnvironment === 'sandbox' ? 'selected' : '' }}>Sandbox / Testnet (Simulation)</option>
                                        <option value="live" {{ $binanceEnvironment === 'live' ? 'selected' : '' }}>Live Production Gateway</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="px-6 py-3.5 rounded-2xl font-bold text-xs uppercase tracking-wider text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:brightness-105 transition shadow-md flex items-center justify-center gap-2 cursor-pointer font-mono">
                                <i class="fa-solid fa-floppy-disk"></i>
                                <span>Save Commission Rates & Credentials</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>

    </div>

    <!-- Reliable Tab Switcher Script (Vanilla JS + Event Listeners) -->
    <script>
        function switchSettingsTab(tabName) {
            // 1. Hide all tab panes
            const panes = document.querySelectorAll('.settings-tab-pane');
            panes.forEach(function(pane) {
                pane.classList.add('hidden');
            });

            // 2. Reset styling on all tab buttons
            const buttons = document.querySelectorAll('.settings-tab-btn');
            buttons.forEach(function(btn) {
                btn.classList.remove('border-amber-400', 'text-amber-300', 'bg-amber-950/25');
                btn.classList.add('border-transparent', 'text-natural-textMuted');
            });

            // 3. Show targeted pane
            const activePane = document.getElementById('settings-pane-' + tabName);
            if (activePane) {
                activePane.classList.remove('hidden');
            }

            // 4. Highlight targeted button
            const activeBtn = document.getElementById('tab-btn-' + tabName);
            if (activeBtn) {
                activeBtn.classList.remove('border-transparent', 'text-natural-textMuted');
                activeBtn.classList.add('border-amber-400', 'text-amber-300', 'bg-amber-950/25');
            }

            // 5. Update URL hash without scroll
            if (history.replaceState) {
                history.replaceState(null, null, '#' + tabName);
            }
        }

        // Auto-switch based on hash (e.g. #security or #commissions) or errors
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->updatePassword->isNotEmpty())
                switchSettingsTab('security');
            @elseif (session('status') || $errors->has('referral_commission_percent') || $errors->has('withdrawal_fee_percent'))
                switchSettingsTab('commissions');
            @else
                const hash = window.location.hash.replace('#', '');
                if (hash && ['general', 'security', 'commissions'].includes(hash)) {
                    switchSettingsTab(hash);
                }
            @endif
        });
    </script>
</x-app-layout>
