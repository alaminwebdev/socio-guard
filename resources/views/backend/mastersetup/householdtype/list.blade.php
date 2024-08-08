@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Household Type</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Household Type</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Household Type List
					<a class="btn btn-sm btn-success float-right" href="{{route('householdtypes.create')}}"><i class="fa fa-plus-circle"></i> Add Household Type</a>
				</h5>
			</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
					<thead  >
						<tr>
							<th>Sl.</th>
							<th>Household Type</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($householdtypes as $key => $item)
						<tr class="{{$item->id}}">
							<td>{{$key+1}}</td>
							<td>{{$item->title}}</td>
							<td>
								<a class="btn btn-sm btn-success" title="Edit" href="{{route('householdtypes.edit',$item->id)}}"><i class="fa fa-edit"></i></a>
								<a class="btn btn-sm btn-danger" title="Edit" href="{{route('householdtypes.show',$item->id)}}"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection