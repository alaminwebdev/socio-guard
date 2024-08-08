@extends('backend.layouts.app')
@section('content')

<style type="text/css">
	.form-group {
    margin-bottom: 0.5rem!important;
}
</style>

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Violence Incident</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home</li>
			<li class="breadcrumb-item active">Violence Incident</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Select search criteria
					@if(crudpermission('setup.venue.add') !='')
					<a class="btn btn-sm btn-success float-right" href="{{route('incident.violence.add')}}"><i class="fa fa-plus-circle"></i> Add Violence Incident</a>
					@endif
				</h5>
			</div>
			<div class="card-body">
				<form method="get" action="" id="filterForm">
					<div class="form-row">
						<div class="form-group col-md-3">
							<label class="control-label">Regions</label>
							@if(count(session()->get('userareaaccess.sregions')) ==1)
								<select name="region_id" id="region_id" class="region_id form-control form-control-sm select2" required="" disabled="">
							@else
								<select name="region_id" id="region_id" class="region_id form-control form-control-sm select2">
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
						<div class="form-group col-sm-2">
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
								<option value="null">NULL</option>
							</select>
						</div>
						<div class="form-group col-sm-2">
							<label class="control-label">Gender</label>
							<select name="gender" id="gender" class="gender form-control form-control-sm">
								<option value="">Select Gender</option>
								<option value="null">NULL</option>
							</select>
						</div>
						<div class="form-group col-sm-2">
							<label class="control-label">Reason</label>
							<select name="reason" id="reason" class="reason form-control form-control-sm">
								<option value="">Select Reason</option>
								<option value="null">NULL</option>
							</select>
						</div>
						<div class="form-group col-sm-2">
							<label class="control-label">Age</label>
							<select name="age" id="age" class="age form-control form-control-sm">
								<option value="">Select Age</option>
								<option value="null">NULL</option>
							</select>
						</div>
						<div class="form-group col-sm-2">
							<label class="control-label">District NUll Check</label>
							<select name="district_check" id="district_check" class="district_check form-control form-control-sm">
								<option value="">Select</option>
								<option value="null">NULL</option>
							</select>
						</div>
						<div class="form-group col-sm-2">
							<!-- <a class="btn btn-sm btn-primary" type="submit" style="margin-top: 29px; color: white">Search</a> -->
							<button type="submit" class="btn btn-success btn-sm"  style="margin-top: 29px; color: white">Search</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h3>Violence/Incident List</h3>
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
							<th>Incident No.</th>
							<th>Survivor Name</th>
							<th>Survivor Age</th>
							<th>Incident Date</th>
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
        var dTable = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:'{{ route("incident.getIncidentTestDatatable") }}',
                data: function (d) {
                	console.log(d);
                    d._token      				= "{{ csrf_token() }}";
                    d.region_id 				= $('select[name=region_id]').val();
                    d.division_id 				= $('select[name=division_id]').val();
                    d.district_id 				= $('select[name=district_id]').val();
                    d.upazila_id  				= $('select[name=upazila_id]').val();
                    d.union_id    				= $('select[name=union_id]').val();
                    d.violence_category_id 		= $('select[name=violence_category_id]').val();
                    d.gender 					= $('select[name=gender]').val();
                    d.age 						= $('select[name=age]').val();
                    d.reason 					= $('select[name=reason]').val();
                    d.district_check 			= $('select[name=district_check]').val();
                    d.from_date   				= $('input[name=from_date]').val();
                    d.to_date     				= $('input[name=to_date]').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'survivor_incident_informations.id'},
                {data: 'survivor_id', name: 'survivor_incident_informations.survivor_id'},
                {data: 'survivor_name', name: 'survivor_incident_informations.survivor_name'},
                {data: 'survivor_age', name: 'survivor_incident_informations.survivor_age'},
                {data: 'violence_date', name: 'survivor_incident_informations.violence_date'},
                {data: 'created_at', name: 'survivor_incident_informations.created_at'},
                {data: 'action_column', name: 'action_column'}
            ],
            // "dom": "<'row'<'col-sm-3'l><'col-sm-5'B><'col-sm-4'f>>" +
            //        "<'row'<'col-sm-12'tr>>" +
            //        "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            // "buttons": [
            //     'excel',
            //     //'colvis',
            //     {
            //         extend: 'excelHtml5',
            //         text: 'Excel',
            //         exportOptions: {
            //             columns: ':visible'
            //         }
            //     }
            // ]
        });

        $('#filterForm').on('submit', function(e) {
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

<!-- <script type="text/javascript">
	$(function(){
		$(document).on('change','#division_id',function(){
			var division_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-district')}}",
				type : "GET",
				data : {division_id:division_id},
				success:function(data){
					var html = '<option value="">Select District</option>';
					$.each(data[0],function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('#district_id').html(html);
				}
			});
		});
	});
</script> -->

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

<script type="text/javascript">
  $(function(){
    $('#region_id').trigger('change');
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