<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\GenerateSalarySheet;
use App\Models\Employee;
use App\Models\HourlyPayGrade;
use App\Models\Allowance;
use App\Models\Deduction;
use App\Models\TaxRule;
use App\Models\Attendance;
use App\Models\MonthlyPayGrade;
use App\Models\LeaveApplications;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use DateTime;

class Yb_GenerateSalarySheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $data = DB::table('salary_details')->select(['employees.*','salary_details.*','departments.department_name','designations.designation_name'])
            ->leftJoin('employees','employees.emp_id','=','salary_details.employee')
            ->leftJoin('departments','departments.department_id','=','employees.department')
            ->leftJoin('designations','designations.designation_id','=','employees.designation')
            ->orderBy('salary_details.id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('emp_name',function($row){
                return $row->first_name.' '.$row->last_name;
            })
            ->editColumn('department_name',function($row){
                return '('.$row->designation_name.') '. $row->department_name;
            })
            ->editColumn('month',function($row){
                return date('M Y',strtotime($row->month));
            })
            ->editColumn('status',function($row){
                if($row->status == '1'){
                    $status = '<span class="badge badge-success">Paid</span>';
                }else{
                    $status = '<span class="badge badge-warning">Unpaid</span>';
                }
                return $status;
            })
            ->addColumn('action', function($row){
                if($row->status == '0'){
                    $btn = '<button type="button" data-id="'.$row->id.'" class="btn btn-primary btn-sm pay-salary">Pay Salary</button>';
                }else{
                    $btn = '<a href="salary_sheet/'.$row->id.'" class="btn btn-success btn-sm">Get Payslip</a>';
                }
                return $btn;
            })
            ->rawColumns(['department_name','status','action'])
            ->make(true);
        }
        return view('admin.salary_sheet.index');
    }

    public function calculateTax($gross_salary,$basic_salary,$date_of_birth,$gender,$pay_grade_id)
    {
        $result     = $this->calculateAllowance($basic_salary,$pay_grade_id);
        $birthday   = $this->getEmployeeAge($date_of_birth);
        $tax    = 0;
        $tax = $gross_salary - $result['totalAllowance'];
        $totalTax = $tax * 12;
        // if($birthday >= 65 || $gender == 'Female'){
            $taxRule = TaxRule::get();
        // }else{
            // $taxRule = TaxRule::where('gender','m')->get();
        // }

        $yearlyTax = 0;
        foreach ($taxRule as $value){
            if($totalTax <= 0){
                break;
            }
            if($totalTax >= $value->total_income && $value->total_income !=0){
                $yearlyTax +=($value->total_income * $value->tax_rate) / 100;
                $totalTax = $totalTax - $value->total_income;
            }else{
                $yearlyTax +=($totalTax * $value->tax_rate) / 100;
                 $totalTax = $totalTax - $totalTax;
            }
        }

        $monthlyTax = 0;
        if($yearlyTax !=0){
            $monthlyTax = $yearlyTax / 12;
        }
        $data =[
            'monthlyTax'          => round($monthlyTax),
            'taxAbleSalary'          => $tax,
        ];

        return $data;
    }

    public function calculateAllowance($basic_salary,$pay_grade_id)
    {
        $alw_ids = MonthlyPayGrade::where('monthly_id',$pay_grade_id)->pluck('allowance')->first();
        $alw_ids = array_filter(explode(',',$alw_ids));
        $allowances = Allowance::whereIn('allowance_id',$alw_ids)->get();
        

        $allowanceArray = [];
        $totalAllowance = 0;
        foreach ($allowances as $key => $allowance){
            $temp                           = [];
            $temp['allowance_id']           = $allowance->allowance_id;
            $temp['allowance_name']         = $allowance->allowance_name;
            $temp['allowance_type']         = $allowance->allowance_type;
            $temp['percentage_of_basic']    = $allowance->percentage_of_basic;
            $temp['limit_per_month']        = $allowance->limit_per_month;
            
            if($allowance->allowance_type == '1'){
                $percentageOfAllowance = ($basic_salary * $allowance->percentage_of_basic) / 100;
                 if($allowance->limit_per_month !=0 && $percentageOfAllowance >= $allowance->limit_per_month){
                     $temp['amount_of_allowance'] = $allowance->limit_per_month;
                 }else {
                     $temp['amount_of_allowance'] = $percentageOfAllowance;
                 }
            }else{
                $temp['amount_of_allowance'] = $allowance->limit_per_month;
            }
            $totalAllowance +=$temp['amount_of_allowance'];
            $allowanceArray[$key] = $temp;
        }

        return ['allowanceArray'=>$allowanceArray, 'totalAllowance'=>$totalAllowance];
    }

    public function calculateDeduction($basic_salary,$pay_grade_id)
    {
        $ddc_ids = MonthlyPayGrade::where('monthly_id',$pay_grade_id)->pluck('deduction')->first();
        $ddc_ids = array_filter(explode(',',$ddc_ids));
        $deductions = Deduction::whereIn('deduction_id',$ddc_ids)->get();

        $deductionArray = [];
        $totalDeduction = 0;
        foreach ($deductions as $key => $deduction){
            $temp                           = [];
            $temp['deduction_id']           = $deduction->deduction_id;
            $temp['deduction_name']         = $deduction->deduction_name;
            $temp['deduction_type']         = $deduction->deduction_type;
            $temp['percentage_of_basic']    = $deduction->percentage_of_basic;
            $temp['limit_per_month']        = $deduction->limit_per_month;

            if($deduction->deduction_type == '1'){
                $percentageOfDeduction = ($basic_salary * $deduction->percentage_of_basic) / 100;
                if($deduction->limit_per_month !=0 && $percentageOfDeduction >= $deduction->limit_per_month){
                    $temp['amount_of_deduction'] = $deduction->limit_per_month;
                }else {
                    $temp['amount_of_deduction'] = $percentageOfDeduction;
                }
            }else{
                $temp['amount_of_deduction'] = $deduction->limit_per_month;
            }
            $totalDeduction +=$temp['amount_of_deduction'];
            $deductionArray[$key] = $temp;
        }
        return ['deductionArray'=>$deductionArray, 'totalDeduction'=>$totalDeduction];
    }

    


    public function getEmployeeAge($date_of_birth)
    {
        $birthday = new DateTime ($date_of_birth);
        $currentDate = new DateTime ( 'now' );
        $interval = $birthday->diff ( $currentDate );
        return $interval->y;
    }


    public function getEmployeeOtmAbsLvLtAndWokDays($employee_id,$month,$overtime_rate,$basic_salary){

        $getDate = $this->getMonthToStartDateAndEndDate($month);
        // return $getDate;
        $queryResult =  $this->getEmployeeMonthlyAttendance($getDate['firstDate'], $getDate['lastDate'],$employee_id);
        // return $queryResult;

        $overTime = [];
        $totalPresent = 0;
        $totalAbsence = 0;
        $totalLeave   = 0;
        $totalLate    = 0;
        $totalLateAmount    = 0;
        $totalAbsenceAmount    = 0;
        $totalWorkingDays    = count($queryResult);

        foreach ($queryResult as $value){
            if($value['action'] =='Absence'){
                $totalAbsence +=1;
            }elseif($value['action'] =='Leave'){
                $totalLeave +=1;
            }else{
                $totalPresent +=1;
            }

            if($value['ifLate'] == 'Yes'){
                $totalLate +=1;
            }

            $workingHour = new DateTime($value['workingHour']);
            $workingTime = new DateTime($value['working_time']);
            if($workingHour < $workingTime){
                $interval = $workingHour->diff($workingTime);
                $overTime[]= $interval->format('%H:%I');
            }
        }

        /**
         * @employee Salary Deduction For Late Attendance
        */

        $salaryDeduction = DB::table('salary_deduction_for_late')->where('status','1')->first();
        $dayOfSalaryDeduction = 0;
        $oneDaysSalary = 0;
        if($basic_salary!=0 && $totalWorkingDays!=0 && $totalLate !=0 && !empty($salaryDeduction)){
            $numberOfDays = 0;
             for($i=1;$i<=$totalLate;$i++){
                 $numberOfDays++;
                 if($numberOfDays == $salaryDeduction->for_days){
                     $dayOfSalaryDeduction +=1;
                     $numberOfDays = 0;
                 }
             }

            $oneDaysSalary = $basic_salary / $totalWorkingDays;
            $totalLateAmount = $oneDaysSalary * $dayOfSalaryDeduction;

        }

        /**
        * @employee Salary Deduction For absence
        */

        if($totalAbsence !=0 && $basic_salary!=0 && $totalWorkingDays!=0){
           $perDaySalary = $basic_salary /$totalWorkingDays;
           $totalAbsenceAmount = $perDaySalary * $totalAbsence;
        }

        $oneDaySalary = $basic_salary /$totalWorkingDays;

        $overTime = $this->calculateEmployeeTotalOverTime($overTime,$overtime_rate);
        $data =[
            'overtime_rate'          => $overtime_rate,
            'totalOverTimeHour'      => $overTime['totalOverTimeHour'],
            'totalOvertimeAmount'    => $overTime['overtimeAmount'],
            'totalPresent'           => $totalPresent,
            'totalAbsence'           => $totalAbsence,
            'totalAbsenceAmount'     => round($totalAbsenceAmount),
            'totalLeave'             => $totalLeave,
            'totalLate'              => $totalLate,
            'dayOfSalaryDeduction'   => $dayOfSalaryDeduction,
            'totalLateAmount'        => round($totalLateAmount),
            'totalWorkingDays'       => $totalWorkingDays,
            'oneDaysSalary'          => round($oneDaySalary),
        ];

        return $data;
    }

    public function getEmployeeMonthlyAttendance($from_date, $to_date,$employee_id){
        // $monthlyAttendanceData  = DB::select("CALL `SP_monthlyAttendance`('".$employee_id."','".$from_date."','".$to_date."')");
        // $monthlyAttendanceData  = DB::table('employees')->select(['employees.emp_id','departments.department_name','attendances.*',DB::raw("CONCAT(employees.first_name,' ',employees.last_name') AS fullname"),DB::raw("DATE_FORMAT(attendances.clock_in,'%h:%i') AS in_time"),DB::raw("DATE_FORMAT(attendances.clock_out,'%h:%i %p') AS out_time"),DB::raw("TIME_FORMAT( work_shift.late_count_time, '%H:%i:%s' ) as lateCountTime","(CASE WHEN DATE_FORMAT(MIN(attendances.clock_in),'%H:%i:00') > lateCountTime THEN 'Yes' ELSE 'No' END) AS  ifLate,(SELECT CASE WHEN TIMEDIFF((DATE_FORMAT(MIN(attendances.clock_in),'%H:%i:%s')),work_shift.late_count_time) > '0' THEN TIMEDIFF((DATE_FORMAT(MIN(attendances.clock_in),'%H:%i:%s')),work_shift.late_count_time) ELSE '00:00:00' END) AS  totalLateTime, TIMEDIFF((DATE_FORMAT(work_shift.`end_time`,'%H:%i:%s')),work_shift.`start_time`) AS workingHour")])
        // ->rightJoin('attendances','attendances.employeeId','=','employees.emp_id')
        // ->leftJoin('departments','departments.department_id','=','employees.department')
        // ->whereBetween('attendances.date', [$from_date, $to_date])
        // ->where('employees.status',1)
        // ->where('employees.emp_id',$employee_id)
        // ->groupBy('attendances.date')->get();
        $attendances = Attendance::where('employeeId',$employee_id)
                                    ->whereBetween('date', [$from_date, $to_date])
                                    ->get();
        // return $attendances;
        $work_shift = Employee::where('emp_id',$employee_id)
                                ->select('work_shift.*')                        
                                ->leftJoin('work_shift','work_shift.shift_id','=','employees.work_shift')
                                ->first();
        // return $work_shift;

        $monthlyAttendanceData = [];
        foreach($attendances as $key => $att){
            $monthlyAttendanceData[$key]['date'] = $att->date;
            $monthlyAttendanceData[$key]['employeeId'] = $att->employeeId;
            $monthlyAttendanceData[$key]['department_name'] = $att->employeeId;
            if(strtotime($att->clock_in) > strtotime($work_shift->late_count_time)){
                $monthlyAttendanceData[$key]['ifLate'] = 'Yes';
            }else{
                $monthlyAttendanceData[$key]['ifLate'] = 'No';
            }
            $lateDiff = (strtotime($att->clock_in) - strtotime($work_shift->late_count_time));
            if($lateDiff > 0){
                $monthlyAttendanceData[$key]['totalLateTime'] = $lateDiff;
            }else{
                $monthlyAttendanceData[$key]['totalLateTime'] = "00:00:00";
            }
            $monthlyAttendanceData[$key]['workingHour'] = date('H:i:s',(strtotime($work_shift->end_time) - strtotime($work_shift->start_time)));
            $monthlyAttendanceData[$key]['clock_in'] = $att->clock_in;
            $monthlyAttendanceData[$key]['clock_out'] = $att->clock_out;

        }

        // return $monthlyAttendanceData;
        $workingDates           = $this->number_of_working_days_date($from_date, $to_date);
        // return $workingDates;
        $employeeLeaveRecords   = $this->getEmployeeLeaveRecord($from_date, $to_date,$employee_id);

        $dataFormat = [];
        $tempArray  = [];
        if($workingDates && $monthlyAttendanceData) {
            foreach ($workingDates as $data) {
                $flag = 0;
                foreach ($monthlyAttendanceData as $value) {
                    // return $value;
                    if ($data == $value['date']) {
                        $flag = 1;
                        break;
                    }
                }
                if ($flag == 0) {
                    $tempArray['employee_id']       = $value['employeeId'];
                    // $tempArray['fullName']          = $value->fullName;
                    // $tempArray['department_name']   = $value->department_name;
                    $tempArray['date']              = $data;
                    $tempArray['working_time']      = '';
                    $tempArray['in_time']           = '';
                    $tempArray['out_time']          = '';
                    $tempArray['lateCountTime']     = '';
                    $tempArray['ifLate']            = '';
                    $tempArray['totalLateTime']     = '';
                    $tempArray['workingHour']       = '';
                    if (in_array($data, $employeeLeaveRecords)) {
                        $tempArray['action']        = 'Leave';
                    } else {
                        $tempArray['action']        = 'Absence';
                    }
                    $dataFormat[] = $tempArray;
                } else {
                    $tempArray['employee_id']       = $value['employeeId'];
                    // $tempArray['fullName']          = $value->fullName;
                    // $tempArray['department_name']   = $value->department_name;
                    $tempArray['date']              = $value['date'];
                    $tempArray['working_time']      = $value['workingHour'];
                    // $tempArray['in_time']           = $value->in_time;
                    $tempArray['in_time']           = $value['clock_in'];
                    // $tempArray['out_time']          = $value->out_time;
                    $tempArray['out_time']          = $value['clock_out'];
                    // $tempArray['lateCountTime']     = $value->lateCountTime;
                    $tempArray['ifLate']            = $value['ifLate'];
                    $tempArray['totalLateTime']     = $value['totalLateTime'];
                    $tempArray['workingHour']       = $value['workingHour'];
                    $tempArray['action']            = '';
                    $dataFormat[]                   = $tempArray;
                }
            }
        }

       return $dataFormat;

    }

    public function number_of_working_days_date($from_date, $to_date) {
        // $holidays  = DB::select(DB::raw('call SP_getHoliday("'. $from_date .'","'.$to_date .'")'));
        $holidays  = DB::table('holiday_details')->select('from_date','to_date')
                        ->where('from_date','>=',$from_date)
                        ->where('to_date','>=',$to_date)
                        ->get();
        $public_holidays = [];
        foreach ($holidays as $holidays) {
            $start_date = $holidays->from_date;
            $end_date   = $holidays->to_date;
            while (strtotime($start_date) <= strtotime($end_date)) {
                $public_holidays[] = $start_date;
                $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
            }
        }

        // $weeklyHolidays = DB::select(DB::raw('call SP_getWeeklyHoliday()'));
        $weeklyHolidays = DB::table('weekly_holidays')->select('day_name')->where('status','1')->get();
        $weeklyHolidayArray = [];
        foreach ($weeklyHolidays as $weeklyHoliday){
            $weeklyHolidayArray[]=$weeklyHoliday->day_name;
        }

        $target = strtotime($from_date);
        $workingDate = [];

        while ($target <= strtotime(date("Y-m-d", strtotime($to_date)))) {
            //get weekly  holiday name
            $timestamp  = strtotime(date('Y-m-d', $target));
            $dayName    = date("l", $timestamp);

            if(!in_array(date('Y-m-d', $target),$public_holidays) && !in_array($dayName,$weeklyHolidayArray)) {
                array_push($workingDate, date('Y-m-d', $target));
            }
            if(date('Y-m-d') <= date('Y-m-d', $target)){
                break;
            }
            $target += (60 * 60 * 24);
        }
        return $workingDate;
    }



    public function getEmployeeLeaveRecord($from_date, $to_date,$employee_id){
        $queryResult = LeaveApplications::select('from_date','to_date')
                        ->where('status','1')
                        ->where('from_date','>=',$from_date)
                        ->where('to_date','<=',$to_date)
                        ->where('employee_id',$employee_id)
                        ->get();
        $leaveRecord = [];
        foreach ($queryResult as $value) {
            $start_date = $value->application_from_date;
            $end_date   = $value->application_to_date;
            while (strtotime($start_date) <= strtotime($end_date)) {
                $leaveRecord[] = $start_date;
                $start_date = date("Y-m-d", strtotime("+1 day", strtotime($start_date)));
            }
        }
        return $leaveRecord;
    }




    public function calculateEmployeeTotalOverTime($overTime, $overtime_rate)
    {

        $totalMinute = 0;
        $minuteWiseAmount = 0;
        $hour = 0;
        $minutes = 0;
        foreach($overTime  as $key => $value) {

            $value = explode(':',$value);
            $hour += $value[0];
            $minutes += $value[1];
            if($minutes>=60){
                $minutes -= 60;
                $hour ++;
            }
        }
        $hours   = $hour.':'.(($minutes<10)?'0'.$minutes:$minutes);
        $value   = explode(':',$hours);
        $totalMinute = $value[1];
        if($totalMinute !=0 && $overtime_rate!=0){

            $perMinuteAmount = $overtime_rate / 60;
            $minuteWiseAmount = $perMinuteAmount * $totalMinute;

        }
         $overtimeAmount = ($value[0] * $overtime_rate) + $minuteWiseAmount;


        return ['totalOverTimeHour' => $hours,'overtimeAmount' => round($overtimeAmount)];
    }



    public function getMonthToStartDateAndEndDate($month){

        $month = explode('-',$month);
        $current_year = $month[0];
        $lastMonth    = $month[1];

        $firstDate = $current_year."-".$lastMonth."-01" ;
        $lastDateOfMonth = date('t',strtotime($firstDate));
        $lastDate = $current_year."-".$lastMonth."-".$lastDateOfMonth ;

        return['firstDate'=>$firstDate,'lastDate'=>$lastDate];

    }


    public function getEmployeeHourlySalary($employee_id,$month,$hourly_rate){
        $getDate     = $this->getMonthToStartDateAndEndDate($month);
        $queryResult = DB::table('attendances')->where('employeeId',$employee_id)->whereBetween('date', [$getDate['firstDate'], $getDate['lastDate']])->get()->toArray();
        // return $queryResult;
        $totalAmountOfSalary = 0;
        $hour    = 0;
        $minutes = 0;
        foreach ($queryResult as $value){
            $diff = strtotime($value->clock_out) - strtotime($value->clock_in);
            $value = explode(':',date('H:i', $diff));
            $hour += $value[0];
            $minutes += $value[1];
            if($minutes>=60){
                $minutes -= 60;
                $hour ++;
            }
        }

        $totalTime   = $hour.':'.(($minutes<10)?'0'.$minutes:$minutes);
        $perMinuteAmount = $hourly_rate / 60;
        $minuteWiseAmount = $perMinuteAmount * (($minutes<10)?'0'.$minutes:$minutes);

        $totalAmountOfSalary = ($hour * $hourly_rate) + $minuteWiseAmount;;

        $data = [
            'totalWorkingHour' =>  $totalTime,
            'totalSalary' =>  round($totalAmountOfSalary),
        ];
        return $data;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->input()){
            // return $request->employee;
            $search_emp = $request->employee;
            $search_year_month = array_filter(explode('-',$request->month));
            $search_year = $search_year_month['0'];
            $search_month = $search_year_month['1'];
            
            $query = Attendance::where('employeeId',$request->employee)
                            ->whereMonth('date',$search_month)->get();
            if(count($query) <= 0){
                Session::flash('error', 'No attendance found.');
                return redirect('admin/salary_sheet');
            }

            $queryResult = DB::table('salary_details')->where('employee',$request->employee)->where('month',$request->month)->count();
            // return $queryResult;
            if($queryResult > 0){
                Session::flash('error', 'Salary already generated for this month.');
                return redirect('admin/salary_sheet');
            }

            $employeeDetails = Employee::select(['employees.*','departments.department_name as department','designations.designation_name as designation','hourly_pay_grade.hourly_rate','monthly_pay_grade.pay_grade','monthly_pay_grade.basic_salary','monthly_pay_grade.gross_salary'])
                        ->leftJoin('departments','employees.department', '=','departments.department_id')
                        ->leftJoin('designations','employees.designation', '=','designations.designation_id')
                        ->leftJoin('monthly_pay_grade','employees.monthly_pay', '=','monthly_pay_grade.monthly_id')
                        ->leftJoin('hourly_pay_grade','employees.hourly_pay', '=','hourly_pay_grade.hourly_id')->where('employees.emp_id',$request->employee)->first();

            if($employeeDetails->monthly_pay != '') {
                $employeeAllInfo = [];
                $allowance = [];
                $deduction = [];
                $tax = 0;

                $from_date = $request->month."-01" ;
                $to_date = date('Y-m-t',strtotime($from_date));

                $leaveRecord =  LeaveApplications::select('leave_applications.*')
                                ->join('leave_type', 'leave_type.id','leave_applications.leave_type')
                                ->where('status','1')
                                ->where('from_date','>=',$from_date)
                                ->where('to_date','<=',$to_date)
                                ->where('employee_id',$request->employee)
                                ->get();

                // $monthAndYear    = explode('-',$request->month);
                $start_year          = $search_year.'-01';
                $end_year            = $search_year.'-12';

                $financialYearTax = DB::table('salary_details')->select(DB::raw('SUM(tax) as totalTax'))
                                ->where('status',1)
                                ->where('employee',$request->employee)
                                ->whereBetween('month',[$start_year,$end_year])
                                ->first();

                $allowance = $this->calculateAllowance($employeeDetails->basic_salary,$employeeDetails->monthly_pay);

                $deduction = $this->calculateDeduction($employeeDetails->basic_salary,$employeeDetails->monthly_pay);

                $tax = $this->calculateTax(
                    $employeeDetails->gross_salary,
                    $employeeDetails->basic_salary,
                    $employeeDetails->DOB,
                    $employeeDetails->gender,
                    $employeeDetails->monthly_pay
                );
                // return $tax;
                $employeeAllInfo = $this->getEmployeeOtmAbsLvLtAndWokDays(
                    $request->employee, $request->month,
                    $employeeDetails->overtime_rate,
                    $employeeDetails->basic_salary
                );

                // return $employeeAllInfo;

                $last_salary_id = DB::table('salary_details')->orderBy('id','DESC')->pluck('id')->first();
                // return $last_salary_id;
                $data = [
                    // 'employee_list'      => $employeeList,
                    'salary_id' => $last_salary_id,
                    'allowance'        => $allowance,
                    'deduction'        => $deduction,
                    'tax'               => $tax['monthlyTax'],
                    'taxAbleSalary'     => $tax['taxAbleSalary'],
                    'employee_id'       => $request->employee,
                    'month'             => $request->month,
                    'employeeAllInfo'   => $employeeAllInfo,
                    'employee'   => $employeeDetails,
                    'leaveRecords'      => $leaveRecord,
                    'financialYearTax'  => $financialYearTax,
                    'employeeGrossSalary'  => $employeeDetails->gross_salary,
                ];
            }else{
                $last_salary_id = DB::table('salary_details')->orderBy('id','DESC')->pluck('id')->first();
                
                $hourly_rate = HourlyPayGrade::where('hourly_id',$employeeDetails->hourly_pay)->pluck('hourly_rate')->first();

                $employeeHourlySalary = $this->getEmployeeHourlySalary($request->employee, $request->month,$hourly_rate);
                // return $employeeHourlySalary;

                $data = [
                    // 'employee_list'          => $employeeList,
                    'salary_id' => $last_salary_id,
                    'hourly_rate'           => $hourly_rate,
                    'employee_id'           => $request->employee,
                    'month'                 => $request->month,
                    'totalWorkingHour'      => $employeeHourlySalary['totalWorkingHour'],
                    'totalSalary'           => $employeeHourlySalary['totalSalary'],
                    'employee'       => $employeeDetails,

                ];
                // return $data;

                $employee_list = Employee::where('status','1')->get();
                return view('admin.salary_sheet.hourly_create',['employee_list'=>$employee_list,'data'=>$data]);
            }
            // return $data;
            $employee_list = Employee::where('status','1')->get();
            return view('admin.salary_sheet.create',['employee_list'=>$employee_list,'data'=>$data]);
        }else{
            $employee_list = Employee::where('status','1')->get();
            return view('admin.salary_sheet.create',['employee_list'=>$employee_list]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->input();

        $insert = DB::table('salary_details')->insert([
            'employee' =>  $request->employee,
            'month' =>  $request->month,
            'basic_salary' =>  $request->basic_salary,
            'total_allowance' =>  $request->total_allowance,
            'total_deduction' =>  $request->total_deduction,
            'total_late' =>  $request->total_late,
            'total_late_amount' =>  $request->total_late_amount,
            'total_absence' =>  $request->total_absence,
            'total_absence_amount' =>  $request->total_absence_amount,
            'hourly_rate' =>  $request->hourly_rate,
            'total_present' =>  $request->total_present,
            'total_leave' =>  $request->total_leave,
            'total_working_days' =>  $request->total_working_days,
            'tax' =>  $request->tax,
            'gross_salary' =>  $request->gross_salary,
            'taxable_salary' =>  $request->taxable_salary,
            'net_salary' =>  $request->net_salary,
            'working_hour' =>  $request->working_hour,
        ]);
        return redirect('admin/salary_sheet');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $salary_details = DB::table('salary_details')->select(['salary_details.*','employees.*','departments.department_name as department','designations.designation_name as designation'])
       ->leftJoin('employees','employees.emp_id','=','salary_details.employee')
       ->leftJoin('departments','departments.department_id','=','employees.department')
       ->leftJoin('designations','designations.designation_id','=','employees.designation')
       ->where('id',$id)->first();
    //    return $salary_details;
       if($salary_details->monthly_pay != ''){
            return view('admin.salary_sheet.show',['salary_details'=>$salary_details]);
       }else{
            return view('admin.salary_sheet.hourly_show',['salary_details'=>$salary_details]);
       }
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

    public function yb_pay_salary(Request $request){
        $id = $request->id;
        $salary_details = DB::table('salary_details')->where('id',$id)->get();
        
        foreach($salary_details as $row){
            DB::table('payment_history')->insert([
                'employee' => $row->employee,
                'month' => $row->month,
                'amount' => $row->net_salary,
                'salary_id' => $row->id,
                'date' => date('Y-m-d'),
            ]);
            DB::table('salary_details')->where('id',$id)->update([
                'status' => 1
            ]);
        }
        return '1';

    }


    public function yb_payment_history(Request $request)
    {   
        if ($request->ajax()) {
            $data = DB::table('payment_history')->select(['payment_history.*','employees.first_name','employees.last_name'])
            ->leftJoin('employees','employees.emp_id','=','payment_history.employee')
            ->orderBy('payment_history.id','desc')->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('emp_name',function($row){
                return $row->first_name.' '.$row->last_name;
            })
            ->editColumn('month',function($row){
                return date('M Y',strtotime($row->month));
            })
            ->editColumn('date',function($row){
                return date('d M, Y',strtotime($row->date));
            })
            // ->rawColumns(['department_name','status','action'])
            ->make(true);
        }
        return view('admin.salary_sheet.payment-history');
    }

    public function yb_download_payslip($id){
            $salary_details = DB::table('salary_details')->select(['salary_details.*','employees.*','departments.department_name as department','designations.designation_name as designation'])
                ->leftJoin('employees','employees.emp_id','=','salary_details.employee')
                ->leftJoin('departments','departments.department_id','=','employees.department')
                ->leftJoin('designations','designations.designation_id','=','employees.designation')
                ->where('id',$id)->first();
                if($salary_details->monthly_pay != ''){
                    $pdf = PDF::loadView('admin.salary_sheet.monthlyPdf',['salaryDetails'=>$salary_details]);
                    $pdf->setPaper('A4', 'landscape');
                    return $pdf->download("payslip.pdf");
                }else{
                    // return view('admin.salary_sheet.hourlyPdf',['salaryDetails'=>$salary_details]);
                    $pdf = PDF::loadView('admin.salary_sheet.hourlyPdf',['salaryDetails'=>$salary_details]);
                    $pdf->setPaper('A4', 'landscape');
                    return $pdf->download("payslip.pdf");
                }

        
    }

}
