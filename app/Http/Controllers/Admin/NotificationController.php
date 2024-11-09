<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifications = Notification::where('notifiable_id', Auth::user()->id)  // $userId is the ID of the user
        ->where('notifiable_type', User::class)
            ->where('created_at', '>=', now()->subDays(1))
            ->get();


        return view('admin.notifications.index', compact('notifications'));
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
        // Get the authenticated user's notifications with potential eager loading if needed
        $notifications = Notification::where('user_id', Auth::id())
            // Example: eager load relationships if you have any, like 'user', 'relatedModel'
            // ->with(['user', 'relatedModel'])
            ->get();

        return view('admin.notifications.show', compact(
            'notification',
            'notifications',
        ));
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
