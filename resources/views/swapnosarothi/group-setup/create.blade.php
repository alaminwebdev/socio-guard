@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Swapnosarothi Group Setup</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active"> Swapnosarothi Group Setup</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
					<a class="btn btn-sm btn-success float-right" href="{{ route('swapnosarothisetupgroup.index') }}"><i class="fa fa-list"></i> Group List</a></h5>
			</div>
			<!-- Form Start-->
			@include('swapnosarothi.group-setup.form')
			<!--Form End-->
		</div>
	</div>
</div>
<!-- extra html -->

<script>
   $(document).ready(function() {
        $.ajax({
            url: '{{ route("swapnosarothi.group.setup.id") }}',
            type: 'GET',
            success: function(data) {
                $('#group_id').val(data);
            },
            error: function(xhr, status, error) {
                console.error('AJAX request failed:', status, error);
            }
        });
    });
</script>

@endsection