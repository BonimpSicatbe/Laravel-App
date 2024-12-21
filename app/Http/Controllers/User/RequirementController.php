<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use App\Models\RequirementUser;
use App\Models\Task;
use App\Models\TemporaryFile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $validated = $request->validate([
            'userFileUpload' => 'nullable',
        ]);

        $uploadedFile = $validated['userFileUpload'];
        if($uploadedFile) {
            $file_path = "uploads/requirements/userSubmittedRequirementFiles/{$request->requirement->id}/";
            $files = collect();

            foreach ($uploadedFile as $file) {
                $decodedFile = json_decode($file, true);

                if (isset($decodedFile['folder'])) {
                    $folder = $decodedFile['folder'];

                }
            }
        }

        return redirect()->route('requirements.show', $request->requirement);
    }

    /**
     * Display the specified resource.
     */
    public function show(Requirement $requirement)
    {
        $user = Auth::user();

        $tasks = Task::with(['requirement', 'createdBy'])
            ->where('requirement_id', $requirement->id)
            ->get();

        return view('user.requirements.show', compact(
            'requirement',
            'tasks',
            'user',
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
