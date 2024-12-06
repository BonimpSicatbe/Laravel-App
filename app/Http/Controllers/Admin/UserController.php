<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Notification;
use App\Models\Position;
use App\Models\PositionUser;
use App\Models\Subject;
use App\Models\SubjectUser;
use App\Models\User;
use App\Models\UserHasNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::with(['position', 'requirements', 'tasks', 'roles', 'permissions'])->get();

        $courses = Course::all();
        $subjects = Subject::all();
        $positions = Position::all();


//        dd($users);
        return view('admin.users.index', compact(
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
        $roles = Role::all();

//        dd($courses, $subjects, $positions);

        $user = Auth::user();

        return view('admin.users.create', compact(
            'courses',
            'subjects',
            'positions',
            'roles',
        ));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_number' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
            'position' => ['required', 'int', 'max:255'],
            'course' => ['required', 'int', 'max:255'],
            'subject' => ['required', 'int', 'max:255'],
        ]);

        // insert user to user table
        $user = User::create([
            'account_number' => $request->account_number,
            'name' => $request->name,
//            'role' => $request->role,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password
        ]);

        // assign user role
        $user->assignRole($request->role);

        // insert user and user's course into table course_user
        $courseUser = CourseUser::create(['user_id' => $user->id, 'course_id' => $request->course, 'created_at' => now(), 'updated_at' => now()]);
        $subjectUser = SubjectUser::create(['user_id' => $user->id, 'subject_id' => $request->subject, 'created_at' => now(), 'updated_at' => now()]);
        $positionUser = PositionUser::create(['user_id' => $user->id, 'position_id' => $request->position, 'created_at' => now(), 'updated_at' => now()]);

        $notifications = Notification::all();

        foreach ($notifications as $notification) {
            if ($courseUser->course === $notification->sent_to) {
                UserHasNotification::create([
                    'user_id' => $user->id,
                    'notification_id' => $notification->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($subjectUser->course === $notification->sent_to) {
                UserHasNotification::create([
                    'user_id' => $user->id,
                    'notification_id' => $notification->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if ($positionUser->course === $notification->sent_to) {
                UserHasNotification::create([
                    'user_id' => $user->id,
                    'notification_id' => $notification->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.users.create')->with('success', 'User created successfully and notifications has been sent.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $courses = $user->courses;
        $subjects = $user->subjects;

        dd($courses);

        return view('admin.users.show', compact(
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

        return view('admin.users.edit', compact([
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
            'account_number' => ['required', 'string', 'max:255', 'unique:' . User::class],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'role' => ['required', 'string', 'max:255'],
            'position' => ['required', 'int', 'max:255'],
        ]);

        $request->user()->save();

        return redirect()->route('admin.users.edit', $user->id)->with('success', 'User updated successfully');
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

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
