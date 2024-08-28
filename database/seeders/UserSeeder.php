<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'employee_id' => '0',
            'first_name' => 'John',
            'middle_name' => 'Smith',
            'last_name' => 'Doe',
            'suffix' => '',
            'contact' => '09123456789',
            'email' => 'johndoe@gmail.com',
            'ee_number' => '2024-7-0700',
            'college_id' => '0',
            'usertype_id' => '7',
            'office_id' => '1',
            'status' => 'Active',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'employee_id' => '1',
            'first_name' => 'Emily',
            'middle_name' => 'Grace',
            'last_name' => 'Davis',
            'suffix' => '',
            'contact' => '09123456789',
            'email' => 'emilygrace@gmail.com',
            'ee_number' => '2024-2-0700',
            'college_id' => '0',
            'usertype_id' => '2',
            'office_id' => '1',
            'status' => 'Active',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'employee_id' => '3',
            'first_name' => 'Sarah',
            'middle_name' => 'Elizabeth',
            'last_name' => 'Brown',
            'suffix' => '',
            'contact' => '09123456789',
            'email' => 'sarahelizabeth@gmail.com',
            'ee_number' => '2024-3-0700',
            'college_id' => '0',
            'usertype_id' => '3',
            'office_id' => '2',
            'status' => 'Active',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'employee_id' => '4',
            'first_name' => 'James',
            'middle_name' => 'Alexander',
            'last_name' => 'wilson',
            'suffix' => '',
            'contact' => '09123456789',
            'email' => 'jamesalexander@gmail.com',
            'ee_number' => '2024-4-0700',
            'college_id' => '0',
            'usertype_id' => '4',
            'office_id' => '4',
            'status' => 'Active',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'employee_id' => '5',
            'first_name' => 'Laura',
            'middle_name' => 'Marie',
            'last_name' => 'Taylor',
            'suffix' => '',
            'contact' => '09123456789',
            'email' => 'lauramarie@gmail.com',
            'ee_number' => '2024-5-0700',
            'college_id' => '0',
            'usertype_id' => '5',
            'office_id' => '3',
            'status' => 'Active',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'employee_id' => '6',
            'first_name' => 'David',
            'middle_name' => 'William',
            'last_name' => 'Anderson',
            'suffix' => '',
            'contact' => '09123456789',
            'email' => 'davidwilliam@gmail.com',
            'ee_number' => '2024-6-0700',
            'college_id' => '0',
            'usertype_id' => '6',
            'office_id' => '5',
            'status' => 'Active',
            'password' => Hash::make('123456'),
        ]);

        User::create([
            'employee_id' => '1',
            'first_name' => 'Emma',
            'middle_name' => 'Louise',
            'last_name' => 'Moore',
            'suffix' => '',
            'contact' => '09123456789',
            'email' => 'emmalouise@gmail.com',
            'ee_number' => '2024-1-0700',
            'college_id' => '0',
            'usertype_id' => '1',
            'office_id' => '6',
            'status' => 'Active',
            'password' => Hash::make('123456'),
        ]);
    }
}
