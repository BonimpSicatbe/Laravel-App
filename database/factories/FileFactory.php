<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Folder;
use App\Models\Requirement;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    protected $model = File::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileName = $this->faker->word() . '.' . $this->faker->fileExtension();
        return [
            'name' => $fileName,
            'path' => $fileName,
            'user_id' => 1,  // User is created at the seeder level
            'requirement_id' => 1, // Ensure requirement_id is assigned
            'task_id' => 1,  // Ensure task_id is assigned
            'folder_id' => 1,  // Ensure folder_id is assigned
            'mime_type' => $this->faker->mimeType(),
            'size' => $this->faker->numberBetween(1000, 5000), // File size in bytes
        ];
    }

}
