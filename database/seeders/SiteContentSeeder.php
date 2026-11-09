<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    /**
     * Seed default CMS content items.
     */
    public function run(): void
    {
        $items = [
            // ================= HOME PAGE =================
            [
                'key' => 'home.hero.badge',
                'group' => 'home',
                'section' => 'Hero Banner',
                'label' => 'Top Badge Text',
                'type' => 'text',
                'default_value' => 'Institutional Yield Terminal • Binance Pay & TxID Automated',
            ],
            [
                'key' => 'home.hero.title',
                'group' => 'home',
                'section' => 'Hero Banner',
                'label' => 'Main Heading',
                'type' => 'text',
                'default_value' => 'Sustainable Wealth Generation through Automated',
            ],
            [
                'key' => 'home.hero.title_highlight',
                'group' => 'home',
                'section' => 'Hero Banner',
                'label' => 'Heading Highlight (Italic / Colored)',
                'type' => 'text',
                'default_value' => 'Daily Returns',
            ],
            [
                'key' => 'home.hero.description',
                'group' => 'home',
                'section' => 'Hero Banner',
                'label' => 'Hero Description',
                'type' => 'textarea',
                'default_value' => 'Join thousands of investors generating 1.8% to 4.2% fixed daily profits. Backed by audited 1:1 cold reserves, automated multi-level referral matching, and zero friction instant cashouts.',
            ],
            [
                'key' => 'home.hero.cta_primary',
                'group' => 'home',
                'section' => 'Hero Banner',
                'label' => 'Primary CTA Button Text',
                'type' => 'text',
                'default_value' => 'Start Earning Today',
            ],
            [
                'key' => 'home.hero.cta_secondary',
                'group' => 'home',
                'section' => 'Hero Banner',
                'label' => 'Secondary CTA Button Text',
                'type' => 'text',
                'default_value' => 'Calculate My Returns',
            ],

            // Stats Strip
            [
                'key' => 'home.stats.capital_label',
                'group' => 'home',
                'section' => 'Statistics Bar',
                'label' => 'Managed Capital Label',
                'type' => 'text',
                'default_value' => 'Total Capital Managed',
            ],
            [
                'key' => 'home.stats.yields_label',
                'group' => 'home',
                'section' => 'Statistics Bar',
                'label' => 'Yields Paid Label',
                'type' => 'text',
                'default_value' => 'Daily Yields Paid to Members',
            ],
            [
                'key' => 'home.stats.investors_label',
                'group' => 'home',
                'section' => 'Statistics Bar',
                'label' => 'Active Investors Label',
                'type' => 'text',
                'default_value' => 'Active Global Investors',
            ],
            [
                'key' => 'home.stats.commission_label',
                'group' => 'home',
                'section' => 'Statistics Bar',
                'label' => 'Referral Commission Label',
                'type' => 'text',
                'default_value' => 'Direct Referral Commission',
            ],

            // How It Works
            [
                'key' => 'home.how.badge',
                'group' => 'home',
                'section' => 'How It Works',
                'label' => 'Section Badge',
                'type' => 'text',
                'default_value' => 'Simple & Transparent Flow',
            ],
            [
                'key' => 'home.how.title',
                'group' => 'home',
                'section' => 'How It Works',
                'label' => 'Section Title',
                'type' => 'text',
                'default_value' => 'The Natural Path to Daily Returns',
            ],
            [
                'key' => 'home.how.description',
                'group' => 'home',
                'section' => 'How It Works',
                'label' => 'Section Description',
                'type' => 'textarea',
                'default_value' => 'No complex formulas or confusing barriers. Follow four simple steps to begin generating predictable daily cash flow.',
            ],
            [
                'key' => 'home.how.step1_title',
                'group' => 'home',
                'section' => 'How It Works',
                'label' => 'Step 1 Title',
                'type' => 'text',
                'default_value' => 'Create Account',
            ],
            [
                'key' => 'home.how.step1_desc',
                'group' => 'home',
                'section' => 'How It Works',
                'label' => 'Step 1 Description',
                'type' => 'textarea',
                'default_value' => 'Register your secure investor portal in under 60 seconds with simple verification.',
            ],
            [
                'key' => 'home.how.step2_title',
                'group' => 'home',
                'section' => 'How It Works',
                'label' => 'Step 2 Title',
                'type' => 'text',
                'default_value' => 'Select Growth Tier',
            ],
            [
                'key' => 'home.how.step2_desc',
                'group' => 'home',
                'section' => 'How It Works',
                'label' => 'Step 2 Description',
                'type' => 'textarea',
                'default_value' => 'Choose from our sustainable packages starting from just $50 up to institutional tiers.',
            ],
            [
                'key' => 'home.how.step3_title',
                'group' => 'home',
                'section' => 'How It Works',
                'label' => 'Step 3 Title',
                'type' => 'text',
                'default_value' => 'Daily Compounding',
            ],
            [
                'key' => 'home.how.step3_desc',
                'group' => 'home',
                'section' => 'How It Works',
                'label' => 'Step 3 Description',
                'type' => 'textarea',
                'default_value' => 'Fixed profits credit directly to your available balance every 24 hours automatically.',
            ],
            [
                'key' => 'home.how.step4_title',
                'group' => 'home',
                'section' => 'How It Works',
                'label' => 'Step 4 Title',
                'type' => 'text',
                'default_value' => 'Withdraw or Share',
            ],
            [
                'key' => 'home.how.step4_desc',
                'group' => 'home',
                'section' => 'How It Works',
                'label' => 'Step 4 Description',
                'type' => 'textarea',
                'default_value' => 'Cash out anytime once your balance reaches $10, or share your link to earn daily referral rewards.',
            ],

            // Packages Header
            [
                'key' => 'home.packages.badge',
                'group' => 'home',
                'section' => 'Investment Packages Header',
                'label' => 'Section Badge',
                'type' => 'text',
                'default_value' => 'Curated Investment Tiers',
            ],
            [
                'key' => 'home.packages.title',
                'group' => 'home',
                'section' => 'Investment Packages Header',
                'label' => 'Section Title',
                'type' => 'text',
                'default_value' => 'Sustainable Growth Packages',
            ],
            [
                'key' => 'home.packages.description',
                'group' => 'home',
                'section' => 'Investment Packages Header',
                'label' => 'Section Description',
                'type' => 'textarea',
                'default_value' => 'Every package offers guaranteed daily fixed profit calculated on your available balance, with full capital return upon contract maturity.',
            ],

            // Calculator Header
            [
                'key' => 'home.calc.badge',
                'group' => 'home',
                'section' => 'Yield Calculator',
                'label' => 'Calculator Badge',
                'type' => 'text',
                'default_value' => 'Real-Time Yield Calculator',
            ],
            [
                'key' => 'home.calc.title',
                'group' => 'home',
                'section' => 'Yield Calculator',
                'label' => 'Calculator Title',
                'type' => 'text',
                'default_value' => 'Estimate Your Daily Returns',
            ],
            [
                'key' => 'home.calc.description',
                'group' => 'home',
                'section' => 'Yield Calculator',
                'label' => 'Calculator Description',
                'type' => 'textarea',
                'default_value' => 'Select your preferred growth plan and investment amount to simulate your daily cash flow and total maturity profit.',
            ],
            [
                'key' => 'home.calc.cta_button',
                'group' => 'home',
                'section' => 'Yield Calculator',
                'label' => 'Calculator Action Button',
                'type' => 'text',
                'default_value' => 'Lock In This Plan & Start Earning',
            ],

            // Referral Section
            [
                'key' => 'home.ref.badge',
                'group' => 'home',
                'section' => 'Referral Program',
                'label' => 'Referral Badge',
                'type' => 'text',
                'default_value' => 'Community Growth & Affiliates',
            ],
            [
                'key' => 'home.ref.title',
                'group' => 'home',
                'section' => 'Referral Program',
                'label' => 'Referral Title',
                'type' => 'text',
                'default_value' => 'Share your personal link. Grow together with',
            ],
            [
                'key' => 'home.ref.title_highlight',
                'group' => 'home',
                'section' => 'Referral Program',
                'label' => 'Referral Title Highlight',
                'type' => 'text',
                'default_value' => 'daily community rewards.',
            ],
            [
                'key' => 'home.ref.description',
                'group' => 'home',
                'section' => 'Referral Program',
                'label' => 'Referral Description',
                'type' => 'textarea',
                'default_value' => 'Every registered member gets their own dedicated invitation link. When friends or peers subscribe to any plan, you receive both an instant commission on their deposit plus a recurring percentage of their daily profit every single day!',
            ],

            // Footer
            [
                'key' => 'home.footer.tagline',
                'group' => 'home',
                'section' => 'Footer',
                'label' => 'Brand Tagline / Description',
                'type' => 'textarea',
                'default_value' => 'A natural, transparent wealth generation platform providing fixed daily percentage profits, automated multi-tier referral matching, and friction-free withdrawals.',
            ],
            [
                'key' => 'home.footer.copyright',
                'group' => 'home',
                'section' => 'Footer',
                'label' => 'Copyright Note',
                'type' => 'text',
                'default_value' => 'Verdant Institutional Operations. All rights reserved.',
            ],

            // ================= AUTH PAGES =================
            // Login
            [
                'key' => 'auth.login.title',
                'group' => 'auth',
                'section' => 'Login Page',
                'label' => 'Sign In Title',
                'type' => 'text',
                'default_value' => 'Investor Sign In',
            ],
            [
                'key' => 'auth.login.subtitle',
                'group' => 'auth',
                'section' => 'Login Page',
                'label' => 'Sign In Subtitle',
                'type' => 'textarea',
                'default_value' => 'Access your active investments, daily returns, and balance withdrawals.',
            ],
            [
                'key' => 'auth.login.button',
                'group' => 'auth',
                'section' => 'Login Page',
                'label' => 'Submit Button Label',
                'type' => 'text',
                'default_value' => 'Sign In to Account',
            ],
            [
                'key' => 'auth.login.no_account',
                'group' => 'auth',
                'section' => 'Login Page',
                'label' => 'No Account Prompt Text',
                'type' => 'text',
                'default_value' => "Don't have an investor account yet?",
            ],

            // Register
            [
                'key' => 'auth.register.title',
                'group' => 'auth',
                'section' => 'Registration Page',
                'label' => 'Registration Title',
                'type' => 'text',
                'default_value' => 'Create Investor Account',
            ],
            [
                'key' => 'auth.register.subtitle',
                'group' => 'auth',
                'section' => 'Registration Page',
                'label' => 'Registration Subtitle',
                'type' => 'textarea',
                'default_value' => 'Start earning fixed daily returns on your investments with automated profit distribution and instant withdrawals.',
            ],
            [
                'key' => 'auth.register.button',
                'group' => 'auth',
                'section' => 'Registration Page',
                'label' => 'Submit Button Label',
                'type' => 'text',
                'default_value' => 'Complete Account Registration',
            ],
            [
                'key' => 'auth.register.has_account',
                'group' => 'auth',
                'section' => 'Registration Page',
                'label' => 'Existing Account Prompt Text',
                'type' => 'text',
                'default_value' => 'Already have an active account?',
            ],

            // ================= INVESTOR DASHBOARD =================
            [
                'key' => 'dashboard.header.investor_badge',
                'group' => 'dashboard',
                'section' => 'Dashboard Header',
                'label' => 'Investor Badge Label',
                'type' => 'text',
                'default_value' => 'Verified Investor',
            ],
            [
                'key' => 'dashboard.header.welcome_text',
                'group' => 'dashboard',
                'section' => 'Dashboard Header',
                'label' => 'Greeting Prefix',
                'type' => 'text',
                'default_value' => 'Welcome back',
            ],
            [
                'key' => 'dashboard.balance.title',
                'group' => 'dashboard',
                'section' => 'Balance Card',
                'label' => 'Balance Card Title',
                'type' => 'text',
                'default_value' => 'Total Active Balance',
            ],
            [
                'key' => 'dashboard.balance.subtitle',
                'group' => 'dashboard',
                'section' => 'Balance Card',
                'label' => 'Compounding Note',
                'type' => 'text',
                'default_value' => 'Compounds automatically every 24 hours on your total balance',
            ],
            [
                'key' => 'dashboard.deposit.button',
                'group' => 'dashboard',
                'section' => 'Balance Card',
                'label' => 'Deposit Button Label',
                'type' => 'text',
                'default_value' => 'Deposit Capital',
            ],
            [
                'key' => 'dashboard.cashout.button',
                'group' => 'dashboard',
                'section' => 'Balance Card',
                'label' => 'Cashout Button Label',
                'type' => 'text',
                'default_value' => 'Cashout ($10 Min)',
            ],
            [
                'key' => 'dashboard.referral.title',
                'group' => 'dashboard',
                'section' => 'Affiliate Link Banner',
                'label' => 'Affiliate Banner Title',
                'type' => 'text',
                'default_value' => '3-Tier Referral Link',
            ],
            [
                'key' => 'dashboard.referral.subtitle',
                'group' => 'dashboard',
                'section' => 'Affiliate Link Banner',
                'label' => 'Affiliate Banner Subtitle',
                'type' => 'text',
                'default_value' => 'Earn instant referral bonus plus residual yield matching.',
            ],
            [
                'key' => 'dashboard.activity.title',
                'group' => 'dashboard',
                'section' => 'Activity Section',
                'label' => 'Activity Title',
                'type' => 'text',
                'default_value' => 'Recent Account Activity',
            ],
            [
                'key' => 'dashboard.activity.subtitle',
                'group' => 'dashboard',
                'section' => 'Activity Section',
                'label' => 'Activity Subtitle',
                'type' => 'text',
                'default_value' => 'Latest 24h profit distributions, deposits, and cashout transactions',
            ],
        ];

        foreach ($items as $item) {
            SiteContent::firstOrCreate(
                ['key' => $item['key']],
                $item
            );
        }
    }
}
