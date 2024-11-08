<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Folder;
use App\Models\Requirement;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $files = $user->files;

        return view('files.index', compact(
            'files',
        ));
    }

    public function showTasks($requirementId)
    {
        $user = Auth::user();

        // Get all tasks for the specific requirement and user, along with the requirement data
        $tasks = Task::where('user_id', $user->id)
            ->where('requirement_id', $requirementId)
            ->with('requirement') // Load the related requirement
            ->get();

        return view('files.showTasks', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Task $task)
    {
        $request->validate([
            'files.*' => 'required|file',
        ]);

        $files = $request->file('files');
        $names = $request->input('file_names', []); // Optional custom names

        foreach ($files as $index => $uploadedFile) {
            $path = $uploadedFile->store('files', 'public'); // Store in the 'public' disk
            $name = isset($names[$index]) ? $names[$index] : $uploadedFile->getClientOriginalName();

            $task->files()->create([
                'name' => $name,
                'path' => $path,
                'size' => $uploadedFile->getSize(),
                'mime_type' => $uploadedFile->getMimeType(),
            ]);
        }

        return redirect()->back()->with('success', 'Files uploaded successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Retrieve the file by its ID
        $file = File::findOrFail($id);

        // Return the file for download
        return Storage::disk('public')->download($file->path, $file->name);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the file by ID and delete it
        $file = File::findOrFail($id);
        Storage::disk('public')->delete($file->path); // Delete from storage
        $file->delete(); // Remove from database

        return redirect()->route('files.index')->with('success', 'File deleted successfully!');
    }
}
