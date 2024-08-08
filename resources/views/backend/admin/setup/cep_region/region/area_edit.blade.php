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
				<h5>
					Update Zone Area
					<a class="btn btn-sm btn-success float-right" href="{{ route('setup.cepregion.region.areaView') }}"><i class="fa fa-list"></i> Zone Area List</a>
				</h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{ route('setup.cepregion.region.areaUpdate', $editData->id) }}" id="myForm">
				{{ csrf_field() }}
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-4">
								<label class="control-label">Zone Name</label>
								<select name="region_id" class="form-control form-control-sm">
									<option value="">Select Zone</option>
									@foreach($regions as $region)
									<option value="{{ $region->id }}" {{ ($editData->region->id == $region->id) ? "selected" : "" }}>{{ $region->region_name }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="region_area">
							@foreach($editData->region_area_detail as $key => $area)
							<div class="form-row region_area_info">
								<div class="form-group col-md-3">
									<label class="control-label">Division Name</label>
									<select name="division_id[]" class="form-control form-control-sm" required="" onclick="getDivisionDistrict(this.options[this.selectedIndex].value, $(this));">
										<option value="">Select Division</option>
										@foreach($divisions as $division)
										<option value="{{ $division->id }}" {{ ($area->regional_division['id'] == $division->id) ? "selected" : "" }}>{{ $division->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-md-3">
									<label class="control-label">District Name</label>
									<select name="district_id[]" el_type="" class="form-control form-control-sm district_id" required="">
										<option value="">Select District</option>
										@foreach($districts as $district)
										<option value="{{ $district->id }}" {{ ($area->regional_district['id'] == $district->id) ? "selected" : "" }}>{{ $district->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-md-2">
									<label class="control-label">Date from</label>
									<input type="date" class="form-control form-control-sm district_id"  name="date_from[]" value="{{$editData->region_area_detail[$key]->date_from}}" id="">
								</div>
								<div class="form-group col-md-2">
									<label class="control-label">Date to</label>
									<input type="date" class="form-control form-control-sm district_id"  name="date_to[]" value="{{$editData->region_area_detail[$key]->date_to}}" id="">
								</div>
								<div class="form-group col-md-2" style="position: relative; top: 30px;">
									<i class="fa fa-plus btn btn-sm btn-info" onclick="add($(this));"></i>
	                                @if($key != 0)
	                                <i class="fa fa-minus btn btn-sm btn-danger btn-remove" data-type="delete" onclick="remove($(this));"></i>
	                                @endif
								</div>
							</div>
							@endforeach
							<div class="extra_region_area_info"></div>
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


<script>
	$(document).ready(function(){
		addEventListener('change',(e)=>{
			if(e.target.hasAttribute('el_type')){
				$.ajax({
					url : "{{route('setup.cepregion.region.checkactivedistrict')}}",
					type : "GET",
					data : {district_id:e.target.value},
					success:function(data){
						if(data.status==200){
							Swal.fire({
								icon: 'error',
								title: 'This district is already in use',
								showConfirmButton: true,
								
								html:'<a href="'+data.url+'" target="_blank">Click</a> ' +
									'to inactive this district',
								
							})
							if(e.target.parentNode.parentNode.parentNode.getAttribute("class")=="extra_region_area_info"){
								//console.log(e.target.parentNode.parentNode.getAttribute("class"))
								e.target.parentNode.parentNode.remove();
							}else{
								window.location.reload()
							}
							
						}
					}
				});
			}
		})
	})
</script>

@endsection