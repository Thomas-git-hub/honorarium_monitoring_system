<?php

namespace App\Http\Controllers;

use App\Mail\TempPasswordMail;
use App\Models\Office;
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

        // $user = DB::connection('ibu_test')->table('employee_user')->where('email', $request->email)->first();
        $user = DB::connection('ibu_test')->table('employee_user')->where('email', $request->email)->first();

        if ($user) {
            $mysqlUserId = DB::connection('mysql')->table('users')->insertGetId([
                'employee_id' => $user->id,
                'email' => $request->email,
                'password' => Hash::make($randomString),

            ]);

            // $employeeDetails = DB::connection('ibu_test')->table('employee')
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
        $query = User::with('usertype')->whereNull('deleted_at');
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

    // public function getUser(Request $request) {
    //     $searchTerm = $request->input('search'); // Capture search term

    //     // Join the 'employee' and 'employee_user' tables to get the email
    //     $faculties = DB::connection('ibu_test')
    //                     ->table('employee')
    //                     ->join('employee_user', 'employee.id', '=', 'employee_user.id')
    //                     ->select(
    //                         'employee.id',
    //                         'employee.employee_fname',
    //                         'employee.employee_lname',
    //                         'employee.employee_no',
    //                         'employee_user.email' // Assuming email is in the employee_user table
    //                     )
    //                     ->where('employee.active', 'T')
    //                     ->where(function($query) use ($searchTerm) {
    //                         $query->where(DB::raw("CONCAT(employee.employee_fname, ' ', employee.employee_lname)"), 'like', "%{$searchTerm}%")
    //                               ->orWhere('employee.employee_fname', 'like', "%{$searchTerm}%")
    //                               ->orWhere('employee.employee_lname', 'like', "%{$searchTerm}%");
    //                     })
    //                     ->get();

    //     return response()->json($faculties);
    // }

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


}
