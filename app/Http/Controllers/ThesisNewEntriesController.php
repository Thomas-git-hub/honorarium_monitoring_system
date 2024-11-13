<?php

namespace App\Http\Controllers;

use App\Models\Defense;
use App\Models\Degree;
use App\Models\Member;
use App\Models\Recorder;
use App\Models\Student;
use App\Models\ThesisLogs;
use App\Models\ThesisTransaction ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;

class ThesisNewEntriesController extends Controller
{
    public function thesisNewEntries()
    {
        if(in_array(Auth::user()->usertype->name, ['Dean', 'Superadmin'])) {
            return view('administration.thesis_new_entries');
        }else{
            abort(403, 'Unauthorized action.');
        }
    }

    public function getStudent(Request $request){

        $searchTerm = $request->input('search'); // Capture search term

        $searchTerm = ucfirst($searchTerm);

        $data = Student::whereNull('deleted_at')
        ->where('status', 'Active')
        ->where(function($query) use ($searchTerm) {
            $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$searchTerm}%")
                ->orWhere('first_name', 'like', "%{$searchTerm}%")
                ->orWhere('last_name', 'like', "%{$searchTerm}%");
        })->get();

        return response()->json($data);

    }

    public function getMembers(Request $request){
        $searchTerm = $request->input('search'); // Capture search term

        $searchTerm = ucfirst($searchTerm);

        $data = Member::whereNull('deleted_at')
        ->where('status', 'Active')
        ->where(function($query) use ($searchTerm) {
            $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$searchTerm}%")
                ->orWhere('first_name', 'like', "%{$searchTerm}%")
                ->orWhere('last_name', 'like', "%{$searchTerm}%");
        })->get();

        return response()->json($data);

    }

    public function getDegrees(){
        $data = Degree::all();
        return response()->json($data);
    }

    public function getDefenseTypes(){
        $data = Defense::all();
        return response()->json($data);
    }

    public function getRecorder(Request $request){
        $searchTerm = $request->input('search'); // Capture search term

        $searchTerm = ucfirst($searchTerm);

        $data = Recorder::whereNull('deleted_at')
        ->where('status', 'Active')
        ->where(function($query) use ($searchTerm) {
            $query->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$searchTerm}%")
                ->orWhere('first_name', 'like', "%{$searchTerm}%")
                ->orWhere('last_name', 'like', "%{$searchTerm}%");
        })->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Handle Student
            $student_id = $request->student_id;
            if (!$student_id && $request->student_first_name) {
                // Create new student
                $student = Student::create([
                    'first_name' => ucfirst($request->student_first_name),
                    'middle_name' => ucfirst($request->student_middle_name),
                    'last_name' => ucfirst($request->student_last_name),
                    'suffix' => $request->student_suffix,
                    'status' => 'Active',
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);

                $student_id = $student->id;
            }

            // Handle Members
            $member_ids = [];
            for ($i = 1; $i <= 4; $i++) {
                $member_id = $request->input("member_{$i}_id");
                if (!$member_id && $request->input("member_{$i}_first_name")) {
                    // Create new member
                    $member = Member::create([
                        'first_name' => ucfirst($request->input("member_{$i}_first_name")),
                        'middle_name' => ucfirst($request->input("member_{$i}_middle_name")),
                        'last_name' => ucfirst($request->input("member_{$i}_last_name")),
                        'suffix' => $request->input("member_{$i}_suffix"),
                        'member_type' => $request->input("member_type_{$i}"),
                        'status' => 'Active',
                        'created_by' => Auth::user()->id,
                        'updated_by' => Auth::user()->id,
                    ]);
                    $member_ids[] = $member->id;
                } elseif ($member_id) {
                    $member_ids[] = $member_id;
                }
            }

            // Handle Recorder
            $recorder_id = $request->recorder_id;
            if (!$recorder_id && $request->recorder_first_name) {
                // Create new recorder
                $recorder = Recorder::create([
                    'first_name' => ucfirst($request->recorder_first_name),
                    'middle_name' => ucfirst($request->recorder_middle_name),
                    'last_name' => ucfirst($request->recorder_last_name),
                    'suffix' => $request->recorder_suffix,
                    'status' => 'Active',
                    'created_by' => Auth::user()->id,
                    'updated_by' => Auth::user()->id,
                ]);
                $recorder_id = $recorder->id;
            }

            // Create thesis transaction
            $thesis = new ThesisTransaction ();
            $thesis->student_id = $student_id;
            $thesis->degree_id = $request->degree_id;
            $thesis->defense_id = $request->defense_id;
            $thesis->adviser_id = $request->adviser_id;
            $thesis->chairperson_id = $request->chairperson_id;
            $thesis->member_ids = json_encode($member_ids);
            $thesis->recorder_id = $recorder_id;
            $thesis->or_number = $request->or_number;
            $thesis->defense_date = $request->defense_date;
            $thesis->defense_time = $request->defense_time;
            $thesis->created_by = Auth::user()->id;
            $thesis->created_on = Auth::user()->office_id;
            $thesis->updated_by = Auth::user()->id;
            $thesis->updated_on = Auth::user()->office_id;
            $thesis->status = 'Active';
            $thesis->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Thesis entry created successfully',
                'data' => $thesis
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Check if error is due to null column values
            if (strpos($e->getMessage(), 'cannot be null') !== false) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please fill up the form properly'
                ], 422);
            }

            return response()->json([
                'success' => false,
                'message' => 'Error creating thesis entry: ' . $e->getMessage()
            ], 500);
        }
    }

    public function list()
    {
        $query = ThesisTransaction::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn'])
            ->whereNull('deleted_at')
            ->get();

        $ibu_dbcon = DB::connection('ibu_test');


        return DataTables::of($query)
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
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->adviser_id)
                ->first();
                return ucfirst($employeeDetails->employee_fname) . ' ' . ucfirst($employeeDetails->employee_lname);

            })

            ->addColumn('chairperson', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->chairperson_id)
                ->first();
                return ucfirst($employeeDetails->employee_fname) . ' ' . ucfirst($employeeDetails->employee_lname);

            })

            ->addColumn('chairperson', function($data) use($ibu_dbcon) {
                $employeeDetails = $ibu_dbcon->table('employee')
                ->where('id', $data->chairperson_id)
                ->first();
                return ucfirst($employeeDetails->employee_fname) . ' ' . ucfirst($employeeDetails->employee_lname);

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

            ->editColumn('created_at', function($data) {
                return $data->created_at->format('m/d/Y');
            })

            ->editColumn('membersCount', function($data) {
                return count(json_decode($data->member_ids));
            })

            ->make(true);
    }

    public function checkData()
    {
        $hasData = ThesisTransaction::count() > 0;
        return response()->json(['hasData' => $hasData]);
    }

    public function destroy($id)
    {
        try {
            $thesisEntry = ThesisTransaction::findOrFail($id);
            $thesisEntry->delete(); // Soft delete

            return response()->json([
                'success' => true,
                'message' => 'Thesis entry deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting thesis entry: ' . $e->getMessage()
            ], 500);
        }
    }


    public function generateTrackingNum(Request $request){

        $transactions = ThesisTransaction::whereNull('deleted_at')
        ->where('created_on', Auth::user()->office_id)
        // ->whereNull('tracking_number')
        ->where('created_by', Auth::user()->id)
        ->get();

        if ($transactions->isEmpty()) {
            // Find the last batch_id
            $lastBatch = ThesisTransaction::whereNotNull('tracking_number')
                ->where('status', '<>', 'On Queue')
                ->orderBy('tracking_number', 'desc')
                ->first();

            if ($lastBatch) {
                $lastBatchCreatedAt = $lastBatch->created_at->format('F j, Y');

                // Count transactions with the status 'processing' for the new batch_id
                $processingTransactions = ThesisTransaction::whereNull('deleted_at')
                ->where('tracking_number', $lastBatch->tracking_number)
                ->where('status', 'processing') // Adjust the 'status' value based on your actual column values
                ->count();


                return response()->json([
                    'success' => false,
                    'message' => 'No transactions found',
                    'last_batch_id' => $lastBatch->batch_id, // Return last generated batch_id
                    'processing_transactions' => $processingTransactions, // Count of processing transactions
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
        $lastBatch = ThesisTransaction::whereNull('deleted_at')
            ->whereNotNull('tracking_number')
            ->orderBy('tracking_number', 'desc')
            ->first();


        $lastNumber = 0;
        if ($lastBatch) {
            // Extract the number before the dash
            $batchParts = explode(' - ', $lastBatch->tracking_number);
            $lastNumber = preg_replace('/\D/', '', $batchParts[0]);
        }

        // Increment the batch number
        $newNumber = $lastNumber + 1;


        // Format the current date as 'mdy'
        $date = now()->format('mdy');

        // Generate the new tracking_number
        $newBatchId = "THS{$newNumber} - {$date}";

        foreach ($transactions as $transaction) {
            $transaction->tracking_number = $newBatchId;
            $transaction->save();
        }

        $ack = new ThesisLogs();
        $ack->tracking_number= $newBatchId;
        $ack->office_id = Auth::user()->office_id;
        $ack->user_id = Auth::user()->id;
        $ack->save();


        // Count total transactions for the new batch_id
        $totalTransactions = ThesisTransaction::whereNull('deleted_at')
                                ->where('tracking_number', $newBatchId)->count();

        // Count transactions with the status 'processing' for the new batch_id
        $processingTransactions = ThesisTransaction::whereNull('deleted_at')
            ->where('tracking_number', $newBatchId)
            ->where('status', 'processing') // Adjust the 'status' value based on your actual column values
            ->count();

            return response()->json([
                'success' => true,
                'message' => 'Tracking Number generated successfully',
                'batch_id' => $newBatchId,
                'total_transactions' => $totalTransactions, // Total transactions count
                'processing_transactions' => $processingTransactions, // Count of processing transactions
                'date' => $date, // Count of processing transactions
            ]);

    }

    public function getMembersByID(Request $request)
    {
        $id = $request->id;
        $thesisEntry = ThesisTransaction::where('id', $id)->first();
        $membersArray = json_decode($thesisEntry->member_ids);

        // Retrieve all needed columns
        $members = Member::whereIn('id', $membersArray)
            ->get(['first_name', 'last_name', 'member_type'])
            ->mapWithKeys(function ($member) {
                return [$member->last_name => [
                    'first_name' => $member->first_name,
                    'member_type' => $member->member_type,
                ]];
            });

        return response()->json($members);
    }

    public function getTransactionByID(Request $request){
        $id = $request->id;

        $thesisEntry = ThesisTransaction::findOrFail($id);
        $ibu_dbcon = DB::connection('ibu_test');

        $student = Student::where('id',  $thesisEntry->student_id)->first();
        $defense = Defense::where('id',  $thesisEntry->defense_id)->first();
        $degree = Degree::where('id',  $thesisEntry->degree_id)->first();
        $recorder = Recorder::where('id',  $thesisEntry->recorder_id)->first();

        $adviser = $ibu_dbcon->table('employee')
        ->where('id', $thesisEntry->adviser_id)
        ->first();

        $chairperson = $ibu_dbcon->table('employee')
        ->where('id', $thesisEntry->chairperson_id)
        ->first();

        $memberIds = json_decode($thesisEntry->member_ids);
        $members = Member::whereIn('id', $memberIds)->get();

         // Prepare member data
        $membersData = $members->map(function ($member) {
            return [
                'id' => $member->id,
                'first_name' => $member->first_name,
                'middle_name' => $member->middle_name,
                'last_name' => $member->last_name,
                'suffix' => $member->suffix,
                'member_type' => $member->member_type,
            ];
        });

        return response()->json([
            'thesisEntry' => $thesisEntry,
            'student' => $student,
            'defense' => $defense,
            'degree' => $degree,
            'recorder' => $recorder,
            'adviser' => $adviser,
            'chairperson' => $chairperson,
            'members' => $membersData,
        ]);
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            $id = $request->thesis_id;

            // Find the thesis entry
            $thesisEntry = ThesisTransaction::findOrFail($id);

            // Update Student
            if ($request->student_id) {
                $student = Student::findOrFail($request->student_id);
                $student->update([
                    'first_name' => ucfirst($request->student_first_name),
                    'middle_name' => ucfirst($request->student_middle_name),
                    'last_name' => ucfirst($request->student_last_name),
                    'suffix' => $request->student_suffix,
                    'updated_by' => Auth::user()->id,
                ]);
            }

            // Update Members
            $member_ids = [];
            for ($i = 1; $i <= 4; $i++) {
                $member_id = $request->input("member_id_{$i}");
                if ($member_id) {
                    $member = Member::findOrFail($member_id);
                    $member->update([
                        'first_name' => ucfirst($request->input("member_first_name_{$i}")),
                        'middle_name' => ucfirst($request->input("member_middle_name_{$i}")),
                        'last_name' => ucfirst($request->input("member_last_name_{$i}")),
                        'suffix' => $request->input("member_suffix_{$i}"),
                        'member_type' => $request->input("member_type_{$i}"),
                        'updated_by' => Auth::user()->id,
                    ]);
                    $member_ids[] = $member->id;
                }
            }

            // Update Recorder
            if ($request->recorder_id) {
                $recorder = Recorder::findOrFail($request->recorder_id);
                $recorder->update([
                    'first_name' => ucfirst($request->recorder_first_name),
                    'middle_name' => ucfirst($request->recorder_middle_name),
                    'last_name' => ucfirst($request->recorder_last_name),
                    'suffix' => $request->recorder_suffix,
                    'updated_by' => Auth::user()->id,
                ]);
            }

            // Update Thesis Transaction
            $thesisEntry->update([
                'degree_id' => $request->degree,
                'defense_id' => $request->defense_type,
                'adviser_id' => $request->adviser_id,
                'chairperson_id' => $request->chairperson_id,
                'member_ids' => json_encode($member_ids),
                'or_number' => $request->or_number,
                'defense_date' => $request->defense_date,
                'defense_time' => $request->defense_time,
                'updated_by' => Auth::user()->id,
                'updated_on' => Auth::user()->office_id,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Thesis entry updated successfully',
                'data' => $thesisEntry
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error updating thesis entry: ' . $e->getMessage()
            ], 500);
        }
    }
}
