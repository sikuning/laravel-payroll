@extends('admin.layout')
@section('title','Deduction')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Deduction @endslot
        @slot('add_btn') <button type="button" data-toggle="modal" data-target="#modal-default" class="align-top btn btn-sm btn-primary d-inline-block">Add New</button> @endslot
        @slot('active') Deduction  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Deduction Name','Deduction Type','Percentage of Basic','Limit Per Month','Action']
    ])
        @slot('table_id')deduction-list @endslot
    @endcomponent

    <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Deduction Add</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form  id="add_deduction" method="POST" >
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Deduction Name</label>
                                <input type="text" name="deduction" class="form-control" placeholder="Enter Deduction Name">
                            </div>
                            <div class="form-group">
                                <label>Deduction Type</label>
                                <select class="form-control deduction_type" name="deduction_type"  style="width: 100%;">
                                    <option disabled selected value="">Select The Deduction Type</option>
                                    <option value="0">Fixed</option>
                                    <option value="1">Percentage</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Percentage of Basic</label>
                                <input type="number" name="percentage" class="form-control percentage_of_basic" placeholder="Enter Allowance Percentage of Basic">
                            </div>
                            <div class="form-group">
                                <label>Limit Per Month</label>
                                <input type="text" name="limit_per_month" class="form-control" placeholder="Enter Allowance Limit Per Month">
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
                        <h4 class="modal-title">Deduction Edit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form  id="edit_deduction" method="POST" >
                        <div class="modal-body">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-group">
                                <label>Deduction Name</label>
                                <input type="text" name="deduction" class="form-control"  placeholder="Enter Deduction Name">
                                <input type="hidden" name="id" >
                            </div>
                            <div class="form-group">
                                <label>Deduction Type</label>
                                <select class="form-control update_deduction_type" name="deduction_type"  style="width: 100%;">
                                    <option disabled selected value="">Select The Deduction Type</option>
                                    <option value="0">Fixed</option>
                                    <option value="1">Percentage</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Percentage of Basic</label>
                                <input type="number" name="percentage" class="form-control percentage_of_basic" placeholder="Enter Allowance Percentage of Basic">
                            </div>
                            <div class="form-group">
                                <label>Limit Per Month</label>
                                <input type="text" name="limit_per_month" class="form-control" placeholder="Enter Allowance Limit Per Month">
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
<!-- DataTables -->
<script src="{{asset('public/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#deduction-list").DataTable({
        processing: true,
        serverSide: true,
        ajax:"deduction",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'deduction_name', name: 'deduction'},
            {data: 'deduction_type', name: 'type'},
            {data: 'percentage_of_basic', name: 'percentage'},
            {data: 'limit_per_month', name: 'month'},
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