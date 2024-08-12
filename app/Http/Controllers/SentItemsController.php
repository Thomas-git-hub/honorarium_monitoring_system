<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SentItemsController extends Controller
{
    public function sent_items(){
        return view('administration.sent_items');
    }
}
