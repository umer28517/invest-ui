<x-guest-layout>
    <div class="w-full max-w-xl mx-auto">
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder/90 p-8 sm:p-12 shadow-dark-card relative overflow-hidden space-y-8">
            <!-- Ambient glow at top -->
            <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-80 h-36 bg-natural-sage/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-8">
                <!-- Header -->
                <div class="text-center space-y-3">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-natural-forest/60 via-natural-darkCard to-natural-forest/20 border border-natural-moss/40 flex items-center justify-center text-natural-mint text-2xl shadow-lg mx-auto">
                        <i class="fa-solid fa-lock-open"></i>
                    </div>
                    <div class="space-y-1.5">
                        <h1 class="font-serif font-bold text-3xl sm:text-4xl text-white tracking-tight">Set New Password</h1>
                        <p class="text-sm sm:text-base text-natural-textMuted max-w-md mx-auto">Create a strong, unique password to secure your investment account.</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

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
                                   value="{{ old('email', $request->email) }}" 
                                   required 
                                   autofocus 
                                   autocomplete="username" 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 sm:py-4 text-sm sm:text-base text-white placeholder-natural-textMuted/40 focus:border-natural-sage focus:ring-2 focus:ring-natural-sage/20 focus:outline-none transition">
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs sm:text-sm text-rose-400 font-medium" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-natural-textPrimary mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-lock text-natural-sage text-xs"></i>
                            <span>New Password</span>
                        </label>
                        <div class="relative">
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="new-password" 
                                   placeholder="Min. 8 characters" 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 sm:py-4 text-sm sm:text-base text-white placeholder-natural-textMuted/40 focus:border-natural-sage focus:ring-2 focus:ring-natural-sage/20 focus:outline-none transition">
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs sm:text-sm text-rose-400 font-medium" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-natural-textPrimary mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-shield-halved text-natural-sage text-xs"></i>
                            <span>Confirm New Password</span>
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" 
                                   type="password" 
                                   name="password_confirmation" 
                                   required 
                                   autocomplete="new-password" 
                                   placeholder="Repeat your new password" 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 sm:py-4 text-sm sm:text-base text-white placeholder-natural-textMuted/40 focus:border-natural-sage focus:ring-2 focus:ring-natural-sage/20 focus:outline-none transition">
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs sm:text-sm text-rose-400 font-medium" />
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-4 rounded-2xl font-bold text-sm sm:text-base tracking-wide text-white bg-natural-forest hover:bg-natural-moss transition-all duration-200 shadow-natural-btn flex items-center justify-center gap-2.5 group">
                        <span>Update Password & Sign In</span>
                        <i class="fa-solid fa-check text-xs group-hover:scale-110 transition-transform"></i>
                    </button>
                </form>

                <div class="pt-2 text-center text-sm text-natural-textMuted">
                    <a href="{{ route('login') }}" class="text-natural-sage font-bold hover:underline">Back to Sign In &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
