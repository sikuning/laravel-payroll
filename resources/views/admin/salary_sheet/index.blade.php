@extends('admin.layout')
@section('title','Salary Details')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Salary Details @endslot
        @slot('add_btn') 
        <a href="{{url('admin/salary_sheet/create')}}" class="align-top btn btn-sm btn-primary d-inline-block">Generate Salary</a>
         @endslot
        @slot('active') Salary Details  @endslot
    @endcomponent
    <!-- /.content-header -->
    @if(Session::has('error'))
        <p class="alert {{ Session::get('alert-class', 'alert-danger') }}">{{ Session::get('error') }}</p>
        @endif
    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Month','Employee Name','Department','Net Salary','Status','Action']
    ])
        @slot('table_id') salary-list @endslot
    @endcomponent
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
    var table = $("#salary-list").DataTable({
        processing: true,
        serverSide: true,
        ajax:"salary_sheet",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'month', name: 'month'},
            {data: 'emp_name', name: 'emp_name'},
            {data: 'department_name', name: 'department'},
            {data: 'net_salary', name: 'net_salary'},
            {data: 'status', name: 'amount'},
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