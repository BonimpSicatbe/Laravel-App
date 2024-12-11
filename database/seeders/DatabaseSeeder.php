<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseUser;
use App\Models\File;
use App\Models\Folder;
use App\Models\Notification;
use App\Models\Position;
use App\Models\PositionUser;
use App\Models\Requirement;
use App\Models\RequirementUser;
use App\Models\SubjectUser;
use App\Models\Task;
use App\Models\TaskUser;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public function run(): void
    {
        $this->call([
            PositionSeeder::class,
            SubjectSeeder::class,
            CourseSeeder::class,
        ]);

        // Create roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']); // Renamed this variable to avoid conflict

        // Create admin user and assign super-admin role
        $superAdminUser = User::create([
            'account_number' => '202104361',
            'name' => 'Doming Ricalde',
            'email' => 'domingricalde@gmail.com',
            'password' => bcrypt('domingricalde'),
            'email_verified_at' => now(),
        ]);

        $superAdminUser->assignRole('super-admin'); // Assign the super-admin role to the admin user

        PositionUser::create(['user_id' => $superAdminUser->id, 'position_id' => 1]);
        CourseUser::create(['user_id' => $superAdminUser->id, 'course_id' => 1]);
        SubjectUser::create(['user_id' => $superAdminUser->id, 'subject_id' => 1]);

        $adminUser = User::create([
            'account_number' => '202104361',
            'name' => 'Bonimp Sicatbe',
            'email' => 'bonimpsicatbe@gmail.com',
            'password' => bcrypt('bonimpsicatbe'),
            'email_verified_at' => now(),
        ]);

        $adminUser->assignRole('admin');

        PositionUser::create(['user_id' => $adminUser->id, 'position_id' => 1]);
        CourseUser::create(['user_id' => $adminUser->id, 'course_id' => 1]);
        SubjectUser::create(['user_id' => $adminUser->id, 'subject_id' => 1]);

        // Create a regular user and assign user role
        $regularUser = User::create([
            'account_number' => '202104362',
            'name' => 'User Account',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $regularUser->assignRole('user'); // Assign the user role to the regular user

        PositionUser::create(['user_id' => $regularUser->id, 'position_id' => 1]);
        CourseUser::create(['user_id' => $regularUser->id, 'course_id' => 1]);
        SubjectUser::create(['user_id' => $regularUser->id, 'subject_id' => 1]);

        User::factory()->count(50)->create();
    }

}
