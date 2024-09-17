<?php

namespace App\Http\Controllers;

use App\Mail\TempPasswordMail;
use App\Models\Office;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    protected $redirectTo = '/admin_dashboard';

    public function index(){

        return view('index');
    }

    public function registration(){
        return view('registration');
    }

    public function register(Request $request){

        $randomString = Str::random(16);


        // Mail::to("angelicamae.bonganay@gmail.com")->send(new TempPasswordMail($randomString));


        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false,'errors' => $validator->errors()]);
        }

        $existingUser = DB::connection('mysql')->table('users')->where('email', $request->email)->first();

        if ($existingUser) {
            return response()->json(['success' => false, 'message' => 'User already has an account'], 200);
        }

        // $user = DB::connection('ors_pgsql')->table('employee_user')->where('email', $request->email)->first();
        $user = DB::connection('ibu_test')->table('employee_user')->where('email', $request->email)->first();

        if ($user) {
            $mysqlUserId = DB::connection('mysql')->table('users')->insertGetId([
                'employee_id' => $user->id,
                'email' => $request->email,
                'password' => Hash::make($randomString),

            ]);

            // $employeeDetails = DB::connection('ors_pgsql')->table('employee')
            $employeeDetails = DB::connection('ibu_test')->table('employee')
            ->where('id', $user->id)
            ->first();

            $usertype = UserType::where('name', 'Faculties')->first();
            $office = Office::where('name', 'Faculty')->first();

            if ($employeeDetails) {
                DB::connection('mysql')->table('users')->where('id', $mysqlUserId)->update([
                    'first_name' => $employeeDetails->employee_fname,
                    'last_name' => $employeeDetails->employee_lname,
                    'middle_name' => $employeeDetails->employee_mname,
                    'ee_number' => $employeeDetails->employee_no,
                    'position' => $employeeDetails->employee_academic_rank,
                    'college_id' => $employeeDetails->college_id,
                    'usertype_id' => $usertype->id,
                    'office_id' => $office->id,
                    'created_at' => now(),

                ]);

                Mail::to($user->email)->send(new TempPasswordMail($randomString, $employeeDetails->employee_fname));

                return response()->json(['success' => true, 'data'=> $randomString,  'message' => 'Successfully created a temporary password. Please check your email.']);

            }

        }

        return response()->json(['success' => false, 'message' => 'User Not Found']);
    }

    public function login(Request $request){
        // try {
        //     Mail::to("thomasallenebonoabra.escoto@bicol-u.edu.ph")->send(new TempPasswordMail());
        // } catch (\Throwable $th) {
        //     dd($th);
        // }


        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false,'errors' => $validator->errors()], 200);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (auth()->attempt($credentials, $remember)) {
            if (auth()->user()->status == 'Active') {
                return response()->json(['success' => true, 'redirect' => $this->redirectTo]);
            } else {
                auth()->logout();
                return response()->json(['success' => false, 'message' => 'Your account is not active. Please contact the Admin.']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Invalid credentials']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function list(Request $request)
    {

        $employeeIds = DB::connection('ibu_test')->table('employee_user')->pluck('id');

        // Modify the query to only include users whose id matches an employee_id from the employee_user table
        $query = User::with('usertype')
        ->whereNull('deleted_at')
        ->whereIn('employee_id', $employeeIds);

        // $user = DB::connection('ibu_test')->table('employee_user')->get();

        // $query = User::with('usertype')->whereNull('deleted_at');
        $users = $query->get();

        return DataTables::of($users)
            ->addColumn('id', function($user) {
                return $user->id;
            })
            ->addColumn('faculty', function($user) {
                return ucfirst($user->first_name) . ' ' . ucfirst($user->last_name);
            })
            ->editColumn('created_at', function($user) {
                return $user->created_at? $user->created_at->format('m/d/Y') : now();
            })
            ->editColumn('college', function($user) {
                if($user->college_id){
                    $collegeDetails = DB::connection('ibu_test')->table('college')
                    ->where('id', $user->college_id)
                    ->first();
                    return $collegeDetails->college_shortname;
                }
                else{
                    return 'No College Found';
                }

            })

            // ->addColumn('usertype', function($user) {
            //     return $user->usertype ? $user->usertype->name : 'N/A';
            // })
            ->make(true);
    }


    public function getUser(Request $request) {
        $searchTerm = $request->input('search'); // Capture search term

        // Join the 'employee' and 'employee_user' tables to get the email
        $faculties = DB::connection('ibu_test')
                        ->table('employee')
                        ->where('active', 'T')
                        ->where(function($query) use ($searchTerm) {
                            $query->where(DB::raw("CONCAT(employee_fname, ' ', employee_lname)"), 'like', "%{$searchTerm}%")
                                  ->orWhere('employee_fname', 'like', "%{$searchTerm}%")
                                  ->orWhere('employee_lname', 'like', "%{$searchTerm}%");
                        })
                        ->get();

        return response()->json($faculties);
    }

    public function AdminList(Request $request)
    {

        $query = array();
        $bugs_office = Office::where('name', 'BUGS Administration')->first();
        $query = Transaction::with(['honorarium', 'createdBy'])
        ->where('employee_id', $request->user_id)
        ->where('office', $bugs_office->id)
        ->where('status', 'Processing')
        ->orWhere('status', 'On-hold');

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
        ->where('status', 'Processing')
        ->orWhere('status', 'On-hold');

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
        ->where('status', 'Processing')
        ->orWhere('status', 'On-hold');

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
        ->where('status', 'Processing')
        ->orWhere('status', 'On-hold');

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
        ->where('status', 'Processing')
        ->orWhere('status', 'On-hold');

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
