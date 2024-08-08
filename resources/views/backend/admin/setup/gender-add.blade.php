@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Gender</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Gender</li>
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
					Update Gender
					@else
					Add Gender
					@endif 
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.gender.view')}}"><i class="fa fa-list"></i> Gender List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editData->id) ? route('setup.gender.update',$editData->id) : route('setup.gender.store')}}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Gender</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="{{@$editData->name}}" placeholder="Gender">
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