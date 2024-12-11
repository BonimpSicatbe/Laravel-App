<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Requirement>
 */
class RequirementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->realText(25),
            'description' => fake()->sentence(),
            'due_date' => fake()->dateTimeBetween('now', '+1 year'),
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed']),
            'sent_to' => fake()->randomElement(User::all()->pluck('id')->toArray()),
            'user_id' => User::factory(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
        ];
    }
}
