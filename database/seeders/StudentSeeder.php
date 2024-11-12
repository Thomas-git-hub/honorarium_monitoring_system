<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        Student::create([
            'first_name' => 'Jane',
            'middle_name' => 'Smith',
            'last_name' => 'Doe',
            'created_by' => 1, // Assuming admin user has ID 1
            'updated_by' => 1,
        ]);

        Student::create([
            'first_name' => 'Cloe',
            'middle_name' => 'Cullen',
            'last_name' => 'Armstrong',
            'created_by' => 1, // Assuming admin user has ID 1
            'updated_by' => 1,
        ]);

        Student::create([
            'first_name' => 'Anna',
            'middle_name' => 'Sy',
            'last_name' => 'Tan',
            'created_by' => 1, // Assuming admin user has ID 1
            'updated_by' => 1,
        ]);
    }
}
