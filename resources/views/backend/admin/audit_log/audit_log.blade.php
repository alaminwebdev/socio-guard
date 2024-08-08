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
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Audit Log List
				</h5>
			</div>
			<div class="card-body">
				<form method="get" action="" id="filterForm">
					<input type="hidden" name="token" id="token" value="{{ csrf_token() }}"/>
					<div class="form-row">
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
							<button type="" class="btn btn-danger btn-sm delete-log" onclick="deleteItem(event, $(this))" style="margin-top: 21px; color: white">Delete</button>
						</div>
					</form>
				</div>
			</div>
			<br>

			<div class="card">
				<div class="card-body">
					<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="data-table">
                    <thead>
                    	<tr>
                    		<th>Sl.</th>
                    		<th>Employee PIN</th>
                    		<th>Employee Name</th>
                    		<th>Login Time</th>
                    		<th>Logout Time</th>
                    		<th>Complain ID</th>
                    		<th>Pollisomaj Data ID</th>
                    		<th>Description</th>
                    		<th>Action Type</th>
                    		<th>Action Date-Time</th>
                    		<th>Ip Address</th>
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
            	url:'{{ route("audit_log.getAuditLogDatatable") }}',
            	data: function (d) {
					console.log(d);
            		d._token      				= "{{ csrf_token() }}";
            		d.from_date   				= $('input[name=from_date]').val();
            		d.to_date     				= $('input[name=to_date]').val();
            	}
            },
            columns: [
            {data: 'DT_RowIndex', name: 'audit_logs.id'},
            {data: 'employee_pin', name: 'employee_pin'},
            {data: 'employee_name', name: 'employee_name'},
            {data: 'login_time', name: 'audit_logs.login_time'},
            {data: 'logout_time', name: 'audit_logs.logout_time'},
            {data: 'complain_id', name: 'audit_logs.complain_id'},
            {data: 'pollisomaj_data_id', name: 'audit_logs.pollisomaj_data_id'},
            {data: 'description', name: 'audit_logs.description'},
            {data: 'action_type', name: 'audit_logs.action_type'},
            {data: 'created_at', name: 'created_at'},
            {data: 'ip_address', name: 'ip_address'}
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

{{-- <script type="text/javascript">
	$(document).ready(function(){
		$(".delete-log").click(function(){
			var from_date 	= $('#from_date').val();
			var to_date 	= $('#to_date').val();
			var token       = $('#token').val();
			$.ajax({
				type: "POST",
				data: {
					_token:token, 
					from_date:from_date, 
					to_date:to_date 
				},
				url: "{{route('deleteAuditLog')}}",
				success: function(response) {
					// Handle success
					console.log(response);
				},
				error: function(error) {
					// Handle error
				}
			});
		});
	});
</script> --}}

<script>
	function deleteItem(e, item)
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
				var from_date 	= $('#from_date').val();
				var to_date 	= $('#to_date').val();
				var token       = $('#token').val();
        		var url  		= "{{ route('deleteAuditLog', '') }}"+"/"+from_date+"/"+to_date;

		      	$.get(url, function(response) {
		      		if (response == 'deleted')
		      		{
		      			swal("Deleted!", "Your item has been deleted!", "success");
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

@endsection