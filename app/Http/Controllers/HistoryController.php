<?php

namespace App\Http\Controllers;

use App\Mail\Acknowledge;
use App\Models\Acknowledgement;
use App\Models\Office;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HistoryController extends Controller
{
    public function history(){
        return view('administration.history');
    }

    public function open_history(Request $request){
        $batch_id = $request->input('id');

        $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
        ->select('batch_id', 'trans_id as transaction_id', 'office_id', 'created_at', 'user_id')
        ->where('batch_id', $batch_id)
        ->first();

        $TransCount = Transaction::with(['honorarium', 'createdBy'])->where('batch_id', $batch_id)->count();

        return view('administration.open_history', compact('batch_id', 'acknowledgements', 'TransCount'));
    }

    public function list(Request $request)
    {
        // Fetch data from the Acknowledgement table
        $acknowledgements = collect(); // Initialize an empty collection

        if (Auth::user()->usertype->name === 'Superadmin') {
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'trans_id as transaction_id', 'office_id', 'created_at', 'user_id', 'id')
                ->get();
        } elseif (Auth::user()->usertype->name === 'Budget Office') {
            $From_office = Office::where('name', 'BUGS Administration')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'trans_id as transaction_id', 'office_id', 'created_at', 'user_id', 'id')
                ->where('office_id', $From_office->id)
                ->get();
        } elseif (Auth::user()->usertype->name === 'Dean') {
            $From_office = Office::where('name', 'Budget Office')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'trans_id as transaction_id', 'office_id', 'created_at', 'user_id', 'id')
                ->where('office_id', $From_office->id)
                ->get();
        } elseif (Auth::user()->usertype->name === 'Accounting' || Auth::user()->usertype->name === 'Cashiers') {
            $From_office = Office::where('name', 'Dean')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'trans_id as transaction_id', 'office_id', 'created_at', 'user_id', 'id')
                ->where('office_id', $From_office->id)
                ->get();
        } elseif (Auth::user()->usertype->name === 'Dean') {
            $From_office_acc = Office::where('name', 'Accounting')->first();
            $From_office_BO = Office::where('name', 'Budget Office')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'trans_id as transaction_id', 'office_id', 'created_at', 'user_id', 'id')
                ->where('office_id', $From_office_acc->id)
                ->orWhere('office_id', $From_office_BO->id)
                ->get();
        }else{
            $acknowledgements = collect();
        }

        // dd($acknowledgements);

        // Filter out acknowledgements with a transaction count of 0
        $filteredAcknowledgements = $acknowledgements->filter(function ($acknowledgement) {
            $countTran = Transaction::where('batch_id', $acknowledgement->batch_id)
                                    // ->where('status', '!=', 'On Queue')
                                        ->count();
            return $countTran > 0; // Only keep acknowledgements with a transaction count greater than 0
        });

        // Return data as JSON using DataTables
        return DataTables::of($filteredAcknowledgements)
            ->addColumn('id', function ($data) {
                return $data->id;
            })
            ->addColumn('batch_id', function ($data) {
                return $data->batch_id;
            })
            ->addColumn('from', function ($data) {
                return $data->user->first_name . ' ' . $data->user->last_name . ' ' .
                    '(' . $data->office->name . ')';
            })
            ->addColumn('number_of_transactions', function ($data) {
                return Transaction::where('batch_id', $data->batch_id)->count();
            })
            ->addColumn('date', function ($data) {
                return $data->created_at ? $data->created_at->format('Y-m-d H:i:s') : 'N/A';
            })
            ->make(true);
    }

    public function OpenHistoryList(Request $request){

        $query = Transaction::with(['honorarium', 'createdBy'])->where('batch_id', $request->batch_id);
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
                // $employeeDetails = $ibu_dbcon->table('employee')
                // ->where('id', $data->employee_id)
                // ->first();
                return $data->ee_number ? $data->ee_number : 0;
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

            ->addColumn('created_by', function($data) {
                return $data->createdBy ? $data->createdBy->first_name  . ' ' . $data->createdBy->last_name: 'Unknown';
            })
            ->addColumn('action', function($data) {
                $editButton = '<button type="button" class="btn btn-icon me-2 btn-label-success edit-btn"><span class="tf-icons bx bx-pencil bx-18px"></span></button>';
                $on_holdButton = '<button type="button" class="btn btn-icon me-2 btn-label-danger on-hold-btn"><span class="tf-icons bx bxs-hand bx-18px"></span></button>';

                return '<div class="d-flex flex-row" data-id="' . $data->id . '">' . $editButton . $on_holdButton . '</div>';
            })

            ->make(true);

    }
}