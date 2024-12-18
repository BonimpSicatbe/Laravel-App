<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Requirement;
use App\Models\RequirementUser;
use App\Models\Task;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

        $requirementSubmittedFile = $user->requirementSubmittedFile;

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
}
