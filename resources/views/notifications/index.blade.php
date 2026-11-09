<x-app-layout>
    <div class="space-y-6">

        <!-- Header Card -->
        <div class="bg-natural-darkCard p-6 sm:p-8 rounded-3xl border border-natural-darkBorder shadow-dark-card flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="px-3 py-1 rounded-full bg-natural-forest/30 border border-natural-moss/40 text-natural-mint text-xs font-bold flex items-center gap-2 w-fit mb-2">
                    <span class="w-2 h-2 rounded-full bg-natural-sage animate-pulse"></span>
                    <span>Official Investor Inbox</span>
                </span>
                <h2 class="font-serif font-bold text-2xl sm:text-3xl text-white">Notifications & Announcements</h2>
                <p class="text-xs text-natural-textMuted mt-1">Stay updated with 24h yield distributions, special compounding dividends, and platform news.</p>
            </div>

            @if ($notifications->where('is_read', false)->count() > 0)
                <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-natural-darkPaper hover:bg-natural-darkCard border border-natural-darkBorder hover:border-natural-sage text-natural-mint text-xs font-bold transition flex items-center gap-2 shadow-xs">
                        <i class="fa-solid fa-check-double text-natural-sage"></i>
                        <span>Mark All as Read ({{ $notifications->where('is_read', false)->count() }})</span>
                    </button>
                </form>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="space-y-4">
            @forelse ($notifications as $item)
                @php
                    $typeConfig = [
                        'announcement' => [
                            'icon' => 'fa-bullhorn',
                            'badge' => 'Announcement',
                            'border' => 'border-emerald-500/40',
                            'badge_style' => 'bg-emerald-950/60 text-emerald-300 border-emerald-500/40',
                            'icon_bg' => 'bg-emerald-950/80 text-emerald-400 border border-emerald-500/30'
                        ],
                        'bonus' => [
                            'icon' => 'fa-gift',
                            'badge' => 'Yield Bonus',
                            'border' => 'border-amber-500/40',
                            'badge_style' => 'bg-amber-950/60 text-amber-300 border-amber-600/40',
                            'icon_bg' => 'bg-amber-950/80 text-amber-400 border border-amber-500/30'
                        ],
                        'alert' => [
                            'icon' => 'fa-shield-halved',
                            'badge' => 'Security Alert',
                            'border' => 'border-rose-500/40',
                            'badge_style' => 'bg-rose-950/60 text-rose-300 border-rose-600/40',
                            'icon_bg' => 'bg-rose-950/80 text-rose-400 border border-rose-500/30'
                        ],
                        'system' => [
                            'icon' => 'fa-server',
                            'badge' => 'System Update',
                            'border' => 'border-sky-500/40',
                            'badge_style' => 'bg-sky-950/60 text-sky-300 border-sky-600/40',
                            'icon_bg' => 'bg-sky-950/80 text-sky-400 border border-sky-500/30'
                        ],
                    ];
                    $cfg = $typeConfig[$item->type] ?? $typeConfig['announcement'];
                @endphp

                <div class="bg-natural-darkCard rounded-3xl p-6 border {{ $item->is_read ? 'border-natural-darkBorder' : $cfg['border'] . ' shadow-dark-card' }} transition space-y-4 relative overflow-hidden">
                    
                    @if (! $item->is_read)
                        <div class="absolute top-0 right-0 w-16 h-16 overflow-hidden">
                            <div class="bg-natural-forest text-natural-mint text-[9px] font-bold font-mono py-1 px-4 text-center transform rotate-45 translate-x-3 -translate-y-1 shadow-xs">
                                NEW
                            </div>
                        </div>
                    @endif

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl {{ $cfg['icon_bg'] }} flex items-center justify-center font-bold text-sm shrink-0">
                                <i class="fa-solid {{ $cfg['icon'] }}"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <h3 class="font-serif font-bold text-base sm:text-lg text-white">{{ $item->title }}</h3>
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono uppercase font-bold border {{ $cfg['badge_style'] }}">
                                        {{ $cfg['badge'] }}
                                    </span>
                                </div>
                                <span class="text-[11px] text-natural-textMuted font-mono">
                                    {{ $item->created_at->diffForHumans() }} • {{ $item->created_at->format('M d, Y • h:i A') }}
                                </span>
                            </div>
                        </div>

                        @if (! $item->is_read)
                            <form method="POST" action="{{ route('notifications.mark-read', $item) }}">
                                @csrf
                                <button type="submit" class="text-xs font-semibold text-natural-sage hover:text-white transition flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-natural-darkPaper border border-natural-darkBorder hover:border-natural-sage">
                                    <i class="fa-solid fa-check text-[10px]"></i>
                                    <span>Mark as read</span>
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Rendered Rich Text Body -->
                    <div class="text-xs sm:text-sm text-stone-200 leading-relaxed pt-2 border-t border-white/[0.06] prose prose-invert max-w-none prose-p:my-2 prose-ul:my-2 prose-li:my-0.5 prose-a:text-natural-mint">
                        {!! $item->body !!}
                    </div>

                </div>
            @empty
                <div class="bg-natural-darkCard rounded-3xl p-12 border border-natural-darkBorder text-center space-y-3">
                    <div class="w-14 h-14 rounded-2xl bg-natural-darkPaper border border-natural-darkBorder text-natural-textMuted mx-auto flex items-center justify-center text-xl">
                        <i class="fa-solid fa-bell-slash"></i>
                    </div>
                    <h3 class="font-serif font-bold text-lg text-white">No Notifications Right Now</h3>
                    <p class="text-xs text-natural-textMuted max-w-md mx-auto">
                        Your inbox is up to date! As soon as the platform administrators broadcast new yield dividends, bonuses, or security notices, they will appear right here.
                    </p>
                </div>
            @endforelse

            <div class="pt-2">
                {{ $notifications->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
