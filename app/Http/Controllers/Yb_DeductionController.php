<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Deduction;
use Yajra\DataTables\DataTables;

class Yb_DeductionController extends Controller
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
            $data = Deduction::orderBy('deduction_id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('deduction_type', function($row){
                if($row->deduction_type == '0'){
                    $deduction_type = '<span>Fixed</span>';
                }else{
                    $deduction_type = '<span>Percentage</span>';
                }
                return $deduction_type;
            })
            ->editColumn('percentage_of_basic', function($row){
                if($row->percentage_of_basic != ''){
                    $percentage_of_basic = '<span> '.$row->percentage_of_basic.'% </span>';
                }else{
                    $percentage_of_basic = '<span></span>';
                }
                return $percentage_of_basic;
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->deduction_id.'" class="edit_deduction btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-deduction btn btn-danger btn-sm" data-id="'.$row->deduction_id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['deduction_type','percentage_of_basic','action'])
            ->make(true);
        }
        return view('admin.deduction.index');
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
            'deduction'=> 'required|unique:deduction,deduction_name',
            'deduction_type'=> 'required',
          //  'percentage'=> 'required',
            'limit_per_month'=> 'required',
        ]);
 
        $deduction = new Deduction();
        $deduction->deduction_name = $request->input("deduction");
        $deduction->deduction_type = $request->input("deduction_type");
        $deduction->percentage_of_basic = $request->input("percentage");
        $deduction->limit_per_month = $request->input("limit_per_month");
        $result = $deduction->save();
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
        $deduction = Deduction::where(['deduction_id'=>$id])->get();
        return $deduction;
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
            'deduction'=>'required|unique:deduction,deduction_name,'.$id.',deduction_id',
            'deduction_type'=> 'required',
          //  'percentage'=> 'required',
            'limit_per_month'=> 'required',
        ]);

        $deduction = Deduction::where(['deduction_id'=>$id])->update([
            "deduction_name"=>$request->input('deduction'),
            "deduction_type" => $request->input('deduction_type'),
            "percentage_of_basic" => $request->input('percentage'),
            "limit_per_month" => $request->input('limit_per_month'),
        ]);
        return $deduction;
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
        $destroy = Deduction::where('deduction_id',$id)->delete();
        return  $destroy;
    }
}
