<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            // College of Agriculture, Forestry, and Environmental Science
            ['name' => 'Bachelor of Science in Agriculture', 'code' => 'BSA'],
            ['name' => 'Bachelor of Science in Environmental Science', 'code' => 'BSES'],

            // College of Arts and Sciences
            ['name' => 'Bachelor of Arts in Communication', 'code' => 'BAC'],
            ['name' => 'Bachelor of Arts in English', 'code' => 'BAE'],
            ['name' => 'Bachelor of Science in Psychology', 'code' => 'BSP'],
            ['name' => 'Bachelor of Science in Mathematics', 'code' => 'BSM'],

            // College of Business and Management
            ['name' => 'Bachelor of Science in Business Administration', 'code' => 'BSBA'],
            ['name' => 'Bachelor of Science in Accounting', 'code' => 'BSA'],
            ['name' => 'Bachelor of Science in Hospitality Management', 'code' => 'BSHM'],

            // College of Engineering and Information Technology
            ['name' => 'Bachelor of Science in Computer Engineering', 'code' => 'BSCpE'],
            ['name' => 'Bachelor of Science in Information Technology', 'code' => 'BSIT'],
            ['name' => 'Bachelor of Science in Electrical Engineering', 'code' => 'BSEE'],
            ['name' => 'Bachelor of Science in Civil Engineering', 'code' => 'BSCE'],

            // College of Education
            ['name' => 'Bachelor of Elementary Education', 'code' => 'BEED'],
            ['name' => 'Bachelor of Secondary Education', 'code' => 'BSED'],
            ['name' => 'Bachelor of Physical Education', 'code' => 'BPEd'],

            // College of Economics, Management, and Development Studies
            ['name' => 'Bachelor of Science in Development Management', 'code' => 'BSDM'],
            ['name' => 'Bachelor of Science in Agricultural Economics', 'code' => 'BSAE'],

            // Graduate Programs
            ['name' => 'Master in Business Administration', 'code' => 'MBA'],
            ['name' => 'Master in Public Administration', 'code' => 'MPA'],
            ['name' => 'Master in Development Management', 'code' => 'MDM'],
        ];

        DB::table('courses')->insert($courses);
    }
}
