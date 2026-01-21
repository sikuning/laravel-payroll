@extends('admin.layout')
@section('title','Monthly Pay Grade')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Monthly Pay Grade @endslot
        @slot('add_btn')<a href="{{url('admin/pay_grade/create')}}" class="align-top btn btn-sm btn-primary">Add New</a> @endslot
        @slot('active') Monthly Pay Grade  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Pay Grade Name','Gross Salary','Percentage of Basic','Basic Salary','Overtime Rate','Action']
    ])
        @slot('table_id')pay-list @endslot
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
    var table = $("#pay-list").DataTable({
        processing: true,
        serverSide: true,
        ajax:"pay_grade",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'pay_grade', name: 'pay'},
            {data: 'gross_salary', name: 'gross_salary'},
            {data: 'percentage_of_basic', name: 'percentage'},
            {data: 'basic_salary', name: 'basic_salary'},
            {data: 'overtime_rate', name: 'overtime_rate'},
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