@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Regional Manager</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Regional Manager</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Regional Manager List
					<a class="btn btn-sm btn-success float-right" href="{{ route('user.region.region_manager.add') }}"><i class="fa fa-plus-circle"></i> Add Regional Manager</a>
				</h5>
			</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
					<thead>
						<tr>
							<th>Sl.</th>
							<th>Manager Name</th>
							<th>PIN</th>
							<th>Zone</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($regional_managers as $key => $regional_manager)
						<tr class="tr-row">
							<td>{{ ++$key }}</td>
							<td>{{ $regional_manager->name }}</td>
							<td>{{ $regional_manager->pin }}</td>
							<td>{{ $regional_manager->region->region_name }}</td>
							<td><input type="checkbox" {{ ($regional_manager->status == 1) ? 'checked' : '' }} data-toggle="toggle" data-on="Active" data-off="Inactive" onchange="changeStatus($(this), {{ $regional_manager->id }});"></td>
							<td>
								<a class="btn btn-sm btn-success" title="Edit" href="{{ route('user.region.region_manager.edit', $regional_manager->id) }}"><i class="fa fa-edit"></i></a>
								<a class="btn btn-sm btn-danger" title="Delete" href="#" onclick="deleteManager({{ $regional_manager->id }}, event, $(this))"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
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

    	var url  = "{{ route('changeRegionManagerStatus') }}";
    	var data = {
    		id: id,
    		status: status
    	}

    	$.get(url, data, function(response) {
    		console.log(response);
    	});
    }
	
	function deleteManager(id, e, item) 
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
        		var url  = "{{ route('user.region.region_manager.delete', '') }}"+"/"+id;
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