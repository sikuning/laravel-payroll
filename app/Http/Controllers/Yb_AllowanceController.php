<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Allowance;
use Yajra\DataTables\DataTables;

class Yb_AllowanceController extends Controller
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
            $data = Allowance::orderBy('allowance_id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('allowance_type', function($row){
                if($row->allowance_type == '0'){
                    $allowance_type = '<span>Fixed</span>';
                }else{
                    $allowance_type = '<span>Percentage</span>';
                }
                return $allowance_type;
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
                $btn = '<a href="javascript:void(0)" data-id="'.$row->allowance_id.'" class="edit_allowance btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-allowance btn btn-danger btn-sm" data-id="'.$row->allowance_id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['allowance_type','percentage_of_basic','action'])
            ->make(true);
        }
        return view('admin.allowance.index');
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
            'allowance'=> 'required|unique:allowance,allowance_name',
            'allowance_type'=> 'required',
           // 'percentage'=> 'required',
            'limit_per_month'=> 'required',
        ]);
 
        $allowance = new Allowance();
        $allowance->allowance_name = $request->input("allowance");
        $allowance->allowance_type = $request->input("allowance_type");
        $allowance->percentage_of_basic = $request->input("percentage");
        $allowance->limit_per_month = $request->input("limit_per_month");
        $result = $allowance->save();
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
        $allowance = Allowance::where(['allowance_id'=>$id])->get();
        return $allowance;
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
            'allowance'=>'required|unique:allowance,allowance_name,'.$id.',allowance_id',
            'allowance_type'=> 'required',
          //  'percentage'=> 'required',
            'limit_per_month'=> 'required',
        ]);

        $allowance = Allowance::where(['allowance_id'=>$id])->update([
            "allowance_name"=>$request->input('allowance'),
            "allowance_type" => $request->input('allowance_type'),
            "percentage_of_basic" => $request->input('percentage'),
            "limit_per_month" => $request->input('limit_per_month'),
        ]);
        return $allowance;
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
        $destroy = Allowance::where('allowance_id',$id)->delete();
        return  $destroy;
    }
}
