@extends('admin.layout')
@section('title','Payment History')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Payment History @endslot
        @slot('add_btn') 
         @endslot
        @slot('active') Payment History  @endslot
    @endcomponent
    <!-- /.content-header -->
   
    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Month','Employee Name','Amount','Paid On']
    ])
        @slot('table_id') payment-list @endslot
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
    var table = $("#payment-list").DataTable({
        processing: true,
        serverSide: true,
        ajax:"payment_history",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'month', name: 'month'},
            {data: 'emp_name', name: 'emp_name'},
            {data: 'amount', name: 'net_salary'},
            {data: 'date', name: 'net_salary'},
        ]
    });
</script>
@stop