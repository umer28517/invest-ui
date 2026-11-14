<x-app-layout>
    <div class="space-y-6 max-w-6xl mx-auto">

        <!-- Compact Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-1">
            <div>
                <h2 class="font-serif font-bold text-xl sm:text-2xl text-white">Investment Packages & Daily Commission Rates</h2>
                <p class="text-xs text-natural-textMuted font-mono">Configure investment price ranges, randomized daily profit ranges, and cashout limits</p>
            </div>
            <button type="button" onclick="openCreatePackageModal()" class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 text-xs font-bold transition flex items-center gap-2 shadow-md cursor-pointer shrink-0">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Create New Package</span>
            </button>
        </div>

        <!-- Single Clean Packages Table -->
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder shadow-dark-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-natural-textPrimary font-sans">
                    <thead class="bg-[#0A100D] text-natural-textMuted uppercase font-mono tracking-wider border-b border-natural-darkBorder text-[11px]">
                        <tr>
                            <th class="p-4 sm:p-5">Package Name</th>
                            <th class="p-4 sm:p-5">Price Range ($)</th>
                            <th class="p-4 sm:p-5">Daily ROI Range (%)</th>
                            <th class="p-4 sm:p-5">30m Trade Range (%)</th>
                            <th class="p-4 sm:p-5">Referral Comm. (%)</th>
                            <th class="p-4 sm:p-5">Min. Withdrawal Limit</th>
                            <th class="p-4 sm:p-5">Status</th>
                            <th class="p-4 sm:p-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-darkBorder">
                        @forelse ($packages as $pkg)
                            <tr class="hover:bg-natural-darkPaper/60 transition">
                                
                                <!-- Name -->
                                <td class="p-4 sm:p-5">
                                    <div class="font-bold text-white text-sm">
                                        {{ $pkg->name }}
                                    </div>
                                    <div class="text-[11px] text-natural-textMuted max-w-xs truncate">{{ $pkg->description ?? 'No description provided' }}</div>
                                </td>

                                <!-- Price Range -->
                                <td class="p-4 sm:p-5 font-mono text-white font-bold text-sm">
                                    {{ $pkg->price_range_text }}
                                </td>

                                <!-- Daily Profit Range -->
                                <td class="p-4 sm:p-5 font-serif font-bold text-natural-mint text-sm">
                                    {{ $pkg->daily_profit_range_text }} <span class="text-[10px] font-sans text-natural-textMuted font-normal">/ day</span>
                                </td>

                                <!-- 30m Trade Profit Range -->
                                <td class="p-4 sm:p-5 font-serif font-bold text-amber-300 text-sm">
                                    {{ $pkg->trade_profit_range_text }} <span class="text-[10px] font-sans text-natural-textMuted font-normal">/ 30m</span>
                                </td>

                                <!-- Referral Commission -->
                                <td class="p-4 sm:p-5 font-mono text-amber-400 font-bold text-sm">
                                    {{ number_format($pkg->referral_commission_percent ?? 5.00, 2) }}%
                                </td>

                                <!-- Min Withdrawal Limit -->
                                <td class="p-4 sm:p-5 font-mono text-amber-300 font-bold">
                                    ${{ number_format($pkg->min_withdrawal_limit, 2) }}
                                </td>

                                <!-- Status -->
                                <td class="p-4 sm:p-5">
                                    @if ($pkg->is_active)
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-950/60 border border-emerald-500/40 text-emerald-300 text-[10px] font-bold">Active</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full bg-rose-950/60 border border-rose-600/40 text-rose-300 text-[10px] font-bold">Disabled</span>
                                    @endif
                                </td>

                                <!-- Actions: Compact Edit and Delete Icon Buttons -->
                                <td class="p-4 sm:p-5 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button type="button" onclick="openEditPackageModal({{ json_encode($pkg) }})" class="w-8 h-8 rounded-xl bg-natural-darkPaper hover:bg-natural-darkCard border border-natural-darkBorder hover:border-amber-400 text-amber-300 transition flex items-center justify-center shadow-xs cursor-pointer" title="Edit Package">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </button>
                                        
                                        <form id="deletePkgForm-{{ $pkg->id }}" method="POST" action="{{ route('admin.packages.destroy', $pkg) }}" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmPackageDelete('deletePkgForm-{{ $pkg->id }}', '{{ addslashes($pkg->name) }}')" class="w-8 h-8 rounded-xl bg-natural-darkPaper hover:bg-rose-950/60 border border-natural-darkBorder hover:border-rose-600/40 text-natural-textMuted hover:text-rose-300 transition flex items-center justify-center cursor-pointer" title="Delete Package">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-natural-textMuted">
                                    No packages configured. Click "Create New Package" to add your first investment tier.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- ================= MODAL: CREATE PACKAGE ================= -->
    <div id="createPackageModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-natural-darkCard border border-natural-darkBorder rounded-3xl p-6 sm:p-8 max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="flex items-center justify-between pb-4 border-b border-natural-darkBorder">
                <div>
                    <h3 class="font-serif font-bold text-xl text-white">Create New Investment Package</h3>
                    <p class="text-xs text-natural-textMuted">Define flexible investment price ranges and daily profit ranges.</p>
                </div>
                <button type="button" onclick="closeCreatePackageModal()" class="text-natural-textMuted hover:text-white p-2">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.packages.store') }}" class="space-y-4 pt-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Package Name *</label>
                    <input type="text" name="name" required placeholder="e.g. Cedar Prime" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none transition">
                </div>

                <!-- Price Range: Min & Max -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Min Price ($) *</label>
                        <input type="number" step="0.01" min="1" name="min_investment" required placeholder="100.00" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-white focus:border-amber-400 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Max Price ($)</label>
                        <input type="number" step="0.01" min="1" name="max_investment" placeholder="200.00" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-white focus:border-amber-400 focus:outline-none transition">
                    </div>
                </div>

                <!-- Daily Profit Range: Min & Max -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Min Daily Profit (%) *</label>
                        <input type="number" step="0.01" min="0.01" max="100" name="min_daily_profit_percent" required placeholder="1.75" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-natural-mint font-bold focus:border-amber-400 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Max Daily Profit (%)</label>
                        <input type="number" step="0.01" min="0.01" max="100" name="max_daily_profit_percent" placeholder="2.00" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-natural-mint font-bold focus:border-amber-400 focus:outline-none transition">
                    </div>
                </div>

                <!-- Referral Commission % -->
                <div>
                    <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Referral Commission (%) *</label>
                    <input type="number" step="0.01" min="0" max="100" name="referral_commission_percent" value="5.00" required placeholder="3.00" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-amber-400 font-bold focus:border-amber-400 focus:outline-none transition">
                    <p class="text-[10px] text-natural-textMuted mt-1">One-time matching reward credited to the direct referrer when this package is approved.</p>
                </div>

                <!-- 30-Minute Trade Profit Range: Min & Max -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Min Trade Profit (%) *</label>
                        <input type="number" step="0.01" min="0.01" max="100" name="min_trade_profit_percent" required placeholder="1.75" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-amber-300 font-bold focus:border-amber-400 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Max Trade Profit (%)</label>
                        <input type="number" step="0.01" min="0.01" max="100" name="max_trade_profit_percent" placeholder="2.00" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-amber-300 font-bold focus:border-amber-400 focus:outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Min. Cashout Limit ($) *</label>
                    <input type="number" step="0.01" min="1" name="min_withdrawal_limit" value="10.00" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-white focus:border-amber-400 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Package Description</label>
                    <textarea name="description" rows="2" placeholder="Brief overview of the investment package..." class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none transition"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="is_active" id="createIsActive" value="1" checked class="rounded border-natural-darkBorder bg-natural-darkPaper text-amber-400 focus:ring-0">
                    <label for="createIsActive" class="text-xs text-natural-textPrimary">Activate package immediately</label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-natural-darkBorder">
                    <button type="button" onclick="closeCreatePackageModal()" class="px-4 py-2.5 rounded-xl text-xs font-bold text-natural-textMuted hover:text-white transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 text-xs font-bold transition shadow-md">
                        Save Package
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ================= MODAL: EDIT PACKAGE ================= -->
    <div id="editPackageModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden flex items-center justify-center p-4">
        <div class="bg-natural-darkCard border border-natural-darkBorder rounded-3xl p-6 sm:p-8 max-w-lg w-full max-h-[90vh] overflow-y-auto shadow-2xl">
            <div class="flex items-center justify-between pb-4 border-b border-natural-darkBorder">
                <div>
                    <h3 class="font-serif font-bold text-xl text-white">Edit Investment Package</h3>
                    <p class="text-xs text-natural-textMuted">Modify package price ranges, daily returns, and minimum limits.</p>
                </div>
                <button type="button" onclick="closeEditPackageModal()" class="text-natural-textMuted hover:text-white p-2">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="editPackageForm" method="POST" action="" class="space-y-4 pt-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Package Name *</label>
                    <input type="text" name="name" id="editName" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none transition">
                </div>

                <!-- Price Range: Min & Max -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Min Price ($) *</label>
                        <input type="number" step="0.01" min="1" name="min_investment" id="editMinInvestment" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-white focus:border-amber-400 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Max Price ($)</label>
                        <input type="number" step="0.01" min="1" name="max_investment" id="editMaxInvestment" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-white focus:border-amber-400 focus:outline-none transition">
                    </div>
                </div>

                <!-- Daily Profit Range: Min & Max -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Min Daily Profit (%) *</label>
                        <input type="number" step="0.01" min="0.01" max="100" name="min_daily_profit_percent" id="editMinDailyProfit" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-natural-mint font-bold focus:border-amber-400 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Max Daily Profit (%)</label>
                        <input type="number" step="0.01" min="0.01" max="100" name="max_daily_profit_percent" id="editMaxDailyProfit" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-natural-mint font-bold focus:border-amber-400 focus:outline-none transition">
                    </div>
                </div>

                <!-- Referral Commission % -->
                <div>
                    <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Referral Commission (%) *</label>
                    <input type="number" step="0.01" min="0" max="100" name="referral_commission_percent" id="editReferralCommission" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-amber-400 font-bold focus:border-amber-400 focus:outline-none transition">
                </div>

                <!-- 30-Minute Trade Profit Range: Min & Max -->
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Min Trade Profit (%) *</label>
                        <input type="number" step="0.01" min="0.01" max="100" name="min_trade_profit_percent" id="editMinTradeProfit" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-amber-300 font-bold focus:border-amber-400 focus:outline-none transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Max Trade Profit (%)</label>
                        <input type="number" step="0.01" min="0.01" max="100" name="max_trade_profit_percent" id="editMaxTradeProfit" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-amber-300 font-bold focus:border-amber-400 focus:outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Min. Cashout Limit ($) *</label>
                    <input type="number" step="0.01" min="1" name="min_withdrawal_limit" id="editMinCashout" required class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs font-mono text-white focus:border-amber-400 focus:outline-none transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Package Description</label>
                    <textarea name="description" id="editDescription" rows="2" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-xl px-4 py-2.5 text-xs text-white focus:border-amber-400 focus:outline-none transition"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" name="is_active" id="editIsActive" value="1" class="rounded border-natural-darkBorder bg-natural-darkPaper text-amber-400 focus:ring-0">
                    <label for="editIsActive" class="text-xs text-natural-textPrimary">Package is Active</label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-natural-darkBorder">
                    <button type="button" onclick="closeEditPackageModal()" class="px-4 py-2.5 rounded-xl text-xs font-bold text-natural-textMuted hover:text-white transition">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 text-xs font-bold transition shadow-md">
                        Update Package
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openCreatePackageModal() {
            document.getElementById('createPackageModal').classList.remove('hidden');
        }
        function closeCreatePackageModal() {
            document.getElementById('createPackageModal').classList.add('hidden');
        }

        function openEditPackageModal(pkg) {
            document.getElementById('editPackageForm').action = `/admin/packages/${pkg.id}`;
            document.getElementById('editName').value = pkg.name;
            document.getElementById('editMinInvestment').value = pkg.min_investment ?? pkg.investment_amount;
            document.getElementById('editMaxInvestment').value = pkg.max_investment ?? pkg.investment_amount;
            document.getElementById('editMinDailyProfit').value = pkg.min_daily_profit_percent ?? pkg.daily_commission_percent;
            document.getElementById('editMaxDailyProfit').value = pkg.max_daily_profit_percent ?? pkg.daily_commission_percent;
            document.getElementById('editReferralCommission').value = pkg.referral_commission_percent ?? 5.00;
            document.getElementById('editMinTradeProfit').value = pkg.min_trade_profit_percent ?? pkg.min_daily_profit_percent ?? 2.00;
            document.getElementById('editMaxTradeProfit').value = pkg.max_trade_profit_percent ?? pkg.max_daily_profit_percent ?? 2.50;
            document.getElementById('editMinCashout').value = pkg.min_withdrawal_limit;
            document.getElementById('editDescription').value = pkg.description || '';
            document.getElementById('editIsActive').checked = Boolean(pkg.is_active);

            document.getElementById('editPackageModal').classList.remove('hidden');
        }
        function closeEditPackageModal() {
            document.getElementById('editPackageModal').classList.add('hidden');
        }

        function confirmPackageDelete(formId, pkgName) {
            Swal.fire({
                title: 'Delete Package?',
                html: `Are you sure you want to permanently delete package "<strong>${pkgName}</strong>"? This action cannot be undone.`,
                icon: 'warning',
                iconColor: '#f43f5e',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#23352B',
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    popup: 'verdant-swal-popup',
                    title: 'verdant-swal-title',
                    htmlContainer: 'verdant-swal-html',
                    confirmButton: 'px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider',
                    cancelButton: 'px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-natural-textMuted'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
</x-app-layout>
