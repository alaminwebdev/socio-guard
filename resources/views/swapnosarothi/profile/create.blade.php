@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Swapnosarothi Profile Create</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active"> Swapnosarothi Profile Create</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-12">
		<div class="card border-0">
			<div class="card-header">
				<h5>Add Profile
					<a class="btn btn-sm btn-success float-right" href="{{ route('swapnosarothiprofile.index') }}"><i class="fa fa-list"></i> Profile List</a></h5>
			</div>
			<!-- Form Start-->
			@include('swapnosarothi.profile.form')
			<!--Form End-->
		</div>
	</div>

	{{-- profile data upload --}}
	{{-- <div class="col-md-12 mt-5">
		<div class="card">
			<div class="card-header">
				<h5>Upload Profile Data</h5>
			</div>
			<!-- Form Start-->
			<form action="{{ route('profile.data.upload') }}" method="POST" enctype="multipart/form-data">
				@csrf
				<div class="row p-5">
					<div class="col-md-6">
						<input type="file" class="form-control" name="profile_upload">
					</div>
					<div class="col-md-6">
	
						<input type="submit" class="btn btn-sm btn-primary">
					</div>
				</div>
			</form>
			<!--Form End-->
		</div>
	</div> --}}
</div>
<!-- extra html -->

<script>
   $(document).ready(function() {
        $.ajax({
            url: '{{ route("swapnosarothi.profile.id") }}',
            type: 'GET',
            success: function(data) {
				console.log(data);
                $('#profile_id').val(data);
            },
            error: function(xhr, status, error) {
                console.error('AJAX request failed:', status, error);
            }
        });
    });
</script>

@endsection