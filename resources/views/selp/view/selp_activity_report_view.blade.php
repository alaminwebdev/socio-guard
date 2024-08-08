@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">SELP Activity Report</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">SELP Activity Report</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Select Filter Criteria</h5>
			</div>
			<div class="card-body">
				<form method="post" action="" id="filterForm" target="_blank">
				{{ csrf_field() }}
					<div class="form-row">
						<div class="form-group col-md-3">
							<label class="control-label">Report Type <span class="text-danger">*</span></label>
							<select name="report_type" id="report_type" class="report_type form-control form-control-sm" required>
							  <option value="">Select Report Type</option>
							  {{-- <option id="all_data_report" value="{{route('activity-mis-report-excel.view')}}">Activity Data Entry Details One</option> --}}
							  <option id="all_format_report" value="{{route('activity-mis-report.all')}}">Activity Wise Report</option>
							</select>
						</div>
						<div class="form-group col-md-3 category_type" style="display: none">
							<label class="control-label">Category Type</label>
							<select name="category_type" id="category_type" class="form-control form-control-sm">
							  <option value="">Select Category Type</option>
							  <option value="">All</option>
							  <option value="1">Meeting/Workshop</option>
							  <option value="2">Training/Orientation</option>
							  <option value="3">Community Level Awareness</option>
							  <option value="4">Campaign and Day Observation</option>
							  <option value="5">PT Show</option>
							  <option value="6">PT Production Workshop</option>
							</select>
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-2">
							<label class="control-label">Zone <span class="text-danger">*</span></label>
							@if(count(session()->get('userareaaccess.sregions'))>0)
								<select name="region_id" id="region_id" class="region_id form-control form-control-sm select2" required="">
								<option value="">Select zone</option>
								@foreach($regions as $key=>$region)
									
									@if(in_array($region->id,session()->get('userareaaccess.sregions')) )
									<option value="{{$region->id}}">{{$region->region_name}}</option>
									@endif
								@endforeach
								</select>
							@else
								<select name="region_id" id="region_id" class="region_id form-control form-control-sm select2" required="">
									<option value="">Select Zone</option>
									@if($auth_user->user_role[0]['role_id'] != 4 && $auth_user->user_role[0]['role_id'] != 5)
										<option value="all_zone"> All </option>
									@endif
									@foreach($regions as $region)
										<option value="{{$region->id}}">{{$region->region_name}}</option>
									@endforeach
								</select>  
							@endif
						</div>
                        <div class="form-group col-md-2">
                          <label class="control-label">Division</label>
                          <select name="division_id" id="division_id" class="division_id form-control form-control-sm select2">
                            <option value="">Select Division</option>
							
						</select>
                        </div>
                        <div class="form-group col-md-2">
							<label class="control-label">District</label>
							<select name="district_id" id="district_id" class="district_id form-control form-control-sm select2">
								<option value="">Select District</option>
								
							</select>
                        </div>
                        <div class="form-group col-md-2">
							<label class="control-label">Upazila</label>
							{{-- <input type="checkbox" id="all_upazila" name="all_upazila" value="1">&nbsp;All --}}
							<select name="upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm select2">
								<option value="">Select Upazila</option>
								
							</select>
						</div>
						<div class="form-group col-md-2">
							<label class="control-label">From Date <span class="text-danger">*</span></label>
							<!-- <select name="from_year" id="from_year" class="form-control form-control-sm select2" required="">
								<option value="">Select From Year</option>
								@php
                                    $last_year = date('Y');
                                    for($i = $last_year; $i >= 1990; $i--){
                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                    }
                                @endphp
							</select> -->
							<input type="text" name="from_date" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off" required>
						</div>
						<div class="form-group col-md-2">
							<label class="control-label">To Date <span class="text-danger">*</span></label>
							<!-- <select name="to_year" id="to_year" class="form-control form-control-sm select2" required="">
								<option value="">Select To Year</option>
								@php
                                    $last_year = date('Y');
                                    for($i = $last_year; $i >= 1990; $i--){
                                        echo '<option value="'.$i.'">'.$i.'</option>';
                                    }
                                @endphp
							</select> -->
							<input type="text" name="to_date" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off" required>
						</div>
						<div class="form-group col-sm-3">
							<label class="control-label">Document Type</label>
							<select name="format_download" id="format_download" class="format_download form-control form-control-sm" required>
								<option value="">Select Document Type</option>
								<option value="1"> PDF </option>
								<option value="2"> Excel </option>
							</select>
						</div>
						<div class="form-group col-sm-2">
							<!-- <a class="btn btn-sm btn-primary" type="submit" style="margin-top: 29px; color: white">Search</a> -->
							<button type="submit" class="btn btn-success btn-sm"  style="margin-top: 21px; color: white">Search</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div id="route_container">

