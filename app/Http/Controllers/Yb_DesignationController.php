<?php

namespace App\Http\Controllers;
use App\Models\Designations;
use App\Models\Departments;
use App\Models\Employee;
use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class Yb_DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $departments = Departments::all();
        if ($request->ajax()) {
           // $data = Designations::orderBy('designation_id','desc')->get();
            $data = Designations::select(['designations.*','departments.department_name as department'])
                    ->LeftJoin('departments','designations.department_id','=','departments.department_id')
                    ->orderBy('designations.designation_id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->designation_id.'" class="edit_designation btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-designation btn btn-danger btn-sm" data-id="'.$row->designation_id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.designations.index',['department'=>$departments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'designation'=> 'required|unique:designations,designation_name',
            'department' => 'required'
        ]);

        $designations = new Designations();
        $designations->designation_name = $request->input("designation");
        $designations->department_id = $request->input("department");
        $result =  $designations->save();
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $designations = Designations::where('designation_id',$id)->get();
        return $designations;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'designation'=> 'required|unique:designations,designation_name,'.$id.',designation_id',
            'department' => 'required'
        ]);

        $designations = Designations::where(['designation_id'=>$id])->update([
            "designation_name"=>$request->input('designation'),
            "department_id"=>$request->input('department'),
        ]);
        return $designations;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = Employee::where('department',$id)->count();
        if($check == 0){
            $destroy = Designations::where('designation_id',$id)->delete();
            return  $destroy;
        }else{
            return "You won't Delete this (This Designation is used in Employees Table.)";
        }
    }

    public function yb_get_department_designations(Request $request){
        $id = $request->id;
        $designations = Designations::where('department_id',$id)->get();
        $output = '<option selected disabled value="">Select Designation</option>';
        foreach($designations as $row){
            $output .= '<option value="'.$row->designation_id.'">'.$row->designation_name.'</option>';
        }
        return $output;
    }
}
