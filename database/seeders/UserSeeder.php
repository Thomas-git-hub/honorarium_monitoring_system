<?php

namespace Database\Seeders;

use App\Models\Office;
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
            'usertype_id' => UserType::where('name', 'Superadmin')->first()->id,
            'office_id' =>  Office::where('name', 'ICTO')->first()->id,
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
            'usertype_id' => UserType::where('name', 'Administrator')->first()->id,
            'office_id' => Office::where('name', 'BUGS Administration')->first()->id,
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
            'usertype_id' => UserType::where('name', 'Budget Office')->first()->id,
            'office_id' => Office::where('name', 'Budget Office')->first()->id,
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
            'usertype_id' => UserType::where('name', 'Dean')->first()->id,
            'office_id' => Office::where('name', 'Dean')->first()->id,
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
            'usertype_id' => UserType::where('name', 'Accounting')->first()->id,
            'office_id' => Office::where('name', 'Accounting')->first()->id,
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
            'usertype_id' => UserType::where('name', 'Cashiers')->first()->id,
            'office_id' => Office::where('name', 'Cashiers')->first()->id,
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
            'usertype_id' => UserType::where('name', 'Faculty')->first()->id,
            'office_id' => Office::where('name', 'Faculty')->first()->id,
            'status' => 'Active',
            'password' => Hash::make('123456'),
        ]);
    }
}
