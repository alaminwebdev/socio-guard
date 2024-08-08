@extends('backend.layouts.app')
@section('content')
<div class="container fullbody">
	<div class="row">
		<div class="col-md-12 card" style="padding-right: 0px;padding-left: 0px;">
			<div class="card-header">
				<h5>Secondary Refferal List
					<a class="btn btn-sm btn-success float-right" href="{{route('secondary-refferal.create')}}"><i class="fa fa-plus-circle"></i> Add Secondary Refferal</a>
				</h5>
			</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
					<thead  >
						<tr>
							<th>Sl.</th>
							<th>Secondary Refferal Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($refferal as $key => $item)
						<tr class="{{$item->id}} tr-row">
							<td>{{$key+1}}</td>
							<td>{{$item->name}}</td>
							<td>
								<a class="btn btn-sm btn-success" title="Edit" href="{{route('secondary-refferal.edit',$item->id)}}"><i class="fa fa-edit"></i></a>
								<a class="btn btn-sm btn-danger" title="Edit" href="#" onclick="remove({{ $item->id }}, event, $(this))"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script>
	function remove(id, e, item)
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
        		var url  = "{{ route('secondary-refferal.show', '') }}"+"/"+id;
        		// console.log(url);
				
				$.get(url, function(response) {
					console.log(response);
					if (response == 'deleted')
		      		{
		      			swal("Deleted!", "Your item has been deleted!", "success");
		      			item.closest('.tr-row').remove();
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

@endsection