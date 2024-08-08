@extends('backend.layouts.app')
@section('content')
<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">{{session()->get('title')}}</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">{{session()->get('title')}}</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
					<h5>{{session()->get('title')}} List <a href="#" class="btn btn-sm btn-facebook float-right"><i class="fa fa-plus"></i>
					Add {{session()->get('title')}}</a></h5>
				</div>
			<div class="card-body">
				<table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="datatable">

				</table>
			</div>
		</div>
	</div>
</div>
@endsection


{{-- 
<a class="btn btn-sm btn-danger softdelete" title="Delete" data-id="{{$user->id}}" data-tablename="users"><i class="fa fa-trash"></i></a> --}}