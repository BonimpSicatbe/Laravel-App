<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attachment>
 */
class AttachmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(3, true),
            'size' => fake()->randomNumber(),
            'type' => fake()->randomElement(['png', 'jpg', 'jpeg']),
            'task_id' => Task::factory(),
            'user_id' => User::factory(),
            'file_path' => 'attachments/' . fake()->unique()->lexify('file_?????.jpg'), // Fake file path
        ];
    }
}
