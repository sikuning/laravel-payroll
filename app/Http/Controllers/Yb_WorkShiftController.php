<?php

namespace App\Http\Controllers;
use App\Models\WorkShift; 

use Yajra\DataTables\DataTables;

use Illuminate\Http\Request;

class Yb_WorkShiftController extends Controller
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
            $data = WorkShift::orderBy('shift_id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->shift_id.'" class="edit_shift btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-shift btn btn-danger btn-sm" data-id="'.$row->shift_id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.work_shift.index');
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
            'shift'=> 'required|unique:work_shift,work_shift',
            'start_time'=> 'required',
            'end_time'=> 'required',
           // 'late_count_time'=> 'required',
        ]);

        $workShift = new WorkShift();
        $workShift->work_shift = $request->input("shift");
        $workShift->start_time = $request->input("start_time");
        $workShift->end_time = $request->input("end_time");
        $workShift->late_count_time = $request->input("late_count_time");
        $result = $workShift->save();
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
        $workShift = WorkShift::where('shift_id',$id)->get();
        return $workShift;
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
            'shift'=> 'required|unique:work_shift,work_shift,'.$id.',shift_id',
            'start_time'=> 'required',
            'end_time'=> 'required',
           // 'late_count_time'=> 'required',
        ]);

        $workShift = WorkShift::where(['shift_id'=>$id])->update([
            "work_shift"=>$request->input('shift'),
            "start_time"=>$request->input('start_time'),
            "end_time"=>$request->input('end_time'),
            "late_count_time"=>$request->input('late_count_time'),
        ]);
        return '1';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $destroy = WorkShift::where('shift_id',$id)->delete();
        return  $destroy;
    }
}
