@extends('admin.layout')
@section('title','Salary Sheet')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Salary Details'=>'admin/salary_sheet']])
        @slot('title') Salary Sheet @endslot
        @slot('add_btn')  @endslot
        @slot('active') Show @endslot
    @endcomponent
    <!-- /.content-header -->
    <!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row" >
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                    <h3 class="card-title">Employee SALARY SHEET</h3>
                    </div>
                    <div class="card-body p-0 pt-2 pl-2">
                        <a href="{{url('admin/downloadPaySlip/'.$salary_details->id)}}" class="btn btn-success" id="down-pdf">Download PDF</a>
                        <div class="row salarySheet_view p-3" id="content">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>No. :</td>
                                        <td>{{$salary_details->id}}</td>
                                    </tr>
                                    <tr>
                                        <td>Month :</td>
                                        <td>{{date('M Y',strtotime($salary_details->month))}}</td>
                                    </tr>
                                    <tr>
                                        <td>Number of Working Days :</td>
                                        <td>{{$salary_details->total_working_days}}</td>
                                    </tr>
                                    <tr>
                                        <td>Number of Days Working in the comapny:</td>
                                        <td>{{$salary_details->total_present}}</td>
                                    </tr>
                                    <tr>
                                        <td>Unjustified Absence</td>
                                        <td>{{$salary_details->total_absence}}</td>
                                    </tr>
                                </table>
                                
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <tr>
                                        <td>Name :</td>
                                        <td>{{$salary_details->first_name}} {{$salary_details->last_name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Department :</td>
                                        <td>{{$salary_details->department}}</td>
                                    </tr>
                                    <tr>
                                        <td>Designation :</td>
                                        <td>{{$salary_details->designation}}</td>
                                    </tr>
                                    <tr>
                                        <td>Date of Joining :</td>
                                        <td>{{date('d M, Y',strtotime($salary_details->date_of_joining))}}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                            <table class="table table-bordered">
                                    <tr>
                                        <td>Basic Salary</td>
                                        <td>{{$salary_details->basic_salary}}</td>
                                    </tr>
                                    <tr>
                                        <td>Allowance</td>
                                        <td>{{$salary_details->total_allowance}}</td>
                                    </tr>
                                    <tr>
                                        <th>Net Salary</th>
                                        <th>{{$salary_details->net_salary}}</th>
                                    </tr>
                                    <tr>
                                        <td>Deduction</td>
                                        <td>{{$salary_details->total_deduction}}</td>
                                    </tr>
                                    <tr>
                                        <th>Net Salary to be Paid</th>
                                        <th>{{$salary_details->net_salary - $salary_details->total_deduction}}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                <!-- /.card-body -->
            </div>
            <!--/.col (left) -->
        </div>
            <!-- /.row -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
<div id="editor"></div>
</div>
@stop

@section('pageJsScripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js"></script>
@stop

