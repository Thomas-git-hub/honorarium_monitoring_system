<?php

namespace App\Http\Controllers;

use App\Models\Emailing;
use App\Models\Office;
use App\Models\ThesisLogs;
use App\Models\ThesisTransaction;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ThesisAcknowledgementController extends Controller
{
    public function thesis_acknowledgement(request $request)
    {
        if(Auth::user()->usertype->name !== 'Faculty'){
            $TransCountToday = ThesisTransaction::whereNull('deleted_at')
                                    ->where('status', 'On Queue')
                                    ->where('updated_on', Auth::user()->office_id)
                                    ->whereDate('created_at', Carbon::today())
                                    ->count();
            $yesterday = Carbon::yesterday()->format('Y-m-d');

            $TransCountYesterday = ThesisTransaction::whereNull('deleted_at')
                ->where('status', 'On Queue')
                ->where('updated_on', Auth::user()->office_id)
                ->whereDate('updated_at', $yesterday)
                ->count();

            $TransCountDaysAgo = ThesisTransaction::whereNull('deleted_at')
                ->where('status', 'On Queue')
                ->where('updated_on', Auth::user()->office_id)
                ->whereDate('updated_at', '<', now()->subDays(1))
                ->whereDate('updated_at', '>=', now()->subDays(7))
                ->count();

            $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
            $EmailCount = $pendingMails->count();

            $TransactionCount = ThesisTransaction::whereNull('deleted_at')
            ->where('status', 'On Queue')
            ->where('updated_on', Auth::user()->office_id)
            ->count();

            return view('administration.thesis_acknowledgement', compact('TransCountToday', 'TransCountYesterday', 'TransCountDaysAgo', 'EmailCount', 'TransactionCount'));

        }else{
            abort(403, 'Unauthorized action.');
        }
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

        if(Auth::user()->usertype->name === 'Administrator' || Auth::user()->usertype->name === 'Superadmin'){
            // Filter out ThesisLogs with a transaction count of 0
            $filteredThesisLogs = $ThesisLogs->filter(function ($acknowledgement) {
                $countTran = ThesisTransaction::whereNull('deleted_at')
                ->where('tracking_number', $acknowledgement->tracking_number)
                ->where('status', 'On Queue')
                // ->where('office', Auth::user()->office_id)
                ->count();
                return $countTran > 0; // Only keep ThesisLogs with a transaction count greater than 0
            });


        }else{
           // Filter out acknowledgements with a transaction count of 0
            $filteredThesisLogs = $ThesisLogs->filter(function ($ThesisLogs) {
                $countTran = ThesisTransaction::whereNull('deleted_at')
                ->where('tracking_number', $ThesisLogs->tracking_number)
                ->where('status', 'On Queue')
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
                ->where('status', 'On Queue')
                ->where('updated_on', Auth::user()->office_id)
                ->count();
            })
            ->addColumn('created_at', function ($data) {
                return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
            })
            ->make(true);
    }

    public function openThesisAcknowledgement(Request $request){
        $tracking_number = $request->input('id');

        $thesisLogs = ThesisLogs::with(['user', 'office', 'transaction'])
        ->select('id','tracking_number', 'office_id', 'created_at', 'user_id')
        ->where('tracking_number', $tracking_number)
        ->orderBy('id', 'desc')
        ->first();

        $TransCount = ThesisTransaction::with(['honorarium', 'createdBy'])
        ->whereNull('deleted_at')
        ->where('updated_on', Auth::user()->office_id)
        ->where('status', 'On Queue')
        ->where('tracking_number', $tracking_number)
        ->count();

        $office = Office::where('id', $thesisLogs->office_id)
        ->first();

        $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
        $EmailCount = $pendingMails->count();

        $TransactionCount = ThesisTransaction::with(['honorarium', 'createdBy'])
        ->whereNull('deleted_at')
        ->where('status', 'On Queue')
        ->where('updated_on', Auth::user()->office_id)
        ->count();

        return view('administration.thesis_open_acknowledgement', compact('tracking_number', 'thesisLogs', 'office', 'TransCount', 'EmailCount', 'TransactionCount'));
    }


    public function open_list(Request $request){

        if(Auth::user()->usertype->name === 'Superadmin'){
            $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn'])
            ->whereNull('deleted_at')
            ->where('status', 'On Queue')
            ->where('tracking_number', $request->tracking_number);
        }else{
            $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn'])
                    ->whereNull('deleted_at')
                    ->where('updated_on',  Auth::user()->office_id)
                    ->where('tracking_number', $request->tracking_number)
                    ->where('status', 'On Queue');
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

            ->addColumn('student', function($data) {
                return $data->student_id ? ucfirst($data->student->first_name) . ' ' . ucfirst($data->student->last_name) : 'N/A';
            })

            ->editColumn('defense_date', function($data) {
                return $data->defense_date;
            })
            ->editColumn('defense_time', function($data) {
                return $data->defense_time;
            })

            ->addColumn('orNumber', function($data) {
                return $data->or_number;
            })

            ->addColumn('degree', function($data) {
                return $data->degree_id ? ucfirst($data->degree->name) : 'N/A';
            })

            ->addColumn('defense', function($data) {
                return $data->defense_id ? ucfirst($data->defense->name) : 'N/A';
            })

            ->addColumn('adviser', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->adviser_id)
                ->first();
                return ucfirst($employeeDetails->employee_fname) . ' ' . ucfirst($employeeDetails->employee_lname);

            })

            ->addColumn('chairperson', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->chairperson_id)
                ->first();
                return ucfirst($employeeDetails->employee_fname) . ' ' . ucfirst($employeeDetails->employee_lname);

            })

            ->addColumn('chairperson', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->chairperson_id)
                ->first();
                return ucfirst($employeeDetails->employee_fname) . ' ' . ucfirst($employeeDetails->employee_lname);

            })

            ->addColumn('recorder', function($data) {
                return $data->recorder_id ? ucfirst($data->recorder->first_name) . ' ' . ucfirst($data->recorder->last_name) : 'N/A';
            })

            ->editColumn('created_by', function($data) {
                return $data->created_by ? ucfirst($data->createdBy->first_name) . ' ' . ucfirst($data->createdBy->last_name) : 'N/A';
            })

            ->editColumn('created_on', function($data) {
                return $data->created_on ? ucfirst($data->createdOn->name) : 'N/A';
            })

            ->editColumn('membersCount', function($data) {
                return count(json_decode($data->member_ids));
            })

            ->editColumn('created_at', function ($data) {
                return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
            })
            ->make(true);

    }

    public function acknowledge(Request $request){

        $transactions = ThesisTransaction::with(['createdBy'])
                                ->whereNull('deleted_at')
                                ->where('updated_on', Auth::user()->office_id)
                                ->where('tracking_number', $request->tracking_number)
                                ->where('status', 'On Queue')
                                ->get();

        if ($transactions->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No transactions found with status Processing']);
        }

        $ThesisLogs = ThesisLogs::where('tracking_number', $request->tracking_number)->first();

        $logs = new ThesisLogs();
        $logs->office_id = Auth::user()->office_id;
        $logs->user_id = Auth::user()->id;
        $logs->tracking_number = $ThesisLogs->tracking_number;
        $logs->save();

        foreach ($transactions as $transaction) {
            ThesisTransaction::whereNull('deleted_at')
            ->where('status', 'On Queue')
            ->where('tracking_number', $transaction->tracking_number)
            ->where('updated_on', Auth::user()->office_id)
            ->update([
                'status' => 'processing',
                'created_on' => Auth::user()->office_id,
                'created_by' => Auth::user()->id,
                'updated_at' => now(),
            ]);

        }


        return response()->json(['success' => true, 'message' => 'Thesis Acknowledged Successfully.']);
    }


}
