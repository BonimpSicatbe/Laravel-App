<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Position;
use App\Models\PositionUser;
use App\Models\Subject;
use App\Models\SubjectUser;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(25);

        $courses = Course::all();
        $subjects = Subject::all();
        $positions = Position::all();

        return view('users.index', compact(
            'users',
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

        return view('users.create', compact('courses', 'subjects', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_number' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed'],
            'role' => ['required', 'string', 'max:255'],
            'position' => ['required', 'int', 'max:255'],
            'course' => ['required', 'int', 'max:255'],
            'subject' => ['required', 'int', 'max:255'],
        ]);

        // insert user to user table
        $user = User::create([
            'account_number' => $request->account_number,
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password
        ]);

        // insert user and user's course into table course_user
        DB::table('course_users')->insert([
            'user_id' => $user->id,
            'course_id' => $request->course
        ]);

        // insert user and user's subject into table subject_user
        DB::table('subject_users')->insert([
            'user_id' => $user->id,
            'subject_id' => $request->course
        ]);

        // insert user and user's position into table position_user
        DB::table('position_users')->insert([
            'user_id' => $user->id,
            'position_id' => $request->course
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $courses = $user->courses;
        $subjects = $user->subjects;

//        dd($courses);
        return view('users.show', compact(
            'user',
        'courses',
        'subjects',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $courses = $user->courses;
        $subjects = $user->subjects;

        return view('users.edit', compact([
            'user',
        'courses',
        'subjects',
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'account_number' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'role' => ['required', 'string', 'max:255'],
            'position' => ['required', 'int', 'max:255'],
        ]);

        $request->user()->save();

        return redirect()->route('users.edit', $user->id)->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->positionUser()->delete();
        $user->requirementUsers()->delete();
        $user->subjectUsers()->delete();
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }
}
