<html>
<head>
    <title>Login || BCS Academy</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('css/login.css')}}" rel="stylesheet">
    <script src="{{asset('backend/js/jquery.min.js')}}"></script>
    <script src="{{asset('backend/js/notify.js') }}"></script>
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
</head>

<body>
    <div class="container">
        <div class="card card-container">
            <img id="profile-img" class="profile-img-card" src="{{asset('backend/images/logo.png')}}"/>
            <!-- <p id="profile-name" class="profile-name-card">Incident</p> -->
            <form class="form-signin" action="{{route('masterlogin')}}" method="post">
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
            </form><!-- /form -->
        <!-- <a href="#" class="forgot-password">
            Forgot the password?
        </a> -->
    </div><!-- /card-container -->
</div><!-- /container -->
</body>
</html>
