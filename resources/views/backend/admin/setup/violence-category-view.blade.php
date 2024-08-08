@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Violence Type</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Violence Type</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Violence Type List
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.violence.category.add')}}"><i class="fa fa-plus-circle"></i> Add Violence Type</a>
				</h5>
			</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
					<thead  >
						<tr>
							<th>Sl.</th>
							<th>Violence Type</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($allData as $key => $category)
						<tr class="{{$category->id}} tr-row">
							<td>{{$key+1}}</td>
							<td>{{$category->name}}</td>
							<td>
								<a class="btn btn-sm btn-success" title="Edit" href="{{route('setup.violence.category.edit',$category->id)}}"><i class="fa fa-edit"></i></a>
								<a class="btn btn-sm btn-danger" title="Delete" href="#" onclick="remove({{ $category->id }}, event, $(this))"><i class="fa fa-trash"></i></a>
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
        		var url  = "{{ route('setup.violence.category.delete', '') }}"+"/"+id;
        		// console.log(url);

				$.get(url, function(response) {
		      		console.log(response);
		      		if (response == 'deleted')
		      		{
		      			swal("Deleted!", "Your item has been deleted!", "success");
		      			item.closest('.tr-row').remove();
		      			location.reload(true);
		      		}
					else if (response == 'notdeleted')
					{
						swal("Ops!", "There are some entries found under this Violence Type!", "warning");
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