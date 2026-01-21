@extends('admin.layout')
@section('title','Add New Employee')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Employees'=>'admin/employees']])
    @slot('title') Add Employee @endslot
    @slot('add_btn')  @endslot
    @slot('active') Add Employee @endslot
@endcomponent
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <!-- form start -->
        <form class="form-horizontal" id="addEmployee"  method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    @if($department->isEmpty())
                        <div class="alert alert-danger">Department List is Empty</div>
                    @endif
                    @if($workShift->isEmpty())
                        <div class="alert alert-danger">Work Shift List is Empty</div>
                    @endif
                    @if($monthly_pay->isEmpty())
                        <div class="alert alert-danger">Monthly Pay Grade List is Empty</div>
                    @endif
                    @if($hourly_pay->isEmpty())
                        <div class="alert alert-danger">Hourly Pay Garde List is Empty</div>
                    @endif
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Personal Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="f_name" placeholder="Enter First Name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="l_name" placeholder="Enter Last Name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group">
                                        <label>Gender <span class="text-danger">*</span></label>
                                        <select class="form-control" name="gender"  style="width: 100%;">
                                            <option disabled selected value="" >Select The Gender</option>
                                            <option value="m">Male</option>
                                            <option value="f">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Date Of Birth <span class="text-danger">*</span></label>
                                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                        <input type="text" name="dob" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Religion</label>
                                        <input type="text" class="form-control" name="religion" placeholder="Enter User Religion">
                                    </div>
                                </div>
                                
                                <div class="col-md-4 col-12">
                                    <!-- phone mask -->
                                    <div class="form-group">
                                        <label>Phone Number <span class="text-danger">*</span></label>
                                        <div class="input-group" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                            </div>
                                            <input type="text" name="phone" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Marital Status <span class="text-danger">*</span></label>
                                        <select name="marital_status" class="form-control" required>
                                            <option selected disabled value="">Select </option>
                                            <option value="1">Married</option>
                                            <option value="0">Not Married</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="address" class="form-control" placeholder="Address"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Emergency Contact</label>
                                        <textarea name="emergency_contact" class="form-control" placeholder="Emergency Contact"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2">Photo</label>
                                <div class="custom-file col-md-7">
                                    <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                                    <label class="custom-file-label">Choose file</label>
                                </div>
                                <div class="col-md-3 text-right">
                                    <img id="image" src="{{asset('public/employees/default.png')}}" alt="" width="80px" height="80px">
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div>
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Employee Account</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Email address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Confirm Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="con_password" placeholder="Enter Password">
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div>
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Company Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Department Name <span class="text-danger">*</span></label>
                                        <select class="form-control select-department" name="department">
                                            <option disabled selected value="" >Select The Department</option>
                                            @if(!empty($department))
                                                @foreach($department as $types)
                                                    <option value="{{$types->department_id}}">{{$types->department_name}}</option> 
                                                @endforeach
                                            @endif 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Designation <span class="text-danger">*</span></label>
                                        <select class="form-control d-designation" name="designation">
                                            <option disabled selected value="" >First Select Department</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Work Shift <span class="text-danger">*</span></label>
                                        <select class="form-control" name="work_shift">
                                            <option disabled selected value="" >Select The Work Shift Time</option>
                                            @if(!empty($workShift))
                                                @foreach($workShift as $types)
                                                    <option value="{{$types->shift_id}}">{{$types->work_shift}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Monthly Pay Grade <span class="text-danger">*</span></label>
                                        <select class="form-control" name="monthly_pay">
                                            <option disabled selected value="" >Select The Monthly Pay Grade</option>
                                            @if(!empty($monthly_pay))
                                                @foreach($monthly_pay as $types)
                                                    <option value="{{$types->monthly_id}}">{{$types->pay_grade}}</option> 
                                                @endforeach
                                            @endif 
                                        </select>
                                        <small><b>NOTE:</b> Select one from the monthly and hourly pay grade</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Hourly Pay Grade <span class="text-danger">*</span></label>
                                        <select class="form-control" name="hourly_pay">
                                            <option disabled selected value="" >Select The Hourly Pay Grade</option>
                                            @if(!empty($hourly_pay))
                                                @foreach($hourly_pay as $types)
                                                    <option value="{{$types->hourly_id}}">{{$types->hourly_pay_grade}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Date Of Joining <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="join_date">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Date Of Leaving</label>
                                        <input type="date" class="form-control" name="leave_date">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Educational Qualifications</h3>
                        </div>
                        <div class="card-body">
                            <div class="education-container">
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success add-education"><i class="fa fa-plus"></i> Add Educational Qualification</button>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Professional Experience</h3>
                        </div>
                        <div class="card-body">
                            <div class="experience-container">
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-success add-experience"><i class="fa fa-plus"></i> Add Professional Experience</button>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-12 mb-5">
                    <input type="submit" class="btn btn-info" name="submit" value="Submit">
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