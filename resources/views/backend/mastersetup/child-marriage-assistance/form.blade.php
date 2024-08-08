@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Assistance taken to Prevention child marriage</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Assistance taken to Prevention</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
					@if(@$editData)
					Update Assistance taken to Prevention
					@else
					Add Assistance taken to Prevention
					@endif 
					<a class="btn btn-sm btn-success float-right" href="{{route('childmarriageassistancetaken.index')}}"><i class="fa fa-list"></i> Assistance taken to Prevention List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="POST" action="{{!empty(@$editData->id) ? route('childmarriageassistancetaken.update',$editData->id) : route('childmarriageassistancetaken.store')}}" id="myForm">
				@csrf
                @if (@$editData->id)
                    @method('PUT')
                @endif
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Assistance taken to Prevention</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="{{old('name', @$editData->name)}}" placeholder="Name">
                                @error('name')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
							</div>
						</div>
					</div>
						
					<button type="submit" class="btn btn-success btn-sm">{{(@$editData) ? 'Update' : 'Submit'}}</button>
					<button type="reset" class="btn btn-danger btn-sm">Reset</button>
				</div>
			</form>
			<!--Form End-->
		</div>
	</div>
</div>
<!-- extra html -->

@endsection