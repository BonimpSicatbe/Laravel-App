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
use Illuminate\Support\Facades\Validator;
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
        $assigned_users = Requirement::with(['tasks.users'])
            ->find($request->requirement);
        $requirement = Requirement::with(['tasks.users', 'tasks.createdBy'])
            ->find($request->requirement);

        $tasks = $requirement->tasks;

        if (!$requirement) {
            return back()->with('error', 'Requirement not found.');
        }


        return view('admin.tasks.create', compact(
            'requirement',
            'tasks',
            'assigned_users',
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'requirement_id' => 'required|exists:requirements,id',
        ]);

        // Create the task
        $task = Task::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'priority' => $validatedData['priority'],
            'due_date' => $validatedData['due_date'],
            'requirement_id' => $validatedData['requirement_id'],
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        // Process attachments
        $attachments = $request->attachments;

        if ($attachments) {
            $file_path = "uploads/tasks/attachments/{$task->id}";
            $files = collect();

            foreach ($attachments as $attachment) {
                // Decode the JSON string (if applicable)
                $decodedAttachment = json_decode($attachment, true);

                if (isset($decodedAttachment['folder'])) {
                    $folder = $decodedAttachment['folder'];

                    // Log the folder name for debugging
                    \Log::info("Processing files from folder: {$folder}");

                    // Retrieve the temporary files from the database
                    $temporaryFiles = TemporaryFile::where('folder', $folder)->get();

                    foreach ($temporaryFiles as $tempFile) {
                        // Define the temporary file's path
                        $tempFilePath = storage_path("app/uploads/tmp/{$folder}/{$tempFile->filename}");

                        // Ensure the file exists before proceeding
                        if (file_exists($tempFilePath)) {
                            $file_name = $tempFile->filename;
                            $size = filesize($tempFilePath);
                            $type = mime_content_type($tempFilePath);

                            // Define the permanent storage path
                            $storedPath = "{$file_path}/{$file_name}";
                            Storage::put($storedPath, file_get_contents($tempFilePath));

                            // Save the file's metadata to the `attachments` table
                            $createdAttachment = Attachment::create([
                                'file_name' => $file_name,
                                'size' => $size,
                                'type' => $type,
                                'file_path' => $storedPath,
                                'task_id' => $task->id,
                                'requirement_id' => $validatedData['requirement_id'],
                                'created_at' => now(),
                                'updated_at' => now(),
                                'created_by' => Auth::id(),
                                'updated_by' => Auth::id(),
                            ]);

                            $files->push($createdAttachment);

                            // Optionally: Delete the temporary file after moving
                            unlink($tempFilePath);
                        }
                    }

                    // Optionally: Clean up the folder after processing
                    Storage::deleteDirectory("uploads/tmp/{$folder}");
                    TemporaryFile::where('folder', $folder)->delete();
                }
            }

            // Debug output for validation
            \Log::info('Attachments successfully processed:', $files->toArray());
        }

        return redirect()->route('admin.requirements.show', $validatedData['requirement_id'])
            ->with('success', 'Task created successfully with attachments.');
    }


    /*
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date',
            'requirement_id' => 'required|exists:requirements,id',
//        'attachments.*' => 'file|max:2048', // Adjust max file size as needed
        ]);

        // Create the task
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->due_date,
            'requirement_id' => $request->requirement_id,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        // Check if files exist and process them
        if ($request->has('attachments') && $request->file('attachments')) {
            $attachments = $request->file('attachments');

            $finalPath = "uploads/tasks/{$task->id}/attachments/";

            // Ensure attachments is an array
            if (is_array($attachments)) {
                foreach ($attachments as $attachment) {
                    $fileName = $attachment->getClientOriginalName();
                    $temporaryFile = TemporaryFile::where('filename', $fileName)->first();

                    if ($temporaryFile) {
                        $folder = "uploads/tmp/{$temporaryFile->folder}/";
                        $finalFilePath = "{$finalPath}{$temporaryFile->filename}";

                        // Move the file to its final destination
                        Storage::disk('local')->move("{$folder}{$temporaryFile->filename}", $finalFilePath);

                        // Save file metadata
                        Attachment::create([
                            'file_name' => $temporaryFile->filename,
                            'size' => $attachment->getSize(),
                            'type' => $attachment->getMimeType(),
                            'file_path' => $finalFilePath,
                            'task_id' => $task->id,
                            'requirement_id' => $task->requirement_id,
                            'created_by' => Auth::id(),
                            'updated_by' => Auth::id(),
                        ]);

                        // Cleanup temporary files
                        Storage::disk('local')->deleteDirectory($folder);
                        $temporaryFile->delete();
                    }
                }
            }
        }

        dd('File not found.');

        return redirect()->route('admin.tasks.show', $task->id)->with('success', 'Task and attachments saved successfully!');
    }
    */

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        // Load the necessary relationships, including 'users'
//        $task->load(['attachments', 'requirement', 'createdBy', 'updatedBy', 'users']);
        $task->with('users')->get();

        $assigned_users = $task->requirement; // Assuming you want the requirement's data

        $attachments = Attachment::where('task_id', $task->id)->get();

        return view('admin.tasks.show', compact(
            'task',
            'assigned_users',
            'attachments',
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


}
