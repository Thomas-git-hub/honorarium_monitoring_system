<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CashierQueueController extends Controller
{
    public function cashier_in_queue(){

        return view('administration.cashier_in_queue');
    }

    public function cashier_open_queue(){

        return view('administration.cashier_open_queue');
    }
}
