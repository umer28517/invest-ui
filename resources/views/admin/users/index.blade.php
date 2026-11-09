<x-app-layout>
    <div class="space-y-6">

        <!-- Compact Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-1">
            <div>
                <h2 class="font-serif font-bold text-xl sm:text-2xl text-white">Investor & User Management</h2>
                <p class="text-xs text-natural-textMuted font-mono">Directory of registered investor accounts</p>
            </div>
            <div class="flex items-center gap-2 font-mono text-xs">
                <span class="px-3 py-1 rounded-lg bg-natural-darkPaper border border-natural-darkBorder text-natural-mint">
                    Total: {{ $users->count() }}
                </span>
                <span class="px-3 py-1 rounded-lg bg-emerald-950/60 border border-emerald-500/30 text-emerald-300">
                    Active: {{ $users->where('is_active', true)->count() }}
                </span>
                <span class="px-3 py-1 rounded-lg bg-rose-950/60 border border-rose-500/30 text-rose-300">
                    Disabled: {{ $users->where('is_active', false)->count() }}
                </span>
            </div>
        </div>

        <!-- Search Filter Bar -->
        <div class="p-4 rounded-2xl bg-natural-darkCard border border-natural-darkBorder flex items-center gap-3">
            <i class="fa-solid fa-magnifying-glass text-natural-textMuted text-sm"></i>
            <input type="text" id="userSearchInput" onkeyup="filterUserTable()" placeholder="Search user by name, email, phone, or referral code..." class="w-full bg-transparent border-0 text-xs text-white placeholder-natural-textMuted focus:outline-none focus:ring-0">
        </div>

        <!-- Users Directory Table -->
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder shadow-dark-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-natural-textPrimary" id="usersTable">
                    <thead class="bg-[#0A100D] text-natural-textMuted uppercase font-mono tracking-wider border-b border-natural-darkBorder text-[11px]">
                        <tr>
                            <th class="p-4 sm:p-5">Investor Details</th>
                            <th class="p-4 sm:p-5">Active Tier & Yield</th>
                            <th class="p-4 sm:p-5">Compounding Balance</th>
                            <th class="p-4 sm:p-5">Capital Lock</th>
                            <th class="p-4 sm:p-5">Status</th>
                            <th class="p-4 sm:p-5">Joined</th>
                            <th class="p-4 sm:p-5 text-right">Account Control & History</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-darkBorder">
                        @forelse ($users as $u)
                            <tr class="hover:bg-natural-darkPaper/60 transition group user-row">
                                
                                <!-- User Name & Email -->
                                <td class="p-4 sm:p-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl {{ $u->isAdmin() ? 'bg-amber-950/60 text-amber-400 border border-amber-500/40' : 'bg-natural-forest/40 text-natural-mint border border-natural-moss/40' }} flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.users.show', $u) }}" class="font-bold text-white text-sm user-name hover:text-amber-400 transition">{{ $u->name }}</a>
                                            <div class="text-[11px] text-natural-textMuted font-mono user-email">{{ $u->email }}</div>
                                            <div class="text-[10px] text-stone-500 font-mono">Ref: {{ $u->referral_code }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Active Tier & Daily Rate -->
                                <td class="p-4 sm:p-5">
                                    @if ($u->active_daily_rate > 0)
                                        <div class="font-bold text-amber-300 text-xs">{{ $u->activePackage?->name ?? 'Active Plan' }}</div>
                                        <div class="text-[10px] text-natural-mint font-mono">+{{ number_format($u->active_daily_rate, 2) }}% / day</div>
                                    @else
                                        <span class="text-stone-500 font-mono text-[11px]">No Active Plan</span>
                                    @endif
                                </td>

                                <!-- Total Compounding Available Balance -->
                                <td class="p-4 sm:p-5 font-mono">
                                    <div class="font-bold text-white text-sm">${{ number_format($u->balance, 2) }}</div>
                                    <div class="text-[10px] text-natural-sage">Yield base</div>
                                </td>

                                <!-- 30-Day Lock Status -->
                                <td class="p-4 sm:p-5 font-mono text-[11px]">
                                    @if ($u->isCapitalLocked())
                                        <span class="inline-flex items-center gap-1 text-amber-300 font-bold bg-amber-950/40 border border-amber-500/30 px-2 py-0.5 rounded-md text-[10px]">
                                            <i class="fa-solid fa-lock text-[9px]"></i> {{ $u->daysRemainingLocked() }}d left
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-emerald-400 font-bold bg-emerald-950/40 border border-emerald-500/30 px-2 py-0.5 rounded-md text-[10px]">
                                            <i class="fa-solid fa-lock-open text-[9px]"></i> Unlocked
                                        </span>
                                    @endif
                                </td>

                                <!-- Status Badge (Active vs Deactivated) -->
                                <td class="p-4 sm:p-5">
                                    @if ($u->is_active)
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-950/50 border border-emerald-500/40 text-emerald-300 text-[11px] font-bold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                            <span>Active</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-rose-950/60 border border-rose-600/50 text-rose-300 text-[11px] font-bold">
                                            <i class="fa-solid fa-ban text-[10px]"></i>
                                            <span>Deactivated</span>
                                        </span>
                                    @endif
                                </td>

                                <!-- Joined Date -->
                                <td class="p-4 sm:p-5 text-natural-textMuted font-mono text-[11px]">
                                    {{ $u->created_at ? $u->created_at->format('M d, Y') : '—' }}
                                </td>

                                <!-- Action: View Audit, Enable / Disable Toggle & Delete -->
                                <td class="p-4 sm:p-5 text-right">
                                    @if ($u->id === Auth::id())
                                        <span class="text-[11px] text-stone-500 italic font-mono px-3 py-1.5 rounded-lg bg-natural-darkPaper border border-natural-darkBorder">
                                            (Your Session)
                                        </span>
                                    @else
                                        <div class="flex items-center justify-end gap-1.5">
                                            <!-- View Full History Dossier -->
                                            <a href="{{ route('admin.users.show', $u) }}" class="px-3 py-1.5 rounded-xl bg-amber-400/20 hover:bg-amber-400/30 border border-amber-400/30 text-amber-300 text-xs font-bold transition flex items-center gap-1.5 shadow-xs" title="View Investor History & Detailed Logs">
                                                <i class="fa-solid fa-chart-pie text-xs"></i>
                                                <span>Audit History</span>
                                            </a>

                                            <!-- Activate / Deactivate Form -->
                                            <form id="toggleUserForm-{{ $u->id }}" method="POST" action="{{ route('admin.users.toggle-status', $u) }}" class="inline-block">
                                                @csrf
                                                @if ($u->is_active)
                                                    <button type="button" onclick="confirmUserStatusToggle('toggleUserForm-{{ $u->id }}', '{{ addslashes($u->name) }}', true)" class="px-3 py-1.5 rounded-xl bg-rose-950/40 hover:bg-rose-900/60 border border-rose-600/40 text-rose-300 text-xs font-bold transition flex items-center gap-1.5 shadow-xs" title="Deactivate Investor">
                                                        <i class="fa-solid fa-user-xmark text-xs"></i>
                                                        <span>Deactivate</span>
                                                    </button>
                                                @else
                                                    <button type="button" onclick="confirmUserStatusToggle('toggleUserForm-{{ $u->id }}', '{{ addslashes($u->name) }}', false)" class="px-3 py-1.5 rounded-xl bg-natural-forest hover:bg-natural-moss text-white text-xs font-bold transition flex items-center gap-1.5 shadow-xs" title="Activate Investor">
                                                        <i class="fa-solid fa-user-check text-xs"></i>
                                                        <span>Activate</span>
                                                    </button>
                                                @endif
                                            </form>

                                            <!-- Delete User Form -->
                                            <form id="deleteUserForm-{{ $u->id }}" method="POST" action="{{ route('admin.users.destroy', $u) }}" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmUserDelete('deleteUserForm-{{ $u->id }}', '{{ addslashes($u->name) }}')" class="p-2 rounded-xl bg-natural-darkPaper hover:bg-rose-950/60 border border-natural-darkBorder hover:border-rose-600/40 text-natural-textMuted hover:text-rose-300 transition" title="Delete User Account">
                                                    <i class="fa-solid fa-trash text-xs"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-natural-textMuted">
                                    No registered users found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- User Search, SweetAlert2 Status Toggle & Delete Script -->
    <script>
        function filterUserTable() {
            const input = document.getElementById("userSearchInput");
            const filter = input.value.toLowerCase();
            const rows = document.querySelectorAll("#usersTable tbody tr.user-row");

            rows.forEach(row => {
                const name = row.querySelector(".user-name") ? row.querySelector(".user-name").innerText.toLowerCase() : "";
                const email = row.querySelector(".user-email") ? row.querySelector(".user-email").innerText.toLowerCase() : "";
                const phone = row.querySelector(".user-phone") ? row.querySelector(".user-phone").innerText.toLowerCase() : "";
                const ref = row.querySelector(".user-ref") ? row.querySelector(".user-ref").innerText.toLowerCase() : "";

                if (name.includes(filter) || email.includes(filter) || phone.includes(filter) || ref.includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        function confirmUserStatusToggle(formId, userName, isCurrentlyActive) {
            const action = isCurrentlyActive ? 'deactivate' : 'activate';
            const actionTitle = isCurrentlyActive ? 'Deactivate Investor Account?' : 'Activate Investor Account?';
            const confirmBtnColor = isCurrentlyActive ? '#e11d48' : '#2D6A4F';
            const confirmBtnText = isCurrentlyActive ? 'Yes, Deactivate' : 'Yes, Activate';

            Swal.fire({
                title: actionTitle,
                html: `Are you sure you want to <strong>${action.toUpperCase()}</strong> access for investor <strong>${userName}</strong>?`,
                icon: isCurrentlyActive ? 'warning' : 'question',
                iconColor: isCurrentlyActive ? '#f43f5e' : '#52B788',
                showCancelButton: true,
                confirmButtonColor: confirmBtnColor,
                cancelButtonColor: '#23352B',
                confirmButtonText: confirmBtnText,
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

        function confirmUserDelete(formId, userName) {
            Swal.fire({
                title: 'Delete Investor Account?',
                html: `Are you sure you want to permanently delete investor <strong>${userName}</strong>? This action cannot be undone and will erase all account records.`,
                icon: 'warning',
                iconColor: '#f43f5e',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#23352B',
                confirmButtonText: 'Yes, Delete Account',
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
