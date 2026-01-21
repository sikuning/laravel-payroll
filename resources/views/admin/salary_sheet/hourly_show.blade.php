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
        <div class="row">
            <div class="col-12">
                
                <div class="card card-primary">
                    <div class="card-header">
                    <h3 class="card-title">Employee SALARY SHEET/ FINAL BALANCE</h3>
                </div>
                <div class="card-body p-0 pt-2 pl-2">
                <a href="{{url('admin/downloadPaySlip/'.$salary_details->id)}}" class="btn btn-success" id="down-pdf">Download PDF</a>
                    <div class="row salarySheet_view p-3">
                       
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <td>No. :</td>
                                    <td>{{$salary_details->id}}1</td>
                                </tr>
                                <tr>
                                    <td>Month :</td>
                                    <td>{{date('M Y',strtotime($salary_details->month))}}</td>
                                </tr>
                                <tr>
                                    <td>Hourly Rate :</td>
                                    <td>{{$salary_details->hourly_rate}}</td>
                                </tr>
                                <tr>
                                    <td>Working Hours:</td>
                                    <td>{{$salary_details->working_hour}}</td>
                                </tr>
                                <tr>
                                    <td>Total Salary</td>
                                    <td>{{$salary_details->net_salary}}</td>
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
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.card-body -->
            </div>
            <!--/.col (left) -->
        </div>
            <!-- /.row -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div>
@stop

