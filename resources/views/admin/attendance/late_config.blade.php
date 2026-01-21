@extends('admin.layout')
@section('title','Late Configration')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
   @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') Late Configuration @endslot
        @slot('add_btn') @endslot
        @slot('active') Late Configration @endslot
    @endcomponent
    <!-- /.content-header -->
    <div class="card">
        <div class="card-header"> 
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive">
        @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-primary') }}">{{ Session::get('message') }}</p>
        @endif
            <form action="{{url('admin/late_configration')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="">For Days</label>
                    <input type="number" class="form-control" name="for_days" value="{{$salary_deduction->for_days}}">
                </div>
                <div class="form-group">
                    <label for="">Days of Salary Deduction</label>
                    <input type="number" class="form-control" name="days_salary" value="{{$salary_deduction->days_of_salary}}">
                </div>
                <div class="form-group">
                    <label for="">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{(($salary_deduction->status == '1')? 'selected' : '')}}>Active</option>
                        <option value="0" {{(($salary_deduction->status == '0')? 'selected' : '')}}>Inactive</option>
                    </select>
                </div>
                <input type="submit" class="btn btn-primary" name="update" value="Update">
            </form>
        </div>
    </div>
    <!-- /.card -->
</div>
@stop

@section('pageJsScripts')

</script>
@stop