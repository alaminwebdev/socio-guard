@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Violence/Incident Support Management</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Support</li>
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
					Update Brac Support
					@else
					Add Violence/Incident Support
					@endif
					<a class="btn btn-sm btn-success float-right" href="{{route('support.barck.manage.view')}}"><i class="fa fa-list"></i> Violence/Incident Support List</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editIncident->id)?route('support.barck.manage.store',$editIncident->id):''}}" id="survivorSupportForm" class="survivorSupportForm">
				{{csrf_field()}}
				<div class="card-body">
					@include('backend.admin.incident.survivor-support')
		            <div class="form-group col-sm-4">
						<button type="submit" class="btn btn-primary btn-sm">Submit</button>
					</div>
				</div>
			</form>
			<!--Form End-->
		</div>
	</div>
</div>
<!-- extra html -->

<!--Extra Brac Support-->
<div style="display: none;">
	<div class="whole_extra_support_item_add" id="whole_extra_support_item_add">
		<div class="delete_whole_extra_support_item_add" id="delete_whole_extra_support_item_add">
			<hr style="background: #000000;padding: 1px;text-align: left;width: 71%;margin-left: 0px;">
			<div class="form-row">
				<div class="form-group col-sm-3">
					<div class="check_brac_support">
						<label class="control-label">Support Name</label>
						<select name="survivor_final_support_id[]" id="survivor_final_support_id" class="survivor_final_support_id form-control form-control-sm">
							<option value="">Select Support</option>
							@foreach($brac_support as $brac)
							<option value="{{$brac->id}}" >{{$brac->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Programs Name</label>
					<select name="brac_program_id[]" id="brac_program_id" class="brac_program_id form-control form-control-sm">
						<option value="">Select Program</option>
						@foreach($programs as $p)
						<option value="{{$p->id}}">{{$p->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Date</label>
					<input type="text" name="survivor_support_date[]" value="" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off">
				</div>
				<div class="form-group col-sm-1" style="padding-top: 29px;">
					<div class="form-row">
						<i class="btn btn-success fa fa-plus-circle addSupportEvent"></i>
						<i class="btn btn-danger fa fa-minus-circle removeSupportEvent"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!--Extra Other Support-->
<div style="display: none;">
	<div class="whole_extra_other_support_item_add" id="whole_extra_other_support_item_add">
		<div class="delete_whole_extra_other_support_item_add" id="delete_whole_extra_other_support_item_add">
			<hr style="background: #000000;padding: 1px;text-align: left;width: 71%;margin-left: 0px;">
			<div class="form-row">
				<div class="form-group col-sm-3">
					<div class="check_brac_support">
						<label class="control-label">Other Support Name</label>
						<select name="survivor_final_support_other_id[]" id="survivor_final_support_other_id" class="survivor_final_support_other_id form-control form-control-sm">
							<option value="">Select Support</option>
							@foreach($other_support as $other)
							<option value="{{$other->id}}" >{{$other->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Other Program Name</label>
					<input type="text" name="other_program[]" class="form-control form-control-sm" placeholder="Write Other Programs">
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Date</label>
					<input type="text" name="survivor_other_support_date[]" value="" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off">
				</div>
				<div class="form-group col-sm-1" style="padding-top: 29px;">
					<div class="form-row">
						<i class="btn btn-success fa fa-plus-circle addOtherEvent"></i>
						<i class="btn btn-danger fa fa-minus-circle removeOtherEvent"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@if(@$editIncident)
	<script type="text/javascript">
		$(document).ready(function(){
			$('.removeeventmore:not(:first)').addClass('btn btn-danger fa fa-minus-circle ');
			$('.removeSupportEvent:not(:first)').addClass('btn btn-danger fa fa-minus-circle ');
			$('.removeOtherEvent:not(:first)').addClass('btn btn-danger fa fa-minus-circle ');
		});
	</script>
@endif

<!-- extra_add_brac_support_item -->
<script type="text/javascript">
    $(document).ready(function () {
        var counter = 0;

        $(document).on("click",".addSupportEvent", function () {
            var whole_extra_support_item_add = $("#whole_extra_support_item_add").html();
            $(this).closest(".add_support_item").append(whole_extra_support_item_add);
            counter++;
            $('.singledatepicker').daterangepicker({
				singleDatePicker: true,
				showDropdowns: false,
				autoUpdateInput: false,
			      // drops: "up",
			      autoApply:true,
			      locale: {
			      	format: 'YYYY-MM-SS',
			      	daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
			      	firstDay: 0
			      },
			      minDate: '01-01-1930',
			      // maxDate: new Date(),
			  },
			  function(start) {
			  	this.element.val(start.format('DD-MM-YYYY'));
			  	this.element.parent().parent().removeClass('has-error');
			  },
			  function(chosen_date) {
			  	this.element.val(chosen_date.format('DD-MM-YYYY'));
			  });
        });

        $(document).on("click", ".removeSupportEvent", function (event) {
            $(this).closest(".delete_whole_extra_support_item_add").remove();
            counter -= 1
        });
    });
</script>

<!-- extra_add_other_support_item -->
<script type="text/javascript">
    $(document).ready(function () {
        var counter = 0;

        $(document).on("click",".addOtherEvent", function () {
            var whole_extra_other_support_item_add = $("#whole_extra_other_support_item_add").html();
            $(this).closest(".add_other_support_item").append(whole_extra_other_support_item_add);
            counter++;
            $('.singledatepicker').daterangepicker({
				singleDatePicker: true,
				showDropdowns: false,
				autoUpdateInput: false,
			      // drops: "up",
			      autoApply:true,
			      locale: {
			      	format: 'YYYY-MM-SS',
			      	daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
			      	firstDay: 0
			      },
			      minDate: '01-01-1930',
			      // maxDate: new Date(),
			  },
			  function(start) {
			  	this.element.val(start.format('DD-MM-YYYY'));
			  	this.element.parent().parent().removeClass('has-error');
			  },
			  function(chosen_date) {
			  	this.element.val(chosen_date.format('DD-MM-YYYY'));
			  });
        });

        $(document).on("click", ".removeOtherEvent", function (event) {
            $(this).closest(".delete_whole_extra_other_support_item_add").remove();
            counter -= 1
        });
    });
</script>

<script>
    $(document).ready(function(){
    	$('#survivorSupportForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	        	// 'survivor_support_date' : {
	         //        required : true,
	         //    },
	         //    'survivor_final_support_id[]' : {
	         //        required : true,
	         //    },
	         //    'brac_program_id[]' : {
	         //        required : true,
	         //    },
	         //    'brack_support_descriptin' : {
	         //        required : true,
	         //    },
	         //    'survivor_final_support_other_id[]' : {
	         //        required : true,
	         //    },
	         //    'other_program[]' : {
	         //        required : true,
	         //    },
	         //    'other_organization_support_description' : {
	         //        required : true,
	         //    },
	        },
	        messages : {

	        }
	    });

    });
</script>

@endsection