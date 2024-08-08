@extends('backend.layouts.app')
@section('content')
<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Activity</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Activity</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Activity Data Entry List
					<a target="_blank" class="btn btn-sm btn-success float-right" href="{{url('activity/add')}}?addnew=true""><i class="fa fa-plus-circle"></i> Add New Activity Data</a>
				</h5>
			</div>
			<div class="card-body">

				{{-- Search form start --}}
				<form method="get" action="" id="pollisomaj-filterForm">
					<div class="form-row">
						<div class="form-group col-md-3">
							<label class="control-label">Zones</label>
							{{-- {{ dd(session()->get('userareaaccess.sregions')) }} --}}
							@if(count(session()->get('userareaaccess.sregions')) ==1)
							<select name="region_id" id="region_id" class="region_id form-control form-control-sm select2" required="" disabled="">
								@else
								<select name="region_id" id="region_id" class="region_id form-control form-control-sm select2" required="">
									@endif
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
							<div class="form-group col-md-3">
								<label class="control-label">Division</label>
								<select name="division_id" id="division_id" class="division_id form-control form-control-sm">
									<option value="">Select Division</option>
								</select>
							</div>
							<div class="form-group col-md-2">
								<label class="control-label">District</label>
								<select name="district_id" id="district_id" class="district_id form-control form-control-sm">
									<option value="">Select District</option>
								</select>
							</div>
							<div class="form-group col-md-2">
								<label class="control-label">Upazila</label>
								<select name="upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
									<option value="">Select Upazila</option>
								</select>
							</div>
							<div class="form-group col-md-2">
								<label class="control-label">Union</label>
								<select name="union_id" id="union_id" class="union_id form-control form-control-sm">
									<option value="">Select Union</option>
								</select>
							</div>
							{{-- <div class="form-group col-sm-2">
								<label class="control-label" style="font-size: 13px;">Violence/Incident Period</label>
								<input type="text" name="from_date" id="from_date" class="form-control form-control-sm singledatepicker" placeholder="From Date" autocomplete="off">
							</div>
							<div class="form-group col-sm-2" style="padding-top: 8px;">
								<label class="control-label"></label>
								<input type="text" name="to_date" id="to_date" class="form-control form-control-sm singledatepicker" placeholder="To Date" autocomplete="off">
							</div>
							<div class="form-group col-sm-2">
								<label class="control-label">Violence Type</label>
								<select name="violence_category_id" id="violence_category_id" class="violence_category_id form-control form-control-sm">
									<option value="">Select Type</option>
									@foreach($violence_categories as $cat)
									<option value="{{$cat->id}}">{{$cat->name}}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-sm-2">
								<label class="control-label">Violence Sub Type</label>
								<select name="violence_sub_category_id" id="violence_sub_category_id" class="violence_sub_category_id form-control form-control-sm">
									<option value="">Select Sub Type</option>
								</select>
							</div>
							<div class="form-group col-sm-2">
								<label class="control-label">Violence Name</label>
								<select name="violence_name_id" id="violence_name_id" class="violence_name_id form-control form-control-sm">
									<option value="">Select Name</option>
								</select>
							</div> --}}
							{{-- <div class="form-group col-sm-2">
								<label class="control-label">Complain ID</label>
								<input type="text" name="survivor_id" id="survivor_id" class="survivor_id form-control form-control-sm" placeholder="Write Incident ID">
							</div> --}}
							<div class="form-group col-sm-2" style="margin-top: -23px;">
								<!-- <a class="btn btn-sm btn-primary" type="submit" style="margin-top: 29px; color: white">Search</a> -->
								<button type="submit" class="btn btn-success btn-sm"  style="margin-top: 29px; color: white">Search</button>
							</div>
						</div>
					</form>
				{{-- Search form end --}}
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="pollisomaj-data-table">
					<thead>
						<tr>
							<th>Sl.</th>
                            <th>selp_activity_ref</th>
                            <th>employee_pin</th>
							<th>employee_name</th>
							<th>Reporting Date</th>
							<th>Action</th>
						</tr>
					</thead>
                    <tbody>
                        @foreach($activity_data as $key => $data)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{ $data->selp_activity_ref }}</td>
                            <td>{{ $data->employee_pin }}</td>
                            <td>{{ $data->employee_name }}</td>
                            <td>{{ $data->reporting_data }}</td>
                            <td>
                                <a href="{{ route('activity.data.edit', $data->selp_activity_ref) }}" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                                <a href="#" target="__blank" class="btn btn-sm btn-danger" title="PDF"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>
                                <a href="#" target="__blank" class="btn btn-sm btn-success" title="Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
					
				</table>
			</div>
		</div>
	</div>
</div>

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
					var html = '<option value="">Select District</option>';
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
					var html = '<option value="">Select Upazila</option>';
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
		$(document).on('change','#upazila_id',function(){
			var upazila_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-union')}}",
				type : "GET",
				data : {upazila_id:upazila_id},
				success:function(data){
					var html = '<option value="">Select Union</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('#union_id').html(html);
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$('#region_id').trigger('change');
	});
</script>
@endsection


