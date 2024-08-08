@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Village</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Village</li>
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
					Update Village
					@else
					Add Village
					@endif 
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.village.view')}}"><i class="fa fa-list"></i> Village List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editData->id) ? route('setup.village.update',$editData->id) : route('setup.village.store')}}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Division Name</label>
								<select name="division_id" id="division_id" class="form-control form-control-sm">
									<option value="">Select Division</option>
									@foreach($divisions as $d)
									<option value="{{$d->id}}" {{(@$editData->division_id==$d->id)?"selected":""}}>{{$d->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">District Name</label>
								<select name="district_id" id="district_id" class="form-control form-control-sm">
									<option value="">Select District</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">Upazila Name</label>
								<select name="upazila_id" id="upazila_id" class="form-control form-control-sm">
									<option value="">Select Upazila</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">Union Name</label>
								<select name="union_id" id="union_id" class="form-control form-control-sm">
									<option value="">Select Union</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label class="control-label">Village Name</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="{{@$editData->name}}" placeholder="Village Name">
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

	<div class="col-md-12 mt-5">
		<div class="card">
			<div class="card-header">
				<h5>Upload Village Data</h5>
			</div>
			<!-- Form Start-->
			<form action="{{ route('setup.village.import') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row p-5">
					<div class="col-md-6">
						<input type="file" class="form-control" name="village">
					</div>
					<div class="col-md-6">
	
						<input type="submit" class="btn btn-sm btn-primary">
					</div>
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
	            'division_id' : {
	                required : true,
	            },
	            'district_id' : {
	                required : true,
	            },
	            'upazila_id' : {
	                required : true,
	            },
	            'union_id' : {
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
		$(document).on('change','#division_id',function(){
			var division_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-district')}}",
				type : "GET",
				data : {division_id:division_id},
				success:function(data){
					var html = '<option value="">Select District</option>';
					//console.log(data);
					$.each(data[0],function(key,v){
						console.log(v);
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('#district_id').html(html);
					var district_id = "{{@$editData->district_id}}";
					if(district_id !=''){
						$('#district_id').val(district_id).trigger('change');
					}
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('change','#district_id',function(){
			var district_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-upazila')}}",
				type : "GET",
				data : {district_id:district_id},
				success:function(data){
					var html = '<option value="">Select Upazila</option>';
					$.each(data[0],function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('#upazila_id').html(html);
					var upazila_id = "{{@$editData->upazila_id}}";
					if(upazila_id !=''){
						$('#upazila_id').val(upazila_id).trigger('change');
					}
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('change','#upazila_id',function(){
			var upazila_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-union')}}",
				type : "GET",
				data : {upazila_id:upazila_id},
				success:function(data){
					var html = '<option value="">Select Union</option>';
					
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('#union_id').html(html);
					var union_id = "{{@$editData->union_id}}";
					if(union_id !=''){
						$('#union_id').val(union_id);
					}
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		var division_id = "{{@$editData->division_id}}";
		if(division_id){
			$('#division_id').val(division_id).trigger('change');
		}
	});
</script>

@endsection