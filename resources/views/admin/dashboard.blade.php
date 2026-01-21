@extends('admin.layout')
@section('title','Dashboard')
@section('content')
<!-- Main content -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Employees</span>
                            <span class="info-box-number">{{$employees}}</span>    
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cubes"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Total Departments</span>
                            <span class="info-box-number">{{$departments}}</span>
                        </div><!-- /.info-box-content -->
                    </div><!-- /.info-box -->
                </div><!-- /.col -->
                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                    <span class="info-box-icon bg-success elevation-1"><i class="fas fa-list"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Total Designations</span>
                        <span class="info-box-number">{{$designations}}</span>
                    </div><!-- /.info-box-content -->
                    </div> <!-- /.info-box -->
                </div><!-- /.col -->
            </div><!-- /.col -->
            <div class="row">
                <div class="col-12 px-3">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Latest Leave Applications</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Department</th>
                                        <th>Leave Type</th>
                                        <th>Leave Date</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($leave_applications->isNotEmpty())
                                        @foreach($leave_applications as $row)
                                            <tr>
                                                <td>{{$row->first_name}} {{$row->last_name}}</td>
                                                <td>{{$row->department_name}}</td>
                                                <td>{{$row->leave_name}}</td>
                                                <td>{{date('d M, Y',strtotime($row->from_date))}} - {{date('d M, Y',strtotime($row->to_date))}}</td>
                                                <td><button data-url="{{url('employee/leave/')}}" data-id="{{$row->leave_id}}" class="view_leave btn btn-primary btn-sm"><i class="fa fa-eye"></i></button>
                                                <button data-url="{{url('admin')}}" data-value="1" data-id="{{$row->leave_id}}" class="change_status btn btn-success btn-sm">Approve</button>
                                                <button data-url="{{url('admin')}}" data-value="-1" data-id="{{$row->leave_id}}" class="change_status btn btn-danger btn-sm">Reject</button></td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5" align="center">No Applications Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
</div>
@stop