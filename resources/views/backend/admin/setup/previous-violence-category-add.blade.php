@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Violence Type</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Violence Type</li>
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
					Update Previous Violence Type
					@else
					Add Previous Violence Type
					@endif 
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.previous.violence.category.view')}}"><i class="fa fa-list"></i> Previous Violence Type List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editData->id) ? route('setup.previous.violence.category.update',$editData->id) : route('setup.previous.violence.category.store')}}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Previous Violence Type</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="{{@$editData->name}}" placeholder="Write Violence Type">
							</div>
							<div class="form-group col-md-12">
								<label class="control-label">Status</label>
                                <br>
								Active : <input type="radio"  {{@$editData->status==1 ? "checked" : ""}} value="1" name="status">
                                &nbsp;&nbsp;&nbsp;Inactive: <input type="radio" {{@$editData->status==0 && isset($editData) ? "checked" : ""}} value="0" name="status">
							</div>
						</div>
					</div>
						
					<button type="submit" class="btn btn-success btn-sm">{{(@$editData) ? 'Update' : 'Submit'}}</button>
					<button type="reset" class="btn btn-danger btn-sm">Reset</button>
				</div>
			</form>
			<!--Form End-->
		</div>
	</div>
</div>
<!-- extra html -->

<script>
    $(document).ready(function(){
    	$('#myForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	            'name' : {
	                required : true,
	            },
	        },
	        messages : {

	        }
	    });
    });
</script>

@endsection