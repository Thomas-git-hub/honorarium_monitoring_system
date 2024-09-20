<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class UserManagementController extends Controller
{
    public function user_management(){

        return view('administration.user_management');
    }


    public function list(Request $request)
    {

        $ibu_dbcon = DB::connection('ibu_test');

        $users = User::with('office')->get();

        // $users = $query->get();

        return DataTables::of($users)
            ->addColumn('id', function($user) {
                return $user->id;
            })
            ->addColumn('faculty', function($user) use($ibu_dbcon){
                return  $user->first_name . ' ' . $user->last_name;
            })

            ->addColumn('usertype', function($user) {
                return $user->usertype ? $user->usertype->name : 'N/A';
            })

            ->addColumn('email', function($user) {
                return $user->email;
            })

            ->addColumn('date', function($user) {
                return $user->created_at;
            })

            ->addColumn('status', function($user) {
                return $user->status;
            })

            ->addColumn('contact', function($user) {
                return $user->contact;
            })

            ->addColumn('position', function($user) {
                return $user->position ? $user->position : 'No Academic Rank';
            })

            ->addColumn('ee_number', function($user) {
                return $user->ee_number ? $user->ee_number : 'No Employee Number';
            })

            ->addColumn('office', function($user) {
                return $user->office->name ? $user->office->name : 'No Office';
            })

            ->editColumn('college', function($user) {
                if($user->college_id){
                    $collegeDetails = DB::connection('ibu_test')->table('college')
                    ->where('id', $user->college_id)
                    ->first();
                    return $collegeDetails->college_name;
                }
                else{
                    return 'No College Found';
                }

            })


            ->addColumn('action', function($data) {
                $viewButton = '<button type="button" class="btn btn-icon me-2 btn-label-primary view-btn"><span class="tf-icons bx bx-show-alt bx-22px"></span></button>';
                $on_holdButton = '<button type="button" class="btn btn-icon me-2 btn-label-danger on-hold-btn"><span class="tf-icons bx bxs-hand bx-18px"></span></button>';
                $deleteButton = '<button type="button" class="btn btn-icon me-2 btn-label-danger delete-btn"><span class="tf-icons bx bxs-trash bx-18px"></span></button>';

                return '<div class="d-flex flex-row" data-id="' . $data->id . '">' . $viewButton . '</div>';
            })



            ->make(true);
    }


}
