@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Violence Sub Type</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Sub Type</li>
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
					Update Violence Sub Type
					@else
					Add Violence Sub Type
					@endif 
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.violence.sub-category.view')}}"><i class="fa fa-list"></i> Violence Sub Type List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editData->id) ? route('setup.violence.sub-category.update',$editData->id) : route('setup.violence.sub-category.store')}}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Violence Type</label>
								<select name="violence_category_id" class="form-control form-control-sm">
									<option value="">Select Type</option>
									@foreach($violence_categories as $vcategory)
									<option value="{{$vcategory->id}}" {{(@$editData->violence_category_id==$vcategory->id)?"selected":""}}>{{$vcategory->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">Violence Sub Type</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="{{@$editData->name}}" placeholder="Write Violence Sub Type">
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
	            'violence_category_id' : {
	                required : true,
	            },
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