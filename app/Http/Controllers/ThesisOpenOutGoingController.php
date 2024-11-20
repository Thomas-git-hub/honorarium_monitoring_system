<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThesisOpenOutGoingController extends Controller
{
    public function showThesisOpenOutGoing()
    {
        return view('administration.thesis_open_out_going');
    }
}
