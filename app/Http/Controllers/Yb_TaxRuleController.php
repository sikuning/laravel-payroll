<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaxRule;
use Yajra\DataTables\DataTables;

class Yb_TaxRuleController extends Controller
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
            $data = TaxRule::orderBy('tax_id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('tax_rate', function($row){
                if($row->tax_rate != ''){
                    $tax_rate = '<span> '.$row->tax_rate.'% </span>';
                }else{
                    $tax_rate = '<span></span>';
                }
                return $tax_rate;
            })
            ->addColumn('action', function($row){
                $btn = '<a href="javascript:void(0)" data-id="'.$row->tax_id.'" class="edit_tax btn btn-success btn-sm"><i class="fa fa-edit"></i></a>';
                return $btn;
            })
            ->rawColumns(['tax_rate','action'])
            ->make(true);
        }
        return view('admin.tax_rule.index');
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
            'income'=>'required',
            'tax'=>'required',
           //'taxableAmount'=>'required',
        ]);
 
        $taxRule = new TaxRule();
        $taxRule->total_income = $request->input("income");
        $taxRule->tax_rate = $request->input("tax");
        $taxRule->taxable_amount = $request->input("taxable_amount");
        $result = $taxRule->save();
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
        $taxRule = TaxRule::where(['tax_id'=>$id])->get();
        return $taxRule;
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
            'income'=>'required',
            'tax'=>'required',
           // 'taxable_amount'=>'required',
        ]);

        $taxRule = TaxRule::where(['tax_id'=>$id])->update([
            "total_income"=>$request->input('income'),
            "tax_rate" => $request->input('tax'),
            "taxable_amount" => $request->input('taxable_amount'),
            "gender" => $request->input('gender'),
        ]);
        return $taxRule;
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
    }
}
