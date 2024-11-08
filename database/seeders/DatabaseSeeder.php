<?php

namespace Database\Seeders;

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
        $adminUser = User::create([
            'account_number' => '202104361',
            'name' => 'Doming Ricalde',
            'email' => 'domingricalde@gmail.com',
            'password' => bcrypt('domingricalde'),
            'email_verified_at' => now(),
        ]);

        $adminUser->assignRole('super-admin'); // Assign the super-admin role to the admin user

        // Create a position for the admin user
        PositionUser::create([
            'user_id' => $adminUser->id, // Use the actual ID of the created admin user
            'position_id' => 1,
        ]);

        // Create a regular user and assign user role
        $regularUser = User::create([
            'account_number' => '202104362',
            'name' => 'User Account',
            'email' => 'user@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        $regularUser->assignRole('user'); // Assign the user role to the regular user
    }

}
