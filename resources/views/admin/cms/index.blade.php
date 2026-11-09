<x-app-layout>
    <div class="space-y-6 max-w-6xl mx-auto pb-12" x-data="{ activeTab: 'home' }">

        <!-- Top Header & Status Alert -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-natural-darkBorder pb-5">
            <div>
                <div class="flex items-center gap-2 text-xs font-mono text-amber-400 uppercase tracking-widest">
                    <i class="fa-solid fa-pen-to-square"></i> Content Management System
                </div>
                <h1 class="font-serif font-bold text-2xl sm:text-3xl text-white mt-1">Platform Copy & Content CMS</h1>
                <p class="text-xs sm:text-sm text-natural-textMuted mt-1 max-w-2xl">
                    Customize titles, descriptions, and labels across all user and public pages. Every field includes zero-downtime fallback protection: if left blank, the system automatically uses platform defaults.
                </p>
            </div>

            <!-- Global Action Controls -->
            <div class="flex items-center gap-3">
                <form method="POST" action="{{ route('admin.cms.reset') }}" onsubmit="return confirm('Are you sure you want to restore all platform copy to original defaults?');">
                    @csrf
                    <button type="submit" class="px-4 py-2.5 rounded-xl border border-natural-darkBorder bg-natural-darkPaper hover:bg-rose-950/40 hover:border-rose-700/50 text-natural-textMuted hover:text-rose-300 text-xs font-bold transition flex items-center gap-2">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span>Reset Defaults</span>
                    </button>
                </form>
            </div>
        </div>

        @if (session('status'))
            <div class="p-4 rounded-2xl bg-emerald-950/50 border border-emerald-500/40 text-emerald-300 text-xs font-semibold flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-base text-emerald-400"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <!-- CMS Navigation Tabs -->
        <div class="flex items-center gap-2 p-1.5 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder">
            <button type="button" 
                    @click="activeTab = 'home'" 
                    :class="activeTab === 'home' ? 'bg-amber-400 text-slate-950 shadow-sm font-extrabold' : 'text-natural-textMuted hover:text-white font-bold'"
                    class="flex-1 py-3 rounded-xl text-xs sm:text-sm transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-house"></i>
                <span>Home Page</span>
            </button>

            <button type="button" 
                    @click="activeTab = 'auth'" 
                    :class="activeTab === 'auth' ? 'bg-amber-400 text-slate-950 shadow-sm font-extrabold' : 'text-natural-textMuted hover:text-white font-bold'"
                    class="flex-1 py-3 rounded-xl text-xs sm:text-sm transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-user-lock"></i>
                <span>Login & Register</span>
            </button>

            <button type="button" 
                    @click="activeTab = 'dashboard'" 
                    :class="activeTab === 'dashboard' ? 'bg-amber-400 text-slate-950 shadow-sm font-extrabold' : 'text-natural-textMuted hover:text-white font-bold'"
                    class="flex-1 py-3 rounded-xl text-xs sm:text-sm transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-gauge-high"></i>
                <span>Investor Dashboard</span>
            </button>
        </div>

        <!-- Main Form -->
        <form method="POST" action="{{ route('admin.cms.update') }}" class="space-y-8">
            @csrf

            <!-- ================= TAB 1: HOME PAGE ================= -->
            <div x-show="activeTab === 'home'" class="space-y-8">
                
                @foreach ($homeContents as $sectionName => $items)
                    <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder p-6 sm:p-8 space-y-6 shadow-dark-card">
                        <div class="border-b border-natural-darkBorder pb-4 flex items-center justify-between">
                            <div>
                                <h3 class="font-serif font-bold text-lg sm:text-xl text-white">{{ $sectionName }}</h3>
                                <p class="text-xs text-natural-textMuted">Live landing page section copy</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-natural-darkPaper border border-natural-darkBorder text-[10px] font-mono text-natural-sage font-bold">
                                {{ $items->count() }} field(s)
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($items as $item)
                                <div class="{{ $item->type === 'textarea' ? 'md:col-span-2' : '' }} space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-bold text-natural-textPrimary">
                                            {{ $item->label }}
                                        </label>
                                        <span class="text-[10px] font-mono text-natural-textMuted/70 bg-black/20 px-2 py-0.5 rounded">
                                            {{ $item->key }}
                                        </span>
                                    </div>

                                    @if ($item->type === 'textarea')
                                        <textarea name="contents[{{ $item->key }}]" 
                                                  rows="3" 
                                                  placeholder="{{ $item->default_value }}"
                                                  class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs sm:text-sm text-white placeholder-natural-textMuted/40 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 focus:outline-none transition">{{ $item->value }}</textarea>
                                    @else
                                        <input type="text" 
                                               name="contents[{{ $item->key }}]" 
                                               value="{{ $item->value }}" 
                                               placeholder="{{ $item->default_value }}"
                                               class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs sm:text-sm text-white placeholder-natural-textMuted/40 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 focus:outline-none transition">
                                    @endif

                                    <div class="text-[11px] text-natural-textMuted flex items-baseline gap-1.5 font-mono">
                                        <span class="text-natural-sage/70 shrink-0">Default:</span>
                                        <span class="truncate">{{ $item->default_value }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- ================= TAB 2: AUTH PAGES ================= -->
            <div x-show="activeTab === 'auth'" class="space-y-8" style="display: none;">
                
                @foreach ($authContents as $sectionName => $items)
                    <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder p-6 sm:p-8 space-y-6 shadow-dark-card">
                        <div class="border-b border-natural-darkBorder pb-4 flex items-center justify-between">
                            <div>
                                <h3 class="font-serif font-bold text-lg sm:text-xl text-white">{{ $sectionName }}</h3>
                                <p class="text-xs text-natural-textMuted">Authentication and onboarding screens</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-natural-darkPaper border border-natural-darkBorder text-[10px] font-mono text-natural-sage font-bold">
                                {{ $items->count() }} field(s)
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($items as $item)
                                <div class="{{ $item->type === 'textarea' ? 'md:col-span-2' : '' }} space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-bold text-natural-textPrimary">
                                            {{ $item->label }}
                                        </label>
                                        <span class="text-[10px] font-mono text-natural-textMuted/70 bg-black/20 px-2 py-0.5 rounded">
                                            {{ $item->key }}
                                        </span>
                                    </div>

                                    @if ($item->type === 'textarea')
                                        <textarea name="contents[{{ $item->key }}]" 
                                                  rows="3" 
                                                  placeholder="{{ $item->default_value }}"
                                                  class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs sm:text-sm text-white placeholder-natural-textMuted/40 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 focus:outline-none transition">{{ $item->value }}</textarea>
                                    @else
                                        <input type="text" 
                                               name="contents[{{ $item->key }}]" 
                                               value="{{ $item->value }}" 
                                               placeholder="{{ $item->default_value }}"
                                               class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs sm:text-sm text-white placeholder-natural-textMuted/40 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 focus:outline-none transition">
                                    @endif

                                    <div class="text-[11px] text-natural-textMuted flex items-baseline gap-1.5 font-mono">
                                        <span class="text-natural-sage/70 shrink-0">Default:</span>
                                        <span class="truncate">{{ $item->default_value }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- ================= TAB 3: INVESTOR DASHBOARD ================= -->
            <div x-show="activeTab === 'dashboard'" class="space-y-8" style="display: none;">
                
                @foreach ($dashboardContents as $sectionName => $items)
                    <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder p-6 sm:p-8 space-y-6 shadow-dark-card">
                        <div class="border-b border-natural-darkBorder pb-4 flex items-center justify-between">
                            <div>
                                <h3 class="font-serif font-bold text-lg sm:text-xl text-white">{{ $sectionName }}</h3>
                                <p class="text-xs text-natural-textMuted">Logged-in investor operational console copy</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-natural-darkPaper border border-natural-darkBorder text-[10px] font-mono text-natural-sage font-bold">
                                {{ $items->count() }} field(s)
                            </span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach ($items as $item)
                                <div class="{{ $item->type === 'textarea' ? 'md:col-span-2' : '' }} space-y-2">
                                    <div class="flex items-center justify-between">
                                        <label class="text-xs font-bold text-natural-textPrimary">
                                            {{ $item->label }}
                                        </label>
                                        <span class="text-[10px] font-mono text-natural-textMuted/70 bg-black/20 px-2 py-0.5 rounded">
                                            {{ $item->key }}
                                        </span>
                                    </div>

                                    @if ($item->type === 'textarea')
                                        <textarea name="contents[{{ $item->key }}]" 
                                                  rows="3" 
                                                  placeholder="{{ $item->default_value }}"
                                                  class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs sm:text-sm text-white placeholder-natural-textMuted/40 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 focus:outline-none transition">{{ $item->value }}</textarea>
                                    @else
                                        <input type="text" 
                                               name="contents[{{ $item->key }}]" 
                                               value="{{ $item->value }}" 
                                               placeholder="{{ $item->default_value }}"
                                               class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-xs sm:text-sm text-white placeholder-natural-textMuted/40 focus:border-amber-400 focus:ring-1 focus:ring-amber-400 focus:outline-none transition">
                                    @endif

                                    <div class="text-[11px] text-natural-textMuted flex items-baseline gap-1.5 font-mono">
                                        <span class="text-natural-sage/70 shrink-0">Default:</span>
                                        <span class="truncate">{{ $item->default_value }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- Sticky Save Bar -->
            <div class="sticky bottom-6 z-20 bg-natural-darkCard/95 backdrop-blur-md p-4 sm:p-5 rounded-2xl border border-natural-moss/50 shadow-2xl flex items-center justify-between gap-4">
                <div class="flex items-center gap-2.5 text-xs text-natural-textMuted">
                    <i class="fa-solid fa-shield-halved text-emerald-400"></i>
                    <span>Changes take effect immediately across all live views.</span>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit" class="px-8 py-3 rounded-xl font-bold text-xs uppercase tracking-wider text-slate-950 bg-amber-400 hover:bg-amber-300 transition shadow-md flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Save All Changes</span>
                    </button>
                </div>
            </div>

        </form>

    </div>
</x-app-layout>
