<?php

namespace App\Http\Controllers;

use App\Models\Activity_logs;
use App\Models\Emailing;
use App\Models\Office;
use App\Models\Transaction;
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

        $pendingMails = Emailing::where('status', 'Unread')->where('to_user', Auth::user()->employee_id);
        $EmailCount = $pendingMails->count();

        $OnQueue = Transaction::where('status', 'On Queue')->count();
        $OnHold = Transaction::where('status', 'On-hold')->count();
    
        return view('administration.admin_dashboard', compact('EmailCount', 'OnQueue', 'OnHold'));
    }

    public function admin_email(){
        return view('administration.admin_email');
    }

    public function admin_open_email(){
        return view('administration.admin_open_email');
    }

    public function admin_faculty(){

        $today = Carbon::today();
        $newAccountsToday = DB::connection('mysql')->table('users')
            ->whereDate('created_at', $today)
            ->count();
            return view('administration.admin_faculty', compact('newAccountsToday'));
    }

    public function admin_view_faculty(Request $request){
        $id = $request->query('id');
        $user = User::findOrFail($id);


        $collegeDetails = DB::connection('ibu_test')->table('college')
                ->where('id', $user->college_id)
                ->first();

        if(!empty($collegeDetails)){
            $college = $collegeDetails->college_name;
        }
        else{
            $college = 'No Assigned College';
        }


        return view('administration.admin_view_faculty', compact('user', 'college'));
    }

    public function admin_honorarium(){
        return view('administration.admin_honorarium');
    }

    /* ---------------------------------------NEW ENTRIES FUNCTIONS-------------------------------------------- */
    public function admin_new_entries(){
        $onQueue = Transaction::where('status', 'Processing')
            ->count();
        return view('administration.admin_new_entries', compact('onQueue'));
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
        $onQueue = Transaction::where('status', 'Processing')
            ->count();
        return view('administration.admin_on_queue', compact('onQueue'));
    }

    public function admin_on_hold(){
        $OnHold = Transaction::where('status', 'On-hold')->where('office', Auth::user()->office_id)->count();
        return view('administration.admin_on_hold', compact('OnHold'));
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