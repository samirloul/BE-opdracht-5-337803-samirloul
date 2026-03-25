<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('enrollments')->truncate();
        DB::table('students')->truncate();
        DB::table('courses')->truncate();

        DB::table('students')->insert([
            ['student_number' => 'S1001', 'name' => 'Anna Jansen', 'email' => 'anna@example.com', 'created_at' => now(), 'updated_at' => now()],
            ['student_number' => 'S1002', 'name' => 'Bilal Ahmed', 'email' => 'bilal@example.com', 'created_at' => now(), 'updated_at' => now()],
            ['student_number' => 'S1003', 'name' => 'Chantal de Vries', 'email' => 'chantal@example.com', 'created_at' => now(), 'updated_at' => now()],
            ['student_number' => 'S1004', 'name' => 'Daan Smits', 'email' => 'daan@example.com', 'created_at' => now(), 'updated_at' => now()],
            ['student_number' => 'S1005', 'name' => 'Esmee Bakker', 'email' => 'esmee@example.com', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('courses')->insert([
            ['code' => 'SQL101', 'title' => 'SQL Basics', 'credits' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'WEB210', 'title' => 'Web Development', 'credits' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'DB305', 'title' => 'Data Modeling', 'credits' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['code' => 'LAR420', 'title' => 'Laravel Advanced', 'credits' => 5, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('enrollments')->insert([
            ['student_id' => 1, 'course_id' => 1, 'grade' => 8.2, 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => 1, 'course_id' => 2, 'grade' => 7.8, 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => 2, 'course_id' => 1, 'grade' => 6.9, 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => 3, 'course_id' => 3, 'grade' => 9.1, 'created_at' => now(), 'updated_at' => now()],
            ['student_id' => 4, 'course_id' => 2, 'grade' => 5.8, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
