<?php

namespace App\Http\Controllers;

use App\Models\Activity_logs;
use App\Models\Emailing;
use App\Models\Office;
use App\Models\Transaction;
use App\Models\Acknowledgement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    public function admin_dashboard(){

        if(Auth::user()->usertype->name !== 'Faculty'){

            $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
            $EmailCount = $pendingMails->count();

            if(Auth::user()->usertype->name === 'Administrator'){
                $OnQueue = Transaction::whereNull('deleted_at')
                ->where('created_by', Auth::user()->id)
                ->whereIn('status', ['Processing'])
                ->where('batch_id', '!=', NULL)
                ->count();
            }
            else{
                $OnQueue = Transaction::whereNull('deleted_at')
                ->where('status', 'Processing')
                ->where('created_by', Auth::user()->id)
                ->where('batch_id', '!=', NULL)
                ->count();
            }


            $OnHold = Transaction::whereNull('deleted_at')
            ->where('status', 'On-hold')
            ->where('batch_id', '!=', NULL)
            ->where('office', Auth::user()->office_id)
            ->where('created_by', Auth::user()->id)
            ->count();

            $TransactionCount = Transaction::with(['honorarium', 'createdBy'])
            ->whereNull('deleted_at')
            ->where('status', 'On Queue')
            ->where('office', Auth::user()->office_id)
            ->count();

            return view('administration.admin_dashboard', compact('EmailCount', 'OnQueue', 'OnHold', 'TransactionCount'));
        }else{
            abort(403, 'Unauthorized action.');
        }
    }

    public function admin_email(){
        $emailtoday = Emailing::whereDate('created_at', Carbon::today())
        ->where('to_user', Auth::user()->employee_id)
        ->count();

        $UnreadCount = Emailing:: where('status', 'Unread')
        ->where('to_user', Auth::user()->employee_id)
        ->count();

        $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
        $EmailCount = $pendingMails->count();

        $TransactionCount = Transaction::with(['honorarium', 'createdBy'])
        ->whereNull('deleted_at')
        ->where('status', 'On Queue')
        ->where('office', Auth::user()->office_id)
        ->count();

        return view('administration.admin_email', compact('emailtoday', 'UnreadCount', 'EmailCount', 'TransactionCount'));
    }

    public function admin_open_email(Request $request){
        $id = $request->input('id');
        $data = Emailing::with('employee')->where('id', $id)->first();

        $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
        $EmailCount = $pendingMails->count();

        $TransactionCount = Transaction::with(['honorarium', 'createdBy'])
        ->whereNull('deleted_at')
        ->where('status', 'On Queue')
        ->where('office', Auth::user()->office_id)
        ->count();

        $docuJson = json_decode($data->documentation);


        return view('administration.admin_open_email', compact('data', 'docuJson', 'EmailCount', 'TransactionCount'));
    }

    public function admin_faculty(){

        if(Auth::user()->usertype->name === 'Administrator' || Auth::user()->usertype->name === 'SuperAdmin'){
            $today = Carbon::today();
            $employeeIds = DB::connection('ibu_test')->table('employee_user')->pluck('id');
            $newAccountsToday = DB::connection('mysql')->table('users')
                ->whereDate('created_at', $today)
                ->whereNull('deleted_at')
                ->whereIn('employee_id', $employeeIds)
                ->count();

            $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
            $EmailCount = $pendingMails->count();

            $TransactionCount = Transaction::with(['honorarium', 'createdBy'])
            ->whereNull('deleted_at')
            ->where('status', 'On Queue')
            ->where('office', Auth::user()->office_id)
            ->count();

                return view('administration.admin_faculty', compact('newAccountsToday', 'EmailCount', 'TransactionCount'));

        }else{
            abort(403, 'Unauthorized action.');
        }

    }

    public function admin_view_faculty(Request $request){

        $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
        $EmailCount = $pendingMails->count();

        $id = $request->query('id');
        $ibu_dbcon = DB::connection('ibu_test');
        $user = $ibu_dbcon->table('employee')->where('id', $id )->first();
        // Transaction::findOrFail($id);

        $collegeDetails = DB::connection('ibu_test')->table('college')
                ->where('id', $user->college_id)
                ->first();

        if(!empty($collegeDetails)){
            $college = $collegeDetails->college_name;
        }
        else{
            $college = 'No Assigned College';
        }

        return view('administration.admin_view_faculty', compact('user', 'college', 'EmailCount'));
    }


    public function admin_honorarium(){

        if(Auth::user()->usertype->name === 'Administrator' || Auth::user()->usertype->name === 'SuperAdmin'){
            $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
            $EmailCount = $pendingMails->count();
            return view('administration.admin_honorarium', compact('EmailCount'));
        }else{
            abort(403, 'Unauthorized action.');
        }
    }

    /* ---------------------------------------NEW ENTRIES FUNCTIONS-------------------------------------------- */
    public function admin_new_entries(){

        if(Auth::user()->usertype->name === 'Administrator' || Auth::user()->usertype->name === 'SuperAdmin'){

            $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
            $EmailCount = $pendingMails->count();

            $onQueue = Transaction::whereNull('deleted_at')
                ->where('batch_status', '<>', 'Batch On Hold')
                ->where('office', Auth::user()->office_id)
                ->where('created_by', Auth::user()->id)
                ->whereIn('status', ['Processing'])
                ->count();
            return view('administration.admin_new_entries', compact('onQueue', 'EmailCount'));
        }else{

            abort(403, 'Unauthorized action.');
        }
    }


    public function submitForm(Request $request)
    {
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
        $transaction->from_office = Auth::user()->office_id;
        $transaction->honorarium_id = $request->honorarium_id;
        $transaction->sem = $request->sem;
        $transaction->year = $request->year;
        $transaction->month = $request->month;
        $transaction->is_complete = $request->is_complete;
        $transaction->status = 'Processing';
        $transaction->created_by = Auth::user()->id;
        $transaction->save();

        $logs = new Activity_logs();
        $logs->trans_id = $transaction->id;
        $logs->office_id = Auth::user()->office_id;
        $logs->user_id = $transaction->created_by;
        $logs->save();


        return response()->json(['success' => true, 'message' => 'Form submitted successfully.']);
    }

    public function submitOnHold(Request $request)
    {
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

    public function admin_on_queue(){

        if(Auth::user()->usertype->name === 'Faculty'){

            abort(403, 'Unauthorized action.');

        }else{

            $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
            $EmailCount = $pendingMails->count();

            $TransactionCount = Transaction::with(['honorarium', 'createdBy'])
            ->whereNull('deleted_at')
            ->where('status', 'On Queue')
            ->where('office', Auth::user()->office_id)
            ->count();



            if(Auth::user()->usertype->name === 'Administrator'){
                $onQueue = Transaction::whereNull('deleted_at')
                ->where('status', 'Processing')
                ->orWhere('status', 'On Queue')
                // ->where('created_by', Auth::user()->id)
                ->where('batch_id', '!=', NULL)
                ->count();
            }
            else{
                $onQueue = Transaction::where('status', 'Processing')
                ->where('created_by', Auth::user()->id)
                ->where('batch_id', '!=', NULL)
                ->count();

            }
            return view('administration.admin_on_queue', compact('onQueue', 'EmailCount', 'TransactionCount'));
        }




    }

    public function admin_on_hold(Request $request){
        if(Auth::user()->usertype->name === 'Faculty'){

            abort(403, 'Unauthorized action.');

        }else{

            $batch_id = $request->input('id');

            $TransactionCount = Transaction::with(['honorarium', 'createdBy'])
            ->whereNull('deleted_at')
            ->where('batch_status', 'Batch On Hold')
            ->count();

            $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
            $EmailCount = $pendingMails->count();

            $OnHold = Transaction::whereNull('deleted_at')
            ->whereNull('deleted_at')
            ->where('batch_status', 'Batch On Hold')
            ->where('batch_id', $batch_id)
            ->count();

            $OnHoldData = Transaction::with(['createdBy', 'office'])
            ->whereNull('deleted_at')
            ->where('batch_status', 'Batch On Hold')
            ->where('batch_id', $batch_id)
            ->first();

            $office = Office::where('id', $OnHoldData->office)->first();
            
            return view('administration.admin_on_hold', compact('OnHold', 'EmailCount', 'TransactionCount', 'OnHoldData', 'office'));

        }
    }

    public function list(Request $request)
    {
        if(Auth::user()->usertype->name === 'Superadmin'){
            $bugs_office = Office::where('name', 'BUGS Administration')->first();
            $query = Transaction::with(['honorarium', 'createdBy'])
            ->whereNull('deleted_at')
            ->where('batch_status', '<>', 'Batch On Hold')
            ->where('office', $bugs_office->id)
            ->whereIn('status', ['Processing', 'On-hold']);

        }
        else{

            $bugs_office = Office::where('name', 'BUGS Administration')->first();
            $query = Transaction::with(['honorarium', 'createdBy'])
            ->whereNull('deleted_at')
            ->where('batch_status', '<>', 'Batch On Hold')
            ->where('office', $bugs_office->id)
            ->where('created_by', Auth::user()->id)
            ->whereIn('status', ['Processing', 'On-hold']);

           ;


        };
        // elseif(Auth::user()->usertype->name === 'Budget Office'){
        //     $From_office = Office::where('name', 'BUGS Administration')->first();
        //     $query = Transaction::with(['honorarium', 'createdBy'])
        //     ->where('status', 'Processing')
        //     ->where('created_by', Auth::user()->id);

        // }elseif(Auth::user()->usertype->name === 'Dean'){
        //     $From_office = Office::where('name', 'Budget Office')->first();
        //     $query = Transaction::with(['honorarium', 'createdBy'])
        //     ->where('status', 'Processing')
        //     ->where('created_by', Auth::user()->id);

        // }elseif(Auth::user()->usertype->name === 'Accounting' || Auth::user()->usertype->name === 'Cashiers'){
        //     $From_office = Office::where('name', 'Dean')->first();
        //     $query = Transaction::with(['honorarium', 'createdBy'])
        //     ->where('status', 'Processing')
        //     ->where('created_by', Auth::user()->id);


        // }elseif(Auth::user()->usertype->name === 'Dean'){
        //     $From_office_acc = Office::where('name', 'Accounting')->first();
        //     $From_office_BO = Office::where('name', 'Budget Office')->first();
        //     $query = Transaction::with(['honorarium', 'createdBy'])
        //     ->where('status', 'Processing')
        //     ->where('created_by', Auth::user()->id);
        // }

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

            ->addColumn('status', function($data) {
                return $data->status;
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
                $deleteButton = '<button type="button" class="btn btn-icon me-2 btn-label-danger delete-btn"><span class="tf-icons bx bxs-trash bx-18px"></span></button>';

                return '<div class="d-flex flex-row" data-id="' . $data->id . '">' . $deleteButton . '</div>';
            })

            ->make(true);
    }

    public function generate_trackingNum(Request $request){

        $transactions = Transaction::whereNull('deleted_at')
        ->where('batch_status', '<>', 'Batch On Hold')
        ->where('office', Auth::user()->office_id)
        // whereNull('batch_id')
        ->where('created_by', Auth::user()->id)
        ->get();



        // if ($transactions->isEmpty()) {
        //     return response()->json(['success'=> false, 'message' => 'No transactions found']);
        // }

        if ($transactions->isEmpty()) {
            // Find the last batch_id
            $lastBatch = Transaction::whereNotNull('batch_id')
                ->where('batch_status', '<>', 'Batch On Hold')
                ->where('status', '<>', 'On Queue')
                ->orderBy('batch_id', 'desc')
                ->first();

            if ($lastBatch) {
                $lastBatchCreatedAt = $lastBatch->created_at->format('F j, Y');

                // Count transactions with the status 'processing' for the new batch_id
                $processingTransactions = Transaction::whereNull('deleted_at')
                ->where('batch_status', '<>', 'Batch On Hold')
                ->where('batch_id', $lastBatch->batch_id)
                ->where('status', 'processing') // Adjust the 'status' value based on your actual column values
                ->count();

                $onHoldTransactions = Transaction::whereNull('deleted_at')
                ->where('batch_status', '<>', 'Batch On Hold')
                ->where('batch_id', $lastBatch->batch_id)
                ->where('status', 'On-hold') // Adjust the 'status' value based on your actual column values
                ->count();

                return response()->json([
                    'success' => false,
                    'message' => 'No transactions found',
                    'last_batch_id' => $lastBatch->batch_id, // Return last generated batch_id
                    'processing_transactions' => $processingTransactions, // Count of processing transactions
                    'onhold_transactions' => $onHoldTransactions, // Count of processing transactions
                    'date' => $lastBatchCreatedAt // Count of processing transactions
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No transactions and no batch_id found'
                ]);
            }
        }

        // Find the last batch_id to increment the number part
        $lastBatch = Transaction::whereNull('deleted_at')
            ->whereNotNull('batch_id')
            ->orderBy('batch_id', 'desc')
            ->first();


        $lastNumber = 0;
        if ($lastBatch) {
            // Extract the number before the dash
            $batchParts = explode(' - ', $lastBatch->batch_id);
            $lastNumber = intval($batchParts[0]);
        }

        // Increment the batch number
        $newNumber = $lastNumber + 1;


        // Format the current date as 'mdy'
        $date = now()->format('mdy');

        // Generate the new batch_id
        $newBatchId = "00{$newNumber} - {$date}";

        foreach ($transactions as $transaction) {
            $transaction->batch_id = $newBatchId;
            $transaction->save();
        }

        $ack = new Acknowledgement();
        $ack->batch_id= $newBatchId;
        $ack->office_id = Auth::user()->office_id;
        $ack->user_id = Auth::user()->id;
        $ack->save();


        // Count total transactions for the new batch_id
        $totalTransactions = Transaction::whereNull('deleted_at')
                                ->where('batch_id', $newBatchId)->count();

        // Count transactions with the status 'processing' for the new batch_id
        $processingTransactions = Transaction::whereNull('deleted_at')
            ->where('batch_status', '<>', 'Batch On Hold')
            ->where('batch_id', $newBatchId)
            ->where('status', 'processing') // Adjust the 'status' value based on your actual column values
            ->count();

        $onHoldTransactions = Transaction::whereNull('deleted_at')
            ->where('batch_status', '<>', 'Batch On Hold')
            ->where('batch_id', $newBatchId)
            ->where('status', 'On-hold') // Adjust the 'status' value based on your actual column values
            ->count();

            return response()->json([
                'success' => true,
                'message' => 'Tracking Number generated successfully',
                'batch_id' => $newBatchId,
                'total_transactions' => $totalTransactions, // Total transactions count
                'processing_transactions' => $processingTransactions, // Count of processing transactions
                'onhold_transactions' => $onHoldTransactions // Count of processing transactions
            ]);

    }

    public function Getadmin_new_entries(){

        $onQueue = Transaction::whereNull('deleted_at')
            ->where('office', Auth::user()->office_id)
            ->whereIn('status', ['Processing', 'On-hold'])
            ->count();
        return response()->json([
            'onQueue' => $onQueue,

        ]);
    }


    public function getadmin_email(){
        $emailtoday = Emailing::whereDate('created_at', Carbon::today())
        ->where('deleted_by', '=', NULL)
        ->where('to_user', Auth::user()->employee_id)
        ->count();

        $UnreadCount = Emailing::where('deleted_by', '=', NULL)
        ->where('status', 'Unread')
        ->where('to_user', Auth::user()->employee_id)
        ->count();

        return response()->json([
            'emailtoday' => $emailtoday,
            'UnreadCount' => $UnreadCount,

        ]);
    }

    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'id' => 'required|exists:org_otc,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 200);
        }

        $ifExist = Transaction::whereNull('deleted_at')->where('id', $request->id)->exists();

        if($ifExist){
            $trans = Transaction::findOrFail($request->id);
            $trans->created_by = Auth::user()->id;
            $trans->updated_at = now();
            $trans->delete();

        }else{
            return response()->json(['success' => false, 'errors' => 'The transaction does not exist']);
        }



        return response()->json(['success' => true, 'message' => 'Transaction deleted successfully']);
    }

}
