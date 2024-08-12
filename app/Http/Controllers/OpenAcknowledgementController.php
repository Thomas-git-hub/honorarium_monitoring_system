<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OpenAcknowledgementController extends Controller
{
    public function open_acknowledgement(){
        return view('administration.open_acknowledgement');
    }

}
