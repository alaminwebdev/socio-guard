@extends('backend.layouts.app')
@section('content')

<style>
	.switch {
	  position: relative;
	  display: inline-block;
	  width: 50px;
	  height: 20px;
	}
	
	.switch input { 
	  opacity: 0;
	  width: 0;
	  height: 0;
	}
	
	.slider {
	  position: absolute;
	  cursor: pointer;
	  top: 0;
	  left: 0;
	  right: 0;
	  bottom: 0;
	  background-color: #ccc;
	  -webkit-transition: .4s;
	  transition: .4s;
	}
	
	.slider:before {
	  position: absolute;
	  content: "";
	  height: 15px;
	  width: 15px;
	  left: 5px;
	  bottom: 3px;
	  background-color: white;
	  -webkit-transition: .4s;
	  transition: .4s;
	}
	
	input:checked + .slider {
	  background-color: #28a745;
	}
	
	input:focus + .slider {
	  box-shadow: 0 0 1px #2196F3;
	}
	
	input:checked + .slider:before {
	  -webkit-transform: translateX(26px);
	  -ms-transform: translateX(26px);
	  transform: translateX(26px);
	}
	
	/* Rounded sliders */
	.slider.round {
	  border-radius: 34px;
	}
	
	.slider.round:before {
	  border-radius: 50%;
	}
</style>

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Add Skills </h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active"> Add Skills </li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	
	<div class="col-md-12 mt-3">
		<form action="{{ route('swapnosarothiprofileskill.store') }}" method="POST">
			@csrf
			<div class="card">
				<div class="card-header">
					<h5>Add Skills 
						<a class="btn btn-sm btn-success float-right" href="{{ route('swapnosarothiprofileskill.index') }}"><i class="fa fa-list"></i> Back Profile Skill Page</a></h5>
				</div>
				@if (count($profiles) > 0)
				<div class="card-body table-responsive">
					<div class="form-row">
						<div class="form-group col-md-4">
							<label class="control-label">Skill <span class="text-danger">*</span></label>
							<select name="skill_table_id" id="skill_id" class="form-control form-control-sm select2">
								<option value="">Select Session</option>
								@foreach ($skills as $skill)
									<option value="{{ $skill->id }}">{{ $skill->name }}</option>
								@endforeach
							</select>
							@error('skill_table_id')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Session Date <span class="text-danger">*</span></label>
							<input type="date" name="skill_date" class="form-control form-control-sm" value="{{old('skill_date')}}" max="{{ date('Y-m-d') }}">
							@error('skill_date')
								<p class="text-danger">{{ $message }}</p>
							@enderror
						</div>
					</div>
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="10%">Sl.</th>
								<th width="30%">Girl's Name</th>
								<th width="20%">Father's Name</th>
								<th width="20%">Mother's Name</th>
								<th width="20%">Action</th>
							</tr>
						</thead>
	
						<tbody id="profile_body">
						   @foreach ($profiles as $profile)
						   <input type="hidden" name="group_table_id" class="group_id" value="{{ $profile->group_id }}">
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $profile->name }}</td>
								<td>{{ $profile->fathers_name }}</td>
								<td>{{ $profile->mothers_name }}</td>
								<td>
									<input type="hidden" value="{{ $profile->id }}" class="profile_id">
									<label class="switch mb-0">
										<input type="checkbox" name="addskill[{{ $profile->id }}]" class="addskillcheck" checked>
										<span class="slider round"></span>
									</label>
									<div class="message_text" style="display: none">This Skill Already Added!</div>
								</td>
							</tr>
						   @endforeach
						</tbody>
					</table>
				</div>
				<div class="card-footer text-right">
					<button type="submit" class="btn btn-success" onclick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Submit</button>
				</div>
				@else
				<div class="alert alert-info m-3">
					<p>Profile Not Found!</p>
				</div>
				@endif

			</div>
		</form>
	</div>
	
</div>
<!-- extra html -->

<script>
	$(function($) {
		$(document).on('change', '#skill_id', function() {
		var skill_id = $(this).val();
		var group_id = $('.group_id').val();
		var profile_body = $('#profile_body');

		$.ajax({
			url: "{{ route('swapnosarothi.profile.skill.check') }}",
			type: 'GET',
			data: { group_id, skill_id },
			success: function(data) {
				profile_body.find('tr').each(function() {
					var profile_id = $(this).find('.profile_id').val();
					var checkbox = $(this).find('input[type="checkbox"]');
					var switchr = $(this).find('.switch');
					var message_text = $(this).find('.message_text');
					checkbox.attr('checked', true);
					switchr.fadeIn(100);
					message_text.fadeOut(50);
					$.each(data, function(index, item) {
						if (item == profile_id) {
							checkbox.attr('checked', false);
							switchr.fadeOut(100);
							message_text.fadeIn(200);
						}
					});
				});
				
			}
		});
	});
	});
</script>

@endsection
