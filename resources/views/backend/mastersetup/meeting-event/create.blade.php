@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Meeting Event</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Meeting Event</li>
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
					Update Meeting Event
					@else
					Add Meeting Event
					@endif 
					<a class="btn btn-sm btn-success float-right" href="{{route('meeting-event.index')}}"><i class="fa fa-list"></i> Meeting Event List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{ route('meeting-event.store') }}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Meeting Event Name</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="" placeholder="Write Meeting Event Name">
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
					{{-- <button type="reset" class="btn btn-danger btn-sm">Reset</button> --}}
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