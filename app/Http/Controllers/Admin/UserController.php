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
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource with search and filters.
     */
    public function index(Request $request)
    {
        // Query Users with relationships
        $query = User::with(['position', 'roles', 'permissions', 'courses', 'subjects', 'requirements', 'tasks']); // Eager load relationships

        // Apply search filters
        if ($request->filled('role') && $request->role !== 'all') {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        // Search by name
        if ($request->filled('searchName')) {
            $searchKeywords = explode(' ', $request->searchName);
            $query->where(function ($q) use ($searchKeywords) {
                foreach ($searchKeywords as $keyword) {
                    $q->orWhere('name', 'like', '%' . $keyword . '%');
                }
            });
        }

        // Search by email
        if ($request->filled('searchEmail')) {
            $searchKeywords = explode(' ', $request->searchEmail);
            $query->where(function ($q) use ($searchKeywords) {
                foreach ($searchKeywords as $keyword) {
                    $q->orWhere('email', 'like', '%' . $keyword . '%');
                }
            });
        }

        // Paginate results
        $users = $query->paginate(10);

        $courses = Course::all();
        $subjects = Subject::all();
        $positions = Position::all();

        return view('admin.users.index', compact('users', 'courses', 'subjects', 'positions'));
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

        return view('admin.users.create', compact('courses', 'subjects', 'positions', 'roles'));
    }

    /**
     * Store a newly created user in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'account_number' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'exists:roles,name'],
            'position' => ['required', 'integer', 'exists:positions,id'],
            'course' => ['required', 'integer', 'exists:courses,id'],
            'subject' => ['required', 'integer', 'exists:subjects,id'],
        ]);

        // Create a new user
        $user = User::create([
            'account_number' => $request->account_number,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Assign role to the user
        $user->assignRole($request->role);

        // Attach relationships
        CourseUser::create(['user_id' => $user->id, 'course_id' => $request->course]);
        SubjectUser::create(['user_id' => $user->id, 'subject_id' => $request->subject]);
        PositionUser::create(['user_id' => $user->id, 'position_id' => $request->position]);

        // Assign notifications if applicable
        $notifications = Notification::whereIn('sent_to', [$request->course, $request->subject, $request->position])->get();

        foreach ($notifications as $notification) {
            UserHasNotification::create([
                'user_id' => $user->id,
                'notification_id' => $notification->id,
            ]);
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing a user.
     */
    public function edit(User $user)
    {
        $courses = Course::all();
        $subjects = Subject::all();
        $positions = Position::all();
        $roles = Role::all();

        return view('admin.users.edit', compact('user', 'courses', 'subjects', 'positions', 'roles'));
    }

    /**
     * Update the specified user in the database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'account_number' => ['required', 'string', 'max:255', 'unique:users,account_number,' . $user->id],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'exists:roles,name'],
            'position' => ['required', 'integer', 'exists:positions,id'],
        ]);

        // Update user details
        $user->update([
            'account_number' => $request->account_number,
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Sync role and relationships
        $user->syncRoles([$request->role]);
        $user->courses()->sync([$request->course]);
        $user->subjects()->sync([$request->subject]);
        $user->positions()->sync([$request->position]);

        return redirect()->route('admin.users.edit', $user->id)->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from the database.
     */
    public function destroy(User $user)
    {
        // Detach related data
        $user->courses()->detach();
        $user->subjects()->detach();
        $user->positions()->detach();

        // Delete the user
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
