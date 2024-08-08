@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Survivor/Incident Place</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Survivor/Incident Place</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Survivor/Incident Place List
					<a class="btn btn-sm btn-success float-right" href="{{route('setup.survivor-incident.place.add')}}"><i class="fa fa-plus-circle"></i> Add Survivor/Incident Place</a>
				</h5>
			</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">
					<thead  >
						<tr>
							<th>Sl.</th>
							<th>Survivor/Incident Place</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach($allData as $key => $place)
						<tr class="{{$place->id}}">
							<td>{{$key+1}}</td>
							<td>{{$place->name}}</td>
							<td>
								<a class="btn btn-sm btn-success" title="Edit" href="{{route('setup.survivor-incident.place.edit',$place->id)}}"><i class="fa fa-edit"></i></a>
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