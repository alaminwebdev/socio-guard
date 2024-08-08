@extends('backend.layouts.app')
@section('content')

<div class="container fullbody">
	<div class="row">
		<div class="col-md-12 card" style="padding-right: 0px;padding-left: 0px;">
			<div class="card-header">
				<h5>
					@if(@$editData)
					Update Primary Refferal
					@else
					Add Primary Refferal
					@endif 
					<a class="btn btn-sm btn-success float-right" href="{{route('refferal.index')}}"><i class="fa fa-list"></i> Primary Refferal List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{ route('refferal.update',$editData->id) }}" id="myForm">
				{{csrf_field()}}
                @if (!empty($editData->id))
                    <input type="hidden" name="_method" value="PUT">
                @endif
				<div class="card-body">
					<div class="show_module_more_event">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Primary Refferal Name</label>
								<input type="text" name="name" id="name" class="form-control form-control-sm" value="{{@$editData->name}}" placeholder="Write Primary Refferal Name">
							</div>
						</div>

                        <div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Status</label>
                                <br>
								Active : <input type="radio" checked value="1" name="status"/>
                                &nbsp;&nbsp;&nbsp;Inactive: <input type="radio" value="0" name="status"/>
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