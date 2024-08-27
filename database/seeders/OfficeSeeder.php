<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Office::create(
            [
                'name'=> 'BUGS Administration',
                'created_by'=> 'Superadmin',

            ]
          );
          Office::create(
            [
                'name'=> 'Budget Office',
                'created_by'=> 'Superadmin',

            ]
          );

          Office::create(
            [
                'name'=> 'Accounting',
                'created_by'=> 'Superadmin',

            ]
          );
          Office::create(
            [
                'name'=> 'Dean',
                'created_by'=> 'Superadmin',

            ]
          );
          Office::create(
            [
                'name'=> 'Cashiers',
                'created_by'=> 'Superadmin',

            ]
          );
          Office::create(
            [
                'name'=> 'Faculty',
                'created_by'=> 'Superadmin',

            ]
          );

    }
}
