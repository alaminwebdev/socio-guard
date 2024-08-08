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
                    <div class="col-sm-6 col-md-9">
                    	<div class="row">
                    		<div class="col-sm-6">
                    			<p><span class="profile-info">Incident No.:</span> {{ $incident->survivor_id }}</p>
		                    	<p><span class="profile-info">survivor Name:</span> {{ $incident->survivor_name }}</p>
		                    	<p><span class="profile-info">Incident Date:</span> {{ $incident->violence_date }}</p>
                    		</div>
                    		<div class="col-sm-6">
                    			<p><span class="profile-info">Follow-Up No:</span> {{ isset($followup_info) ? $followup_info->followup_no : '' }}</p>
		                    	<p><span class="profile-info">Last Follow-Up Date:</span> {{ isset($followup_info) ? date("Y-m-d h:i A", strtotime($followup_info->followup_date)) : '' }}</p>
		                    	<p><span class="profile-info">Last Follow-Up Done By:</span> {{ isset($followup_info) ? $followup_info->followup_done_by->name : '' }}</p>
                    		</div>
                    	</div>
                    	<div class="row">
                    		<div class="col-sm-12">
		                    	<p>
		                    		<span class="profile-info">Survivor Support Name:</span>
		                    		@foreach($incident->survivor_brac_support as $key => $support)
			                    		@if(!empty($support->brac_final_support->name))
			                    			{{ $support->brac_final_support->name }},
			                    		@endif
		                    		@endforeach
		                    		@foreach($incident->survivor_other_organization_support as $key => $support)
			                    		@if(!empty($support->other_organization_final_support->name))
			                    			{{ $support->other_organization_final_support->name }},
			                    		@endif
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
				<h5>Follow-Up Answer</h5>
			</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%;">
					<thead>
						<tr>
							<th>Sl.</th>
							<th>Question</th>
							<th>First Follow-up Answer</th>
							<th>Second Follow-up Answer</th>
							<th>Third Follow-up Answer</th>
						</tr>
					</thead>
					<tbody>
						@foreach($followups as $key => $followup)
						<tr class="tr-row">
							<td>{{ ++$key }}</td>
							<td>{{ $followup->question }}</td>
							<!-- <td>{{ isset($followup['question_answer'][0]['followup_question_answer']) ? $followup['question_answer'][0]['question_answer_option']['option'] : '' }}</td>
							<td>{{ isset($followup['question_answer'][1]['followup_question_answer']) ? $followup['question_answer'][0]['question_answer_option']['option'] : '' }}</td>
							<td>{{ isset($followup['question_answer'][2]['followup_question_answer']) ? $followup['question_answer'][0]['question_answer_option']['option'] : '' }}</td> -->
							<td>{{ isset($followup['question_answer']) ? @$followup['question_answer'][0]['question_answer_option']['option'] : '' }}</td>
							<td>{{ isset($followup['question_answer']) ? @$followup['question_answer'][1]['question_answer_option']['option'] : '' }}</td>
							<td>{{ isset($followup['question_answer']) ? @$followup['question_answer'][2]['question_answer_option']['option'] : '' }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- extra html -->

@endsection
