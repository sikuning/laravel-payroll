@extends('admin.layout')
@section('title','Generate Salary Sheet')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Salary Details'=>'admin/salary_sheet']])
        @slot('title') Generate Salary Sheet @endslot
        @slot('add_btn')  @endslot
        @slot('active') Create @endslot
    @endcomponent
    <!-- /.content-header -->
    <!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Employee Generate Salary Sheet</h3>
                    </div>
                    <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Employee Name</label>
                                    <select class="form-control employee" name="employee" required>
                                        <option disabled selected value="" >Select The Employee</option>
                                        @if(!empty($employee_list))
                                            @foreach($employee_list as $emp)
                                                <option value="{{$emp->emp_id}}">{{$emp->first_name}} {{$emp->last_name}}</option> 
                                            @endforeach
                                        @endif 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Month:</label>
                                    <input type="month" name="month" value="{{date('Y-m')}}" class="form-control"/>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <input type="submit" class="btn btn-primary my-4" value="Submit">
                            </div>
                        </div>
                    </form>
                    </div> 
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
            @if(isset($data))
            <div class="col-12">
            @if($errors->any())
                {!! implode('', $errors->all('<div>:message</div>')) !!}
            @endif
                <!-- @php echo '<pre>'; @endphp
                @php print_r($data); @endphp -->
                <div class="card card-primary">
                    <div class="card-header">
                    <h3 class="card-title">Employee SALARY SHEET/ FINAL BALANCE</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="row salarySheet_view p-3">
                       
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <td>No. :</td>
                                    <td>{{$data['salary_id']}}</td>
                                </tr>
                                <tr>
                                    <td>Month :</td>
                                    <td>{{date('M Y',strtotime($data['month']))}}</td>
                                </tr>
                                <tr>
                                    <td>Number of Working Days :</td>
                                    <td>{{$data['employeeAllInfo']['totalWorkingDays']}}</td>
                                </tr>
                                <tr>
                                    <td>Number of Days Working in the comapny:</td>
                                    <td>{{$data['employeeAllInfo']['totalPresent']}}</td>
                                </tr>
                                <tr>
                                    <td>Unjustified Absence</td>
                                    <td>{{$data['employeeAllInfo']['totalAbsence']}}</td>
                                </tr>
                                <tr>
                                    <td>Per Day Salary :</td>
                                    <td>{{$data['employeeAllInfo']['oneDaysSalary']}}</td>
                                </tr>
                            </table>
                            
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <td>Name :</td>
                                    <td>{{$data['employee']->first_name}} {{$data['employee']->last_name}}</td>
                                </tr>
                                <tr>
                                    <td>Department :</td>
                                    <td>{{$data['employee']->department}}</td>
                                </tr>
                                <tr>
                                    <td>Designation :</td>
                                    <td>{{$data['employee']->designation}}</td>
                                </tr>
                                <tr>
                                    <td>Date of Joining :</td>
                                    <td>{{date('d M, Y',strtotime($data['employee']->date_of_joining))}}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Allowances</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @php $t_allowance = 0;  @endphp
                                @foreach($data['allowance']['allowanceArray'] as $alw)
                                    <tr>
                                        <td>{{$alw['allowance_name']}}</td>
                                        <td>{{$alw['amount_of_allowance']}}</td>
                                    </tr>
                                    @php $t_allowance += $alw['amount_of_allowance']; @endphp
                                @endforeach
                                    <tr>
                                        <th>Total</th>
                                        <th>{{$t_allowance}}</th>
                                    </tr>
                                </tbody>
                            </table>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Deductions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $t_deduction = 0;  @endphp
                                    @foreach($data['deduction']['deductionArray'] as $ded)
                                        <tr>
                                            <td>{{$ded['deduction_name']}}</td>
                                            <td>{{$ded['amount_of_deduction']}}</td>
                                        </tr>
                                        @php $t_deduction += $ded['amount_of_deduction']; @endphp
                                        <tr>
                                            <td>Tax</td>
                                            <td>{{$data['tax']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Absence Amount</td>
                                            <td>{{$data['employeeAllInfo']['totalAbsenceAmount']}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Late Amount</td>
                                            <td>{{$data['employeeAllInfo']['totalLateAmount']}}</td>
                                        </tr>
                                    @endforeach
                                        @php
                                            $t_deduction += $data['tax'];
                                            $t_deduction += $data['employeeAllInfo']['totalLateAmount'];
                                            $t_deduction += $data['employeeAllInfo']['totalAbsenceAmount'];
                                        @endphp
                                        <tr>
                                            <th>Total</th>
                                            <th>{{$t_deduction}}</th>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                        <table class="table table-bordered">
                                <tr>
                                    <td>Basic Salary</td>
                                    <td>{{$data['employee']->gross_salary}}</td>
                                </tr>
                                <tr>
                                    <td>Allowance</td>
                                    <td>{{$t_allowance}}</td>
                                </tr>
                                <tr>
                                    <th>Net Salary</th>
                                    @php $totalSalary = $data['employee']->gross_salary + $t_allowance; @endphp
                                    <th>{{$totalSalary}}</th>
                                </tr>
                                <tr>
                                    <td>Deduction</td>
                                    <td>{{$t_deduction}}</td>
                                </tr>
                                <tr>
                                    <th>Net Salary to be Paid</th>
                                    <th>{{$totalSalary - $t_deduction}}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-12 table-responsive ">
                        <form action="{{url('admin/salary_sheet')}}" method="POST">
                            @csrf
                            <input hidden type="text" name="employee" value="{{$data['employee_id']}}">
                            <input hidden type="text" name="month" value="{{$data['month']}}">
                            <input hidden type="text" name="basic_salary" value="{{$data['employee']->gross_salary}}">
                            <input hidden type="text" name="total_allowance" value="{{$data['allowance']['totalAllowance']}}">
                            <input hidden type="text" name="total_deduction" value="{{$data['deduction']['totalDeduction']}}">
                            <input hidden type="text" name="total_late" value="{{$data['employeeAllInfo']['totalLate']}}">
                            <input hidden type="text" name="total_late_amount" value="{{$data['employeeAllInfo']['totalLateAmount']}}">
                            <input hidden type="text" name="total_absence" value="{{$data['employeeAllInfo']['totalAbsence']}}">
                            <input hidden type="text" name="total_absence_amount" value="{{$data['employeeAllInfo']['totalAbsenceAmount']}}">
                            <input hidden type="text" name="hourly_rate" value="{{$data['employee']['hourly_rate']}}">
                            <input hidden type="text" name="total_present" value="{{$data['employeeAllInfo']['totalPresent']}}">
                            <input hidden type="text" name="total_leave" value="{{$data['employeeAllInfo']['totalLeave']}}">
                            <input hidden type="text" name="total_working_days" value="{{$data['employeeAllInfo']['totalWorkingDays']}}">
                            <input hidden type="text" name="tax" value="{{$data['tax']}}">
                            <input hidden type="text" name="gross_salary" value="{{$data['employee']->gross_salary}}">
                            <!-- <input type="text" name="payment_method" value=""> -->
                            <input hidden type="text" name="taxable_salary" value="{{$data['taxAbleSalary']}}">
                            <input hidden type="text" name="net_salary" value="{{$totalSalary - $t_deduction}}">
                            <input hidden type="text" name="working_hour" value="">
                            <input type="submit" class="btn btn-primary" name="save" value="Save">
                        </form>
                        <table class="table table-striped">
                            <tbody>
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.card-body -->
            </div>
            @endif
            <!--/.col (left) -->
        </div>
            <!-- /.row -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div>
@stop

