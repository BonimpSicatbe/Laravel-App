<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\File;
use App\Models\Notification;
use App\Models\Requirement;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $tasks = Task::where('status', ['pending', 'in_progress'])
            ->get();

        $notifications = $user->notifications;

        // overview
        $total_requirements = Requirement::all();
        $total_tasks = Task::all();
        $total_users = User::all();
        $total_attachments = Attachment::all();
        $total_files = File::all();

        // pending task
        $pending_tasks = Task::where('status', ['pending', 'in_progress'])->get();

        return view('admin.dashboard.index', compact([
            'notifications',
            'tasks',
            'total_requirements',
            'total_tasks',
            'total_users',
            'total_attachments',
            'total_files',
            'pending_tasks',
        ]));
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
