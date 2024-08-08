@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Zone Wise User</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Zone Wise User</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            $(function () {
                $.notify("{{ $error }}", {globalPosition: 'bottom right', className: 'error'});
            });
        </script>
    @endforeach
@endif
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
					Zone Wise User List
					<a class="btn btn-sm btn-success float-right" href="{{ route('user.setup.add') }}"><i class="fa fa-plus-circle"></i> Add Zone Wise User</a>
				</h5>
			</div>
			<div class="card-body" style="width:100%;overflow-x:scroll">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable-bkp">
					<thead>
						<tr>
							<th rowspan="2">Sl.</th>
							<th rowspan="2">Zone</th>
							<th rowspan="2">Role</th>
							<th rowspan="2">name</th>
							<th colspan="6">
								<span style="position: relative; left: 200px;">Address</span>
							</th>
							<th rowspan="2">Date From</th>
							<th rowspan="2">Date To</th>
							<th rowspan="2">Status</th>
							<th rowspan="2">Action</th>
						</tr>
						<tr>
							<th>Division</th>
							<th>District</th>
							<th>Upazila</th>
							<th>Union</th>
							<th>Date from</th>
							<th>Date to</th>
						</tr>
					</thead>
					<tbody>

						@php $count = 0; @endphp
						@foreach($users as $key => $user_region)
						    @php
								$counter=0;
								$printDate=false;
								$userId=0;
							@endphp
							@foreach($user_region['region'] as $key1 => $user)
							    
							    @php
								   if(isset($user['user'])){
										if($userId!=$user['user']['id']){
											$printDate=true;
											$userId=$user['user']['id'];
											$counter=0;
										}else{
											// $counter++;
											//$printDate=false;
										}
								   }
									
								@endphp
								<tr class="tr-row">
									@if ($loop->first)
										<td rowspan="{{ count($user_region['region']) }}">{{ ++$count }}</td>
										<td rowspan="{{ count($user_region['region']) }}">{{ $user['region_name'] }}</td>
									@endif
									@if(isset($user['role_rs']))
										@if(!empty($user['role_rs']))
											<td rowspan="{{ $user['role_rs'] }}">
												@foreach($user['user']['user_role'] as $key2 => $role)
													{{ $role['role_details']['name'] }},
												@endforeach
											</td>
										@else
											<td>
												@foreach($user['user']['user_role'] as $key2 => $role)
													{{ $role['role_details']['name'] }},
												@endforeach
											</td>
										@endif
									@endif
									@if(isset($user['role_rs']))
										@if(!empty($user['role_rs']))
											<td rowspan="{{ $user['role_rs'] }}">{{ $user['employee_name'] }}</td>
										@else
											<td>{{ $user['employee_name'] }}</td>
										@endif
									@endif
									<td>{{ $user['division'] }}</td>
									<td>{{ $user['district'] }}</td>
									<td>{{ $user['upazila'] }}</td>
									<td>{{ $user['union'] }}</td>
									<td>{{date_format(date_create($user['area_date_from']),'d-M-Y')}}</td>
									<td>{{$user['area_date_to']==null ? '--' : date_format(date_create($user['area_date_to']),'d-M-Y')}}</td>
									@if(!empty($user['role_rs']))
										@if ($counter==0 || $printDate)
											<td rowspan="{{ $user['role_rs'] }}">
												{{date_format(date_create($user['date_from']),'d-M-Y')}}
											</td>
										@endif
										
									@else
										@if ($counter==0 || $printDate)
											<td  rowspan="{{ $user['role_rs'] }}">
												{{date_format(date_create($user['date_from']),'d-M-Y')}}
											</td>
										@endif	
									@endif

									
									@if(!empty($user['role_rs']))
									    
										@if ($counter==0 || $printDate)
											<td rowspan="{{ $user['role_rs'] }}">
												{{$user['date_to']==null ? '--' : date_format(date_create($user['date_to']),'d-M-Y')}}
											</td>
										@endif
									@else
										@if ($counter==0 || $printDate)
											<td  rowspan="{{ $user['role_rs'] }}"">
												{{$user['date_to']==null ? '--' : date_format(date_create($user['date_to']),'d-M-Y')}}
											</td>
										@endif
									@endif
									@if(isset($user['role_rs']))
										@if(!empty($user['role_rs']))
											<td rowspan="{{ $user['role_rs'] }}">
												<input type="checkbox" {{ ($user['status'] == 1) ? 'checked' : '' }} data-toggle="toggle" data-on="Active" data-off="Inactive" data-size="small" onchange="changeStatus($(this), {{ $user['id'] }});">
											</td>
										@else
											<td>
												<input type="checkbox" {{ ($user['status'] == 1) ? 'checked' : '' }} data-toggle="toggle" data-on="Active" data-off="Inactive" data-size="small" onchange="changeStatus($(this), {{ $user['id'] }});">
											</td>
										@endif
									@endif
									
									@if(isset($user['role_rs']))
										@if(!empty($user['role_rs']))
											<td rowspan="{{ $user['role_rs'] }}">
												<a class="btn btn-sm btn-success" title="Edit" href="{{ route('user.setup.edit', ['user_id'=>$user['user']['id'],'region_id'=>$user['region_id']]) }}"><i class="fa fa-edit"></i></a>
												<a class="btn btn-sm btn-danger" title="Delete" href="#" onclick="remove({{ $user['id'] }}, event, $(this))"><i class="fa fa-trash"></i></a>
											</td>
										@else
											<td>
												<a class="btn btn-sm btn-success" title="Edit" href="{{ route('user.setup.edit',  ['user_id'=>$user['user']['id'],'region_id'=>$user['region_id']]) }}"><i class="fa fa-edit"></i></a>
												<a class="btn btn-sm btn-danger" title="Delete" href="#" onclick="remove({{ $user['id'] }}, event, $(this))"><i class="fa fa-trash"></i></a>
											</td>
										@endif
									@endif
									
								</tr>
								@php
									$counter++
								@endphp
							@endforeach
						@endforeach

					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>

	function changeStatus(item, id)
    {
    	var status = 0;
    	if (item.is(':checked')) {
    		status = 1;
    	}

    	var url  = "{{ route('changeSetupUserStatus') }}";
    	var data = {
    		id: id,
    		status: status
    	}

    	$.get(url, data, function(response) {
    		console.log(response);
    	});
    }

	function remove(id, e, item)
	{
		e.preventDefault();
		swal({
	        title: "Are you sure?",
	        text: "You will not be able to recover this item!",
	        type: "warning",
	        showCancelButton: true,
	        confirmButtonClass: 'btn-danger',
	        confirmButtonText: 'Yes, delete it!',
	        cancelButtonText: "No, cancel plx!",
	        closeOnConfirm: false,
	        closeOnCancel: false
        },
     	function (isConfirm) {
        	if (isConfirm)
        	{
        		var url  = "{{ route('user.setup.delete', '') }}"+"/"+id;
        		// console.log(url);

		      	$.get(url, function(response) {
		      		if (response == 'deleted')
		      		{
		      			swal("Deleted!", "Your item has been deleted!", "success");
		      			item.closest('.tr-row').remove();
		      		}
		      		else
		      		{
		      			swal("Ops!", "Something went wrong. Your item hasn't been deleted!", "error");
		      		}
		        });
            }
            else
            {
                swal("Cancelled", "Your item is safe :)", "error");
            }
	    });
	}

</script>

@endsection