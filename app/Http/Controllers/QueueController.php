<?php

namespace App\Http\Controllers;

use App\Mail\TransactionStatusChanged;
use App\Models\Acknowledgement;
use App\Models\Activity_logs;
use App\Models\Office;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class QueueController extends Controller
{

    public function proceedToBudgetOffice(Request $request)
    {
        $ibu_dbcon = DB::connection('ors_pgsql');

        // Fetch all transactions with status 'Processing'
        $transactions = Transaction::where('status', 'Processing')->get();

        if ($transactions->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No transactions found with status Processing']);
        }
        foreach ($transactions as $transaction) {
            $logs = new Activity_logs();
            $logs->trans_id = $transaction->id;
            $logs->office_id = Auth::user()->office_id;
            $logs->user_id = Auth::user()->id;
            $logs->save();

        }

        $ack = new Acknowledgement();
        $ack->trans_id = $transaction->id;
        $ack->office_id = Auth::user()->office_id;
        $ack->user_id = Auth::user()->id;
        $ack->save();

        // Update the batch_id after saving
        $ack->batch_id = '00'. $ack->id . '-' . $ack->created_at->format('mdY');
        $ack->save();

        $usertype = Auth::user()->usertype->name;

        if($usertype === 'Admin' || $usertype === 'Superadmin'){
            $office = Office::where('name', 'Budget Office')->first();
        }
        elseif($usertype === 'Budget Office' || $usertype === 'Accounting ' ){
            $office = Office::where('name', 'Dean')->first();
        }else{
            $office = Office::where('name', 'Faculty')->first();
        }

        // Update the status to 'On Queue'
        Transaction::where('status', 'Processing')->update([
            'status' => 'On Queue',
            'batch_id' => $ack->batch_id,
            'office' => $office->id
        ]);


        return response()->json(['success' => true, 'message' => 'Emails sent and transactions updated.']);
    }

    public function update(Request $request){

        // Validation
        $validator = Validator::make($request->all(), [
            'honorarium_id' => 'required|exists:honorarium,id',
            'sem' => 'required|string',
            'year' => 'required|integer',
            'month' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 200);
        }

        // Find the transaction by ID
        $transaction = Transaction::find($request->id);

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found.'], 404);
        }

        // Update the transaction with new data
        $transaction->honorarium_id = $request->honorarium_id;
        $transaction->sem = $request->sem;
        $transaction->year = $request->year;
        $transaction->month = $request->month;
        $transaction->created_by =Auth::user()->id;
        $transaction->save();

        return response()->json(['success' => true, 'message' => 'Transaction updated successfully.']);

    }

    public function change_to_onhold(Request $request){

        // Find the transaction by ID
        $transaction = Transaction::find($request->id);
        $ibu_dbcon = DB::connection('ibu_test');
        // dd($transaction->employee_id);

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found.'], 404);
        }

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
                'status' => $transaction->status,
            ];

            Mail::to($employee->email)->send(new TransactionStatusChanged($emailData));
        }

        $transaction->status = 'On-hold';
        $transaction->created_by = Auth::user()->id;
        $transaction->save();

        return response()->json(['success' => true, 'message' => 'Transaction updated successfully.']);

    }

}
