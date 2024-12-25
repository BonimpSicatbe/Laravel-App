<?php

// TODO :: file validation, if file exist in storage, display files in the requirements.show

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
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
use App\Models\TemporaryFile;
use App\Models\User;
use App\Models\UserHasNotification;
use App\Notifications\RequirementAssignedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RequirementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Query Requirements with relationships
        $query = Requirement::with(['tasks', 'users']);

        // Filter by status if provided
        if ($request->has('sortStatus') && $request->sortStatus !== 'all') {
            $query->where('status', $request->sortStatus);
        }

        // Search by name or other fields if needed
        if ($request->has('search') && !empty($request->search)) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Get the filtered and paginated results
        $requirements = $query->paginate(10);

        // Fetch additional data
        $courses = Course::all();
        $subjects = Subject::all();
        $positions = Position::all();

        return view('admin.requirements.index', compact(
            'requirements',
            'courses',
            'subjects',
            'positions',
        ));
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
            'select_target_group' => 'nullable',
            'attachments' => 'nullable',
        ]);

        // Step 1: Determine 'sent_to_type' and 'sent_to_id'
        $select_group = $validatedData['select_group'] === 'all' ? 'all' : $validatedData['select_group'];
        $select_target_group = $validatedData['select_group'] === 'all' ? null : $validatedData['select_target_group'];

        \Log::info('Creating requirement.');
        // Step 2: Create the Requirement
        $requirement = Requirement::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
            'due_date' => $validatedData['due_date'],
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'sent_to_type' => $select_group,
            'sent_to_id' => $select_target_group,
        ]);

        \Log::info("Requirement {$requirement->name} created.");

        // Step 3: Fetch users based on the selected group
        // Initialize an empty collection of users
        $users = collect();
        switch ($select_group) {
            case 'course':
                $users = CourseUser::where('course_id', $select_target_group)->pluck('user_id');
                break;
            case 'subject':
                $users = SubjectUser::where('subject_id', $select_target_group)->pluck('user_id');
                break;
            case 'position':
                $users = PositionUser::where('position_id', $select_target_group)->pluck('user_id');
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
        switch ($select_group) {
            case 'course':
                $sentTo = Course::where('id', $select_target_group)->first();
                break;
            case 'subject':
                $sentTo = Subject::where('id', $select_target_group)->first();
                break;
            case 'position':
                $sentTo = Position::where('id', $select_target_group)->first();
                break;
            case 'all':
                $sentTo = 'all'; // Explicitly set as 'all'
                break;
        }

        // Step 5: Create the notification
        $notification = Notification::create([
            'notification_name' => "New Requirement Assigned.",
            'notification_description' => "{$requirement->created_by} created a new requirement.",
            'title' => $requirement->name,
            'message' => $requirement->description,
            'requirement_id' => $requirement->id,
            'sent_to' => $sentTo === 'all' ? 'all' : $sentTo->name,
            'created_by' => $requirement->created_by,
            'updated_by' => $requirement->updated_by,
        ]);

        // assign the notification for each user
        foreach ($users as $userId) {
            $requirementUser = RequirementUser::create(['requirement_id' => $requirement->id, 'user_id' => $userId, 'created_at' => now(), 'updated_at' => now()]);

            $userHasNotification = UserHasNotification::create([
                'notification_id' => $notification->id,
                'user_id' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        //
        $uploadedSyllabus = $validatedData['attachments'];
        if ($uploadedSyllabus) {
            $file_path = "uploads/requirements/syllabus/{$requirement->id}";

            $files = collect();
            foreach ($uploadedSyllabus as $syllabus) {
                // Decode the JSON string (if applicable)
                $decodedFile = json_decode($syllabus, true);

                if (isset($decodedFile['folder'])) {
                    $folder = $decodedFile['folder'];

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
                                'requirement_id' => $requirement->id,
                                'created_at' => now(),
                                'updated_at' => now(),
                                'created_by' => $user->id,
                                'updated_by' => $user->id,
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
                $files->push($decodedFile);
            }

            // Debug output for validation
            \Log::info('Attachments successfully processed:', $files->toArray());
        }

//        dd($request->all());

        // Step 7: Redirect to Task Creation page
        return redirect()->route('admin.requirements.index')
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
        DB::beginTransaction();
        
        try {
            // Check if any dependencies exist (like related tasks, users, etc.)
            $requirement->notifications()->delete();  // Deleting notifications linked to the requirement
            $requirement->users()->detach();  // Detach users linked to the requirement
            
            // Delete the requirement itself
            $requirement->delete();
            
            // Commit transaction if everything is successful
            DB::commit();

            return redirect()->route('admin.requirements.index')->with('success', 'Requirement and associated tasks deleted successfully.');
        } catch (Exception $e) {
            // Rollback in case of any errors
            DB::rollBack();
            return redirect()->route('admin.requirements.index')->with('error', 'Failed to delete requirement.');
        }
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

    public function getGroupData(Request $request)
    {
        $type = $request->query('type');
        $data = [];

        if ($type === 'course') {
            $data = Course::select('id', 'name')->get();
        } elseif ($type === 'subject') {
            $data = Subject::select('id', 'name')->get();
        } elseif ($type === 'position') {
            $data = Position::select('id', 'name')->get();
        }

        return response()->json($data);
    }
}


