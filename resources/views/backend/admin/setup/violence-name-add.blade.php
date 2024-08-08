@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Violence Name</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Violence Name</li>
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
					Update Violence Name
					@else
					Add Violence Name
					@endif
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.violence.name.view')}}"><i class="fa fa-list"></i> Violence Name List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editData->id) ? route('setup.violence.name.update',$editData->id) : route('setup.violence.name.store')}}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Violence Type</label>
								<select name="violence_category_id" id="violence_category_id" class="form-control form-control-sm">
									<option value="">Select Type</option>
									@foreach($violence_categories as $vcategory)
									<option value="{{$vcategory->id}}" {{(@$editData->violence_category_id==$vcategory->id)?"selected":""}}>{{$vcategory->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">Violence Sub Type</label>
								<select name="violence_sub_category_id" id="violence_sub_category_id" class="form-control form-control-sm">
									<option value="">Select Sub Type</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">Violence Name</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="{{@$editData->name}}" placeholder="Write Violence Name">
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
	            'violence_sub_category_id' : {
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

<script type="text/javascript">
	$(function(){
		$(document).on('change','#violence_category_id',function(){
			var violence_category_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-violence-sub-category')}}",
				type : "GET",
				data : {violence_category_id:violence_category_id},
				success:function(data){
					var html = '<option value="">Select Violence Sub Category</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('#violence_sub_category_id').html(html);
					var violence_sub_category_id = "{{@$editData->violence_sub_category_id}}";
					if(violence_sub_category_id !=''){
						$('#violence_sub_category_id').val(violence_sub_category_id);
					}
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		var violence_category_id = "{{@$editData->violence_category_id}}";
		if(violence_category_id){
			$('#violence_category_id').val(violence_category_id).trigger('change');
		}
	});
</script>

@endsection