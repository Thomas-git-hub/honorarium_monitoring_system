<?php

namespace App\Http\Controllers;

use App\Models\Acknowledgement;
use App\Models\Office;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CashierQueueController extends Controller
{
    public function cashier_in_queue(){

        return view('administration.cashier_in_queue');
    }

    public function cashier_open_queue(Request $request){
        $batch_id = $request->input('id');

        $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
        ->select('batch_id', 'office_id', 'created_at', 'user_id')
        ->where('batch_id', $batch_id)
        ->first();

        $TransCount = Transaction::with(['honorarium', 'createdBy'])
        ->where('office', Auth::user()->office_id)
        ->where('status', 'Processing')
        ->where('batch_id', $batch_id)
        ->count();

        $office = Office::where('id', $acknowledgements->office_id)->first();

        return view('administration.cashier_open_queue', compact('batch_id', 'acknowledgements', 'office', 'TransCount'));
    }


    public function list(Request $request)
    {
        // Fetch data from the Acknowledgement table
        $acknowledgements = collect(); // Initialize an empty collection
        DB::statement("SET SQL_MODE=''");

        $From_office = Office::where('name', 'Dean')->first();
        $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
            ->select('batch_id', 'office_id', 'created_at', 'user_id')
            ->where('office_id', $From_office->id)
            ->groupBy('batch_id')
            ->get();

        if(Auth::user()->usertype->name === 'Superadmin'){
            $filteredAcknowledgements = $acknowledgements->filter(function ($acknowledgement) {
                $countTran = Transaction::where('batch_id', $acknowledgement->batch_id)
                ->where('status', 'Processing')
                ->count();
                return $countTran > 0;
            });
        }
        else{
            $filteredAcknowledgements = $acknowledgements->filter(function ($acknowledgement) {
                $countTran = Transaction::where('batch_id', $acknowledgement->batch_id)
                ->where('status', 'Processing')
                ->where('office', Auth::user()->office_id)
                ->where('created_by', Auth::user()->id)
                ->count();
                return $countTran > 0;
            });


        }

        // Return data as JSON using DataTables
        return DataTables::of($filteredAcknowledgements)
            ->addColumn('batch_id', function ($data) {
                return $data->batch_id;
            })
            ->addColumn('from', function ($data) {
                return $data->user->first_name . ' ' . $data->user->last_name . ' ' .
                    '(' . $data->office->name . ')';
            })
            ->addColumn('trans_id', function ($data) {
                if(Auth::user()->usertype->name === 'Admin' || Auth::user()->usertype->name === 'Superadmin'){
                    return Transaction::where('batch_id', $data->batch_id)
                    ->where('status','!=', 'On-hold')
                    ->count();
                }
                else{
                    return Transaction::where('batch_id', $data->batch_id)->where('status', 'Processing')
                    ->where('office', Auth::user()->office_id)
                    ->count();
                }

            })
            ->addColumn('created_at', function ($data) {
                return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
            })
            ->make(true);
    }

    public function open_list(Request $request){

        if(Auth::user()->usertype->name === 'Superadmin'){
            $query = Transaction::with(['honorarium', 'createdBy'])->where('status', 'Processing')->where('batch_id', $request->batch_id);
        }else{
            $query = Transaction::with(['honorarium', 'createdBy'])
                                    ->where('status', 'Processing')
                                    ->where('batch_id', $request->batch_id)
                                    ->where('office',  Auth::user()->office_id);

        }

        $transactions = $query->get();
        $ibu_dbcon = DB::connection('ibu_test');

        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        return DataTables::of($transactions)
            ->addColumn('id', function($data) {
                return $data->id;
            })
            ->addColumn('faculty', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->employee_id)
                ->first();
                return ucfirst($employeeDetails->employee_fname) . ' ' . ucfirst($employeeDetails->employee_lname);
            })
            ->addColumn('id_number', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->employee_id)
                ->first();
                return $employeeDetails->employee_no ? $employeeDetails->employee_no : 0;
            })
            ->addColumn('academic_rank', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->employee_id)
                ->first();
                return ucfirst($employeeDetails->employee_academic_rank);
            })

            ->addColumn('college', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->employee_id)
                ->first();

                $collegeDetails = $ibu_dbcon->table('college')
                ->where('id', $employeeDetails->college_id)
                ->first();
                return $collegeDetails->college_shortname ? $collegeDetails->college_shortname : 'No College Found';
            })

            ->addColumn('honorarium', function($data) {
                return $data->honorarium_id ? $data->honorarium->name : 'N/A';
            })

            ->addColumn('month', function($data) use ($months) {
                // return $months[$data->month] ?? 'Unknown';
                return [
                    'month_number' => $data->month,
                    'month_name' => $months[$data->month] ?? 'Unknown'
                ];
            })

            ->addColumn('contact', function($data) use($ibu_dbcon) {
                $user =  User::where('employee_id',  $data->employee_id)->first();
                if( $user === NULL){
                    return 'No Contact Found';
                }else{
                    return $user->contact ? $user->contact : 0;
                }
                // $employeeDetails = $ibu_dbcon->table('employee')
                // ->where('id', $data->employee_id)
                // ->first();

            })

            ->addColumn('created_by', function($data) {
                return $data->createdBy ? $data->createdBy->first_name  . ' ' . $data->createdBy->last_name: 'Unknown';
            })
            ->addColumn('net_amount', function($data) {
                return '';
            })


            ->make(true);

    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'id' => 'required|integer|exists:transaction,id',
            'net_amount' => 'required|numeric|min:0',
        ]);

        // Find the transaction by ID and update the net amount
        $transaction = Transaction::find($request->id);
        $transaction->net_amount = $request->net_amount;
        $transaction->updated_at = now();
        $transaction->created_by = Auth::user()->id;
        $transaction->save();

        // Return success response
        return response()->json(['success' => 'Net amount updated successfully.']);
    }

    public function checkIfProceedToCashier(Request $request)
    {
        $batchId = $request->input('batch_id');
        $user = Auth::user();
        $accountingOfficeId = Office::where('name', 'Accounting')->first()->id;

        // Check if the batch is already acknowledged by Accounting
        $batchAcknowledgedByAccounting = Acknowledgement::where('batch_id', $batchId)
            ->where('office_id', $accountingOfficeId)
            ->exists();

        // Check if the user is a Dean
        $isDean = $user->usertype->name === 'Dean';

        return response()->json([
            'canProceedToCashier' => $batchAcknowledgedByAccounting && $isDean
        ]);
    }

}
