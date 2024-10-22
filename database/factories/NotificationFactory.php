<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\SyllabusRequirement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['info', 'warning', 'success', 'error']),
            'title' => fake()->realText(),
            'message' => fake()->sentences(5, true),
            'read' => fake()->boolean(50),
            'read_at' => function (array $attributes) {
                return $attributes['read'] ? $this->faker->dateTimeThisYear() : null;
            },
            'action_url' => $this->faker->optional()->url(),
            'user_id' => User::factory(),
            'sender_id' => User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
