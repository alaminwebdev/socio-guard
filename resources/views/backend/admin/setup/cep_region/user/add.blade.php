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
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
					Add Zone Wise User
					<a class="btn btn-sm btn-success float-right" href="{{ route('user.setup.view') }}"><i class="fa fa-list"></i> Zone Wise User List</a>
				</h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{ route('user.setup.store') }}" id="myForm" autocomplete="off">
				{{ csrf_field() }}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-4">
								<label class="control-label">PIN</label>
								<select name="employee_pin" class="form-control form-control-sm select2 employee_pin" required="" onchange="getUser(this.options[this.selectedIndex].value, $(this));">
									<option value="">Select PIN</option>
									@foreach($employee_pins as $employee_pin)
									<option value="{{ $employee_pin->pin }}">{{ $employee_pin->pin }}</option>
									@endforeach
								</select>
								<input type="hidden" name="user_id" class="form-control form-control-sm user_id" value="" readonly="" required="">
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Name</label>
								<input type="text" name="employee_name" class="form-control form-control-sm employee_name" value="" readonly="" required="">
							</div>
							<div class="form-group col-md-4">
								<label class="control-label">Role</label>
								<input type="text" class="form-control form-control-sm role_name" value="" readonly="">
							</div>
							
						</div>
						<div class="region_area">
							<div id="region_area_info" class="form-row region_area_info">
								<div class="row">
									<div class="form-group col-md-2">
										<label class="control-label">Zone</label>
										<select name="region_id[]"  id="region_id" class="form-control form-control-sm region_id" required="" onchange="getRegionalDivision(this.options[this.selectedIndex].value, $(this));">
											<option value="">Select Zone</option>
											@foreach($regions as $region)
											<option value="{{ $region->id }}">{{ $region->region_name }}</option>
											@endforeach
										</select>
										
									</div>
									<div class="form-group col-md-2">
										<label class="control-label">Division</label>
										<select name="division_id[]" class="form-control form-control-sm division_id" onchange="getRegionalDivisionDistrict(this.options[this.selectedIndex].value, $(this));">
											<option value="">Select Division</option>
										</select>
									</div>
									<div class="form-group col-md-2">
										<label class="control-label">District</label>
										<select name="district_id[]" class="form-control form-control-sm district_id" onchange="getDistrictUpazila(this.options[this.selectedIndex].value, $(this));">
											<option value="">Select District</option>
										</select>
									</div>
									<div class="form-group col-md-2">
										<label class="control-label">Upazila</label>
										<select name="upazila_id[]" class="form-control form-control-sm upazila_id" onchange="getUpazilaUnion(this.options[this.selectedIndex].value, $(this));">
											<option value="">Select Upazila</option>
										</select>
									</div>
									<div class="form-group col-md-2">
										<label class="control-label">Union</label>
										<select name="union_id[]" class="form-control form-control-sm union_id">
											<option value="">Select Union</option>
										</select>
									</div>
									<div class="form-group col-md-2">
										<label class="control-label">Date from</label>
										<input type="date" class="form-control form-control-sm" name="date_from[]" id="">
									</div>
									<div class="form-group col-md-2">
										<label class="control-label">Date to</label>
										<input type="date" class="form-control form-control-sm" name="date_to[]" id="">
									</div>
									<div class="form-group col-md-1" style="margin-top: 22px;">
										<i class="fa fa-plus btn btn-sm btn-info" onclick="add($(this));"></i>
										<i class="fa fa-minus btn btn-sm btn-danger btn-remove d-none" data-type="delete" onclick="remove($(this));"></i>
									</div>
								</div>

								
								
							</div>
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
<script src="{{asset('backend/js/region_area_details_template.js')}}"></script>
<script>

    $(document).ready(function(){
    	$('#myForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	            'employee_name' : {
	                required : true,
	            },
	            'employee_pin' : {
	                required : true,
	            },
	        },
	        messages : {

	        }
	    });
    });

    function add(item)
    {
		//console.log(addNewRegionContainer());
		// document.getElementById("region_area_info").innerHTML+=addNewRegionContainer()
		// return;
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

    function getUser(employee_pin, item)
    {
    	var url  = "{{ route('setup.getUser') }}";
      	var data = {
    		employee_pin: employee_pin
    	}

      	$.get(url, data, function(response) {
            var role_name = '';
            $.each(response.user_role, function(index, value) {
			  	role_name += value.role_details.name+', ';
			});

            item.closest('.show_module_more_event').find('.user_id').val(response.id);
            item.closest('.show_module_more_event').find('.employee_name').val(response.name);
			item.closest('.show_module_more_event').find('.role_name').val(role_name);
        });
    }

    function getRegionalDivision(region_id, item)
    {
    	var url  = "{{ route('setup.getRegionalDivision') }}";
      	var data = {
    		region_id: region_id
    	}
		
      	$.get(url, data, function(response) {
			
            // item.closest('.show_module_more_event').find('.division_id').html(response);
			item.closest('.region_area_info').find('.division_id').html(response);
			//item.nextUntil('#division_id').html(response);
			
        });
    }

    function getRegionalDivisionDistrict(division_id, item)
    {
    	var region_id = item.closest('.region_area_info').find('.region_id').val() //$('.region_id').val();
    	var url  = "{{ route('setup.getRegionalDivisionDistrict') }}";
      	var data = {
    		region_id: region_id,
    		division_id: division_id
    	}

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
    	}

      	$.get(url, data, function(response) {
            // console.log(response);
            item.closest('.region_area_info').find('.upazila_id').html(response);
        });
    }

    function getUpazilaUnion(upazila_id, item)
    {
    	var url  = "{{ route('setup.getUpazilaUnion') }}";
      	var data = {
    		upazila_id: upazila_id
    	}

      	$.get(url, data, function(response) {
            // console.log(response);
            item.closest('.region_area_info').find('.union_id').html(response);
        });
    }

</script>

@endsection