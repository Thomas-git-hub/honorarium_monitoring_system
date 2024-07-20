<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(){
        return view('index');
    }

    public function registration(){

        // $users = User::first();
        $cacheKey = 'ibu_test_employee_first';

        // Try to get the cached data
        $users = Cache::remember($cacheKey, 60, function() {
            // return DB::connection('pgsql')->table('employee')->first();
        });

        // dd($users);
        return view('registration');
    }


}
