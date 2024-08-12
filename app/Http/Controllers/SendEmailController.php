<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    public function sendEmail(Request $request){
        // dd($request);
        return view('administration.send_email');
    }
}
