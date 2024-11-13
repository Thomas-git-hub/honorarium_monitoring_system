<?php

namespace App\Http\Controllers;

use App\Models\Defense;
use App\Models\Degree;
use App\Models\Member;
use App\Models\Recorder;
use App\Models\Student;
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
        $thesisEntries = ThesisTransaction ::with(['student', 'degree', 'defense', 'recorder', 'createdBy', 'createdOn'])
            ->get();

        $ibu_dbcon = DB::connection('ibu_test');


        return DataTables::of($thesisEntries)
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

            ->make(true);
    }

    public function checkData()
    {
        $hasData = ThesisTransaction::count() > 0;
        return response()->json(['hasData' => $hasData]);
    }
}
