<x-app-layout>
    <div class="space-y-6">

        <!-- Compact Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-1">
            <div>
                <h2 class="font-serif font-bold text-xl sm:text-2xl text-white">Broadcast Notifications Terminal</h2>
                <p class="text-xs text-natural-textMuted font-mono">Compose announcements and yield alerts for all investors</p>
            </div>
            <div class="flex items-center gap-2 font-mono text-xs">
                <span class="px-3 py-1 rounded-lg bg-natural-darkPaper border border-natural-darkBorder text-natural-mint">
                    Audience: {{ $totalInvestors }}
                </span>
                <span class="px-3 py-1 rounded-lg bg-amber-950/60 border border-amber-600/30 text-amber-300">
                    Total Sent: {{ $broadcasts->count() }}
                </span>
            </div>
        </div>

        <!-- Rich Text Broadcast Creator (Full Width) -->
        <div class="bg-natural-darkCard rounded-3xl p-6 sm:p-8 border border-natural-darkBorder shadow-dark-card space-y-6">
            <div class="flex items-center gap-3 pb-4 border-b border-natural-darkBorder">
                <div class="w-10 h-10 rounded-xl bg-amber-950/60 text-amber-400 border border-amber-600/30 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-pen-nib"></i>
                </div>
                <div>
                    <h3 class="font-serif font-bold text-lg text-white">Compose New Broadcast</h3>
                    <p class="text-xs text-natural-textMuted">Dispatches real-time notification to every registered investor dashboard</p>
                </div>
            </div>

            <form id="broadcastForm" method="POST" action="{{ route('admin.notifications.store') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="type" value="announcement">

                <div>
                    <label for="broadcast_title" class="block text-xs font-bold text-natural-textPrimary mb-1.5">Notification Title *</label>
                    <input id="broadcast_title" type="text" name="title" required placeholder="e.g. Important: Special Platform Update for All Members" value="{{ old('title') }}" class="w-full bg-natural-darkPaper border border-natural-darkBorder rounded-2xl px-4 py-3 text-sm text-white placeholder-natural-textMuted/40 focus:border-amber-400 focus:outline-none transition">
                    <x-input-error :messages="$errors->get('title')" class="mt-1 text-xs text-rose-400" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-natural-textPrimary mb-1.5">Description (Rich Text Editor) *</label>
                    
                    <!-- Quill Rich Text Editor Container -->
                    <div id="quillEditor" class="rounded-2xl overflow-hidden min-h-[160px]">
                        <p>Dear Investors,</p>
                        <p><br></p>
                        <p>We are pleased to announce that your 24-hour yield compounding is now verified and active. You can review your updated wallet balance in your portfolio anytime.</p>
                    </div>

                    <!-- Hidden Textarea to submit HTML content -->
                    <textarea id="hiddenBodyInput" name="body" class="hidden">{{ old('body') }}</textarea>
                    <x-input-error :messages="$errors->get('body')" class="mt-1 text-xs text-rose-400" />
                </div>

                <div class="pt-2">
                    <button type="button" onclick="confirmBroadcastSubmit()" class="w-full py-4 rounded-2xl font-bold text-xs uppercase tracking-wider text-slate-950 bg-amber-400 hover:bg-amber-300 transition shadow-md flex items-center justify-center gap-2">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Broadcast Announcement to All {{ $totalInvestors }} Investors</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Sent Broadcasts History Table -->
        <div class="bg-natural-darkCard rounded-3xl border border-natural-darkBorder shadow-dark-card overflow-hidden">
            <div class="p-6 border-b border-natural-darkBorder flex items-center justify-between">
                <div>
                    <h3 class="font-serif font-bold text-lg text-white">Broadcast History</h3>
                    <p class="text-xs text-natural-textMuted">Past notifications delivered to the investor network</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-natural-darkPaper border border-natural-darkBorder text-xs text-natural-mint font-mono font-bold">
                    {{ $broadcasts->count() }} Dispatched
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-[#0A100D] text-natural-textMuted uppercase font-mono tracking-wider border-b border-natural-darkBorder text-[11px]">
                        <tr>
                            <th class="p-4 sm:p-5">Announcement Title</th>
                            <th class="p-4 sm:p-5">Content Preview</th>
                            <th class="p-4 sm:p-5">Recipients</th>
                            <th class="p-4 sm:p-5">Dispatched By</th>
                            <th class="p-4 sm:p-5">Date</th>
                            <th class="p-4 sm:p-5 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-natural-darkBorder">
                        @forelse ($broadcasts as $broadcast)
                            <tr class="hover:bg-natural-darkPaper/60 transition">
                                <td class="p-4 sm:p-5">
                                    <div class="font-bold text-white text-sm mb-1">{{ $broadcast->title }}</div>
                                    @php
                                        $typeStyles = [
                                            'announcement' => 'bg-emerald-950/60 text-emerald-300 border-emerald-500/40',
                                            'bonus' => 'bg-amber-950/60 text-amber-300 border-amber-600/40',
                                            'alert' => 'bg-rose-950/60 text-rose-300 border-rose-600/40',
                                            'system' => 'bg-sky-950/60 text-sky-300 border-sky-600/40',
                                        ];
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono uppercase font-bold border {{ $typeStyles[$broadcast->type] ?? 'bg-natural-darkPaper text-white border-natural-darkBorder' }}">
                                        {{ $broadcast->type }}
                                    </span>
                                </td>

                                <td class="p-4 sm:p-5 max-w-xs text-stone-300 line-clamp-2">
                                    {{ Str::limit(strip_tags($broadcast->body), 110) }}
                                </td>

                                <td class="p-4 sm:p-5 font-mono text-amber-300 font-bold">
                                    {{ $broadcast->recipients_count }} Investors
                                </td>

                                <td class="p-4 sm:p-5 text-natural-textMuted">
                                    {{ $broadcast->creator->name ?? 'System Admin' }}
                                </td>

                                <td class="p-4 sm:p-5 font-mono text-natural-textMuted text-[11px]">
                                    {{ $broadcast->created_at->format('M d, Y • h:i A') }}
                                </td>

                                <td class="p-4 sm:p-5 text-right">
                                    <form id="deleteBroadcastForm-{{ $broadcast->id }}" method="POST" action="{{ route('admin.notifications.destroy', $broadcast) }}" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmBroadcastDelete('deleteBroadcastForm-{{ $broadcast->id }}', '{{ addslashes($broadcast->title) }}')" class="p-2 rounded-xl bg-natural-darkPaper hover:bg-rose-950/60 border border-natural-darkBorder hover:border-rose-600/40 text-natural-textMuted hover:text-rose-300 transition" title="Delete Broadcast">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-natural-textMuted">
                                    No broadcast notifications sent yet. Use the form above to dispatch your first announcement.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Quill.js Initialization & SweetAlert2 Broadcast Script -->
    <script>
        let quill;
        document.addEventListener('DOMContentLoaded', function() {
            quill = new Quill('#quillEditor', {
                theme: 'snow',
                placeholder: 'Write the complete broadcast announcement details here...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'color': [] }, { 'background': [] }],
                        ['link', 'clean']
                    ]
                }
            });
        });

        function confirmBroadcastSubmit() {
            const title = document.getElementById('broadcast_title').value.trim();
            const htmlContent = quill.root.innerHTML.trim();
            const textContent = quill.getText().trim();

            if (!title) {
                toastr.error('Please enter a notification title.');
                document.getElementById('broadcast_title').focus();
                return;
            }

            if (!textContent || textContent.length < 5) {
                toastr.error('Please write some content in the description editor.');
                return;
            }

            // Sync Quill HTML content to hidden input
            document.getElementById('hiddenBodyInput').value = htmlContent;

            Swal.fire({
                title: 'Broadcast Announcement?',
                html: `Are you sure you want to send <strong>"${title}"</strong> to all <strong>{{ $totalInvestors }} registered investors</strong>?`,
                icon: 'question',
                iconColor: '#f59e0b',
                showCancelButton: true,
                confirmButtonColor: '#f59e0b',
                cancelButtonColor: '#23352B',
                confirmButtonText: 'Yes, Send Broadcast Now',
                cancelButtonText: 'Cancel',
                reverseButtons: true,
                customClass: {
                    popup: 'verdant-swal-popup',
                    title: 'verdant-swal-title',
                    htmlContainer: 'verdant-swal-html',
                    confirmButton: 'px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-slate-950',
                    cancelButton: 'px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-natural-textMuted'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('broadcastForm').submit();
                }
            });
        }

        function confirmBroadcastDelete(formId, title) {
            Swal.fire({
                title: 'Delete Broadcast?',
                html: `Are you sure you want to delete <strong>"${title}"</strong>? This will also remove it from investors' notifications inbox.`,
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
