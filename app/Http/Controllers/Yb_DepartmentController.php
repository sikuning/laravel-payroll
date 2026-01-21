<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departments;
use App\Models\Designations;
use App\Models\Employee;
use Yajra\DataTables\DataTables;

class Yb_DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Departments::orderBy('department_id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->department_id.'" class="edit_department btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-department btn btn-danger btn-sm" data-id="'.$row->department_id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.departments.index');
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
            'department'=> 'required|unique:departments,department_name',
        ]);
 
        $departments = new Departments();
        $departments->department_name = $request->input("department");
        $result =  $departments->save();
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
        $department = Departments::where(['department_id'=>$id])->get();
        return $department;
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
            'department'=>'required|unique:departments,department_name,'.$id.',department_id',
        ]);

        $departments = Departments::where(['department_id'=>$id])->update([
            "department_name"=>$request->input('department'),
        ]);
        return $departments;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check1 = Designations::where('department_id',$id)->count();
        $check2 = Employee::where('department',$id)->count();
        if($check1 == 0 && $check2 == 0){
            $destroy = Departments::where('department_id',$id)->delete();
            return  $destroy;
        }else{
            return "You won't Delete this (This Department is used in Designations or Employees Table.)";
        }
    }
}
