<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThesisOutGoingController extends Controller
{
    public function showThesisOutGoing()
    {
        return view('administration.thesis_out_going');
    }
}
