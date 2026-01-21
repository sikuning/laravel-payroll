<!doctype html>
<html lang="en-US">
<head>
<title>{{$siteInfo->com_name}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('public/assets/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('public/assets/css/adminlte.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body class="hold-transition login-page bg-white">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"> <b>{{$siteInfo->com_name}}</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body bg-light">
                <form id="employeeLogin" method="POST"> 
                   @csrf
                   <input type="hidden" id="url" value="{{url('/')}}">
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" name="email" placeholder="Enter Your Email">
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Enter Password">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mb-2">LogIn</button>
                </form>
                <div class="message"></div>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
    <!-- jquery-validation -->
    <script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
   
    <script src="{{asset('public/assets/js/additional-methods.min.js')}}"></script>
    <!-- SweetAlert -->
 <script src="{{asset('public/assets/js/sweetalert2.min.js')}}"></script>
    <script src="{{asset('public/assets/js/employee.js')}}"></script>
</body>

