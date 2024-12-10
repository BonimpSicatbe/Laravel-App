<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Notification;
use App\Models\NotificationHasAttachments;
use App\Models\Requirement;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\UserHasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Auth::user()->notifications;

        return view('user.notifications.index', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $notification)
    {
        $user = Auth::user();

        // Check if the user has the notification in the pivot table
        $userNotification = $user->notifications()->where('notifications.id', $notification->id)->first();

        if (!$userNotification) {
            abort(403, 'Unauthorized action.');
        }

        // If the notification is unread, update the 'read_at' field to the current timestamp
        $userNotification->pivot->update(['read_at' => now()]);

        // Get all notifications of the authenticated user for display
        $notifications = $user->notifications;

        return view('user.notifications.show', compact('notification', 'notifications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notification $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $notification)
    {
        //
    }
}
