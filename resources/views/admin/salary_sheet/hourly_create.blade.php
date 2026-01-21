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
                                    @php
                                    $empl = ''; 
                                    $dt = date('Y-m');
                                    if(isset($_GET['employee'])){
                                        $empl = $_GET['employee'];
                                    }
                                    if(isset($_GET['month'])){
                                        $dt = $_GET['month'];
                                    }
                                    @endphp

                                    <select class="form-control employee" name="employee" required>
                                        <option disabled selected value="" >Select The Employee</option>
                                        @if(!empty($employee_list))
                                            @foreach($employee_list as $emp)
                                                @php $selected = ($empl == $emp->emp_id) ? 'selected' : '';  @endphp
                                                <option value="{{$emp->emp_id}}" {{$selected}}>{{$emp->first_name}} {{$emp->last_name}}</option> 
                                            @endforeach
                                        @endif 
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label>Month:</label>
                                    <input type="month" name="month" value="{{$dt}}" class="form-control"/>
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
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <td>Month :</td>
                                    <td>{{date('M Y',strtotime($data['month']))}}</td>
                                </tr>
                                <tr>
                                    <td>Hourly Rate :</td>
                                    <td>{{$data['hourly_rate']}}</td>
                                </tr>
                                <tr>
                                    <td>Working Hours:</td>
                                    <td>{{$data['totalWorkingHour']}}</td>
                                </tr>
                                <tr>
                                    <td>Total Salary</td>
                                    <td>{{$data['totalSalary']}}</td>
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
                    </div>
                    <div class="col-12 table-responsive ">
                        <form action="{{url('admin/salary_sheet')}}" method="POST">
                            @csrf
                            <input hidden type="text" name="employee" value="{{$data['employee_id']}}">
                            <input hidden type="text" name="month" value="{{$data['month']}}">
                            <input hidden type="text" name="hourly_rate" value="{{$data['hourly_rate']}}">
                            <input hidden type="text" name="working_hour" value="{{$data['totalWorkingHour']}}">
                            <input hidden type="text" name="net_salary" value="{{$data['totalSalary']}}">
                            <input type="submit" class="btn btn-primary" name="save" value="Save">
                        </form>
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

