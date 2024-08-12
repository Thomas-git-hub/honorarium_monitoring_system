<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class QueueController extends Controller
{
    public function proceedToBudgetOffice(Request $request){

        // $ibu_dbcon = DB::connection('ibu_test');
        $ibu_dbcon = DB::connection('ors_pgsql');

        // Fetch all transactions with status 'Processing'
        $transactions = Transaction::where('status', 'Processing')->get();

        if ($transactions->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No transactions found with status Processing']);
        }

        // Update the status to 'On Queue'
        Transaction::where('status', 'Processing')->update(['status' => 'On Queue']);


        // Get the emails of the employees associated with the transactions
        $employeeIds = $transactions->pluck('employee_id')->toArray();
        $emails = $ibu_dbcon->table('employee_user')
            ->whereIn('id', $employeeIds)
            ->pluck('email')
            ->toArray(); // Get an array of emails

        // Send an email to each employee
        foreach ($emails as $email) {
            Mail::send('emails.transaction_processing', [], function ($message) use ($email) {
                $message->to($email)
                    ->subject('Transaction Update: On Queue');
            });
        }

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
        $transaction->created_by = auth()->user()->id;
        $transaction->save();

        return response()->json(['success' => true, 'message' => 'Transaction updated successfully.']);

    }

    public function change_to_onhold(Request $request){

        // Find the transaction by ID
        $transaction = Transaction::find($request->id);

        if (!$transaction) {
            return response()->json(['success' => false, 'message' => 'Transaction not found.'], 404);
        }

        // Update the transaction with new data
        $transaction->status = 'On-hold';
        $transaction->created_by = auth()->user()->id;
        $transaction->save();

        return response()->json(['success' => true, 'message' => 'Transaction updated successfully.']);

    }

}
