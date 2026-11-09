<!DOCTYPE html>
<html lang="en" class="scroll-smooth dark">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verdant Wealth | Sustainable Daily Yields & Modern Investment Platform</title>
  
  <!-- Google Fonts: Editorial Serif + Clean Modern Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;1,9..144,400;1,9..144,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  
  <!-- Font Awesome Icons CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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

    .natural-dark-card {
      background-color: #131E18;
      border: 1px solid #23352B;
      box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.4);
      transition: all 0.25s ease;
    }

    .natural-dark-card:hover {
      border-color: #40916C;
      box-shadow: 0 16px 36px -8px rgba(0, 0, 0, 0.6);
      transform: translateY(-2px);
    }

    input[type=range] {
      -webkit-appearance: none;
      background: #23352B;
      height: 7px;
      border-radius: 9999px;
      outline: none;
    }
    input[type=range]::-webkit-slider-thumb {
      -webkit-appearance: none;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background: #52B788;
      border: 3px solid #0C1310;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
      cursor: pointer;
      transition: transform 0.15s ease, background-color 0.15s ease;
    }
    input[type=range]::-webkit-slider-thumb:hover {
      transform: scale(1.15);
      background: #74C69D;
    }

    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-track {
      background: #0C1310;
    }
    ::-webkit-scrollbar-thumb {
      background: #23352B;
      border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
      background: #40916C;
    }
  </style>
