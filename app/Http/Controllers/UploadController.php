<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'uploadTaskFile.*' => 'required|file|max:2048', // Adjust the max size as needed
        ]);

        $requirementId = $request->requirement_id; // Get the requirement ID from the request
        $taskId = $request->task_id; // Get the task ID from the request
        $userId = auth()->id(); // Get the authenticated user's ID

        // Check if the request has files
        if ($request->hasFile('uploadTaskFile')) {
            $files = $request->file('uploadTaskFile');
            $folderPath = 'uploads/requirements/' . $requirementId . '/tasks/' . $taskId . '/';

            foreach ($files as $file) {
                // Store the file in the specified folder
                $filePath = $file->storeAs($folderPath, $file->getClientOriginalName());

                // Create an entry in the attachments table
                Attachment::create([
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'type' => $file->getClientMimeType(),
                    'file_path' => $filePath,
                    'requirement_id' => $requirementId,
                    'task_id' => $taskId,
                    'user_id' => $userId,
                ]);
            }

            return response()->json(['success' => true, 'message' => 'Files uploaded successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'No files uploaded.']);
    }
}
