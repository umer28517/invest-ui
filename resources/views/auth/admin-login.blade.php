<x-guest-layout>
    <div class="w-full max-w-xl mx-auto">
        
        <!-- Main Expansive Admin Login Card -->
        <div class="bg-natural-darkCard rounded-3xl border border-amber-900/50 p-8 sm:p-12 shadow-dark-card relative overflow-hidden">
            <!-- Golden ambient glow at top -->
            <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-80 h-36 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-8">
                
                <!-- Card Header -->
                <div class="text-center space-y-3">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-950/70 via-natural-darkCard to-amber-900/30 border border-amber-500/40 flex items-center justify-center text-amber-400 text-2xl shadow-lg mx-auto">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>

                    <div class="space-y-1.5">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-950/60 border border-amber-500/30 text-amber-300 text-[11px] font-bold tracking-wider uppercase mb-1">
                            <i class="fa-solid fa-lock text-[10px]"></i>
                            <span>Restricted Operator Gateway</span>
                        </div>
                        <h1 class="font-serif font-bold text-3xl sm:text-4xl text-white tracking-tight">Admin Management Console</h1>
                        <p class="text-sm sm:text-base text-natural-textMuted max-w-md mx-auto">Authorized system operators only. Manage reserves, adjust package yield rates, and audit transactions.</p>
                    </div>
                </div>

                <!-- Session Status Alert -->
                <x-auth-session-status class="text-sm font-medium text-amber-300 bg-amber-950/40 p-3.5 rounded-2xl border border-amber-500/40" :status="session('status')" />

                <!-- Quick 1-Click Test Credentials Bar -->
                <div class="p-4 rounded-2xl bg-natural-darkPaper/90 border border-amber-900/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-950/50 text-amber-400 flex items-center justify-center shrink-0 text-sm">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <div>
                            <div class="text-xs sm:text-sm font-bold text-white flex items-center gap-1.5">
                                <span>Master Admin Account</span>
                                <span class="px-2 py-0.5 rounded-full bg-amber-950 text-amber-300 text-[10px] font-mono font-bold border border-amber-600/30">OPERATOR</span>
                            </div>
                            <div class="text-xs text-natural-textMuted font-mono">admin@verdant.com • admin123</div>
                        </div>
                    </div>
                    <button type="button" onclick="fillAdminDemo()" class="px-4 py-2 rounded-xl bg-amber-950/60 hover:bg-amber-900/80 border border-amber-500/50 text-amber-300 text-xs font-bold transition flex items-center justify-center gap-2 shadow-xs group">
                        <i class="fa-solid fa-bolt text-[11px] group-hover:scale-110 transition-transform"></i>
                        <span>Auto-Fill</span>
                    </button>
                </div>

                <!-- Admin Login Form -->
                <form method="POST" action="{{ route('admin.login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="admin_email" class="block text-sm font-bold text-natural-textPrimary mb-2 flex items-center gap-2">
                            <i class="fa-regular fa-envelope text-amber-400 text-xs"></i>
                            <span>Admin Email Address</span>
                        </label>
                        <div class="relative">
                            <input id="admin_email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="username" 
                                   placeholder="admin@verdant.com" 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 sm:py-4 text-sm sm:text-base text-white placeholder-natural-textMuted/40 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 focus:outline-none transition">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs sm:text-sm text-rose-400 font-medium" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="admin_password" class="text-sm font-bold text-natural-textPrimary flex items-center gap-2">
                                <i class="fa-solid fa-lock text-amber-400 text-xs"></i>
                                <span>Security Password</span>
                            </label>
                        </div>
                        <div class="relative">
                            <input id="admin_password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password" 
                                   placeholder="Enter master password" 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 sm:py-4 text-sm sm:text-base text-white placeholder-natural-textMuted/40 focus:border-amber-400 focus:ring-2 focus:ring-amber-400/20 focus:outline-none transition">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs sm:text-sm text-rose-400 font-medium" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded bg-natural-darkPaper border-natural-darkBorder text-amber-500 focus:ring-0 focus:ring-offset-0">
                            <span class="ms-2.5 text-xs sm:text-sm text-natural-textMuted select-none">Remember this administrative session</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-4 rounded-2xl font-bold text-sm sm:text-base tracking-wide text-stone-900 bg-amber-400 hover:bg-amber-300 transition-all duration-200 shadow-lg shadow-amber-500/20 flex items-center justify-center gap-2.5 group">
                        <i class="fa-solid fa-fingerprint text-base"></i>
                        <span>Authenticate as Administrator</span>
                    </button>
                </form>

                <!-- Return to Investor Login -->
                <div class="pt-6 border-t border-natural-darkBorder/80 text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-natural-textMuted hover:text-natural-mint transition group py-1.5 px-3 rounded-xl hover:bg-white/[0.03]">
                        <i class="fa-solid fa-arrow-left text-xs group-hover:-translate-x-1 transition-transform"></i>
                        <span>Not an administrator? Switch to Investor Portal</span>
                    </a>
                </div>

            </div>
        </div>

    </div>

    <script>
        function fillAdminDemo() {
            document.getElementById('admin_email').value = 'admin@verdant.com';
            document.getElementById('admin_password').value = 'admin123';
            const rem = document.getElementById('remember_me');
            if (rem) {
                rem.checked = true;
            }
        }
    </script>
</x-guest-layout>
