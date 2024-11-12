<?php

namespace Database\Seeders;

use App\Models\Recorder;
use Illuminate\Database\Seeder;

class RecorderSeeder extends Seeder
{
    public function run()
    {
        $recorders = [
            [
                'first_name' => 'John',
                'middle_name' => 'D.',
                'last_name' => 'Smith',
                'status' => 'Active',
                'created_by' => 1, // Assuming admin user has ID 1
                'updated_by' => 1,
            ],
            // Add more sample recorders as needed
        ];

        foreach ($recorders as $recorder) {
            Recorder::create($recorder);
        }
    }
} 