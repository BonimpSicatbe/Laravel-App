<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $positions = [
            ['name' => 'Deans', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Open Learning Center Coordinator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Extension Coordinator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Gad Coordinator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'QUAAC Coordinator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Guidance Coordinator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Department Chairperson', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'College Graduate Research Coordinator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'College Graduate Program Coordinator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Learning Center Coordinator', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('positions')->insert($positions);
    }
}
