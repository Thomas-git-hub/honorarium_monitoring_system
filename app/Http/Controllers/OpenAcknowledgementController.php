<?php

namespace App\Http\Controllers;

use App\Mail\Acknowledge;
use App\Models\Acknowledgement;
use App\Models\Activity_logs;
use App\Models\Emailing;
use App\Models\Office;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class OpenAcknowledgementController extends Controller
{
    public function open_acknowledgement(Request $request){
        $batch_id = $request->input('id');

        $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
        ->select('id','batch_id', 'office_id', 'created_at', 'user_id')
        ->where('batch_id', $batch_id)
        ->orderBy('id', 'desc')
        ->first();

        $TransCount = Transaction::with(['honorarium', 'createdBy'])
        ->where('office', Auth::user()->office_id)
        ->where('status', 'On Queue')
        ->where('batch_id', $batch_id)
        ->count();

        $office = Office::where('id', $acknowledgements->office_id)
        ->first();

        $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
        $EmailCount = $pendingMails->count();

        return view('administration.open_acknowledgement', compact('batch_id', 'acknowledgements', 'office', 'TransCount', 'EmailCount'));
    }

    public function list(Request $request){

        if(Auth::user()->usertype->name === 'Superadmin'){
            $query = Transaction::with(['honorarium', 'createdBy'])->where('status', 'On Queue')->where('batch_id', $request->batch_id);
        }else{
            $query = Transaction::with(['honorarium', 'createdBy'])
                    ->where('office',  Auth::user()->office_id)
                    ->where('batch_id', $request->batch_id)
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

            ->addColumn('created_by', function($data) {
                return $data->createdBy ? $data->createdBy->first_name  . ' ' . $data->createdBy->last_name: 'Unknown';
            })
            ->addColumn('action', function($data) {

                $usertype = Auth::user()->usertype->name;
                if ( $usertype === 'Admin' ||  $usertype === 'Accounting' ||$usertype === 'Superadmin') {
                    $editButton = '<button type="button" class="btn btn-icon me-2 btn-label-success edit-btn"><span class="tf-icons bx bx-pencil bx-18px"></span></button>';

                }else{
                    $editButton = '';
                }
                // $editButton = '<button type="button" class="btn btn-icon me-2 btn-label-success edit-btn"><span class="tf-icons bx bx-pencil bx-18px"></span></button>';
                $on_holdButton = '<button type="button" class="btn btn-icon me-2 btn-label-danger on-hold-btn"><span class="tf-icons bx bxs-hand bx-18px"></span></button>';
                return '<div class="d-flex flex-row" data-id="' . $data->id . '">' . $editButton . $on_holdButton . '</div>';
            })

            ->make(true);

    }

    public function acknowledge(Request $request){

        $transactions = Transaction::where('office', Auth::user()->office_id)
                                ->where('batch_id', $request->batchId)
                                ->where('status', 'On Queue')
                                ->get();

        $getCreateBy = Transaction::with(['user', 'createdBy'])
        ->where('office', Auth::user()->office_id)
        ->where('batch_id', $request->batchId)
        ->where('status', 'On Queue')
        ->first();

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

        $acknowledgement = Acknowledgement::where('batch_id', $request->batchId)->first();

        $ack = new Acknowledgement();
        $ack->office_id = Auth::user()->office_id;
        $ack->user_id = Auth::user()->id;
        $ack->batch_id = $acknowledgement->batch_id;
        $ack->save();

        foreach ($transactions as $batch_id) {
            Transaction::where('status', 'On Queue')
            ->where('batch_id', $transaction->batch_id)
            ->where('office', Auth::user()->office_id)
            ->update([
                'status' => 'Processing',
                'batch_id' => $ack->batch_id,
                'office' => Auth::user()->office_id,
                'created_by' => Auth::user()->id,
                'updated_at' => now(),
            ]);

        }

        if (!empty($getCreateBy->createdBy->email)) {
            $emailData = [
                'user_id' => $getCreateBy->createdBy->employee_id,
                'employee_fname' => $getCreateBy->createdBy->first_name, //user who you will send an email to
                'subject' => 'Batch Transaction was Acknowledged by ' . Auth::user()->office->name,
                'batch_id' => $ack->batch_id,
                'office' => Auth::user()->office->name,
                'action_by' => Auth::user()->first_name .  ' ' . Auth::user()->last_name, // user who is sending an email
                'message' => 'Transaction was Acknowledged',
                'sender_email' => Auth::user()->email, // Add sender email
            ];

            Mail::to($getCreateBy->createdBy->email)->send(new Acknowledge($emailData));

        }

        // Process form data
        $email = new Emailing();
        $email->subject = $emailData['subject'];
        $email->to_user = $emailData['user_id'];
        $email->message = $emailData['message'];
        $email->status = 'Unread';
        $email->created_by = Auth::user()->id;
        $email->save();


        return response()->json(['success' => true, 'message' => 'Emails sent and transactions updated.']);
    }

}
