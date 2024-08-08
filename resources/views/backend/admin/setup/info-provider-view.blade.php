@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Information Provider Source</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Information Provider Source</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Information Provider Source List
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.source.add')}}"><i class="fa fa-plus-circle"></i> Add Information Provider Source</a>
				</h5>
			</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
						<thead  >
							<tr>
								<th>Sl.</th>
								<th>Name/Source</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($allData as $key => $source)
							<tr class="{{$source->id}} tr-row">
								<td>{{$key+1}}</td>
								<td>{{$source->name}}</td>
								<td>
									<a class="btn btn-sm btn-success" title="Edit" href="{{route('setup.source.edit',$source->id)}}"><i class="fa fa-edit"></i></a>
									<a class="btn btn-sm btn-danger" title="Delete" href="#" onclick="remove({{ $source->id }}, event, $(this))"><i class="fa fa-trash"></i></a>
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
        		var url  = "{{ route('setup.source.delete', '') }}"+"/"+id;
        		// console.log(url);

		      	$.get(url, function(response) {
		      		if (response == 'deleted')
		      		{
		      			swal("Deleted!", "Your item has been deleted!", "success");
		      			item.closest('.tr-row').remove();
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