@extends('backend.layouts.app')
@section('content')

<style>
	.profile-info {
		font-size: 15px;
	}
</style>

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Add Follow-Up Information</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Follow-Up Information</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
					Follow-Up Information
					<a class="btn btn-sm btn-success float-right" href="{{ route('followup.info.view') }}"><i class="fa fa-plus-circle"></i> View Follow-Up List</a>
				</h5>
			</div>
			<div class="card-body">
				<div class="row">
                    <!-- <div class="col-sm-6 col-md-3">
                        <img src="{{asset('uploads/images/trainer_images/20190826_1566819300_Traniner_Name.jpg') }}" alt="" class="img-rounded img-responsive" height="150" width="150">
                    </div> -->
                    <div class="col-sm-6 col-md-12">
                    	<div class="row">
                    		<div class="col-sm-4">
                    			<p><span class="profile-info">Incident No. :</span> {{ $incident->survivor_id }}</p>
                    			<p><span class="profile-info">Follow-Up No :</span> {{ isset($followup_info) ? $followup_info->followup_no : '' }}</p>
                    		</div>
                    		<div class="col-sm-4">
		                    	<p><span class="profile-info">Survivor Name :</span> {{ $incident->survivor_name }}</p>
		                    	<p><span class="profile-info">Last Follow-Up Date :</span> {{ isset($followup_info) ? date("Y-m-d h:i A", strtotime($followup_info->followup_date)) : '' }}</p>
                    		</div>
                    		<div class="col-sm-4">
		                    	<p><span class="profile-info">Incident Date :</span> {{ $incident->violence_date }}</p>
		                    	<p><span class="profile-info">Last Follow-Up Done By :</span> {{ isset($followup_info) ? $followup_info->followup_done_by->name : '' }}</p>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-sm-12">
		                    	<p>
		                    		<span class="profile-info">Survivor Support Name :</span>
		                    		@foreach($incident->survivor_brac_support as $key => $support)
		                    			{{ $support->brac_final_support['name'] }},
		                    		@endforeach
		                    		@foreach($incident->survivor_other_organization_support as $key => $support)
		                    			{{ $support->other_organization_final_support['name'] }},
		                    		@endforeach
		                    	</p>
		                    </div>
	                    </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
	<br>
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Follow-Up Questions</h5>
			</div>
			<div class="card-body">
				<form method="post" action="{{ route('followup.info.store') }}">
					{{ csrf_field() }}
					<input type="hidden" class="form-control" name="survivor_id" value="{{ $incident->survivor_id }}">
					<input type="hidden" class="form-control" name="survivor_incident_info_id" value="{{ $incident->id }}">
					<div class="form-row">
						<div class="form-group col-md-2">
							<label class="control-label">Follow-Up Date:</label>
						</div>
						<div class="form-group col-md-2">
							<input type="text" name="followup_date" class="form-control form-control-sm singledatepicker" value="" readonly="" required="">
						</div>
					</div>
					<br>
					@php $count = 0; @endphp
				    @foreach($questions as $key => $question)
				    <input type="hidden" class="form-control" name="question[{{ $key }}]" value="{{ $question->id }}">
			    	<div>
						<div class="form-group">
							<label><span>{{ ++$count }}.</span> {{ $question->question }}</label>
						</div>
						@foreach($question->followup_question_option as $key1 => $option)
						<div class="form-check-inline">
							<label class="form-check-label">
					        	<input type="radio" class="form-check-input" name="option[{{ $key }}]" value="{{ $option->id }}" required="">{{ $option->option }}
					    	</label>
					    </div>
					    @endforeach
				    </div>
				    <br>
				    @endforeach
				    <div class="form-row">
					    <div class="form-group col-md-8">
						  	<label>Remarks:</label>
						  	<textarea class="form-control" rows="4" name="remark"></textarea>
						</div>
					</div>
				    <br>
				    <button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
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