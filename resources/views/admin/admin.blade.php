<!doctype html>
<html lang="en-US">
<head>
    <title>{{$siteInfo->com_name}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('public/assets/fontawesome-free/css/all.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('public/assets/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/assets/css/sweetalert-bootstrap-4.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{asset('public/site-img/'.$siteInfo->com_logo)}}" alt="" width="100px" >
        </div>
        <h3 class="text-center">{{$siteInfo->com_name}}</h3>
        <div class="card">
            <div class="card-body login-card-body">
                <form class="form-horizontal" id="adminLogin" method="POST">
                    @csrf
                    <input type="hidden" class="url" value="{{url('/')}}">
                    <div class="form-group mb-3">
                        <label>Username</label>
                        <input type="text" class="form-control" name="username" placeholder="UserName">
                    </div>
                    <div class="form-group mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Password">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block mb-2">LogIn</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->
    <!-- jQuery UI 1.11.4 -->
    <script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
    <!-- jquery-validation -->
    <script src="{{asset('public/assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('public/assets/js/sweetalert2.min.js')}}"></script>
   
    <script src="{{asset('public/assets/js/additional-methods.min.js')}}"></script>
    <script src="{{asset('public/assets/js/admin-login.js')}}"></script>

    <input type="hidden" class="site-url" value="{{url('/')}}"></input>
</body>
</html>
