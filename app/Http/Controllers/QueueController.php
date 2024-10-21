<?php

namespace App\Http\Controllers;

use App\Jobs\SendTransactionEmailsJob;
use App\Mail\On_Hold_Email_two;
use App\Mail\TransactionStatusChanged;
use App\Models\Acknowledgement;
use App\Models\Activity_logs;
use App\Models\Emailing;
use App\Models\Office;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class QueueController extends Controller
{

    // public function proceedToBudgetOffice(Request $request)
    // {
    //     $ibu_dbcon = DB::connection('ors_pgsql');

    //     $usertype = Auth::user()->usertype->name;

    //     if($usertype === 'Admin' || $usertype === 'Superadmin'){
    //         $office = Office::where('name', 'Budget Office')->first();
    //     }
    //     elseif($usertype === 'Budget Office' || $usertype === 'Accounting' ){
    //         $office = Office::where('name', 'Dean')->first();
    //     }
    //     elseif($usertype === 'Dean' ){
    //         $office = Office::where('name', 'Accounting')->first();
    //     }elseif($usertype === 'Cashiers'){
    //         $office = Office::where('name', 'Faculty')->first();
    //     }else{
    //         return response()->json(['success' => false, 'message' => 'No office Found']);
    //     }

    //     // Fetch all transactions with status 'Processing'
    //     $transactions = Transaction::with(['honorarium', 'office'])
    //     ->whereNull('deleted_at')
    //     ->where('status', 'Processing')
    //     ->orwhere('status', 'On-hold')
    //     ->where('batch_id', '!=', NULL)
    //     ->where('office', Auth::user()->office_id)
    //     ->where('created_by', Auth::user()->id)
    //     ->get();

    //     if ($transactions->isEmpty()) {
    //         return response()->json(['success' => false, 'message' => 'No transactions found with status Processing']);
    //     }


    //     $transaction_update = Transaction::whereNull('deleted_at')
    //     ->where('status', 'Processing')
    //     ->where('office', Auth::user()->office_id)
    //     ->where('created_by', Auth::user()->id)
    //     ->update([
    //         'status' => 'On Queue',
    //         'office' => $office->id,
    //         'created_by' => Auth::user()->id,
    //         'updated_at' => now(),
    //     ]);

    //     $transaction_update = Transaction::whereNull('deleted_at')
    //     ->where('status', 'On-hold')
    //     ->where('office', Auth::user()->office_id)
    //     ->where('created_by', Auth::user()->id)
    //     ->update([
    //         'office' => $office->id,
    //         'created_by' => Auth::user()->id,
    //         'updated_at' => now(),
    //     ]);

    //     //Emailing each transaction
    //     foreach ($transactions as $transaction) {
    //         if ($transaction->status === 'Processing'){
    //             $logs = new Activity_logs();
    //             $logs->trans_id = $transaction->id;
    //             $logs->office_id = Auth::user()->office_id;
    //             $logs->user_id = Auth::user()->id;
    //             $logs->save();

    //             $employee = $ibu_dbcon->table('employee_user')
    //             ->where('id', $transaction->employee_id)
    //             ->first();
    //             $employeedetails = $ibu_dbcon->table('employee')
    //             ->where('id', $transaction->employee_id)
    //             ->first();

    //             if (!empty($employee->email)) {
    //                 $emailData = [
    //                     'transaction_id' => $transaction->id,
    //                     'employee_fname' => $employeedetails->employee_fname,
    //                     'employee_lname' => $employeedetails->employee_lname,
    //                     'status' => 'On Queue',
    //                     'created_at' => now()->format('F j, Y'),
    //                     'honorarium' => $transaction->honorarium->name,
    //                     'office' => $office->name,
    //                 ];

    //                 Mail::to($employee->email)->send(new TransactionStatusChanged($emailData));
    //                 sleep(1);
    //             }

    //             $email = new Emailing();
    //             $email->transaction_id = $transaction->id;
    //             $email->subject = 'Transaction Processing';
    //             $email->to_user = $employeedetails->id;
    //             $email->message = 'The transaction for your honorarium will be acknowledged by the Budget Office. Please wait for further updates.';
    //             $email->status = 'Unread';
    //             $email->created_by = Auth::user()->id;
    //             $email->save();

    //         }

    //     }

    //     $batchId = $transaction->batch_id;

    //     return response()->json(['success' => true, 'batch_id'=> $batchId, 'message' => 'Emails sent and transactions updated.']);
    // }

    public function proceedToBudgetOffice(Request $request)
    {
        $ibu_dbcon = DB::connection('ors_pgsql');

        // Fetch all transactions with status 'Processing' or 'On-hold'
        $transactions = Transaction::with(['honorarium', 'office'])
            ->where('batch_status', '<>', 'Batch On Hold')
            ->whereNull('deleted_at')
            ->where(function($query) {
                $query->where('status', 'Processing')
                    ->orWhere('status', 'On-hold');
            })
            ->where('batch_id', '!=', NULL)
            ->where('office', Auth::user()->office_id)
            ->where('created_by', Auth::user()->id)
            ->get();

        if ($transactions->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No transactions found with status Processing or On-hold']);
        }

        // Check if any transaction has 'On-hold' status
        $hasOnHold = $transactions->where('status', 'On-hold')->isNotEmpty();

        // If there is any 'On-hold' transaction, update all transactions in the batch
        if ($hasOnHold) {
            $office = Office::where('name', 'BUGS Administration')->first();
            $batchId = $transactions->first()->batch_id;


            Transaction::where('batch_id', $batchId)
                ->whereNull('deleted_at')
                ->where('status', 'Processing')
                ->where('batch_status', '<>', 'Batch On Hold')
                ->where('office', Auth::user()->office_id)
                ->where('created_by', Auth::user()->id)
                ->update([
                    'from_office' =>  Auth::user()->office_id,
                    'batch_status' => 'Batch On Hold',
                    'requirement_status' => 'Complete',
                    'office' => $office->id,
                    'updated_at' => now(),
            ]);

            Transaction::where('batch_id', $batchId)
                ->whereNull('deleted_at')
                ->where('status', 'On-hold')
                ->where('batch_status', '<>', 'Batch On Hold')
                ->where('office', Auth::user()->office_id)
                ->where('created_by', Auth::user()->id)
                ->update([
                    'from_office' =>  Auth::user()->office_id,
                    'batch_status' => 'Batch On Hold',
                    'office' => $office->id,
                    'updated_at' => now(),
            ]);


             // Emailing each transaction
             foreach ($transactions as $transaction) {
                $logs = new Activity_logs();
                $logs->trans_id = $transaction->id;
                $logs->office_id = Auth::user()->office_id;
                $logs->user_id = Auth::user()->id;
                $logs->save();

                $employee = $ibu_dbcon->table('employee_user')
                ->where('id', $transaction->employee_id)
                ->first();
                $employeedetails = $ibu_dbcon->table('employee')
                    ->where('id', $transaction->employee_id)
                    ->first();

                if ($transaction->status === 'Processing') {
                    if (!empty($employee->email)) {
                        $emailData = [
                            'employee_fname' => $employeedetails->employee_fname,
                            'employee_lname' => $employeedetails->employee_lname,
                            'subject' => 'Transaction On-Hold ',
                            'sender_email' => Auth::user()->email, // Add sender email
                            'office_name' => $office->name,
                            'created_at' => now()->format('F j, Y'),
                            'created_by' => Auth::user()->first_name. ' ' .Auth::user()->last_name,
                        ];

                        Mail::to($employee->email)->send(new On_Hold_Email_two($emailData));
                        sleep(1);
                    }

                    $emailMessage = "
                        <div>
                            <p>Hi {$employeedetails->employee_fname} {$employeedetails->employee_lname}, 🖐</p>

                            <p><strong>Your honorarium transaction has been placed on hold due to incomplete requirements from one of the faculty members involved in the same transaction.</strong></p>

                            <p>Date On-Hold: <strong>" . now()->format('F j, Y') . "</strong></p>

                            <p>On-Hold by: <strong>" . Auth::user()->first_name . ' ' . Auth::user()->last_name . "</strong></p>

                            <p>Office of: <strong>{$office->name}</strong></p>

                            <p>For further information or clarification regarding your honorarium, please visit the Administration Office.</p>
                        </div>
                    ";

                    $email = new Emailing();
                    $email->transaction_id = $transaction->id;
                    $email->subject = 'Batch Transaction On-hold';
                    $email->to_user = $employeedetails->id;
                    $email->message = $emailMessage;
                    $email->status = 'Unread';
                    $email->created_by = Auth::user()->id;
                    $email->save();
                }

            }
        }

        // Check if any transaction has no 'On-hold' status
        $hasNoOnHold = $transactions->where('status', 'On-hold')->isEmpty();

        if ($hasNoOnHold) {
            $office = Office::where('name', 'Budget Office')->first();
            $batchId = $transactions->first()->batch_id;

            Transaction::where('batch_id', $batchId)
                ->whereNull('deleted_at')
                ->where('batch_status', '<>', 'Batch On Hold')
                ->where('status', 'Processing')
                ->where('office', Auth::user()->office_id)
                ->where('created_by', Auth::user()->id)
                ->update([
                    'status' => 'On Queue',
                    'from_office' =>  Auth::user()->office_id,
                    'office' => $office->id,
                    'created_by' => Auth::user()->id,
                    'updated_at' => now(),
            ]);

            // Emailing each transaction
            foreach ($transactions as $transaction) {
                if ($transaction->status === 'Processing') {
                    $logs = new Activity_logs();
                    $logs->trans_id = $transaction->id;
                    $logs->office_id = Auth::user()->office_id;
                    $logs->user_id = Auth::user()->id;
                    $logs->save();

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
                        sleep(1);
                    }


                    // Define the email message content as a string
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
                    $email->subject = 'Transaction Processing';
                    $email->to_user = $employeedetails->id;
                    $email->message = $emailMessage;
                    $email->status = 'Unread';
                    $email->created_by = Auth::user()->id;
                    $email->save();
                }
            }
        }

        $batchId = $transactions->first()->batch_id;

        return response()->json(['success' => true, 'batch_id'=> $batchId, 'message' => 'Emails sent and transactions updated.']);
    }

    public function proceed(Request $request)
    {
        $ibu_dbcon = DB::connection('ors_pgsql');

        // Fetch all transactions with status 'Processing'
        $transactions = Transaction::whereNull('deleted_at')
        ->where('status', 'Processing')
        ->where('office', Auth::user()->office_id)
        ->where('created_by', Auth::user()->id)
        ->where('batch_id', $request->batch_id)
        ->get();

        if ($transactions->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No transactions found with status Processing']);
        }

        $usertype = Auth::user()->usertype->name;

        if($usertype === 'Administrator' || $usertype === 'Superadmin'){
            $office = Office::where('name', 'Budget Office')->first();
        }
        elseif($usertype === 'Budget Office' || $usertype === 'Accounting' ){
            $office = Office::where('name', 'Dean')->first();
        }
        elseif($usertype === 'Dean' ){
            $office = Office::where('name', 'Accounting')->first();

        }elseif($usertype === 'Cashiers'){
            $office = Office::where('name', 'Faculty')->first();

        }elseif($usertype === 'Accounting' ){
            $office = Office::where('name', 'Dean')->first();
        }
        else{
            return response()->json(['success' => false, 'message' => 'No office Found']);
        }

        $ack = new Acknowledgement();
        $ack->batch_id= $request->batch_id;
        $ack->office_id = Auth::user()->office_id;
        $ack->user_id = Auth::user()->id;
        $ack->save();

        // Update the status to 'On Queue'
        if($usertype === 'Cashiers' ){

            Transaction::whereNull('deleted_at')
            ->where('status', 'Processing')
            ->where('office', Auth::user()->office_id)
            ->where('created_by', Auth::user()->id)
            ->where('batch_id', $request->batch_id)
            ->update([
                'status' => 'Complete',
                'from_office' =>  Auth::user()->office_id,
                'office' => $office->id,
                'created_by' => Auth::user()->id,
                'updated_at' => now(),
            ]);

        }else{

            Transaction::whereNull('deleted_at')
            ->where('status', 'Processing')
            ->where('office', Auth::user()->office_id)
            ->where('created_by', Auth::user()->id)
            ->where('batch_id', $request->batch_id)
            ->update([
                'status' => 'On Queue',
                'from_office' =>  Auth::user()->office_id,
                'office' => $office->id,
                'created_by' => Auth::user()->id,
                'updated_at' => now(),
            ]);

        }


        $batchId = $request->batch_id;

        foreach ($transactions as $transaction) {
            $logs = new Activity_logs();
            $logs->trans_id = $transaction->id;
            $logs->office_id = Auth::user()->office_id;
            $logs->user_id = Auth::user()->id;
            $logs->save();

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

            $email = new Emailing();
            $email->transaction_id = $transaction->id;
            $email->subject = 'Transaction Processing';
            $email->to_user = $employeedetails->id;
            $email->message = '';
            $email->status = 'Unread';
            $email->created_by = Auth::user()->id;
            $email->save();

        }

        return response()->json(['success' => true, 'batch_id'=> $batchId, 'message' => 'Emails sent and transactions updated.']);
    }

    public function proceedToCashier(Request $request)
    {
        $ibu_dbcon = DB::connection('ors_pgsql');

        // Fetch all transactions with status 'Processing'
        $transactions = Transaction::whereNull('deleted_at')
        ->where('status', 'Processing')
        ->where('office', Auth::user()->office_id)
        ->where('created_by', Auth::user()->id)
        ->where('batch_id', $request->batch_id)
        ->get();

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

        $usertype = Auth::user()->usertype->name;

        $office = Office::where('name','like', '%Cashier%')->first();

        $ack = new Acknowledgement();
        $ack->batch_id= $request->batch_id;
        $ack->office_id = Auth::user()->office_id;
        $ack->user_id = Auth::user()->id;
        $ack->save();



        $batchId = $request->batch_id;

        foreach ($transactions as $transaction) {
            $logs = new Activity_logs();
            $logs->trans_id = $transaction->id;
            $logs->office_id = Auth::user()->office_id;
            $logs->user_id = Auth::user()->id;
            $logs->save();

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

            $email = new Emailing();
            $email->transaction_id = $transaction->id;
            $email->subject = 'Transaction Processing';
            $email->to_user = $employeedetails->id;
            $email->message = 'The transaction for your honorarium will be acknowledged by the Budget Office. Please wait for further updates.';
            $email->status = 'Unread';
            $email->created_by = Auth::user()->id;
            $email->save();

        }

        // Update the status to 'On Queue'
        Transaction::whereNull('deleted_at')
        ->where('status', 'Processing')
        ->where('office', Auth::user()->office_id)
        ->where('created_by', Auth::user()->id)
        ->where('batch_id', $request->batch_id)
        ->update([
            'status' => 'On Queue',
            'from_office' =>  Auth::user()->office_id,
            'office' => $office->id,
            'created_by' => Auth::user()->id,
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Emails sent and transactions updated.', 'batch_id' => $batchId]);
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
        $transaction->created_by = Auth::user()->id;
        $transaction->updated_at = now();
        $transaction->remarks = $request->remarks ? $request->remarks : null;
        $transaction->save();

        return response()->json(['success' => true, 'message' => 'Transaction updated successfully.']);

    }

    public function change_to_onhold(Request $request){

        // Find the transaction by ID
        $transaction = Transaction::find($request->id);
        $ibu_dbcon = DB::connection('ors_pgsql');

        $office = Office::where('id', $transaction->office)->first();
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
                'employee_lname' => $employeedetails->employee_lname,
                'status' => 'On Hold',
                'created_at' => now()->format('F j, Y'),
                'honorarium' => $transaction->honorarium->name,
                'office' => $office->name,
            ];

            Mail::to($employee->email)->send(new TransactionStatusChanged($emailData));
        }

        $transaction->status = 'On-hold';
        $transaction->from_office = Auth::user()->office_id;
        $transaction->created_by = Auth::user()->id;
        $transaction->updated_at = now();
        $transaction->save();

        $email = new Emailing();
        $email->transaction_id = $request->id;
        $email->subject = 'Transaction Status Changed';
        $email->to_user = $employeedetails->id;
        $email->message = 'Your transaction has been on hold';
        $email->status = 'Unread';
        $email->created_by = Auth::user()->id;
        $email->save();

        return response()->json(['success' => true, 'message' => 'Transaction updated successfully.']);

    }


    public function list(Request $request)
    {
        // Fetch data from the Acknowledgement table
        $acknowledgements = collect(); // Initialize an empty collection
        DB::statement("SET SQL_MODE=''");

        if (Auth::user()->usertype->name === 'Superadmin') {
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'office_id', 'created_at', 'user_id')
                ->groupBy('batch_id', 'user_id')
                ->get();
        }elseif(Auth::user()->usertype->name === 'Admin'){
            $From_office = Office::where('name', 'BUGS Administration')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'office_id', 'created_at', 'user_id')
                ->where('office_id', Auth::user()->office_id)
                ->where('user_id', Auth::user()->id)
                ->groupBy('batch_id')
                ->get();
        }

        elseif (Auth::user()->usertype->name === 'Budget Office') {
            $From_office = Office::where('name', 'BUGS Administration')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'office_id', 'created_at', 'user_id')
                ->where('office_id', Auth::user()->office_id)
                ->groupBy('batch_id')
                ->get();

        } elseif (Auth::user()->usertype->name === 'Accounting') {
            $From_office = Office::where('name', 'Dean')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'office_id', 'created_at', 'user_id')
                ->where('office_id', $From_office->id)
                ->groupBy('batch_id')
                ->get();
        } elseif (Auth::user()->usertype->name === 'Dean') {
            $From_office_acc = Office::where('name', 'Accounting')->first();
            $From_office_BO = Office::where('name', 'Budget Office')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'office_id', 'created_at', 'user_id')
                ->where('office_id', $From_office_acc->id)
                ->orWhere('office_id', $From_office_BO->id)
                ->groupBy('batch_id')
                ->get();
        }else{
            $acknowledgements = collect();
        }

        if(Auth::user()->usertype->name === 'Admin'){
            $filteredAcknowledgements = $acknowledgements->filter(function ($acknowledgement) {
                $countTran = Transaction::whereNull('deleted_at')
                ->where('batch_id', $acknowledgement->batch_id)
                ->where('office', Auth::user()->office_id)
                ->where('created_by', Auth::user()->id)
                ->where('status', 'Processing')
                ->count();
                return $countTran > 0;
            });

        }elseif(Auth::user()->usertype->name === 'Superadmin'){
            $filteredAcknowledgements = $acknowledgements->filter(function ($acknowledgement) {
                $countTran = Transaction::whereNull('deleted_at')
                ->where('batch_id', $acknowledgement->batch_id)
                ->where('status', 'Processing')
                ->count();
                return $countTran > 0;
            });
        }
        else{
            $filteredAcknowledgements = $acknowledgements->filter(function ($acknowledgement) {
                $countTran = Transaction::whereNull('deleted_at')
                ->where('batch_id', $acknowledgement->batch_id)
                ->where('status', 'Processing')
                ->where('office', Auth::user()->office_id)
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
                    return Transaction::whereNull('deleted_at')
                    ->where('batch_id', $data->batch_id)
                    ->where('status','!=', 'On-hold')
                    ->count();
                }
                else{
                    return Transaction::whereNull('deleted_at')
                    ->where('batch_id', $data->batch_id)->where('status', 'Processing')
                    ->where('office', Auth::user()->office_id)
                    ->count();
                }

            })
            ->addColumn('created_at', function ($data) {
                return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
            })
            ->make(true);
    }


    public function OpenOnQueue(Request $request){
        // return view('administration.open_on_queue');
        $batch_id = $request->input('id');

        $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
        ->select('batch_id', 'office_id', 'created_at', 'user_id')
        ->where('batch_id', $batch_id)
        ->first();

        $TransCount = Transaction::with(['honorarium', 'createdBy'])
        ->whereNull('deleted_at')
        ->where('office', Auth::user()->office_id)
        ->where('status', 'Processing')
        ->where('batch_id', $batch_id)
        ->count();

        $office = Office::where('id', $acknowledgements->office_id)->first();

        return view('administration.open_on_queue', compact('batch_id', 'acknowledgements', 'office', 'TransCount'));
    }

    public function open_list(Request $request){

        if(Auth::user()->usertype->name === 'Superadmin'){
            $query = Transaction::with(['honorarium', 'createdBy'])->whereNull('deleted_at')->where('status', 'Processing')->where('batch_id', $request->batch_id);
        }
        elseif(Auth::user()->usertype->name === 'Admin'){
            $office = Office::where('name', 'Budget Office')->first();
            $query = Transaction::with(['honorarium', 'createdBy'])
                                    ->whereNull('deleted_at')
                                    ->where('batch_id', $request->batch_id)
                                    ->where('status','!=', 'On-hold');

        }
        elseif(Auth::user()->usertype->name === 'Budget Office'){
            $office = Office::where('name', 'Budget Office')->first();
            $query = Transaction::with(['honorarium', 'createdBy'])
                                    ->whereNull('deleted_at')
                                    ->where('office',  $office->id)
                                    ->where('batch_id', $request->batch_id)
                                    ->where('status', 'Processing');


        }elseif(Auth::user()->usertype->name === 'Dean'){
            $office = Office::where('name', 'Dean')->first();
            $query = Transaction::with(['honorarium', 'createdBy'])
                                    ->whereNull('deleted_at')
                                    ->where('status', 'Processing')
                                    ->where('batch_id', $request->batch_id)
                                    ->where('office',  $office->id);

        }elseif(Auth::user()->usertype->name === 'Accounting'){
            $office = Office::where('name', 'Accounting')->first();
            $query = Transaction::with(['honorarium', 'createdBy'])
                                    ->whereNull('deleted_at')
                                    ->where('status', 'Processing')
                                    ->where('batch_id', $request->batch_id)
                                    ->where('office',  $office->id);

        }

        $transactions = $query->get();
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

                ->addColumn('updated_at', function ($data) {
                    return $data->updated_at ? $data->updated_at->format('m-d-Y') : 'N/A';
                })

                // newly added remarks column, added last oct 4, 2024
                ->addColumn('remarks', function($data) {
                   return '';
                })

                ->addColumn('remark', function($data) {
                   return $data->remarks ?? 'No remarks';
                })

                ->addColumn('action', function($data) {
                    $usertype = Auth::user()->usertype->name;
                    if ( $usertype === 'Admin' ||  $usertype === 'Accounting' ||$usertype === 'Superadmin') {
                        $editButton = '<button type="button" class="btn btn-icon me-2 btn-label-success edit-btn"><span class="tf-icons bx bx-pencil bx-18px"></span></button>';

                    }else{
                        $editButton = '';
                    }
                    // $editButton = '<button type="button" class="btn btn-icon me-2 btn-label-success edit-btn"><span class="tf-icons bx bx-pencil bx-18px"></span></button>';
                    $on_holdButton = '<button type="button" class="btn btn-icon me-2 btn-label-danger on-hold-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" aria-controls="offcanvasEnd" id="sendEmailBtn"><span class="tf-icons bx bxs-hand bx-18px"></span></button>';

                    return '<div class="d-flex flex-row" data-id="' . $data->id . '">' . $editButton . $on_holdButton . '</div>';
                    })

                ->make(true);

    }





}