</div>
<script type="text/javascript">
	$(document).on('change','#report_type',function(){
        var report_type = $(this).val();
		document.getElementById('filterForm').setAttribute('action',`${report_type}`)
    });
</script>

<script type="text/javascript">
	$('[name^="all_district"]').change(function(){
    if($(this).is(":checked"))
	    {
	        $(this).next("select").attr("disabled",true);
	    }
	    else
	    {
	        $(this).next("select").attr("disabled",false);
	    }
	});
</script>

<script type="text/javascript">
  $(function(){
    $(document).on('change','#region_id',function(){
      var region_id = $(this).val();
      $.ajax({
        url : "{{route('default.get-division')}}",
        type : "GET",
        data : {region_id:region_id},
        success:function(data){
			var html = '<option value="">Select Division</option>';
          $.each(data,function(key,v){
            html +='<option value="'+v.division_id+'">'+v.regional_division.name+'</option>';
          });
		  $('#division_id').html(html);
        }
      });
    });
  });
</script>

<script type="text/javascript">
  $(function(){
    $(document).on('change','#division_id',function(){
      var region_id = $('#region_id').val();
      var division_id = $(this).val();
      $.ajax({
        url : "{{route('default.get-region-district')}}",
        type : "GET",
        data : {region_id:region_id,division_id:division_id},
        success:function(data){
			var html = `<option value="">Select District</option> @if( $auth_user->user_role[0]['role_id'] != 5)
									<option value="all_district"> All </option>
								@endif`;
          $.each(data,function(key,v){
            html +='<option value="'+v.district_id+'">'+v.regional_district.name+'</option>';
          });
		  $('#district_id').html(html);
        }
      });
    });
  });
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('change','#district_id',function(){
			var district_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-region-upazila')}}",
				type : "GET",
				data : {district_id:district_id},
				success:function(data){
					var html = `<option value="">Select District</option> @if($auth_user->user_role[0]['role_id'] != 5)
									<option value="all_upazila"> All </option>
								@endif `;
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('#upazila_id').html(html);
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$(".violence_sub_category_id").select2({
		    placeholder: "Select a option"
		});
	})

	$(function(){
		$(".violence_name_id").select2({
		    placeholder: "Select a option"
		});
	})
</script>

<script type="text/javascript">
	$('[name^="platform_all"]').change(function(){
    if($(this).is(":checked"))
	    {
	        $(this).next("select").attr("disabled",true);
	    }
	    else
	    {
	        $(this).next("select").attr("disabled",false);
	    }
	});
</script>

<script type="text/javascript">
	$(document).on('change','.platform_id',function(){
        var platform_id = $(this).val();
        if(platform_id != '0'){
        	$("#platform_all").attr('disabled', true);
        }else{
        	$("#platform_all").attr('disabled', false);
        }
    });
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('change','.violence_category_id',function(){
			var violence_category_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-violence-sub-category')}}",
				type : "GET",
				data : {violence_category_id:violence_category_id},
				success:function(data){
					var html = '<option value="">Select Violence Sub Category</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('.violence_sub_category_id').html(html);
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('change','.violence_sub_category_id',function(){
			var violence_sub_category_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-violence-name')}}",
				type : "GET",
				data : {violence_sub_category_id:violence_sub_category_id},
				success:function(data){
					var html = '<option value="">Select Violence Name</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('.violence_name_id').html(html);
				}
			});
		});
	});
</script>


<script>
	$(document).ready(function() {
		$("#report_type").change(function() {
		var report_type = $(this).children(":selected").attr("id");

		  if (report_type == "all_format_report") {
			$(".category_type").show();
		  } else {
			$(".category_type").hide();
		  }
		});
	}); 
</script>

@endsection