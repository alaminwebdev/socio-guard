<div class="parent_div">
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label class="control-label">Name</label>
			<input type="text" name="employee_name" value="{{(@$editIncident)?($editIncident->employee_name):Auth::user()->name}}" id="employee_name" class="form-control form-control-sm" readonly="">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Cell</label>
			<input type="text" name="employee_mobile_number" value="{{(@$editIncident)?($editIncident->employee_mobile_number):Auth::user()->mobile}}" id="employee_mobile_number" class="form-control form-control-sm" readonly="">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Designation</label>
			<input type="text" name="employee_designation" value="{{(@$editIncident)?($editIncident->employee_designation):Auth::user()->designation}}" id="employee_designation" class="form-control form-control-sm" readonly="">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Pin</label>
			<input type="text" name="employee_pin" value="{{(@$editIncident)?($editIncident->employee_pin):Auth::user()->pin}}" id="employee_pin" class="form-control form-control-sm" readonly="">
		</div>
		<!-- <div class="form-group col-sm-2">
			<label class="control-label">Signature</label>
			<input type="file" name="employee_signature" id="employee_signature" class="form-control form-control-sm">
		</div> -->
		<div class="form-group col-sm-12" style="margin-top: -12px;margin-bottom: -12px;">
			<p><strong><u>Address:</u></strong></p>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Division</label>
			<select name="employee_division_id" id="division_id" class="division_id form-control form-control-sm">
				<option value="">Select Division</option>
				@foreach($divisions as $d)
				<option value="{{$d->id}}" {{(@$editIncident->employee_division_id==$d->id)?"selected":""}}>{{$d->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">District</label>
			<select name="employee_district_id" id="district_id" class="district_id form-control form-control-sm">
				<option value="">Select District</option>
				<?php echo getdistrict($division_id=@$editIncident->employee_division_id,$selected_district_id=@$editIncident->employee_district_id)?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Upazila</label>
			<select name="employee_upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
				<option value="">Select Upazila</option>
				<?php echo getupazila($district_id=@$editIncident->employee_district_id,$selected_upazila_id=@$editIncident->employee_upazila_id)?>
			</select>
		</div>
		<div class="form-group col-sm-2" style="padding-top: 29px;">
			<input type="hidden" name="info_sender_save" value="info_sender_save">
			<button type="submit" id="info_sender_save" class="btn btn-primary btn-sm">Save</button>
		</div>
	</div>
</div>