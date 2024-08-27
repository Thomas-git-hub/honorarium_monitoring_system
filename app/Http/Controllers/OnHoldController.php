<?php

namespace App\Http\Controllers;

use App\Models\Activity_logs;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OnHoldController extends Controller
{
    public function getOnHoldTransactions(Request $request)
    {
        // Query to get transactions with status 'On-hold'
        $transactions = Transaction::where('status', 'On-hold')->get();
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

        // Return DataTables response
        return DataTables::of($transactions)
            ->addColumn('id', function ($data) {
                return $data->id;
            })

            ->addColumn('faculty', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->employee_id)
                ->first();
                return ucfirst($employeeDetails->employee_fname ? $employeeDetails->employee_fname : '') . ' ' . ucfirst($employeeDetails->employee_lname ? $employeeDetails->employee_lname : ' ');
            })

            ->addColumn('id_number', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->employee_id)
                ->first();
                return ucfirst($employeeDetails->employee_no ? $employeeDetails->employee_no : ' ');
            })

            ->addColumn('academic_rank', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->employee_id)
                ->first();
                return ucfirst($employeeDetails->employee_academic_rank ? $employeeDetails->employee_academic_rank : ' ');
            })

            ->addColumn('college', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->employee_id)
                ->first();

                $collegeDetails = $ibu_dbcon->table('college')
                ->where('id', $employeeDetails->college_id)
                ->first();
                return $collegeDetails->college_shortname ? $collegeDetails->college_shortname : '';
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
                // $editButton = '<button type="button" class="btn btn-icon me-2 btn-label-success edit-btn"><span class="tf-icons bx bx-pencil bx-18px"></span></button>';
                // $on_holdButton = '<button type="button" class="btn btn-icon me-2 btn-label-danger on-hold-btn"><span class="tf-icons bx bxs-hand bx-18px"></span></button>';
                $proceedButton = '<button type="button" class="btn me-2 btn-primary btn-sm edit-btn gap-1" data-bs-toggle="modal" data-bs-target="#proceed">Proceed<i class="bx bx-chevrons-right"></i></button>';

                return '<div class="d-flex flex-row" data-id="' . $data->id . '">' . $proceedButton . '</div>';
            })

            ->make(true);
    }

    public function saveOnHold(Request $request){
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

        $office = Office::where('name', 'Bugs Administration')->first();

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
        $transaction->created_by = auth()->user()->id;
        $transaction->save();


        $logs = new Activity_logs();
        $logs->trans_id = $transaction->id;
        $logs->office_id = $office->id;
        $logs->user_id = $transaction->created_by;
        $logs->save();

        return response()->json(['success' => true, 'message' => 'Form submitted successfully.']);


    }
}
