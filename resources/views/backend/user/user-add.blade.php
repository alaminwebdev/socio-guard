@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage User</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">User</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
					@if(@$editData)
					Update User
					@else
					Add User
					@endif
					<a class="btn btn-sm btn-success float-right" href="{{route('user')}}"><i class="fa fa-list"></i> User List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editData->id) ? route('user.update',$editData->id) : route('user.store')}}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="control-label">PIN</label>
									<div class="row">
										<div class="col-md-4">
											<input type="number" name="pin" id="pin" class="form-control form-control-sm" value="{{@$editData->pin}}" placeholder="Write User PIN" onfocusout="getUsersApi($(this))">  <!-- onfocusout="getUserApi($(this))" -->
										</div>
										<div class="col-md-2">
				                            <input type="button" value="Search" class="btn btn-success find-land-btn btn-sm" onclick="getUserApi($(this));">
										</div>
									</div>
								</div>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Name</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="{{@$editData->name}}" placeholder="Write User Name">
								<font color="red">{{($errors->has('name'))?($errors->first('name')):''}}</font>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Email</label>
								<input type="email" name="email" id="email" class="form-control form-control-sm" value="{{@$editData->email}}" placeholder="Write User Email" autocomplete="off">
								<font color="red">{{($errors->has('email'))?($errors->first('email')):''}}</font>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Designation</label>
								<input type="text" name="designation" id="designation" class="form-control form-control-sm" value="{{@$editData->designation}}" placeholder="Write User Designation">
							</div>

							<div class="form-group col-md-4">
								<label class="control-label">Mobile No</label>
								<input type="number" name="mobile" id="mobile" class="form-control form-control-sm" value="{{@$editData->mobile}}" placeholder="Write Mobile No" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
							    maxlength = "11">
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">User Role</label>
								<select name="user_role[]" id="user_role" class="form-control form-control-sm select2" multiple>
									@foreach($roles as $role)
									<option value="{{ $role->id }}" {{ @$role_array ? in_array($role->id, array_column($role_array, 'role_id')) ? "selected" : "" : "" }}>
										{{ $role->name }}
									</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Password</label>
								<input type="password" name="password" id="password" class="form-control form-control-sm" autocomplete="off">
								<font color="red">{{($errors->has('password'))?($errors->first('password')):''}}</font>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Confirm Password</label>
								<input type="password" name="password2" class="form-control form-control-sm">
							</div>
							<!-- @if(!isset($editData))
							@endif -->
						</div>
					</div>

					<button type="submit" class="btn btn-success btn-sm">{{(@$editData) ? 'Update' : 'Submit'}}</button>
				</div>
			</form>
			<!--Form End-->
		</div>
	</div>
</div>
<!-- extra html -->

<script type="text/javascript">
	function minmax(digit, min, max)
	{
	    if(parseInt(digit) < min || isNaN(parseInt(digit)))
	        return min;
	    else if(parseInt(digit) > max)
	        return max;
	    else return digit;
	}
</script>

<script>
	function getUserApi(item) {
		// var employee_pin = item.val();
		var employee_pin = $('#pin').val();
		var url  = "{{ route('setup.getUserApi') }}";
      	var data = {
    		employee_pin: employee_pin
    	}

      	$.get(url, data, function(response) {
      		console.log(response);
      		item.closest('.show_module_more_event').find('#name').val(response[0].StaffName);
            item.closest('.show_module_more_event').find('#email').val(response[0].EmailID);
			item.closest('.show_module_more_event').find('#designation').val(response[0].DesignationName);
			item.closest('.show_module_more_event').find('#mobile').val(response[0].MobileNo);
        });
	}

	function getUsersApi(item) {
		var employee_pin = item.val();
		// var employee_pin = $('#pin').val();
		var url  = "{{ route('setup.getUserApi') }}";
      	var data = {
    		employee_pin: employee_pin
    	}

      	$.get(url, data, function(response) {
      		console.log(response);
      		item.closest('.show_module_more_event').find('#name').val(response[0].StaffName);
            item.closest('.show_module_more_event').find('#email').val(response[0].EmailID);
			item.closest('.show_module_more_event').find('#designation').val(response[0].DesignationName);
			item.closest('.show_module_more_event').find('#mobile').val(response[0].MobileNo);
        });
	}

    $(document).ready(function(){
    	$('#myForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	            // role : {
	            //     required : true
	            // },
	            // name : {
	            //     required : true
	            // },
	            // designation : {
	            //     required : true
	            // },
	            // pin : {
	            //     required : true
	            // },
	            // mobile : {
	            //     required : true
	            // },
	            // email : {
	            //     required : true,
	            //     email : true
	            // },
				status : {
					required : true
				},
	        },
	        messages : {
	        	email : {
	                required : 'Please enter email address',
	                email : 'Please enter a <em>valid</em> email address',
	            },
	        }
	    });
    });
</script>

@endsection