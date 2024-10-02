<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacultyDashboardController extends Controller
{
    public function faculty_dashboard(){
        if(Auth::user()->usertype->name === 'Faculties'){

            return view('administration.faculty_dashboard');
        }else{
            abort(403, 'Unauthorized action.');
        }
    }
}
