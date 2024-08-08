@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Add Skills</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active"> Add Skills</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12 mb-3">
		<div class="card">
			<div class="card-header">
				<h5>Group's information
					
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
		</div>
	</div>

    <div class="col-md-12 ">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered  dt-responsive nowrap" style="width: 100%" id="data-table">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Groups Name</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- extra html -->

<script>

    $(document).ready(function() {
        var dTable = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '{{ route('swapnosarothi.profile.skill.list.datatable') }}',
                data: function(d) {
                    d._token = "{{ csrf_token() }}";
                    d.region_id = $('select[name=region_id]').val();
                    d.division_id = $('select[name=division_id]').val();
                    d.district_id = $('select[name=district_id]').val();
                    d.upazila_id = $('select[name=upazila_id]').val();
                    d.start_date = $('input[name=from_date]').val();
                    d.end_date = $('input[name=to_date]').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'id'
                },
                
                {
                    data: 'group_name',
                    name: 'group_name'
                },
                {
                    data: 'status',
                    name: 'status'
                },
               
                // {
                //     data: 'group',
                //     name: 'group',
                //     orderable: true, 
                //     searchable: true
                // },
                
                {
                    data: 'action_column',
                    name: 'action_column'
                }
            ]
        });
        $('#filterForm').on('submit', function(e) {
			dTable.draw();
			e.preventDefault();
		});

        
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