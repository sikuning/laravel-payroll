<?php

namespace App\Http\Controllers;
use App\Models\HourlyPayGrade;
use App\Models\Employee;

use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class Yb_HourlyPayGradeController extends Controller
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
            $data = HourlyPayGrade::orderBy('hourly_id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->hourly_id.'" class="edit_hourly btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-hourly btn btn-danger btn-sm" data-id="'.$row->hourly_id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.hourly_pay_grade.index');
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
            'hourly'=> 'required|unique:hourly_pay_grade,hourly_pay_grade',
            'hourly_rate'=> 'required',
        ]);
 
        $hourly_payGrade = new HourlyPayGrade();
        $hourly_payGrade->hourly_pay_grade = $request->input("hourly");
        $hourly_payGrade->hourly_rate = $request->input("hourly_rate");
        $result = $hourly_payGrade->save();
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
        $hourly_payGrade = HourlyPayGrade::where(['hourly_id'=>$id])->get();
        return  $hourly_payGrade;
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
        //return $request->input();
        $request->validate([
           'hourly'=> 'required|unique:hourly_pay_grade,hourly_pay_grade,'.$id.',hourly_id',
            'hourly_rate'=> 'required',
        ]);
 
        $hourly_payGrade = HourlyPayGrade::where(['hourly_id'=>$id])->update([
            "hourly_pay_grade" => $request->input("hourly"),
            "hourly_rate" => $request->input("hourly_rate"),
        ]);
        return $hourly_payGrade;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = Employee::where('hourly_pay',$id)->count();
        if($check == 0){
            $destroy = HourlyPayGrade::where('hourly_id',$id)->delete();
            return  $destroy;
        }else{
            return "You won't Delete this (This Name is used in Employees Table.)";
        }

        
    }
}
