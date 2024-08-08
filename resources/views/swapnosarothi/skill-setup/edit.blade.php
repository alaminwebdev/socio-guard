@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Swapnosarothi Skill Setup</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active"> Swapnosarothi Skill Setup</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
					<a class="btn btn-sm btn-success float-right" href="{{ route('swapnosarothiskill.index') }}"><i class="fa fa-list"></i> Skill List</a></h5>
			</div>
			<!-- Form Start-->
			@include('swapnosarothi.skill-setup.form')
			<!--Form End-->
		</div>
	</div>
</div>
<!-- extra html -->

@endsection