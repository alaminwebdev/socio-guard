@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Zone</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Zone</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
					Add Zone 
					<a class="btn btn-sm btn-success float-right" href="{{ route('setup.cepregion.region.view') }}"><i class="fa fa-list"></i> Zone List</a>
				</h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{ route('setup.cepregion.region.store') }}">
				{{ csrf_field() }}
				<div class="card-body">
					<div class="form-row">
						<div class="form-group col-md-4">
							<label class="control-label">Zone Name</label>
							<input type="text" name="region_name" class="form-control form-control-sm" value="" placeholder="Zone Name">
						</div>
						<div class="form-group col-md-4" style="position: relative; top: 28px;">
							<button type="submit" class="btn btn-success btn-sm">Submit</button>
							<button type="reset" class="btn btn-danger btn-sm">Reset</button>
						</div>
					</div>
				</div>
			</form>
			<!--Form End-->
		</div>
	</div>
</div>
<!-- extra html -->

@endsection
