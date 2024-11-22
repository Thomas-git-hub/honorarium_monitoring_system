<?php

namespace App\Http\Controllers;

use App\Models\Amount;
use App\Models\Office;
use App\Models\ThesisLogs;
use App\Models\ThesisTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ThesisOpenOutGoingController extends Controller
{
    public function showThesisOpenOutGoing(Request $request)
    {

        $tracking_number = $request->input('id');

        $thesisLogs = ThesisLogs::with(['user', 'office', 'transaction'])
        ->select('tracking_number', 'office_id', 'created_at', 'user_id')
        ->where('tracking_number', $tracking_number)
        ->first();

        $TransCount = ThesisTransaction::with([ 'createdBy'])
        ->whereNull('deleted_at')
        ->where('created_on', Auth::user()->office_id)
        ->whereIn('status', ['Processing', 'On-hold'])
        ->where('tracking_number', $tracking_number)
        ->count();


        $office = Office::where('id', $thesisLogs->created_on)->first();

        return view('administration.thesis_open_out_going', compact('tracking_number', 'thesisLogs', 'office', 'TransCount'));
    }

    public function open_list(Request $request){

        if(Auth::user()->usertype->name === 'Superadmin'){
            $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn', 'adviser', 'chairperson'])
            ->whereNull('deleted_at')
            ->where('status', 'processing')
            ->where('tracking_number', $request->tracking_number);
        }else{
            $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn', 'adviser', 'chairperson'])
                    ->whereNull('deleted_at')
                    ->where('updated_on',  Auth::user()->office_id)
                    ->where('tracking_number', $request->tracking_number)
                    ->where('status', 'processing');
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

            ->addColumn('student', function($data) {
                return $data->student_id ? ucfirst($data->student->first_name) . ' ' . ucfirst($data->student->last_name) : 'N/A';
            })

            ->editColumn('defense_date', function($data) {
                return $data->defense_date;
            })
            ->editColumn('defense_time', function($data) {
                return $data->defense_time;
            })

            ->addColumn('orNumber', function($data) {
                return $data->or_number;
            })

            ->addColumn('degree', function($data) {
                return $data->degree_id ? ucfirst($data->degree->name) : 'N/A';
            })

            ->addColumn('defense', function($data) {
                return $data->defense_id ? ucfirst($data->defense->name) : 'N/A';
            })

            ->addColumn('adviser', function($data) use($ibu_dbcon) {
                return $data->adviser_id ? ucfirst($data->adviser->first_name) . ' ' . ucfirst($data->adviser->last_name) : 'N/A';

            })

            ->addColumn('chairperson', function($data) use($ibu_dbcon) {
                return $data->chairperson_id ? ucfirst($data->chairperson->first_name) . ' ' . ucfirst($data->chairperson->last_name) : 'N/A';

            })


            ->addColumn('recorder', function($data) {
                return $data->recorder_id ? ucfirst($data->recorder->first_name) . ' ' . ucfirst($data->recorder->last_name) : 'N/A';
            })

            ->editColumn('created_by', function($data) {
                return $data->created_by ? ucfirst($data->createdBy->first_name) . ' ' . ucfirst($data->createdBy->last_name) : 'N/A';
            })

            ->editColumn('created_on', function($data) {
                return $data->created_on ? ucfirst($data->createdOn->name) : 'N/A';
            })

            ->editColumn('membersCount', function($data) {
                return count(json_decode($data->member_ids));
            })

            ->editColumn('date', function ($data) {
                return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
            })
            ->make(true);

    }

    public function fetchTransactionDetails(Request $request)
    {
        $tracking_number = $request->input('tracking_number');

        $thesisLogs = ThesisLogs::with(['user', 'office', 'transaction'])
        ->select('tracking_number', 'office_id', 'created_at', 'user_id')
        ->where('tracking_number', $tracking_number)
        ->first();

        $TransCount = ThesisTransaction::with(['createdBy'])
        ->whereNull('deleted_at')
        ->where('updated_on', Auth::user()->office_id)
        ->whereIn('status', ['Processing', 'On-hold'])
        ->where('tracking_number', $tracking_number)
        ->count();

        $office = Office::where('id', $thesisLogs->office_id)->first();

        $transactionDetails = ThesisTransaction::where('tracking_number', $tracking_number)
            ->with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn', 'adviser', 'chairperson'])
            ->first();

        return response()->json([
            'thesisLogs' => $thesisLogs,
            'TransCount' => $TransCount,
            'office' => $office,
            'transactionDetails' => $transactionDetails,
            'tracking_number' => $tracking_number
        ]);
    }

    public function getHonorariumData(Request $request)
    {
        $id = $request->input('id');

        // Fetch the thesis transaction details
        $transaction = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'adviser', 'chairperson'])
            ->where('id', $id)
            ->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Fetch amounts for adviser, chairperson, recorder
        $adviserAmount = Amount::where('transaction_id', $id)->where('adviser_id', $transaction->adviser_id)->value('amount');
        $chairpersonAmount = Amount::where('transaction_id', $id)->where('chairperson_id', $transaction->chairperson_id)->value('amount');
        $recorderAmount = Amount::where('transaction_id', $id)->where('recorder_id', $transaction->recorder_id)->value('amount');

        // Fetch members if member_ids are present
        $members = [];
        if ($transaction->member_ids) {
            $memberIds = json_decode($transaction->member_ids);
            $members = DB::table('thesis_member')->whereIn('id', $memberIds)->get();
        }

        // Fetch amounts for members
        $memberAmounts = [];
        foreach ($members as $member) {
            $memberAmounts[$member->id] = Amount::where('transaction_id', $id)->where('member_id', $member->id)->value('amount');
        }

        return response()->json([
            'transaction' => $transaction,
            'members' => $members,
            'adviser_amount' => $adviserAmount,
            'chairperson_amount' => $chairpersonAmount,
            'recorder_amount' => $recorderAmount,
            'member_amounts' => $memberAmounts,
        ]);
    }

    public function submitAmount(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:thesis_transaction,id',
            'adviser_amount' => 'required|numeric',
            'chairperson_amount' => 'required|numeric',
            'recorder_amount' => 'required|numeric',
            'member_ids' => 'array',
            'member_ids.*' => 'required|numeric',
        ]);

        // Update or create adviser amount
        if($request->adviser_id){
            Amount::updateOrCreate(
                ['transaction_id' => $request->transaction_id, 'adviser_id' => $request->adviser_id],
                [
                    'amount' => $request->adviser_amount, 
                    'updated_by' => Auth::user()->id,
                    'created_by' => Auth::user()->id,
                ]
            );
        }

        // Update or create chairperson amount
        if($request->chairperson_id){
            Amount::updateOrCreate(
                ['transaction_id' => $request->transaction_id, 'chairperson_id' => $request->chairperson_id],
                [
                    'amount' => $request->chairperson_amount, 
                    'updated_by' => Auth::user()->id,
                    'created_by' => Auth::user()->id,
                ]
            );
        }

        // Update or create recorder amount
        if($request->recorder_id){
            Amount::updateOrCreate(
                ['transaction_id' => $request->transaction_id, 'recorder_id' => $request->recorder_id],
                [
                    'amount' => $request->recorder_amount, 
                    'updated_by' => Auth::user()->id,
                    'created_by' => Auth::user()->id,
                ]
            );
        }

        // Update or create member amounts
        if ($request->member_ids) {
            foreach ($request->member_ids as $memberId => $amount) {
                Amount::updateOrCreate(
                    ['transaction_id' => $request->transaction_id, 'member_id' => $memberId],
                    [
                        'amount' => $amount,
                        'updated_by' => Auth::user()->id,
                        'created_by' => Auth::user()->id
                    ]
                );
            }
        }
    
        return response()->json(['message' => 'Honorarium amounts saved successfully!']);
    }

    public function proceedByTN(Request $request)
    {
        // Fetch all transactions with status 'Processing'
        $transactions = ThesisTransaction::whereNull('deleted_at')
        ->where('status','processing')
        ->where('updated_on', Auth::user()->office_id)
        ->where('updated_by', Auth::user()->id)
        ->where('tracking_number', $request->tracking_number)
        ->get();

        if ($transactions->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No transactions found with status Processing']);
        }

        $usertype = Auth::user()->usertype->name;

        
        if($usertype === 'Administrator'){
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
        $batchId = $transactions->first()->tracking_number;
        $ack = new ThesisLogs();
        $ack->tracking_number= $request->tracking_number;
        $ack->office_id = Auth::user()->office_id;
        $ack->user_id = Auth::user()->id;
        $ack->save();

        // Update the status to 'On Queue'
        if($usertype === 'Cashiers' ){

            ThesisTransaction::whereNull('deleted_at')
            ->where('tracking_number', $batchId)
            ->where('status', 'processing')
            ->where('updated_on', Auth::user()->office_id)
            ->where('updated_by', Auth::user()->id)
            ->update([
                'status' => 'Complete',
                'updated_on' =>  $office->id,
                'updated_by' => Auth::user()->id,
                'updated_at' => now(),
            ]);

        }else{

            ThesisTransaction::whereNull('deleted_at')
            ->where('tracking_number', $batchId)
            ->where('status', 'processing')
            ->where('updated_on', Auth::user()->office_id)
            ->where('updated_by', Auth::user()->id)
            ->update([
                'status' => 'On Queue',
                'created_on' =>  Auth::user()->office_id,
                'updated_on' =>  $office->id,
                'updated_by' => Auth::user()->id,
                'updated_at' => now(),
            ]);

        }

       

        return response()->json(['success' => true, 'batch_id'=> $batchId, 'message' => 'Thesis transaction forwarded successfully']);
    }

    public function checkIfProceedToCashier(Request $request)
    {
        $batchId = $request->input('batch_id');
        $user = Auth::user();
        $accountingOfficeId = Office::where('name', 'Accounting')->first()->id;

        // Check if the batch is already acknowledged by Accounting
        $ThesisLogs = ThesisLogs::where('tracking_number', $batchId)
            ->where('office_id', $accountingOfficeId)
            ->exists();

        // Check if the user is a Dean
        $isDean = $user->usertype->name === 'Dean';

        return response()->json([
            'canProceedToCashier' => $ThesisLogs && $isDean
        ]);
    }

    public function proceedToCashier(Request $request)
    {
        $ibu_dbcon = DB::connection('ibu_test');

        // Fetch all transactions with status 'Processing'
        $transactions = ThesisTransaction::whereNull('deleted_at')
        ->where('status', 'processing')
        ->where('updated_on', Auth::user()->office_id)
        ->where('created_by', Auth::user()->id)
        ->where('tracking_number', $request->batch_id)
        ->get();

        if ($transactions->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No transactions found with status Processing']);
        }


        $usertype = Auth::user()->usertype->name;

        $office = Office::where('name','like', '%Cashier%')->first();

        $logs = new ThesisLogs();
        $logs->tracking_number= $request->batch_id;
        $logs->office_id = Auth::user()->office_id;
        $logs->user_id = Auth::user()->id;
        $logs->save();

        $batchId = $request->batch_id;
        // Update the status to 'On Queue'
        ThesisTransaction::whereNull('deleted_at')
        ->where('status', 'processing')
        ->where('updated_on', Auth::user()->office_id)
        ->where('created_by', Auth::user()->id)
        ->where('tracking_number', $request->batch_id)
        ->update([
            'status' => 'On Queue',
            'created_on' =>  Auth::user()->office_id,
            'updated_on' => $office->id,
            'created_by' => Auth::user()->id,
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Emails sent and transactions updated.', 'batch_id' => $batchId]);
    }

}
