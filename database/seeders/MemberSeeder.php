<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::create([
            'first_name' => 'Jane',
            'middle_name' => 'Smith',
            'last_name' => 'Doe',
            'member_type' => 'Internal Member',
            'created_by' => 1, // Assuming admin user has ID 1
            'updated_by' => 1,
        ]);

        Member::create([
            'first_name' => 'Cloe',
            'middle_name' => 'Cullen',
            'last_name' => 'Armstrong',
            'member_type' => 'Internal Member',
            'created_by' => 1, // Assuming admin user has ID 1
            'updated_by' => 1,
        ]);

        Member::create([
            'first_name' => 'Anna',
            'middle_name' => 'Sy',
            'last_name' => 'Tan',
            'member_type' => 'Internal Member',
            'created_by' => 1, // Assuming admin user has ID 1
            'updated_by' => 1,
        ]);

        Member::create([
            'first_name' => 'Troy',
            'middle_name' => 'Pter',
            'last_name' => 'Tan',
            'member_type' => 'Internal Member',
            'created_by' => 1, // Assuming admin user has ID 1
            'updated_by' => 1,
        ]);
    }
}
