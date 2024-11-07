<?php

namespace Database\Seeders;

use App\Models\Defense;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Defense::create(
            [
                'name'=> 'Proposal',
                'created_by'=> 'Superadmin',

            ]
          );
        Defense::create(
            [
                'name'=> 'Pre-Oral',
                'created_by'=> 'Superadmin',

            ]
          );
        Defense::create(
            [
                'name'=> 'Final',
                'created_by'=> 'Superadmin',

            ]
          );
    }
}
