<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\ThesisLogs;
use App\Models\ThesisTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ThesisOutGoingController extends Controller
{
    public function showThesisOutGoing()
    {
        return view('administration.thesis_out_going');
    }

    public function list(Request $request)
    {
        // Fetch data from the Acknowledgement table
        $acknowledgements = collect(); // Initialize an empty collection
        DB::statement("SET SQL_MODE=''");

        if ( Auth::user()->usertype->name === 'Administrator') {
            $From_office = Office::where('name', 'Dean')->first();
            $ThesisLogs = ThesisLogs::with(['user', 'office', 'transaction'])
                ->select('tracking_number', 'office_id', 'created_at', 'user_id')
                ->where('office_id', $From_office->id)
                ->groupBy('tracking_number')
                ->get();
        
        } 
        elseif (Auth::user()->usertype->name === 'Budget Office') {
            $From_office = Office::where('name', 'BUGS Administration')->first();
            $ThesisLogs = ThesisLogs::with(['user', 'office', 'transaction'])
                ->select('tracking_number', 'office_id', 'created_at', 'user_id')
                ->where('office_id', $From_office->id)
                ->groupBy('tracking_number')
                ->get();

        } elseif (Auth::user()->usertype->name === 'Accounting' || Auth::user()->usertype->name === 'Cashiers') {
            $From_office = Office::where('name', 'Dean')->first();
            $ThesisLogs = ThesisLogs::with(['user', 'office', 'transaction'])
                ->select('tracking_number', 'office_id', 'created_at', 'user_id')
                ->where('office_id', $From_office->id)
                ->groupBy('tracking_number')
                ->get();
        } elseif (Auth::user()->usertype->name === 'Dean') {
            $From_office_acc = Office::where('name', 'Accounting')->first();
            $From_office_BO = Office::where('name', 'Budget Office')->first();
            $ThesisLogs = ThesisLogs::with(['user', 'office', 'transaction'])
                ->select('tracking_number', 'office_id', 'created_at', 'user_id')
                ->where('office_id', $From_office_acc->id)
                ->orWhere('office_id', $From_office_BO->id)
                ->groupBy('tracking_number')
                ->get();
        }else{
            $ThesisLogs = collect();
        }

        if( Auth::user()->usertype->name === 'Superadmin'){
            // Filter out ThesisLogs with a transaction count of 0
            $filteredThesisLogs = $ThesisLogs->filter(function ($acknowledgement) {
                $countTran = ThesisTransaction::whereNull('deleted_at')
                ->where('tracking_number', $acknowledgement->tracking_number)
                ->where('status', 'processing')
                // ->where('office', Auth::user()->office_id)
                ->count();
                return $countTran > 0; // Only keep ThesisLogs with a transaction count greater than 0
            });


        }else{
           // Filter out acknowledgements with a transaction count of 0
            $filteredThesisLogs = $ThesisLogs->filter(function ($ThesisLogs) {
                $countTran = ThesisTransaction::whereNull('deleted_at')
                ->where('tracking_number', $ThesisLogs->tracking_number)
                ->where('status', 'processing')
                ->where('updated_on', Auth::user()->office_id)
                ->count();
                return $countTran > 0; // Only keep ThesisLogs with a transaction count greater than 0
            });


        }

        // Return data as JSON using DataTables
        return DataTables::of($filteredThesisLogs)
            ->addColumn('tracking_number', function ($data) {
                return $data->tracking_number;
            })
            ->addColumn('from', function ($data) {
                return $data->user->first_name . ' ' . $data->user->last_name . ' ' .
                '(' . $data->office->name . ')';
            })
            ->addColumn('trans_id', function ($data) {
                return ThesisTransaction::whereNull('deleted_at')
                ->where('tracking_number', $data->tracking_number)
                ->where('status', 'processing')
                ->where('updated_on', Auth::user()->office_id)
                ->count();
            })
            ->addColumn('created_at', function ($data) {
                return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
            })
            ->make(true);
    }

    public function getItems(){

        $transactions = ThesisTransaction::whereNull('deleted_at')
        ->where('status', 'processing')
        ->where('updated_on', Auth::user()->office_id)
        ->where('updated_by', Auth::user()->id)
        ->count();

        return response()->json(['transactions' => $transactions]);
    }

    
}
