@extends('backend.layouts.app')
@section('content')

<style type="text/css">
	.form-group {
		margin-bottom: 0.5rem!important;
	}
</style>

{{-- <div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Violence Incident</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home</li>
			<li class="breadcrumb-item active">Violence Incident</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div> --}}
<div class="container fullbody">
	<div class="row">
		<div class="col-md-12 card">
			<div class="card-header">
				<h5>Select Search Criteria
					{{-- @if(crudpermission('setup.venue.add') !='')
					<a class="btn btn-sm btn-success float-right" href="{{url('incident/selp/add')}}?addNew=true"><i class="fa fa-plus-circle"></i> Add Violence Incident</a>
					@endif --}}
					@if($auth_user->user_role[0]['role_id'] == 5)
						<a class="btn btn-sm btn-success float-right" href="{{url('incident/selp/add')}}?addNew=true"><i class="fa fa-plus-circle"></i> Add Violence Incident</a>
					@endif
				</h5>
			</div>
			<div class="card-body">
				<form method="get" action="" id="filterForm">
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
							<!-- <a class="btn btn-sm btn-primary" type="submit" style="margin-top: 29px; color: white">Search</a> -->
							<button type="submit" class="btn btn-success btn-sm"  style="margin-top: 21px; color: white">Search</button>
						</div>
					</div>
				</form>
			</div>
			<br>

			<div class="card">
				<div class="card-header">
					{{-- @if($auth_user->user_role[0]['role_id'] == 4 || $auth_user->user_role[0]['role_id'] == 5)
					@endif --}}
					<a href="{{ route('incident.draft.list') }}"><button type="submit" class="btn btn-warning btn-sm"  style="color: white">Draft List</button></a>
					<a href="{{ route('incident.pending.list') }}"><button type="submit" class="btn btn-primary btn-sm"  style="color: white">Pending List</button></a>
					<a href="{{ route('incident.approved.list') }}"><button type="submit" class="btn btn-success active"  style="color: white"><i class="fa fa-check-circle" aria-hidden="true"></i> Approved List</button></a>
					{{-- <h3 class="text-right">Violence/Incident List</h3> --}}
				</div>
				<div class="card-body">
					<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="data-table">
                    <!-- <thead>
                        <tr>
							@{{{thsource}}}
                        </tr>
                    </thead>
                    <tbody>
                    	@{{{tdsource}}}
                    </tbody> -->
                    <thead>
                    	<tr>
                    		<th>Sl.</th>
                    		<th>Complain ID.</th>
                    		<th>Survivor Name</th>
                    		<th>Survivor Age</th>
                    		<th>Reporting Date</th>
                    		<th>Creation Date</th>
                    		<th>Status</th>
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
		var dTable = $('#data-table').DataTable({
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
            	url:'{{ route("incident.getSelpIncidentApprovedDatatable") }}',
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
            {data: 'DT_RowIndex', name: 'selp_incident_informations.id'},
            {data: 'selp_incident_ref', name: 'selp_incident_informations.selp_incident_ref'},
            {data: 'survivor_name', name: 'selp_incident_informations.survivor_name'},
            {data: 'survivor_age', name: 'selp_incident_informations.survivor_age'},
            {data: 'posting_date', name: 'selp_incident_informations.posting_date'},
            {data: 'created_at', name: 'selp_incident_informations.created_at'},
            {data: 'status', name: 'selp_incident_informations.status'},
            {data: 'action_column', name: 'action_column'}
            ]
        });

		$('#filterForm').on('submit', function(e) {
			console.log("asf");
			dTable.draw();
			e.preventDefault();
		});
	});

</script>

<script>

	$(document).ready(function(){
		$('#data-table').on( 'click.dt', function (e) {
			if(e.target.getAttribute("action_type")=="inc_del"){
				remove(e.target.id,e,'');
			}
			//console.log(e.target.getAttribute("action_type"));
			
		} );
	});
	// $(".delete_incident").click(function(){
	// 	alert();
	// })
	function remove(id, e, item)
	{
		e.preventDefault();
		swal({
	        title: "Are you sure?",
	        text: "would you like to delete this complain record and relevant information? You will not be able to recover this item!",
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
        		var url  = "{{ route('incident.delete', '') }}"+"/"+id;
        		// console.log(url);

		      	$.get(url, function(response) {
		      		if (response == 'Deleted Successfully')
		      		{
		      			swal("Deleted!", "Your item has been deleted!", "success");
		      			// item.closest('.tr-row').remove();
						var dTable = $('#data-table').DataTable();
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

<script type="text/javascript">
	$(document).ready(function(){
		$(".deleteincident").click(function(){
			alert("sfas");
			if (!confirm("Do you want to delete")){
				return false;
			}
		});
	});
</script>

@endsection