<?php

namespace App\Http\Controllers;
use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\Designations;
use App\Models\Departments;
use App\Models\MonthlyPayGrade;
use App\Models\HourlyPayGrade;
use App\Models\WorkShift; 
use App\Models\LeaveType;
use App\Models\LeaveApplications;
use App\Models\Attendance;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class Yb_EmployeeController extends Controller
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
            //$data = Employee::orderBy('emp_id','desc')->get();
            $data = Employee::select(['employees.*','departments.department_name as department'])
                    ->LeftJoin('departments','employees.department','=','departments.department_id')
                    ->orderBy('employees.emp_id','desc')->get();
            return Datatables::of($data)
            ->addColumn('id', function($row){
                return '<b>EMP000'.$row->emp_id.'</b>';
            })
            ->addColumn('emp_img',function($row){ 
                if($row->emp_img != ''){
                    $img = '<img src="'.asset("public/employees/".$row->emp_img).'" width="50px">';
                }else{
                    $img = '<img src="'.asset("public/employees/default.png").'" width="50px">';
                }
                return $img;
            })
            ->addColumn('emp_name', function($row){
                return $row->first_name.' '.$row->last_name;
            })
            ->editColumn('status', function($row){
                if($row->status == '1'){
                    $status = '<span class="btn btn-xs btn-success">Active</span>';
                }else{
                    $status = '<span class="btn btn-xs btn-danger">Inactive</span>';
                }
                return $status;
            })
            ->editColumn('date_of_joining', function($row){
                return date('d M, Y',strtotime($row->date_of_joining));
            })
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $btn = '<a href="employees/'.$row->emp_id.'/edit" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a> <a href="javascript:void(0)" class="delete-employee btn btn-danger btn-sm" data-id="'.$row->emp_id.'"><i class="fa fa-trash"></i></a>';
                return $btn;
            })
            ->rawColumns(['id','emp_img','status','action'])
            ->make(true);
    }
    return view('admin.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $departments = Departments::all();
        $designations = Designations::all();
        $monthly_payGrade = MonthlyPayGrade::all();
        $hourly_payGrade = HourlyPayGrade::all();
        $workShift = WorkShift::all();
        return view('admin.employee.create',['department'=>$departments,'designation'=>$designations,'monthly_pay'=>$monthly_payGrade,'hourly_pay'=>$hourly_payGrade,'workShift'=>$workShift]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     //   return $request->input();
        $request->validate([
            'f_name'=>'required',
            'gender'=>'required',
            'dob'=>'required',
            'phone'=>'required',
            'marital_status'=>'required',
            'email'=>'required|email|unique:employees,email',
            'password'=>'required',
            'department'=>'required',
            'designation'=>'required',
            'join_date'=>'required',
            'work_shift'=>'required',

        ]);

        if($request->img){
            $image = $request->img->getClientOriginalName();
            $request->img->move(public_path('employees'),$image);
        }else {
            $image = "";
        }

        $employee = new Employee();
        $employee->emp_img = $image;
        $employee->first_name = $request->input("f_name");
        $employee->last_name = $request->input("l_name");
        $employee->phone = $request->input("phone");
        $employee->gender = $request->input("gender");
        $employee->dob = $request->input("dob");
        $employee->address = $request->input("address");
        $employee->emergenecy_contact = $request->input("emergency_contact");
        $employee->religion = $request->input("religion");
        $employee->email  = $request->input("email");
        $employee->password  = Hash::make($request->input("password"));
        $employee->department = $request->input("department");
        $employee->designation = $request->input("designation");
        if($request->monthly_pay){
            $employee->monthly_pay = $request->input("monthly_pay");
        }
        if($request->hourly_pay){
            $employee->hourly_pay = $request->input("hourly_pay");
        }
        $employee->date_of_joining = $request->input("join_date");
        $employee->date_of_leaving = $request->input("leave_date");
        $employee->work_shift = $request->input("work_shift");
        $employee->marital_status = $request->input("marital_status");
        $result = $employee->save();

        $emp_id = Employee::orderBy('emp_id','desc')->pluck('emp_id')->first();

        if($request->university){
        $education = [];
        for($i=0;$i<count($request->university);$i++){
            $education[$i]['employee'] = $emp_id;
            $education[$i]['university'] = $request->university[$i];
            $education[$i]['degree'] = $request->degree[$i];
            $education[$i]['pass_year'] = $request->pass_year[$i];
            $education[$i]['cgpa'] = $request->cgpa[$i];
        }
        DB::table('employee_education')->insert($education);
        }

        if($request->organisation){
        $experience = [];
        for($j=0;$j<count($request->organisation);$j++){
            $experience[$j]['employee'] = $emp_id;
            $experience[$j]['organisation'] = $request->organisation[$j];
            $experience[$j]['designation'] = $request->exp_designation[$j];
            $experience[$j]['from_date'] = $request->exp_from[$j];
            $experience[$j]['to_date'] = $request->exp_to[$j];
            $experience[$j]['responsibility'] = $request->responsibility[$j];
            $experience[$j]['skills'] = $request->skill[$j];
        }
        DB::table('employee_experience')->insert($experience);
        }
        return '1';
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
        $employee = Employee::where(['emp_id'=>$id])->first();
        $education = DB::table('employee_education')->where(['employee'=>$id])->get();
        $experience = DB::table('employee_experience')->where(['employee'=>$id])->get();
        $departments = Departments::all();
        $designations = Designations::where('department_id',$employee->department)->get();
        $monthly_payGrade = MonthlyPayGrade::all();
        $hourly_payGrade = HourlyPayGrade::all();
        $workShift = WorkShift::all();
        return view('admin.employee.edit',['employee'=>$employee,'education'=>$education,'experience'=>$experience,'department'=>$departments,'designation'=>$designations,'monthly_pay'=>$monthly_payGrade,'hourly_pay'=>$hourly_payGrade,'workShift'=>$workShift]);
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
            'f_name'=>'required',
            'phone'=>'required',
            'gender'=>'required',
            'dob'=>'required',
            'email'=>'required|email|unique:employees,email,' .$id. ',emp_id',
            'department'=>'required',
            'designation'=>'required',
            'join_date'=>'required',
            'marital_status'=>'required',
            'work_shift'=>'required',
            'status'=>'required',
        ]);
        // Update Provider Image
          if($request->img != ''){        
            $path = public_path().'/employees/';
            //code for remove old file
            if($request->old_img != ''  && $request->old_img != null){
                $file_old = $path.$request->old_img;
                if(file_exists($file_old)){
                    unlink($file_old);
                }
            }
            //upload new file
            $file = $request->img;
            $image = $request->img->getClientOriginalName();
            $file->move($path, $image);
        }else{
            $image = $request->old_img;
        }

        // Update Provider Password
        if($request->password != ''){ 
            $password = Hash::make($request->password);
        }else{
            $password = $request->old_password;
        }

        $employee = Employee::where(['emp_id'=>$id])->update([
            "emp_img" => $image,
            "first_name" => $request->input("f_name"),
            "last_name" => $request->input("l_name"),
            "phone" => $request->input("phone"),
            "gender" => $request->input("gender"),
            "dob" => $request->input("dob"),
            "address" => $request->input("address"),
            "emergenecy_contact" => $request->input("emergency_contact"),
            "religion" => $request->input("religion"),
            "email" => $request->input("email"),
            "password" => $password,
            "department" => $request->input("department"),
            "designation" => $request->input("designation"),
            "monthly_pay" => $request->input("monthly_pay"),
            "hourly_pay" => $request->input("hourly_pay"),
            "date_of_joining" => $request->input("join_date"),
            "date_of_leaving" => $request->input("leaves-date"),
            "marital_status" => $request->input("marital_status"),
            "work_shift" => $request->input("work_shift"),
            "status" => $request->input("status"),
        ]);

        if($request->university){
            DB::table('employee_education')->where('employee',$id)->delete();
            $education = [];
            for($i=0;$i<count($request->university);$i++){
                $education[$i]['employee'] = $id;
                $education[$i]['university'] = $request->university[$i];
                $education[$i]['degree'] = $request->degree[$i];
                $education[$i]['pass_year'] = $request->pass_year[$i];
                $education[$i]['cgpa'] = $request->cgpa[$i];
            }
            DB::table('employee_education')->insert($education);
            }
    
            if($request->organisation){
                DB::table('employee_experience')->where('employee',$id)->delete();
            $experience = [];
            for($j=0;$j<count($request->organisation);$j++){
                $experience[$j]['employee'] = $id;
                $experience[$j]['organisation'] = $request->organisation[$j];
                $experience[$j]['designation'] = $request->exp_designation[$j];
                $experience[$j]['from_date'] = $request->exp_from[$j];
                $experience[$j]['to_date'] = $request->exp_to[$j];
                $experience[$j]['responsibility'] = $request->responsibility[$j];
                $experience[$j]['skills'] = $request->skill[$j];
            }
            DB::table('employee_experience')->insert($experience);
            }
        return $employee;
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
        $destroy = Employee::where('emp_id',$id)->delete();
        return  $destroy;
    }


    public function yb_login(Request $req){
        if($req->input()){
            $req->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);

            $user = $req->input('email');
            $pass = $req->input('password');

            $login = Employee::select(['emp_id','first_name','email','password'])
                            ->where('email',$user)->first();
            if($login){
                // return $login['emp_id'];
                if(Hash::check($pass,$login['password'])){
                        $req->session()->put('emp_id',$login['emp_id']);
                        $req->session()->put('first_name',$login['first_name']);
                        return '1'; 
                }else{
                    return 'Email Address and Password Not Matched.'; 
                }
            }else{
                return 'Email Does Not Exists'; 
            }
        }else{
            return view('employee/employee_login');
        }
    }

    public function yb_profile(Request $request){
        $value = $request->session()->get('emp_id');
        $education = DB::table('employee_education')->where('employee',$value)->get();
        $experience = DB::table('employee_experience')->where('employee',$value)->get();

        $data= Employee::Select(['employees.*','departments.department_name as department','designations.designation_name as designation'])
        ->leftJoin('departments','employees.department', '=','departments.department_id')
        ->leftJoin('designations','employees.designation', '=','designations.designation_id')
        ->where(["employees.emp_id" => $value])->get();
        // return $data;
        return view('employee.home',['data'=> $data,'education'=>$education,'experience'=>$experience]);
    }

    public function yb_my_leaves(){ 
        $value = session()->get('emp_id');
        $LeaveType = LeaveType::all();
        $data= Employee::Select(['employees.*','departments.department_name as department','designations.designation_name as designation'])
        ->leftJoin('departments','employees.department', '=','departments.department_id')
        ->leftJoin('designations','employees.designation', '=','designations.designation_id')
        ->where(["employees.emp_id" => $value])->get();

        return view('employee.employee-leave',['data'=> $data,'LeaveType'=>$LeaveType]); 
   }

    public function yb_add_leave(Request $request){
           $request->validate([
            'from_date'=> 'required',
            'to_date'=> 'required',
            'leave' => 'required',
            'reason' => 'required'
        ]);
        $value = $request->session()->get('emp_id');
        $LeaveApplications = new LeaveApplications();
        $LeaveApplications->employee_id = $value;
        $LeaveApplications->from_date  = $request->input("from_date");
        $LeaveApplications->to_date  = $request->input("to_date");
        $LeaveApplications->leave_type = $request->input("leave");
        $LeaveApplications->reason  = $request->input("reason");
        $result =  $LeaveApplications->save();
        return $result;
    }
    
    public function yb_logout(Request $request){
        $request->session()->forget('emp_id');
        $request->session()->forget('first_name');
        return redirect('employee-login');
    }
}
