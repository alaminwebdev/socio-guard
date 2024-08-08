@extends('backend.layouts.app')
@section('content')

<div class="container fullbody">
	<div class="row">
		<div class="col-md-12 card">
			<div class="card-header">
				<h5>
					@if(@$editData)
					Update Survivor's Relationship with Accused
					@else
					Add Survivor's Relationship with Accused
					@endif 
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.accuse.relationship.view')}}"><i class="fa fa-list"></i> Survivor's Relationship with Accused List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editData->id) ? route('setup.accuse.relationship.update',$editData->id) : route('setup.accuse.relationship.store')}}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Survivor's Relationship with Accused</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="{{@$editData->name}}" placeholder="Survivor's Relationship with Accused">
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