<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MonthlyPayGrade;
use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\Employee;
use Yajra\DataTables\DataTables;

class Yb_MonthlyPayGradeController extends Controller
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
            $data = MonthlyPayGrade::orderBy('monthly_id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="pay_grade/'.$row->monthly_id.'/edit"  class="edit_pay btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete-pay btn btn-danger btn-sm" data-id="'.$row->monthly_id.'">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        return view('admin.pay_grade.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $allowance = Allowance::all();
        $deduction = Deduction::all();
        return view('admin.pay_grade.create',['allowance'=> $allowance,'deduction'=> $deduction]);
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
            'pay_grade'=> 'required|unique:monthly_pay_grade,pay_grade',
           // 'overtime_rate'=> 'required',
            'gross_salary'=> 'required',
            'percentage'=> 'required',
           // 'basic_salary'=> 'required',
           // 'allowance'=> 'required',
           // 'deduction'=> 'required',
        ]);
        // return Allowance::pluck('allowance_id')->toArray();
        $monthly_payGrade = new MonthlyPayGrade();
        $monthly_payGrade->pay_grade = $request->input("pay_grade");
        $monthly_payGrade->overtime_rate = $request->input("overtime_rate");
        $monthly_payGrade->gross_salary = $request->input("gross_salary");
        $monthly_payGrade->percentage_of_basic = $request->input("percentage");
        $monthly_payGrade->basic_salary = $request->input("basic_salary");
        if($request->allowance || $request->all_allowance){
            if($request->input("all_allowance")){ 
                $monthly_payGrade->allowance = implode(',',Allowance::pluck('allowance_id')->toArray());
            }else{
                $monthly_payGrade->allowance = implode(',',$request->input("allowance"));
            }
        }
        
        if($request->deduction || $request->all_deduction){
            if($request->input("all_deduction")){ 
                $monthly_payGrade->deduction = implode(',',Deduction::pluck('deduction_id')->toArray());
            }else{
                $monthly_payGrade->deduction = implode(',',$request->input("deduction"));
            }
        }
        $result = $monthly_payGrade->save();
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
        $allowance = Allowance::all();
        $deduction = Deduction::all();
        $monthly_payGrade =  MonthlyPayGrade::where(['monthly_id'=>$id])->first();
        return view('admin.pay_grade.edit',['payGrade'=> $monthly_payGrade,'allowance'=> $allowance,'deduction'=> $deduction]);
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
            'pay_grade'=> 'required|unique:monthly_pay_grade,pay_grade,'.$id. ',monthly_id',
            // 'overtime_rate'=> 'required',
            'gross_salary'=> 'required',
            'percentage'=> 'required',
           // 'basic_salary'=> 'required',
            // 'allowance'=> 'required',
            // 'deduction'=> 'required',
        ]);
        if($request->allowance || $request->all_allowance){
            if($request->input("all_allowance")){ 
                $allowance = implode(',',Allowance::pluck('allowance_id')->toArray());
            }else{
                $allowance = implode(',',$request->input("allowance"));
            }
        }else{
            $allowance = '';
        }
        if($request->deduction || $request->all_deduction){
            if($request->input("all_deduction")){ 
                $deduction = implode(',',Deduction::pluck('deduction_id')->toArray());
            }else{
                $deduction =implode(',',$request->input("deduction"));
            }
        }else{
            $deduction = '';
        }
        $monthly_payGrade = MonthlyPayGrade::where(['monthly_id'=>$id])->update([
           'pay_grade' => $request->input("pay_grade"),
           'overtime_rate' => $request->input("overtime_rate"),
           'gross_salary' => $request->input("gross_salary"),
           'percentage_of_basic'=> $request->input("percentage"),
           'basic_salary' => $request->input("basic_salary"),
           'allowance' => $allowance,
           'deduction' => $deduction,
        ]);
        return $monthly_payGrade;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = Employee::where('monthly_pay',$id)->count();
        if($check == 0){
            $destroy = MonthlyPayGrade::where('monthly_id',$id)->delete();
            return  $destroy;
        }else{
            return "You won't Delete this (This Name is used in Employees Table.)";
        }
    }
}
