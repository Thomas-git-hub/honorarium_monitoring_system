<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacultyDashboardController extends Controller
{
    public function faculty_dashboard(){

        return view('administration.faculty_dashboard');
    }
}
