@extends('backend.layouts.app')
@section('content')
<div class="container fullbody">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <!-- Form Start-->
                <form method="post" action="{{ route('pollishomajData') }}" id="myForm">
                    {{csrf_field()}}
                    <div class="card-body">
                        <div class="show_module_more_event">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Pollishomaj Data ID</label>
                                    <input type="number" name="id" id="id" class="form-control form-control-sm" value="" placeholder="ID">
                                </div>
                                <div class="col-md-2" style="margin-top: 21px;">
    
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--Form End-->
            </div>
        </div>
    
        <div class="col-md-6">
            <div class="card">
                <!-- Form Start-->
                <form method="post" action="{{ route('activityDataDelete') }}" id="myForm">
                    {{csrf_field()}}
                    <div class="card-body">
                        <div class="show_module_more_event">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">Activity Data ID</label>
                                    <input type="number" name="id" id="id" class="form-control form-control-sm" value="" placeholder="ID">
                                </div>
                                <div class="col-md-2" style="margin-top: 21px;">
    
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <!--Form End-->
            </div>
        </div>
    </div>
</div>
<!-- extra html -->
@if (Session::has('success'))
    <script>
    toastr.success('',"{{Session::get('success')}}",{
        hideMethod:'fadeOut',
        hideDuration: 1000,
        progressBar:true

    })
    </script>
@endif
<script>
    $(document).ready(function(){
    	$('#myForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	            'name' : {
	                required : true,
	            },
	        },
	        messages : {

	        }
	    });
    });
</script>

@endsection