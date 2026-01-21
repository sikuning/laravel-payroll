@extends('admin.layout')
@section('title','Tax Rule')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Tax Rule @endslot
        @slot('add_btn') 
        <!-- <button type="button" data-toggle="modal" data-target="#modal-default" class="align-top btn btn-sm btn-primary d-inline-block">Add New</button> -->
         @endslot
        @slot('active') Tax Rule  @endslot
    @endcomponent
    <!-- /.content-header -->

    <!-- show data table component -->
    @component('admin.components.data-table',['thead'=>
        ['S NO.','Total Income','Tax Rate %','Taxable Amount','Action']
    ])
        @slot('table_id') tax-list @endslot
    @endcomponent

    <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tax Rule Add</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form  id="add_tax" method="POST" >
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Total Income</label>
                                <input type="number" name="income" class="form-control income" placeholder="Enter Total Income">
                            </div>
                            <div class="form-group">
                                <label>Tax Rate %</label>
                                <input type="number" name="tax" class="form-control" placeholder="Enter Tax Rate">
                            </div>
                            <div class="form-group">
                                <label>Taxable Amount</label>
                                <input type="number" name="taxable_amount" class="form-control taxable_amount" placeholder="Enter Taxable Amount">
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
                        <h4 class="modal-title">Tax Rule Edit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- form start -->
                    <form  id="edit_tax" method="POST" >
                        <div class="modal-body">
                            @csrf
                            {{ method_field('PATCH') }}
                            <div class="form-group">
                                <label>Total Income</label>
                                <input type="text" name="income" class="form-control m_income"  placeholder="Enter Total Income">
                                <input type="hidden" name="id" >
                            </div>
                            <div class="form-group">
                                <label>Tax Rate %</label>
                                <input type="number" name="tax" class="form-control tax m_tax" placeholder="Enter Tax Rate">
                            </div>
                            <div class="form-group">
                                <label>Taxable Amount</label>
                                <input type="number" name="taxable_amount" class="form-control taxable_amount" placeholder="Enter Taxable Amount">
                            </div>
                            <div class="form-group">
                                <!-- <label>Gender</label> -->
                                <select hidden class="form-control" name="gender"  style="width: 100%;">
                                    <option disabled selected value="">Select The Gender Name</option>
                                    <option value="m">Male</option>
                                    <option value="f">Female</option>
                                </select>
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
    var table = $("#tax-list").DataTable({
        processing: true,
        serverSide: true,
        ajax:"tax_rule",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex',sWidth: '40px'},
            {data: 'total_income', name: 'income'},
            {data: 'tax_rate', name: 'tax_rate'},
            {data: 'taxable_amount', name: 'amount'},
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