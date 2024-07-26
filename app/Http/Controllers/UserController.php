<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

        return view('index');
    }

    public function registration(){

        // $users = User::first();
        // $cacheKey = 'ibu_test_employee_first';

        // // Try to get the cached data
        // $users = Cache::remember($cacheKey, 60, function() {
        //     return DB::connection('ibu_test')->table('employee')->first();
        // });

        // dd($users);
        return view('registration');
    }

    public function login(Request $request){
        // $request->validate([
        //     'email' => 'required|email',
        //     'password' => 'required',
        // ]);

        // $user = DB::connection('ibu_test')->table('employee_user')->where('email', $request->email)->first();

        // if ($user) {
        //     $credentials = $request->only('email', 'password');
        //     $remember = $request->has('remember');
        //     if (auth()->attempt($credentials)) {
        //         return response()->json(['success' => true, 'message' => 'true']);
        //     } else {
        //         return response()->json(['success' => false, 'message' => 'Invalid Credentials']);
        //     }
        // } else {
        //     return response()->json(['success' => false, 'message' => 'User Not Found']);
        // }
    }


}
