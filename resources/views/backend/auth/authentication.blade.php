<html>
<head>
	<title>Authentication || BCS Academy</title>
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
		<div class="card card-container" style="margin-top: 150px; padding: 1px 40px 40px 40px;">
			<h3 class="text-center" style="color: #636363; font-weight: bold;">Authentication Code</h3>
            <div style="text-align: justify;"><p>Authentication code send successfully to your Email: {{@$email}} <br>Please do not close this tab/window. Open another tab/window to check your email to get authentication code</p></div><br>
			<form class="form-signin" action="{{route('login')}}" method="post">
				{{csrf_field()}}
				<input type="hidden" value="yes" name="authentication_has">           
				<div class="form-group {{$errors->has('password') ? 'has-error' : '' }}">
					<input type="text" class="form-control" placeholder="Authentication Code" name="authentication_code">
					@if ($errors->has('authentication_code'))
					<span class="help-block">
						<strong>{{ $errors->first('authentication_code') }}</strong>
					</span>
					@endif
				</div>
				<button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Authenticate</button>
			</form>
		</div>
	</div>
</body>
</html>
