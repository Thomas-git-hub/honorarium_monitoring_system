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
use Yajra\DataTables\Facades\DataTables;

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

        $ibu_dbcon = DB::connection('ors_pgsql');

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
        }

        // Process form data
        $email = new Emailing();
        $email->subject = $request->subject;
        $email->to_user = $request->user_id;
        $email->message = $request->message;
        $email->status = 'Unread';
        $email->created_by = Auth::user()->id;
        $email->save();

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


    public function getEmails(Request $request)
    {
        // Query to get transactions with status 'On-hold'
        $emails = Emailing::with('employee')
        ->where('to_user', Auth::user()->employee_id)
        // ->where('status', '!=', 'Deleted')
        ->where(function($query) {
            $query->whereNull('deleted_by')
                  ->orWhere('deleted_by', '!=', Auth::user()->employee_id); // Show only emails not deleted by the user
        })
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
        return DataTables::of($emails)
            ->addColumn('id', function ($data) {
                return $data->id;
            })
            ->addColumn('name', function ($data) {
                return $data->employee->first_name. ' ' .$data->employee->last_name;
            })
            ->addColumn('subject', function ($data) {
                return $data->subject;
            })
            ->addColumn('date', function ($data) {
                return $data->created_at->format('m/d/Y');
            })

            ->make(true);
    }

    public function updateStatus(Request $request)
    {
        $email = Emailing::find($request->id);

        if ($email) {
            $email->status = 'Read'; // Assuming you have a 'status' column in the emailing table
            $email->save();
            return response()->json(['success' => true, 'message' => 'Email status updated to Read']);
        }

        return response()->json(['success' => false, 'message' => 'Email not found'], 404);
    }

    public function deleteEmails(Request $request)
    {
        $ids = $request->input('ids');

        if (empty($ids)) {
            return response()->json(['success' => false, 'message' => 'No emails selected for deletion']);
        }

        // Update the status of the selected emails to "Deleted"
        Emailing::whereIn('id', $ids)
        ->where('to_user', Auth::user()->employee_id)  // Ensure the user is deleting their own emails
        ->update(
            [
                'deleted_by' => Auth::user()->employee_id, // Track which user deleted the email
                'updated_at' => now(),
            ]
        );
        return response()->json(['success' => true, 'message' => 'Emails deleted successfully']);
    }

}
