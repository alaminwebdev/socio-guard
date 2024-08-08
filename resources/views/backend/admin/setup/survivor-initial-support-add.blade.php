@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Survivor Initial Support</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Initial Support</li>
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
					Update Survivor Initial Support
					@else
					Add Survivor Initial Support
					@endif 
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.survivor.initial.support.view')}}"><i class="fa fa-list"></i> Survivor Initial Support List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editData->id) ? route('setup.survivor.initial.support.update',$editData->id) : route('setup.survivor.initial.support.store')}}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Survivor Initial Support</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="{{@$editData->name}}" placeholder="Write Support Name">
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