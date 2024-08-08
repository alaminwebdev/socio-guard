<html>
<head>
    <title>Login || SELP</title>
    <link rel="icon" href="{{asset('backend/images/logo2.png')}}" type="image/x-icon" sizes="16x16"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('css/login.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/plugins/sweetalert2/sweetalert2.min.css')}}">
    <script src="{{asset('backend/js/jquery.min.js')}}"></script>
    <script src="{{ asset('backend/js/notify.js') }}"></script>
    <script type="text/javascript" src="{{asset('frontend/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    @if (session()->has('success'))
    <script type="text/javascript">
        $(function () {
            $.notify("{{session()->get("success")}}", {globalPosition: 'top right',className: 'success'});
        });
    </script>
    @endif

    @if (session()->has('error'))
    <script type="text/javascript">
        $(function () {
            $.notify("{{session()->get("error")}}", {globalPosition: 'top right',className: 'error'});
        });
    </script>
    @endif

    @if (session()->has('warning'))
    <script type="text/javascript">
        $(function () {
            $.notify("{{session()->get("warning")}}", {globalPosition: 'top right',className: 'warn'});
        });
    </script>
    @endif
    @if (session()->has('swal-success'))
    <script type="text/javascript">
        $(function () {
            Swal.fire({
                position: 'center',
                type: 'success',
                title: '{{session()->get("swal-success")}}',
            });
        });
    </script>
    @endif

    <style>
        body {
            /* background-color: #dddddd; */
            /* background-image: url(http://www.brac.net/program/wp-content/uploads/2019/11/sdp-banner-.jpg); */
            
                background-image: url(backend/images/login_photo.jpg)!important;
                background-repeat: no-repeat!important;
                background-size: 100% 100%!important;
                overflow: hidden;
            
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card card-container">
            <img style="height: 75px; width: 210px" id="profile-img" class="profile-img-card" src="{{url('backend/images/logo-original.png')}}"/>
            <p id="profile-name" class="profile-name-card">Social Empowerment and Legal Protection (SELP)</p>
            <br>
            <form class="form-signin" action="{{route('login')}}" method="post">
                {{csrf_field()}} 
                <div class="form-group {{$errors->has('email') ? 'has-error' : '' }}">
                    <input type="text" class="form-control" name="email" value="{{old('email')}}" placeholder="Email Address" required autofocus>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>              
                
                <div class="form-group {{$errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" class="form-control" placeholder="Password" required name="password">
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
            </form>
            <!-- <div class="text-center"><a href="{{url('/')}}"> Back to home page </a></div>
            <div class="form-group row mb-0 text-center">
                @if (Route::has('password.request'))
                <a class="btn btn-link" href="" style="cursor: pointer;">
                    {{ __('Forgot Your Password?') }}
                </a>
                @endif
            </div> -->
            <!-- /form -->
        <!-- <a href="#" class="forgot-password">
            Forgot the password?
        </a> -->
    </div><!-- /card-container -->
</div><!-- /container -->
</body>
</html>
