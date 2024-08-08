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
					<a class="btn btn-sm btn-success float-right" href="{{ route('setup.cepregion.district_manager.view') }}"><i class="fa fa-list"></i> Regional Manager List</a>
				</h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{ route('setup.cepregion.district_manager.update', $editData->id) }}" id="myForm">
				{{ csrf_field() }}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-4">
								<label class="control-label">Manager Name</label>
								<input type="text" name="employee_name" class="form-control form-control-sm" value="{{ $editData->employee_name }}"/>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">PIN</label>
								<input type="text" name="employee_pin" class="form-control form-control-sm" value="{{ $editData->employee_pin }}"/>
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Zone</label>
								<select name="region_id" class="form-control form-control-sm" onclick="getRegionalDivision(this.options[this.selectedIndex].value, $(this));">
									<option value="">Select Zone</option>
									@foreach($regions as $region)
									<option value="{{ $region->id }}" {{ ($editData->region_id == $region->id) ? "selected" : "" }}>{{ $region->region_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="region_area">
							@foreach($editData->district_manager_detail as $detail)
							<div class="form-row region_area_info">
								<div class="form-group col-md-3">
									<label class="control-label">Division Name</label>
									<select name="division_id[]" class="form-control form-control-sm division_id" onclick="getDivisionDistrict(this.options[this.selectedIndex].value, $(this));">
										<option value="">Select Division</option>
										@foreach($divisions as $division)
										<option value="{{ $division->id }}" {{ ($detail->division_id == $division->id) ? "selected" : "" }}>{{ $division->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-md-3">
									<label class="control-label">District Name</label>
									<select name="district_id[]" class="form-control form-control-sm district_id" onclick="getDistrictUpazila(this.options[this.selectedIndex].value, $(this));">
										<option value="">Select District</option>
										@foreach($districts as $district)
										<option value="{{ $district->id }}" {{ ($detail->district_id == $district->id) ? "selected" : "" }}>{{ $district->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-md-3">
									<label class="control-label">Upazila Name</label>
									<select name="upazila_id[]" class="form-control form-control-sm upazila_id">
										<option value="">Select Upazila</option>
										@foreach($upazilas as $upazila)
										<option value="{{ $upazila->id }}" {{ ($detail->upazila_id == $upazila->id) ? "selected" : "" }}>{{ $upazila->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-md-3" style="position: relative; top: 30px;">
									<i class="fa fa-plus btn btn-sm btn-info" onclick="add($(this));"></i>
	                                <i class="fa fa-minus btn btn-sm btn-danger btn-remove d-none" data-type="delete" onclick="remove($(this));"></i>
								</div>
							</div>
							@endforeach
							<div class="extra_region_area_info"></div>
						</div>
					</div>

					<button type="submit" class="btn btn-success btn-sm">Submit</button>
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

    function getRegionalDivision(region_id, item) 
    {
    	var url  = "{{ route('setup.getRegionalDivision') }}";
      	var data = {
    		region_id: region_id
    	};

      	$.get(url, data, function(response) {
            // console.log(response);
            item.closest('.show_module_more_event').find('.division_id').html(response);
        });
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

    function getDistrictUpazila(district_id, item) 
    {
    	var url  = "{{ route('setup.getDistrictUpazila') }}";
      	var data = {
    		district_id: district_id
    	};

      	$.get(url, data, function(response) {
            // console.log(response);
            item.closest('.region_area_info').find('.upazila_id').html(response);
        });
    }

</script>

@endsection