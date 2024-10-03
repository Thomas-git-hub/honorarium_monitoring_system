<?php

namespace App\Http\Controllers;

use App\Models\Honorarium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HonorariumController extends Controller
{
    public function list(Request $request){
        $query = Honorarium::whereNull('deleted_at');
        $honos = $query->get();

        return DataTables::of($honos)
            ->addColumn('action', function($data) {
                return '<button type="button" class="btn btn-icon btn-label-success me-2 edit-btn" data-id="'.$data->id.'"><span class="tf-icons bx bx-pencil bx-18px"></span></button>';
            })
            ->editColumn('created_at', function($data) {
                return $data->created_at ? $data->created_at->format('m-d-Y') : now();
            })
            ->editColumn('updated_at', function($data) {
                return $data->updated_at ? $data->updated_at->format('m-d-Y') : now();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request){
        $request->validate([
            'honorarium.*' => 'required|unique:honorarium,name'
        ], [
            'honorarium.*.unique' => 'The name :input has already been taken.'
        ]);

        $data = $request->input('honorarium');

        foreach($data as $item){
            Honorarium::create([
                'name' => $item,
                'created_by' =>Auth::user()->id,
                'status' => 'Active'
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Honorarium saved successfully.']);
    }

    public function update(Request $request, $id) {
        $honorarium = Honorarium::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:honorarium,name,' . $honorarium->id
        ],
        [
            'name' => 'The honorarium has already been taken.'
        ]);

        $honorarium->name = $request->input('name');
        $honorarium->updated_at = now();
        $honorarium->save();

        return response()->json(['success' => true, 'message' => 'Honorarium updated successfully.']);
    }

    public function getHonorarium(Request $request){

        $query = Honorarium::whereNull('deleted_at')->where('status', 'Active')->get();
        return response()->json($query);
    }
}
