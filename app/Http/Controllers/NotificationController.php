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

        $notification->update([
            'is_read' => true,
        ]);

        return response()->json(['message' => 'Notification marked as read']);
    }


    public function all()
    {
        $notifications = auth()->user()->notifications()->latest()->take(20)->get()->map(function ($n) {
            return [
                'id' => $n->id,
                'title' => $n->title,
                'message' => $n->message,
                'type' => $n->type,
                'time' => $n->created_at->diffForHumans(),
                'is_read' => $n->is_read,
            ];
        });

        return response()->json($notifications);
    }

    public function show($id)
    {
        \Log::info('Notification ID received: ', [$id]);

        $notification = auth()->user()->notifications()->where('id', $id)->first();
        \Log::info($notification);

        if (!$notification) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        return response()->json([
            'id' => $notification->id,
            'title' => $notification->title ?? 'No title',
            'message' => $notification->message ?? 'No message',
            'type' => $notification->type ?? 'info',
            'created_at' => $notification->created_at->format('F j, Y, g:i A'),
        ]);
    }





}
