<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThesisNewEntriesController extends Controller
{
    public function thesisNewEntries()
    {
        return view('administration/thesis_new_entries');
    }
}
