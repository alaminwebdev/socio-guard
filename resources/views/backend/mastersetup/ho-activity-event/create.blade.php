@extends('backend.layouts.app')
@section('content')

{{-- <div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Head Office Activity Event</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Head Office Activity Event</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div> --}}
<div class="container-fluid pt-5">
	<div class="col-md-12">
		<div class="card border-0">
			<div class="card-header border-bottom-0 brac-header d-flex justify-content-between align-items-center">
				<h6 class="mb-0 text-white">
					@if(@$editData)
					Update Head Office Activity Event
					@else
					Add Head Office Activity Event
					@endif 
				</h6>
				<a class="btn btn-sm btn-success" href="{{route('ho-activity-events.index')}}"><i class="fa fa-list"></i> Head Office Activity Event List</a>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{ route('ho-activity-events.store') }}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-8">
								<label class="control-label">Head Office Activity Event Name</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="" placeholder="Write Event Name">
							</div>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-6">
							<label class="control-label">Status</label>
							<br>
							Active : <input type="radio" checked value="1" name="status"/>
							&nbsp;&nbsp;&nbsp;Inactive: <input type="radio" value="0" name="status"/>
						</div>
					</div>
						
					<button type="submit" class="btn btn-success btn-sm"> Submit </button>
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