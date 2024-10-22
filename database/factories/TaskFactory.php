<?php

namespace Database\Factories;

use App\Models\Requirement;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
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
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['pending', 'in_progress', 'completed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'due_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'user_id' => User::factory(),  // Make sure to create a valid user
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
            'requirement_id' => Requirement::factory(), // Ensure requirement_id is assigned correctly
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Task $task) {
            \App\Models\Attachment::factory()->count(3)->create([
                'task_id' => $task->id,
            ]);
        });
    }
}
