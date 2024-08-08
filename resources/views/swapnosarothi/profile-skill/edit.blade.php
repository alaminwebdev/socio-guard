@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Profile Skills </h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active"> Profile Skills </li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	
	<div class="col-md-12 mt-3">
		<div class="card">
			<div class="card-header">
				<h5>Girl's Profile Info 
					<a class="btn btn-sm btn-success float-right" href="{{ route('swapnosarothiprofileskill.index') }}"><i class="fa fa-list"></i> Back Profile Skill Page</a>
				</h5>
			</div>
            <div class="card-body">
                <div class="row mt-3">
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Profile Id:</strong> {{ $skillDatas->id }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Group Id:</strong> {{ @$skillDatas->groupName->group_id }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Group Name:</strong> {{ @$skillDatas->groupName->group_name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Group Status:</strong> <span class="badge badge-{{@$skillDatas->groupName->status == 1 ? 'success' : 'warning'  }}">{{ @$skillDatas->groupName->status == 1 ? 'Active' : 'Deactive' }}</span></p>
                    </div>
                    <div class=" col-md-3 align-self-center">
						@php
							 $statusBg = $skillDatas->group_status == 'ongoing' ? 'success' : ($skillDatas->group_status == 'married' ? 'info' : ($skillDatas->group_status == 'droupout' ? 'warning' : 'primary' ));
						@endphp
                        <p><strong>Profile Status:</strong> <span class="badge badge-{{$statusBg}}">
							{{ $skillDatas->group_status }}
						</span></p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Girl's Name:</strong> {{ @$skillDatas->name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Date Of Birth:</strong> {{ $skillDatas->date_of_birth ? $skillDatas->date_of_birth->format('d M Y') : ''}}</p>
                    </div>
					<div class=" col-md-3 align-self-center">
                        <p><strong>Start Date:</strong> {{ $skillDatas->start_date ? $skillDatas->start_date->format('d M Y') :'' }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Division:</strong> {{ @$skillDatas->profile_division->name }} </p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>District:</strong> {{ @$skillDatas->profile_district->name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Upazila:</strong> {{ @$skillDatas->profile_upazila->name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Union:</strong> {{ @$skillDatas->profile_union->name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Village:</strong> {{ @$skillDatas->profile_village->name }}</p>
                    </div>
                </div>
            </div>
		</div>
	</div>
	<div class="col-md-12 mt-3">
		<div class="card">
			<div class="card-header">
				<h5>Gril's Skills</h5>
			</div>
			<div class="card-body">
				<table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Skill Name</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($skillDatas->profile_skills as $profile_skill)
							<tr>
								<td>{{ $loop->iteration }}</td>
								<td>{{ @$profile_skill->skill->name }}</td>
								<td>{{ $profile_skill->skill_date->format('d M Y') }}</td>
								<td>
									@if ( $skillDatas->group_status == 'ongoing' && $skillDatas->groupName->status == 1)
										<a href="{{ route('swapnosarothiprofileskill.edit', $profile_skill->id) }}" class="btn btn-sm btn-info skillEdtiBtn" title="Edit" data-id="{{ $profile_skill->id }}" data-name="{{ @$profile_skill->skill->name }}" data-skilldate="{{ $profile_skill->skill_date->format('Y-m-d') }}" data-toggle="modal" data-target="#editSkillModal"><i class="fa fa-edit"></i></a>
									@endif
									<form action="{{ route('swapnosarothiprofileskill.destroy', $profile_skill->id) }}" class="d-inline profileDelete" method="POST">
										@csrf
										@method('DELETE')
										<button type="button" class="btn btn-sm btn-danger" style="min-width: auto" title="Delete"><i class="fa fa-trash"></i></button>
									</form>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="4"><p>No Skill Found!</p></td>
							</tr>
						@endforelse
                    </tbody>
                </table>
			</div>
		</div>
	</div>
</div>
<!-- extra html -->

{{-- edit modal --}}
<!-- Modal -->
<div class="modal fade" id="editSkillModal" data-backdrop="static" data-keyboard="false">
	<form action="" method="POST" id="modalSubmit">
		@csrf
		@method('PUT')
		<input type="hidden" name="updated_by" value="{{ Auth::id() }}">
	<div class="modal-dialog modal-dialog-centered modal-lg">
	 
		<div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			  </button>
			</div>
			<div class="modal-body">
				<div class="form-row">
					<div class="form-group col-md-4">
						<label class="control-label">Skill</label>
						<input type="text" value="" id="editSkillName" class="form-control form-control-sm" readonly>
					</div>
					<div class="form-group col-md-4">
						<label class="control-label">Skill Date <span class="text-danger">*</span></label>
						<input type="date" name="skill_date" id="editSkillDate" class="form-control form-control-sm" value="{{old('skill_date')}}" max="{{ date('Y-m-d') }}">
						@error('skill_date')
							<p class="text-danger">{{ $message }}</p>
						@enderror
					</div>
					<div class="form-group col-md-3 align-self-end" >
						<button type="submit" class="btn btn-primary btn-sm">Update</button>
					</div>
				</div>
			</div>
		  </div>
		</div>
	</form>
  </div>

<script>
	$(function($) {
		$('.profileDelete').on('click', function(e){
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).submit();
                }
            });
        });

		$('.skillEdtiBtn').on('click', function(){
			var name = $(this).data('name');
			var date = $(this).data('skilldate');
			var id = $(this).data('id');
			var url = "{{ route('swapnosarothiprofileskill.update', ':id') }}";
			url = url.replace(':id', id);
			$('#editSkillName').val(name);
			$('#editSkillDate').val(date);
			$('#modalSubmit').attr('action', url);
		});
	});
</script>

@endsection