<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function history(){
        return view('administration.history');
    }

    public function open_history(){
        return view('administration.open_history');
    }
}
