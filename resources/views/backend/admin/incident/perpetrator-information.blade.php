<div class="add_item">
	<div class="form-row" style="display: none">
		<div class="col-sm-12 text-center">
			<strong><span style="margin-right: 10px;">Not Applicable</span></strong><input type="checkbox" name="perpetrator_applicable_status" value="1" {{(@$editIncident['perpetrator_info']['0']['perpetrator_applicable_status']=='1')?'checked':''}} id="perpetrator_applicable_status" class="btn btn-info btn-sm">
		</div>
	</div>
		<div class="delete_whole_extra_item_add parent_div" id="delete_whole_extra_item_add">
			<div class="form-row">
				<div class="form-group col-sm-3">
					<label class="control-label">Name</label>
					<input type="text" name="perpetrator_name" value="{{@$editIncident->perpetrator_name}}" class="form-control form-control-sm">
				</div>
				<div class="form-group col-sm-2">
					<label class="control-label">Marital Status</label>
					<select name="perpetrator_marital_status_id" id="marital_status_id" class="marital_status_id form-control form-control-sm">
						<option value="">Select Status</option>
						@foreach($marital_statuses as $mstatus)
						<option value="{{$mstatus->id}}" {{(@$editIncident->perpetrator_marital_status_id==$mstatus->id)?"selected":""}}>{{$mstatus->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-2">
					<label class="control-label">Gender</label>
					<select name="perpetrator_gender_id" id="perpetrator_gender_id" class="perpetrator_gender_id form-control form-control-sm">
						<option value="">Select Gender</option>
						@foreach($genders as $gender)
						<option value="{{$gender->id}}" {{(@$editIncident->perpetrator_gender_id==$gender->id)?"selected":""}}>{{$gender->name}}</option>
						@endforeach
						<option value="0" {{(@$editIncident->perpetrator_gender_id=='0')?"selected":""}}>Others(specify)</option>
					</select>
					@if(@$editIncident->perpetrator_gender_id=='0')
						<input type="text" name="perpetrator_others_gender" value="{{@$editIncident->perpetrator_others_gender}}" class="form-control form-control-sm perpetrator_others_gender" placeholder="Write Gender" id="perpetrator_others_gender" style="display: block;">
					@else
						<input type="text" name="perpetrator_others_gender" value="{{@$editIncident->perpetrator_others_gender}}" class="form-control form-control-sm perpetrator_others_gender" placeholder="Write Gender" id="perpetrator_others_gender" style="display: none">
					@endif
				</div>
				<div class="form-group col-sm-2">
					<label class="control-label">Age</label>
					<!-- <input type="number" name="perpetrator_age" value="{{@$editIncident->perpetrator_age}}" class="form-control form-control-sm" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "3"> -->
					<select name="perpetrator_age" id="perpetrator_age" class="form-control form-control-sm select2">
						@if(@$editIncident->perpetrator_age)
						<option value="{{@$editIncident->perpetrator_age}}">{{@$editIncident->perpetrator_age}}</option>
						@endif
						<option value="">Select Age</option>
						@php
		                    $last_year = 100;
		                    for($i = $last_year; $i >= 0; $i--){
		                        echo '<option value="'.$i.'">'.$i.'</option>';
		                    }
		                @endphp
					</select>
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Current Place of perpetrators</label>
					<select name="perpetrator_place_id" id="perpetrator_place_id" class="perpetrator_current_place_id form-control form-control-sm">
						<option value="">Select Place</option>
						@foreach($perpetrator_place as $place)
						<option value="{{$place->id}}" {{(@$editIncident->perpetrator_place_id==$place->id)?"selected":""}}>{{$place->name}}</option>
						@endforeach
						<option value="0" {{(@$editIncident->perpetrator_place_id=='0')?"selected":""}}>Others(specify)</option>
					</select>
					@if(@$editIncident->perpetrator_place_id=='0')
						<input type="text" name="perpetrator_others_place" value="{{@$editIncident->perpetrator_others_place}}" class="form-control form-control-sm perpetrator_others_place" placeholder="Write Place" id="perpetrator_others_place" style="display: block;">
					@else
						<input type="text" name="perpetrator_others_place" value="{{@$editIncident->perpetrator_others_place}}" class="form-control form-control-sm perpetrator_others_place" placeholder="Write Place" id="perpetrator_others_place" style="display: none">
					@endif
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Occupation</label>
					<select name="perpetrator_occupation_id" id="occupation_id" class="occupation_id form-control form-control-sm">
						<option value="">Select Occupation</option>
						@foreach($occupations as $occupation)
						<option value="{{$occupation->id}}" {{(@$editIncident->perpetrator_occupation_id==$occupation->id)?"selected":""}}>{{$occupation->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">No. of Perpetrator</label>
					<input type="text" name="no_of_perpetrator" value="{{@$editIncident->no_of_perpetrator}}" class="form-control form-control-sm">
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label" style="font-size: 12px;">Survivors and perpetrators Relationship</label>
					<select name="perpetrator_relationship_id" id="perpetrator_relationship_id" class="perpetrator_relationship_id form-control form-control-sm">
						<option value="">Select Relationship</option>
						@foreach($survivor_relationships as $relation)
						<option value="{{$relation->id}}" {{(@$editIncident->perpetrator_relationship_id==$relation->id)?"selected":""}}>{{$relation->name}}</option>
						@endforeach
						<option value="0" {{(@$editIncident->perpetrator_relationship_id=='0')?"selected":""}}>Others(specify)</option>
					</select>
					@if(@$editIncident->perpetrator_relationship_id=='0')
						<input type="text" name="perpetrator_others_relationship" value="{{@$editIncident->perpetrator_others_relationship}}" class="form-control form-control-sm perpetrator_others_relationship" placeholder="Write Other Relationship" id="perpetrator_others_relationship" style="display: block;">
					@else
						<input type="text" name="perpetrator_others_relationship" value="{{@$editIncident->perpetrator_others_relationship}}" class="form-control form-control-sm perpetrator_others_relationship" placeholder="Write Other Relationship" id="perpetrator_others_relationship" style="display: none">
					@endif
				</div>
				<div class="form-group col-sm-3">
					<div class="add_perpetrator_family_member_id" style="display: none;">
						<label class="control-label">If perpetrator is family member</label>
						<select name="perpetrator_family_member_id[]" id="perpetrator_family_member_id" class="perpetrator_family_member_id form-control form-control-sm select2" multiple="multiple">
							<option value="">Select Family Member</option>
							@foreach($family_members as $member)
							<option value="{{$member->id}}" {{(in_array($member->id,explode(',',@$editIncident->perpetrator_family_member_id)) == true)?("selected"):""}}>{{$member->name}}</option>
							@endforeach
							<option value="0" {{(@$editIncident->perpetrator_family_member_id=='0')?"selected":""}}>Others(specify)</option>
						</select>
						@if(@$editIncident->perpetrator_family_member_id=='0')
							<input type="text" name="perpetrator_others_family_member" value="{{@$editIncident->perpetrator_others_family_member}}" class="form-control form-control-sm perpetrator_others_family_member" placeholder="Write Other Family Member" id="perpetrator_others_family_member" style="display: block;">
						@else
							<input type="text" name="perpetrator_others_family_member" value="{{@$editIncident->perpetrator_others_family_member}}" class="form-control form-control-sm perpetrator_others_family_member" placeholder="Write Other Family Member" id="perpetrator_others_family_member" style="display: none">
						@endif
					</div>
				</div>
				{{-- <div class="form-group col-sm-3">
					<label class="control-label">Religion</label>
					<select name="perpetrator_religion_id" id="perpetrator_religion_id" class="form-control form-control-sm">
						<option value="">Select Religion</option>
						@foreach($religions as $religion)
						<option value="{{$religion->id}}" {{(@$editIncident->perpetrator_religion_id==$religion->id)?"selected":""}}>{{$religion->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Social Status</label>
					<select name="perpetrator_social_status_id" id="perpetrator_social_status_id" class="form-control form-control-sm">
						<option value="">Select Social Status</option>
						@foreach($social_statuses as $social)
						<option value="{{$social->id}}" {{(@$editIncident->perpetrator_social_status_id==$social->id)?"selected":""}}>{{$social->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Economic Condition</label>
					<select name="perpetrator_economic_condition_id" id="perpetrator_economic_condition_id" class="form-control form-control-sm">
						<option value="">Select Economic Condition</option>
						@foreach($economic_conditions as $economic)
						<option value="{{$economic->id}}" {{(@$editIncident->perpetrator_economic_condition_id==$economic->id)?"selected":""}}>{{$economic->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-6">
					<label class="control-label">Was there any previous enmity between survivor & oppressor</label>
					<select name="perpetrator_previous_enmity_status" id="perpetrator_previous_enmity_status" class="perpetrator_previous_enmity_status form-control form-control-sm">
						<option value="">Select previous enmity</option>
						<option value="Yes" {{(@$editIncident->perpetrator_previous_enmity_status=="Yes")?"selected":""}}>Yes</option>
						<option value="No" {{(@$editIncident->perpetrator_previous_enmity_status=="No")?"selected":""}}>No</option>
					</select>
				</div> --}}

				<div class="form-group col-sm-12" style="margin-top: -12px;margin-bottom: -12px;">
					<p><strong><u>Address:</u></strong></p>
				</div>
				<div class="form-group col-md-3">
					<label class="control-label">Division</label>
					<select name="perpetrator_division_id" id="division_id" class="division_id form-control form-control-sm">
						<option value="">Select Division</option>
						@foreach($divisions as $d)
						<option value="{{$d->id}}" {{(@$editIncident->perpetrator_division_id==$d->id)?"selected":""}}>{{$d->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-md-3">
					<label class="control-label">District</label>
					<select name="perpetrator_district_id" id="district_id" class="district_id form-control form-control-sm">
						<?php echo getdistrict($division_id=@$editIncident->perpetrator_division_id,$selected_district_id=@$editIncident->perpetrator_district_id)?>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label class="control-label">Upazila</label>
					<select name="perpetrator_upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
						<?php echo getupazila($district_id=@$editIncident->perpetrator_district_id,$selected_upazila_id=@$editIncident->perpetrator_upazila_id)?>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label class="control-label">Union</label>
					<select name="perpetrator_union_id" id="union_id" class="union_id form-control form-control-sm">
						<?php echo getunion($upazila_id=@$editIncident->perpetrator_upazila_id,$selected_union_id=@$editIncident->perpetrator_union_id)?>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label class="control-label">Village</label>
					<input type="text" name="perpetrator_village" id="name" class="form-control form-control-sm" value="{{@$editIncident->perpetrator_village}}" placeholder="Village Name">
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">House</label>
					<input type="text" name="perpetrator_house" value="{{@$editIncident->perpetrator_house}}" class="form-control form-control-sm">
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Road</label>
					<input type="text" name="perpetrator_road" value="{{@$editIncident->perpetrator_road}}" class="form-control form-control-sm">
				</div>
				<!-- <div class="form-group col-sm-1" style="padding-top: 29px;">
					<div class="form-row">
						<i class="btn btn-success fa fa-plus-circle addeventmore"></i>
						<i class="removeeventmore"></i>
					</div>
				</div> -->
				<div class="form-group col-sm-2" style="padding-top: 29px;">
					<button type="submit" class="btn btn-primary btn-sm block">Save</button>
				</div>
			</div>
		</div>
</div>