<x-guest-layout>
    <div class="w-full max-w-xl mx-auto">
        
        <!-- Main Expansive Login Card -->
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder/90 p-8 sm:p-12 shadow-dark-card relative overflow-hidden">
            <!-- Subtle ambient glow at top -->
            <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-80 h-36 bg-natural-sage/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-8">
                
                <!-- Card Header -->
                <div class="text-center space-y-3">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-natural-forest/60 via-natural-darkCard to-natural-forest/20 border border-natural-moss/40 flex items-center justify-center text-natural-mint text-2xl shadow-lg mx-auto">
                        <i class="fa-solid fa-leaf"></i>
                    </div>

                    <div class="space-y-1.5">
                        <h1 class="font-serif font-bold text-3xl sm:text-4xl text-white tracking-tight">{{ cms('auth.login.title', 'Investor Sign In') }}</h1>
                        <p class="text-sm sm:text-base text-natural-textMuted max-w-md mx-auto">{{ cms('auth.login.subtitle', 'Access your active investments, daily returns, and balance withdrawals.') }}</p>
                    </div>
                </div>

                <!-- Session Status Alert -->
                <x-auth-session-status class="text-sm font-medium text-natural-mint bg-natural-forest/30 p-3.5 rounded-2xl border border-natural-moss/40" :status="session('status')" />

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-natural-textPrimary mb-2 flex items-center gap-2">
                            <i class="fa-regular fa-envelope text-natural-sage text-xs"></i>
                            <span>Email Address</span>
                        </label>
                        <div class="relative">
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="username" 
                                   placeholder="you@domain.com" 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 sm:py-4 text-sm sm:text-base text-white placeholder-natural-textMuted/40 focus:border-natural-sage focus:ring-2 focus:ring-natural-sage/20 focus:outline-none transition">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs sm:text-sm text-rose-400 font-medium" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="text-sm font-bold text-natural-textPrimary flex items-center gap-2">
                                <i class="fa-solid fa-lock text-natural-sage text-xs"></i>
                                <span>Password</span>
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs sm:text-sm text-natural-sage hover:underline font-semibold">Forgot password?</a>
                            @endif
                        </div>
                        <div class="relative">
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password" 
                                   placeholder="Enter your secret password" 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 sm:py-4 text-sm sm:text-base text-white placeholder-natural-textMuted/40 focus:border-natural-sage focus:ring-2 focus:ring-natural-sage/20 focus:outline-none transition">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs sm:text-sm text-rose-400 font-medium" />
                    </div>


                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-4 rounded-2xl font-bold text-sm sm:text-base tracking-wide text-white bg-natural-forest hover:bg-natural-moss transition-all duration-200 shadow-natural-btn flex items-center justify-center gap-2.5 group">
                        <span>{{ cms('auth.login.button', 'Sign In to Account') }}</span>
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

                <!-- Switch to Register -->
                <div class="text-center pt-2 text-sm text-natural-textMuted">
                    <span>{{ cms('auth.login.no_account', "Don't have an investor account yet?") }}</span>
                    <a href="{{ route('register') }}" class="text-natural-sage font-bold hover:underline ml-1">Create Account &rarr;</a>
                </div>

            </div>
        </div>

    </div>
</x-guest-layout>
