@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Assistance taken to Prevention child marriage</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Assistance taken to Prevention List</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
					Assistance taken to Prevention
					<a class="btn btn-sm btn-success float-right" href="{{route('childmarriageassistancetaken.create')}}"><i class="fa fa-plus"></i> Add Assistance taken to Prevention Info</a></h5>
			</div>
			<!-- Form Start-->
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
					<thead  >
						<tr>
							<th>Sl.</th>
							<th>Assistance Taken List</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($datas as $key => $item)
						<tr class="{{$item->id}} tr-row">
							<td>{{$key+1}}</td>
							<td>{{$item->name}}</td>
							<td>
								<a class="btn btn-sm btn-success" title="Edit" href="{{route('childmarriageassistancetaken.edit',$item->id)}}"><i class="fa fa-edit"></i></a>
                                <form class="d-inline" action="{{ route('childmarriageassistancetaken.destroy',$item->id) }}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <a href="#" class="btn btn-sm btn-danger deleteList" title="Edit"><i class="fa fa-trash"></i></a>
                                </form>
                            </td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<!-- extra html -->

@endsection

@section('page_script')
    <script>
        $(function ($) {
            $(".deleteList").on('click', function(){
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).parent('form').submit();
                    }
                })
            })
            
        });
        
        
    </script>
@endsection