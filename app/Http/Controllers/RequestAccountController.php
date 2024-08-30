<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RequestAccountController extends Controller
{
    public function request_account(){

        return view('administration.request_account');
    }
}
