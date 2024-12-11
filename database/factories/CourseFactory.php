<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $courses = [
            ['code' => 'BSA', 'name' => 'Bachelor of Science in Agriculture', 'description' => 'This program focuses on agricultural sciences, including crop production, animal husbandry, and farm management.'],
            ['code' => 'BSF', 'name' => 'Bachelor of Science in Forestry', 'description' => 'A program that covers forest management, conservation, and ecosystem studies.'],
            ['code' => 'BSES', 'name' => 'Bachelor of Science in Environmental Science', 'description' => 'This course focuses on environmental issues, sustainability, and ecological principles.'],
            ['code' => 'BAC', 'name' => 'Bachelor of Arts in Communication', 'description' => 'A program aimed at developing communication skills across various media.'],
            ['code' => 'BAE', 'name' => 'Bachelor of Arts in English', 'description' => 'This program emphasizes English language and literature studies.'],
            ['code' => 'BSP', 'name' => 'Bachelor of Science in Psychology', 'description' => 'A course that explores human behavior and mental processes.'],
            ['code' => 'BSM', 'name' => 'Bachelor of Science in Mathematics', 'description' => 'This program focuses on mathematical theories and applications.'],
            ['code' => 'BSBA', 'name' => 'Bachelor of Science in Business Administration', 'description' => 'A comprehensive program in business management principles.'],
            ['code' => 'BSA', 'name' => 'Bachelor of Science in Accounting', 'description' => 'This course covers accounting principles and financial reporting.'],
            ['code' => 'BSHM', 'name' => 'Bachelor of Science in Hospitality Management', 'description' => 'A program focusing on the hospitality and service industry.'],
            ['code' => 'BSCpE', 'name' => 'Bachelor of Science in Computer Engineering', 'description' => 'This program combines computer science and electrical engineering.'],
            ['code' => 'BSIT', 'name' => 'Bachelor of Science in Information Technology', 'description' => 'A course focused on information systems and technology applications.'],
            ['code' => 'BSEE', 'name' => 'Bachelor of Science in Electrical Engineering', 'description' => 'This program covers electrical systems and circuit design.'],
            ['code' => 'BSCE', 'name' => 'Bachelor of Science in Civil Engineering', 'description' => 'A course that focuses on construction, design, and infrastructure management.'],
            ['code' => 'BEED', 'name' => 'Bachelor of Elementary Education', 'description' => 'A program preparing students to teach at the elementary level.'],
            ['code' => 'BSED', 'name' => 'Bachelor of Secondary Education', 'description' => 'This program prepares students for teaching at the secondary level.'],
            ['code' => 'BPEd', 'name' => 'Bachelor of Physical Education', 'description' => 'A course that focuses on physical fitness and education methodologies.'],
            ['code' => 'BSDM', 'name' => 'Bachelor of Science in Development Management', 'description' => 'A program that focuses on development policies and management practices.'],
            ['code' => 'BSAE', 'name' => 'Bachelor of Science in Agricultural Economics', 'description' => 'This course covers economic principles applied to agriculture.'],
        ];

        return fake()->randomElement($courses);
    }
}
