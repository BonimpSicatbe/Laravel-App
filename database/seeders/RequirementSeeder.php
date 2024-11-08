<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Position;
use App\Models\Requirement;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequirementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch users to assign as creators and updaters
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn("No users found, skipping requirements seeding.");
            return;
        }

        // Get data from related tables
        $courses = Course::pluck('id')->toArray();
        $subjects = Subject::pluck('id')->toArray();
        $positions = Position::pluck('id')->toArray();

        // Define possible `sent_to_type` values
        $types = ['course', 'subject', 'position'];

        // Create requirements with randomized data
        foreach (range(1, 10) as $i) {
            $sentToType = $types[array_rand($types)];
            $sentToId = null;

            // Select `sent_to_id` based on the `sent_to_type`
            switch ($sentToType) {
                case 'course':
                    $sentToId = $courses ? $courses[array_rand($courses)] : null;
                    break;
                case 'subject':
                    $sentToId = $subjects ? $subjects[array_rand($subjects)] : null;
                    break;
                case 'position':
                    $sentToId = $positions ? $positions[array_rand($positions)] : null;
                    break;
            }

            Requirement::create([
                'name' => 'Requirement ' . $i,
                'description' => 'Description for Requirement ' . $i,
                'sent_to_type' => $sentToType,
                'sent_to_id' => $sentToId,
                'due_date' => now()->addDays(rand(1, 30)),
                'status' => 'pending',
                'created_by' => $users->random()->id,
                'updated_by' => $users->random()->id,
            ]);
        }
    }
}
