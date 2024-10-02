<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FacultyTrackingController extends Controller
{
    public function faculty_tracking(){

        if(Auth::user()->usertype->name === 'Faculties'){

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

            $adminCount = Transaction::with(['honorarium', 'createdBy'])
            ->where('employee_id', Auth::user()->employee_id)
            ->where('office', $bugs_office->id)
            ->whereIn('status', ['Processing', 'On Queue', 'On-hold'])
            ->count();

            $budgtCount =  Transaction::with(['honorarium', 'createdBy'])
            ->where('employee_id', Auth::user()->employee_id)
            ->where('office', $bugt_office->id)
            ->whereIn('status', ['Processing', 'On Queue', 'On-hold'])
            ->count();

            $deanCount = Transaction::with(['honorarium', 'createdBy'])
            ->where('employee_id', Auth::user()->employee_id)
            ->where('office', $dean_office->id)
            ->whereIn('status', ['Processing', 'On Queue', 'On-hold'])
            ->count();

            $acctCount = Transaction::with(['honorarium', 'createdBy'])
            ->where('employee_id', Auth::user()->employee_id)
            ->where('office', $Accounting_office->id)
            ->whereIn('status', ['Processing', 'On Queue', 'On-hold'])
            ->count();

            $cashCount = Transaction::with(['honorarium', 'createdBy'])
            ->where('employee_id', Auth::user()->employee_id)
            ->where('office', $Cashiers->id)
            ->whereIn('status', ['Processing', 'On Queue', 'On-hold'])
            ->count();

            $releaseCount = Transaction::with(['honorarium', 'createdBy'])
            ->where('employee_id',Auth::user()->employee_id)
            ->where('office', $faculty->id)
            ->where('status', 'Completed')
            ->count();


            if(!empty($collegeDetails)){
                $college = $collegeDetails->college_name;
            }
            else{
                $college = 'No Assigned College';
            }
            return view('administration.faculty_tracking', compact('user', 'college', 'adminCount', 'budgtCount', 'deanCount', 'acctCount', 'cashCount', 'releaseCount'));
        }else{

            abort(403, 'Unauthorized action.');
        }


    }

    public function AdminList(Request $request)
    {

        $query = array();
        $bugs_office = Office::where('name', 'BUGS Administration')->first();
        $query = Transaction::with(['honorarium', 'createdBy'])
        ->where('employee_id', $request->user_id)
        ->where('office', $bugs_office->id)
        ->whereIn('status', ['Processing', 'On Queue', 'On-hold']);
        // ->orWhere('status', 'On-hold');

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

            ->addColumn('honorarium', function($data) {
                return $data->honorarium_id ? $data->honorarium->name : 'N/A';
            })
            ->addColumn('sem', function($data) {
                return $data->sem ? $data->sem : 'N/A';
            })

            ->addColumn('year', function($data) {
                return $data->year ? $data->year : 'N/A';
            })

            ->addColumn('date_received', function($data) {
                return $data->date_of_trans ? $data->date_of_trans : 'N/A';
            })

            ->addColumn('transaction_date', function($data) {
                return $data->updated_at ? $data->updated_at : 'N/A';
            })

            ->addColumn('month', function($data) use ($months) {
                // return $months[$data->month] ?? 'Unknown';
                return [
                    'month_number' => $data->month,
                    'month_name' => $months[$data->month] ?? 'Unknown'
                ];
            })

            ->make(true);
    }

    public function BudgetList(Request $request)
    {

        $query = array();
        $bugt_office = Office::where('name', 'Budget Office')->first();
        $query = Transaction::with(['honorarium', 'createdBy'])
        ->where('employee_id', $request->user_id)
        ->where('office', $bugt_office->id)
        ->whereIn('status', ['Processing', 'On Queue', 'On-hold']);
        // ->orWhere('status', 'On-hold');

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

            ->addColumn('honorarium', function($data) {
                return $data->honorarium_id ? $data->honorarium->name : 'N/A';
            })
            ->addColumn('sem', function($data) {
                return $data->sem ? $data->sem : 'N/A';
            })

            ->addColumn('year', function($data) {
                return $data->year ? $data->year : 'N/A';
            })

            ->addColumn('date_received', function($data) {
                return $data->date_of_trans ? $data->date_of_trans : 'N/A';
            })

            ->addColumn('transaction_date', function($data) {
                return $data->updated_at ? $data->updated_at : 'N/A';
            })

            ->addColumn('month', function($data) use ($months) {
                // return $months[$data->month] ?? 'Unknown';
                return [
                    'month_number' => $data->month,
                    'month_name' => $months[$data->month] ?? 'Unknown'
                ];
            })

            ->make(true);
    }

    public function DeanList(Request $request)
    {

        $query = array();
        $dean_office = Office::where('name', 'Dean')->first();
        $query = Transaction::with(['honorarium', 'createdBy'])
        ->where('employee_id', $request->user_id)
        ->where('office', $dean_office->id)
        ->whereIn('status', ['Processing', 'On Queue', 'On-hold']);
        // ->orWhere('status', 'On-hold');

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

            ->addColumn('honorarium', function($data) {
                return $data->honorarium_id ? $data->honorarium->name : 'N/A';
            })
            ->addColumn('sem', function($data) {
                return $data->sem ? $data->sem : 'N/A';
            })

            ->addColumn('year', function($data) {
                return $data->year ? $data->year : 'N/A';
            })

            ->addColumn('date_received', function($data) {
                return $data->date_of_trans ? $data->date_of_trans : 'N/A';
            })

            ->addColumn('transaction_date', function($data) {
                return $data->updated_at ? $data->updated_at : 'N/A';
            })

            ->addColumn('month', function($data) use ($months) {
                // return $months[$data->month] ?? 'Unknown';
                return [
                    'month_number' => $data->month,
                    'month_name' => $months[$data->month] ?? 'Unknown'
                ];
            })

            ->make(true);
    }
    public function DeanListTwo(Request $request)
    {

        $query = array();
        $dean_office = Office::where('name', 'Dean')->first();
        $query = Transaction::with(['honorarium', 'createdBy'])
        ->where('employee_id', $request->user_id)
        ->where('office', $dean_office->id)
        ->whereIn('status', ['Processing', 'On Queue', 'On-hold']);
        // ->orWhere('status', 'On-hold');

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

            ->addColumn('honorarium', function($data) {
                return $data->honorarium_id ? $data->honorarium->name : 'N/A';
            })
            ->addColumn('sem', function($data) {
                return $data->sem ? $data->sem : 'N/A';
            })

            ->addColumn('year', function($data) {
                return $data->year ? $data->year : 'N/A';
            })

            ->addColumn('date_received', function($data) {
                return $data->date_of_trans ? $data->date_of_trans : 'N/A';
            })

            ->addColumn('transaction_date', function($data) {
                return $data->updated_at ? $data->updated_at : 'N/A';
            })

            ->addColumn('month', function($data) use ($months) {
                // return $months[$data->month] ?? 'Unknown';
                return [
                    'month_number' => $data->month,
                    'month_name' => $months[$data->month] ?? 'Unknown'
                ];
            })

            ->make(true);
    }

    public function AccountList(Request $request)
    {

        $query = array();
        $Accounting_office = Office::where('name', 'Accounting')->first();
        $query = Transaction::with(['honorarium', 'createdBy'])
        ->where('employee_id', $request->user_id)
        ->where('office', $Accounting_office->id)
        ->whereIn('status', ['Processing', 'On Queue', 'On-hold']);
        // ->orWhere('status', 'On-hold');

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

            ->addColumn('honorarium', function($data) {
                return $data->honorarium_id ? $data->honorarium->name : 'N/A';
            })
            ->addColumn('sem', function($data) {
                return $data->sem ? $data->sem : 'N/A';
            })

            ->addColumn('year', function($data) {
                return $data->year ? $data->year : 'N/A';
            })

            ->addColumn('date_received', function($data) {
                return $data->date_of_trans ? $data->date_of_trans : 'N/A';
            })

            ->addColumn('transaction_date', function($data) {
                return $data->updated_at ? $data->updated_at : 'N/A';
            })

            ->addColumn('month', function($data) use ($months) {
                // return $months[$data->month] ?? 'Unknown';
                return [
                    'month_number' => $data->month,
                    'month_name' => $months[$data->month] ?? 'Unknown'
                ];
            })

            ->make(true);
    }

    public function CashierList(Request $request)
    {

        $query = array();
        $Cashiers = Office::where('name', 'Cashiers')->first();
        $query = Transaction::with(['honorarium', 'createdBy'])
        ->where('employee_id', $request->user_id)
        ->where('office', $Cashiers->id)
        ->whereIn('status', ['Processing', 'On Queue', 'On-hold']);
        // ->orWhere('status', 'On-hold');

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

            ->addColumn('honorarium', function($data) {
                return $data->honorarium_id ? $data->honorarium->name : 'N/A';
            })
            ->addColumn('sem', function($data) {
                return $data->sem ? $data->sem : 'N/A';
            })

            ->addColumn('year', function($data) {
                return $data->year ? $data->year : 'N/A';
            })

            ->addColumn('date_received', function($data) {
                return $data->date_of_trans ? $data->date_of_trans : 'N/A';
            })

            ->addColumn('transaction_date', function($data) {
                return $data->updated_at ? $data->updated_at : 'N/A';
            })

            ->addColumn('month', function($data) use ($months) {
                // return $months[$data->month] ?? 'Unknown';
                return [
                    'month_number' => $data->month,
                    'month_name' => $months[$data->month] ?? 'Unknown'
                ];
            })

            ->make(true);
    }

    public function honorarium_released(Request $request)
    {

        $query = array();
        $faculty = Office::where('name', 'Faculty')->first();
        $query = Transaction::with(['honorarium', 'createdBy'])
        ->where('employee_id', $request->user_id)
        ->where('office', $faculty->id)
        ->where('status', 'Completed');

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

            ->addColumn('honorarium', function($data) {
                return $data->honorarium_id ? $data->honorarium->name : 'N/A';
            })
            ->addColumn('sem', function($data) {
                return $data->sem ? $data->sem : 'N/A';
            })

            ->addColumn('year', function($data) {
                return $data->year ? $data->year : 'N/A';
            })

            ->addColumn('date_received', function($data) {
                return $data->date_of_trans ? $data->date_of_trans : 'N/A';
            })

            ->addColumn('transaction_date', function($data) {
                return $data->updated_at ? $data->updated_at : 'N/A';
            })

            ->addColumn('month', function($data) use ($months) {
                // return $months[$data->month] ?? 'Unknown';
                return [
                    'month_number' => $data->month,
                    'month_name' => $months[$data->month] ?? 'Unknown'
                ];
            })

            ->make(true);
    }


}
