<?php
use App\Http\Controllers\Yb_EmployeeController;
use App\Http\Controllers\Yb_DepartmentController;
use App\Http\Controllers\Yb_DesignationController;
use App\Http\Controllers\Yb_WorkShiftController;
//use App\Http\Controllers\Yb_EmpAttendanceController;
use App\Http\Controllers\Yb_AttendanceController;
use App\Http\Controllers\Yb_AdminController;
use App\Http\Controllers\Yb_SettingController;
use App\Http\Controllers\Yb_LeaveTypeController;
use App\Http\Controllers\Yb_LeaveApplicationController;
use App\Http\Controllers\Yb_AllowanceController;
use App\Http\Controllers\Yb_DeductionController;
use App\Http\Controllers\Yb_MonthlyPayGradeController;
use App\Http\Controllers\Yb_HourlyPayGradeController;
use App\Http\Controllers\Yb_GenerateSalarySheetController;
use App\Http\Controllers\Yb_TaxRuleController;
use App\Http\Controllers\Yb_BonusController;
use App\Http\Controllers\PublicHolidaysController;
use App\Http\Controllers\WeeklyHolidaysController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['middleware'=>'installed'], function(){
    Route::get('/',[Yb_AdminController::class,'yb_index']); 
    Route::post('/',[Yb_AdminController::class,'yb_index']); 
    Route::group(['middleware'=>'protectedPage'],function(){
        // Route::post('/',[Yb_AdminController::class,'yb_index']);
        Route::get('admin/dashboard',[Yb_AdminController::class,'yb_dashboard']); 
        Route::get('admin/attendance/attendance-ajax',[Yb_AttendanceController::class,'yb_ajax_attendance']);
        Route::post('admin/attendance-filter',[Yb_AttendanceController::class,'yb_filter_attendance']);
        Route::any('admin/late_configration',[Yb_AttendanceController::class,'yb_late_configration']); 
        Route::resource('admin/attendance',Yb_AttendanceController::class); 
        Route::resource('admin/employees',Yb_EmployeeController::class);
        Route::resource('admin/departments',Yb_DepartmentController::class);
        Route::resource('admin/designations',Yb_DesignationController::class);   
        Route::resource('admin/work_shift',Yb_WorkShiftController::class);  
        Route::resource('admin/leave_type',Yb_LeaveTypeController::class);
        Route::resource('admin/leave_application',Yb_LeaveApplicationController::class);
        Route::resource('admin/allowance',Yb_AllowanceController::class);
        Route::resource('admin/deduction',Yb_DeductionController::class);
        Route::resource('admin/deduction',Yb_DeductionController::class);
        Route::resource('admin/pay_grade',Yb_MonthlyPayGradeController::class); 
        Route::resource('admin/hourly_pay_grade',Yb_HourlyPayGradeController::class); 
        Route::post('admin/pay-employee-salary',[Yb_GenerateSalarySheetController::class,'yb_pay_salary']);
        Route::any('admin/payment_history',[Yb_GenerateSalarySheetController::class,'yb_payment_history']);
        Route::get('admin/downloadPaySlip/{id}',[Yb_GenerateSalarySheetController::class,'yb_download_payslip']);
        Route::resource('admin/salary_sheet',Yb_GenerateSalarySheetController::class);
        Route::resource('admin/tax_rule',Yb_TaxRuleController::class);
        Route::resource('admin/bonus',Yb_BonusController::class);
        Route::resource('admin/public_holidays',PublicHolidaysController::class);
        Route::resource('admin/weekly_holidays',WeeklyHolidaysController::class);


        Route::post('admin/change-leave-status',[Yb_LeaveApplicationController::class,'yb_changeLeave_status']);
        Route::get('admin/logout',[Yb_AdminController::class,'yb_logout']); 
        Route::post('get_designations',[Yb_DesignationController::class,'yb_get_department_designations']); 


        Route::any('admin/general-settings',[Yb_SettingController::class,'yb_general_settings']);
        Route::any('admin/profile-settings',[Yb_SettingController::class,'yb_profile_settings']);
        Route::post('admin/change-password',[Yb_SettingController::class,'yb_change_password']);
    });

    Route::group(['middleware'=>'empprotectedPage'],function(){
        Route::any('employee-login',[Yb_EmployeeController::class,'yb_login']);
        Route::get('employee/leave/{id}',[Yb_LeaveApplicationController::class,'yb_getSingle_leave']);

        Route::get('employee/home',[Yb_EmployeeController::class,'yb_profile']);
        Route::get('employee/leaves',[Yb_EmployeeController::class,'yb_my_leaves']); 
        Route::post('employee/employee-leave',[Yb_EmployeeController::class,'yb_add_leave']); 
        Route::get('employee/my-leaves',[Yb_LeaveApplicationController::class,'yb_view']);
        //Route::any('employee/employee_login',[Yb_EmployeeController::class,'yb_login']);
        Route::get('employee/logout',[Yb_EmployeeController::class,'yb_logout']);
    });
});
