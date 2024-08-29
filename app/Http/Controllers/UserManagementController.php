<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function user_management(){

        return view('administration.user_management');
    }
}
