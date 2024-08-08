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
				<h5>
					Update Regional Manager
					<a class="btn btn-sm btn-success float-right" href="{{ route('user.region.region_manager.view') }}"><i class="fa fa-list"></i> Regional Manager List</a>
				</h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{ route('user.region.region_manager.update', $editData->id) }}" id="myForm">
				{{ csrf_field() }}
				<div class="card-body">
					<div class="form-row">
						<div class="form-group col-md-4">
							<label class="control-label">Manager Name</label>
							<input type="text" name="name" class="form-control form-control-sm" value="{{ $editData->name }}" autocomplete="off">
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">PIN</label>
							<input type="text" name="pin" class="form-control form-control-sm" value="{{ $editData->pin }}">
						</div>
						<div class="form-group col-md-4">
							<label class="control-label">Zone</label>
							<select name="region_id" class="form-control form-control-sm">
								<option value="">Select Zone</option>
								@foreach($regions as $region)
								<option value="{{ $region->id }}" {{ ($editData->region->id == $region->id) ? "selected" : "" }}>{{ $region->region_name }}</option>
								@endforeach
							</select>
						</div>
					</div>
						
					<button type="submit" class="btn btn-success btn-sm">Update</button>
					<button type="reset" class="btn btn-danger btn-sm">Reset</button>
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
	            'name' : {
	                required : true,
	            },
	        },
	        messages : {

	        }
	    });
    });

    function add(item) 
    {
        var extra_region_area_info = item.closest('.region_area_info').clone();

        extra_region_area_info.find('.btn-remove').removeClass('d-none');
        extra_region_area_info.find('input, select').each(function() {
            $(this).val('');
        });

        item.closest('.region_area').find('.extra_region_area_info').append(extra_region_area_info);
    }

    function remove(item) 
    {
        item.closest('.region_area_info').remove();
    }

    function getDivisionDistrict(division_id, item) 
    {
    	var url  = "{{ route('setup.getDivisionDistrict') }}";
      	var data = {
    		division_id: division_id
    	};

      	$.get(url, data, function(response) {
            // console.log(response);
            item.closest('.region_area_info').find('.district_id').html(response);
        });
    }

</script>

@endsection