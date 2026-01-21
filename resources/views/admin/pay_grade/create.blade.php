@extends('admin.layout')
@section('title','Add New Monthly Pay Grade')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Pay Grade'=>'admin/pay_grade']])
    @slot('title') Add Pay Grade @endslot
    @slot('add_btn')  @endslot
    @slot('active') Add Pay Grade @endslot
@endcomponent
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- form start -->
        <form class="form-horizontal" id="addPay"  method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Monthly Pay Grade Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Pay Grade Name</label>
                                        <input type="text" name="pay_grade" class="form-control" placeholder="Enter Pay Grade Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Overtime Rate (Per Hour)</label>
                                        <input type="number" name="overtime_rate" class="form-control" placeholder="Enter Pay Grade Overtime Rate (Per Hour) Name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Gross Salary</label>
                                        <input type="number" name="gross_salary" class="form-control gross_salary" placeholder="Enter Pay Grade Gross Salary">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Percentage of Basic</label>
                                        <select class="form-control percentage_of_basic" name="percentage"  style="width: 100%;">
                                            <option disabled selected value="">Select The Percentage of Basic</option>
                                            <option value="5%">5%</option>
                                            <option value="10%">10%</option>
                                            <option value="10%">10%</option>
                                            <option value="15%">15%</option>
                                            <option value="20%">20%</option>
                                            <option value="25%">25%</option>
                                            <option value="30%">30%</option>
                                            <option value="35%">35%</option>
                                            <option value="40%">40%</option>
                                            <option value="45%">45%</option>
                                            <option value="50%">50%</option>
                                            <option value="55%">55%</option>
                                            <option value="60%">60%</option>
                                            <option value="65%">65%</option>
                                            <option value="70%">70%</option>
                                            <option value="75%">75%</option>
                                            <option value="80%">80%</option>
                                            <option value="85%">85%</option>
                                            <option value="90%">90%</option>
                                            <option value="100%">100%</option>
                                        </select>
                                        <!-- <input type="number" name="percentage" class="form-control percentage_of_basic" placeholder="Enter Pay Grade Percentage of Basic"> -->
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Basic Salary</label>
                                        <input type="number" name="basic_salary" class="form-control basic_salary" placeholder="Enter Pay Grade Basic Salary">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Allowance Name</label>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary">
                                                <input type="checkbox" id='all_id' class="all_allowance" name="all_allowance" value="all">
                                                <label for="all_id">All Allowance</label>
                                            </div>
                                            @foreach($allowance as $types)
                                            <div class="icheck-primary">
                                                <input type="checkbox" id='{{$types->allowance_id}}"' class="singleAllowance" name="allowance[]" value="{{$types->allowance_id}}">
                                                <label for="{{$types->allowance_id}}">{{$types->allowance_name}}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Deduction Name</label>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary">
                                                <input type="checkbox" id='all_id' class="all_deduction" name="all_deduction" value="all">
                                                <label for="all_id">All Deduction</label>
                                            </div>
                                            @foreach($deduction as $types)
                                            <div class="icheck-primary">
                                                <input type="checkbox" id='{{$types->deduction_id}}"' class="singleDeduction" name="deduction[]" value="{{$types->deduction_id}}">
                                                <label for="{{$types->deduction_id}}">{{$types->deduction_name}}</label>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form> <!-- /.form start -->
    </div><!-- /.container-fluid -->
</section><!-- /.content -->
</div>
<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>
@stop