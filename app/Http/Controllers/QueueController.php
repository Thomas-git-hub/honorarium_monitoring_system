<?php

namespace App\Http\Controllers;

use App\Mail\TransactionStatusChanged;
use App\Models\Acknowledgement;
use App\Models\Activity_logs;
use App\Models\Emailing;
use App\Models\Office;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class QueueController extends Controller
{

    public function proceedToBudgetOffice(Request $request)
    {
        $ibu_dbcon = DB::connection('ors_pgsql');

        // Fetch all transactions with status 'Processing'
        $transactions = Transaction::where('status', 'Processing')
        ->where('office', Auth::user()->office_id)
        ->where('created_by', Auth::user()->id)
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

        if($usertype === 'Admin' || $usertype === 'Superadmin'){
            $office = Office::where('name', 'Budget Office')->first();
        }
        elseif($usertype === 'Budget Office' || $usertype === 'Accounting' ){
            $office = Office::where('name', 'Dean')->first();
        }
        elseif($usertype === 'Dean' ){
            $office = Office::where('name', 'Accounting')->first();
        }elseif($usertype === 'Cashiers'){
            $office = Office::where('name', 'Faculty')->first();
        }else{
            return response()->json(['success' => false, 'message' => 'No office Found']);
        }


        if (is_null($transaction->batch_id)) {
            $ack = new Acknowledgement();
            $ack->trans_id = $transaction->id;
            $ack->office_id = Auth::user()->office_id;
            $ack->user_id = Auth::user()->id;
            $ack->save();

            // Update the batch_id after saving
            $ack->batch_id = '00'. $ack->id . '-' . $ack->created_at->format('mdY');
            $ack->save();

            // Update the status to 'On Queue'
            Transaction::where('status', 'Processing')
            ->where('office', Auth::user()->office_id)
            ->where('created_by', Auth::user()->id)
            ->update([
                'status' => 'On Queue',
                'batch_id' => $ack->batch_id,
                'office' => $office->id,
                'created_by' => Auth::user()->id,
            ]);

            $transaction->batch_id = $ack->batch_id;
            $batchId = $transaction->batch_id;
        }else{


            // Update the status to 'On Queue'
            Transaction::where('status', 'Processing')
            ->where('office', Auth::user()->office_id)
            ->where('created_by', Auth::user()->id)
            ->update([
                'status' => 'On Queue',
                'office' => $office->id,
                'created_by' => Auth::user()->id,
            ]);

            $batchId = $transaction->batch_id;

        }
        return response()->json(['success' => true, 'batch_id'=> $batchId, 'message' => 'Emails sent and transactions updated.']);
    }

    public function proceedToCashier(Request $request)
    {
        $ibu_dbcon = DB::connection('ors_pgsql');

        // Fetch all transactions with status 'Processing'
        $transactions = Transaction::where('status', 'Processing')
        ->where('office', Auth::user()->office_id)
        ->where('created_by', Auth::user()->id)
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

        if (is_null($transaction->batch_id)) {
            $ack = new Acknowledgement();
            $ack->trans_id = $transaction->id;
            $ack->office_id = Auth::user()->office_id;
            $ack->user_id = Auth::user()->id;
            $ack->save();

            // Update the batch_id after saving
            $ack->batch_id = '00'. $ack->id . '-' . $ack->created_at->format('mdY');
            $ack->save();

            // Update the status to 'On Queue'
            Transaction::where('status', 'Processing')
            ->where('office', Auth::user()->office_id)
            ->where('created_by', Auth::user()->id)
            ->update([
                'status' => 'On Queue',
                'batch_id' => $ack->batch_id,
                'office' => $office->id,
                'created_by' => Auth::user()->id,
            ]);
        }else{
            // Update the status to 'On Queue'
            Transaction::where('status', 'Processing')
            ->where('office', Auth::user()->office_id)
            ->where('created_by', Auth::user()->id)
            ->update([
                'status' => 'On Queue',
                'office' => $office->id,
                'created_by' => Auth::user()->id,
            ]);

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
        $transaction->created_by =Auth::user()->id;
        $transaction->save();

        return response()->json(['success' => true, 'message' => 'Transaction updated successfully.']);

    }

    public function change_to_onhold(Request $request){

        // Find the transaction by ID
        $transaction = Transaction::find($request->id);
        $ibu_dbcon = DB::connection('ors_pgsql');
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
        if(Auth::user()->usertype->name === 'Superadmin'){
            $query = Transaction::with(['honorarium', 'createdBy'])->where('status', 'Processing');

        }
        elseif(Auth::user()->usertype->name === 'Admin'){
            $From_office = Office::where('name', 'BUGS Administration')->first();
            $query = Transaction::with(['honorarium', 'createdBy'])
            ->where('status', 'Processing')
            ->where('created_by', Auth::user()->id);

        }elseif(Auth::user()->usertype->name === 'Budget Office'){
            $From_office = Office::where('name', 'BUGS Administration')->first();
            $query = Transaction::with(['honorarium', 'createdBy'])
            ->where('status', 'Processing')
            ->where('created_by', Auth::user()->id);

        }elseif(Auth::user()->usertype->name === 'Dean'){
            $From_office = Office::where('name', 'Budget Office')->first();
            $query = Transaction::with(['honorarium', 'createdBy'])
            ->where('status', 'Processing')
            ->where('created_by', Auth::user()->id);

        }elseif(Auth::user()->usertype->name === 'Accounting' || Auth::user()->usertype->name === 'Cashiers'){
            $From_office = Office::where('name', 'Dean')->first();
            $query = Transaction::with(['honorarium', 'createdBy'])
            ->where('status', 'Processing')
            ->where('created_by', Auth::user()->id);


        }elseif(Auth::user()->usertype->name === 'Dean'){
            $From_office_acc = Office::where('name', 'Accounting')->first();
            $From_office_BO = Office::where('name', 'Budget Office')->first();
            $query = Transaction::with(['honorarium', 'createdBy'])
            ->where('status', 'Processing')
            ->where('created_by', Auth::user()->id);
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
            ->addColumn('batch_id', function($data) {
                return $data->batch_id ? $data->batch_id: 'No Batch ID Found';
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
