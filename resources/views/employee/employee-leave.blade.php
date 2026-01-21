@extends('employee/layout') 
@section('title','My Leaves')
@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper pt-5">
   <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
            @include('employee.components.sidebar')
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-server mr-1"></i>My Leave Applications</h3>
                            <button type="button" data-toggle="modal" data-target="#modal-default" class="float-right btn btn-sm btn-default">Add New</button> 
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="leave-list" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>S NO.</th>
                                        <th>Date</th>
                                        <th>Leave Type</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>S NO.</th>
                                        <th>Date</th>
                                        <th>Leave Type</th>
                                        <th>Reason</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="modal fade" id="modal-default">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Apply Leave</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <!-- form start -->
                                    <form  id="add_EmpLeave">
                                        <div class="modal-body">
                                            @csrf
                                            <div class="form-group">
                                                <label>From Date:</label>
                                                <input type="date" name="from_date" class="form-control" value="{{date('Y-m-d')}}" />
                                            </div> 
                                            <div class="form-group">
                                                <label>To Date:</label>
                                                <input type="date" name="to_date" class="form-control" value="{{date('Y-m-d')}}" />
                                            </div> 
                                            <div class="form-group">
                                                <label> Leave Type </label>
                                                <select name="leave" class="form-control">
                                                <option value="0" selected disabled>Select Leave Type</option>
                                                    @if(!empty($LeaveType))
                                                    @foreach($LeaveType as $types)
                                                        <option value="{{$types->id}}">{{$types->leave_type}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Reason</label>
                                                <input type="text" class="form-control" name="reason" placeholder="Enter Reason">
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="submit" class="btn btn-primary ">Submit</button>
                                        </div>
                                    </form>   
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </div>
</div>
<!-- /.row -->
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
<!-- DataTables -->
<script src="{{asset('public/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/assets/js/responsive.bootstrap4.min.js')}}"></script>

<script type="text/javascript">
     var table = $("#leave-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "my-leaves",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'date', name: 'date'},
            {data: 'leave_type', name: 'leave_type'},
            {data: 'reason', name: 'reason'},
            {data: 'status', name: 'status'},
        ]
    });
</script>

@stop