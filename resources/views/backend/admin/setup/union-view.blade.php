@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Union</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Union</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Union List
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.union.add')}}"><i class="fa fa-plus-circle"></i> Add Union</a>
				</h5>
			</div>
			<div class="card-body">
				<form method="get" action="" id="filterForm">
					<div class="form-row">
						<div class="form-group col-md-3">
							<label class="control-label">Division Name</label>
							<select name="division_id" id="division_id" class="form-control form-control-sm">
								<option value="">Select Division</option>
								@foreach($divisions as $d)
								<option value="{{$d->id}}" {{(@$editData->division_id==$d->id)?"selected":""}}>{{$d->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-3">
							<label class="control-label">District Name</label>
							<select name="district_id" id="district_id" class="form-control form-control-sm">
								<option value="">Select District</option>
							</select>
						</div>
						<div class="form-group col-md-3">
							<label class="control-label">Upazila Name</label>
							<select name="upazila_id" id="upazila_id" class="form-control form-control-sm">
								<option value="">Select Upazila</option>
							</select>
						</div>
						<div class="form-group col-sm-2">
							<button type="submit" class="btn btn-primary btn-sm"  style="margin-top: 21px; color: white">Search</button>
							<a href="{{ route('setup.union.view') }}" class="btn btn-sm btn-warning" type="submit" style="margin-top: 21px; color: white">Reset</a>
						</div>
						</div>
					</form>
				</div>
			</div>
			<br>
			<div class="card">
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
								<th>Division</th>
								<th>District</th>
								<th>Upazila</th>
								<th>Union</th>
								<th>Action</th>
							</tr>
						</thead>
					</table>
				</div>
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
            	url:'{{ route("setup.union.getUnion") }}',
            	data: function (d) {
            		console.log(d);
            		d._token      				= "{{ csrf_token() }}";
            		d.division_id 				= $('select[name=division_id]').val();
            		d.district_id 				= $('select[name=district_id]').val();
            		d.upazila_id  				= $('select[name=upazila_id]').val();
            	}
            },
            columns: [
            {data: 'DT_RowIndex', name: 'unions.id'},
            {data: 'division', name: 'division'},
            {data: 'district', name: 'district'},
            {data: 'upazila', name: 'upazila'},
            {data: 'name', name: 'unions.name'},
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

<script type="text/javascript">
	$(function(){
		$(document).on('change','#division_id',function(){
			var division_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-district-master')}}",
				type : "GET",
				data : {division_id:division_id},
				success:function(data){
					var html = '<option value="">Select District</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('#district_id').html(html);
					var district_id = "{{@$editData->district_id}}";
					if(district_id !=''){
						$('#district_id').val(district_id).trigger('change');
					}
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
				url : "{{route('default.get-upazila-master')}}",
				type : "GET",
				data : {district_id:district_id},
				success:function(data){
					var html = '<option value="">Select Upazila</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('#upazila_id').html(html);
					var upazila_id = "{{@$editData->upazila_id}}";
					if(upazila_id !=''){
						$('#upazila_id').val(upazila_id);
					}
				}
			});
		});
	});
</script>


@endsection