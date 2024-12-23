<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Position;
use App\Models\PositionUser;
use App\Models\Requirement;
use App\Models\Subject;
use App\Models\SubjectUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'account_number' => fake()->unique()->numerify('2024#####'),
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            'password' => bcrypt('password'), // default password for testing
            'email_verified_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (User $user) {
            // Create a PositionUser record after the User is created
            PositionUser::create([
                'user_id' => $user->id,
                'position_id' => Position::inRandomOrder()->first()->id,
            ]);

            CourseUser::create([
                'user_id' => $user->id,
                'course_id' => Course::inRandomOrder()->first()->id,
            ]);

            SubjectUser::create([
                'user_id' => $user->id,
                'subject_id' => Subject::inRandomOrder()->first()->id,
            ]);

            $requirement = Requirement::with(['course', 'subject', 'position'])->get();

            $user->assignRole('user');
        });
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
