<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdviserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Adviser::create([
            'first_name' => 'John',
            'middle_name' => 'A.',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'suffix' => null,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        \App\Models\Adviser::create([
            'first_name' => 'Jane',
            'middle_name' => 'B.',
            'last_name' => 'Smith',
            'email' => 'jane.smith@example.com',
            'suffix' => null,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        \App\Models\Adviser::create([
            'first_name' => 'Emily',
            'middle_name' => 'C.',
            'last_name' => 'Johnson',
            'email' => 'emily.johnson@example.com',
            'suffix' => null,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        \App\Models\Adviser::create([
            'first_name' => 'Michael',
            'middle_name' => 'D.',
            'last_name' => 'Williams',
            'email' => 'michael.williams@example.com',
            'suffix' => null,
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        \App\Models\Adviser::create([
            'first_name' => 'Sarah',
            'middle_name' => 'E.',
            'last_name' => 'Brown',
            'email' => 'sarah.brown@example.com',
            'suffix' => null,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
    }
}
