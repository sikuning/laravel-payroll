@extends('admin.layout')
@section('title','Work Shift')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Work Shift @endslot
        @slot('add_btn') <button type="button" data-toggle="modal" data-target="#modal-default" class="align-top btn btn-sm btn-primary d-inline-block">Add New</button> @endslot
        @slot('active') Work Shift  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Work Shift Name','Start Time','End Time','Late Time Count','Action']
    ])
        @slot('table_id') shift-list @endslot
    @endcomponent

    <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Work Shift Add</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form  id="add_shift" method="POST" >
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Work Shift Name</label>
                                <input type="text" name="shift" class="form-control" placeholder="Enter Work Shift Name">
                            </div>
                            <div class="form-group">
                                <label>Start Time</label>
                                <input type="time" name="start_time" class="form-control" placeholder="Enter Start Time Shift Name">
                            </div>
                            <div class="form-group">
                                <label>End Time</label>
                                <input type="time" name="end_time" class="form-control" placeholder="Enter End Time Shift Name">
                            </div>
                            <div class="form-group">
                                <label>Late Count Time</label>
                                <input type="time" name="late_count_time" class="form-control" placeholder="Enter Late Count Time Shift Name">
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
        <!-- /.modal --> 
        <div class="modal fade" id="modal-info">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Work Shift Edit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form  id="edit_shift" method="POST" >
                        <div class="modal-body">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-group">
                                <label>Work Shift Name</label>
                                <input type="text" name="shift" class="form-control"  placeholder="Enter Work Shift Name">
                                <input type="hidden" name="id" >
                            </div>
                            <div class="form-group">
                                <label>Start Time</label>
                                <input type="time" name="start_time" class="form-control" placeholder="Enter Start Time Shift Name">
                            </div>
                            <div class="form-group">
                                <label>End Time</label>
                                <input type="time" name="end_time" class="form-control" placeholder="Enter End Time Shift Name">
                            </div>
                            <div class="form-group">
                                <label>Late Count Time</label>
                                <input type="time" name="late_count_time" class="form-control" placeholder="Enter Late Count Time Shift Name">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="submit" class="btn btn-primary ">Update</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
</div>
@stop

@section('pageJsScripts')
<!-- DataTables -->
<script src="{{asset('public/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#shift-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "work_shift",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'work_shift', name: 'work_shift'},
            {data: 'start_time', name: 'start_time'},
            {data: 'end_time', name: 'end_time'},
            {data: 'late_count_time', name: 'late_count_time'},
            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true,
                sWidth: '100px'
            }
        ]
    });
</script>
@stop