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
				{{-- Table start  --}}

				


				{{-- Table end --}}
				<form method="post" action="" id="filterForm" target="_blank">
				{{ csrf_field() }}
					<div class="form-row">
						<div class="form-group col-md-3">
							<label class="control-label">Report Type</label>
							<select name="report_type" id="report_type" class="report_type form-control form-control-sm" required>
							  <option value="">Select Report Type</option>
							  <option value="{{route('generate.courtcasereport')}}">Courtcase Report</option>
							  {{-- <option value="{{ route('pollisomaj-child-marriage-initiative-report.generate') }}">Child marrige prevention initiative is taken by PS</option>
							  <option value="{{ route('vawc-incident-prevent-initiative-report.generate') }}"> No. of VAWC/VAWG incidents prevented by Pollishomaj</option>
							  <option value="{{ route('pollisomaj-elected-person-report.generate') }}"> District wise percentage of PS members elected in Local Government Election against participation</option> --}}
							  
							</select>
						  </div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-2">
                          <label class="control-label">Zone</label>
                          <select name="region_id" id="region_id" class="region_id form-control form-control-sm select2" required>
                            <option value="">Select Zone</option>
                            @foreach($regions as $region)
                            @if(count(session()->get('userareaaccess.sregions')) ==1)
                            <option value="{{$region->id}}" {{(session()->get('userareaaccess.sregions')[0] == $region->id)?('selected'):''}}>{{$region->region_name}}</option>
                            @else
                            <option value="{{$region->id}}">{{$region->region_name}}</option>
                            @endif
                            @endforeach
                          </select>
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
								<option value="all_district"> All </option>
							</select>
                        </div>
                        <div class="form-group col-md-2">
							<label class="control-label">Upazila</label>
							{{-- <input type="checkbox" id="all_upazila" name="all_upazila" value="1">&nbsp;All --}}
							<select name="upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm select2">
								<option value="">Select Upazila</option>
								<option value="all_upazila"> All </option>
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
							<input type="text" name="from_date" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off">
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
							<input type="text" name="to_date" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off" >
						</div>
						<!-- <div class="form-group col-md-2">
							<label class="control-label">Month <span class="text-danger">*</span></label>
							<select name="month" id="month" class="form-control form-control-sm" required="">
								<option value="">Select Month</option>
                                <option value="01" {{date('m')== '01'?'selected':''}}>January</option>
                                <option value="02" {{date('m')== '02'?'selected':''}}>February</option>
                                <option value="03" {{date('m')== '03'?'selected':''}}>March</option>
                                <option value="04" {{date('m')== '04'?'selected':''}}>April</option>
                                <option value="05" {{date('m')== '05'?'selected':''}}>May</option>
                                <option value="06" {{date('m')== '06'?'selected':''}}>June</option>
                                <option value="07" {{date('m')== '07'?'selected':''}}>July</option>
                                <option value="08" {{date('m')== '08'?'selected':''}}>August</option>
                                <option value="09" {{date('m')== '09'?'selected':''}}>September</option>
                                <option value="10" {{date('m')== '10'?'selected':''}}>October</option>
                                <option value="11" {{date('m')== '11'?'selected':''}}>November</option>
                                <option value="12" {{date('m')== '12'?'selected':''}}>December</option>
							</select>
						</div> -->
						{{-- <br/>
						<div class="form-group col-sm-2">
							<label class="control-label"> Gender </label>
							<select name="gender_id" id="gender_id" class="gender_id form-control form-control-sm">
								<option value="0">Select Gender</option>
								@foreach($genders as $cat)
								<option value="{{$cat->id}}">{{$cat->name}}</option>
								@endforeach
							</select>
						</div> --}}
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
          var html = '<option value="">Select District</option><option value="all_district"> All </option>';
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
				url : "{{route('default.get-upazila')}}",
				type : "GET",
				data : {district_id:district_id},
				success:function(data){
					var html = '<option value="">Select Upazila</option><option value="all_upazila"> All </option>';
					$.each(data[0],function(key,v){
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