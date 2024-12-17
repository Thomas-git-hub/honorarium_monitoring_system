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

            if(Auth::user()->usertype->name === 'Superadmin'){
                
                $TransCountToday = Transaction::with(['honorarium', 'createdBy'])
                                        ->whereNull('deleted_at')
                                        ->where('status', 'On Queue')
                                        ->whereDate('created_at', Carbon::today())
                                        ->count();
                $yesterday = Carbon::yesterday()->format('Y-m-d');

                $TransCountYesterday = Transaction::with(['honorarium', 'createdBy'])
                    ->whereNull('deleted_at')
                    ->where('status', 'On Queue')
                    ->whereDate('updated_at', $yesterday)
                    ->count();

                $TransCountDaysAgo = Transaction::with(['honorarium', 'createdBy'])
                    ->whereNull('deleted_at')
                    ->where('status', 'On Queue')
                    ->whereDate('updated_at', '<', now()->subDays(1))
                    ->whereDate('updated_at', '>=', now()->subDays(7))
                    ->count();

                $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
                $EmailCount = $pendingMails->count();

               
            $acknowledgementCount = Acknowledgement::where('office_id', Auth::user()->office_id)
            ->count();
        }else{

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

           
            $acknowledgementCount = Acknowledgement::where('office_id', Auth::user()->office_id)
            ->count();

        }

            return view('administration.for_acknowledgement', compact('TransCountToday', 'TransCountYesterday', 'TransCountDaysAgo', 'EmailCount', 'acknowledgementCount'));

        }else{
            abort(403, 'Unauthorized action.');
        }
    }

    public function list(Request $request)
    {
        // Fetch data from the Acknowledgement table
        $acknowledgements = collect(); // Initialize an empty collection
        DB::statement("SET SQL_MODE=''");

        if (Auth::user()->usertype->name === 'Superadmin' || Auth::user()->usertype->name === 'Administrator') {
            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
            ->select(
                'acknowledgement.batch_id',
                'acknowledgement.office_id',
                'acknowledgement.from_office_id',
                'acknowledgement.created_at',
                'acknowledgement.from_user'
            )
            ->joinSub(
                DB::table('acknowledgement')
                    ->select('batch_id', DB::raw('MAX(created_at) as latest_created_at'))
                    ->groupBy('batch_id'),
                'latest_acknowledgement',
                function ($join) {
                    $join->on('acknowledgement.batch_id', '=', 'latest_acknowledgement.batch_id')
                        ->on('acknowledgement.created_at', '=', 'latest_acknowledgement.latest_created_at');
                }
            )
            ->get();

            $filteredAcknowledgements = $acknowledgements->filter(function ($acknowledgement) {

                $countTran = Transaction::whereNull('deleted_at')
                ->where('batch_id', $acknowledgement->batch_id)
                ->where('status', 'On Queue')
                ->where('office', $acknowledgement->office_id)
                ->count();
                return $countTran > 0; // Only keep acknowledgements with a transaction count greater than 0
            });

        } else{
            if (Auth::user()->usertype->name === 'Budget Office') {
                $office = Office::whereIn('name', ['BUGS Administration', 'ICTO'])->pluck('id');
               
            } 
            elseif (Auth::user()->usertype->name === 'Accounting' || Auth::user()->usertype->name === 'Cashiers') {
                $office = Office::whereIn('name', ['Dean'])->pluck('id');
               
            } elseif (Auth::user()->usertype->name === 'Dean') {
                $office = Office::whereIn('name', ['Accounting', 'Budget Office'])->pluck('id');
            
            }
            

            $acknowledgements = Acknowledgement::with(['user', 'office', 'transaction'])
            ->where('office_id', Auth::user()->office_id)
            ->whereIn('from_office_id', $office)
            ->groupBy('batch_id')
            ->get();

            $filteredAcknowledgements = $acknowledgements->filter(function ($acknowledgement) {
                $countTran = Transaction::whereNull('deleted_at')
                ->where('batch_id', $acknowledgement->batch_id)
                ->where('status', 'On Queue')
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
                if(Auth::user()->usertype->name === 'Superadmin'){
                    return Transaction::whereNull('deleted_at')
                    ->where('batch_id', $data->batch_id)
                    ->where('status', 'On Queue')
                    // ->where('from_office', Auth::user()->office_id)
                    ->count();

                }else{
                    return Transaction::whereNull('deleted_at')
                    ->where('batch_id', $data->batch_id)
                    ->where('status', 'On Queue')
                    ->where('office', Auth::user()->office_id)
                    ->count();
                }
              
            })
            ->addColumn('created_at', function ($data) {
                return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
            })
            ->make(true);
    }

}
