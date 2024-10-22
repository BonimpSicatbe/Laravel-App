<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Folder;
use App\Models\Notification;
use App\Models\Requirement;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        User::create([
            'account_number' => '202104361',
            'name' => 'Doming Ricalde',
//            'role' => 'admin',
            'is_admin' => 1,
            'position' => 'deans',
            'email' => 'domingricalde@gmail.com',
            'password' => bcrypt('domingricalde'),
            'email_verified_at' => now(),
        ]);
    }

//    public function run(): void
//    {
//        // Create the specific user
//        $specificUser = User::factory()->create([
//            'account_number' => '202104361',
//            'name' => 'Doming Ricalde',
//            'role' => 'admin',
//            'position' => 'deans',
//            'email' => 'domingricalde@gmail.com',
//            'password' => bcrypt('domingricalde'),
//            'email_verified_at' => now(),
//        ]);
//
//        // Create other users
//        $otherUsers = User::factory()->count(5)->create();
//
//        // Create Requirements, Tasks, Folders, and Files for each user
//        $otherUsers->each(function (User $user) use ($otherUsers) {
//            $requirements = Requirement::factory()->count(3)->create([
//                'created_by' => $user->id,
//                'updated_by' => $user->id,
//                'user_id' => $user->id,
//            ]);
//
//            $requirements->each(function (Requirement $requirement) use ($user) {
//                $tasks = Task::factory()->count(3)->create([
//                    'requirement_id' => $requirement->id,
//                    'user_id' => $user->id,
//                    'created_by' => $user->id,
//                    'updated_by' => $user->id,
//                ]);
//
//                $tasks->each(function (Task $task) use ($user) {
//                    $folders = Folder::factory()->count(3)->create([
//                        'task_id' => $task->id,
//                        'user_id' => $user->id,
//                        'requirement_id' => $task->requirement_id, // Ensure requirement_id is passed
//                    ]);
//
//                    // Create Files for each folder
//                    $folders->each(function (Folder $folder) use ($user) {
//                        File::factory()->count(3)->create([
//                            'folder_id' => $folder->id,
//                            'task_id' => $folder->task_id, // Pass task_id from the folder
//                            'requirement_id' => $folder->requirement_id, // Pass requirement_id from the folder
//                            'user_id' => $user->id,
//                        ]);
//                    });
//
//                    // Create Files directly for the Task
//                    File::factory()->count(3)->create([
//                        'task_id' => $task->id,
//                        'requirement_id' => $task->requirement_id, // Ensure requirement_id is passed from the task
//                        'user_id' => $user->id,
//                    ]);
//                });
//
//                // Create Files directly for the Requirement
//                File::factory()->count(3)->create([
//                    'requirement_id' => $requirement->id,
//                    'user_id' => $user->id,
//                ]);
//            });
//
//            // Create Notifications for each user
//            Notification::factory()->count(5)->create([
//                'user_id' => $user->id,
//                'sender_id' => $otherUsers->where('id', '!=', $user->id)->random()->id, // Random different user as sender
//            ]);
//        });
//
//        // Create Requirements, Tasks, Folders, and Files for the specific user
//        $requirements = Requirement::factory()->count(3)->create([
//            'created_by' => $specificUser->id,
//            'updated_by' => $specificUser->id,
//            'user_id' => $specificUser->id,
//        ]);
//
//        $requirements->each(function (Requirement $requirement) use ($specificUser) {
//            $tasks = Task::factory()->count(3)->create([
//                'requirement_id' => $requirement->id,
//                'user_id' => $specificUser->id,
//                'created_by' => $specificUser->id,
//                'updated_by' => $specificUser->id,
//            ]);
//
//            $tasks->each(function (Task $task) use ($specificUser) {
//                $folders = Folder::factory()->count(3)->create([
//                    'task_id' => $task->id,
//                    'user_id' => $specificUser->id,
//                    'requirement_id' => $task->requirement_id, // Ensure requirement_id is passed
//                ]);
//
//                $folders->each(function (Folder $folder) use ($specificUser) {
//                    File::factory()->count(3)->create([
//                        'folder_id' => $folder->id,
//                        'task_id' => $folder->task_id, // Pass task_id from the folder
//                        'requirement_id' => $folder->requirement_id, // Pass requirement_id from the folder
//                        'user_id' => $specificUser->id,
//                    ]);
//                });
//
//                // Create Files directly for the Task
//                File::factory()->count(3)->create([
//                    'task_id' => $task->id,
//                    'requirement_id' => $task->requirement_id, // Ensure requirement_id is passed from the task
//                    'user_id' => $specificUser->id,
//                ]);
//            });
//
//            File::factory()->count(3)->create([
//                'requirement_id' => $requirement->id,
//                'user_id' => $specificUser->id,
//            ]);
//        });
//
//        // Create Notifications for the specific user
//        Notification::factory()->count(5)->create([
//            'user_id' => $specificUser->id,
//            'sender_id' => $otherUsers->random()->id, // Random different user as sender
//        ]);
//    }


}
