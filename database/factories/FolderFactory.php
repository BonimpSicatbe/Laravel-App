<?php

namespace Database\Factories;

use App\Models\Requirement;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Folder>
 */
class FolderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'size' => $this->faker->randomDigit(),
            'user_id' => User::factory(),
            'task_id' => Task::factory(),  // Ensure task_id is assigned
            'requirement_id' => Requirement::factory(),  // Ensure requirement_id is assigned
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

}
