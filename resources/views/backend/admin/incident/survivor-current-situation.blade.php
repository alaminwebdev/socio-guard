<div class="parent_div">
	<div class="form-row" style="display: none">
		<div class="col-sm-12 text-center">
			<strong><span style="margin-right: 10px;">Not Applicable</span></strong><input type="checkbox" name="current_situation_applicable_status" value="1" {{(@$editIncident->current_situation_applicable_status=='1')?'checked':''}} id="current_situation_applicable_status" class="btn btn-info btn-sm">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-sm-4">
			<label class="control-label">Survivors situation during data collection</label>
			<select name="survivor_situation_id" id="survivor_situation_id" class="survivor_situation_id form-control form-control-sm">
				<option value="">Select Situation</option>
				@foreach($survivor_situation as $situation)
				<option value="{{$situation->id}}" {{(@$editIncident->survivor_situation_id==$situation->id)?"selected":""}}>{{$situation->name}}</option>
				@endforeach
				<option value="0" {{(@$editIncident->survivor_situation_id=='0')?"selected":""}}>Others(specify)</option>
			</select>
			@if(@$editIncident->survivor_situation_id=='0')
				<input type="text" name="survivor_other_situation" value="{{@$editIncident->survivor_other_situation}}" class="survivor_other_situation form-control form-control-sm" placeholder="Write Other Situation" id="survivor_other_situation" style="display: block;">
			@else
				<input type="text" name="survivor_other_situation" value="{{@$editIncident->survivor_other_situation}}" class="survivor_other_situation form-control form-control-sm" placeholder="Write Other Situation" id="survivor_other_situation" style="display: none;">
			@endif
		</div>
		<div class="form-group col-sm-4">
			<label class="control-label">Survivors place during data collection</label>
			<select name="survivor_place_id" id="survivor_place_id" class="survivor_place_id form-control form-control-sm">
				<option value="">Select Place</option>
				@foreach($survivor_place as $place)
				<option value="{{$place->id}}" {{(@$editIncident->survivor_place_id==$place->id)?"selected":""}}>{{$place->name}}</option>
				@endforeach
				<option value="0" {{(@$editIncident->survivor_place_id=='0')?"selected":""}}>Others(specify)</option>
			</select>
			@if(@$editIncident->survivor_place_id=='0')
				<input type="text" name="survivor_other_place" value="{{@$editIncident->survivor_other_place}}" class="survivor_other_place form-control form-control-sm" placeholder="Write Other Place" id="survivor_other_place" style="display: block;">
			@else
				<input type="text" name="survivor_other_place" value="{{@$editIncident->survivor_other_place}}" class="survivor_other_place form-control form-control-sm" placeholder="Write Other Place" id="survivor_other_place" style="display: none;">
			@endif
		</div>
		<div class="form-group col-sm-4">
			<label class="control-label">Survivors received any support?</label>
			<select name="survivor_initial_support_id" id="survivor_initial_support_id" class="survivor_initial_support_id form-control form-control-sm">
				<optgroup label="Yes">
					@foreach($survivor_initial_support as $insupport)
					<option value="{{$insupport->id}}" {{(@$editIncident->survivor_initial_support_id==$insupport->id)?"selected":""}}>{{$insupport->name}}</option>
					@endforeach
				</optgroup>
				<option value="No" {{(@$editIncident->survivor_initial_support_id=='No')?"selected":""}}>No</option>
				<option value="0" {{(@$editIncident->survivor_initial_support_id=='0')?"selected":""}}>Others(specify)</option>
			</select>
				@if(@$editIncident->survivor_initial_support_id=='0')
					<input type="text" name="survivor_initial_other_support" value="{{@$editIncident->survivor_initial_other_support}}" class="form-control form-control-sm survivor_initial_other_support" placeholder="Write Other Support" id="survivor_initial_other_support" style="display: block;">
				@else
					<input type="text" name="survivor_initial_other_support" value="{{@$editIncident->survivor_initial_other_support}}" class="form-control form-control-sm survivor_initial_other_support" placeholder="Write Other Support" id="survivor_initial_other_support" style="display: none">
				@endif
		</div>
		<div class="form-group col-sm-4">
			<button type="submit" class="btn btn-primary btn-sm">Save</button>
		</div>
	</div>
</div>