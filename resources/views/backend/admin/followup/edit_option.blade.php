@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Edit Follow-Up Question-Options</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Follow-Up Question-Options</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
					Follow-Up Question-Options List
					<a class="btn btn-sm btn-success float-right" href="{{ route('followup.question.option.view') }}"><i class="fa fa-plus-circle"></i> View Follow-Up Question-Options</a>
				</h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{ route('followup.question.option.update', $editData->id) }}" id="myForm">
				{{ csrf_field() }}
				<div class="card-body">
					<div class="question">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="control-label">Question</label>
								<select name="question_id" class="form-control form-control-sm select2 employee_pin" required="">
									<option value="">Select Question</option>
									@foreach($followup_questions as $question)
									<option {{ ($editData->id == $question->id) ? "selected" : "" }} value="{{ $question->id }}">{{ $question->question }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="option_area">
							@foreach($editData->followup_question_option as $key => $option)
							<div class="form-row option">
								<div class="form-group col-md-3">
									<label class="control-label">Option</label>
									<input type="text" name="option[]" class="form-control form-control-sm" value="{{ $option->option }}" placeholder="Option">
								</div>
								<div class="form-group col-md-2" style="position: relative; top: 30px;">
									<i class="fa fa-plus btn  btn-info" onclick="add($(this));"></i>
									@if($key == 0)
	                                <i class="fa fa-minus btn btn-danger btn-remove d-none" data-type="delete" onclick="remove($(this));"></i>
	                                @else
	                                <i class="fa fa-minus btn btn-danger" data-type="delete" onclick="remove($(this));"></i>
	                                @endif
								</div>
							</div>
							@endforeach
							<div class="extra_option"></div>
						</div>
					</div>
					<div>
						<button type="submit" class="btn btn-success btn-sm">Submit</button>
						<button type="reset" class="btn btn-danger btn-sm">Reset</button>
					</div>
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

    function add(item)
    {
        var extra_option = item.closest('.option').clone();

        extra_option.find('.btn-remove').removeClass('d-none');
        extra_option.find('input, select').each(function() {
            $(this).val('');
        });

        item.closest('.option_area').find('.extra_option').append(extra_option);
    }

    function remove(item)
    {
        item.closest('.option').remove();
    }

</script>

@endsection