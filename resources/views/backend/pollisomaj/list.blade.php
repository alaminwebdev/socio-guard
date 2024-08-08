@extends('backend.layouts.app')
@section('content')
{{-- <div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Pollishomaj</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Pollishomaj</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div> --}}
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Pollishomaj List
					<a target="_blank" class="btn btn-sm btn-success float-right" href="{{route('add.pollisomaj')}}"><i class="fa fa-plus-circle"></i> Add Pollishomaj</a>
				</h5>
			</div>
			<div class="card-body">
				<form method="get" action="" id="filterForm">
					<div class="form-row">
						<div class="form-group col-md-2">
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
						<div class="form-group col-md-2">
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
						<div class="form-group col-sm-2">
							<button type="submit" class="btn btn-primary btn-sm"  style="margin-top: 21px; color: white">Search</button>
							<a href="{{ route('view.pollisomaj') }}" class="btn btn-sm btn-warning" type="submit" style="margin-top: 21px; color: white">Reset</a>
						</div>
						</div>
					</form>
				</div>
			</div>
			<br>
			<div class="card">
				<div class="card-body">
					<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="data-table">
						<thead  >
							<tr>
								<th>Sl.</th>
								<th>Pollishomaj No.</th>
								<th>Pollishomaj Name</th>
								<th>Zone</th>
								<th>Division</th>
								<th>District</th>
								<th>Upazila</th>
								<th>Union</th>
								<th>Village</th>
								<th>Date from</th>
								<th>Date to</th>
								<th>Action</th>
							</tr>
						</thead>
						{{-- <tbody>
							@foreach($pollisomajList as $key=>$item)
								<tr class="tr-row">
									<td>{{$key+1}}</td>
									<td>{{@$item->pollisomaj_no}}</td>
									<td>{{@$item->pollisomaj_name}}</td>
									<td>{{@$item->zone->region_name}}</td>
									<td>{{@$item->division->name}}</td>
									<td>{{@$item->district->name}}</td>
									<td>{{@$item->upazila->name}}</td>
									<td>{{@$item->union->name}}</td>
									<td>{{@$item->village_name}}</td>
									<td>{{@$item->date_from}}</td>
									<td>{{@$item->date_to}}</td>
									<td>
										<a class="btn btn-sm btn-success" title="Edit" href="{{route('edit.pollisomaj',['id'=>$item->id])}}"><i class="fa fa-edit"></i></a>
										<a class="btn btn-sm btn-danger" title="Delete" href="#" onclick="deleteManager({{$item->id}}, event, $(this))"><i class="fa fa-trash"></i></a>
									</td>
								</tr>
							@endforeach
						</tbody> --}}
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	$(document).ready(function(){
		$('#data-table').on( 'click.dt', function (e) {
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
        		var url  = "{{ route('delete.pollisomaj', '') }}"+"/"+id;
        		// console.log(url);

		      	$.get(url, function(response) {
		      		if (response == 'deleted')
		      		{
		      			swal("Deleted!", "Your item has been deleted!", "success");
		      			// item.closest('.tr-row').remove();
						var dTable = $('#data-table').DataTable();
						dTable.draw();
						e.preventDefault();
						
		      		}
					else if (response == 'notdeleted')
					{
						swal("Ops!", "this data already use in this system. You can edit this data.", "warning");
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
	$(document).ready(function(){
		var dTable = $('#data-table').DataTable({
			processing: true,
			serverSide: true,
            ajax: {
            	url:'{{ route("view.getPolliSomaj") }}',
            	data: function (d) {
            		console.log(d);
            		d._token      				= "{{ csrf_token() }}";
            		d.zone_id 					= $('select[name=region_id]').val();
            		d.division_id 				= $('select[name=division_id]').val();
            		d.district_id 				= $('select[name=district_id]').val();
            		d.upazila_id  				= $('select[name=upazila_id]').val();
            	}
            },
            columns: [
            {data: 'DT_RowIndex', name: 'id'},
            {data: 'pollisomaj_no', name: 'pollisomaj_no'},
            {data: 'pollisomaj_name', name: 'pollisomaj_name'},
            {data: 'zone', name: 'zone'},
            {data: 'division', name: 'division'},
            {data: 'district', name: 'district'},
            {data: 'upazila', name: 'upazila'},
            {data: 'union', name: 'union'},
            {data: 'village_name', name: 'village_name'},
            {data: 'date_from', name: 'date_from'},
            {data: 'date_to', name: 'date_to'},
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
	function deleteManager(id, e, item)
	{
		e.preventDefault();
		swal({
	        title: "Are you sure?",
	        text: "You will not be able to recover this item!",
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
        		var url  = "{{ route('delete.pollisomaj', '') }}"+"/"+id;
        		// console.log(url);

		      	$.get(url, function(response) {
		      		if (response == 'deleted')
		      		{
		      			swal("Deleted!", "Your item has been deleted!", "success");
		      			item.closest('tbody').find('.tr-row').remove();
						location.reload();
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