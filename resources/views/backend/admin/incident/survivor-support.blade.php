<div class="parent_div">
	<div class="form-row" style="display: none">
		<div class="col-sm-12 text-center">
			<strong><span style="margin-right: 10px;">Not Applicable</span></strong><input type="checkbox" name="survivor_support_applicable_status" value="1" {{(@$editIncident['survivor_brac_support']['0']['survivor_support_applicable_status']=='1')?'checked':''}} id="survivor_support_applicable_status" class="btn btn-info btn-sm">
		</div>
	</div>
	<!-- <div class="form-row">
		<div class="form-group col-sm-4">
			<label class="control-label">Date</label>
			<input type="text" name="survivor_support_date" value="{{(!empty($editIncident['survivor_brac_support']['0']['survivor_support_date']))?date('d-m-Y',strtotime($editIncident['survivor_brac_support']['0']['survivor_support_date'])):''}}" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off">
		</div>
	</div> -->
	<div class="clearfix"></div>
	<div class="add_support_item">
		<!-- <p style="font-weight: bold;font-size: 15px;margin-bottom: 0px;"><u>No Support</u></p> -->
		<input type="checkbox" class="" id="defaultInline1" name="inlineDefaultRadiosExample" value="1">
		<label class="custom-control-label" for="defaultInline1">No Support Required</label>
	</div>
	<br>
	<div class="add_support_item">
		<p style="font-weight: bold;font-size: 15px;margin-bottom: 0px;"><u>Brac Support</u></p>
		@if(@$editIncident)
			@foreach($editIncident['survivor_brac_support'] as $editBracSupport)
				<div class="delete_whole_extra_support_item_add parent_div" id="delete_whole_extra_support_item_add">
					<div class="form-row">
						<div class="form-group col-sm-3">
							<div class="check_brac_support">
								<label class="control-label">Support Name</label>
								<select name="survivor_final_support_id[]" id="survivor_final_support_id" class="survivor_final_support_id form-control form-control-sm">
									<option value="">Select Support</option>
									@foreach($brac_support as $brac)
									<option value="{{$brac->id}}" {{($editBracSupport->survivor_final_support_id==$brac->id)?"selected":""}}>{{$brac->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group col-sm-3">
							<label class="control-label">Programs Name</label>
							<select name="brac_program_id[]" id="brac_program_id" class="brac_program_id form-control form-control-sm">
								<option value="">Select Programs</option>
								@foreach($programs as $p)
								<option value="{{$p->id}}" {{($editBracSupport->brac_program_id==$p->id)?"selected":""}}>{{$p->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-sm-3">
							<label class="control-label">Date</label>
							<input type="text" name="survivor_support_date[]" value="{{(!empty($editBracSupport->survivor_support_date))?date('d-m-Y',strtotime($editBracSupport->survivor_support_date)):''}}" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off">
						</div>
						<div class="form-group col-sm-1" style="padding-top: 29px;">
							<div class="form-row">
								<i class="btn btn-success fa fa-plus-circle addSupportEvent"></i>
								<i class="removeSupportEvent"></i>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		@else
		<div class="delete_whole_extra_support_item_add parent_div" id="delete_whole_extra_support_item_add">
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
						<option value="">Select Programs</option>
						@foreach($programs as $p)
						<option value="{{$p->id}}">{{$p->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Date</label>
					<input type="text" name="survivor_support_date[]" value="{{(!empty($editIncident['survivor_brac_support']['0']['survivor_support_date']))?date('d-m-Y',strtotime($editIncident['survivor_brac_support']['0']['survivor_support_date'])):''}}" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off">
				</div>
				<div class="form-group col-sm-1" style="padding-top: 29px;">
					<i class="btn btn-success fa fa-plus-circle addSupportEvent"></i>
				</div>
			</div>
		</div>
		@endif
	</div>
	<div class="form-row">
		<div class="form-group col-sm-12">
			<label class="control-label">Support Description</label>
			<textarea name="brac_support_description" class="form-control form-control-sm" placeholder="Write Detail Description">{{@$editIncident['survivor_brac_support']['0']['brac_support_description']}}</textarea>
		</div>
	</div>
	<div class="add_other_support_item">
		<p style="font-weight: bold;font-size: 15px;margin-bottom: 0px;"><u>Other Organization Support</u></p>
		@if(@$editIncident)
			@foreach($editIncident['survivor_other_organization_support'] as $editOtherSupport)
			<div class="delete_whole_extra_other_support_item_add parent_div" id="delete_whole_extra_other_support_item_add">
				<div class="form-row">
					<div class="form-group col-sm-3">
						<div class="check_brac_support">
							<label class="control-label">Other Support</label>
							<select name="survivor_final_support_other_id[]" id="survivor_final_support_other_id" class="survivor_final_support_other_id form-control form-control-sm">
								<option value="">Select Support</option>
								@foreach($other_support as $other)
								<option value="{{$other->id}}" {{($editOtherSupport->survivor_final_support_id==$other->id)?"selected":""}}>{{$other->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group col-sm-3">
						<label class="control-label">Other Program Name</label>
						<input type="text" name="other_program[]" value="{{$editOtherSupport->other_program}}" class="form-control form-control-sm" placeholder="Write Other Programs">
					</div>
					<div class="form-group col-sm-3">
						<label class="control-label">Date</label>
						<input type="text" name="survivor_other_support_date[]" value="{{(!empty($editOtherSupport->survivor_other_support_date))?date('d-m-Y',strtotime($editOtherSupport->survivor_other_support_date)):''}}" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off">
					</div>
					<div class="form-group col-sm-1" style="padding-top: 29px;">
						<div class="form-row">
							<i class="btn btn-success fa fa-plus-circle addOtherEvent"></i>
							<i class="removeOtherEvent"></i>
						</div>
					</div>
				</div>
			</div>
			@endforeach
		@else
		<div class="delete_whole_extra_other_support_item_add parent_div" id="delete_whole_extra_other_support_item_add">
			<div class="form-row">
				<div class="form-group col-sm-3">
					<div class="check_brac_support">
						<label class="control-label">Other Support</label>
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
					<input type="text" name="survivor_other_support_date[]" value="{{(!empty($editOtherSupport['survivor_other_organization_support']['0']['survivor_other_support_date']))?date('d-m-Y',strtotime($editOtherSupport['survivor_other_organization_support']['0']['survivor_other_support_date'])):''}}" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off">
				</div>
				<div class="form-group col-sm-1" style="padding-top: 29px;">
					<i class="btn btn-success fa fa-plus-circle addOtherEvent"></i>
				</div>
			</div>
		</div>
		@endif
	</div>
	<div class="form-row">
		<div class="form-group col-sm-12">
			<label class="control-label">Other Support Description</label>
			<textarea name="other_organization_support_description" class="form-control form-control-sm" placeholder="Write Detail Other Description">{{@$editIncident['survivor_other_organization_support']['0']['other_organization_support_description']}}</textarea>
		</div>
	</div>
</div>