<?php

namespace Database\Factories;

use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PositionUser>
 */
class PositionUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
//            'user_id' => User::inRandomOrder()->first()->id, // Get a random user ID
            'position_id' => Position::inRandomOrder()->first()->id, // Get a random position ID
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
