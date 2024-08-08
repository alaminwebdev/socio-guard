@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">SELP MIS Report</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">SELP MIS Report</li>
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
							<label class="control-label">Report Type</label>
							<select name="report_type" id="report_type" class="report_type form-control form-control-sm" required>
							  <option value="">Select Report Type</option>
							  <option value="{{route('selp-all-incident-report.generate')}}">Complain ID wise Details</option>
							  <option value="{{route('selp-mis-report.generate')}}">No. of reported VAWC/VAWG incidents</option>
							  <option value="{{ route('selp-area-wise-age-report.generate') }}">Age range of marriage among survivor groups</option>
							  <option value="{{ route('selp-age-wise-violence-report.generate') }}">Area wise survivor age group and type of violence</option>
							  <option value="{{ route('selp-education-wise-violence-report.generate') }}">Perpetrators Education wise Report With Violence</option>
							  <option value="{{ route('selp-occupation-wise-violence-report.generate') }}">Perpetrators Occupational wise Report With Violence</option>
							  <option value="{{ route('selp-gender-wise-violence-report.generate') }}">Gender Wise Dispute Type Report</option>
							  <option value="{{ route('selp-referrel-report.generate') }}">Referrel Report</option>
							  <option value="{{ route('selp-place-wise-violence-report.generate') }}">Place Wise Report</option>
							  {{-- <option value="{{ route('selp-adr-report.generate') }}">ADR Report</option> --}}
							  <option value="{{ route('selp-adr-initiatives-report.generate') }}">Initiatives of ADR </option>
							  <option value="{{ route('selp-adr-completed-report.generate') }}">ADR Completed</option>
							  {{-- <option value="{{ route('selp-adr-completed-with-area-report.generate') }}">ADR Completed With Area</option> --}}
							  {{-- <option value="{{ route('generate.courtcasereport') }}">Court Case Report</option> --}}
							  <option value="{{ route('selp-case-status-wise-report.generate') }}">Court Case Status Wise Report</option>
							  <option value="{{ route('selp-courtcase-completed-report.generate') }}">Court Case Completed</option>
							  <option value="{{ route('selp.adr.completed.day.count.generate') }}">ADR Completed with decesion Total Day Count</option>
							  <option value="{{ route('selp.case.file.judgement.day.count') }}">Case field to Judgement Total Day Count</option>
							</select>
						  </div>
					</div>
					<div class="form-row">
						{{-- <div class="form-group col-md-2">
                          <label class="control-label">Zone</label>
                          <select name="region_id" id="region_id" class="region_id form-control form-control-sm select2" required>
                            <option value="">Select Zone</option>

							@if($auth_user->user_role[0]['role_id'] == 1)
								<option value="all_zone"> All </option>
							@endif
							
                            @foreach($regions as $region)
                            @if(count(session()->get('userareaaccess.sregions')) ==1)
                            <option value="{{$region->id}}" {{(session()->get('userareaaccess.sregions')[0] == $region->id)?('selected'):''}}>{{$region->region_name}}</option>
                            @else
                            <option value="{{$region->id}}">{{$region->region_name}}</option>
                            @endif
                            @endforeach
                          </select>
                        </div> --}}
						<div class="form-group col-md-2">
							
							<label class="control-label">Zone </label>
							
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
          var html = `<option value="">Select District</option> @if($auth_user->user_role[0]['role_id'] != 5)
									<option value="all_district"> All </option>
								@endif `;
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

@endsection