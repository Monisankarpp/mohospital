<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        // If you are using 'is_read' field (your custom notifications table)
        $notification->update([
            'is_read' => true,
        ]);

        return response()->json(['message' => 'Notification marked as read']);
    }
}
