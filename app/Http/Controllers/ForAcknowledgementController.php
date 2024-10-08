<?php

namespace App\Http\Controllers;

use App\Models\Acknowledgement;
use App\Models\Emailing;
use App\Models\Office;
use App\Models\Transaction;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ForAcknowledgementController extends Controller
{
    public function for_acknowledgement(request $request)
    {
        if(Auth::user()->usertype->name !== 'Faculty'){
            $TransCountToday = Transaction::with(['honorarium', 'createdBy'])
                                    ->whereNull('deleted_at')
                                    ->where('status', 'On Queue')
                                    ->where('office', Auth::user()->office_id)
                                    ->whereDate('created_at', Carbon::today())
                                    ->count();
            $yesterday = Carbon::yesterday()->format('Y-m-d');

            $TransCountYesterday = Transaction::with(['honorarium', 'createdBy'])
                ->whereNull('deleted_at')
                ->where('status', 'On Queue')
                ->where('office', Auth::user()->office_id)
                ->whereDate('updated_at', $yesterday)
                ->count();

            $TransCountDaysAgo = Transaction::with(['honorarium', 'createdBy'])
                ->whereNull('deleted_at')
                ->where('status', 'On Queue')
                ->where('office', Auth::user()->office_id)
                ->whereDate('updated_at', '<', now()->subDays(1))
                ->whereDate('updated_at', '>=', now()->subDays(7))
                ->count();

            $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
            $EmailCount = $pendingMails->count();

            $TransactionCount = Transaction::with(['honorarium', 'createdBy'])
            ->whereNull('deleted_at')
            ->where('status', 'On Queue')
            ->where('office', Auth::user()->office_id)
            ->count();

            return view('administration.for_acknowledgement', compact('TransCountToday', 'TransCountYesterday', 'TransCountDaysAgo', 'EmailCount', 'TransactionCount'));

        }else{
            abort(403, 'Unauthorized action.');
        }
    }

    public function list(Request $request)
    {
        // Fetch data from the Acknowledgement table
        $acknowledgements = collect(); // Initialize an empty collection
        DB::statement("SET SQL_MODE=''");

        if (Auth::user()->usertype->name === 'Superadmin') {
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'office_id', 'created_at', 'user_id')
                ->get();
        } elseif (Auth::user()->usertype->name === 'Budget Office') {
            $From_office = Office::where('name', 'BUGS Administration')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'office_id', 'created_at', 'user_id')
                ->where('office_id', $From_office->id)
                ->groupBy('batch_id')
                ->get();
        } elseif (Auth::user()->usertype->name === 'Dean') {
            $From_office = Office::where('name', 'Budget Office')->first();
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
                ->select('batch_id', 'office_id', 'created_at', 'user_id')
                ->where('office_id', $From_office->id)
                ->groupBy('batch_id')
                ->get();
        } elseif (Auth::user()->usertype->name === 'Accounting' || Auth::user()->usertype->name === 'Cashiers') {
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

        if(Auth::user()->usertype->name === 'Administrator' || Auth::user()->usertype->name === 'Superadmin'){
            // Filter out acknowledgements with a transaction count of 0
            $filteredAcknowledgements = $acknowledgements->filter(function ($acknowledgement) {
                $countTran = Transaction::whereNull('deleted_at')
                ->where('batch_id', $acknowledgement->batch_id)
                ->where('status', 'On Queue')
                // ->where('office', Auth::user()->office_id)
                ->count();
                return $countTran > 0; // Only keep acknowledgements with a transaction count greater than 0
            });


        }else{
           // Filter out acknowledgements with a transaction count of 0
            $filteredAcknowledgements = $acknowledgements->filter(function ($acknowledgement) {
                $countTran = Transaction::whereNull('deleted_at')
                ->where('batch_id', $acknowledgement->batch_id)
                ->where('status', 'On Queue')
                ->where('office', Auth::user()->office_id)
                ->count();
                return $countTran > 0; // Only keep acknowledgements with a transaction count greater than 0
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
                return Transaction::whereNull('deleted_at')
                ->where('batch_id', $data->batch_id)
                ->where('status', 'On Queue')
                ->where('office', Auth::user()->office_id)
                ->count();
            })
            ->addColumn('created_at', function ($data) {
                return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
            })
            ->make(true);
    }

}
