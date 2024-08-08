@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Swapnosarothi Group Setup</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active"> Swapnosarothi Group Setup</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12 mb-3">
		<div class="card">
			<div class="card-header">
				<h5>
					<a class="btn btn-sm btn-success float-right" href="{{ route('swapnosarothisetupgroup.create') }}">
                        <i class="fa fa-list"></i> Add Group</a></h5>
			</div>
			
		</div>
	</div>
    <div class="col-md-12 ">
        <div class="card">
            <div class="card-body">
                <table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%"
                    id="data-table">
                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
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
            ajax: {
                url: '{{ route('swapnosarothi.group.setup.datatable') }}',
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
                    name:'id'
                },
                {
                    data: 'group_id',
                    name: 'group_id'
                },
                {
                    data: 'group_name',
                    name: 'group_name'
                },
                {
                    data: 'start_date',
                    name: 'start_date'
                },
                {
                    data: 'end_date',
                    name: 'end_date'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'action_column',
                    name: 'action_column'
                }
            ]
        });
    });
</script>



@endsection