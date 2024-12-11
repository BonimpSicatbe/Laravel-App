<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\Requirement;
use App\Models\Task;
use App\Models\TaskAttachment;
use App\Models\TaskUser;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $tasks = $user->tasks()->get();

        return view('user.tasks.index', compact(
            'tasks',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Requirement $requirement, Request $request)
    {
        $requirement = Requirement::with(['tasks.users', 'tasks.createdBy'])
            ->find($request->requirement);

        $tasks = $requirement->tasks;

        if (!$requirement) {
            return back()->with('error', 'Requirement not found.');
        }

        return view('user.tasks.create', compact(
            'requirement',
            'tasks'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        return back()->with('success', 'Task created successfully and users assigned!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $user = Auth::user();
//        $attachments = Attachment::with(['task', 'users', 'createdBy'])
//            ->where('task_id', $task->id)
//            ->get();

        $assigned_users = $task->requirement;

        return view('user.tasks.show', compact(
//            'attachments',
            'task',
            'assigned_users',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('user.tasks.edit', compact(
            'task',
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'priority' => 'required|string|in:low,medium,high', // Ensure the priority value is one of these options
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // Update the task fields
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->due_date = $request->input('due_date');
        $task->priority = $request->input('priority');
        $task->updated_by = Auth::id(); // Set the updated_by field to the current user's ID
        $task->save();

        // Handle file upload if a new file is provided
        if ($request->hasFile('file')) {
            $originalFile = $request->file('file');
            $filePath = $originalFile->store('uploads/tasks/' . $task->id);

            // Save the file details in the attachments table
            $attachment = new Attachment();
            $attachment->name = $originalFile->getClientOriginalName();
            $attachment->file_path = $filePath;
            $attachment->task_id = $task->id;
            $attachment->save();
        }

        return redirect()->route('tasks.show', $task->id)
            ->with('success', 'Task updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->files()->delete();
        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully');
    }

    /*
     *
     * custom routes
     *
     * */
    private function getUsersBasedOnType(Requirement $requirement)
    {
        switch ($requirement->sent_to_type) {
            case 'course':
                return DB::table('course_users')
                    ->where('course_id', $requirement->sent_to_id)
                    ->pluck('user_id');

            case 'subject':
                return DB::table('subject_users')
                    ->where('subject_id', $requirement->sent_to_id)
                    ->pluck('user_id');

            case 'position':
                return DB::table('position_users')
                    ->where('position_id', $requirement->sent_to_id)
                    ->pluck('user_id');

            case 'all':
                return User::pluck('id');

            default:
                return collect();
        }
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('uploadTaskAttachment')) {
            $file = $request->file('uploadTaskAttachment');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '_' . now()->timestamp;
            $file->storeAs('tasks_attachments/tmp/' . $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);

            // Return a JSON response with the folder name
            return response()->json(['folder' => $folder]);
        }

        return response()->json(['folder' => ''], 400);
    }
}
