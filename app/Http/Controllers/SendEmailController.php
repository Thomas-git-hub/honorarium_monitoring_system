<?php

namespace App\Http\Controllers;

use App\Mail\SendEmail;
use App\Models\Activity_logs;
use App\Models\Emailing;
use App\Models\Office;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SendEmailController extends Controller
{
    public function sendEmail(Request $request){
        // dd($request);
        return view('administration.send_email');
    }

    public function reply_send(Request $request){

        $validator = Validator::make($request->all(), [
            'subject' => 'required',
            'message' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false,'errors' => $validator->errors()], 422);
        }

        $ibu_dbcon = DB::connection('ibu_test');

        $employee = $ibu_dbcon->table('employee_user')
                ->where('id', $request->user_id)
                ->first();
        $employeedetails = $ibu_dbcon->table('employee')
                ->where('id', $request->user_id)
                ->first();


        if (!empty($employee->email)) {

            $emailData = [
                'user_id' => $request->user_id,
                'employee_fname' => $employeedetails->employee_fname,
                'subject' => $request->subject,
                'message' => $request->message,
                'sender_email' => Auth::user()->email, // Add sender email
            ];

            Mail::to($employee->email)->send(new SendEmail($emailData));


            // Process form data
            $email = new Emailing();
            $email->subject = $request->subject;
            $email->to_user = $request->user_id;
            $email->message = $request->message;
            $email->status = 'Unread';
            $email->created_by = Auth::user()->id;
            $email->save();
        }



        // Check for duplicate transaction
        $office = Office::where('name', 'Bugs Administration')->first();
        $existingTransaction = Transaction::where('date_of_trans', $request->date_of_trans)
            ->where('employee_id', $request->employee_id)
            ->where('office', $office->id)
            ->where('honorarium_id', $request->honorarium_id)
            ->where('sem', $request->sem)
            ->where('year', $request->year)
            ->where('month', $request->month)
            ->first();

        $transaction = null;

        if (!$existingTransaction) {
            // If no duplicate transaction exists, save the transaction
            $transaction = new Transaction();
            $transaction->date_of_trans = $request->date_of_trans;
            $transaction->employee_id = $request->employee_id;
            $transaction->office = $office->id;
            $transaction->honorarium_id = $request->honorarium_id;
            $transaction->sem = $request->sem;
            $transaction->year = $request->year;
            $transaction->month = $request->month;
            $transaction->is_complete = $request->is_complete;
            $transaction->status = 'On-hold';
            $transaction->created_by = Auth::user()->id;
            $transaction->save();

            // Log the activity
            $logs = new Activity_logs();
            $logs->trans_id = $transaction->id;
            $logs->office_id = $office->id;
            $logs->user_id = $transaction->created_by;
            $logs->save();
        }

        if ($email && $transaction) {
            $email->transaction_id = $transaction->id;
            $email->save();
        }

        return response()->json(['success' => true, 'message' => 'The transaction is on hold and the email has been sent.']);
    }

}
