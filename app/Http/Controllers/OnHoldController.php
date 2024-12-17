<?php

namespace App\Http\Controllers;

use App\Mail\TransactionStatusChanged;
use App\Models\Acknowledgement;
use App\Models\Activity_logs;
use App\Models\Emailing;
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
        $transactions = Transaction::with(['createdBy'])
        ->whereNull('deleted_at')
        ->where('batch_id', '=', $request->batch_id)
        ->where('batch_status', 'Batch On Hold')
        ->get();
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
                return $data->createdBy ? $data->createdBy->first_name  . ' ' . $data->createdBy->middle_name. ' ' .$data->createdBy->last_name: 'Unknown';
            })

            ->addColumn('sent', function($data) {
                return floor($data->updated_at->diffInDays(now())) . ' Days Ago';
            })

            ->addColumn('year', function($data) {
                return $data->year;
            })

            ->addColumn('requirement_status', function($data) {
                return $data->requirement_status;
            })

            ->addColumn('complied_on', function($data) {
                return $data->complied_on;
            })

            ->addColumn('action', function($data) {
                $proceedButton = '<button type="button" class="btn me-2 btn-primary btn-sm edit-btn gap-1" id="proceedTransactionButton">Proceed<i class="bx bx-chevrons-right"></i></button>';

                return '<div class="d-flex flex-row" data-id="' . $data->id . '">' . $proceedButton . '</div>';
            })

            ->addColumn('created_by_office', function($data) {
                return $data->createdBy->office_id;
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

        return response()->json(['success' => true, 'message' => 'Form submitted successfully.']);
    }


    public function UpdateToProceed(Request $request){

        $ibu_dbcon = DB::connection('ibu_test');

        // Fetch all transactions with status 'On-hold'
        $transaction = Transaction::whereNull('deleted_at')
        ->where('status', 'On-hold')->where('id', $request->id)->first();

        if (empty($transaction)) {
            return response()->json(['success' => false, 'message' => 'No transactions found with status Processing']);
        }

        $usertype = Auth::user()->usertype->name;

        if($usertype === 'Administrator' || $usertype === 'Superadmin'){
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

        $transactionQuery = Transaction::whereNull('deleted_at')
            ->where('status', 'On-hold')
            // ->where('office', Auth::user()->office_id)
            ->where('id', $request->id)
            ->where('created_by', Auth::user()->id)
            ->update([
                'status' => 'On Queue',
                'office' => $office->id,
                'created_by' => Auth::user()->id,
            ]);

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

    public function mainOnHold()
    {
        return view('administration.main_on_hold');
    }

    public function list(Request $request)
    {
        // Fetch data from the Acknowledgement table
        $acknowledgements = collect(); // Initialize an empty collection
        DB::statement("SET SQL_MODE=''");

        if(Auth::user()->usertype->name === 'Administrator' || Auth::user()->usertype->name === 'Superadmin'){

            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
            ->whereHas('transaction', function ($query) {
                $query->where('status', 'On-hold');
            })
            ->groupBy('batch_id')
            ->get();

            // Filter out acknowledgements with a transaction count of 0
            $filteredAcknowledgements = $acknowledgements->filter(function ($acknowledgement) {
                $countTran = Transaction::whereNull('deleted_at')
                ->where('batch_id', $acknowledgement->batch_id)
                ->where('batch_status', 'Batch On Hold')
                ->count();
                return $countTran > 0; // Only keep acknowledgements with a transaction count greater than 0
            });

        }else{

            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
            // ->where('office_id', Auth::user()->office_id)
            ->groupBy('batch_id')
            ->get();
           // Filter out acknowledgements with a transaction count of 0
            $filteredAcknowledgements = $acknowledgements->filter(function ($acknowledgement) {
                $countTran = Transaction::whereNull('deleted_at')
                ->where('batch_id', $acknowledgement->batch_id)
                ->where('batch_status', 'Batch On Hold')
                // ->where('from_office', Auth::user()->office_id)
                ->count();
                return $countTran > 0; // Only keep acknowledgements with a transaction count greater than 0
            });


        }

        // Return data as JSON using DataTables
        return DataTables::of($filteredAcknowledgements)
            ->addColumn('batch_id', function ($data) {
                return $data->batch_id;
            })
            ->addColumn('office', function ($data) {
                $office_of = Transaction::whereNull('deleted_at')
                ->with(['createdBy', 'office_from'])
                ->where('batch_id', $data->batch_id)
                ->where('batch_status', 'Batch On Hold')
                ->first();
                return 
                    $office_of->office_from->name;
            })
            ->addColumn('count_transaction', function ($data) {
                return Transaction::whereNull('deleted_at')
                ->where('batch_id', $data->batch_id)
                ->where('batch_status', 'Batch On Hold')
                // ->where('office', Auth::user()->office_id)
                ->count();
            })
            ->addColumn('hold_by', function ($data) {
                $hold_by = Transaction::whereNull('deleted_at')
                ->with(['createdBy'])
                ->where('batch_id', $data->batch_id)
                ->where('batch_status', 'Batch On Hold')
                ->first();
                return $hold_by->createdBy->first_name. ' ' .$hold_by->createdBy->middle_name. ' ' .$hold_by->createdBy->last_name;
            })

            ->addColumn('sent', function($data) {
                return floor($data->updated_at->diffInDays(now())) . ' Days Ago';
            })

            ->addColumn('date_received', function ($data) {
                return $data->updated_at ? $data->updated_at->format('m-d-Y') : 'N/A';
            })

            ->make(true);
    }

    public function updateCompliedOn(Request $request)
    {
        // Validate the request
        $request->validate([
            'id' => 'required|exists:transaction,id',
            'complied_on' => 'required|date'
        ]);

        // Find the transaction by ID
        $transaction = Transaction::find($request->id);

        if ($transaction) {
            // Update the complied_on field
            $transaction->complied_on = $request->complied_on;
            $transaction->requirement_status = 'Complied';
            $transaction->save();

            // Return a JSON response
            return response()->json(['success' => true, 'message' => 'Complied on date updated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Transaction not found.'], 404);
    }

    public function proceed_on_hold(Request $request)
    {
        $ibu_dbcon = DB::connection('ibu_test');

        $transactions = Transaction::whereNull('deleted_at')
        ->where('batch_status', 'Batch On Hold')
        ->where('batch_id', $request->batch_id)
        ->get();

        $hasForCompliance = $transactions->where('requirement_status', 'For Compliance')->isNotEmpty();

        if($hasForCompliance){
            return response()->json(['success' => false, 'message' => 'This batch still has for compliance item(s)']);

        }

        if ($transactions->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No transactions found with status Processing']);
        }

        

        $batchId = $request->batch_id;

        foreach ($transactions as $transaction) {

            if($transaction->office_from->name === 'BUGS Administration'){
                $office = Office::where('name', 'Budget Office')->first();
            }
            elseif($transaction->office_from->name === 'Budget Office' || $transaction->office_from->name === 'Accounting' ){
                $office = Office::where('name', 'Dean')->first();
            }
            elseif($transaction->office_from->name === 'Dean' ){
                $office = Office::where('name', 'Accounting')->first();

            }elseif($transaction->office_from->name === 'Cashiers'){
                $office = Office::where('name', 'Faculty')->first();

            }elseif($transaction->office_from->name === 'Accounting' ){
                $office = Office::where('name', 'Dean')->first();
            }
            else{
                return response()->json(['success' => false, 'message' => 'No office Found']);
            }

          
            if($transaction->office_from->name === 'Cashiers' ){

                Transaction::whereNull('deleted_at')
                ->where('id', $transaction->id)
                ->where('batch_status', 'Batch On Hold')
                ->where('batch_id', $request->batch_id)
                ->update([
                    'batch_status' => 'No Findings',
                    'status' => 'Complete',
                    'requirement_status' => 'Complete',
                    'office' => $office->id,
                    'created_by' => Auth::user()->id,
                    'updated_at' => now(),
                ]);

            }else{

                Transaction::whereNull('deleted_at')
                ->where('id', $transaction->id)
                ->where('batch_status', 'Batch On Hold')
                ->where('batch_id', $request->batch_id)
                ->update([
                    'batch_status' => 'No Findings',
                    'status' => 'On Queue',
                    'requirement_status' => 'Complete',
                    'office' => $office->id,
                    'created_by' => Auth::user()->id,
                    'updated_at' => now(),
                ]);

            }

            $employee = $ibu_dbcon->table('employee_user')
            ->where('id', $transaction->employee_id)
            ->first();
            $employeedetails = $ibu_dbcon->table('employee')
            ->where('id', $transaction->employee_id)
            ->first();

            if (!empty($employee->email)) {
                $emailData = [
                    'transaction_id' => $transaction->id,
                    'employee_fname' => $employeedetails->employee_fname,
                    'employee_lname' => $employeedetails->employee_lname,
                    'status' => 'On Queue',
                    'created_at' => now()->format('F j, Y'),
                    'honorarium' => $transaction->honorarium->name,
                    'office' => $office->name,

                ];

                Mail::to($employee->email)->send(new TransactionStatusChanged($emailData));
            }

            $emailMessage = '
            <div>
                Hi ' . $employeedetails->employee_fname . ', 🖐<br><br>
                Your transaction has been updated.<br><br>
                <ul>
                    <li>Your Honorarium is now on: ' . $office->name . '</li>
                    <li>Date of Transaction: ' . now()->format('F j, Y') . '</li>
                    <li>Transaction Status: On Queue</li>
                    <li>Honorarium: ' . $transaction->honorarium->name . '</li>
                </ul>
            </div>
            ';

            $email = new Emailing();
            $email->transaction_id = $transaction->id;
            $email->subject = 'New Update on Your Honorarium Transaction';
            $email->to_user = $employeedetails->id;
            $email->message = $emailMessage;
            $email->status = 'Unread';
            $email->created_by = Auth::user()->id;
            $email->save();

        }

        return response()->json(['success' => true, 'batch_id'=> $batchId, 'message' => 'Emails sent and transactions updated.']);
    }


}
