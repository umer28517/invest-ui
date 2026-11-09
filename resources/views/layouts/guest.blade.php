<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Verdant Wealth') }} - Sustainable Daily Yields</title>

    <!-- Google Fonts: Editorial Serif + Clean Modern Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- intl-tel-input Plugin CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Fraunces"', 'Georgia', 'serif'],
                    },
                    colors: {
                        natural: {
                            darkBg: '#0C1310',
                            darkCard: '#131E18',
                            darkCardHover: '#182720',
                            darkBorder: '#23352B',
                            darkPaper: '#0E1713',
                            forest: '#2D6A4F',
                            moss: '#40916C',
                            sage: '#52B788',
                            mint: '#D8F3DC',
                            mintText: '#74C69D',
                            terracotta: '#F59E0B',
                            textPrimary: '#F5F3EF',
                            textMuted: '#9CA8A0',
                        }
                    },
                    boxShadow: {
                        'dark-card': '0 20px 40px -10px rgba(0, 0, 0, 0.55), 0 0 0 1px rgba(255, 255, 255, 0.05)',
                        'natural-btn': '0 6px 18px -3px rgba(45, 106, 79, 0.4)',
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background-color: #0C1310;
            color: #F5F3EF;
            font-family: 'Plus Jakarta Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }
        .bg-natural-dark-pattern {
            background-color: #0C1310;
            background-image: radial-gradient(rgba(82, 183, 136, 0.08) 0.75px, transparent 0.75px);
            background-size: 24px 24px;
        }

        /* intl-tel-input Natural Dark Styling */
        .iti {
            width: 100% !important;
            display: block !important;
        }
        .iti__country-list {
            background-color: #131E18 !important;
            border: 1px solid #23352B !important;
            border-radius: 1rem !important;
            box-shadow: 0 15px 35px -5px rgba(0, 0, 0, 0.7) !important;
            color: #F5F3EF !important;
            margin-top: 6px !important;
            z-index: 50 !important;
            max-height: 220px !important;
        }
        .iti__country {
            padding: 10px 14px !important;
            font-size: 13px !important;
            transition: background-color 0.15s ease !important;
        }
        .iti__country:hover, .iti__country.iti__highlight {
            background-color: #1A2A21 !important;
            color: #52B788 !important;
        }
        .iti__country-name, .iti__dial-code {
            color: #F5F3EF !important;
        }
        .iti__dial-code {
            color: #9CA8A0 !important;
        }
        .iti__selected-flag {
            background-color: transparent !important;
            border-radius: 1rem 0 0 1rem !important;
            padding-left: 16px !important;
            padding-right: 10px !important;
        }
        .iti__selected-flag:hover {
            background-color: rgba(255, 255, 255, 0.04) !important;
        }
        .iti__selected-dial-code {
            color: #F5F3EF !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            margin-left: 6px !important;
        }
        .iti__arrow {
            border-top-color: #9CA8A0 !important;
            margin-left: 6px !important;
        }
        .iti__arrow--up {
            border-bottom-color: #9CA8A0 !important;
        }
        .iti__divider {
            border-bottom: 1px solid #23352B !important;
        }
    </style>
</head>
<body class="bg-natural-dark-pattern min-h-screen flex flex-col justify-between selection:bg-natural-moss selection:text-white text-natural-textPrimary">

    <!-- Top Minimal Navigation -->
    <header class="w-full py-4 px-4 sm:px-8 border-b border-white/[0.06] bg-[#0C1310]/85 backdrop-blur-xl sticky top-0 z-30">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center space-x-2.5 group">
                <div class="w-9 h-9 rounded-xl bg-natural-forest/80 border border-natural-moss/40 flex items-center justify-center text-natural-mint shadow-xs group-hover:bg-natural-forest transition">
                    <i class="fa-solid fa-seedling text-base"></i>
                </div>
                <div class="flex items-baseline space-x-1.5">
                    <span class="font-serif font-bold text-xl tracking-tight text-white group-hover:text-natural-mint transition">Verdant<span class="text-natural-sage">.</span></span>
                    <span class="text-[9px] font-mono tracking-widest text-natural-textMuted uppercase font-bold">Wealth</span>
                </div>
            </a>

            <div class="flex items-center space-x-4 text-xs font-semibold">
                <a href="{{ url('/') }}" class="text-natural-textMuted hover:text-white transition flex items-center gap-1.5 px-3 py-1.5 rounded-lg hover:bg-white/[0.04]">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span class="hidden sm:inline">Back to Home</span>
                </a>
                <span class="text-stone-700">|</span>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? url('/admin/dashboard') : url('/dashboard') }}" class="text-natural-sage hover:underline">Dashboard</a>
                    @else
                        @if (request()->routeIs('register'))
                            <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-natural-textPrimary hover:bg-natural-darkCardHover transition">Sign In</a>
                        @else
                            <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl bg-natural-forest text-white hover:bg-natural-moss transition shadow-natural-btn">Create Account</a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </header>

    <!-- Main Content Container (Expansive & Breathable) -->
    <main class="flex-grow flex items-center justify-center py-10 sm:py-16 px-4 sm:px-6">
        <div class="w-full flex justify-center">
            {{ $slot }}
        </div>
    </main>

    <!-- Simple Warm Dark Footer -->
    <footer class="py-6 border-t border-white/[0.06] bg-[#0A100D] text-center text-xs text-natural-textMuted">
        <div class="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div>
                © {{ date('Y') }} Verdant Wealth Partners. All rights reserved.
            </div>
            <div class="flex items-center space-x-5 text-xs">
                <span class="flex items-center gap-1.5 text-natural-sage"><i class="fa-solid fa-lock text-[10px]"></i> 256-Bit SSL Encrypted</span>
                <span class="flex items-center gap-1.5 text-natural-sage"><i class="fa-solid fa-circle-check text-[10px]"></i> $10 Min. Cashout</span>
                <span class="flex items-center gap-1.5 text-natural-sage"><i class="fa-solid fa-shield-halved text-[10px]"></i> CertiK Verified</span>
            </div>
        </div>
    </footer>

</body>
</html>
