<div class="parent_div">
	<div class="form-row" style="display: none">
		<div class="col-sm-12 text-center">
			<strong><span style="margin-right: 10px;">Not Applicable</span></strong><input type="checkbox" name="violence_applicable_status" value="1" {{(@$editIncident->violence_applicable_status=='1')?'checked':''}} id="violence_applicable_status" class="btn btn-info btn-sm">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-4">
			<label class="control-label">Violence Type</label>
			<select name="violence_category_id" id="violence_category_id" class="violence_category_id form-control form-control-sm" required="">
				<option value="">Select Type</option>
				@foreach($violence_categories as $cat)
				<option value="{{$cat->id}}" {{(@$editIncident->violence_category_id==$cat->id)?"selected":""}}>{{$cat->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-sm-4">
			<label class="control-label">Violence Sub Type</label>
			<select name="violence_sub_category_id" id="violence_sub_category_id" class="violence_sub_category_id form-control form-control-sm" required="">
				<option value="">Select Sub Type</option>
				<?php echo violencesubcat($violence_category_id=@$editIncident->violence_category_id,$selected_violence_sub_category_id=@$editIncident->violence_sub_category_id)?>
			</select>
		</div>
		<div class="form-group col-sm-4">
			<label class="control-label">Violence Name (If Applicable)</label>
			<select name="violence_name_id" id="violence_name_id" class="violence_name_id form-control form-control-sm">
				<option value="">Select Name</option>
				<?php echo violencename($violence_sub_category_id=@$editIncident->violence_sub_category_id,$selected_violence_name_id=@$editIncident->violence_name_id)?>
			</select>
		</div>
		<div class="form-group col-sm-2">
			<label class="control-label">Date</label>
			<input type="text" name="violence_date" value="{{(!empty($editIncident->violence_date))?date('d-m-Y',strtotime(@$editIncident->violence_date)):''}}" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off" required="">
		</div>
		<div class="form-group col-sm-2">
			<label class="control-label">Time</label>
			<input type="text" name="violence_time" value="{{@$editIncident->violence_time}}" class="form-control form-control-sm datetime">
		</div>

		<div class="form-group col-sm-4">
			<label class="control-label">Union/Pourosova/City corporation</label>
			<select name="violence_place_id" id="violence_place_id" class="violence_place_id form-control form-control-sm" required="">
				<option value="">Select Union/Pourosova/City corporation</option>
				@foreach($violence_place as $place)
				<option value="{{$place->id}}" {{(@$editIncident->violence_place_id==$place->id)?"selected":""}}>{{$place->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="form-group col-sm-4">
			<label class="control-label">Violence Reason <small style="color:green;">Click here to select violence reason</small></label>
			<select name="violence_reason_id[]" id="violence_reason_id" class="violence_reason_id form-control form-control-sm" multiple="multiple" required="">
				@foreach($violenc_reasons as $place)
				<option value="{{$place->id}}" {{(in_array($place->id,explode(',',@$editIncident->violence_reason_id)) == true)?("selected"):""}}>{{$place->name}}</option>
				@endforeach
			</select>
		</div>

		<div class="form-group col-sm-8">
			<label class="control-label">Violence Description</label>
			<textarea name="violence_reason_details" class="form-control form-control-sm" placeholder="Write Detail Violence Description">{{@$editIncident->violence_reason_details}}</textarea>
		</div>
		<div class="form-group col-sm-2" style="padding-top: 29px;">
			<input type="hidden" name="violence_incident_save" value="violence_incident_save">
			<button type="submit" id="violence_incident_save" class="btn btn-primary btn-sm">Save</button>
		</div>
	</div>
</div>
@section('page_script')
<script type="text/javascript">
	$(function(){
		$(".violence_reason_id").select2({
		    placeholder: "Select a option"
		});
	})
</script>
@endsection