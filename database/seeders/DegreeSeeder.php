<?php

namespace Database\Seeders;

use App\Models\Degree;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Degree::create(
            [
                'name'=> 'Masteral',
                'created_by'=> 'Superadmin',

            ]
          );
        Degree::create(
            [
                'name'=> 'Doctoral',
                'created_by'=> 'Superadmin',

            ]
          );
    }
}
