<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function admin_dashboard(){
        return view('administration.admin_dashboard');
    }

    public function admin_email(){
        return view('administration.admin_email');
    }

    public function admin_open_email(){
        return view('administration.admin_open_email');
    }

    public function admin_faculty(){
        return view('administration.admin_faculty');
    }

    public function admin_view_faculty(){
        return view('administration.admin_view_faculty');
    }

    public function admin_honorarium(){
        return view('administration.admin_honorarium');
    }

    public function admin_new_entries(){
        return view('administration.admin_new_entries');
    }

    public function submitForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'faculty' => 'required|string',
            'honorarium' => 'required|integer',
            'date_received' => 'required|date',
            'month' => 'required|integer',
            'semester' => 'required|integer',
            'year' => 'required|digits:4|integer',
            'requirements' => 'required|string|in:complete,incomplete',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Process form data
        // ...

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }

    public function admin_on_queue(){
        return view('administration.admin_on_queue');
    }

    public function admin_on_hold(){
        return view('administration.admin_on_hold');
    }

}
