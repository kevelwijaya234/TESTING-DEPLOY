<?php

namespace App\Http\Controllers;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        Notification::where(
            'member_id',
            session('member_id')
        )->update([
            'is_read' => true
        ]);

        $notifications = Notification::where(
            'member_id',
            session('member_id')
        )
            ->latest()
            ->get();

        return view(
            'anggota.notifications.index',
            compact('notifications')
        );
    }
}
