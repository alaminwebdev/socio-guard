@extends('backend.layouts.app')
@section('content')
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Community Mobilisation Data Entry List
					@if($auth_user->user_role[0]['role_id'] == 5)
					<a target="_blank" class="btn btn-sm btn-success float-right" href="{{url('incident/pollisomaj/data/add')}}?addnew=true""><i class="fa fa-plus-circle"></i> Add New Pollisomaj Data</a>
					@endif
				</h5>
			</div>
			<div class="card-body">

				{{-- Search form start --}}
				<form method="get" action="" id="pollisomaj-filterForm">
					<div class="form-row">
						<div class="form-group col-md-3">
							<label class="control-label">Zone</label>
							@if(count(session()->get('userareaaccess.sregions'))>0)
								<select name="region_id" id="region_id" class="region_id form-control form-control-sm select2">
								  	<option value="">Select zone</option>
								  	@foreach($regions as $key=>$region)
										@if(in_array($region->id,session()->get('userareaaccess.sregions')) )
									  	<option value="{{$region->id}}">{{$region->region_name}}</option>
										@endif
								  	@endforeach
								</select>
							@else
								<select name="region_id" id="region_id" class="region_id form-control form-control-sm select2">
								  	<option value="">Select Zone</option>
									@foreach($regions as $region)
									<option value="{{$region->id}}">{{$region->region_name}}</option>
									@endforeach
								</select>  
							@endif
						</div>
						<div class="form-group col-md-3">
							<label class="control-label">Division</label>
							<select name="division_id" id="division_id" class="division_id form-control form-control-sm">
								<option value="">Select Division</option>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label class="control-label">District</label>
							<select name="district_id" id="district_id" class="district_id form-control form-control-sm">
								<option value="">Select District</option>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label class="control-label">Upazila</label>
							<select name="upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
								<option value="">Select Upazila</option>
							</select>
						</div>
							<div class="form-group col-sm-2">
								<label class="control-label">From Date</label>
								<input type="text" name="from_date" id="from_date" class="form-control form-control-sm singledatepicker" placeholder="From Date" autocomplete="off">
							</div>
							<div class="form-group col-sm-2">
								<label class="control-label">To Date</label>
								<input type="text" name="to_date" id="to_date" class="form-control form-control-sm singledatepicker" placeholder="To Date" autocomplete="off">
							</div>
							<div class="form-group col-sm-2">
								<button type="submit" class="btn btn-success btn-sm"  style="margin-top: 21px; color: white">Search</button>
							</div>
						</div>
					</form>
				{{-- Search form end --}}
				<div class="card">
					<div class="card-header">
						{{-- @if($auth_user->user_role[0]['role_id'] == 5)
						@endif --}}
						<a href="{{ route('incident.pollisomaj.viewpollisomajDraftList') }}"><button type="submit" class="btn btn-warning btn-sm"  style="color: white">Draft List</button></a>
						<a href="{{ route('incident.pollisomaj.viewpollisomajPendingList') }}"><button type="submit" class="btn btn-primary btn-sm"  style="color: white">Pending List</button></a>
						<a href="{{ route('incident.pollisomaj.viewpollisomajApproveList') }}"><button type="submit" class="btn btn-success active"  style="color: white"><i class="fa fa-check-circle" aria-hidden="true"></i> Approved List</button></a>
					</div>
					<div class="card-body">
						<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="pollisomaj-data-table">
							<thead>
								<tr>
									<th>Sl.</th>
									<th>Pollisomaj Data Entry No.</th>
									<th>Pollisomaj name</th>
									<th>Status</th>
									<th>Reporting Date</th>
									<th>Creation Date</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<script type="text/javascript">
	$(document).ready(function(){
		var dTable = $('#pollisomaj-data-table').DataTable({
			processing: true,
			serverSide: true,
            ajax: {
            	url:'{{ route("incident.pollisomaj.getPollisomajApproveList") }}',
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
			{data: 'pollisomaj_name', name: 'pollisomaj_data.pollisomaj_name'},
            {data: 'flag', name: 'pollisomaj_data.flag'},
			{data: 'reporting_date', name: 'pollisomaj_data.reporting_date'},
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

</script>

<script>

	$(document).ready(function(){
		$('#pollisomaj-data-table').on( 'click.dt', function (e) {
			if(e.target.getAttribute("action_type")=="inc_del"){
				remove(e.target.id,e,'');
			}
			//console.log(e.target.getAttribute("action_type"));
			
		} );
	});
	function remove(id, e, item)
	{
		e.preventDefault();
		swal({
	        title: "Are you sure?",
	        text: "would you like to delete this Pollishomaj Information? You will not be able to recover this item!",
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
        		var url  = "{{ route('delete.getPollisomajInfo', '') }}"+"/"+id;
        		// console.log(url);

		      	$.get(url, function(response) {
		      		if (response == 'Deleted Successfully')
		      		{
		      			swal("Deleted!", "Your item has been deleted!", "success");
		      			// item.closest('.tr-row').remove();
						var dTable = $('#pollisomaj-data-table').DataTable();
						dTable.draw();
						e.preventDefault();
						
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
				url : "{{route('default.get-region-upazila')}}",
				type : "GET",
				data : {district_id:district_id},
				success:function(data){
          console.log(data);
					var html = '<option value="">Select Upazila</option>';
					$.each(data,function(key,v){
            if (v.setup_user_upazila == undefined) {
              html +='<option value="'+v.id+'">'+v.name+'</option>';
            } else {
              html +='<option value="'+v.setup_user_upazila.id+'">'+v.setup_user_upazila.name+'</option>';
            }
					});
					$('#upazila_id').html(html);
				}
			});
		});
	});
</script>
@endsection


