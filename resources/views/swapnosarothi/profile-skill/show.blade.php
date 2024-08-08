@extends('backend.layouts.app')
@section('content')


<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">View Skills </h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active"> View Skills </li>
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
					<h5>View Skills 
						<a class="btn btn-sm btn-success float-right" href="{{ route('swapnosarothiprofileskill.index') }}"><i class="fa fa-list"></i> Back Profile Skill Page</a></h5>
				</div>
				@if (count($profiles) > 0)
				<div class="card-body table-responsive">
					
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Sl.</th>
								<th>Girl's Name</th>
								<th>Father's Name</th>
								<th>Mother's Name</th>
								<th>Girl's Status</th>
								<th>Skills</th>
								<th>Action</th>
							</tr>
						</thead>
	
						<tbody>
						   @foreach ($profiles as $profile)
						   <input type="hidden" name="group_table_id" value="{{ $profile->group_id }}">
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ $profile->name }}</td>
								<td>{{ $profile->fathers_name }}</td>
								<td>{{ $profile->mothers_name }}</td>
								<td>
									@php
										$statusBg = $profile->group_status == 'ongoing' ? 'success' : ($profile->group_status == 'married' ? 'info' : ($profile->group_status == 'droupout' ? 'warning' : 'primary' ));
									@endphp
									<span class="badge badge-{{ $statusBg }}">{{ $profile->group_status }}</span>
									
								</td>
								<td>
									@foreach ($profile->profile_skills as $skill)
									
									<span class="badge badge-success">{{ $skill->skill->name }}</span>
										
									@endforeach
								</td>
								<td>
									<a href="{{ route('swapnosarothiprofileskill.edit', $profile->id) }}" class="btn btn-sm btn-primary">View</a>
								</td>
							</tr>
						   @endforeach
						</tbody>
					</table>
				</div>
				@else
				<div class="alert alert-info m-3">
					<p>Skill Not Found!</p>
				</div>
				@endif

			</div>
		</form>
	</div>
	
</div>
<!-- extra html -->

@endsection
