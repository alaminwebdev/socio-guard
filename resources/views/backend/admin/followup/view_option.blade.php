@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Follow-Up Question-Options</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Follow-Up Question-Options</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
					Follow-Up Question-Options List
					<a class="btn btn-sm btn-success float-right" href="{{ route('followup.question.option.add') }}"><i class="fa fa-plus-circle"></i> Add Follow-Up Question-Options</a>
				</h5>
			</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
					<thead>
						<tr>
							<th>Sl.</th>
							<th>Question</th>
							<th>Options</th>
							<!-- <th>Status</th> -->
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($followup_questions as $key => $followup_question)
							@foreach($followup_question->followup_question_option as $key1 => $option)
								<tr class="tr-row">
									@if($key1 == 0)
										<td rowspan="{{ count($followup_question->followup_question_option) }}">{{ ++$key }}</td>
										<td rowspan="{{ count($followup_question->followup_question_option) }}">{{ $followup_question->question }}</td>
										<td>{{ $option->option }}</td>
										<!-- <td rowspan="{{ count($followup_question->followup_question_option) }}">{{ ($followup_question->status == 1) ? 'Active' : 'Inactive' }}</td> -->
										<td rowspan="{{ count($followup_question->followup_question_option) }}">
											<a class="btn btn-sm btn-success" title="Edit" href="{{ route('followup.question.option.edit', $followup_question->id) }}"><i class="fa fa-edit"></i></a>
										</td>
									@else
										<td>{{ $option->option }}</td>
									@endif
								</tr>
							@endforeach
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>

</script>

@endsection