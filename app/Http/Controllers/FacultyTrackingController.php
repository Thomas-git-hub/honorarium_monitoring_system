<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacultyTrackingController extends Controller
{
    public function faculty_tracking(){

        return view('administration.faculty_tracking');
    }
}
