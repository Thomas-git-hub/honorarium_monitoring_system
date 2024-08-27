<?php

namespace App\Http\Controllers;

use App\Models\Acknowledgement;
use App\Models\Office;
use App\Models\Transaction;

use Yajra\DataTables\Facades\DataTables;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForAcknowledgementController extends Controller
{
    public function for_acknowledgement(request $request)
    {
        return view('administration.for_acknowledgement');
    }

    public function list(Request $request){

        // Fetch data from the Acknowledgement table

        if(Auth::user()->usertype->name === 'Superadmin'){
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
            ->select('batch_id', 'trans_id as transaction_id', 'office_id', 'created_at', 'user_id')
            ->get();

        }
        elseif(Auth::user()->usertype->name === 'Budget Office'){
            $From_office = Office::where('name', 'BUGS Administration')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
            ->select('batch_id', 'trans_id as transaction_id', 'office_id', 'created_at', 'user_id')
            ->where('office_id',  $From_office->id)
            ->get();

        }elseif(Auth::user()->usertype->name === 'Dean'){
            $From_office = Office::where('name', 'Budget Office')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
            ->select('batch_id', 'trans_id as transaction_id', 'office_id', 'created_at', 'user_id')
            ->where('office_id',  $From_office->id)
            ->get();

        }elseif(Auth::user()->usertype->name === 'Accounting' || Auth::user()->usertype->name === 'Cashiers'){
            $From_office = Office::where('name', 'Dean')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
            ->select('batch_id', 'trans_id as transaction_id', 'office_id', 'created_at', 'user_id')
            ->where('office_id',  $From_office->id)
            ->get();

        }elseif(Auth::user()->usertype->name === 'Dean'){
            $From_office_acc = Office::where('name', 'Accounting')->first();
            $From_office_BO = Office::where('name', 'Budget Office')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
            ->select('batch_id', 'trans_id as transaction_id', 'office_id', 'created_at', 'user_id')
            ->where('office_id',  $From_office_acc->id)
            ->orWhere('office_id',  $From_office_BO->id)
            ->get();
        }
        
        // Return data as JSON
        // return response()->json(['data' => $acknowledgements]);
        // return view('administration.for_acknowledgement');

        return DataTables::of($acknowledgements)
        ->addColumn('batch_id', function ($data) {
            return $data->batch_id;
        })
        ->addColumn('from', function ($data) {
            return $data->user->first_name . ' ' . $data->user->last_name . ' ' .
                   '(' . $data->office->name . ')';
        })
        ->addColumn('trans_id', function ($data) {
            $countTran = Transaction::where('batch_id', $data->batch_id);
            return   $countTran->count();
        })
        ->addColumn('created_at', function ($data) {
            return $data->created_at ? $data->created_at->format('Y-m-d H:i:s') : 'N/A';
        })
        ->make(true);
    }
}
