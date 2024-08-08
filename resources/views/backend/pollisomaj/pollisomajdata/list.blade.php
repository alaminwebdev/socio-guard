@extends('backend.layouts.app')
@section('content')
<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Village</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Pollisomaj</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Community Mobilisation Data Entry List
					<a target="_blank" class="btn btn-sm btn-success float-right" href="{{url('incident/pollisomaj/data/add')}}?addnew=true""><i class="fa fa-plus-circle"></i> Add New Pollisomaj Data</a>
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
					<thead  >
						<tr>
							<th>Sl.</th>
                            <th>Pollisomaj Data Ref</th>
                            <th>Pollisomaj name</th>
                           
							{{-- <th>District</th>
							<th>Upazila</th>
							<th>Union</th>---}}
							<th>Status</th>
							<th>Posting Date</th>
							<th>Action</th>
						</tr>
					</thead>
					
				</table>
			</div>
		</div>
	</div>
</div>




<script type="text/javascript">
	$(document).ready(function(){
		var dTable = $('#pollisomaj-data-table').DataTable({
			processing: true,
			serverSide: true,
			// paging: true,
   //          pagingType: "full_numbers",
   //          language:{
   //          	oPaginate: {
   //          		sNext: '<i class="fa fa-forward"></i>',
   //          		sPrevious: '<i class="fa fa-backward"></i>',
   //          		sFirst: '<i class="fa fa-step-backward"></i>',
   //          		sLast: '<i class="fa fa-step-forward"></i>'
   //          	}
   //          },
            ajax: {
            	url:'{{ route("incident.getPollisomajdataDatatable") }}',
            	data: function (d) {
            		console.log(d);
            		d._token      				= "{{ csrf_token() }}";
            		d.region_id 				= $('select[name=region_id]').val();
            		d.division_id 				= $('select[name=division_id]').val();
            		d.district_id 				= $('select[name=district_id]').val();
            		d.upazila_id  				= $('select[name=upazila_id]').val();
            		d.union_id    				= $('select[name=union_id]').val();
            		d.violence_category_id 		= $('select[name=violence_category_id]').val();
            		d.violence_sub_category_id 	= $('select[name=violence_sub_category_id]').val();
            		d.violence_name_id 			= $('select[name=violence_name_id]').val();
            		d.survivor_id 				= $('input[name=survivor_id]').val();
            		d.from_date   				= $('input[name=from_date]').val();
            		d.to_date     				= $('input[name=to_date]').val();
            	}
            },
            columns: [
            {data: 'DT_RowIndex', name: 'pollisomaj_data.id'},
            {data: 'pollisomaj_data_ref', name: 'pollisomaj_data.pollisomaj_data_ref'},
			{data: 'pollisomaj_name', name: 'pollisomaj_setup.pollisomaj_name'},
            {data: 'flag', name: 'pollisomaj_data.flag'},
			{data: 'created_at', name: 'pollisomaj_data.created_at'},
            {data: 'updated_at', name: 'pollisomaj_data.updated_at'},
            // {data: 'updated_at', name: 'pollisomaj_data.updated_at'}
            ]
        });

		$('#pollisomaj-filterForm').on('submit', function(e) {
			console.log("asf");
			dTable.draw();
			e.preventDefault();
		});
	});



	// $(document).on('click','#search',function(){

	// 	var division_id = $('#division_id').val();
	// 	var district_id = $('#district_id').val();
	// 	var upazila_id = $('#upazila_id').val();
	// 	var union_id = $('#union_id').val();
	// 	var start_date = $('#start_date').val();
	// 	var end_date = $('#end_date').val();
	// 	var violence_category_id = $('#violence_category_id').val();
	// 	var violence_sub_category_id = $('#violence_sub_category_id').val();
	// 	var violence_name_id = $('#violence_name_id').val();
	// 	var survivor_id = $('#survivor_id').val();
	// 	$.ajax({
	// 		url: "{{route('incident.violence.get-list')}}",
	// 		type: "get",
	// 		data: {
	// 			'division_id': division_id,
	// 			'district_id':district_id,
	// 			'upazila_id':upazila_id,
	// 			'union_id':union_id,
	// 			'start_date':start_date,
	// 			'end_date':end_date,
	// 			'violence_category_id':violence_category_id,
	// 			'violence_sub_category_id':violence_sub_category_id,
	// 			'survivor_id':survivor_id,
	// 		},
	// 		beforeSend: function() {
	// 			// $('#loader-wrapper').show();
	// 		},
	// 		success: function (data) {
	// 			var source = $("#document-template").html();
	// 			var template = Handlebars.compile(source);
	// 			var html = template(data);
	// 			$('#DocumentResults').html(html);
	// 			$('#batchdatatable').DataTable();
	// 			$('[data-toggle="tooltip"]').tooltip();
	// 		}
	// 	});
	// });

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


