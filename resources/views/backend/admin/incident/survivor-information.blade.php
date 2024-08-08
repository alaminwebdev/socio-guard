<div class="parent_div">
	<div class="form-row" style="display: none">
		<div class="col-sm-12 text-center">
			<strong><span style="margin-right: 10px;">Not Applicable</span></strong><input type="checkbox" name="survivor_applicable_status" value="1" {{(@$editIncident->survivor_applicable_status=='1')?'checked':''}} id="survivor_applicable_status" class="btn btn-info btn-sm">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-3">
			<label class="control-label">Name</label>
			<input type="text" name="survivor_name" value="{{@$editIncident->survivor_name}}" class="form-control form-control-sm" required="">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Father's Name</label>
			<input type="text" name="survivor_father_name" value="{{@$editIncident->survivor_father_name}}" class="form-control form-control-sm">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Mother's Name</label>
			<input type="text" name="survivor_mother_name" value="{{@$editIncident->survivor_mother_name}}" class="form-control form-control-sm">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Husband's Name(If applicable)</label>
			<input type="text" name="survivor_husband_name" value="{{@$editIncident->survivor_husband_name}}" class="form-control form-control-sm">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Phone Number</label>
			<input type="number" name="survivor_mobile_no" value="{{@$editIncident->survivor_mobile_no}}" class="form-control form-control-sm" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "11">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Age</label>
			<!-- <input type="number" name="survivor_age" value="{{@$editIncident->survivor_age}}" class="form-control form-control-sm" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "3"> -->
			<select name="survivor_age" id="survivor_age" class="form-control form-control-sm select2" required="">
				@if(@$editIncident->survivor_age)
				<option value="{{@$editIncident->survivor_age}}">{{@$editIncident->survivor_age}}</option>
				@endif
				<option value="">Select Age</option>
				@php
                    $last_year = 0;
                    for($i = $last_year; $i <= 100; $i++){
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                @endphp
			</select>
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Gender</label>
			<select name="survivor_gender_id" id="survivor_gender_id" class="survivor_gender_id form-control form-control-sm" required="">
				<option value="">Select Gender</option>
				@foreach($genders as $gender)
				<option value="{{$gender->id}}" {{(@$editIncident->survivor_gender_id==$gender->id)?"selected":""}}>{{$gender->name}}</option>
				@endforeach
				<option value="0" {{(@$editIncident->survivor_gender_id=='0')?"selected":""}}>Others(specify)</option>
			</select>
			@if(@$editIncident->survivor_gender_id=='0')
				<input type="text" name="survivor_others_gender" value="{{@$editIncident->survivor_others_gender}}" class="form-control form-control-sm survivor_others_gender" placeholder="Write Gender" id="survivor_others_gender" style="display: block;">
			@else
				<input type="text" name="survivor_others_gender" value="{{@$editIncident->survivor_others_gender}}" class="form-control form-control-sm survivor_others_gender" placeholder="Write Gender" id="survivor_others_gender" style="display: none">
			@endif
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Religion</label>
			<select name="survivor_religion_id" id="survivor_religion_id" class="survivor_religion_id form-control form-control-sm">
				<option value="">Select Religion</option>
				@foreach($religions as $religion)
				<option value="{{$religion->id}}" {{(@$editIncident->survivor_religion_id==$religion->id)?"selected":""}}>{{$religion->name}}</option>
				@endforeach
				<option value="0" {{(@$editIncident->survivor_religion_id=='0')?"selected":""}}>Others(specify)</option>
			</select>
			@if(@$editIncident->survivor_religion_id=='0')
				<input type="text" name="survivor_others_religion" value="{{@$editIncident->survivor_others_religion}}" class="form-control form-control-sm survivor_others_religion" placeholder="Write Religion" id="survivor_others_religion" style="display: block;">
			@else
				<input type="text" name="survivor_others_religion" value="{{@$editIncident->survivor_others_religion}}" class="form-control form-control-sm survivor_others_religion" placeholder="Write Religion" id="survivor_others_religion" style="display: none">
			@endif
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Marital Status</label>
			<select name="survivor_marital_status_id" id="marital_status_id" class="marital_status_id form-control form-control-sm" required="">
				<option value="">Select Status</option>
				@foreach($marital_statuses as $mstatus)
				<option value="{{$mstatus->id}}" {{(@$editIncident->survivor_marital_status_id==$mstatus->id)?"selected":""}}>{{$mstatus->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Economic Condition</label>
			<!-- <input type="text" name="survivor_monthly_income" value="{{@$editIncident->survivor_monthly_income}}" class="form-control form-control-sm"> -->
			<select name="survivor_monthly_income" id="survivor_monthly_income" class="form-control form-control-sm">
				<option value="">Select Economic Condition</option>
				<option value="Poor" {{(@$editIncident->survivor_monthly_income=="Poor")?"selected":""}}>Poor</option>
				<option value="Hard Core Poor" {{(@$editIncident->survivor_monthly_income=="Hard Core Poor")?"selected":""}}>Hard Core Poor</option>
				<option value="Middle Class" {{(@$editIncident->survivor_monthly_income=="Middle Class")?"selected":""}}>Middle Class</option>
			</select>
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">NID (If applicable)</label>
			<input type="number" name="survivor_nid" value="{{@$editIncident->survivor_nid}}" class="form-control form-control-sm" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "16">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Birth Registration No.</label>
			<input type="text" name="survivor_birth_registration_no" value="{{@$editIncident->survivor_birth_registration_no}}" class="form-control form-control-sm" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "20">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Occupation</label>
			<select name="survivor_occupation_id" id="occupation_id" class="form-control form-control-sm" required="">
				<option value="">Select Occupation</option>
				@foreach($occupations as $occupation)
				<option value="{{$occupation->id}}" {{(@$editIncident->survivor_occupation_id==$occupation->id)?"selected":""}}>{{$occupation->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-sm-3">
				@php
					$allOrganzation = @$editIncident->survivor_organization_type_id;
					$orgArray = explode(',', $allOrganzation);
					// echo "<pre>"; print_r($orgArray); exit();
				@endphp
			<label class="control-label">Organization Affiliation <small style="color:green;">Click Here</small></label>
			<select name="survivor_organization_type_id[]" id="organization_type_id" class="organization_type_id form-control form-control-sm select2" multiple="" required="">
				@foreach($organization_types as $otype)
				<option value="{{$otype->id}}" {{(@$orgArray)?((in_array($otype->id, $orgArray))?("selected"):""):''}}>{{$otype->name}}</option>
				@endforeach
			</select>
		</div>

		<!-- <div class="form-group col-sm-2">
			<label class="control-label">Organization Name</label>
			<select name="survivor_organization_name_id" id="organization_name_id" class="organization_name_id form-control form-control-sm">
				<option value="">Select Orgnaization Name</option>
				<?php echo getorganizationname($organization_type_id=@$editIncident->survivor_organization_type_id,$selected_organization_name_id=@$editIncident->survivor_organization_name_id)?>
			</select>
		</div> -->

		<div class="form-group col-sm-3">
			<label class="control-label">Place of the incidents</label>
			<select name="survivor_incident_place_id" id="survivor_incident_place_id" class="survivor_incident_place_id form-control form-control-sm" required="">
				<option value="">Select Place</option>
				@foreach($survivor_place as $place)
				<option value="{{$place->id}}" {{(@$editIncident->survivor_incident_place_id==$place->id)?"selected":""}}>{{$place->name}}</option>
				@endforeach
				<option value="0" {{(@$editIncident->survivor_incident_place_id=='0')?"selected":""}}>Others(specify)</option>
			</select>
				@if(@$editIncident->survivor_incident_place_id=='0')
				<input type="text" name="survivor_others_incident_place" value="{{@$editIncident->survivor_others_incident_place}}" class="form-control form-control-sm survivor_others_incident_place" placeholder="Write Place" id="survivor_others_incident_place" style="display: block;">
				@else
				<input type="text" name="survivor_others_incident_place" value="{{@$editIncident->survivor_others_incident_place}}" class="form-control form-control-sm survivor_others_incident_place" placeholder="Write Place" id="survivor_others_incident_place" style="display: none">
				@endif
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Disability Status</label>
			<select name="survivor_autistic_id" id="survivor_autistic_id" class="survivor_autistic_id form-control form-control-sm" required="">
				<option value="">Select Disability</option>
				@foreach($challenges as $challenge)
				<option value="{{$challenge->id}}" {{(@$editIncident->survivor_autistic_id==$challenge->id)?"selected":""}}>{{$challenge->name}}</option>
				@endforeach
				<option value="0" {{(@$editIncident->survivor_autistic_id=='0')?"selected":""}}>Others(specify)</option>
			</select>
			@if(@$editIncident->survivor_autistic_id=='0')
				<input type="text" name="survivor_others_autistic" value="{{@$editIncident->survivor_others_autistic}}" class="form-control form-control-sm survivor_others_autistic" placeholder="Write Autistic" id="survivor_others_autistic" style="display: block;">
			@else
				<input type="text" name="survivor_others_autistic" value="{{@$editIncident->survivor_others_autistic}}" class="form-control form-control-sm survivor_others_autistic" placeholder="Write Autistic" id="survivor_others_autistic" style="display: none">
			@endif
		</div>
		<!-- <div class="col-sm-2">
			<label class="control-label">Image</label>
			<input type="file" id="survivor_image" name="survivor_image" class="form-control form-control-sm">
		</div>
		<div class="col-sm-1" style="max-width: 75px;max-height: 105px">
			<img id="showImage" src="{{(@$editIncident->survivor_image) ? (url('backend/images/survivor_images/'.$editIncident->survivor_image)): url('backend/images/noimage.png')}}" style="height: 105px; width: 75px;max-width: 105px;padding-bottom: 10px;">
		</div> -->
		<div class="form-group col-sm-12" style="margin-top: -12px;margin-bottom: -12px;">
			<p><strong><u>Address:</u></strong></p>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Division</label>
			<select name="survivor_division_id" id="division_id" class="division_id form-control form-control-sm" required="">
				<option value="">Select Division</option>
				@foreach($divisions as $d)
				<option value="{{$d->id}}" {{(@$editIncident->survivor_division_id==$d->id)?"selected":""}}>{{$d->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">District</label>
			<select name="survivor_district_id" id="district_id" class="district_id form-control form-control-sm" required="">
				<?php echo getdistrict($division_id=@$editIncident->survivor_division_id,$selected_district_id=@$editIncident->survivor_district_id)?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Upazila</label>
			<select name="survivor_upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
				<?php echo getupazila($district_id=@$editIncident->survivor_district_id,$selected_upazila_id=@$editIncident->survivor_upazila_id)?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Union</label>
			<select name="survivor_union_id" id="union_id" class="union_id form-control form-control-sm">
				<?php echo getunion($upazila_id=@$editIncident->survivor_upazila_id,$selected_union_id=@$editIncident->survivor_union_id)?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Village</label>
			<input type="text" name="survivor_village" value="{{@$editIncident->survivor_village}}" class="form-control form-control-sm" placeholder="Village Name">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">House</label>
			<input type="text" name="survivor_house" value="{{@$editIncident->survivor_house}}" class="form-control form-control-sm">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Road</label>
			<input type="text" name="survivor_road" value="{{@$editIncident->survivor_road}}" class="form-control form-control-sm">
		</div>
		<div class="form-group col-sm-2" style="padding-top: 29px;">
			<input type="hidden" name="survivor_info_save" value="survivor_info_save">
			<button type="submit" id="survivor_info_save" class="btn btn-primary btn-sm">Save</button>
		</div>
	</div>
</div>