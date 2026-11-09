<x-guest-layout>
    <div class="w-full max-w-2xl mx-auto">
        
        <!-- Main Expansive Register Card -->
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder/90 p-8 sm:p-12 shadow-dark-card relative overflow-hidden">
            <!-- Subtle ambient glow at top -->
            <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-96 h-36 bg-natural-sage/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-8">
                
                <!-- Card Header -->
                <div class="text-center space-y-3">
                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-natural-forest/60 via-natural-darkCard to-natural-forest/20 border border-natural-moss/40 flex items-center justify-center text-natural-mint text-2xl shadow-lg mx-auto">
                        <i class="fa-solid fa-user-plus"></i>
                    </div>

                    <div class="space-y-1.5">
                        <h1 class="font-serif font-bold text-3xl sm:text-4xl text-white tracking-tight">{{ cms('auth.register.title', 'Create Investor Account') }}</h1>
                        <p class="text-sm sm:text-base text-natural-textMuted max-w-lg mx-auto">{{ cms('auth.register.subtitle', 'Start earning fixed daily returns on your investments with automated profit distribution and instant withdrawals.') }}</p>
                    </div>
                </div>

                <!-- Registration Form -->
                <form method="POST" action="{{ route('register') }}" id="registerForm" class="space-y-6">
                    @csrf

                    <!-- Row 1: Full Name & Email Address (Spacious 2 Cols) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="name" class="block text-sm font-bold text-natural-textPrimary mb-2 flex items-center gap-2">
                                <i class="fa-regular fa-user text-natural-sage text-xs"></i>
                                <span>Full Legal Name</span>
                            </label>
                            <div class="relative">
                                <input id="name" 
                                       type="text" 
                                       name="name" 
                                       value="{{ old('name') }}" 
                                       required 
                                       autofocus 
                                       autocomplete="name" 
                                       placeholder="Elena Morales" 
                                       class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 sm:py-4 text-sm sm:text-base text-white placeholder-natural-textMuted/40 focus:border-natural-sage focus:ring-2 focus:ring-natural-sage/20 focus:outline-none transition">
                            </div>
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-xs sm:text-sm text-rose-400 font-medium" />
                        </div>

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
                                       autocomplete="username" 
                                       placeholder="elena@example.com" 
                                       class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 sm:py-4 text-sm sm:text-base text-white placeholder-natural-textMuted/40 focus:border-natural-sage focus:ring-2 focus:ring-natural-sage/20 focus:outline-none transition">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs sm:text-sm text-rose-400 font-medium" />
                        </div>
                    </div>

                    <!-- Row 2: International Phone Number Field -->
                    <div>
                        <label for="phone" class="block text-sm font-bold text-natural-textPrimary mb-2 flex items-center gap-2">
                            <i class="fa-solid fa-phone text-natural-sage text-xs"></i>
                            <span>Phone Number</span>
                        </label>
                        <div class="relative">
                            <input id="phone" 
                                   type="tel" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="201 555 0123" 
                                   class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 sm:py-4 text-sm sm:text-base text-white placeholder-natural-textMuted/40 focus:border-natural-sage focus:ring-2 focus:ring-natural-sage/20 focus:outline-none transition">
                        </div>
                        <span id="phoneValidationMsg" class="hidden text-xs text-rose-400 font-medium mt-1.5 block">Please enter a valid phone number.</span>
                        <x-input-error :messages="$errors->get('phone')" class="mt-2 text-xs sm:text-sm text-rose-400 font-medium" />
                    </div>

                    <!-- Row 3: Password & Confirm Password (Spacious 2 Cols) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label for="password" class="block text-sm font-bold text-natural-textPrimary mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-lock text-natural-sage text-xs"></i>
                                <span>Password</span>
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

                        <div>
                            <label for="password_confirmation" class="block text-sm font-bold text-natural-textPrimary mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-shield-halved text-natural-sage text-xs"></i>
                                <span>Confirm Password</span>
                            </label>
                            <div class="relative">
                                <input id="password_confirmation" 
                                       type="password" 
                                       name="password_confirmation" 
                                       required 
                                       autocomplete="new-password" 
                                       placeholder="Repeat password" 
                                       class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3.5 sm:py-4 text-sm sm:text-base text-white placeholder-natural-textMuted/40 focus:border-natural-sage focus:ring-2 focus:ring-natural-sage/20 focus:outline-none transition">
                            </div>
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-xs sm:text-sm text-rose-400 font-medium" />
                        </div>
                    </div>

                    <!-- Silent Referral Code Tracking -->
                    <input type="hidden" name="referral_code" value="{{ request('ref') }}">

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-4 rounded-2xl font-bold text-sm sm:text-base tracking-wide text-white bg-natural-forest hover:bg-natural-moss transition-all duration-200 shadow-natural-btn flex items-center justify-center gap-2.5 group">
                        <span>{{ cms('auth.register.button', 'Complete Registration') }}</span>
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

                <!-- Switch to Login -->
                <div class="text-center pt-2 text-sm text-natural-textMuted">
                    <span>{{ cms('auth.register.has_account', 'Already have an investor account?') }}</span>
                    <a href="{{ route('login') }}" class="text-natural-sage font-bold hover:underline ml-1">Sign In to Account &rarr;</a>
                </div>

            </div>
        </div>

    </div>

    <!-- Initialize intl-tel-input -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const phoneInputField = document.querySelector("#phone");
            if (phoneInputField && window.intlTelInput) {
                const iti = window.intlTelInput(phoneInputField, {
                    initialCountry: "auto",
                    preferredCountries: ["us", "gb", "ae", "pk", "sa", "ca"],
                    separateDialCode: true,
                    geoIpLookup: function(callback) {
                        fetch("https://ipapi.co/json")
                            .then(function(res) { return res.json(); })
                            .then(function(data) { callback(data.country_code); })
                            .catch(function() { callback("us"); });
                    },
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js"
                });

                // Dynamically ensure phone input padding never overlaps with flag + dial code
                const updatePhonePadding = () => {
                    const flagContainer = document.querySelector('.iti__selected-flag');
                    if (flagContainer && phoneInputField) {
                        const width = flagContainer.offsetWidth;
                        if (width > 0) {
                            phoneInputField.style.paddingLeft = (width + 12) + 'px';
                        }
                    }
                };

                phoneInputField.addEventListener('countrychange', updatePhonePadding);
                setTimeout(updatePhonePadding, 50);
                setTimeout(updatePhonePadding, 250);
                setTimeout(updatePhonePadding, 600);

                const form = document.querySelector("#registerForm");
                const errorMsg = document.querySelector("#phoneValidationMsg");

                form.addEventListener('submit', function (e) {
                    if (phoneInputField.value.trim()) {
                        if (iti.isValidNumber()) {
                            phoneInputField.value = iti.getNumber();
                            errorMsg.classList.add('hidden');
                        } else {
                            e.preventDefault();
                            errorMsg.classList.remove('hidden');
                            phoneInputField.focus();
                        }
                    }
                });
            }
        });
    </script>
</x-guest-layout>
