<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Notification;
use App\Models\Position;
use App\Models\PositionUser;
use App\Models\Requirement;
use App\Models\RequirementUser;
use App\Models\Subject;
use App\Models\SubjectUser;
use App\Models\Task;
use App\Models\User;
use App\Models\UserHasNotification;
use App\Notifications\RequirementAssignedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $requirements = Requirement::with(['tasks', 'users'])
            ->get();

        return view('admin.requirements.index', compact('requirements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $subjects = Subject::all();
        $positions = Position::all();

//        Log::info('Redirecting admin.requirements.create');
        return view('admin.requirements.create', compact(
            'courses',
            'subjects',
            'positions',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validate incoming request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'select_group' => 'required|string',  // Either 'course', 'subject', 'position', or 'all'
            'selected_target' => 'nullable',
        ]);

        // Step 1: Determine 'sent_to_type' and 'sent_to_id'
        $sentToType = $request->select_group === 'all' ? 'all' : $request->select_group;
        $sentToId = $request->select_group === 'all' ? null : $request->selected_target;

        // Step 2: Create the Requirement
        $requirement = Requirement::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'sent_to_type' => $sentToType,
            'sent_to_id' => $sentToId,
        ]);

        // Step 3: Fetch users based on the selected group
        // Initialize an empty collection of users
        $users = collect();
        switch ($request->select_group) {
            case 'course':
                $users = CourseUser::where('course_id', $sentToId)->pluck('user_id');
                break;
            case 'subject':
                $users = SubjectUser::where('subject_id', $sentToId)->pluck('user_id');
                break;
            case 'position':
                $users = PositionUser::where('position_id', $sentToId)->pluck('user_id');
                break;
            case 'all':
                $users = User::pluck('id');
                break;
        }

        // Step 4: Exclude admin and super-admin users
        $excludedRoles = ['admin', 'super-admin'];
        $users = User::whereIn('id', $users)
            ->whereDoesntHave('roles', function ($query) use ($excludedRoles) {
                $query->whereIn('name', $excludedRoles);
            })
            ->pluck('id');

        // get the data for sentToType
        $sentTo = null;
        switch ($sentToType) {
            case 'course':
                $sentTo = Course::where('id', $sentToId)->first();
                break;
            case 'subject':
                $sentTo = Subject::where('id', $sentToId)->first();
                break;
            case 'position':
                $sentTo = Position::where('id', $sentToId)->first();
                break;
            case 'all':
                $sentTo = 'all'; // Explicitly set as 'all'
                break;
        }

        // Step 5: Create the notification
        $notification = Notification::create([
            'title' => $requirement->name,
            'message' => $requirement->description,
            'sent_to' => $sentTo === 'all' ? 'all' : $sentTo->name,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // assign the notification for each user
        foreach ($users as $userId) {
            RequirementUser::create(['requirement_id' => $requirement->id, 'user_id' => $userId, 'created_at' => now(), 'updated_at' => now()]);

            UserHasNotification::create([
                'notification_id' => $notification->id,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Step 7: Redirect to Task Creation page
        return redirect()->route('admin.tasks.create', ['requirement' => $requirement->id])
            ->with('success', 'Requirement created successfully and users assigned!');
    }



    /**
     * Display the specified resource.
     */
    public function show(Requirement $requirement, Request $request)
    {
        $tasks = Task::with(['requirement', 'createdBy'])
            ->where('requirement_id', $requirement->id)
            ->get();

        return view('admin.requirements.show', compact(
            'requirement',
            'tasks',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requirement $requirement)
    {
        return view('admin.requirements.edit', compact(
            'requirement',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Requirement $requirement)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'due_date' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
        ]);

        // Update the requirement with validated data
        $requirement->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'due_date' => $validated['due_date'],
            'priority' => $validated['priority'],
            'updated_by' => Auth::id(),
        ]);

        // Redirect back to the requirements list with a success message
        return redirect()->route('admin.requirements.show', $requirement->id)->with('success', 'Requirement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requirement $requirement)
    {
        // Delete associated tasks first
        $requirement->tasks()->delete();

        // Then delete the requirement
        $requirement->delete();

        return redirect()->route('admin.requirements.index')->with('success', 'Requirement and associated tasks deleted successfully.');
    }

    /*
     *
     * custom routes
     *
     * */

    public function deleteAssignedUser($user, $requirement)
    {
        $requirementUser = RequirementUser::where('user_id', $user->id)
            ->where('requirement_id', $requirement->id)
            ->first();

        if ($requirementUser) {
            $requirementUser->delete();
        }

        return redirect()->back()->with('success', '');
    }

    public function tasks($requirementId)
    {
        $user = Auth::user();
        $tasks = Task::with('requirement', 'user')
            ->where('requirement_id', $requirementId)
            ->get();

//        dd($tasks);

        return view('admin.requirements.tasks', compact(
            'tasks',
        ));
    }

    public function deleteRequirementTask($task)
    {
        $task->files()->delete();
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully');
    }
}


