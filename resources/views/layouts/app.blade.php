<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Verdant Wealth') }} - {{ Auth::user()->isAdmin() ? 'Admin Console' : 'Investor Portal' }}</title>

    <!-- Google Fonts: Editorial Serif + Clean Modern Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN & FontAwesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- jQuery, Toastr & SweetAlert2 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- intl-tel-input Plugin CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>

    <!-- Quill.js Rich Text Editor CDN -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

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
                        'dark-card': '0 10px 30px -5px rgba(0, 0, 0, 0.45)',
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
        /* Custom scrollbars */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0C1310;
        }
        ::-webkit-scrollbar-thumb {
            background: #23352B;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #40916C;
        }
        /* intl-tel-input Dark Theme */
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
        .iti__country:hover, .iti__country.iti__highlight {
            background-color: #1A2A21 !important;
            color: #52B788 !important;
        }
        .iti__country-name, .iti__dial-code {
            color: #F5F3EF !important;
        }
        .iti__selected-dial-code {
            color: #F5F3EF !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            margin-left: 6px !important;
        }
        .iti__selected-flag {
            background-color: transparent !important;
            border-radius: 1rem 0 0 1rem !important;
            padding-left: 14px !important;
        }
        .iti__selected-flag:hover {
            background-color: rgba(255, 255, 255, 0.04) !important;
        }

        /* High-Visibility Modern Light Toastr Theme */
        #toast-container {
            z-index: 999999 !important;
            margin-top: 20px !important;
            margin-right: 20px !important;
        }
        #toast-container > div {
            opacity: 1 !important;
            border-radius: 1.15rem !important;
            padding: 16px 20px 16px 52px !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 13.5px !important;
            font-weight: 600 !important;
            letter-spacing: -0.01em !important;
            box-shadow: 0 20px 45px -5px rgba(0, 0, 0, 0.65), 0 0 0 1px rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            border-left-width: 6px !important;
            transition: all 0.25s ease-in-out !important;
        }
        #toast-container > div:hover {
            transform: translateY(-2px);
            box-shadow: 0 25px 50px -8px rgba(0, 0, 0, 0.75) !important;
        }

        /* Success Toast: Crisp Light / Vibrant Emerald Accent */
        #toast-container > .toast-success {
            background-color: #FFFFFF !important;
            border-left-color: #10B981 !important;
            color: #0F172A !important;
        }
        #toast-container > .toast-success .toast-title {
            color: #047857 !important;
        }
        #toast-container > .toast-success .toast-message {
            color: #1E293B !important;
        }
        #toast-container > .toast-success .toast-progress {
            background-color: #10B981 !important;
            height: 4px !important;
            opacity: 0.9 !important;
        }

        /* Error Toast: Crisp Light / Vibrant Red Accent */
        #toast-container > .toast-error {
            background-color: #FFFFFF !important;
            border-left-color: #EF4444 !important;
            color: #0F172A !important;
        }
        #toast-container > .toast-error .toast-title {
            color: #B91C1C !important;
        }
        #toast-container > .toast-error .toast-message {
            color: #1E293B !important;
        }
        #toast-container > .toast-error .toast-progress {
            background-color: #EF4444 !important;
            height: 4px !important;
            opacity: 0.9 !important;
        }

        /* Warning Toast: Crisp Light / Vibrant Amber Accent */
        #toast-container > .toast-warning {
            background-color: #FFFFFF !important;
            border-left-color: #F59E0B !important;
            color: #0F172A !important;
        }
        #toast-container > .toast-warning .toast-title {
            color: #B45309 !important;
        }
        #toast-container > .toast-warning .toast-message {
            color: #1E293B !important;
        }
        #toast-container > .toast-warning .toast-progress {
            background-color: #F59E0B !important;
            height: 4px !important;
            opacity: 0.9 !important;
        }

        /* Info Toast: Crisp Light / Vibrant Blue Accent */
        #toast-container > .toast-info {
            background-color: #FFFFFF !important;
            border-left-color: #3B82F6 !important;
            color: #0F172A !important;
        }
        #toast-container > .toast-info .toast-title {
            color: #1D4ED8 !important;
        }
        #toast-container > .toast-info .toast-message {
            color: #1E293B !important;
        }
        #toast-container > .toast-info .toast-progress {
            background-color: #3B82F6 !important;
            height: 4px !important;
            opacity: 0.9 !important;
        }

        /* Title & Message Typography */
        .toast-title {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            margin-bottom: 3px !important;
        }
        .toast-message {
            font-size: 13.5px !important;
            font-weight: 600 !important;
            line-height: 1.5 !important;
        }

        /* Close Button for Light Background */
        #toast-container .toast-close-button {
            color: #64748B !important;
            opacity: 0.75 !important;
            font-size: 18px !important;
            text-shadow: none !important;
            top: -4px !important;
            right: -4px !important;
        }
        #toast-container .toast-close-button:hover {
            color: #0F172A !important;
            opacity: 1 !important;
        }

        /* Quill Dark Theme Overrides */
        .ql-toolbar.ql-snow {
            background-color: #0E1713 !important;
            border-color: #23352B !important;
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
        }
        .ql-container.ql-snow {
            background-color: #0A100D !important;
            border-color: #23352B !important;
            border-bottom-left-radius: 1rem !important;
            border-bottom-right-radius: 1rem !important;
            color: #F5F3EF !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            font-size: 14px !important;
            min-height: 180px !important;
        }
        .ql-snow .ql-stroke {
            stroke: #9CA8A0 !important;
        }
        .ql-snow .ql-fill {
            fill: #9CA8A0 !important;
        }
        .ql-snow .ql-picker {
            color: #9CA8A0 !important;
        }
        .ql-snow .ql-picker-options {
            background-color: #131E18 !important;
            border-color: #23352B !important;
        }
        .ql-snow.ql-toolbar button:hover .ql-stroke,
        .ql-snow .ql-toolbar button:hover .ql-stroke {
            stroke: #52B788 !important;
        }
        .ql-editor.ql-blank::before {
            color: #5A6A61 !important;
            font-style: normal !important;
        }

        /* SweetAlert2 Custom Dark Theme */
        .swal2-popup.verdant-swal-popup {
            background-color: #131E18 !important;
            border: 1px solid #23352B !important;
            border-radius: 1.5rem !important;
            color: #F5F3EF !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.85) !important;
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        .swal2-title.verdant-swal-title {
            color: #FFFFFF !important;
            font-family: 'Fraunces', serif !important;
            font-size: 1.5rem !important;
        }
        .swal2-html-container.verdant-swal-html {
            color: #9CA8A0 !important;
            font-size: 13px !important;
            line-height: 1.6 !important;
        }
        .swal2-actions {
            gap: 12px !important;
        }
    </style>
</head>
<body class="bg-natural-dark-pattern min-h-screen flex selection:bg-natural-moss selection:text-white text-natural-textPrimary overflow-x-hidden">

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div id="mobileSidebarBackdrop" onclick="toggleMobileSidebar()" class="fixed inset-0 bg-black/70 backdrop-blur-xs z-40 hidden lg:hidden transition-opacity"></div>

    <!-- Sidebar (Desktop Fixed + Mobile Drawer) -->
    <aside id="appSidebar" class="fixed top-0 bottom-0 left-0 w-72 bg-[#0A100D] border-r border-natural-darkBorder z-50 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
        
        <!-- Sidebar Top: Brand & Navigation -->
        <div class="flex flex-col h-full overflow-y-auto">
            
            <!-- Brand Logo Area -->
            <div class="p-5 border-b border-white/[0.06] flex items-center justify-between">
                <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center space-x-2.5 group">
                    <div class="w-10 h-10 rounded-xl bg-natural-forest/80 border border-natural-moss/40 flex items-center justify-center text-natural-mint shadow-xs group-hover:bg-natural-forest transition">
                        <i class="fa-solid fa-seedling text-lg"></i>
                    </div>
                    <div class="flex items-baseline space-x-1.5">
                        <span class="font-serif font-bold text-xl tracking-tight text-white group-hover:text-natural-mint transition">Verdant<span class="text-natural-sage">.</span></span>
                        <span class="text-[9px] font-mono tracking-widest text-natural-textMuted uppercase font-bold">
                            {{ Auth::user()->isAdmin() ? 'Admin' : 'Investor' }}
                        </span>
                    </div>
                </a>

                <!-- Mobile Close Button -->
                <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden text-natural-textMuted hover:text-white p-1.5 rounded-lg hover:bg-white/[0.05]">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Role Indicator Pill -->
            <div class="px-5 pt-4 pb-2">
                @if (Auth::user()->isAdmin())
                    <div class="p-3 rounded-2xl bg-gradient-to-r from-amber-950/60 to-natural-darkCard border border-amber-600/30 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-amber-950/80 text-amber-400 flex items-center justify-center text-xs font-bold border border-amber-500/40">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div class="text-xs">
                            <div class="font-bold text-amber-300">System Operator</div>
                            <div class="text-[10px] text-natural-textMuted">Full Root Privileges</div>
                        </div>
                    </div>
                @else
                    <div class="p-3 rounded-2xl bg-gradient-to-r from-natural-forest/30 to-natural-darkCard border border-natural-moss/30 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl bg-natural-forest/50 text-natural-mint flex items-center justify-center text-xs font-bold border border-natural-moss/40">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <div class="text-xs">
                            <div class="font-bold text-natural-mint">Verified Investor</div>
                            <div class="text-[10px] text-natural-textMuted">Tier 1 Active Member</div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar Navigation Links (Separate Dedicated Pages) -->
            <nav class="flex-1 px-3 py-3 space-y-1.5" id="sidebarNav">
                
                @if (Auth::user()->isAdmin())
                    <!-- Admin Navigation Links -->
                    <a href="{{ route('admin.dashboard') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('admin.dashboard') ? 'text-slate-950 bg-amber-400 border border-amber-300 shadow-md' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-chart-line text-sm {{ request()->routeIs('admin.dashboard') ? 'text-slate-950' : 'text-natural-sage' }}"></i>
                        <span>System Overview</span>
                    </a>

                    <!-- Deposits Management -->
                    <a href="{{ route('admin.deposits.index') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('admin.deposits.*') ? 'text-slate-950 bg-amber-400 border border-amber-300 shadow-md' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-money-bill-transfer text-sm {{ request()->routeIs('admin.deposits.*') ? 'text-slate-950' : 'text-amber-400' }}"></i>
                        <span class="flex-1 text-left">Manage Deposits</span>
                        @php $navPendingDeposits = \App\Models\DepositRequest::where('status', 'pending')->count(); @endphp
                        @if ($navPendingDeposits > 0)
                            <span class="px-2 py-0.5 rounded-full {{ request()->routeIs('admin.deposits.*') ? 'bg-amber-950 text-amber-200' : 'bg-amber-400 text-slate-950 font-extrabold' }} text-[10px] font-mono shadow-sm">
                                {{ $navPendingDeposits }}
                            </span>
                        @endif
                    </a>

                    <a href="{{ route('admin.users.index') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('admin.users.*') ? 'text-slate-950 bg-amber-400 border border-amber-300 shadow-md' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-users-gear text-sm {{ request()->routeIs('admin.users.*') ? 'text-slate-950' : 'text-amber-400' }}"></i>
                        <span class="flex-1 text-left">User Management</span>
                        <span class="px-2 py-0.5 rounded-full {{ request()->routeIs('admin.users.*') ? 'bg-amber-950 text-amber-200' : 'bg-natural-darkPaper text-natural-sage' }} text-[10px] font-mono border border-natural-darkBorder">Manage</span>
                    </a>

                    <a href="{{ route('admin.packages.index') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('admin.packages.*') ? 'text-slate-950 bg-amber-400 border border-amber-300 shadow-md' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-sliders text-sm {{ request()->routeIs('admin.packages.*') ? 'text-slate-950' : 'text-natural-sage' }}"></i>
                        <span>Package & Rate Config</span>
                    </a>

                    <a href="{{ route('admin.notifications.index') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('admin.notifications.*') ? 'text-slate-950 bg-amber-400 border border-amber-300 shadow-md' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-bullhorn text-sm {{ request()->routeIs('admin.notifications.*') ? 'text-slate-950' : 'text-amber-400' }}"></i>
                        <span class="flex-1 text-left">Notifications</span>
                        <span class="px-2 py-0.5 rounded-full {{ request()->routeIs('admin.notifications.*') ? 'bg-amber-950 text-amber-200' : 'bg-natural-darkPaper text-amber-300' }} text-[10px] font-mono border border-natural-darkBorder">Broadcast</span>
                    </a>

                    <a href="{{ route('admin.cms.index') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('admin.cms.*') ? 'text-slate-950 bg-amber-400 border border-amber-300 shadow-md' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-pen-to-square text-sm {{ request()->routeIs('admin.cms.*') ? 'text-slate-950' : 'text-amber-300' }}"></i>
                        <span class="flex-1 text-left">Content CMS</span>
                        <span class="px-2 py-0.5 rounded-full {{ request()->routeIs('admin.cms.*') ? 'bg-amber-950 text-amber-200' : 'bg-natural-darkPaper text-natural-sage' }} text-[10px] font-mono border border-natural-darkBorder">Live</span>
                    </a>

                    <a href="{{ route('admin.profile.index') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('admin.profile.*') || request()->routeIs('admin.settings.*') ? 'text-slate-950 bg-amber-400 border border-amber-300 shadow-md' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-gear text-sm {{ request()->routeIs('admin.profile.*') || request()->routeIs('admin.settings.*') ? 'text-slate-950' : 'text-amber-300' }}"></i>
                        <span>Settings</span>
                    </a>

                @else
                    <!-- Investor Navigation Links -->
                    <a href="{{ route('dashboard') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('dashboard') ? 'text-white bg-natural-forest border border-natural-moss/50 shadow-natural-btn' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-chart-pie text-sm text-natural-sage"></i>
                        <span>Dashboard Overview</span>
                    </a>

                    <a href="{{ route('investments.index') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('investments.*') ? 'text-white bg-natural-forest border border-natural-moss/50 shadow-natural-btn' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-layer-group text-sm text-natural-mint"></i>
                        <span>Investment Plans</span>
                    </a>

                    <a href="{{ route('wallet.index') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('wallet.*') ? 'text-white bg-natural-forest border border-natural-moss/50 shadow-natural-btn' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-wallet text-sm text-natural-sage"></i>
                        <span class="flex-1 text-left">Wallet & Cashout</span>
                        <span class="px-2 py-0.5 rounded-full bg-natural-forest/40 text-[10px] text-natural-mint font-bold border border-natural-moss/40">$10 Min</span>
                    </a>

                    <a href="{{ route('referrals.index') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('referrals.*') ? 'text-white bg-natural-forest border border-natural-moss/50 shadow-natural-btn' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-share-nodes text-sm text-amber-300"></i>
                        <span class="flex-1 text-left">Referral Network</span>
                        <span class="px-2 py-0.5 rounded-full bg-amber-950/60 text-[10px] text-amber-300 font-bold border border-amber-600/30">3 Tiers</span>
                    </a>

                    <a href="{{ route('notifications.index') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('notifications.*') ? 'text-white bg-natural-forest border border-natural-moss/50 shadow-natural-btn' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-bell text-sm text-natural-mint"></i>
                        <span class="flex-1 text-left">Notifications</span>
                        @if (Auth::user()->unreadNotificationsCount() > 0)
                            <span class="px-2 py-0.5 rounded-full bg-amber-400 text-slate-950 text-[10px] font-mono font-bold">{{ Auth::user()->unreadNotificationsCount() }}</span>
                        @endif
                    </a>

                    <a href="{{ route('profile.edit') }}" class="w-full px-4 py-3 rounded-2xl text-xs sm:text-sm font-bold flex items-center gap-3.5 transition {{ request()->routeIs('profile.*') ? 'text-white bg-natural-forest border border-natural-moss/50 shadow-natural-btn' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkCard border border-transparent' }}">
                        <i class="fa-solid fa-user text-sm text-natural-sage"></i>
                        <span>My Profile</span>
                    </a>
                @endif
            </nav>

            <!-- Bottom User Profile Card -->
            <div class="p-4 border-t border-natural-darkBorder bg-natural-darkPaper/60">
                <div class="flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-10 h-10 rounded-xl bg-natural-darkCard border border-natural-darkBorder flex items-center justify-center text-natural-mint font-bold text-sm shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</div>
                            <div class="text-[10px] text-natural-textMuted font-mono truncate">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <!-- Direct Logout Form -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Log Out" class="w-8 h-8 rounded-lg bg-natural-darkCard hover:bg-rose-950/60 border border-natural-darkBorder hover:border-rose-700/50 text-natural-textMuted hover:text-rose-300 flex items-center justify-center transition">
                            <i class="fa-solid fa-power-off text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </aside>

    <!-- Main Content Wrapper (With Responsive Sidebar Offset) -->
    <div class="flex-1 flex flex-col min-h-screen lg:pl-72 transition-all duration-300">
        
        <!-- Top App Sticky Header -->
        @php
            if (Auth::user()->isAdmin()) {
                if (request()->routeIs('admin.dashboard')) {
                    $pageTitle = 'System Overview';
                    $pageSubtitle = 'Institutional escrow reserves, live metrics & automated distribution';
                } elseif (request()->routeIs('admin.deposits.*')) {
                    $pageTitle = 'Deposit Management & Approvals';
                    $pageSubtitle = 'Verify Binance Pay proofs, approve deposits, and activate compounding tiers';
                } elseif (request()->routeIs('admin.users.*')) {
                    $pageTitle = 'User Management';
                    $pageSubtitle = 'Investor accounts, verification, and active/deactivate controls';
                } elseif (request()->routeIs('admin.packages.*')) {
                    $pageTitle = 'Package & Rate Configuration';
                    $pageSubtitle = 'Investment tiers, daily commission rates, and withdrawal limits';
                } elseif (request()->routeIs('admin.notifications.*')) {
                    $pageTitle = 'Broadcast Notifications';
                    $pageSubtitle = 'Create and dispatch announcements, alerts, and bonus messages to all investors';
                } elseif (request()->routeIs('admin.reserves.*')) {
                    $pageTitle = 'Reserves & Vault Allocations';
                    $pageSubtitle = 'Air-gapped multi-sig escrow & hot liquidity pools';
                } elseif (request()->routeIs('admin.profile.*') || request()->routeIs('admin.settings.*')) {
                    $pageTitle = 'System Settings & Configuration';
                    $pageSubtitle = 'General info, security credentials, and platform commission percentages';
                } else {
                    $pageTitle = 'Admin Console';
                    $pageSubtitle = 'Institutional escrow & liquidity controls';
                }
            } else {
                if (request()->routeIs('dashboard')) {
                    $pageTitle = 'Investor Dashboard Overview';
                    $pageSubtitle = 'Real-time balance, automated 24-hour percentage returns & yield history';
                } elseif (request()->routeIs('investments.*')) {
                    $pageTitle = 'Investment Plans & Packages';
                    $pageSubtitle = 'Choose an automated daily yield tier tailored to your financial goals';
                } elseif (request()->routeIs('wallet.*')) {
                    $pageTitle = 'Wallet & Instant Cashout';
                    $pageSubtitle = 'Fund balance, request cashouts with $10.00 minimum threshold';
                } elseif (request()->routeIs('referrals.*')) {
                    $pageTitle = '3-Tier Affiliate Network';
                    $pageSubtitle = 'Invite partners and earn 7% Tier 1, 3% Tier 2, and 1% Tier 3 matching bonuses';
                } elseif (request()->routeIs('notifications.*')) {
                    $pageTitle = 'Investor Notifications';
                    $pageSubtitle = 'Official platform announcements, bonus rewards & system updates';
                } elseif (request()->routeIs('profile.*')) {
                    $pageTitle = 'Account Profile & Security';
                    $pageSubtitle = 'Personal details, phone number, and password management';
                } else {
                    $pageTitle = 'Investor Portal';
                    $pageSubtitle = 'Real-time daily yield accumulation & wallet management';
                }
            }
        @endphp

        <header class="h-16 bg-[#0C1310]/90 backdrop-blur-xl border-b border-white/[0.06] sticky top-0 z-30 px-4 sm:px-8 flex items-center justify-between">
            
            <!-- Left: Mobile Hamburger & Dynamic Section Title -->
            <div class="flex items-center gap-3 sm:gap-4">
                <button type="button" onclick="toggleMobileSidebar()" class="lg:hidden p-2 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-natural-textMuted hover:text-white transition">
                    <i class="fa-solid fa-bars text-sm"></i>
                </button>

                <div>
                    <h2 class="font-serif font-bold text-base sm:text-lg text-white">
                        {{ $pageTitle }}
                    </h2>
                    <p class="text-[10px] text-natural-textMuted hidden sm:block">
                        {{ $pageSubtitle }}
                    </p>
                </div>
            </div>

            <!-- Right: Status Indicators & User Badge -->
            <div class="flex items-center space-x-3 sm:space-x-4">
                
                <!-- Live Distribution Status -->
                <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-full bg-natural-darkPaper border border-natural-darkBorder text-xs text-natural-textMuted">
                    <span class="w-2 h-2 rounded-full bg-natural-sage animate-pulse"></span>
                    <span class="text-white font-medium">Daily 24h Yield Engine Active</span>
                </div>

                <!-- $10 Min Cashout Pill -->
                <div class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-natural-forest/20 border border-natural-moss/40 text-natural-mint text-xs font-bold">
                    <i class="fa-solid fa-circle-check text-[11px] text-natural-sage"></i>
                    <span>$10 Min Cashout</span>
                </div>

                <!-- Bell Notifications Icon (Investor) -->
                @if (Auth::user()->isUser())
                    <a href="{{ route('notifications.index') }}" class="relative p-2 rounded-xl bg-natural-darkPaper border border-natural-darkBorder hover:border-natural-sage text-natural-textMuted hover:text-white transition flex items-center justify-center w-9 h-9" title="View Notifications">
                        <i class="fa-solid fa-bell text-xs"></i>
                        @if (Auth::user()->unreadNotificationsCount() > 0)
                            <span class="absolute -top-1 -right-1 min-w-[18px] h-[18px] px-1 bg-amber-400 text-slate-950 text-[10px] font-bold rounded-full flex items-center justify-center font-mono shadow-xs">
                                {{ Auth::user()->unreadNotificationsCount() }}
                            </span>
                        @endif
                    </a>
                @endif

                <!-- Profile Quick Avatar Link -->
                <a href="{{ Auth::user()->isAdmin() ? route('admin.profile.index') : route('profile.edit') }}" class="flex items-center gap-2.5 p-1 sm:px-3 sm:py-1.5 rounded-xl bg-natural-darkPaper border border-natural-darkBorder hover:border-natural-sage transition group">
                    <div class="w-7 h-7 rounded-lg bg-natural-forest/50 text-natural-mint flex items-center justify-center text-xs font-bold font-serif">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <span class="text-xs font-bold text-white hidden sm:inline group-hover:text-natural-mint transition">Profile</span>
                </a>

            </div>

        </header>

        <!-- Main Page Content Slot -->
        <main class="flex-grow p-4 sm:p-6 lg:p-8 max-w-7xl mx-auto w-full">
            @if (Auth::user()->isAdmin() && !request()->routeIs('admin.profile.*') && !request()->routeIs('admin.settings.*') && !request()->routeIs('admin.users.show') && !request()->routeIs('admin.cms.*'))
                @php
                    $tabUsersCount = \App\Models\User::where('role', 'user')->count();
                    $tabPackagesCount = \App\Models\Package::count();
                    $tabBroadcastsCount = \App\Models\BroadcastNotification::count();
                    $tabPendingDepositsCount = \App\Models\DepositRequest::where('status', 'pending')->count();
                @endphp
                <div class="mb-6 overflow-x-auto pb-1 scrollbar-none">
                    <div class="inline-flex items-center gap-1.5 p-1.5 rounded-full bg-natural-darkCard/90 border border-natural-darkBorder backdrop-blur-md shadow-dark-card min-w-max">
                        
                        <!-- Overview -->
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-full text-xs font-bold flex items-center gap-2 transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkPaper' }}">
                            <i class="fa-solid fa-chart-line text-xs {{ request()->routeIs('admin.dashboard') ? 'text-slate-950' : 'text-natural-sage' }}"></i>
                            <span>Overview</span>
                        </a>

                        <!-- Deposits Management -->
                        <a href="{{ route('admin.deposits.index') }}" class="px-4 py-2 rounded-full text-xs font-bold flex items-center gap-2 transition {{ request()->routeIs('admin.deposits.*') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkPaper' }}">
                            <i class="fa-solid fa-money-bill-transfer text-xs {{ request()->routeIs('admin.deposits.*') ? 'text-slate-950' : 'text-amber-400' }}"></i>
                            <span>Deposits</span>
                            @if ($tabPendingDepositsCount > 0)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-extrabold {{ request()->routeIs('admin.deposits.*') ? 'bg-amber-950 text-amber-200' : 'bg-amber-400 text-slate-950' }}">
                                    {{ $tabPendingDepositsCount }}
                                </span>
                            @endif
                        </a>

                        <!-- User Management -->
                        <a href="{{ route('admin.users.index') }}" class="px-4 py-2 rounded-full text-xs font-bold flex items-center gap-2 transition {{ request()->routeIs('admin.users.*') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkPaper' }}">
                            <i class="fa-solid fa-users text-xs {{ request()->routeIs('admin.users.*') ? 'text-slate-950' : 'text-amber-400' }}"></i>
                            <span>User Management</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold {{ request()->routeIs('admin.users.*') ? 'bg-amber-950 text-amber-200' : 'bg-natural-darkPaper text-natural-textMuted border border-natural-darkBorder' }}">
                                {{ $tabUsersCount }}
                            </span>
                        </a>

                        <!-- Package & Rate Config -->
                        <a href="{{ route('admin.packages.index') }}" class="px-4 py-2 rounded-full text-xs font-bold flex items-center gap-2 transition {{ request()->routeIs('admin.packages.*') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkPaper' }}">
                            <i class="fa-solid fa-sliders text-xs {{ request()->routeIs('admin.packages.*') ? 'text-slate-950' : 'text-natural-sage' }}"></i>
                            <span>Package & Rate Config</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold {{ request()->routeIs('admin.packages.*') ? 'bg-amber-950 text-amber-200' : 'bg-natural-darkPaper text-natural-textMuted border border-natural-darkBorder' }}">
                                {{ $tabPackagesCount }}
                            </span>
                        </a>

                        <!-- Notifications (Broadcast) -->
                        <a href="{{ route('admin.notifications.index') }}" class="px-4 py-2 rounded-full text-xs font-bold flex items-center gap-2 transition {{ request()->routeIs('admin.notifications.*') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkPaper' }}">
                            <i class="fa-solid fa-bullhorn text-xs {{ request()->routeIs('admin.notifications.*') ? 'text-slate-950' : 'text-amber-400' }}"></i>
                            <span>Notifications</span>
                            @if ($tabBroadcastsCount > 0)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold {{ request()->routeIs('admin.notifications.*') ? 'bg-amber-950 text-amber-200' : 'bg-amber-950/60 text-amber-300 border border-amber-600/30' }}">
                                    {{ $tabBroadcastsCount }}
                                </span>
                            @endif
                        </a>

                        <!-- Settings -->
                        <a href="{{ route('admin.profile.index') }}" class="px-4 py-2 rounded-full text-xs font-bold flex items-center gap-2 transition {{ request()->routeIs('admin.profile.*') || request()->routeIs('admin.settings.*') ? 'bg-amber-400 text-slate-950 shadow-sm' : 'text-natural-textMuted hover:text-white hover:bg-natural-darkPaper' }}">
                            <i class="fa-solid fa-gear text-xs {{ request()->routeIs('admin.profile.*') || request()->routeIs('admin.settings.*') ? 'text-slate-950' : 'text-amber-300' }}"></i>
                            <span>Settings</span>
                        </a>

                    </div>
                </div>
            @endif

            {{ $slot }}
        </main>

        <!-- Minimal App Footer -->
        <footer class="py-5 px-6 border-t border-natural-darkBorder bg-[#0A100D] text-xs text-natural-textMuted">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-center sm:text-left">
                <div>
                    © {{ date('Y') }} Verdant Wealth Partners. Logged in as <span class="text-white font-semibold">{{ Auth::user()->name }}</span> (<span class="text-natural-sage font-bold capitalize">{{ Auth::user()->role }}</span>).
                </div>
                <div class="flex items-center gap-4 text-[11px]">
                    <span class="flex items-center gap-1.5 text-natural-sage"><i class="fa-solid fa-lock text-[10px]"></i> Bank-Grade SSL</span>
                    <span>•</span>
                    <span class="text-natural-mint">24/7 Automated Settlement</span>
                </div>
            </div>
        </footer>

    </div>

    <!-- Global Scripts -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('appSidebar');
            const backdrop = document.getElementById('mobileSidebarBackdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        // Toastr Global Configuration
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-top-right",
                showDuration: "300",
                hideDuration: "800",
                timeOut: "4500",
                extendedTimeOut: "1500",
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut"
            };

            @if (session('status'))
                toastr.success("{{ session('status') == 'profile-updated' ? 'Profile information updated successfully.' : (session('status') == 'password-updated' ? 'Password updated successfully.' : session('status')) }}");
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @endif
        }
    </script>

</body>
</html>
