<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BroadcastNotification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display broadcast notifications management.
     */
    public function index(): View
    {
        $broadcasts = BroadcastNotification::with('creator')->latest()->get();
        $totalInvestors = User::where('role', 'user')->count();

        return view('admin.notifications.index', compact('broadcasts', 'totalInvestors'));
    }

    /**
     * Broadcast a new notification to all users.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'in:announcement,bonus,alert,system'],
            'body' => ['required', 'string'],
        ]);

        $type = $validated['type'] ?? 'announcement';

        $users = User::where('role', 'user')->get();

        $broadcast = BroadcastNotification::create([
            'title' => $validated['title'],
            'type' => $type,
            'body' => $validated['body'],
            'created_by' => $request->user()->id,
            'recipients_count' => $users->count(),
        ]);

        $now = now();
        $notifications = [];

        foreach ($users as $user) {
            $notifications[] = [
                'user_id' => $user->id,
                'broadcast_id' => $broadcast->id,
                'title' => $validated['title'],
                'type' => $type,
                'body' => $validated['body'],
                'is_read' => false,
                'read_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (! empty($notifications)) {
            // Bulk insert in chunks of 500 for high efficiency
            foreach (array_chunk($notifications, 500) as $chunk) {
                UserNotification::insert($chunk);
            }
        }

        return redirect()->route('admin.notifications.index')
            ->with('status', "Broadcast '{$broadcast->title}' sent to {$users->count()} registered investors.");
    }

    /**
     * Delete a broadcast notification.
     */
    public function destroy(BroadcastNotification $notification): RedirectResponse
    {
        $title = $notification->title;
        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('status', "Notification '{$title}' deleted successfully.");
    }
}
