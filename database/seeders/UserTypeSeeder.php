<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserType::create(
            [
                'name'=> 'Superadmin',
                'created_by'=> 'Superadmin',

            ]
          );
          UserType::create(
            [
                'name'=> 'Administrator',
                'created_by'=> 'Superadmin',

            ]
          );
          UserType::create(
            [
                'name'=> 'Budget Office',
                'created_by'=> 'Superadmin',

            ]
          );
          UserType::create(
            [
                'name'=> 'Dean',
                'created_by'=> 'Superadmin',

            ]
          );
          UserType::create(
            [
                'name'=> 'Accounting',
                'created_by'=> 'Superadmin',

            ]
          );
          UserType::create(
            [
                'name'=> 'Cashiers',
                'created_by'=> 'Superadmin',

            ]
          );
        UserType::create(
            [
                'name'=> 'Faculty',
                'created_by'=> 'Superadmin',

            ]
          );



    }
}
