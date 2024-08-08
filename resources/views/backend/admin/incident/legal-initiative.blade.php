<div class="parent_div">
	<div class="form-row" style="display: none">
		<div class="col-sm-12 text-center">
			<strong><span style="margin-right: 10px;">Not Applicable</span></strong><input type="checkbox" name="case_applicable_status" value="1" {{(@$editIncident->case_applicable_status=='1')?'checked':''}} id="case_applicable_status" class="btn btn-info btn-sm">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-4">
			<label class="control-label">Legal initiative</label>
			<select name="case_status" id="case_status" class="form-control form-control-sm">
				<option value="">Select Legal initiative</option>
				<option value="Yes" {{(@$editIncident->case_status=="Yes")?"selected":""}}>Yes</option>
				<option value="Under Process" {{(@$editIncident->case_status=="Under Process")?"selected":""}}>Under Process</option>
				<option value="No" {{(@$editIncident->case_status=="No")?"selected":""}}>No</option>
				<option value="Resolved through local arbitration" {{(@$editIncident->case_status=="Resolved through local arbitration")?"selected":""}}>Resolved through local arbitration</option>
			</select>
		</div>
		@if(@$editIncident->thana_name!='')
		<div id="add_yes_case_status" style="width: 100%; display: block;">
		@else
		<div id="add_yes_case_status" style="width: 100%; display: none;">
		@endif
			<div class="row">
				<div class="form-group col-sm-3">
		    		<label class="control-label">Name of Thana</label>
		    		<input type="text" name="thana_name" value="{{@$editIncident->thana_name}}" class="form-control form-control-sm">
		    	</div>
		    	<div class="form-group col-sm-3">
		    		<label class="control-label">Name of the Court</label>
		    		<input type="text" name="court_name" value="{{@$editIncident->court_name}}" class="form-control form-control-sm">
		    	</div>
		    	<div class="form-group col-sm-3">
		    		<label class="control-label">Case/FIR/GD no.</label>
		    		<input type="text" name="case_no" value="{{@$editIncident->case_no}}" class="form-control form-control-sm">
		    	</div>
		    	<div class="form-group col-sm-3">
					<label class="control-label">Case/FIR/GD Date</label>
					<input type="text" name="case_filed_date" value="{{(!empty($editIncident->case_filed_date))?date('d-m-Y',strtotime(@$editIncident->violence_date)):''}}" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off">
				</div>
		    	<div class="col-sm-3">

		    	</div>
			</div>
		</div>
		@if(@$editIncident->not_filing_reason!='')
		<div id="add_no_case_status" style="width: 100%; display: block;">
		@else
		<div id="add_no_case_status" style="width: 100%; display: none;">
		@endif
			<div class="row">
				<div class="form-group col-sm-6">
		    		<label class="control-label">Reason of not filing a case against perpetrator</label>
		    		<select name="not_filing_reason" id="not_filing_reason" class="form-control form-control-sm">
						<option value="">Select Legel Initiative Reason</option>
						@foreach($legel_initiative_reasons as $mstatus)
						<option value="{{$mstatus->id}}" {{(@$editIncident->not_filing_reason==$mstatus->id)?"selected":""}}>{{$mstatus->name}}</option>
						@endforeach
					</select>
		    	</div>
			</div>
		</div>
		<div class="form-group col-sm-4" style="padding-top: 29px;">
			<input type="hidden" name="legal_info_save" value="legal_info_save">
			<button type="submit" id="legal_info_save" class="btn btn-primary btn-sm">Save</button>
		</div>
	</div>
</div>

@section('page_script')
<script type="text/javascript">
	$(function(){
		$(".not_filing_reason").select2({
		    placeholder: "Select a option"
		});
	})
</script>
@endsection