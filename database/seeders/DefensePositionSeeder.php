<?php

namespace Database\Seeders;

use App\Models\Defense_Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefensePositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Defense_Position::create(
            [
                'position'=> 'Adviser',
                'created_by'=> 'Superadmin',

            ]
          );
        Defense_Position::create(
            [
                'position'=> 'Chairperson',
                'created_by'=> 'Superadmin',

            ]
          );
        Defense_Position::create(
            [
                'position'=> 'Member',
                'created_by'=> 'Superadmin',

            ]
          );
        Defense_Position::create(
            [
                'position'=> 'Recorder',
                'created_by'=> 'Superadmin',

            ]
          );
    }
}
