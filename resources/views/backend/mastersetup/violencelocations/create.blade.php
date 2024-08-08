@extends('backend.layouts.app')
@section('content')

<div class="container fullbody">
	<div class="row">
		<div class="col-md-12 card">
			<div class="card-header">
				<h5>
					@if(@$editData)
					Update Violence Location
					@else
					Add Violence Location
					@endif 
					<a class="btn btn-sm btn-success float-right" href="{{route('violencelocations')}}"><i class="fa fa-list"></i> Violence Locations List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editData->id) ? route('violencelocations.update',$editData->id) : route('violencelocations.store')}}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Violence Location Name</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="{{@$editData->title}}" placeholder="Violence Location Name">
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