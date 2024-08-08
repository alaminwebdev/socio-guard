@extends('backend.layouts.app')
@section('content')

<style type="text/css">
	.form-group {
    margin-bottom: 0.5rem!important;
}
</style>

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Follow-Up Info</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Follow-Up Info</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Search Follow-Up Info</h5>
			</div>
			<div class="card-body">
				<form method="get" action="" id="filterForm">
					<div class="card-body">
						<!-- <div class="form-row">
							<div class="form-group col-md-3">
								<label class="control-label">Division Name</label>
								<select name="division_id" class="form-control form-control-sm division_id" onclick="getDivisionDistrict(this.options[this.selectedIndex].value, $(this));">
									<option value="">Select Division</option>
									@foreach($divisions as $division)
									<option value="{{ $division->id }}">{{ $division->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="form-group col-md-3">
								<label class="control-label">District Name</label>
								<select name="district_id" class="form-control form-control-sm district_id" onclick="getDistrictUpazila(this.options[this.selectedIndex].value, $(this));">
									<option value="">Select District</option>
								</select>
							</div>
							<div class="form-group col-md-3">
								<label class="control-label">Upazila Name</label>
								<select name="upazila_id" class="form-control form-control-sm upazila_id" onclick="getUpazilaUnion(this.options[this.selectedIndex].value, $(this));">
									<option value="">Select Upazila</option>
								</select>
							</div>
							<div class="form-group col-md-3">
								<label class="control-label">Union Name</label>
								<select name="union_id" class="form-control form-control-sm union_id">
									<option value="">Select Union</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-3">
								<label class="control-label">From Date</label>
								<input type="text" name="from_date" class="form-control form-control-sm singledatepicker" value="" readonly="">
							</div>
							<div class="form-group col-md-3">
								<label class="control-label">To Date</label>
								<input type="text" name="to_date" class="form-control form-control-sm singledatepicker" value="" readonly="">
							</div>
						</div>
						<button type="submit" class="btn btn-success btn-sm">Search</button> -->
						<div class="form-row">
							<div class="form-group col-md-3">
								<label class="control-label">Regions</label>
								<select name="region_id" id="region_id" class="region_id form-control form-control-sm select2" required="">
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
							</div>
							<div class="form-group col-sm-2">
								<label class="control-label">Incident ID</label>
								<input type="text" name="survivor_id" id="survivor_id" class="survivor_id form-control form-control-sm" placeholder="Write Incident ID">
							</div>
							<div class="form-group col-sm-2" style="margin-top: -23px;">
								<!-- <a class="btn btn-sm btn-primary" type="submit" style="margin-top: 29px; color: white">Search</a> -->
								<button type="submit" class="btn btn-success btn-sm"  style="margin-top: 29px; color: white">Search</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<br>
		<div class="card">
			<div class="card-header">
				<h5>Follow-Up Info List</h5>
			</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%;" id="data-table">
					<thead>
						<tr>
							<th>Sl.</th>
							<th>Incident No.</th>
							<th>Survivor Name</th>
							<th>Incident Date</th>
							<th>Follow-Up No.</th>
							<th>Last Follow-Up Date</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>

<script>

    $(document).ready(function(){

        var dTable = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url:'{{ route("followup.info.getViewDatatable") }}',
                data: function (d) {
                    d._token      = "{{ csrf_token() }}";
                    d.region_id = $('select[name=region_id]').val();
                    d.division_id = $('select[name=division_id]').val();
                    d.district_id = $('select[name=district_id]').val();
                    // d.upazila_id  = $('select[name=upazila_id]').val();
                    // d.union_id    = $('select[name=union_id]').val();
                    d.violence_category_id 		= $('select[name=violence_category_id]').val();
                    d.violence_sub_category_id 	= $('select[name=violence_sub_category_id]').val();
                    d.violence_name_id 			= $('select[name=violence_name_id]').val();
                    d.survivor_id 				= $('input[name=survivor_id]').val();
                    d.from_date   = $('input[name=from_date]').val();
                    d.to_date     = $('input[name=to_date]').val();
                }
            },
            columns: [
                {data: 'DT_RowIndex', name: 'survivor_incident_informations.id'},
                {data: 'survivor_id', name: 'survivor_incident_informations.survivor_id'},
                {data: 'survivor_name', name: 'survivor_incident_informations.survivor_name'},
                {data: 'violence_date', name: 'survivor_incident_informations.violence_date'},
                {data: 'followup_no', name: 'followup_no'},
                {data: 'last_followup_date', name: 'last_followup_date'},
                {data: 'case_status', name: 'survivor_incident_informations.case_status'},
                {data: 'action_column', name: 'action_column'}
            ]
        });

        $('#filterForm').on('submit', function(e) {
            dTable.draw();
            e.preventDefault();
        });

    });

	// function getDivisionDistrict(division_id, item)
 //    {
 //    	var url  = "{{ route('setup.getDivisionDistrict') }}";
 //      	var data = {
 //    		division_id: division_id
 //    	};

 //      	$.get(url, data, function(response) {
 //      		// console.log(response);
 //            item.closest('.form-row').find('.district_id').html(response);
 //        });
 //    }

 //    function getDistrictUpazila(district_id, item)
 //    {
 //    	var url  = "{{ route('setup.getDistrictUpazila') }}";
 //      	var data = {
 //    		district_id: district_id
 //    	};

 //      	$.get(url, data, function(response) {
 //            // console.log(response);
 //            item.closest('.form-row').find('.upazila_id').html(response);
 //        });
 //    }

 //    function getUpazilaUnion(upazila_id, item)
 //    {
 //    	var url  = "{{ route('setup.getUpazilaUnion') }}";
 //      	var data = {
 //    		upazila_id: upazila_id
 //    	};

 //      	$.get(url, data, function(response) {
 //            // console.log(response);
 //            item.closest('.form-row').find('.union_id').html(response);
 //        });
 //    }

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

@endsection
