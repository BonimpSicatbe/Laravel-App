<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequirementResource;
use App\Http\Resources\TaskResource;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\File;
use App\Models\Position;
use App\Models\PositionUser;
use App\Models\Requirement;
use App\Models\RequirementUser;
use App\Models\Subject;
use App\Models\SubjectUser;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        return view('requirements.index', compact('requirements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $subjects = Subject::all();
        $positions = Position::all();

        return view('requirements.create', compact(
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
            'selected_course' => 'nullable|exists:courses,id',
            'selected_subject' => 'nullable|exists:subjects,id',
            'selected_position' => 'nullable|exists:positions,id',
        ]);

        // Step 1: Prepare data for 'sent_to'
        $sentToType = null;
        $sentToId = null;

        switch ($request->select_group) {
            case 'course':
                $sentToType = 'course';
                $sentToId = $request->selected_course;
                break;

            case 'subject':
                $sentToType = 'subject';
                $sentToId = $request->selected_subject;
                break;

            case 'position':
                $sentToType = 'position';
                $sentToId = $request->selected_position;
                break;
        }

        // Step 2: Create the Requirement with 'sent_to_type' and 'sent_to_id'
        $requirement = Requirement::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'sent_to_type' => $sentToType,  // Saving the group type
            'sent_to_id' => $sentToId,      // Saving the corresponding ID
        ]);

        // Step 3: Assign users to the Requirement based on the selected group
        $users = collect();  // Initialize an empty collection of users

        switch ($request->select_group) {
            case 'course':
                if ($request->has('selected_course')) {
                    $users = DB::table('course_users')->where('course_id', $request->selected_course)->pluck('user_id');
                }
                break;

            case 'subject':
                if ($request->has('selected_subject')) {
                    $users = DB::table('subject_users')->where('subject_id', $request->selected_subject)->pluck('user_id');
                }
                break;

            case 'position':
                if ($request->has('selected_position')) {
                    $users = DB::table('position_users')->where('position_id', $request->selected_position)->pluck('user_id');
                }
                break;

            case 'all':
                $users = User::pluck('id');
                break;
        }

        // Step 4: Attach users to the requirement (many-to-many relationship)
        if ($users->isNotEmpty()) {
            $requirement->users()->attach($users->toArray());
        }

        // Step 5: Redirect to the Task Creation page with the newly created requirement ID
        return redirect()->route('tasks.create', ['requirement' => $requirement->id])
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

        return view('requirements.show', compact(
            'requirement',
            'tasks',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requirement $requirement)
    {
        return view('requirements.edit', compact(
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
        return redirect()->route('requirements.show', $requirement->id)->with('success', 'Requirement updated successfully.');
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

        return redirect()->route('requirements.index')->with('success', 'Requirement and associated tasks deleted successfully.');
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

        return view('requirements.tasks', compact(
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


