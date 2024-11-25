<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\File;
use App\Models\Requirement;
use App\Models\Task;
use App\Models\TaskAttachment;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Storage;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with(['requirement', 'createdBy', 'users'])
            ->get();

        return view('admin.tasks.index', compact(
            'tasks',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $requirement = Requirement::with(['tasks.users', 'tasks.createdBy'])
            ->find($request->requirement);

        $tasks = $requirement->tasks;

        if (!$requirement) {
            return back()->with('error', 'Requirement not found.');
        }

        return view('admin.tasks.create', compact(
            'requirement',
            'tasks'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'requirement_id' => 'required|exists:requirements,id',
            'uploadTaskAttachment' => 'nullable|string', // Temporary folder name
        ]);

        // Create the task
        $task = Task::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'priority' => $request['priority'],
            'due_date' => $request['due_date'],
            'requirement_id' => $request['requirement_id'],
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        $temporaryFile = TemporaryFile::where('folder', $request->attachment)->first();
        if ($temporaryFile) {
            $task->addMedia(storage_path('attachment/tmp/' . $request->avatar . '/' . $temporaryFile->filename))
                ->toMediaCollection('attachments');
            rmdir(storage_path('attachments/tmp/' . $request->attachment));
            $temporaryFile->delete();
        }

        // Process attachments if uploaded
        if ($request->attachment) {
            $temporaryFile = TemporaryFile::where('folder', $request->attachment)->first();
            if ($temporaryFile) {
                $finalPath = 'tasks_attachments/' . $task->id;
                $filePath = $finalPath . '/' . $temporaryFile->filename;

                // Move the file to the final directory
                Storage::move('attachments/tmp/' . $temporaryFile->folder . '/' . $temporaryFile->filename, $filePath);

                // Save the attachment record
                Attachment::create([
                    'task_id' => $task->id,
                    'file_name' => $temporaryFile->filename,
                    'file_path' => $filePath,
                    'requirement_id' => $request['requirement_id'],
                ]);

                // Remove the temporary record
                TemporaryFile::where('folder', $request->attachment)->delete();

                // Delete the temporary folder
                Storage::deleteDirectory('attachments/tmp/' . $temporaryFile->folder);
            }
        }

        return redirect()->route('admin.requirements.show', $request->requirement_id)
            ->with('success', 'Task created successfully with attachments.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $user = Auth::user();
        $attachments = Attachment::with(['task', 'users', 'createdBy'])
            ->where('task_id', $task->id)
            ->get();

        $assigned_users = $task->requirement;

        return view('admin.tasks.show', compact(
            'attachments',
            'task',
            'assigned_users',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return view('admin.tasks.edit', compact(
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

        return redirect()->route('admin.tasks.show', $task->id)
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
        if ($request->hasFile('attachments')) {
            $attachment = $request->file('attachments');
            $filename = $attachment->getClientOriginalName();
            $folder = uniqid() . '_' . now()->timestamp;
            $attachment->storeAs('attachments/tmp/' . $folder, $filename);

            TemporaryFile::create([
                'folder' => $folder,
                'filename' => $filename,
            ]);

            return $folder;
        }
        return '';
    }

    public function revert(Request $request)
    {
        $folder = $request->getContent();
        $temporaryFile = TemporaryFile::where('folder', $folder)->first();


    }
}
