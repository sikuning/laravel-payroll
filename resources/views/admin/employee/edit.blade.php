@extends('admin.layout')
@section('title','Edit Employee')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
@component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard','Employees'=>'admin/employees']])
    @slot('title') Edit Employees @endslot
    @slot('add_btn')  @endslot
    @slot('active') Edit Employees @endslot
@endcomponent
<!-- Main content -->
<section class="content card">
    <div class="container-fluid card-body">
        <form class="form-horizontal" id="updateEmployee"  method="POST" enctype="multipart/form-data">
            @csrf
            {{ method_field('PUT') }}
            @if($employee)
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Employee Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>First Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="f_name" value="{{$employee->first_name}}" placeholder="Enter First Name">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" name="l_name" value="{{$employee->last_name}}" placeholder="Enter Last Name">
                                        <input type="text" class="id" value="{{$employee->emp_id}}" hidden>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group">
                                        <label>Gender <span class="text-danger">*</span></label>
                                        <select class="form-control" name="gender"  style="width: 100%;">
                                            <option disabled selected value="" >Select The Gender</option>
                                            <option value="m"  {{ ($employee->gender == "m" ? "selected":"") }} >Male</option>
                                            <option value="f"  {{ ($employee->gender == "f" ? "selected":"") }} >Female</option>
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
                                        <input type="text" name="dob" value="{{$employee->dob}}" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Religion</label>
                                        <input type="text" class="form-control" name="religion" value="{{$employee->religion}}" placeholder="Enter User Religion">
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
                                            <input type="text" name="phone" class="form-control" value="{{$employee->phone}}" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group">
                                        <label>Marital Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="marital_status"  style="width: 100%;">
                                            <option disabled selected value="">Select The Marital Status</option>
                                            <option value="1" {{($employee->marital_status == "1" ? "selected":"") }}>Married</option>
                                            <option value="0" {{($employee->marital_status == "0" ? "selected":"") }}>Unmarried</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea name="address" class="form-control">{{$employee->address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group mb-4">
                                        <label>Emergenecy Contact</label>
                                        <textarea name="emergency_contact" class="form-control">{{$employee->emergenecy_contact}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group">
                                        <label>Status <span class="text-danger">*</span></label>
                                        <select class="form-control" name="status"  style="width: 100%;">
                                            <option disabled selected value="" >Select The Status</option>
                                            <option value="1" {{ ($employee->status == "1" ? "selected":"") }} >Active</option>
                                            <option value="0" {{ ($employee->status == "0" ? "selected":"") }} >Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label>Photo</label>
                                    <div class="custom-file">
                                        <input type="hidden" class="custom-file-input" name="old_img" value="{{$employee->emp_img}}" />
                                        <input type="file" class="custom-file-input" name="img" onChange="readURL(this);">
                                        <label class="custom-file-label">Choose file</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    @if($employee->emp_img != '')
                                    <img id="image" src="{{asset('public/employees/'.$employee->emp_img)}}" alt="" width="80px" height="80px">
                                    @else
                                    <img id="image" src="{{asset('public/employees/default.png')}}" alt="" width="80px" height="80px">
                                    @endif
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div> <!-- /.card -->
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
                                        <input type="email" class="form-control" name="email" value="{{$employee->email}}" placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control" name="password"  placeholder="Enter Password">
                                        <small>Leave password empty if not change in password</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                                    @if($employee->department == $types->department_id)
                                                        <option value="{{$types->department_id}}" selected>{{$types->department_name}}</option>
                                                        @else
                                                        <option value="{{$types->department_id}}">{{$types->department_name}}</option>
                                                    @endif
                                                @endforeach
                                            @endif 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Designation <span class="text-danger">*</span></label>
                                        <select class="form-control d-designation" name="designation"  style="width: 100%;">
                                            <option disabled selected value="" >Select The Designation</option>
                                            @if(!empty($designation))
                                                @foreach($designation as $types)
                                                    @if($employee->designation == $types->designation_id)
                                                        <option value="{{$types->designation_id}}" selected>{{$types->designation_name}}</option>
                                                        @else
                                                        <option value="{{$types->designation_id}}">{{$types->designation_name}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12"> 
                                    <div class="form-group">
                                        <label>Work Shift Time <span class="text-danger">*</span></label>
                                        <select class="form-control" name="work_shift"  style="width: 100%;">
                                            <option disabled selected value="" >Select The Work Shift Time Of Employee</option>
                                            @if(!empty($workShift))
                                                @foreach($workShift as $types)
                                                    @if($employee->work_shift == $types->shift_id)
                                                        <option value="{{$types->shift_id}}" selected>{{$types->work_shift}}</option>
                                                        @else
                                                        <option value="{{$types->shift_id}}">{{$types->work_shift}}</option>
                                                    @endif
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
                                                    @if($employee->monthly_pay == $types->monthly_id)
                                                        <option value="{{$types->monthly_id}}" selected>{{$types->pay_grade}}</option>
                                                        @else
                                                        <option value="{{$types->monthly_id}}">{{$types->pay_grade}}</option>
                                                    @endif
                                                @endforeach
                                            @endif 
                                        </select>
                                        <small><b>NOTE:</b> Select one from the monthly and hourly pay grade</small>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Hourly Pay Grade <span class="text-danger">*</span></label>
                                        <select class="form-control" name="hourly_pay" >
                                            <option disabled selected value="" >Select The Hourly Pay Grade</option>
                                            @if(!empty($hourly_pay))
                                                @foreach($hourly_pay as $types)
                                                    @if($employee->hourly_pay == $types->hourly_id)
                                                        <option value="{{$types->hourly_id}}" selected>{{$types->hourly_pay_grade}}</option>
                                                        @else
                                                        <option value="{{$types->hourly_id}}">{{$types->hourly_pay_grade}}</option>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Date Of Joining <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" name="join_date" value="{{$employee->date_of_joining}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label>Date Of Leaving	</label>
                                        <input type="date" class="form-control" name="leave_date" value="{{$employee->date_of_leaving}}">
                                    </div> 
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Educational Qualifications</h3>
                        </div>
                        <div class="card-body">
                            <div class="education-container">
                                @if($education->isNotEmpty())
                                    @foreach($education as $edu)
                                    <div class="row">
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Board / University <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="university[]" value="{{$edu->university}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Degree <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="degree[]" value="{{$edu->degree}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>Passing Year <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" name="pass_year[]" value="{{$edu->pass_year}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-12">
                                            <div class="form-group">
                                                <label>GPA / CGPA <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="cgpa[]" value="{{$edu->cgpa}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-12 mb-3 text-right">
                                            <button type="button" class="btn btn-danger delete-education"><i class="fa fa-times"></i> Delete</button>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
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
                            @if($experience->isNotEmpty())
                                @foreach($experience as $exp)
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Organisation <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="organisation[]" value="{{$exp->organisation}}">
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Designation <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="exp_designation[]" value="{{$exp->designation}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>From Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="exp_from[]" value="{{$exp->from_date}}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>To Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="exp_to[]" value="{{$exp->to_date}}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Responsibility <span class="text-danger">*</span></label>
                                            <textarea name="responsibility[]" class="form-control" required>{{$exp->responsibility}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="form-group">
                                            <label>Skill <span class="text-danger">*</span></label>
                                            <textarea name="skill[]" class="form-control" required>{{$exp->skills}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <button class="btn btn-danger mt-5 delete-experience"><i class="fa fa-times"></i> Delete</button>
                                    </div>
                                </div>
                                @endforeach
                            @endif
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
                <div class="col-12">
                    <button type="submit" class="btn btn-info">Update</button>
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