</head>
<body class="bg-natural-dark-pattern min-h-screen relative antialiased selection:bg-natural-moss selection:text-white text-natural-textPrimary">

  <!-- Top Announcement Bar (Slim, Minimal & Clean) -->
  <div class="bg-[#080E0B] text-natural-textMuted text-[11px] font-medium border-b border-white/[0.06] relative z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-9 flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-natural-forest/30 text-natural-mint border border-natural-moss/40">
          <span class="w-1.5 h-1.5 rounded-full bg-natural-sage animate-pulse"></span> LIVE
        </span>
        <span class="text-white font-medium">Daily 24h Yield: <strong class="text-natural-mint">+2.40%</strong></span>
        <span class="text-stone-700 hidden sm:inline">•</span>
        <span class="hidden sm:inline text-natural-textMuted">Instant Cashout: <strong class="text-white">$10.00 Min</strong></span>
      </div>

      <div class="flex items-center space-x-4 text-xs">
        <span class="hidden md:flex items-center gap-1.5 text-natural-textMuted text-[11px]">
          <i class="fa-solid fa-shield-halved text-natural-sage text-[10px]"></i> CertiK & Cold Escrow Audited
        </span>
        <span class="text-stone-700 hidden md:inline">•</span>
        <a href="{{ route('admin.login') }}" class="text-amber-400 hover:text-amber-300 transition text-[11px] font-semibold flex items-center gap-1">
          <i class="fa-solid fa-lock text-[10px]"></i> Admin Portal
        </a>
      </div>
    </div>
  </div>

  <!-- Navigation Bar (Sleek Glassmorphic 64px Header) -->
  <header class="sticky top-0 z-40 bg-[#0C1310]/85 backdrop-blur-xl border-b border-white/[0.06] transition-all duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      
      <!-- Brand Logo -->
      <a href="{{ url('/') }}" class="flex items-center space-x-2.5 group shrink-0">
        <div class="w-9 h-9 rounded-xl bg-natural-forest/80 border border-natural-moss/40 flex items-center justify-center text-natural-mint shadow-xs group-hover:bg-natural-forest transition">
          <i class="fa-solid fa-seedling text-base"></i>
        </div>
        <div class="flex items-baseline space-x-1.5">
          <span class="font-serif font-bold text-xl tracking-tight text-white group-hover:text-natural-mint transition">Verdant<span class="text-natural-sage">.</span></span>
          <span class="text-[9px] font-mono tracking-widest text-natural-textMuted uppercase font-bold">Wealth</span>
        </div>
      </a>

      <!-- Streamlined Navigation Links (Visible on Large Screens without Crowding) -->
      <nav class="hidden lg:flex items-center space-x-1 text-xs font-semibold text-natural-textMuted">
        <a href="#packages" class="px-3.5 py-2 rounded-lg hover:text-white hover:bg-white/[0.04] transition">Investment Plans</a>
        <a href="#calculator" class="px-3.5 py-2 rounded-lg hover:text-white hover:bg-white/[0.04] transition">Profit Calculator</a>
        <a href="#referrals" class="px-3.5 py-2 rounded-lg hover:text-white hover:bg-white/[0.04] transition flex items-center gap-1.5">
          <span>Referral Circle</span>
          <span class="bg-natural-forest/60 text-natural-mint border border-natural-moss/50 text-[10px] px-1.5 py-0.2 rounded-full font-bold">11%</span>
        </a>
        <a href="#how-it-works" class="px-3.5 py-2 rounded-lg hover:text-white hover:bg-white/[0.04] transition">How It Works</a>
        <a href="#withdrawals" class="px-3.5 py-2 rounded-lg hover:text-white hover:bg-white/[0.04] transition">$10 Cashout</a>
        <a href="#faq" class="px-3.5 py-2 rounded-lg hover:text-white hover:bg-white/[0.04] transition">FAQ</a>
      </nav>

      <!-- Right Action Cluster -->
      <div class="flex items-center space-x-3">
        @auth
          @if (Auth::user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-950 bg-amber-400 hover:bg-amber-300 transition flex items-center gap-1.5 shadow-sm">
              <i class="fa-solid fa-shield-halved text-xs"></i>
              <span>Admin Console</span>
            </a>
          @else
            <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-natural-forest hover:bg-natural-moss shadow-natural-btn transition flex items-center gap-1.5">
              <i class="fa-solid fa-chart-pie text-xs"></i>
              <span>My Portfolio</span>
            </a>
          @endif
        @else
          <a href="{{ route('login') }}" class="text-xs font-bold text-natural-textMuted hover:text-white px-3 py-2 rounded-lg transition hover:bg-white/[0.04]">
            Sign In
          </a>
          <a href="{{ route('register') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-natural-forest hover:bg-natural-moss border border-natural-moss/50 shadow-natural-btn transition transform active:scale-95 flex items-center gap-1.5">
            <span>Get Started</span>
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
          </a>
        @endauth

        <!-- Mobile Menu Toggle Button -->
        <button id="mobileMenuBtn" aria-label="Toggle navigation menu" class="lg:hidden w-9 h-9 rounded-lg bg-natural-darkCard border border-natural-darkBorder text-natural-textMuted hover:text-white flex items-center justify-center transition">
          <i class="fa-solid fa-bars text-sm"></i>
        </button>
      </div>

    </div>

    <!-- Mobile Dropdown Menu (Clean, Beautiful & Spacious) -->
    <div id="mobileMenu" class="hidden lg:hidden bg-natural-darkCard/95 backdrop-blur-2xl border-b border-natural-darkBorder px-5 py-4 space-y-2 shadow-2xl">
      <div class="grid grid-cols-2 gap-2 pb-3 border-b border-natural-darkBorder">
        <a href="#packages" class="p-2.5 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-xs text-natural-textPrimary hover:text-white font-medium flex items-center gap-2">
          <i class="fa-solid fa-layer-group text-natural-sage text-xs"></i> Plans
        </a>
        <a href="#calculator" class="p-2.5 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-xs text-natural-textPrimary hover:text-white font-medium flex items-center gap-2">
          <i class="fa-solid fa-calculator text-natural-sage text-xs"></i> Calculator
        </a>
        <a href="#referrals" class="p-2.5 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-xs text-natural-textPrimary hover:text-white font-medium flex items-center gap-2">
          <i class="fa-solid fa-share-nodes text-natural-sage text-xs"></i> Referrals (11%)
        </a>
        <a href="#how-it-works" class="p-2.5 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-xs text-natural-textPrimary hover:text-white font-medium flex items-center gap-2">
          <i class="fa-solid fa-circle-question text-natural-sage text-xs"></i> How It Works
        </a>
      </div>

      <div class="pt-2 flex flex-col gap-2">
        @auth
          <a href="{{ Auth::user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}" class="w-full py-2.5 text-center font-bold text-xs text-white bg-natural-forest rounded-xl">Go to Dashboard</a>
        @else
          <div class="flex gap-2">
            <a href="{{ route('login') }}" class="flex-1 py-2.5 text-center font-bold text-xs text-natural-textPrimary bg-natural-darkPaper border border-natural-darkBorder rounded-xl hover:bg-natural-darkCard">Sign In</a>
            <a href="{{ route('register') }}" class="flex-1 py-2.5 text-center font-bold text-xs text-white bg-natural-forest rounded-xl shadow-natural-btn">Register</a>
          </div>
          <a href="{{ route('login') }}?role=admin" class="w-full py-2 text-center font-bold text-[11px] text-amber-300 bg-amber-950/40 border border-amber-600/30 rounded-xl">
            <i class="fa-solid fa-shield text-[10px] mr-1"></i> Admin Console Login
          </a>
        @endauth
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <section class="relative pt-12 pb-20 md:pt-20 md:pb-28 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-10 items-center">
        
        <!-- Left: Editorial Value Proposition -->
        <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
          
          <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-natural-forest/30 border border-natural-moss/40 text-natural-mint text-xs font-bold">
            <span class="w-2 h-2 rounded-full bg-natural-sage animate-pulse"></span>
            <span>{{ cms('home.hero.badge', 'Natural Wealth Growth • Fixed Daily Payouts') }}</span>
          </div>

          <h1 class="font-serif font-bold text-4xl sm:text-5xl lg:text-6xl text-white leading-[1.14] tracking-tight">
            {{ cms('home.hero.title', 'Grow your money') }} <span class="italic text-natural-mint underline decoration-natural-sage decoration-4 underline-offset-4">{{ cms('home.hero.title_highlight', 'naturally') }}</span> with daily returns on your total balance.
          </h1>

          <p class="text-base sm:text-lg text-natural-textMuted max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
            {{ cms('home.hero.description', 'Subscribe to transparent, sustainable investment plans. Collect fixed daily profits credited every 24 hours directly to your available balance, and grow faster with our 3-tier community referral program.') }}
          </p>

          <!-- Key Trust Pills -->
          <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2.5 pt-1 text-xs font-semibold text-natural-textPrimary">
            <div class="flex items-center gap-1.5 bg-natural-darkCard border border-natural-darkBorder px-3.5 py-2 rounded-full shadow-sm">
              <i class="fa-solid fa-circle-check text-natural-sage"></i> Up to 4.2% Daily Profit
            </div>
            <div class="flex items-center gap-1.5 bg-natural-darkCard border border-natural-darkBorder px-3.5 py-2 rounded-full shadow-sm">
              <i class="fa-solid fa-wallet text-amber-400"></i> $10 Minimum Withdrawal
            </div>
            <div class="flex items-center gap-1.5 bg-natural-darkCard border border-natural-darkBorder px-3.5 py-2 rounded-full shadow-sm">
              <i class="fa-solid fa-users text-natural-mint"></i> 3-Tier Referral Rewards
            </div>
          </div>

          <!-- CTAs -->
          <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-4">
            <a href="#packages" class="w-full sm:w-auto px-8 py-4 rounded-xl text-sm font-bold text-white bg-natural-forest hover:bg-natural-moss shadow-natural-btn transition transform active:scale-95 text-center">
              {{ cms('home.hero.cta_primary', 'Explore Investment Plans') }}
            </a>
            <a href="#calculator" class="w-full sm:w-auto px-7 py-4 rounded-xl text-sm font-bold text-natural-textPrimary bg-natural-darkCard hover:bg-natural-darkCardHover border border-natural-darkBorder transition text-center flex items-center justify-center gap-2 shadow-sm">
              <i class="fa-solid fa-calculator text-natural-sage"></i>
              <span>{{ cms('home.hero.cta_secondary', 'Calculate Your Returns') }}</span>
            </a>
          </div>

          <!-- Proof Metrics Strip -->
          <div class="pt-6 border-t border-natural-darkBorder flex flex-wrap items-center justify-center lg:justify-start gap-6 text-xs text-natural-textMuted font-medium">
            <span class="flex items-center gap-2">
              <i class="fa-solid fa-lock text-natural-sage"></i> Bank-Grade Capital Security
            </span>
            <span class="flex items-center gap-2">
              <i class="fa-solid fa-clock-rotate-left text-natural-sage"></i> Daily 24-Hour Automated Settlement
            </span>
            <span class="flex items-center gap-2">
              <i class="fa-solid fa-shield-halved text-natural-sage"></i> Transparent Zero-Fee Withdrawals
            </span>
          </div>

        </div>

        <!-- Right: Elena Morales Realistic Card (Dark Styled) -->
        <div class="lg:col-span-5 relative">
          
          <div class="relative mx-auto max-w-md lg:max-w-none">
            
            <div class="bg-natural-darkCard rounded-3xl p-6 sm:p-7 border border-natural-darkBorder shadow-dark-card space-y-6">
              
              <!-- Account Header -->
              <div class="flex items-center justify-between pb-4 border-b border-natural-darkBorder">
                <div class="flex items-center space-x-3">
                  <div class="w-12 h-12 rounded-full bg-natural-darkPaper flex items-center justify-center text-natural-mint font-bold text-base border border-natural-darkBorder">
                    EM
                  </div>
                  <div>
                    <div class="font-bold text-sm text-white">Elena Morales</div>
                    <div class="text-xs text-natural-textMuted flex items-center gap-1.5">
                      <span>Verified Investor</span>
                      <span class="text-natural-sage font-bold">• Active</span>
                    </div>
                  </div>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold text-natural-mint bg-natural-forest/40 border border-natural-moss/40 px-2.5 py-1 rounded-full">
                  <i class="fa-solid fa-circle-check text-xs"></i> Canopy Plan
                </span>
              </div>

              <!-- Available Balance Highlight -->
              <div class="bg-natural-darkPaper p-5 rounded-2xl border border-natural-darkBorder space-y-2">
                <div class="flex justify-between items-center text-xs text-natural-textMuted">
                  <span>Total Available Balance</span>
                  <span class="text-natural-sage font-bold flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> +2.4% Today
                  </span>
                </div>
                <div class="text-3xl sm:text-4xl font-serif font-bold text-white tracking-tight" id="heroLiveBalance">
                  $14,840.50
                </div>
                <div class="grid grid-cols-2 gap-2 text-xs pt-3 border-t border-natural-darkBorder">
                  <div>
                    <span class="text-natural-textMuted block text-[11px]">Daily Profit:</span>
                    <span class="text-natural-mint font-bold text-sm">+$356.16 / day</span>
                  </div>
                  <div>
                    <span class="text-natural-textMuted block text-[11px]">Referral Bonuses:</span>
                    <span class="text-amber-400 font-bold text-sm">+$148.20 / day</span>
                  </div>
                </div>
              </div>

              <!-- Active Plan Status -->
              <div class="space-y-2">
                <div class="flex justify-between text-xs font-semibold text-natural-textPrimary">
                  <span class="flex items-center gap-1.5">
                    <i class="fa-solid fa-tree text-natural-sage"></i> Canopy Growth Package (60 Days)
                  </span>
                  <span class="text-natural-textMuted">Day 28 of 60</span>
                </div>
                <div class="w-full bg-natural-darkPaper h-2 rounded-full overflow-hidden">
                  <div class="bg-natural-sage h-2 rounded-full w-[46%] transition-all duration-700"></div>
                </div>
              </div>

              <!-- Unique Referral Link Box -->
              <div class="bg-natural-darkPaper p-3.5 rounded-xl border border-natural-darkBorder text-xs flex items-center justify-between">
                <div class="truncate mr-2">
                  <div class="text-natural-textMuted text-[10px] font-medium">Elena's Unique Referral Link:</div>
                  <div class="text-natural-sage font-mono text-xs font-semibold truncate">verdant.co/invite/elena92</div>
                </div>
                <button onclick="copyMockRef()" class="px-3 py-1.5 rounded-lg bg-natural-forest text-white hover:bg-natural-moss text-xs font-bold shrink-0 transition flex items-center gap-1.5 shadow-sm">
                  <i class="fa-regular fa-copy"></i>
                  <span id="heroCopyBtnText">Copy</span>
                </button>
              </div>

              <!-- Instant Withdrawal Eligibility -->
              <div class="flex items-center justify-between pt-1">
                <div class="text-xs text-natural-textMuted">
                  Available to Cash Out: <strong class="text-white">$3,240.00</strong>
                </div>
                <button onclick="openModal('registerModal')" class="text-xs bg-natural-darkPaper hover:bg-natural-darkBorder text-natural-mint px-3.5 py-1.5 rounded-lg font-bold transition border border-natural-darkBorder">
                  Withdraw Funds
                </button>
              </div>

            </div>

            <!-- Floating Pill Badge -->
            <div class="absolute -bottom-4 -left-4 bg-natural-darkCard border border-natural-darkBorder p-3 rounded-2xl shadow-xl hidden sm:flex items-center space-x-3">
              <div class="w-9 h-9 rounded-xl bg-natural-forest/40 text-natural-mint flex items-center justify-center font-bold text-sm">
                <i class="fa-solid fa-hand-holding-dollar"></i>
              </div>
              <div class="text-xs">
                <div class="text-natural-textMuted text-[10px]">Instant Payout Received</div>
                <div class="font-bold text-natural-sage">+$180.00 sent to Bank/USDT</div>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- Community Statistics Strip -->
  <section class="border-y border-natural-darkBorder bg-[#0A110E] py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
        
        <div class="space-y-1">
          <div class="font-serif font-bold text-3xl sm:text-4xl text-white">
            ${{ $totalManaged > 1000000 ? number_format($totalManaged / 1000000, 1) . 'M+' : number_format($totalManaged, 2) }}
          </div>
          <div class="text-xs sm:text-sm text-natural-textMuted font-semibold">{{ cms('home.stats.capital_label', 'Total Capital Managed') }}</div>
        </div>

        <div class="space-y-1">
          <div class="font-serif font-bold text-3xl sm:text-4xl text-natural-mint">
            ${{ $totalYieldsPaid > 1000000 ? number_format($totalYieldsPaid / 1000000, 1) . 'M+' : number_format($totalYieldsPaid, 2) }}
          </div>
          <div class="text-xs sm:text-sm text-natural-textMuted font-semibold">{{ cms('home.stats.yields_label', 'Daily Yields Paid to Members') }}</div>
        </div>

        <div class="space-y-1">
          <div class="font-serif font-bold text-3xl sm:text-4xl text-white">
            {{ number_format($totalMembers) }}+
          </div>
          <div class="text-xs sm:text-sm text-natural-textMuted font-semibold">{{ cms('home.stats.investors_label', 'Active Global Investors') }}</div>
        </div>

        <div class="space-y-1">
          <div class="font-serif font-bold text-3xl sm:text-4xl text-amber-400">
            {{ number_format($referralRate, 1) }}%
          </div>
          <div class="text-xs sm:text-sm text-natural-textMuted font-semibold">{{ cms('home.stats.commission_label', 'Direct Referral Commission') }}</div>
        </div>

      </div>
    </div>
  </section>

  <!-- How It Works (The Natural Growth Cycle) -->
  <section id="how-it-works" class="py-20 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
        <span class="text-xs font-bold uppercase tracking-widest text-natural-sage">{{ cms('home.how.badge', 'Simple & Transparent Flow') }}</span>
        <h2 class="font-serif font-bold text-3xl sm:text-4xl text-white">{{ cms('home.how.title', 'The Natural Path to Daily Returns') }}</h2>
        <p class="text-natural-textMuted text-sm sm:text-base">
          {{ cms('home.how.description', 'No complex formulas or confusing barriers. Follow four simple steps to begin generating predictable daily cash flow.') }}
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        
        <div class="natural-dark-card rounded-2xl p-6 sm:p-7 relative group">
          <div class="w-12 h-12 rounded-xl bg-natural-darkPaper text-natural-sage flex items-center justify-center font-bold text-lg mb-5 group-hover:bg-natural-forest/40 transition">
            01
          </div>
          <h3 class="font-bold text-lg text-white mb-2">Create Account</h3>
          <p class="text-natural-textMuted text-xs sm:text-sm leading-relaxed">
            Register in 60 seconds. Set up two-factor authentication to secure your capital.
          </p>
          <div class="mt-4 text-xs text-natural-sage font-semibold flex items-center gap-1.5">
            <i class="fa-solid fa-check"></i> Zero setup fees
          </div>
        </div>

        <div class="natural-dark-card rounded-2xl p-6 sm:p-7 relative group">
          <div class="w-12 h-12 rounded-xl bg-natural-darkPaper text-natural-sage flex items-center justify-center font-bold text-lg mb-5 group-hover:bg-natural-forest/40 transition">
            02
          </div>
          <h3 class="font-bold text-lg text-white mb-2">Select Your Plan</h3>
          <p class="text-natural-textMuted text-xs sm:text-sm leading-relaxed">
            Choose a plan tailored to your budget from $50 up to $20,000+. Fund easily via card or crypto.
          </p>
          <div class="mt-4 text-xs text-natural-sage font-semibold flex items-center gap-1.5">
            <i class="fa-solid fa-check"></i> 100% Principal Returned
          </div>
        </div>

        <div class="natural-dark-card rounded-2xl p-6 sm:p-7 relative group">
          <div class="w-12 h-12 rounded-xl bg-natural-darkPaper text-natural-sage flex items-center justify-center font-bold text-lg mb-5 group-hover:bg-natural-forest/40 transition">
            03
          </div>
          <h3 class="font-bold text-lg text-white mb-2">Earn Daily Profit</h3>
          <p class="text-natural-textMuted text-xs sm:text-sm leading-relaxed">
            Your fixed percentage is automatically credited every 24 hours based on your total balance.
          </p>
          <div class="mt-4 text-xs text-natural-sage font-semibold flex items-center gap-1.5">
            <i class="fa-solid fa-check"></i> Daily compounding
          </div>
        </div>

        <div class="natural-dark-card rounded-2xl p-6 sm:p-7 relative group">
          <div class="w-12 h-12 rounded-xl bg-natural-darkPaper text-natural-sage flex items-center justify-center font-bold text-lg mb-5 group-hover:bg-natural-forest/40 transition">
            04
          </div>
          <h3 class="font-bold text-lg text-white mb-2">{{ cms('home.how.step4_title', 'Withdraw or Share') }}</h3>
          <p class="text-natural-textMuted text-xs sm:text-sm leading-relaxed">
            {{ cms('home.how.step4_desc', 'Cash out anytime once your balance reaches $10, or share your link to earn daily referral rewards.') }}
          </p>
          <div class="mt-4 text-xs text-natural-sage font-semibold flex items-center gap-1.5">
            <i class="fa-solid fa-check"></i> Fast 24/7 Processing
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- Investment Packages Section -->
  <section id="packages" class="py-20 bg-[#0A110E] border-y border-natural-darkBorder">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
        <span class="text-xs font-bold uppercase tracking-widest text-natural-sage">{{ cms('home.packages.badge', 'Curated Investment Tiers') }}</span>
        <h2 class="font-serif font-bold text-3xl sm:text-5xl text-white">{{ cms('home.packages.title', 'Sustainable Growth Packages') }}</h2>
        <p class="text-natural-textMuted text-sm sm:text-base">
          {{ cms('home.packages.description', 'Every package offers guaranteed daily fixed profit calculated on your available balance, with full capital return upon contract maturity.') }}
        </p>
      </div>

      <!-- Packages Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 items-stretch">
        @forelse ($packages as $index => $pkg)
          @php
            $isFeatured = $index === 1;
            $termDays = $pkg->duration_days ?: 30;
            $estTotalYield = $pkg->daily_commission_percent * $termDays;
          @endphp
          <div class="natural-dark-card rounded-2xl p-6 sm:p-7 flex flex-col justify-between {{ $isFeatured ? 'border-2 border-natural-forest shadow-dark-card relative scale-[1.02] bg-natural-darkCard' : '' }}">
            @if ($isFeatured)
              <div class="absolute -top-3.5 left-1/2 transform -translate-x-1/2 bg-natural-forest text-natural-mint text-[10px] uppercase font-bold px-3.5 py-1 rounded-full shadow-md tracking-wider">
                Most Popular Choice
              </div>
            @endif
            <div>
              <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold tracking-wider uppercase text-natural-textMuted font-mono">Tier {{ sprintf('%02d', $index + 1) }}</span>
                <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-natural-darkPaper text-natural-textPrimary border border-natural-darkBorder">
                  {{ $pkg->investment_amount >= 5000 ? 'Institutional' : ($pkg->investment_amount >= 1000 ? 'Growth' : 'Starter') }}
                </span>
              </div>
              <h3 class="font-serif font-bold text-2xl text-white">{{ $pkg->name }}</h3>
              <p class="text-xs text-natural-textMuted mt-1 mb-5">{{ $pkg->description ?: 'Automated 24-hour compounding daily returns.' }}</p>
              
              <div class="bg-natural-darkPaper rounded-xl p-4 mb-6 border border-natural-darkBorder">
                <div class="text-3xl font-serif font-bold text-natural-mint font-mono">+{{ number_format($pkg->daily_commission_percent, 2) }}% <span class="text-xs font-sans font-medium text-natural-textMuted">/ day</span></div>
                <div class="text-xs text-natural-textPrimary mt-1 font-semibold font-mono">Est. 30-Day Return: <strong>+{{ number_format($estTotalYield, 1) }}%</strong></div>
              </div>

              <ul class="space-y-3 text-xs text-natural-textPrimary font-mono">
                <li class="flex items-center justify-between pb-2 border-b border-natural-darkBorder">
                  <span class="text-natural-textMuted font-sans">Investment Amount:</span>
                  <span class="font-bold text-white">${{ number_format($pkg->investment_amount, 2) }}</span>
                </li>
                <li class="flex items-center justify-between pb-2 border-b border-natural-darkBorder">
                  <span class="text-natural-textMuted font-sans">Payout Frequency:</span>
                  <span class="text-natural-sage font-bold">Every 24 Hours</span>
                </li>
                <li class="flex items-center justify-between pb-2 border-b border-natural-darkBorder">
                  <span class="text-natural-textMuted font-sans">Min. Cashout Limit:</span>
                  <span class="font-bold text-amber-300">${{ number_format($pkg->min_withdrawal_limit ?: 10.00, 2) }}</span>
                </li>
                <li class="flex items-center justify-between pb-2 border-b border-natural-darkBorder">
                  <span class="text-natural-textMuted font-sans">Capital Lock Period:</span>
                  <span class="font-bold text-white">30 Days (Escrow)</span>
                </li>
                <li class="flex items-center justify-between">
                  <span class="text-natural-textMuted font-sans">Daily Profit Cashout:</span>
                  <span class="text-natural-mint font-bold">Anytime ($10 Min)</span>
                </li>
              </ul>
            </div>

            <div class="mt-8 pt-4 border-t border-natural-darkBorder">
              <button onclick="selectPackageForCalc('{{ addslashes($pkg->name) }}', {{ $pkg->daily_commission_percent }}, {{ $pkg->investment_amount }}, {{ $pkg->investment_amount * 5 }}, {{ $termDays }})" class="w-full py-3 rounded-xl font-bold text-xs uppercase tracking-wider {{ $isFeatured ? 'text-white bg-natural-forest hover:bg-natural-moss shadow-natural-btn' : 'text-natural-textPrimary bg-natural-darkPaper hover:bg-natural-darkCardHover border border-natural-darkBorder' }} transition cursor-pointer">
                Select {{ $pkg->name }} Plan
              </button>
            </div>
          </div>
        @empty
          <div class="col-span-4 text-center py-12 text-natural-textMuted font-mono">
            No active packages currently configured.
          </div>
        @endforelse
      </div>

    </div>
  </section>

  <!-- Interactive Profit Calculator -->
  <section id="calculator" class="py-20 relative">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="bg-natural-darkCard rounded-3xl p-6 sm:p-10 border border-natural-darkBorder shadow-dark-card">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
          
          <!-- Slider & Form Controls -->
          <div class="lg:col-span-7 space-y-6">
            <div>
              <span class="text-xs font-bold text-natural-sage uppercase tracking-widest">{{ cms('home.calc.badge', 'Real-Time Yield Calculator') }}</span>
              <h2 class="font-serif font-bold text-3xl sm:text-4xl text-white mt-1">{{ cms('home.calc.title', 'Estimate Your Daily Returns') }}</h2>
              <p class="text-natural-textMuted text-xs sm:text-sm mt-1">
                {{ cms('home.calc.description', 'Select your preferred growth plan and investment amount to simulate your daily cash flow and total maturity profit.') }}
              </p>
            </div>

            <!-- Tier Selection Buttons -->
            <div>
              <label class="block text-xs font-bold text-natural-textPrimary mb-2">Select Investment Tier:</label>
              <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                @forelse ($packages as $pIndex => $pkg)
                  <button type="button" 
                    onclick="setCalcPlan('{{ addslashes($pkg->name) }}', {{ (float)$pkg->daily_commission_percent }}, 30, {{ (float)$pkg->investment_amount }}, {{ (float)($pkg->investment_amount * 5) }}, '{{ \Illuminate\Support\Str::slug($pkg->name) }}')" 
                    id="btn-calc-{{ \Illuminate\Support\Str::slug($pkg->name) }}" 
                    class="calc-plan-btn py-2.5 px-3 rounded-xl text-xs font-bold {{ $pIndex === 0 ? 'border-2 border-natural-forest bg-natural-forest/40 text-natural-mint' : 'border border-natural-darkBorder bg-natural-darkPaper text-natural-textPrimary hover:border-natural-sage' }} transition">
                    {{ $pkg->name }} ({{ number_format($pkg->daily_commission_percent, 1) }}%)
                  </button>
                @empty
                  <button type="button" onclick="setCalcPlan('Standard', 2.0, 30, 100, 5000, 'standard')" id="btn-calc-standard" class="calc-plan-btn py-2.5 px-3 rounded-xl text-xs font-bold border-2 border-natural-forest bg-natural-forest/40 text-natural-mint transition">
                    Standard (2.0%)
                  </button>
                @endforelse
              </div>
            </div>

            <!-- Amount Input & Slider -->
            <div class="space-y-3">
              <div class="flex justify-between items-center">
                <label class="text-xs font-bold text-natural-textPrimary">Investment Capital ($ USD):</label>
                <div class="relative">
                  <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-natural-textMuted font-bold">$</span>
                  <input type="number" id="calcInputAmount" value="2500" min="50" max="100000" class="w-36 bg-natural-darkPaper border border-natural-darkBorder rounded-xl pl-8 pr-3 py-1.5 text-sm font-bold text-white text-right focus:border-natural-sage focus:outline-none">
                </div>
              </div>

              <input type="range" id="calcRangeSlider" min="50" max="50000" step="50" value="2500" class="w-full">
              
              <div class="flex justify-between text-[11px] text-natural-textMuted font-medium">
                <span>$50 Min</span>
                <span id="sliderMidLabel">$25,000</span>
                <span>$50,000+</span>
              </div>
            </div>

            <!-- Duration & Crediting Note -->
            <div class="p-3.5 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-xs text-natural-textPrimary flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
              <span class="flex items-center gap-2">
                <i class="fa-regular fa-calendar-check text-natural-sage"></i>
                <span>Contract Duration: <strong id="calcDurationDisplay" class="text-white">45 Days</strong></span>
              </span>
              <span class="flex items-center gap-1.5 text-natural-sage font-semibold">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span>Credited Every 24 Hours</span>
              </span>
            </div>

          </div>

          <!-- Output Summary Card -->
          <div class="lg:col-span-5">
            <div class="bg-gradient-to-b from-[#16251E] to-[#101A15] text-white p-6 sm:p-7 rounded-2xl shadow-xl border border-natural-moss/30 space-y-5">
              
              <div class="border-b border-natural-darkBorder pb-3 flex items-center justify-between">
                <span class="text-xs text-natural-textMuted uppercase tracking-wider font-semibold">Projected Earning</span>
                <span class="text-xs px-2.5 py-0.5 rounded-full bg-natural-forest/50 text-natural-mint font-bold border border-natural-moss/40" id="calcActivePlanBadge">{{ $packages->first() ? $packages->first()->name . ' (' . number_format($packages->first()->daily_commission_percent, 1) . '%)' : 'Select Plan' }}</span>
              </div>

              <div class="space-y-4">
                
                <!-- Daily Profit -->
                <div class="flex justify-between items-baseline">
                  <span class="text-xs text-natural-textMuted">Daily Return:</span>
                  <div class="text-right">
                    <span class="text-2xl font-serif font-bold text-natural-mint" id="calcDailyProfit">$62.50</span>
                    <span class="text-[10px] text-natural-textMuted block">credited automatically</span>
                  </div>
                </div>

                <!-- Weekly Profit -->
                <div class="flex justify-between items-baseline pt-2 border-t border-natural-darkBorder">
                  <span class="text-xs text-natural-textMuted">Weekly Return (7 Days):</span>
                  <span class="text-base font-bold text-white" id="calcWeeklyProfit">$437.50</span>
                </div>

                <!-- Total Net Profit -->
                <div class="flex justify-between items-baseline pt-2 border-t border-natural-darkBorder">
                  <span class="text-xs text-natural-textMuted">Total Net Yield:</span>
                  <span class="text-base font-bold text-natural-sage" id="calcTotalNetProfit">$2,812.50</span>
                </div>

                <!-- Total Payout with Capital -->
                <div class="p-4 rounded-xl bg-natural-darkPaper border border-natural-darkBorder flex justify-between items-center">
                  <div>
                    <span class="text-xs font-bold text-white block">Total Maturity Payout</span>
                    <span class="text-[10px] text-natural-textMuted">100% Capital returned at term end</span>
                  </div>
                  <div class="text-xl font-serif font-bold text-natural-mint" id="calcTotalReturn">$5,312.50</div>
                </div>

                <!-- Referral Preview Pill -->
                <div class="text-[11px] text-natural-textMuted bg-natural-darkBg p-3 rounded-lg border border-natural-darkBorder flex items-center gap-2">
                  <i class="fa-solid fa-users text-amber-400"></i>
                  <span>Invite 1 partner at this amount and earn an extra <strong class="text-white" id="calcRefBonusPreview">$0.00</strong> instant ({{ number_format($referralRate, 1) }}%) bonus!</span>
                </div>

              </div>

              <button onclick="openModal('registerModal')" class="w-full py-3.5 rounded-xl font-bold text-sm text-slate-950 bg-natural-mint hover:bg-white transition shadow-md">
                {{ cms('home.calc.cta_button', 'Lock In This Plan & Start Earning') }}
              </button>

            </div>
          </div>

        </div>

      </div>

    </div>
  </section>

  <!-- Referral Program Section -->
  <section id="referrals" class="py-20 bg-[#0A110E] border-t border-natural-darkBorder">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        
        <!-- Left Column: The 3-Tier Multi-Level Program -->
        <div class="lg:col-span-7 space-y-6">
          <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-natural-forest/40 border border-natural-moss/40 text-natural-mint text-xs font-bold">
            <i class="fa-solid fa-share-nodes"></i> {{ cms('home.ref.badge', 'Community Growth & Affiliates') }}
          </div>

          <h2 class="font-serif font-bold text-3xl sm:text-4xl lg:text-5xl text-white leading-tight">
            {{ cms('home.ref.title', 'Share your personal link. Grow together with') }} <span class="italic text-natural-mint">{{ cms('home.ref.title_highlight', 'daily community rewards.') }}</span>
          </h2>

          <p class="text-natural-textMuted text-sm sm:text-base leading-relaxed">
            {{ cms('home.ref.description', 'Every registered member gets their own dedicated invitation link. When friends or peers subscribe to any plan, you receive both an instant commission on their deposit plus a recurring percentage of their daily profit every single day!') }}
          </p>

          <!-- The 3 Tiers Cards -->
          <div class="space-y-3.5 pt-2">
            
            <div class="bg-natural-darkCard p-4 rounded-xl border border-natural-darkBorder flex items-center justify-between shadow-sm">
              <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-xl bg-natural-forest/40 border border-natural-moss/40 text-natural-mint flex items-center justify-center font-bold text-base">
                  1
                </div>
                <div>
                  <h4 class="font-bold text-sm text-white">Level 1: Direct Referrals</h4>
                  <p class="text-xs text-natural-textMuted">Anyone who registers directly with your unique link.</p>
                </div>
              </div>
              <div class="text-right">
                <div class="text-base font-serif font-bold text-natural-mint">{{ number_format($referralRate, 1) }}% <span class="text-xs font-normal text-natural-textMuted">Instant</span></div>
                <div class="text-[11px] text-natural-sage font-semibold">+ 1.5% Daily Matching</div>
              </div>
            </div>

            <div class="bg-natural-darkCard p-4 rounded-xl border border-natural-darkBorder flex items-center justify-between shadow-sm">
              <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-xl bg-natural-darkPaper text-natural-textPrimary flex items-center justify-center font-bold text-base border border-natural-darkBorder">
                  2
                </div>
                <div>
                  <h4 class="font-bold text-sm text-white">Level 2: Extended Circle</h4>
                  <p class="text-xs text-natural-textMuted">Members invited by your direct referrals.</p>
                </div>
              </div>
              <div class="text-right">
                <div class="text-base font-serif font-bold text-white">3.0% <span class="text-xs font-normal text-natural-textMuted">Instant</span></div>
                <div class="text-[11px] text-natural-textMuted font-semibold">+ 0.8% Daily Matching</div>
              </div>
            </div>

            <div class="bg-natural-darkCard p-4 rounded-xl border border-natural-darkBorder flex items-center justify-between shadow-sm">
              <div class="flex items-center space-x-4">
                <div class="w-10 h-10 rounded-xl bg-natural-darkPaper text-natural-textPrimary flex items-center justify-center font-bold text-base border border-natural-darkBorder">
                  3
                </div>
                <div>
                  <h4 class="font-bold text-sm text-white">Level 3: Community Network</h4>
                  <p class="text-xs text-natural-textMuted">Third generation members in your network.</p>
                </div>
              </div>
              <div class="text-right">
                <div class="text-base font-serif font-bold text-white">1.0% <span class="text-xs font-normal text-natural-textMuted">Instant</span></div>
                <div class="text-[11px] text-natural-textMuted font-semibold">+ 0.4% Daily Matching</div>
              </div>
            </div>

          </div>

          <div class="text-xs text-natural-textMuted flex items-center gap-2 pt-1 font-medium">
            <i class="fa-solid fa-circle-check text-natural-sage"></i>
            <span>No referral cap. Daily matching commissions are credited to your withdrawable balance indefinitely.</span>
          </div>

        </div>

        <!-- Right Column: Interactive Link Generator & Preview -->
        <div class="lg:col-span-5">
          <div class="bg-natural-darkCard p-6 sm:p-8 rounded-3xl border border-natural-darkBorder shadow-dark-card space-y-6">
            
            <div class="flex items-center justify-between border-b border-natural-darkBorder pb-4">
              <span class="text-xs uppercase font-bold text-natural-sage tracking-wider">Your Referral Link Generator</span>
              <span class="text-[11px] bg-natural-forest/40 border border-natural-moss/40 text-natural-mint px-2.5 py-0.5 rounded-full font-bold">Live Preview</span>
            </div>

            <!-- Interactive Username Input -->
            <div class="space-y-3">
              <label class="block text-xs font-bold text-natural-textPrimary">Enter your desired username:</label>
              <div class="flex rounded-xl overflow-hidden border border-natural-darkBorder bg-natural-darkPaper focus-within:border-natural-sage">
                <span class="px-3.5 py-2.5 bg-[#101814] text-natural-textMuted text-xs font-mono select-none">verdant.co/invite/</span>
                <input type="text" id="demoRefUsername" value="grow_daily" oninput="updateDemoRefLink()" class="w-full bg-transparent px-3 py-2 text-sm text-white font-mono font-medium focus:outline-none">
              </div>

              <!-- Shareable Link Box -->
              <div class="p-3 bg-natural-darkPaper rounded-xl border border-natural-darkBorder flex items-center justify-between">
                <div class="truncate text-xs font-mono text-natural-sage font-semibold mr-2" id="generatedLinkPreview">
                  https://verdant.co/invite/grow_daily
                </div>
                <button onclick="copyGeneratedLink()" class="px-3 py-1.5 rounded-lg bg-natural-forest text-white text-xs font-bold hover:bg-natural-moss transition shrink-0 flex items-center gap-1.5 shadow-sm">
                  <i class="fa-regular fa-copy"></i>
                  <span id="genLinkBtnText">Copy</span>
                </button>
              </div>
            </div>

            <!-- Simulated Earnings Widget -->
            <div class="p-5 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder space-y-3">
              <div class="text-xs text-natural-textMuted font-semibold">Simulated Community Activity:</div>
              <div class="grid grid-cols-3 gap-2 text-center">
                <div class="p-2.5 bg-natural-darkCard rounded-xl border border-natural-darkBorder">
                  <div class="text-lg font-serif font-bold text-white">28</div>
                  <div class="text-[10px] text-natural-textMuted">Invited Members</div>
                </div>
                <div class="p-2.5 bg-natural-darkCard rounded-xl border border-natural-darkBorder">
                  <div class="text-lg font-serif font-bold text-natural-mint">$26.5k</div>
                  <div class="text-[10px] text-natural-textMuted">Network Volume</div>
                </div>
                <div class="p-2.5 bg-natural-darkCard rounded-xl border border-natural-darkBorder">
                  <div class="text-lg font-serif font-bold text-amber-400">$1,855</div>
                  <div class="text-[10px] text-natural-textMuted">Bonus Earned</div>
                </div>
              </div>
              <div class="text-[11px] text-natural-sage font-semibold flex items-center gap-1.5 pt-1">
                <i class="fa-solid fa-seedling text-natural-sage"></i>
                <span>Daily matching profit earned today: <strong>+$44.50</strong></span>
              </div>
            </div>

            <button onclick="openModal('registerModal')" class="w-full py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider text-white bg-natural-forest hover:bg-natural-moss transition shadow-natural-btn">
              Claim Your Unique Referral Link
            </button>

          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- Withdrawals & Financial Freedom Section -->
  <section id="withdrawals" class="py-20 bg-natural-darkBg border-y border-natural-darkBorder">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
        <span class="text-xs font-bold uppercase tracking-widest text-natural-sage">Honest & Accessible</span>
        <h2 class="font-serif font-bold text-3xl sm:text-4xl text-white">Withdraw Anytime from Just $10</h2>
        <p class="text-natural-textMuted text-sm sm:text-base">
          We believe you should always have access to your money. As soon as your daily balance hits $10, you can cash out with zero waiting periods.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="natural-dark-card rounded-2xl p-7 border border-natural-darkBorder">
          <div class="w-12 h-12 rounded-xl bg-natural-forest/40 border border-natural-moss/40 text-natural-mint flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-coins"></i>
          </div>
          <h3 class="font-bold text-lg text-white mb-2">$10 Minimum Payout</h3>
          <p class="text-xs sm:text-sm text-natural-textMuted leading-relaxed">
            No mandatory $100+ lockouts. Start seeing tangible returns in your own bank or crypto wallet from day one.
          </p>
          <div class="mt-4 text-xs font-bold text-natural-sage">Accessible to every plan tier</div>
        </div>

        <div class="natural-dark-card rounded-2xl p-7 border border-natural-darkBorder">
          <div class="w-12 h-12 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-natural-sage flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-bolt"></i>
          </div>
          <h3 class="font-bold text-lg text-white mb-2">Automated Instant Clearing</h3>
          <p class="text-xs sm:text-sm text-natural-textMuted leading-relaxed">
            Withdrawal requests are processed automatically through secure liquidity reserves, typically arriving in 5 to 15 minutes.
          </p>
          <div class="mt-4 text-xs font-bold text-natural-sage">Zero hidden withdrawal fees</div>
        </div>

        <div class="natural-dark-card rounded-2xl p-7 border border-natural-darkBorder">
          <div class="w-12 h-12 rounded-xl bg-amber-950/60 border border-amber-600/40 text-amber-300 flex items-center justify-center text-xl mb-4">
            <i class="fa-solid fa-building-columns"></i>
          </div>
          <h3 class="font-bold text-lg text-white mb-2">Flexible Payment Channels</h3>
          <p class="text-xs sm:text-sm text-natural-textMuted leading-relaxed">
            Cash out seamlessly to Tether USDT (TRC-20, ERC-20), Bitcoin, Ethereum, or directly to your local bank account via wire.
          </p>
          <div class="mt-4 text-xs font-bold text-amber-400">256-bit encrypted settlement</div>
        </div>

      </div>

    </div>
  </section>

  <!-- Dual Dashboard Architecture Preview -->
  <section id="dashboards" class="py-20 relative bg-[#0A110E]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center max-w-2xl mx-auto mb-12 space-y-3">
        <span class="text-xs font-bold uppercase tracking-widest text-natural-sage">Tailored Environments</span>
        <h2 class="font-serif font-bold text-3xl sm:text-5xl text-white">Designed for Users & Administrators</h2>
        <p class="text-natural-textMuted text-sm sm:text-base">
          Explore both sides of our platform: the intuitive Investor Portal and the comprehensive Admin Management Console.
        </p>
      </div>

      <!-- Tab Switcher -->
      <div class="flex justify-center mb-10">
        <div class="p-1.5 bg-natural-darkPaper rounded-2xl border border-natural-darkBorder inline-flex space-x-2">
          <button id="tabUserDashBtn" onclick="switchDashboardTab('user')" class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-natural-forest text-white transition flex items-center gap-2 shadow-sm">
            <i class="fa-solid fa-user"></i> Investor Portal Preview
          </button>
          <button id="tabAdminDashBtn" onclick="switchDashboardTab('admin')" class="px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-natural-textMuted hover:text-white transition flex items-center gap-2">
            <i class="fa-solid fa-shield-halved text-amber-400"></i> Admin Console Preview
          </button>
        </div>
      </div>

      <!-- View 1: User Dashboard Preview -->
      <div id="viewUserDash" class="bg-natural-darkCard rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-dark-card space-y-6">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-4 border-b border-natural-darkBorder">
          <div>
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-natural-sage"></span>
              <h3 class="font-serif font-bold text-xl text-white">Investor Dashboard Interface</h3>
            </div>
            <p class="text-xs text-natural-textMuted mt-0.5">Clean, peaceful portfolio overview showing daily yields, referral income, and 1-click withdrawals.</p>
          </div>
          <button onclick="openModal('loginModal', 'user')" class="px-4 py-2 rounded-xl bg-natural-forest/40 border border-natural-moss/40 text-natural-mint hover:bg-natural-forest text-xs font-bold transition flex items-center gap-1.5">
            <span>Open Demo Portal</span>
            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
          <!-- Balance Widget -->
          <div class="p-5 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder space-y-3">
            <div class="text-xs text-natural-textMuted flex justify-between">
              <span>Account Available Balance</span>
              <span class="text-natural-sage font-bold">+2.5% Daily</span>
            </div>
            <div class="text-2xl font-serif font-bold text-white">$8,450.00</div>
            <div class="flex gap-2 pt-1">
              <button onclick="openModal('registerModal')" class="flex-1 py-1.5 rounded-lg bg-natural-forest text-white font-bold text-xs hover:bg-natural-moss transition">Deposit</button>
              <button onclick="openModal('registerModal')" class="flex-1 py-1.5 rounded-lg bg-natural-darkCard border border-natural-darkBorder text-natural-textPrimary font-bold text-xs hover:bg-natural-darkCardHover transition">Withdraw</button>
            </div>
          </div>

          <!-- Active Package Widget -->
          <div class="p-5 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder space-y-2">
            <div class="text-xs text-natural-textMuted flex justify-between">
              <span>Active Subscriptions</span>
              <span class="text-natural-sage font-bold">2 Active</span>
            </div>
            <div class="text-sm font-bold text-white">Bloom Growth ($3,000)</div>
            <div class="text-[11px] text-natural-textMuted">Daily yield: $75.00 • Next credit in 03h 40m</div>
            <div class="w-full bg-natural-darkCard h-1.5 rounded-full mt-2">
              <div class="bg-natural-sage h-1.5 rounded-full w-3/5"></div>
            </div>
          </div>

          <!-- Referral Summary -->
          <div class="p-5 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder space-y-2">
            <div class="text-xs text-natural-textMuted flex justify-between">
              <span>Referral Network</span>
              <span class="text-natural-sage font-bold">3 Tiers</span>
            </div>
            <div class="text-xs font-mono text-natural-sage font-semibold truncate">verdant.co/invite/investor_99</div>
            <div class="text-xs text-natural-textPrimary">Total Downline Earned: <strong>$840.00</strong></div>
            <div class="text-[11px] text-natural-sage font-semibold"><i class="fa-solid fa-users"></i> 14 Active Referrals</div>
          </div>
        </div>

        <div class="p-4 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-xs text-natural-textPrimary flex flex-wrap items-center justify-between gap-4">
          <div class="flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-natural-sage text-lg"></i>
            <span><strong>Investor Flow:</strong> Deposit Funds → Subscribe Package → Automatic 24h Daily Yield on Balance → Instant Cashout from $10.</span>
          </div>
          <button onclick="openModal('registerModal')" class="text-natural-sage font-bold hover:underline">Get Started as Investor →</button>
        </div>

      </div>

      <!-- View 2: Admin Dashboard Preview -->
      <div id="viewAdminDash" class="hidden bg-natural-darkCard rounded-3xl p-6 sm:p-8 border border-amber-600/30 shadow-dark-card space-y-6">
        
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-4 border-b border-natural-darkBorder">
          <div>
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-pulse"></span>
              <h3 class="font-serif font-bold text-xl text-white">Admin Management Console</h3>
            </div>
            <p class="text-xs text-natural-textMuted mt-0.5">Control panel for setting daily percentage yields, auditing withdrawals, and managing package rules.</p>
          </div>
          <a href="{{ route('login') }}?role=admin" class="px-4 py-2 rounded-xl bg-amber-950/60 border border-amber-600/40 text-amber-300 hover:bg-amber-900 text-xs font-bold transition flex items-center gap-1.5">
            <span>Admin Sign In</span>
            <i class="fa-solid fa-lock text-[10px]"></i>
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
          <div class="p-4 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder">
            <span class="text-xs text-natural-textMuted">Total Members</span>
            <div class="text-xl font-serif font-bold text-white mt-1">62,480</div>
            <span class="text-[10px] text-natural-sage font-semibold">+92 registered today</span>
          </div>
          <div class="p-4 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder">
            <span class="text-xs text-natural-textMuted">Escrow Reserves</span>
            <div class="text-xl font-serif font-bold text-natural-mint mt-1">$42,810,000</div>
            <span class="text-[10px] text-natural-textMuted">Audited Cold Storage</span>
          </div>
          <div class="p-4 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder">
            <span class="text-xs text-natural-textMuted">Withdrawals Queue</span>
            <div class="text-xl font-serif font-bold text-white mt-1">0 Pending</div>
            <span class="text-[10px] text-natural-sage font-semibold">100% automated clearing</span>
          </div>
          <div class="p-4 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder">
            <span class="text-xs text-natural-textMuted">Daily ROI Engine</span>
            <div class="text-xl font-serif font-bold text-white mt-1">Active (24h)</div>
            <span class="text-[10px] text-natural-textMuted">Next cycle in 02h 15m</span>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
          <div class="p-4 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-xs space-y-1">
            <div class="font-bold text-white flex items-center gap-2">
              <i class="fa-solid fa-sliders text-amber-400"></i> Package Yield Configuration
            </div>
            <p class="text-natural-textMuted">Adjust base percentages, contract durations, and minimum thresholds dynamically.</p>
          </div>
          <div class="p-4 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-xs space-y-1">
            <div class="font-bold text-white flex items-center gap-2">
              <i class="fa-solid fa-users text-amber-400"></i> Referral Tree Audit
            </div>
            <p class="text-natural-textMuted">Inspect multi-tier downlines, active partner volume, and prevent duplicate account abuse.</p>
          </div>
          <div class="p-4 rounded-xl bg-natural-darkPaper border border-natural-darkBorder text-xs space-y-1">
            <div class="font-bold text-white flex items-center gap-2">
              <i class="fa-solid fa-vault text-amber-400"></i> Ledger & Reconciliation
            </div>
            <p class="text-natural-textMuted">Daily financial balancing reports, bank wire batch exports, and real-time reserves tracking.</p>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- FAQ Section -->
  <section id="faq" class="py-20 bg-natural-darkBg border-t border-natural-darkBorder">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="text-center mb-14 space-y-3">
        <span class="text-xs uppercase font-bold text-natural-sage tracking-wider">Everything Explained</span>
        <h2 class="font-serif font-bold text-3xl sm:text-4xl text-white">Frequently Asked Questions</h2>
        <p class="text-natural-textMuted text-sm">Clear, straightforward answers about packages, referral bonuses, and withdrawals.</p>
      </div>

      <div class="space-y-3.5">
        
        <div class="natural-dark-card rounded-2xl border border-natural-darkBorder overflow-hidden">
          <button class="w-full p-5 text-left font-bold text-sm sm:text-base text-white flex justify-between items-center focus:outline-none" onclick="toggleFaq('faq1')">
            <span>How is the fixed daily profit calculated?</span>
            <i id="faq1-icon" class="fa-solid fa-chevron-down text-natural-sage transition-transform duration-200"></i>
          </button>
          <div id="faq1" class="hidden px-5 pb-5 text-xs sm:text-sm text-natural-textMuted leading-relaxed border-t border-natural-darkBorder pt-3">
            Your daily yield is fixed based on your chosen package (from 1.80% to 4.20% per day). Every 24 hours, our system calculates this percentage on your invested balance and credits it immediately into your withdrawable balance.
          </div>
        </div>

        <div class="natural-dark-card rounded-2xl border border-natural-darkBorder overflow-hidden">
          <button class="w-full p-5 text-left font-bold text-sm sm:text-base text-white flex justify-between items-center focus:outline-none" onclick="toggleFaq('faq2')">
            <span>What is the minimum withdrawal amount and how long does it take?</span>
            <i id="faq2-icon" class="fa-solid fa-chevron-down text-natural-sage transition-transform duration-200"></i>
          </button>
          <div id="faq2" class="hidden px-5 pb-5 text-xs sm:text-sm text-natural-textMuted leading-relaxed border-t border-natural-darkBorder pt-3">
            The minimum withdrawal limit is just <strong>$10.00</strong> across all accounts. Withdrawals are processed 24/7 automatically and generally clear to your bank account or crypto wallet within 5 to 15 minutes.
          </div>
        </div>

        <div class="natural-dark-card rounded-2xl border border-natural-darkBorder overflow-hidden">
          <button class="w-full p-5 text-left font-bold text-sm sm:text-base text-white flex justify-between items-center focus:outline-none" onclick="toggleFaq('faq3')">
            <span>How does the unique referral link and matching profit work?</span>
            <i id="faq3-icon" class="fa-solid fa-chevron-down text-natural-sage transition-transform duration-200"></i>
          </button>
          <div id="faq3" class="hidden px-5 pb-5 text-xs sm:text-sm text-natural-textMuted leading-relaxed border-t border-natural-darkBorder pt-3">
            Upon registration, you receive a unique personal invite link. When someone joins using your link, you receive an instant commission on their package (Level 1: 7%, Level 2: 3%, Level 3: 1%). In addition, you receive a daily matching bonus based on whatever profit they earn every day!
          </div>
        </div>

        <div class="natural-dark-card rounded-2xl border border-natural-darkBorder overflow-hidden">
          <button class="w-full p-5 text-left font-bold text-sm sm:text-base text-white flex justify-between items-center focus:outline-none" onclick="toggleFaq('faq4')">
            <span>Is my original capital returned when the plan finishes?</span>
            <i id="faq4-icon" class="fa-solid fa-chevron-down text-natural-sage transition-transform duration-200"></i>
          </button>
          <div id="faq4" class="hidden px-5 pb-5 text-xs sm:text-sm text-natural-textMuted leading-relaxed border-t border-natural-darkBorder pt-3">
            Yes, 100% of your initial capital is returned to your available balance at the conclusion of your contract period (30, 45, 60, or 90 days), or you can choose to auto-reinvest it to continue compounding.
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- Final Call to Action Section -->
  <section class="py-20 relative bg-[#0A110E]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="bg-gradient-to-r from-[#11241B] via-natural-darkCard to-[#152B20] rounded-3xl p-8 sm:p-14 text-center text-white space-y-6 shadow-xl border border-natural-moss/30 relative overflow-hidden">
        
        <div class="relative z-10 max-w-2xl mx-auto space-y-4">
          <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-natural-forest/40 border border-natural-moss/40 text-natural-mint text-xs font-bold">
            <i class="fa-solid fa-leaf"></i> Start Growing Today
          </div>

          <h2 class="font-serif font-bold text-3xl sm:text-5xl tracking-tight leading-tight text-white">
            Start earning daily returns on your capital in 60 seconds.
          </h2>

          <p class="text-natural-textMuted text-sm sm:text-base leading-relaxed">
            Join thousands of smart investors enjoying predictable daily cash flow and generous community referral rewards. Minimum investment starts at just $50.
          </p>

          <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
            <button onclick="openModal('registerModal')" class="w-full sm:w-auto px-9 py-4 rounded-xl font-bold text-sm text-slate-950 bg-natural-mint hover:bg-white transition transform active:scale-95 shadow-md">
              Create Free Investor Account
            </button>
            <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 rounded-xl font-bold text-sm text-white bg-natural-darkPaper hover:bg-natural-darkBorder border border-natural-darkBorder transition">
              Sign In to Portfolio
            </a>
          </div>

          <div class="flex items-center justify-center space-x-6 text-xs text-natural-textMuted pt-4">
            <span class="flex items-center gap-1.5"><i class="fa-solid fa-lock text-natural-sage"></i> 256-Bit SSL Secured</span>
            <span class="flex items-center gap-1.5"><i class="fa-solid fa-wallet text-natural-sage"></i> $10 Minimum Cashout</span>
            <span class="flex items-center gap-1.5"><i class="fa-solid fa-shield text-natural-sage"></i> Audited Reserves</span>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="border-t border-natural-darkBorder bg-[#080E0B] py-14 text-natural-textMuted text-xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      
      <div class="grid grid-cols-1 md:grid-cols-5 gap-10 pb-12 border-b border-natural-darkBorder">
        
        <div class="md:col-span-2 space-y-4">
          <div class="flex items-center space-x-3">
            <div class="w-8 h-8 rounded-lg bg-natural-forest flex items-center justify-center text-natural-mint font-bold">
              <i class="fa-solid fa-seedling text-sm"></i>
            </div>
            <span class="font-serif font-bold text-xl text-white">Verdant<span class="text-natural-sage">.</span></span>
          </div>
          <p class="text-xs leading-relaxed max-w-sm">
            {{ cms('home.footer.tagline', 'A natural, transparent wealth generation platform providing fixed daily percentage profits, automated multi-tier referral matching, and friction-free withdrawals.') }}
          </p>
          <div class="flex items-center space-x-3 text-natural-textMuted text-base">
            <a href="#" class="w-8 h-8 rounded-lg bg-natural-darkCard hover:bg-natural-forest hover:text-white flex items-center justify-center transition border border-natural-darkBorder"><i class="fa-brands fa-telegram"></i></a>
            <a href="#" class="w-8 h-8 rounded-lg bg-natural-darkCard hover:bg-natural-forest hover:text-white flex items-center justify-center transition border border-natural-darkBorder"><i class="fa-brands fa-x-twitter"></i></a>
            <a href="#" class="w-8 h-8 rounded-lg bg-natural-darkCard hover:bg-natural-forest hover:text-white flex items-center justify-center transition border border-natural-darkBorder"><i class="fa-brands fa-discord"></i></a>
          </div>
        </div>

        <div class="space-y-3">
          <h4 class="text-white font-bold text-xs uppercase tracking-wider">Growth Plans</h4>
          <ul class="space-y-2">
            @forelse ($packages->take(5) as $pkg)
              <li><a href="#packages" class="hover:text-natural-sage transition">{{ $pkg->name }} ({{ number_format($pkg->daily_commission_percent, 1) }}%/day)</a></li>
            @empty
              <li><a href="#packages" class="hover:text-natural-sage transition">Growth Plans Available</a></li>
            @endforelse
          </ul>
        </div>

        <div class="space-y-3">
          <h4 class="text-white font-bold text-xs uppercase tracking-wider">Platform & Access</h4>
          <ul class="space-y-2">
            <li><a href="{{ route('login') }}" class="hover:text-natural-sage transition">Investor Portal Login</a></li>
            <li><a href="{{ route('login') }}?role=admin" class="hover:text-amber-400 transition">Admin Console Login</a></li>
            <li><a href="{{ route('register') }}" class="hover:text-natural-sage transition">Register Account</a></li>
            <li><a href="#calculator" class="hover:text-natural-sage transition">Yield Calculator</a></li>
          </ul>
        </div>

        <div class="space-y-3">
          <h4 class="text-white font-bold text-xs uppercase tracking-wider">Trust & Security</h4>
          <div class="space-y-2 text-xs">
            <div class="flex items-center gap-2 text-natural-sage font-semibold">
              <span class="w-2 h-2 rounded-full bg-natural-sage animate-pulse"></span>
              <span>All Systems Operational</span>
            </div>
            <div>Minimum Withdrawal: <span class="font-bold text-white">$10.00</span></div>
            <div>Audited Cold Reserves: <span class="font-bold text-white">100% Verified</span></div>
            <div>Support: 24/7 Live Desk</div>
          </div>
        </div>

      </div>

      <div class="pt-8 flex flex-col md:flex-row items-center justify-between text-natural-textMuted text-[11px] gap-4">
        <div>
          © 2026 Verdant Wealth Partners. All rights reserved.
        </div>
        <div class="flex space-x-6">
          <a href="#" class="hover:text-white">Terms of Service</a>
          <a href="#" class="hover:text-white">Privacy Policy</a>
          <a href="#" class="hover:text-white">Risk Disclosure</a>
        </div>
      </div>

    </div>
  </footer>

  <!-- ================= MODALS & POPUPS ================= -->

  <!-- Sign In Modal -->
  <div id="loginModal" class="fixed inset-0 z-50 hidden bg-[#050907]/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-natural-darkCard max-w-md w-full rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-2xl relative">
      <button onclick="closeModal('loginModal')" class="absolute top-5 right-5 text-natural-textMuted hover:text-white text-lg">
        <i class="fa-solid fa-xmark"></i>
      </button>

      <!-- Portal Switcher -->
      <div class="flex bg-natural-darkPaper p-1 rounded-xl mb-6 border border-natural-darkBorder">
        <button id="modalUserTab" onclick="setLoginType('user')" class="flex-1 py-2 rounded-lg text-xs font-bold bg-natural-forest text-white shadow-sm transition">
          <i class="fa-solid fa-user mr-1"></i> Investor Portal
        </button>
        <button id="modalAdminTab" onclick="setLoginType('admin')" class="flex-1 py-2 rounded-lg text-xs font-bold text-natural-textMuted hover:text-white transition">
          <i class="fa-solid fa-shield-halved mr-1 text-amber-400"></i> Admin Console
        </button>
      </div>

      <div class="text-center mb-6">
        <h3 id="loginModalTitle" class="font-serif font-bold text-2xl text-white">Investor Sign In</h3>
        <p id="loginModalSubtitle" class="text-xs text-natural-textMuted mt-1">Access your portfolio, daily yields & referral earnings</p>
      </div>

      <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf
        <div>
          <label class="block text-xs font-bold text-natural-textPrimary mb-1">Email Address</label>
          <input type="email" name="email" id="modalLoginEmail" required placeholder="name@example.com" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs text-white placeholder-natural-textMuted/60 focus:border-natural-sage focus:outline-none">
        </div>

        <div>
          <div class="flex justify-between items-center mb-1">
            <label class="text-xs font-bold text-natural-textPrimary">Password</label>
            <a href="{{ route('password.request') }}" class="text-[11px] text-natural-sage font-semibold hover:underline">Forgot?</a>
          </div>
          <input type="password" name="password" id="modalLoginPassword" required placeholder="••••••••••••" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs text-white placeholder-natural-textMuted/60 focus:border-natural-sage focus:outline-none">
        </div>

        <button type="submit" id="loginSubmitBtn" class="w-full py-3 rounded-xl font-bold text-xs uppercase tracking-wider text-white bg-natural-forest hover:bg-natural-moss transition shadow-natural-btn">
          Sign In to Portal
        </button>
      </form>

      <div class="mt-4 flex items-center justify-between text-xs text-natural-textMuted">
        <a href="{{ route('login') }}" class="text-natural-sage font-semibold hover:underline">Dedicated Login Page →</a>
        <div>
          New here? 
          <a href="{{ route('register') }}" class="text-white font-bold hover:underline">Register</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Registration Modal -->
  <div id="registerModal" class="fixed inset-0 z-50 hidden bg-[#050907]/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-natural-darkCard max-w-md w-full rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-2xl relative">
      <button onclick="closeModal('registerModal')" class="absolute top-5 right-5 text-natural-textMuted hover:text-white text-lg">
        <i class="fa-solid fa-xmark"></i>
      </button>

      <div class="text-center mb-6">
        <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-natural-forest/40 border border-natural-moss/40 text-natural-mint text-[10px] font-bold mb-2">
          <i class="fa-solid fa-seedling"></i> Join Verdant Wealth
        </span>
        <h3 class="font-serif font-bold text-2xl text-white">Create Investor Account</h3>
        <p class="text-xs text-natural-textMuted mt-1">Start collecting daily fixed returns & referral bonuses</p>
      </div>

      <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
        @csrf
        <div>
          <label class="block text-xs font-bold text-natural-textPrimary mb-1">Full Name</label>
          <input type="text" name="name" required placeholder="Elena Morales" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs text-white placeholder-natural-textMuted/60 focus:border-natural-sage focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-bold text-natural-textPrimary mb-1">Email Address</label>
          <input type="email" name="email" required placeholder="elena@example.com" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs text-white placeholder-natural-textMuted/60 focus:border-natural-sage focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-bold text-natural-textPrimary mb-1">Phone Number</label>
          <input type="tel" name="phone" placeholder="+1 201 555 0123" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs text-white placeholder-natural-textMuted/60 focus:border-natural-sage focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-bold text-natural-textPrimary mb-1">Password</label>
          <input type="password" name="password" required placeholder="At least 8 characters" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs text-white placeholder-natural-textMuted/60 focus:border-natural-sage focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-bold text-natural-textPrimary mb-1">Confirm Password</label>
          <input type="password" name="password_confirmation" required placeholder="Repeat password" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs text-white placeholder-natural-textMuted/60 focus:border-natural-sage focus:outline-none">
        </div>

        <input type="hidden" name="referral_code" value="{{ request('ref') }}">

        <button type="submit" class="w-full py-3 rounded-xl font-bold text-xs uppercase tracking-wider text-white bg-natural-forest hover:bg-natural-moss transition shadow-natural-btn">
          Complete Registration
        </button>
      </form>

      <div class="mt-4 flex items-center justify-between text-xs text-natural-textMuted">
        <a href="{{ route('register') }}" class="text-natural-sage font-semibold hover:underline">Full Registration Page →</a>
        <div>
          Have an account? 
          <a href="{{ route('login') }}" class="text-white font-bold hover:underline">Sign In</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Notification Alert -->
  <div id="toastNotification" class="fixed bottom-6 right-6 z-50 hidden transform transition-all duration-200">
    <div class="bg-natural-darkCard text-white px-5 py-3.5 rounded-2xl shadow-2xl flex items-center space-x-3 border border-natural-darkBorder">
      <div class="w-7 h-7 rounded-full bg-natural-forest text-natural-mint flex items-center justify-center font-bold text-sm" id="toastIcon">
        <i class="fa-solid fa-check"></i>
      </div>
      <div>
        <div class="text-xs font-bold" id="toastTitle">Success</div>
        <div class="text-[11px] text-natural-textMuted" id="toastMessage">Action completed successfully</div>
      </div>
    </div>
  </div>

  <!-- ================= JAVASCRIPT ================= -->
  <script>
    let currentCalcPlan = {
      name: "{{ $packages->first() ? addslashes($packages->first()->name) : 'Standard' }}",
      dailyPercent: {{ $packages->first() ? (float)$packages->first()->daily_commission_percent : 2.0 }},
      durationDays: 30,
      min: {{ $packages->first() ? (float)$packages->first()->investment_amount : 100 }},
      max: {{ $packages->first() ? (float)($packages->first()->investment_amount * 5) : 5000 }}
    };
    const referralRatePercent = {{ (float) $referralRate }};

    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });

    mobileMenu.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
      });
    });

    function openModal(modalId, portalType = 'user') {
      const modal = document.getElementById(modalId);
      if (modal) {
        modal.classList.remove('hidden');
        if (modalId === 'loginModal') {
          setLoginType(portalType);
        }
      }
    }

    function closeModal(modalId) {
      const modal = document.getElementById(modalId);
      if (modal) {
        modal.classList.add('hidden');
      }
    }

    window.addEventListener('click', (e) => {
      if (e.target.id === 'loginModal') closeModal('loginModal');
      if (e.target.id === 'registerModal') closeModal('registerModal');
    });

    function setLoginType(type) {
      const userTab = document.getElementById('modalUserTab');
      const adminTab = document.getElementById('modalAdminTab');
      const title = document.getElementById('loginModalTitle');
      const subtitle = document.getElementById('loginModalSubtitle');
      const submitBtn = document.getElementById('loginSubmitBtn');

      if (type === 'admin') {
        adminTab.className = 'flex-1 py-2 rounded-lg text-xs font-bold bg-amber-600 text-white shadow-sm transition';
        userTab.className = 'flex-1 py-2 rounded-lg text-xs font-bold text-natural-textMuted hover:text-white transition';
        title.innerHTML = 'Admin Management Console';
        subtitle.innerText = 'Platform administrators and operations sign in';
        submitBtn.className = 'w-full py-3 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 bg-amber-400 hover:bg-amber-300 transition shadow-md';
        submitBtn.innerText = 'Enter Admin Console';
      } else {
        userTab.className = 'flex-1 py-2 rounded-lg text-xs font-bold bg-natural-forest text-white shadow-sm transition';
        adminTab.className = 'flex-1 py-2 rounded-lg text-xs font-bold text-natural-textMuted hover:text-white transition';
        title.innerHTML = 'Investor Sign In';
        subtitle.innerText = 'Access your portfolio, daily yields & referral earnings';
        submitBtn.className = 'w-full py-3 rounded-xl font-bold text-xs uppercase tracking-wider text-white bg-natural-forest hover:bg-natural-moss transition shadow-natural-btn';
        submitBtn.innerText = 'Sign In to Investor Portal';
      }
    }

    function showToast(title, message) {
      const toast = document.getElementById('toastNotification');
      const tTitle = document.getElementById('toastTitle');
      const tMessage = document.getElementById('toastMessage');

      tTitle.innerText = title;
      tMessage.innerText = message;
      toast.classList.remove('hidden');

      setTimeout(() => {
        toast.classList.add('hidden');
      }, 3500);
    }

    function switchDashboardTab(tab) {
      const userBtn = document.getElementById('tabUserDashBtn');
      const adminBtn = document.getElementById('tabAdminDashBtn');
      const userView = document.getElementById('viewUserDash');
      const adminView = document.getElementById('viewAdminDash');

      if (tab === 'admin') {
        adminBtn.className = 'px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-amber-500 text-slate-950 transition flex items-center gap-2 shadow-sm';
        userBtn.className = 'px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-natural-textMuted hover:text-white transition flex items-center gap-2';
        userView.classList.add('hidden');
        adminView.classList.remove('hidden');
      } else {
        userBtn.className = 'px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold bg-natural-forest text-white transition flex items-center gap-2 shadow-sm';
        adminBtn.className = 'px-6 py-2.5 rounded-xl text-xs sm:text-sm font-bold text-natural-textMuted hover:text-white transition flex items-center gap-2';
        adminView.classList.add('hidden');
        userView.classList.remove('hidden');
      }
    }

    function toggleFaq(id) {
      const content = document.getElementById(id);
      const icon = document.getElementById(id + '-icon');
      if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.classList.add('rotate-180');
      } else {
        content.classList.add('hidden');
        icon.classList.remove('rotate-180');
      }
    }

    function copyMockRef() {
      navigator.clipboard.writeText("https://verdant.co/invite/elena92");
      const btnText = document.getElementById('heroCopyBtnText');
      btnText.innerText = "Copied!";
      showToast("Link Copied!", "Your unique invite link was copied to clipboard.");
      setTimeout(() => {
        btnText.innerText = "Copy";
      }, 2000);
    }

    function updateDemoRefLink() {
      const username = document.getElementById('demoRefUsername').value.trim() || 'investor';
      const cleanUser = username.replace(/[^a-zA-Z0-9_-]/g, '');
      const fullUrl = `https://verdant.co/invite/${cleanUser}`;
      document.getElementById('generatedLinkPreview').innerText = fullUrl;
    }

    function copyGeneratedLink() {
      const url = document.getElementById('generatedLinkPreview').innerText;
      navigator.clipboard.writeText(url);
      const btnText = document.getElementById('genLinkBtnText');
      btnText.innerText = "Copied!";
      showToast("Referral Link Copied!", "Share this link with your friends to earn 7% + daily profit matching.");
      setTimeout(() => {
        btnText.innerText = "Copy";
      }, 2000);
    }

    const calcSlider = document.getElementById('calcRangeSlider');
    const calcInput = document.getElementById('calcInputAmount');

    function setCalcPlan(name, rate, duration, min, max, slug) {
      currentCalcPlan = { name, dailyPercent: rate, durationDays: duration, min, max };
      
      document.querySelectorAll('.calc-plan-btn').forEach(btn => {
        btn.className = 'calc-plan-btn py-2.5 px-3 rounded-xl text-xs font-bold border border-natural-darkBorder bg-natural-darkPaper text-natural-textPrimary hover:border-natural-sage transition';
      });
      const targetSlug = slug || name.toLowerCase().replace(/[^a-z0-9]/g, '-');
      const activeBtn = document.getElementById(`btn-calc-${targetSlug}`);
      if (activeBtn) {
        activeBtn.className = 'calc-plan-btn py-2.5 px-3 rounded-xl text-xs font-bold border-2 border-natural-forest bg-natural-forest/40 text-natural-mint transition';
      }

      document.getElementById('calcActivePlanBadge').innerText = `${name} (${rate}%)`;
      document.getElementById('calcDurationDisplay').innerText = `${duration} Days`;

      calcSlider.min = min;
      calcSlider.max = Math.max(max === 50000 ? 50000 : max, min * 5);
      
      if (parseFloat(calcInput.value) < min) {
        calcInput.value = min;
        calcSlider.value = min;
      }

      runCalculation();
    }

    function selectPackageForCalc(name, rate, min, max, duration) {
      setCalcPlan(name, rate, duration, min, max);
      calcInput.value = min;
      calcSlider.value = min;
      runCalculation();
      
      const calcElem = document.getElementById('calculator');
      if (calcElem) {
        calcElem.scrollIntoView({ behavior: 'smooth' });
      }
    }

    calcSlider.addEventListener('input', (e) => {
      calcInput.value = e.target.value;
      runCalculation();
    });

    calcInput.addEventListener('input', (e) => {
      let val = parseFloat(e.target.value) || 0;
      calcSlider.value = val;
      runCalculation();
    });

    function runCalculation() {
      const amount = parseFloat(calcInput.value) || 0;
      const dailyPercent = currentCalcPlan.dailyPercent;
      const duration = currentCalcPlan.durationDays;

      const dailyProfit = amount * (dailyPercent / 100);
      const weeklyProfit = dailyProfit * 7;
      const totalNetProfit = dailyProfit * duration;
      const totalReturn = amount + totalNetProfit;
      const refBonusLevel1 = amount * (referralRatePercent / 100);

      document.getElementById('calcDailyProfit').innerText = `$${dailyProfit.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
      document.getElementById('calcWeeklyProfit').innerText = `$${weeklyProfit.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
      document.getElementById('calcTotalNetProfit').innerText = `$${totalNetProfit.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
      document.getElementById('calcTotalReturn').innerText = `$${totalReturn.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
      document.getElementById('calcRefBonusPreview').innerText = `$${refBonusLevel1.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

    runCalculation();

    setInterval(() => {
      const balanceEl = document.getElementById('heroLiveBalance');
      if (balanceEl) {
        let current = parseFloat(balanceEl.innerText.replace(/[^0-9.]/g, ''));
        current += 0.03;
        balanceEl.innerText = `$${current.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
      }
    }, 3500);
  </script>

</body>
</html>