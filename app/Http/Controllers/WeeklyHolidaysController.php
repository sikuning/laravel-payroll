<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class WeeklyHolidaysController extends Controller
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
            $data = DB::table('weekly_holidays')->orderBy('id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('status', function($row){
                if($row->status == '1'){
                    $status = '<span class="badge badge-success">Active</span>';
                }else{
                    $status = '<span class="badge badge-danger">Inactive</span>';
                }
                return $status;
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit_weekly_holiday btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-weekly-holiday btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
        return view('admin.holidays.weekly');
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
            'day_name'=> 'required|unique:weekly_holidays,day_name',
            'status'=> 'required',
        ]);

        $weekly_holidays = DB::table('weekly_holidays')->insert([
            'day_name' => $request->day_name,
            'status' => $request->status,
        ]);
 
        return $weekly_holidays;
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
        $holidays = DB::table('weekly_holidays')->where(['id'=>$id])->first();
        return $holidays;
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
            'day_name'=> 'required|unique:weekly_holidays,day_name,'.$id.',id',
            'status'=> 'required',
        ]);

        $update = DB::table('weekly_holidays')->where(['id'=>$id])->update([
            "day_name"=>$request->day_name,
            "status"=>$request->status,
        ]);
        return $update;
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
        $destroy = DB::table('weekly_holidays')->where('id',$id)->delete();
        return  $destroy;
    }
}
