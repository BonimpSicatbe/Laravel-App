<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'AGA 101 - Introduction to Agriculture', 'code' => 'AGA 101'],
            ['name' => 'AGA 102 - Soil Science', 'code' => 'AGA 102'],
            ['name' => 'Bachelor of Science in Forestry', 'code' => 'BSF'],
            ['name' => 'FOR 101 - Introduction to Forestry', 'code' => 'FOR 101'],
            ['name' => 'FOR 102 - Dendrology', 'code' => 'FOR 102'],
            ['name' => 'ENS 101 - Environmental Science', 'code' => 'ENS 101'],
            ['name' => 'ENS 102 - Ecology', 'code' => 'ENS 102'],
            ['name' => 'COM 101 - Introduction to Communication', 'code' => 'COM 101'],
            ['name' => 'COM 102 - Media Studies', 'code' => 'COM 102'],
            ['name' => 'ENG 101 - English Composition', 'code' => 'ENG 101'],
            ['name' => 'ENG 102 - World Literature', 'code' => 'ENG 102'],
            ['name' => 'PSY 101 - General Psychology', 'code' => 'PSY 101'],
            ['name' => 'PSY 102 - Developmental Psychology', 'code' => 'PSY 102'],
            ['name' => 'MAT 101 - College Algebra', 'code' => 'MAT 101'],
            ['name' => 'MAT 102 - Calculus I', 'code' => 'MAT 102'],
            ['name' => 'BA 101 - Principles of Management', 'code' => 'BA 101'],
            ['name' => 'BA 102 - Marketing Management', 'code' => 'BA 102'],
            ['name' => 'AC 101 - Financial Accounting', 'code' => 'AC 101'],
            ['name' => 'AC 102 - Managerial Accounting', 'code' => 'AC 102'],
            ['name' => 'HM 101 - Introduction to Hospitality', 'code' => 'HM 101'],
            ['name' => 'HM 102 - Food and Beverage Management', 'code' => 'HM 102'],
            ['name' => 'CP 101 - Introduction to Computer Engineering', 'code' => 'CP 101'],
            ['name' => 'CP 102 - Digital Logic Design', 'code' => 'CP 102'],
            ['name' => 'IT 101 - Computer Fundamentals', 'code' => 'IT 101'],
            ['name' => 'IT 102 - Programming Fundamentals', 'code' => 'IT 102'],
            ['name' => 'EE 101 - Circuit Theory', 'code' => 'EE 101'],
            ['name' => 'EE 102 - Electronics', 'code' => 'EE 102'],
            ['name' => 'CE 101 - Engineering Mechanics', 'code' => 'CE 101'],
            ['name' => 'CE 102 - Structural Analysis', 'code' => 'CE 102'],
            ['name' => 'EED 101 - Child Development', 'code' => 'EED 101'],
            ['name' => 'EED 102 - Curriculum Development', 'code' => 'EED 102'],
            ['name' => 'BSED 101 - Educational Psychology', 'code' => 'BSED 101'],
            ['name' => 'BSED 102 - Methods of Teaching', 'code' => 'BSED 102'],
            ['name' => 'PE 101 - Foundations of Physical Education', 'code' => 'PE 101'],
            ['name' => 'PE 102 - Health and Fitness', 'code' => 'PE 102'],
            ['name' => 'DM 101 - Introduction to Development Studies', 'code' => 'DM 101'],
            ['name' => 'DM 102 - Project Management', 'code' => 'DM 102'],
            ['name' => 'AE 101 - Principles of Agricultural Economics', 'code' => 'AE 101'],
            ['name' => 'AE 102 - Farm Management', 'code' => 'AE 102'],
            ['name' => 'MBA 101 - Management Theories', 'code' => 'MBA 101'],
            ['name' => 'MBA 102 - Strategic Management', 'code' => 'MBA 102'],
            ['name' => 'MPA 101 - Public Policy Analysis', 'code' => 'MPA 101'],
            ['name' => 'MPA 102 - Administrative Law', 'code' => 'MPA 102'],
            ['name' => 'MDM 101 - Development Planning', 'code' => 'MDM 101'],
            ['name' => 'MDM 102 - Project Evaluation', 'code' => 'MDM 102'],
        ];

        DB::table('subjects')->insert($subjects);
    }
}
