@extends('admin.layout')
@section('title','Employees')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Employees @endslot
        @slot('add_btn') <a href="{{url('admin/employees/create')}}" class="align-top btn btn-sm btn-info">Add New</a> @endslot
        @slot('active') Employees  @endslot
    @endcomponent
    <!-- /.content-header -->
    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','ID','Photo','Name','Phone','Department','Date of Joining','Status','Action']
    ])
        @slot('table_id') employee-list @endslot
    @endcomponent
</div>
@stop

@section('pageJsScripts')
<!-- DataTables -->
<script src="{{asset('public/assets/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('public/assets/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/assets/js/responsive.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    var table = $("#employee-list").DataTable({
        processing: true,
        serverSide: true,
        ajax: "employees",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'id', name: 'id'},
            {data: 'emp_img', name: 'image'},
            {data: 'emp_name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'department', name: 'department'},
            {data: 'date_of_joining', name: 'date'},
            {data: 'status', name: 'status'},
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