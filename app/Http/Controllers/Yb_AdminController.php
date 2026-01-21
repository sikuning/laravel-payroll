<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\GeneralSetting;
use App\Models\Employee;
use App\Models\Departments;
use App\Models\Designations;
use App\Models\LeaveApplications;


use Illuminate\Http\Request;

class Yb_AdminController extends Controller
{
    //
    public function yb_index(Request $request){
		if($request->input()){
			$request->validate([
				'username'=>'required',
				'password'=>'required',
			]); 
		// return Hash::make($request->input('password'));
			$login = Admin::where(['username'=>$request->username])->pluck('password')->first();

			if(empty($login)){
				return response()->json(['username'=>'Username Does not Exists']);
			}else{
				if(Hash::check($request->password,$login)){
					$admin = Admin::first();
					$request->session()->put('admin','1');
					$request->session()->put('admin_name',$admin->admin_name);
					return '1';
				}else{
					return response()->json(['password'=>'Username and Password does not matched']);
				}
			}
	    }else{
        //    $generalSetting = GeneralSetting::Select("com_logo",'com_name')->get();
			return view('admin.admin');
		}
    }

    public function yb_dashboard(){
		$employees = Employee::count();
		$departments = Departments::count();
		$designations = Designations::count();
		$leave_applications = LeaveApplications::select(['leave_applications.*','leave_type.leave_type as leave_name','employees.first_name','employees.last_name','departments.department_name'])
		->where('leave_applications.status','0')
		->leftJoin('employees','employees.emp_id','=','leave_applications.employee_id')
		->leftJoin('leave_type','leave_type.id','=','leave_applications.leave_type')
		->leftJoin('departments','departments.department_id','=','employees.department')
		->get();
		
		return view('admin.dashboard',['employees'=> $employees,'departments'=>$departments,'designations'=>$designations,'leave_applications'=>$leave_applications]);
    }

    public function yb_logout(Request $req){
		Auth::logout();
		session()->forget('admin');
		session()->forget('username');
		return '1';
	}
}
