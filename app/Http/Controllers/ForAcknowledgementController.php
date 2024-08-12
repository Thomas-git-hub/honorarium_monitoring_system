<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ForAcknowledgementController extends Controller
{
    public function for_acknowledgement(){
        return view('administration.for_acknowledgement');
    }
}
