<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PublicHolidaysController extends Controller
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
            $data = DB::table('holiday_details')->orderBy('id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('from_date', function($row){
                return date('d M, Y',strtotime($row->from_date));
            })
            ->editColumn('to_date', function($row){
                return date('d M, Y',strtotime($row->to_date));
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit_public_holiday btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-public-holiday btn btn-danger btn-sm" data-id="'.$row->id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.holidays.public');
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
            'holiday'=> 'required|unique:holiday_details,name',
            'from_date'=> 'required',
            'to_date'=> 'required',
        ]);

        $comment = '';
        if($request->comment){
            $comment = $request->comment;
        }

        $public_holidays = DB::table('holiday_details')->insert([
            'name' => $request->holiday,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'comment' => $comment,
        ]);
 
        // $departments = new Departments();
        // $departments->department_name = $request->input("department");
        // $result =  $departments->save();
        return $public_holidays;
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
        $holidays = DB::table('holiday_details')->where(['id'=>$id])->first();
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
            'holiday'=> 'required|unique:holiday_details,name,'.$id.',id',
            'from_date'=> 'required',
            'to_date'=> 'required',
        ]);

        $comment = '';
        if($request->comment){
            $comment = $request->comment;
        }

        $update = DB::table('holiday_details')->where(['id'=>$id])->update([
            "name"=>$request->holiday,
            "from_date"=>$request->from_date,
            "to_date"=>$request->to_date,
            "comment"=>$comment,
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
        $destroy = DB::table('holiday_details')->where('id',$id)->delete();
        return  $destroy;
    }
}
