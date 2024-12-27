<?php

// TODO :: file validation, if file exist in storage, display files in the requirements.show

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\File;
use App\Models\Requirement;
use App\Models\RequirementUser;
use App\Models\Task;
use App\Models\TemporaryFile;
use App\Models\User;
use App\Models\UserHasNotification;
use App\Models\UserSubmittedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Contracts\Role;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $requirements = $user->requirements;

        return view('user.requirements.index', compact(
            'user',
            'requirements',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.requirements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $requirement_id = $request->requirement;

        $validated = $request->validate([
            'userFileUpload' => 'required',
        ]);

        // get the returned or uploaded folder names or files
        $uploadedFile = $validated['userFileUpload'];

        // check if $uploadedFile contains something or is true
        if ($uploadedFile) {
            //
            $file_path = "uploads/requirements/submittedFile/{$requirement_id}";
            $files = collect();
            foreach ($uploadedFile as $submittedFile) {
                // Decode the JSON string (if applicable)
                $decodedFile = json_decode($submittedFile, true);

                if (isset($decodedFile['folder'])) {
                    $folder = $decodedFile['folder'];

                    // Log the folder name for debugging
                    \Log::info("Processing files from folder: {$folder}");

                    // Retrieve the temporary files from the database
                    $temporaryFile = TemporaryFile::where('folder', $folder)->first();

                    // Define the temporary file's path
                    $tempFilePath = storage_path("app/uploads/tmp/{$folder}/{$temporaryFile->filename}");

                    // Ensure the file exists before proceeding
                    if (file_exists($tempFilePath)) {
                        \Log::info("Processing file: {$tempFilePath}");
                        $file_name = $temporaryFile->filename;
                        $size = filesize($tempFilePath);
                        $type = mime_content_type($tempFilePath);

                        // Define the permanent storage path
                        $storedPath = "{$file_path}/{$file_name}";
                        Storage::put($storedPath, file_get_contents($tempFilePath));

                        // Save the file's metadata to the `attachments` table

                        $createdAttachment = UserSubmittedFile::create([
                            'file_name' => $file_name,
                            'size' => $size,
                            'type' => $type,
                            'file_path' => $storedPath,
                            'user_id' => $user->id,
                            'requirement_id' => $requirement_id,
                        ]);

                        // Optionally: Delete the temporary file after moving
                        unlink($tempFilePath);
                    } else {
                        \Log::error("File not found: {$tempFilePath}");
                    }

                    \Log::info("File processing complete: {$tempFilePath}");
                }

                // Optionally: Clean up the folder after processing
                Storage::deleteDirectory("uploads/tmp/{$folder}");
                TemporaryFile::where('folder', $folder)->delete();

                $files->push($createdAttachment);
            }

            // get all admin and super-admin users
            $users = User::role(['admin', 'super-admin'])->get();

            // notify all admin and super-admin users about the new uploaded file
            foreach ($users as $user) {
                $notifyAdmin = UserHasNotification::create([
                    'user_id' => $user->id,
                    'notification_id' => $requirement_id,
                    'read_at' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

        }

        return redirect()->route('user.requirements.show', $requirement_id)->with('success', 'Successfully uploaded files');
    }

    /**
     * Display the specified resource.
     */
    public function show(Requirement $requirement)
    {
        $user = Auth::user();

        $userUploadedFiles = UserSubmittedFile::where('requirement_id', $requirement->id)
        ->where('user_id', $user->id)
        ->get();

        // dd($userUploadedFiles);
        // dd($userUploadedFiles);
        return view('user.requirements.show', compact(
            'requirement',
            'user',
            'userUploadedFiles',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requirement $requirement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Requirement $requirement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requirement $requirement)
    {
        //
    }

    // ===== ===== ===== =====
}
