<?php

namespace App\Http\Controllers;

use App\Models\Emailing;
use App\Models\Office;
use App\Models\ThesisTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ThesisMonitorController extends Controller
{
    public function index(){

        if(in_array(Auth::user()->usertype->name, ['Dean', 'Superadmin', 'Administrator'])){

            $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
            $EmailCount = $pendingMails->count();

            $user = Auth::user();
            $collegeDetails = DB::connection('ibu_test')->table('college')
            ->where('id', $user->college_id)
            ->first();

            $bugs_office = Office::where('name', 'BUGS Administration')->first();
            $bugt_office = Office::where('name', 'Budget Office')->first();
            $dean_office = Office::where('name', 'Dean')->first();
            $Accounting_office = Office::where('name', 'Accounting')->first();
            $Cashiers = Office::where('name', 'Cashiers')->first();
            $faculty = Office::where('name', 'Faculty')->first();

            $initialDeanCount = ThesisTransaction::with([ 'createdBy'])
            ->whereNull('deleted_at')
            ->where('created_on', $dean_office->id)
            ->whereIn('status', ['processing'])
            ->count();

            $adminCount = ThesisTransaction::with([ 'createdBy'])
            ->whereNull('deleted_at')
            ->where('updated_on', $bugs_office->id)
            ->where('created_on', $dean_office->id)
            ->whereIn('status', ['processing', 'On Queue'])
            ->count();

            $budgtCount =  ThesisTransaction::with([ 'createdBy'])
            ->whereNull('deleted_at')
            ->where('updated_on', $bugt_office->id)
            ->where('created_on', $bugs_office->id)
            ->whereIn('status', ['processing', 'On Queue'])
            ->count();

            $deanCount = ThesisTransaction::with([ 'createdBy'])
            ->whereNull('deleted_at')
            ->where('updated_on', $dean_office->id)
            ->where('created_on', $bugt_office->id)
            ->whereIn('status', ['processing', 'On Queue'])
            ->count();

            $deanCountTwo = ThesisTransaction::with([ 'createdBy'])
            ->whereNull('deleted_at')
            ->where('updated_on', $dean_office->id)
            ->where('created_on', $Accounting_office->id)
            ->whereIn('status', ['processing', 'On Queue'])
            ->count();

            $acctCount = ThesisTransaction::with([ 'createdBy'])
            ->whereNull('deleted_at')
            ->where('updated_on', $Accounting_office->id)
            ->whereIn('status', ['processing', 'On Queue'])
            ->count();

            $cashCount = ThesisTransaction::with([ 'createdBy'])
            ->whereNull('deleted_at')
            ->where('updated_on', $Cashiers->id)
            ->whereIn('status', ['processing', 'On Queue'])
            ->count();

            $releaseCount = ThesisTransaction::with([ 'createdBy'])
            ->whereNull('deleted_at')
            ->where('status', 'Complete')
            ->count();


            return view('administration.thesis_track_monitor', compact('user', 'initialDeanCount', 'adminCount', 'budgtCount', 'deanCount', 'acctCount', 'cashCount', 'releaseCount', 'EmailCount', 'deanCountTwo'));
        }else{

            abort(403, 'Unauthorized action.');
        }


    }

    public function DeanListNewEntries(Request $request)
    {

        $query = array();
        $office = Office::where('name', 'Dean')->first();
        $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn', 'adviser', 'chairperson'])
        ->whereNull('deleted_at')
        ->where('created_on', $office->id)
        ->where('updated_on', $office->id)
        ->whereIn('status', ['processing']);

        $transactions = $query->get();
        

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

        ->addColumn('adviser', function($data) {
            return $data->adviser_id ? ucfirst($data->adviser->first_name) . ' ' . ucfirst($data->adviser->last_name) : 'N/A';

        })

        ->addColumn('chairperson', function($data) {
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

        ->editColumn('created_at', function ($data) {
            return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
        })
        ->make(true);
    }

    public function AdminList(Request $request)
    {

        $query = array();
        $office = Office::where('name', 'BUGS Administration')->first();
        $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn', 'adviser', 'chairperson'])
        ->whereNull('deleted_at')
        ->where('updated_on', $office->id)
        ->whereIn('status', ['processing', 'On Queue']);

        $transactions = $query->get();
        

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

        ->addColumn('adviser', function($data) {
            return $data->adviser_id ? ucfirst($data->adviser->first_name) . ' ' . ucfirst($data->adviser->last_name) : 'N/A';

        })

        ->addColumn('chairperson', function($data) {
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

        ->editColumn('created_at', function ($data) {
            return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
        })
        ->make(true);
    }

    public function BudgetList(Request $request)
    {

        $query = array();
        $office = Office::where('name', 'Budget Office')->first();
        $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn', 'adviser', 'chairperson'])
        ->whereNull('deleted_at')
        ->where('updated_on', $office->id)
        ->whereIn('status', ['processing', 'On Queue']);

        $transactions = $query->get();
        

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

        ->addColumn('adviser', function($data) {
            return $data->adviser_id ? ucfirst($data->adviser->first_name) . ' ' . ucfirst($data->adviser->last_name) : 'N/A';

        })

        ->addColumn('chairperson', function($data) {
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

        ->editColumn('created_at', function ($data) {
            return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
        })
        ->make(true);

        
    }

    public function DeanList(Request $request)
    {
        $query = array();
        $office = Office::where('name', 'Dean')->first();
        $from_office = Office::where('name', 'Budget Office')->first();
        $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn', 'adviser', 'chairperson'])
        ->whereNull('deleted_at')
        ->where('updated_on', $office->id)
        ->where('created_on', $from_office->id)
        ->whereIn('status', ['processing', 'On Queue']);

        $transactions = $query->get();
        

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

        ->addColumn('adviser', function($data) {
            return $data->adviser_id ? ucfirst($data->adviser->first_name) . ' ' . ucfirst($data->adviser->last_name) : 'N/A';

        })

        ->addColumn('chairperson', function($data) {
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

        ->editColumn('created_at', function ($data) {
            return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
        })
        ->make(true);

    }
    public function DeanListTwo(Request $request)
    {

        $query = array();
        $office = Office::where('name', 'Dean')->first();
        $from_office = Office::where('name', 'Accounting')->first();
        $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn', 'adviser', 'chairperson'])
        ->whereNull('deleted_at')
        ->where('updated_on', $office->id)
        ->where('created_on', $from_office->id)
        ->whereIn('status', ['processing', 'On Queue']);

        $transactions = $query->get();
        

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

        ->addColumn('adviser', function($data) {
            return $data->adviser_id ? ucfirst($data->adviser->first_name) . ' ' . ucfirst($data->adviser->last_name) : 'N/A';

        })

        ->addColumn('chairperson', function($data) {
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

        ->editColumn('created_at', function ($data) {
            return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
        })
        ->make(true);
        
    }

    public function AccountList(Request $request)
    {

        $query = array();
        $office = Office::where('name', 'Accounting')->first();
        $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn', 'adviser', 'chairperson'])
        ->whereNull('deleted_at')
        ->where('updated_on', $office->id)
        ->whereIn('status', ['processing', 'On Queue']);

        $transactions = $query->get();
        

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

        ->addColumn('adviser', function($data) {
            return $data->adviser_id ? ucfirst($data->adviser->first_name) . ' ' . ucfirst($data->adviser->last_name) : 'N/A';

        })

        ->addColumn('chairperson', function($data) {
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

        ->editColumn('created_at', function ($data) {
            return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
        })
        ->make(true);

       
    }

    public function CashierList(Request $request)
    {

        $query = array();
        $office = Office::where('name', 'Cashiers')->first();
        $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn', 'adviser', 'chairperson'])
        ->whereNull('deleted_at')
        ->where('updated_on', $office->id)
        ->whereIn('status', ['processing', 'On Queue']);

        $transactions = $query->get();
        

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

        ->addColumn('adviser', function($data) {
            return $data->adviser_id ? ucfirst($data->adviser->first_name) . ' ' . ucfirst($data->adviser->last_name) : 'N/A';

        })

        ->addColumn('chairperson', function($data) {
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

        ->editColumn('created_at', function ($data) {
            return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
        })
        ->make(true);

       
    }

    public function honorarium_released(Request $request)
    {

        $query = array();
        $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn', 'adviser', 'chairperson'])
        ->whereNull('deleted_at')
        ->where('status', 'Complete');

        $transactions = $query->get();
        

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

        ->addColumn('adviser', function($data) {
            return $data->adviser_id ? ucfirst($data->adviser->first_name) . ' ' . ucfirst($data->adviser->last_name) : 'N/A';

        })

        ->addColumn('chairperson', function($data) {
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

        ->editColumn('created_at', function ($data) {
            return $data->created_at ? $data->created_at->format('m-d-Y') : 'N/A';
        })
        ->make(true);

    }

}
