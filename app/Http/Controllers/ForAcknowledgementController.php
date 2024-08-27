<?php

namespace App\Http\Controllers;

use App\Models\Acknowledgement;
use App\Models\Transaction;

use Yajra\DataTables\Facades\DataTables;


use Illuminate\Http\Request;

class ForAcknowledgementController extends Controller
{
    public function for_acknowledgement(request $request)
    {
        return view('administration.for_acknowledgement');
    }

    public function list(Request $request){

        // Fetch data from the Acknowledgement table
        $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
        ->select('batch_id', 'trans_id as transaction_id', 'office_id', 'created_at', 'user_id')->get();

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
