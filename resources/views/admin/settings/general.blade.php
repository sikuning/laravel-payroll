@extends('admin.layout')
@section('title','General Settings')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    @component('admin.components.content-header',['breadcrumb'=>['Dashboard'=>'admin/dashboard']])
        @slot('title') General Settings @endslot
        @slot('add_btn') @endslot
        @slot('active') General Settings @endslot
    @endcomponent
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- form start -->
            <form class="form-horizontal" id="updateGeneralSetting" method="POST">
            {{ csrf_field() }}
                @foreach($data as $item)
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group row">
                                            <label class="col-md-3">Company Logo</label>
                                            <div class="col-md-9">
                                                <input type="hidden" class="custom-file-input" name="old_logo" value="{{$item->com_logo}}" />
                                                <input type="file" hidden class="change-com-img" name="logo" onChange="readURL(this);">
                                                @if(empty($item->com_logo))
                                                    <img class="img-thumbnail" id="image" src="{{asset('public/site-img/default.png')}}" width="150px" height="150px">
                                                @else
                                                    <img class="img-thumbnail" id="image" src="{{asset('public/site-img/'.$item->com_logo)}}" width="150px" height="150px">
                                                @endif
                                                <button type="button" class="btn btn-info d-block mt-2 change-logo">Change</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Company Name</label>
                                            <input type="text" class="form-control" name="com_name" value="{{$item->com_name}}"  placeholder="Enter Name">
                                        </div>
                                        <div class="form-group">
                                            <label>Company Email</label>
                                            <input type="email" class="form-control" name="com_email"  value="{{$item->com_email}}" placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <label>Company Address</label>
                                            <input type="text" class="form-control" name="address"  value="{{$item->address}}" placeholder="Enter Email Address">
                                        </div>
                                      
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <!-- phone mask -->
                                        <div class="form-group">
                                            <label>Phone Number <small class="text-danger">*</small></label>
                                            <div class="input-group" >
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                                </div>
                                                <input type="text" name="phone" class="form-control" value="{{$item->com_phone}}" data-inputmask='"mask": "(999) 999-9999"' data-mask>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mb-4">
                                            <label>Site Copyright</label>
                                            <input type="text" class="form-control" name="c_text" value="{{$item->copyright_text}}"  >
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group mb-4">
                                            <label>Currency Format</label>
                                            <input type="text" class="form-control" name="cur_format" value="{{$item->cur_format}}"  >
                                        </div>
                                    </div>
                                     <div class="form-group col-md-12 col-12">
                                        <input type="submit" class="btn btn-primary update-general-settings" value="Update"/>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                @endforeach
            </form> <!-- /.form start -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
  
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    }
</script>
@stop