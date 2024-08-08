<div class="parent_div">
	<div class="form-row">
		<div class="col-sm-12 text-center">
			<strong><span style="margin-right: 10px;">Not Applicable</span></strong><input type="checkbox" name="provider_applicable_status" value="1" {{(@$editIncident->provider_applicable_status=='1')?'checked':''}} id="provider_applicable_status" class="btn btn-info btn-sm">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-12">
			<!-- Default inline 1-->
			<div class="custom-control custom-radio custom-control-inline">
			  <input type="radio" class="custom-control-input information_provider_value" id="defaultInline1" name="provider" value="1" {{(@$editIncident->provider==1)?"checked":""}}>
			  <label class="custom-control-label" for="defaultInline1">Individual</label>
			</div>

			<!-- Default inline 2-->
			<div class="custom-control custom-radio custom-control-inline">
			  <input type="radio" class="custom-control-input information_provider_value" id="defaultInline2" name="provider" value="2" {{(@$editIncident->provider==2)?"checked":""}}>
			  <label class="custom-control-label" for="defaultInline2">Source</label>
			</div>
		</div>
	</div>
	@if(@$editIncident->provider == 1)
	<div class="form-row show_provider_name_wise">
	@else
	<div class="form-row show_provider_name_wise" style="display: none;">
	@endif
		<div class="form-group col-sm-4">
			<label class="control-label">Name</label>
			<input type="text" name="provider_name" class="provider_source_id form-control form-control-sm" placeholder="Write Provider Name" value="{{@$editIncident->provider_name}}">
		</div>
		<div class="form-group col-sm-4">
			<label class="control-label">Phone Number</label>
			<input type="number" name="provider_mobile_no" id="provider_mobile_no" value="{{@$editIncident->provider_mobile_no}}" class="provider_mobile_no form-control form-control-sm" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength = "11">
		</div>
		<!-- <div class="form-group col-sm-4">
			<label class="control-label">Organization Type</label>
			<select name="provider_organization_type_id" id="organization_type_id" class="organization_type_id form-control form-control-sm">
				<option value="">Select Orgnaization Type</option>
				@foreach($organization_types as $otype)
				<option value="{{$otype->id}}" {{(@$editIncident->provider_organization_type_id==$otype->id)?"selected":""}}>{{$otype->name}}</option>
				@endforeach
			</select>
		</div> -->
		<div class="form-group col-sm-4">
			<label class="control-label">Platform</label>
			<select name="provider_organization_name_id" id="organization_name_id" class="organization_name_id form-control form-control-sm">
				<option value="">Select Platform</option>
				@foreach($organization_names as $oname)
				<option value="{{$oname->id}}" {{(@$editIncident->provider_organization_name_id==$oname->id)?"selected":""}}>{{$oname->name}}</option>
				@endforeach
			</select>
		</div>
		<!-- <div class="form-group col-sm-4">
			<label class="control-label">Organization Name</label>
			<select name="provider_organization_name_id" id="organization_name_id" class="organization_name_id form-control form-control-sm">
				<option value="">Select Orgnaization Name</option>
				<?php echo getorganizationname($support_organization_id=@$editIncident->provider_organization_type_id,$selected_organization_name_id=@$editIncident->provider_organization_name_id)?>
			</select>
		</div> -->
		<div class="form-group col-sm-4">
			<label class="control-label">Gender</label>
			<select name="provider_gender_id" id="provider_gender_id" class="provider_gender_id form-control form-control-sm">
				<option value="">Select Gender</option>
				@foreach($genders as $gender)
				<option value="{{$gender->id}}" {{(@$editIncident->provider_gender_id==$gender->id)?"selected":""}}>{{$gender->name}}</option>
				@endforeach
				<option value="0" {{(@$editIncident->provider_gender_id=='0')?"selected":""}}>Others(specify)</option>
			</select>
				@if(@$editIncident->provider_gender_id=='0')
					<input type="text" name="provider_others_gender" value="{{@$editIncident->provider_others_gender}}" class="form-control form-control-sm provider_others_gender" placeholder="Write Gender" id="provider_others_gender" style="display: block;">
				@else
					<input type="text" name="provider_others_gender" value="{{@$editIncident->provider_others_gender}}" class="form-control form-control-sm provider_others_gender" placeholder="Write Gender" id="provider_others_gender" style="display: none;">
				@endif
		</div>
		<div class="form-group col-sm-4">
			<label class="control-label">Relationship with Survivors</label>
			<select name="provider_relationship_id" id="provider_relationship_id" class="provider_relationship_id form-control form-control-sm">
				<option value="">Select Relationship</option>
				@foreach($survivor_relationships as $relation)
				<option value="{{$relation->id}}" {{(@$editIncident->provider_relationship_id==$relation->id)?"selected":""}}>{{$relation->name}}</option>
				@endforeach
				<option value="0" {{(@$editIncident->provider_relationship_id=='0')?"selected":""}}>Others(specify)</option>
				@if(@$editIncident->provider_relationship_id=='0')
					<input type="text" name="provider_other_relationship" value="{{@$editIncident->provider_other_relationship}}" class="provider_other_relationship form-control form-control-sm" placeholder="Write Other Relationship" id="provider_other_relationship" style="display: block;">
				@else
					<input type="text" name="provider_other_relationship" value="{{@$editIncident->provider_other_relationship}}" class="provider_other_relationship form-control form-control-sm" placeholder="Write Other Relationship" id="provider_other_relationship" style="display: none;">
				@endif
			</select>
		</div>
		<div class="form-group col-sm-12" style="margin-top: -12px;margin-bottom: -12px;">
			<p><strong><u>Address:</u></strong></p>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Division</label>
			<select name="provider_division_id" id="division_id" class="division_id form-control form-control-sm">
				<option value="">Select Division</option>
				@foreach($divisions as $d)
				<option value="{{$d->id}}" {{(@$editIncident->provider_division_id==$d->id)?"selected":""}}>{{$d->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">District</label>
			<select name="provider_district_id" id="district_id" class="district_id form-control form-control-sm">
				<?php echo getdistrict($division_id=@$editIncident->provider_division_id,$selected_district_id=@$editIncident->provider_district_id)?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Upazila</label>
			<select name="provider_upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
				<?php echo getupazila($district_id=@$editIncident->provider_district_id,$selected_upazila_id=@$editIncident->provider_upazila_id)?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Union</label>
			<select name="provider_union_id" id="union_id" class="union_id form-control form-control-sm">
				<?php echo getunion($upazila_id=@$editIncident->provider_upazila_id,$selected_union_id=@$editIncident->provider_union_id)?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Village</label>
			<input type="text" name="provider_village" id="name" class="form-control form-control-sm" value="{{@$editIncident->provider_village}}" placeholder="Village Name">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">House</label>
			<input type="text" name="provider_house" value="{{@$editIncident->provider_house}}" class="form-control form-control-sm">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Road</label>
			<input type="text" name="provider_road" value="{{@$editIncident->provider_road}}" class="form-control form-control-sm">
		</div>
	</div>
	@if(@$editIncident->provider == 2)
	<div class="form-row show_provider_sourse_wise">
	@else
	<div class="form-row show_provider_sourse_wise" style="display: none;">
	@endif
		<div class="form-group col-sm-4">
			<label class="control-label">Source</label>
			<select name="provider_source_id" id="provider_source_id" class="provider_source_id form-control form-control-sm">
				<option value="">Select Source</option>
				@foreach($sources as $sr)
				<option value="{{$sr->id}}" {{(@$editIncident->provider_source_id==$sr->id)?"selected":""}}>{{$sr->name}}</option>
				@endforeach
				<option value="0" {{(@$editIncident->provider_source_id=='0')?"selected":""}}>Others(specify)</option>
			</select>
			@if(@$editIncident->provider_source_id=='0')
				<input type="text" name="provider_other_source" value="{{@$editIncident->provider_other_source}}" class="provider_other_source form-control form-control-sm" placeholder="Write Other Source" id="provider_other_source" style="display: block;">
			@else
				<input type="text" name="provider_other_source" value="{{@$editIncident->provider_other_source}}" class="provider_other_source form-control form-control-sm" placeholder="Write Other Source" id="provider_other_source" style="display: none;">
			@endif
		</div>
		<div class="form-group col-sm-4">
			<label class="control-label">Name of Source</label>
			<input type="text" name="source_name" class="provider_source_id form-control form-control-sm" placeholder="Write Provider Name" value="{{@$editIncident->source_name}}">
		</div>
		<div class="form-group col-sm-12" style="margin-top: -12px;margin-bottom: -12px;">
			<p><strong><u>Address:</u></strong></p>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Division</label>
			<select name="source_division_id" id="division_id" class="division_id form-control form-control-sm">
				<option value="">Select Division</option>
				@foreach($divisions as $d)
				<option value="{{$d->id}}" {{(@$editIncident->provider_division_id==$d->id)?"selected":""}}>{{$d->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">District</label>
			<select name="source_district_id" id="district_id" class="district_id form-control form-control-sm">
				<?php echo getdistrict($division_id=@$editIncident->source_division_id,$selected_district_id=@$editIncident->source_district_id)?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Upazila</label>
			<select name="source_upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
				<?php echo getupazila($district_id=@$editIncident->source_district_id,$selected_upazila_id=@$editIncident->source_upazila_id)?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Union</label>
			<select name="source_union_id" id="union_id" class="union_id form-control form-control-sm">
				<?php echo getunion($upazila_id=@$editIncident->source_upazila_id,$selected_union_id=@$editIncident->source_union_id)?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label class="control-label">Village</label>
			<input type="text" name="source_village" id="name" class="form-control form-control-sm" value="{{@$editIncident->source_village}}" placeholder="Village Name">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">House</label>
			<input type="text" name="source_house" value="{{@$editIncident->source_house}}" class="form-control form-control-sm">
		</div>
		<div class="form-group col-sm-3">
			<label class="control-label">Road</label>
			<input type="text" name="source_road" value="{{@$editIncident->source_road}}" class="form-control form-control-sm">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-2">
			<input type="hidden" name="provider_info_save" value="provider_info_save">
			<button type="submit" id="provider_info_save" class="btn btn-primary btn-sm">Save</button>
		</div>
	</div>
</div>

{{-- Extra Others Field Information Source --}}
<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','.information_provider_value',function(){
            var information_provider_value = $(this).val();
            if(information_provider_value == 1){
                $('.show_provider_name_wise').show();
            }else{
                $('.show_provider_name_wise').hide();
            }
            if(information_provider_value == 2){
                $('.show_provider_sourse_wise').show();
            }else{
                $('.show_provider_sourse_wise').hide();
            }
        });
    });
</script>