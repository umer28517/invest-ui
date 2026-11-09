<x-guest-layout>
    <div class="w-full max-w-xl mx-auto">
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder/90 p-8 sm:p-12 shadow-dark-card relative overflow-hidden space-y-8">
            <!-- Ambient glow at top -->
            <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-80 h-36 bg-natural-sage/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-8">
                <!-- Header -->
                <div class="text-center space-y-3">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-natural-forest/60 via-natural-darkCard to-natural-forest/20 border border-natural-moss/40 flex items-center justify-center text-natural-mint text-2xl shadow-lg mx-auto">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <div class="space-y-1.5">
                        <h1 class="font-serif font-bold text-3xl sm:text-4xl text-white tracking-tight">Reset Password</h1>
                        <p class="text-sm sm:text-base text-natural-textMuted max-w-md mx-auto">
                            Enter your registered email and we'll send you a cryptographic reset link to restore your account.
                        </p>
                    </div>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="text-sm font-medium text-natural-mint bg-natural-forest/30 p-3.5 rounded-2xl border border-natural-moss/40" :status="session('status')" />

                <!-- Form -->
                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-natural-textPrimary mb-2 flex items-center gap-2">
                            <i class="fa-regular fa-envelope text-natural-sage text-xs"></i>
                            <span>Account Email Address</span>
                        </label>
                        <div class="relative">
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   placeholder="name@example.com" 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 sm:py-4 text-sm sm:text-base text-white placeholder-natural-textMuted/40 focus:border-natural-sage focus:ring-2 focus:ring-natural-sage/20 focus:outline-none transition">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs sm:text-sm text-rose-400 font-medium" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-4 rounded-2xl font-bold text-sm sm:text-base tracking-wide text-white bg-natural-forest hover:bg-natural-moss transition-all duration-200 shadow-natural-btn flex items-center justify-center gap-2.5 group">
                        <span>Send Password Reset Link</span>
                        <i class="fa-solid fa-paper-plane text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

                <!-- Back to Login -->
                <div class="pt-2 text-center text-sm text-natural-textMuted">
                    <span>Remember your credentials?</span>
                    <a href="{{ route('login') }}" class="text-natural-sage font-bold hover:underline ml-1">Back to Sign In &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
