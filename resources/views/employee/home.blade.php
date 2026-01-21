@extends('employee/layout') 
@section('title','Employee Dashboard')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper pt-5">
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
      @include('employee.components.sidebar')
        @foreach($data as $item)
        <div class="col-md-8">
          <div class="row">
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-user mr-1"></i>Personal Details</h3>
                </div>
                <!-- /.card-header -->
                <table class="card-body table">
                  <tr>
                    <td><strong>Name :</strong></td>
                    <td>{{$item->first_name}} {{$item->last_name}}</td>
                  </tr>
                  <tr>
                    <td><strong>Date of Birth :</strong></td>
                    <td>{{date('d M, Y',strtotime($item->dob))}}</td>
                  </tr>
                  <tr>
                    <td><strong>Gender :</strong></td>
                    <td>
                      @if($item->gender == 'm')
                        Male
                      @else
                        Female
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td><strong>Email address :</strong></td>
                    <td>{{$item->email}}</td>
                  </tr>
                  <tr>
                    <td><strong>Phone Number :</strong></td>
                    <td>{{$item->phone}}</td>
                  </tr>
                  <tr>
                    <td><strong>Address :</strong></td>
                    <td>{{$item->address}}</td>
                  </tr>
                  <tr>
                    <td><strong>Emergency Contact :</strong></td>
                    <td>{{$item->emergenecy_contact}}</td>
                  </tr>
                </table>
                <!-- /.card-body -->
              </div>
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title"><i class="fas fa-briefcase mr-1"></i>Company Details</h3>
                </div>
                <table class="card-body table">
                  <tr>
                    <td><strong>Employee ID :</strong></td>
                    <td>EMP000{{$item->emp_id}}</td>
                  </tr>
                  <tr>
                    <td><strong>Department Name :</strong></td>
                    <td>{{$item->department}}</td>
                  </tr>
                  <tr>
                    <td><strong>Designation :</strong></td>
                    <td>{{$item->designation}}</td>
                  </tr>
                  <tr>
                    <td><strong>Date Of Joining :</strong></td>
                    <td>{{date('d M, Y',strtotime($item->date_of_joining))}}</td>
                  </tr>
                  
                </table>
                <!-- /.card-body -->
              </div>
            </div>
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-book mr-1"></i>Education Qualifications</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Board / University</th>
                          <th>Degree</th>
                          <th>Passing Year</th>
                          <th>GPA / CGPA</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($education->isNotEmpty())
                        @foreach($education as $row)
                          <tr>
                            <td>{{$row->university}}</td>
                            <td>{{$row->degree}}</td>
                            <td>{{$row->pass_year}}</td>
                            <td>{{$row->cgpa}}</td>
                          </tr>
                        @endforeach
                        @else
                          <tr>
                            <td colspan="4" align="center"> No Record Found</td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-book mr-1"></i>Experience</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Organisation</th>
                          <th>Designation</th>
                          <th>From Date</th>
                          <th>To Date</th>
                          <th>Skills</th>
                        </tr>
                      </thead>
                      <tbody>
                        @if($experience->isNotEmpty())
                        @foreach($experience as $exp)
                          <tr>
                            <td>{{$exp->organisation}}</td>
                            <td>{{$exp->designation}}</td>
                            <td>{{date('d M, Y',strtotime($exp->from_date))}}</td>
                            <td>{{date('d M, Y',strtotime($exp->to_date))}}</td>
                            <td>{{$exp->skills}}</td>
                          </tr>
                        @endforeach
                        @else
                          <tr>
                            <td colspan="5" align="center">No Record Found</td>
                          </tr>
                        @endif
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@stop