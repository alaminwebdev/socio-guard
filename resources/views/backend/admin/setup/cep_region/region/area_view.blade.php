@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Zone Area</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Zone Area</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Zone Area List
					<a class="btn btn-sm btn-success float-right" href="{{ route('setup.cepregion.region.areaAdd') }}"><i class="fa fa-plus-circle"></i> Add Zone Area</a>
				</h5>
			</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
					<thead>
						<tr>
							<th>Sl.</th>
							<th>Zone Area</th>
							<th>Division</th>
							<th>District</th>
							<th>Date from</th>
							<th>Date to</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($region_areas as $key => $region_area)
							<?php $count = count($region_area->region_area_detail); ?>
							@foreach($region_area->region_area_detail as $key1 => $area_detail)
								@if($key1 == 0)
                                    <tr class="tr-row">
                                        <td rowspan="{{ $count }}">{{ $key++ }}</td>
                                        <td rowspan="{{ $count }}">{{ @$region_area->region->region_name }}</td>
                                        <td>{{ @$area_detail->regional_division['name'] }}</td>
                                        <td>{{ @$area_detail->regional_district['name'] }}</td>
										<td>{{ date_format(date_create($area_detail->date_from),'d-M-Y') }}</td>
										<td>{{ $area_detail->date_to==null ? "--" : date_format(date_create($area_detail->date_to),'d-M-Y')}}</td>
                                        <td><input type="checkbox" {{ ($area_detail->status == 1) ? 'checked' : '' }} data-toggle="toggle" data-on="Active" data-off="Inactive" data-size="small" onchange="changeStatus($(this), {{ $area_detail->id }});"></td>
										<td rowspan="{{ $count }}">
											<a class="btn btn-sm btn-success" title="Edit" href="{{ route('setup.cepregion.region.areaEdit', $region_area->id) }}"><i class="fa fa-edit"></i></a>
											<a class="btn btn-sm btn-danger" title="Delete" href="#" onclick="deleteManager({{ $region_area->id }}, event, $(this))"><i class="fa fa-trash"></i></a>
										</td>
                                    </tr>
                                @else
                                    <tr class="tr-row">
                                        <td>{{ @$area_detail->regional_division['name'] }}</td>
										<td style="border-right: 1px solid #dee2e6;">{{ @$area_detail->regional_district['name'] }}</td>
										<td>{{ date_format(date_create($area_detail->date_from),'d-M-Y') }}</td>
										<td>{{ $area_detail->date_to==null ? "--" : date_format(date_create($area_detail->date_to),'d-M-Y')}}</td>
                                        <td><input type="checkbox" {{ ($area_detail->status == 1 && $area_detail->deleted_at==null) ? 'checked' : '' }} data-toggle="toggle" data-on="Active" data-off="Inactive" data-size="small" onchange="changeStatus($(this), {{ $area_detail->id }});"></td>
                                    </tr>
                                @endif
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

    	var url  = "{{ route('changeRegionAreaStatus') }}";
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
        		var url  = "{{ route('setup.cepregion.region.areaDelete', '') }}"+"/"+id;
        		// console.log(url);

		      	$.get(url, function(response) {
		      		if (response == 'deleted')
		      		{
		      			swal("Deleted!", "Your item has been deleted!", "success");
		      			item.closest('tbody').find('.tr-row').remove();
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