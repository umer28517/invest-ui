<x-app-layout>
    <div class="space-y-6">

        <!-- Header Card -->
        <div class="bg-natural-darkCard p-6 sm:p-8 rounded-3xl border border-natural-darkBorder shadow-dark-card">
            <h2 class="font-serif font-bold text-2xl sm:text-3xl text-white">Investor Profile & Security Settings</h2>
            <p class="text-xs text-natural-textMuted mt-1">Manage your account information, phone number, and access credentials.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Profile Information Form -->
            <div class="bg-natural-darkCard rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-dark-card space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-natural-darkBorder">
                    <div class="w-10 h-10 rounded-xl bg-natural-forest/40 text-natural-mint flex items-center justify-center font-bold">
                        <i class="fa-solid fa-user-pen"></i>
                    </div>
                    <div>
                        <h3 class="font-serif font-bold text-lg text-white">Profile Information</h3>
                        <p class="text-xs text-natural-textMuted">Update personal details and registered contact info</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                    @csrf
                    @method('patch')

                    <div>
                        <label for="name" class="block text-xs font-bold text-natural-textPrimary mb-1.5">Full Legal Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white focus:border-natural-sage focus:outline-none transition">
                        <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-bold text-natural-textPrimary mb-1.5">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white focus:border-natural-sage focus:outline-none transition">
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <div>
                        <label for="phone" class="block text-xs font-bold text-natural-textPrimary mb-1.5">Phone Number</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+1 555 782 9102" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white focus:border-natural-sage focus:outline-none transition">
                        <x-input-error :messages="$errors->get('phone')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <div class="p-3.5 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder flex items-center justify-between text-xs">
                        <span class="text-natural-textMuted">Your Referral Code:</span>
                        <span class="font-mono font-bold text-natural-sage">{{ $user->referral_code ?? 'None' }}</span>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-2xl font-bold text-xs uppercase tracking-wider text-white bg-natural-forest hover:bg-natural-moss transition shadow-natural-btn flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Save Profile Details
                    </button>
                </form>
            </div>

            <!-- Update Password Form -->
            <div class="bg-natural-darkCard rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-dark-card space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b border-natural-darkBorder">
                    <div class="w-10 h-10 rounded-xl bg-natural-forest/40 text-natural-mint flex items-center justify-center font-bold">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <div>
                        <h3 class="font-serif font-bold text-lg text-white">Update Password</h3>
                        <p class="text-xs text-natural-textMuted">Ensure your portfolio is secured with a strong password</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                    @csrf
                    @method('put')

                    <div>
                        <label for="current_password" class="block text-xs font-bold text-natural-textPrimary mb-1.5">Current Password</label>
                        <input id="current_password" type="password" name="current_password" required autocomplete="current-password" placeholder="••••••••" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white focus:border-natural-sage focus:outline-none transition">
                        <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <div>
                        <label for="password" class="block text-xs font-bold text-natural-textPrimary mb-1.5">New Password</label>
                        <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Min. 8 characters" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white focus:border-natural-sage focus:outline-none transition">
                        <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-xs font-bold text-natural-textPrimary mb-1.5">Confirm New Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Repeat new password" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white focus:border-natural-sage focus:outline-none transition">
                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1 text-xs text-rose-400" />
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-2xl font-bold text-xs uppercase tracking-wider text-white bg-natural-forest hover:bg-natural-moss transition shadow-natural-btn flex items-center justify-center gap-2">
                        <i class="fa-solid fa-lock"></i> Update Password
                    </button>
                </form>
            </div>

        </div>

    </div>
</x-app-layout>
