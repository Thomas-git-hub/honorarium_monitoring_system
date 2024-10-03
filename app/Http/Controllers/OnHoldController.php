<?php

namespace App\Http\Controllers;

use App\Mail\TransactionStatusChanged;
use App\Models\Acknowledgement;
use App\Models\Activity_logs;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class OnHoldController extends Controller
{
    public function getOnHoldTransactions(Request $request)
    {
        // Query to get transactions with status 'On-hold'
        $transactions = Transaction::where('batch_id', '!=', NULL)->where('status', 'On-hold')
        ->where('created_by', Auth::user()->id)
        ->get();
        $ibu_dbcon = DB::connection('ors_pgsql');

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

        // Return DataTables response
        return DataTables::of($transactions)
            ->addColumn('id', function ($data) {
                return $data->id;
            })

            ->addColumn('faculty', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->employee_id)
                ->first();
                return ucfirst($employeeDetails->employee_fname ? $employeeDetails->employee_fname : '') . ' ' . ucfirst($employeeDetails->employee_lname ? $employeeDetails->employee_lname : ' ');
            })

            ->addColumn('id_number', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->employee_id)
                ->first();
                return ucfirst($employeeDetails->employee_no ? $employeeDetails->employee_no : ' ');
            })

            ->addColumn('academic_rank', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->employee_id)
                ->first();
                return ucfirst($employeeDetails->employee_academic_rank ? $employeeDetails->employee_academic_rank : ' ');
            })

            ->addColumn('college', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->employee_id)
                ->first();

                $collegeDetails = $ibu_dbcon->table('college')
                ->where('id', $employeeDetails->college_id)
                ->first();
                return $collegeDetails->college_shortname ? $collegeDetails->college_shortname : '';
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

            ->addColumn('sent', function($data) {
                return 'Sent ' . floor($data->updated_at->diffInDays(now())) . ' Days Ago';
            })

            ->addColumn('action', function($data) {
                $proceedButton = '<button type="button" class="btn me-2 btn-primary btn-sm edit-btn gap-1" id="proceedTransactionButton">Proceed<i class="bx bx-chevrons-right"></i></button>';

                return '<div class="d-flex flex-row" data-id="' . $data->id . '">' . $proceedButton . '</div>';
            })

            ->make(true);
    }

    public function saveOnHold(Request $request){
        $validator = Validator::make($request->all(), [
            'date_of_trans' => 'required|date',
            'employee_id' => 'required',
            'honorarium_id' => 'required|exists:honorarium,id',
            'sem' => 'required|string',
            'year' => 'required|integer',
            'month' => 'required|string',
            'is_complete' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false,'errors' => $validator->errors()], 200);
        }

        // Process form data
        $transaction = new Transaction();
        $transaction->date_of_trans = $request->date_of_trans;
        $transaction->employee_id = $request->employee_id;
        $transaction->office = Auth::user()->office_id;
        $transaction->honorarium_id = $request->honorarium_id;
        $transaction->sem = $request->sem;
        $transaction->year = $request->year;
        $transaction->month = $request->month;
        $transaction->is_complete = $request->is_complete;
        $transaction->status = 'On-hold';
        $transaction->created_by = Auth::user()->id;
        $transaction->save();


        $logs = new Activity_logs();
        $logs->trans_id = $transaction->id;
        $logs->office_id = Auth::user()->office_id;
        $logs->user_id = $transaction->created_by;
        $logs->save();

        return response()->json(['success' => true, 'message' => 'Form submitted successfully.']);
    }


    public function UpdateToProceed(Request $request){

        $ibu_dbcon = DB::connection('ors_pgsql');

        // Fetch all transactions with status 'On-hold'
        $transaction = Transaction::where('status', 'On-hold')->where('id', $request->id)->first();

        if (empty($transaction)) {
            return response()->json(['success' => false, 'message' => 'No transactions found with status Processing']);
        }

        $usertype = Auth::user()->usertype->name;

        if($usertype === 'Admin' || $usertype === 'Superadmin'){
            $office = Office::where('name', 'Budget Office')->first();
        }
        elseif($usertype === 'Budget Office' || $usertype === 'Accounting'){
            $office = Office::where('name', 'Dean')->first();
        }
        elseif($usertype === 'Dean' ){
            $office = Office::where('name', 'Accounting')->first();
        }
        else{
            $office = Office::where('name', 'Faculty')->first();
        }

        $transactionQuery = Transaction::where('status', 'On-hold')
            // ->where('office', Auth::user()->office_id)
            ->where('id', $request->id)
            ->where('created_by', Auth::user()->id)
            ->update([
                'status' => 'On Queue',
                'office' => $office->id,
                'created_by' => Auth::user()->id,
            ]);

        $logs = new Activity_logs();
        $logs->trans_id = $transaction->id;
        $logs->office_id = Auth::user()->office_id;
        $logs->user_id = Auth::user()->id;
        $logs->save();

        $batchId = $transaction->batch_id;

        $employee = $ibu_dbcon->table('employee_user')
        ->where('id', $transaction->employee_id)
        ->first();
        $employeedetails = $ibu_dbcon->table('employee')
                ->where('id', $transaction->employee_id)
                ->first();
        // dd($employee->email);

        if (!empty($employee->email)) {
            $emailData = [
                'transaction_id' => $transaction->id,
                'employee_fname' => $employeedetails->employee_fname,
                'employee_lname' => $employeedetails->employee_lname,
                'status' => 'On Hold',
                'created_at' => now()->format('F j, Y'),
                'honorarium' => $transaction->honorarium->name,
                'office' => $office->name,
            ];

            Mail::to($employee->email)->send(new TransactionStatusChanged($emailData));
        }

        return response()->json(['success' => true, 'batch_id'=> $batchId, 'message' => 'Emails sent and transactions updated.']);
    }
}
