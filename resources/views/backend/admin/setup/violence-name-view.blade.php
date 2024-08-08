@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Violence Name</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Violence Name</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Violence Name List
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.violence.name.add')}}"><i class="fa fa-plus-circle"></i> Add Violence Name</a>
				</h5>
			</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
					<thead  >
						<tr>
							<th>Sl.</th>
							<th>Type</th>
							<th>Sub Type</th>
							<th>Violence Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($allData as $key => $violence)
						<tr class="{{$violence->id}}">
							<td>{{$key+1}}</td>
							<td>{{$violence['violencecategory']['name']}}</td>
							<td>{{$violence['violencesubcategory']['name']}}</td>
							<td>{{$violence->name}}</td>
							<td>
								<a class="btn btn-sm btn-success" title="Edit" href="{{route('setup.violence.name.edit',$violence->id)}}"><i class="fa fa-edit"></i></a>
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