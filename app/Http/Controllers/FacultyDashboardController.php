<?php

namespace App\Http\Controllers;

use App\Models\Emailing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FacultyDashboardController extends Controller
{
    public function faculty_dashboard(){
        if(Auth::user()->usertype->name === 'Faculty'){

            $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
            $EmailCount = $pendingMails->count();

            return view('administration.faculty_dashboard', compact('EmailCount'));
        }else{
            abort(403, 'Unauthorized action.');
        }
    }
}
