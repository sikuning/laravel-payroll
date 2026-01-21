<?php

namespace App\Http\Controllers;
use App\Models\Departments;
use App\Models\WorkShift;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\Attendance;

use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
// use Session;

use Illuminate\Http\Request;

class Yb_AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employee = Employee::all();
        return view('admin.attendance.attendance',['employee'=>$employee]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.attendance.mark-attendance');
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
            'id'=>'required'
        ]);
 
        $attendance = Attendance::firstOrCreate(['employeeId' => $request->input("id"), 'date' => $request->input("date")]);
        if ($attendance->application_status != '1' || ($attendance->application_status == '1' && $request->input('status') == '1')) {
             if ($request->input('status') == '1') {
                 $attendance->status = '1';
                 $attendance->leaveType = null;
                 $attendance->halfDayType = "0";
 
                 $clock_in = $request->get('clock_in');
                 $clock_out = $request->get('clock_out');
 
                 $attendance->clock_in = $request->input("clockIn");
                 $attendance->clock_out = $request->input("clockOut");
 
                 if ($request->input('is_late') == "1") {
                     $attendance->is_late = 1;
                 } else {
                     $attendance->is_late = 0;
                 }
             } else {
                 $attendance->status = '0';
 
                 if ($request->input('half_day') == '1') {
                     $attendance->halfDayType = "1";
                 } else {
                     $attendance->halfDayType = "0";
                 }
 
                 $attendance->leaveType = $request->input('leaveType');
 
                 $attendance->reason = $request->input('reason');
 
                 $attendance->clock_in = '';
                 $attendance->clock_out = '';
                 $attendance->is_late = 0;
             }
 
             $attendance->updated_by = 'admin';
 
             $attendance->save();
 
            
                 return '1';
         }
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
    public function edit($date)
    {
        //
        
        return view('admin.attendance.edit',['date'=>$date]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $date)
    {
        //
        $data = array_filter(json_decode($request->input("data"), true));
       
        $employeeIDs = array_keys($data);

        foreach ($employeeIDs as $employeeID) {
            
            $attendance = Attendance::firstOrCreate(['employeeId' => $employeeID, 'date' => $date]);

            if ($attendance->application_status != '1' || ($attendance->application_status == '1' && $data[$employeeID]["status"] == '1')) {

                $attendance->status = $data[$employeeID]["status"];
                $attendance->is_late = $data[$employeeID]["late"];
                $attendance->clock_in = $data[$employeeID]["clock_in"];
                $attendance->clock_out = $data[$employeeID]["clock_out"];

                if ($data[$employeeID]["status"] == "1") {
                    
                    $attendance->leaveType = null;
                    $attendance->halfDayType = null;
                    $attendance->reason = '';
                    $attendance->application_status = null;

                } else {
                    if(isset($data[$employeeID]["leaveType"])){
                        $attendance->leaveType = $data[$employeeID]["leaveType"];
                    }else{
                        $attendance->leaveType = null;
                    }
                    if(isset($data[$employeeID]["halfDay"])){
                        $attendance->halfDayType = $data[$employeeID]["halfDay"];
                    }else{
                        $attendance->halfDayType = null;
                    }
                    if(isset($data[$employeeID]["reason"])){
                        $attendance->reason = $data[$employeeID]["reason"];
                    }else{
                        $attendance->reason = null;
                    }
                    
                    $attendance->application_status = null;
                    $attendance->is_late = 0;
                }

                $attendance->updated_by = 'admin';

                $attendance->save();
            }
            
        }
        
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
    }

    public function yb_ajax_attendance(Request $request){
        
        if($request->ajax()){
            if($request->input('date')){
                $date = date('Y-m-d',strtotime($request->input('date')));
            }else{
                $date = date('Y-m-d');
            }

            $leaveTypes = LeaveType::all();
            $officeTime = DB::table('work_shift')->select(['start_time','end_time'])->first();

            $data = Employee::select('employees.first_name as employee_name','employees.emp_id as employeeId',
                'attendances.status','attendances.leaveType',
                'attendances.halfDayType',
                'attendances.application_status',
                'attendances.applied_on',
                'attendances.reason',
                'attendances.date',
                'attendances.clock_in',
                'attendances.clock_out',
                )
                ->leftJoin('attendances',function($join) use ($date){
                    $join->on('attendances.employeeId','=','employees.emp_id');
                    $join->where('attendances.date',$date);
                })->orderBy('employees.emp_id','asc')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('employeeId',function($row){
                    return $row->employee_name;
                })
                ->addColumn('status',function($row) use ($leaveTypes){
                    if($row->status == '0'){
                        $s = '<div class="att-checkbox">
                                <input type="checkbox" class="att-check" onchange="showHideLeaveBox('.$row->employeeId.');" id="attendance-status'.$row->employeeId.'" data-bootstrap-switch data-on-text="P" data-off-text="A" data-off-color="danger" data-on-color="success">
                                <label for="attendance-status'.$row->employeeId.'"></label>
                            </div>';
                        $s .= '<div class="leave-form row" id="leaveform'.$row->employeeId.'">
                                <div class="col-6">
                                    <label class="control-label">Leave Type</label>
                                    <select class="form-control leave-type">';
                                        foreach($leaveTypes as $leaves){
                                            $selected = ($leaves->id == $row->leaveType) ? 'selected' : '';
                                            $s .= '<option value="'.$leaves->id.'"  '.$selected.'>'.$leaves->leave_type.'</option>';
                                        }
                                    $s .= '</select>
                                </div>
                                <div class="col-6">
                                    <label class="control-label mr-2">Half Day </label>
                                    <div class="icheck-danger d-inline-block">';
                                        $checked = ($row->halfDayType == '1') ? 'checked' : '';
                                        $s .='<input type="checkbox" '.$checked.' id="checkboxDanger2" class="half-day">
                                        <label for="checkboxDanger2"></label>
                                    </div>  
                                </div>
                                <div class="col-12">
                                    <label class="control-input">Reason</label>
                                    <input class="form-control reason" value="'.$row->reason.'" >
                                </div>
                            </div><input type="hidden" name="employeeId[]" value="'.$row->employeeId.'">';
                    }else{
                        $s ='<div class="att-checkbox">
                                <input type="checkbox" class="att-check" onchange="showHideLeaveBox('.$row->employeeId.');" id="attendance-status'.$row->employeeId.'" checked data-bootstrap-switch data-on-text="P" data-off-text="A" data-off-color="danger" data-on-color="success">
                                <label for="attendance-status'.$row->employeeId.'"></label>
                            </div>
                        ';
                        $s .= '<div class="leave-form row d-none" id="leaveform'.$row->employeeId.'">
                                <div class="col-6">
                                    <label class="control-label">Leave Type</label>
                                    <select class="form-control leave-type">';
                                        foreach($leaveTypes as $leaves){
                                            $selected = ($leaves->id == $row->leaveType) ? 'selected' : '';
                                            $s .= '<option value="'.$leaves->id.'"  '.$selected.'>'.$leaves->leave_type.'</option>';
                                        }
                                    $s .= '</select>
                                </div>
                                <div class="col-6">
                                    <label class="control-label mr-2">Half Day </label>
                                    <div class="icheck-danger d-inline-block">';
                                        $checked = ($row->halfDayType == '1') ? 'checked' : '';
                                        $s .='<input type="checkbox" '.$checked.' id="checkboxDanger'.$row->employeeId.'" class="half-day">
                                        <label for="checkboxDanger'.$row->employeeId.'"></label>
                                    </div>  
                                </div>
                                <div class="col-12">
                                    <label class="control-input">Reason</label>
                                    <input class="form-control reason" value="'.$row->reason.'" >
                                </div>
                            </div><input type="hidden" name="employeeId[]" value="'.$row->employeeId.'">';
                    }
                    return $s; 
                })
                ->addColumn('attendance',function($row){
                    if($row->status == '1' || $row->status == '0'){
                        return '<span class="badge badge-success">MARKED</span>';
                    }else{
                        return '<span class="badge badge-danger">NOT MARKED</span>';
                    }
                })
                ->addColumn('clock-in',function($row) use ($officeTime){
                    $start_time = ($row->clock_in) ? $row->clock_in : $officeTime->start_time;
                    $end_time = ($row->clock_out) ? $row->clock_out : $officeTime->end_time;

                    return '<div class="form-group row">
                                <div class="col-6">
                                    <label for="">Clock In</label>
                                    <input type="time" id="clock-in'.$row->employeeId.'" class="form-control mb-1" value="'.$start_time.'">
                                    <span class="mr-2">Late </span>
                                    <div class="icheck-primary d-inline-block">
                                        <input type="checkbox" id="late'.$row->employeeId.'">
                                        <label for="late'.$row->employeeId.'"></label>
                                    </div> 
                                    </div>
                                <div class="col-6">
                                    <label for="">Clock Out</label>
                                <input type="time" id="clock-out'.$row->employeeId.'" class="form-control" value="'.$end_time.'">
                                </div>
                                </div>';
                })
                ->addColumn('save', function($row) use ($date){
                    $btn = '<button class="btn btn-sm btn-success attendance-mark" data-url="'.url("admin/attendance").'" data-id="'.$row->employeeId.'" data-date="'.$date.'"><i class="fa fa-check"></i></button>';
                    return $btn;
                })
                ->rawColumns(['status','attendance','clock-in','save'])
                ->make(true);
        }
    } 

    public function yb_filter_attendance(Request $request){
        
        if($request->input()){
            
            $attendance = Attendance::select(['employees.emp_id','employees.first_name','attendances.*'])
                            ->leftJoin('employees','employees.emp_id','=','attendances.employeeId')
                            ->whereRaw('MONTH(attendances.date) = ?', [$request->month])
                            ->whereRaw('YEAR(attendances.date) = ?', [$request->year]);
            if($request->employee == 'all'){
                $employee = Employee::all();
                $attendance = $attendance->get();
            }else{
                $employee = Employee::where('emp_id',$request->employee)->get();
                $attendance = $attendance->where('attendances.employeeId', $request->employee)->get();
            }
            $output = [];

            $days_in_month = cal_days_in_month(CAL_GREGORIAN,$request->month,$request->year);
            $output['days_in_month'] = $days_in_month;
           //return $attendance;
            foreach($employee as $user){
                $output['employee'][$user->first_name.$user->last_name] = array_fill(1, $days_in_month, '-');
                foreach($attendance as $att){
                    $date = date('j',strtotime($att->date));
                    if($user->emp_id == $att->emp_id){
                        $output['employee'][$user->first_name.$user->last_name][$date] = 
                        ($att->status == '1') ?
                                '<i class="fa fa-check text-success"></i>' :
                                '<i class="fa fa-times text-danger"></i>'; 
                    }
                }
            }
            return $output;
        }
    }

    public function yb_late_configration(Request $request){
        if($request->input()){
            DB::table('salary_deduction_for_late')->where('id','1')->update([
                'for_days' => $request->for_days,
                'days_of_salary' => $request->days_salary,
                'status' => $request->status,
            ]);
            Session::flash('message', 'Updated Successfully'); 
            return redirect('admin/late_configration');
        }else{
            $data = Db::table('salary_deduction_for_late')->first();
            return view('admin.attendance.late_config',['salary_deduction'=>$data]);
        }
        
    }
}
