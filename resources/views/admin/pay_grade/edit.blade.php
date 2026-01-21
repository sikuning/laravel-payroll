@extends('admin.layout')
@section('title','Edit Pay Grade')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Pay Grade'=>'admin/pay_grade']])
    @slot('title') Edit Pay Grade @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit Pay Grade @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <!-- form start -->
        <form class="form-horizontal" id="updatePay"  method="POST" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            @if($payGrade)
            <div class="row">
                <!-- column -->
                <div class="col-md-12">
                    <input type="hidden" class="url" value="{{url('admin/pay_grade/'.$payGrade->monthly_id)}}" >
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
                                        <input type="text" name="pay_grade" class="form-control" value="{{$payGrade->pay_grade}}"  placeholder="Enter Pay Grade Name">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Overtime Rate (Per Hour)</label>
                                        <input type="number" name="overtime_rate" class="form-control" value="{{$payGrade->overtime_rate}}" placeholder="Enter Pay Grade Overtime Rate (Per Hour) Name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Gross Salary</label>
                                        <input type="number" name="gross_salary" class="form-control gross_salary" value="{{$payGrade->gross_salary}}" placeholder="Enter Pay Grade Gross Salary">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Percentage of Basic</label>
                                        <select class="form-control percentage_of_basic" name="percentage"  style="width: 100%;">
                                            <option disabled selected value="">Select The Percentage of Basic</option>
                                            <option value="5%"  {{($payGrade->percentage_of_basic == "5%" ? "selected":"")}}>5%</option>
                                            <option value="10%" {{($payGrade->percentage_of_basic == "10%" ? "selected":"") }}>10%</option>
                                            <option value="15%" {{($payGrade->percentage_of_basic == "15%" ? "selected":"") }}>15%</option>
                                            <option value="20%" {{($payGrade->percentage_of_basic == "20%" ? "selected":"") }}>20%</option>
                                            <option value="25%" {{($payGrade->percentage_of_basic == "25%" ? "selected":"") }}>25%</option>
                                            <option value="30%" {{($payGrade->percentage_of_basic == "30%" ? "selected":"") }}>30%</option>
                                            <option value="35%" {{($payGrade->percentage_of_basic == "35%" ? "selected":"") }}>35%</option>
                                            <option value="40%" {{($payGrade->percentage_of_basic == "40%" ? "selected":"") }}>40%</option>
                                            <option value="45%" {{($payGrade->percentage_of_basic == "45%" ? "selected":"") }}>45%</option>
                                            <option value="50%" {{($payGrade->percentage_of_basic == "50%" ? "selected":"") }}>50%</option>
                                            <option value="55%" {{($payGrade->percentage_of_basic == "55%" ? "selected":"") }}>55%</option>
                                            <option value="60%" {{($payGrade->percentage_of_basic == "60%" ? "selected":"") }}>60%</option>
                                            <option value="65%" {{($payGrade->percentage_of_basic == "65%" ? "selected":"") }}>65%</option>
                                            <option value="70%" {{($payGrade->percentage_of_basic == "70%" ? "selected":"") }}>70%</option>
                                            <option value="75%" {{($payGrade->percentage_of_basic == "75%" ? "selected":"") }}>75%</option>
                                            <option value="80%" {{($payGrade->percentage_of_basic == "80%" ? "selected":"") }}>80%</option>
                                            <option value="85%" {{($payGrade->percentage_of_basic == "85%" ? "selected":"") }}>85%</option>
                                            <option value="90%" {{($payGrade->percentage_of_basic == "90%" ? "selected":"") }}>90%</option>
                                            <option value="100%" {{($payGrade->percentage_of_basic == "100%" ? "selected":"") }}>100%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Basic Salary</label>
                                        <input type="number" name="basic_salary" class="form-control basic_salary" value="{{$payGrade->basic_salary}}" placeholder="Enter Pay Grade Basic Salary">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label>Allowance Name</label>
                                        <div class="form-group clearfix">
                                            <div class="icheck-primary">
                                                <input type="checkbox" id='all_id' class="all_allowance" name="all_allowance" value="{{$payGrade->allowance}}">
                                                <label for="all_id">All Allowance</label>
                                            </div>
                                            @php $grade_allow = array_filter(explode(',',$payGrade->allowance));  @endphp
                                            @foreach($allowance as $types)
                                            @php $checked = (in_array($types->allowance_id,$grade_allow)) ? 'checked' : '';  @endphp
                                            <div class="icheck-primary">
                                                <input type="checkbox" id='{{$types->allowance_id}}"' {{$checked}}  class="singleAllowance" name="allowance[]" value="{{$types->allowance_id}}">
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
                                                <input type="checkbox" id='all_id' class="all_deduction" name="all_deduction" value="{{$payGrade->deduction}}">
                                                <label for="all_id">All Deduction</label>
                                            </div>
                                            @php $grade_deduction = array_filter(explode(',',$payGrade->deduction));  @endphp
                                            @foreach($deduction as $types)
                                            @php $checked = (in_array($types->deduction_id,$grade_deduction)) ? 'checked' : '';  @endphp
                                            <div class="icheck-primary">
                                                <input type="checkbox" id='{{$types->deduction_id}}"' {{$checked}} class="singleDeduction" name="deduction[]" value="{{$types->deduction_id}}">
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
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
            @endif
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