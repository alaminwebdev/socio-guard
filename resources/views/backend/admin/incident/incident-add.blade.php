@extends('backend.layouts.app')
@section('content')
<style type="text/css">
	.mb-0 > a {
	  display: block;
	  position: relative;
	}
	.mb-0 > a:after {
	  content: "\f078"; /* fa-chevron-down */
	  font-family: 'FontAwesome';
	  position: absolute;
	  right: 0;
	}
	.mb-0 > a[aria-expanded="true"]:after {
	  content: "\f077"; /* fa-chevron-up */
	}
</style>

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Violence Incident</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Violence Incident</li>
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
					Update Violence Incident
					@else
					Add Violence Incident
					@endif
					<a class="btn btn-sm btn-success float-right" href="{{route('incident.violence.view')}}"><i class="fa fa-list"></i> Violence Incident List</a>
				</h5>
			</div>
			<div class="card-body">
				<div class="form-row">
					<div class="col-md-3">

					</div>
					<div class="col-md-2">
						<p style="font-weight: bold;font-size: 16px;padding-left: 5px;">Violence Incident ID:</p>
					</div>
					<div class="col-md-1">
						<p style="font-weight: bold;font-size: 16px;padding-left: 5px;">{{(@$editIncident)?$editIncident->survivor_id:$survivor_id}}</p>
					</div>
					<div class="col-md-2" style="padding-left: 45px;">
						<p style="font-weight: bold;font-size: 16px;padding-left: 5px;">Posting Date:</p>
					</div>
					<div class="col-md-2">
						<p style="font-weight: bold;font-size: 16px;padding-left: 5px;">{{(@$editIncident)? date("Y-m-d", strtotime($editIncident->created_at)): date("Y-m-d")}}</p>
					</div>
				</div>

				<div id="accordion">
					<div class="card">
						<div id="accordion">

							<div class="card">
								<div class="card-header" id="heading-1">
									<h5 class="mb-0">
										<a role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="true" aria-controls="collapse-1">
											Information Sender: (Brac Staff) @if(@$editIncident->employee_division_id!=null)<i class="fa fa-check-circle fa-success"></i>@endif
										</a>
									</h5>
								</div>
								<div id="collapse-1" class="collapse show" data-parent="#accordion" aria-labelledby="heading-1">
									<div class="card-body">
										<form method="post" action="{{!empty($editIncident->id)?route('incident.violence.update',$editIncident->id):route('incident.violence.store')}}" enctype="multipart/form-data" id="informationSenderForm" class="informationSenderForm">
							          		{{csrf_field()}}
											@include('backend.admin.incident.information-sender')
										</form>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="heading-2">
									<h5 class="mb-0">
										<a class="collapsed" role="button" data-toggle="collapse" href="#collapse-2" aria-expanded="false" aria-controls="collapse-2">
											Source of primary information provider
											@if(@$editIncident->provider_applicable_status=='1')
												<i class="fa fa-check-circle fa-success"></i>
											@elseif(@$editIncident->provider_name!=null)
												<i class="fa fa-check-circle fa-success"></i>
											@elseif(@$editIncident->provider_source_id!=null)
												<i class="fa fa-check-circle fa-success"></i>
											@endif
										</a>
									</h5>
								</div>
								<div id="collapse-2" class="collapse" data-parent="#accordion" aria-labelledby="heading-2">
									<div class="card-body">
										<form method="post" action="{{!empty($editIncident->id)?route('incident.violence.update',$editIncident->id):route('incident.violence.store')}}" id="informationProviderForm" class="informationProviderForm">
			          						{{csrf_field()}}
			          						@include('backend.admin.incident.information-provider')
			          					</form>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="heading-3">
									<h5 class="mb-0">
										<a class="collapsed" role="button" data-toggle="collapse" href="#collapse-3" aria-expanded="false" aria-controls="collapse-3">
											Particulars of violence incidents @if(@$editIncident->violence_applicable_status=='1')<i class="fa fa-check-circle fa-success"></i>@elseif(@$editIncident->violence_category_id!=null)<i class="fa fa-check-circle fa-success"></i>@endif
										</a>
									</h5>
								</div>
								<div id="collapse-3" class="collapse" data-parent="#accordion" aria-labelledby="heading-3">
									<div class="card-body">
										<form method="post" action="{{!empty($editIncident->id)?route('incident.violence.update',$editIncident->id):route('incident.violence.store')}}" id="violenceIncidentForm" class="violenceIncidentForm">
							          		{{csrf_field()}}
								            @include('backend.admin.incident.violence-incident')
								      	</form>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="heading-4">
									<h5 class="mb-0">
										<a class="collapsed" role="button" data-toggle="collapse" href="#collapse-4" aria-expanded="false" aria-controls="collapse-4">
											Survivors Information @if(@$editIncident->survivor_applicable_status=='1')<i class="fa fa-check-circle fa-success"></i>@elseif(@$editIncident->survivor_name!=null)<i class="fa fa-check-circle fa-success"></i>@endif
										</a>
									</h5>
								</div>
								<div id="collapse-4" class="collapse" data-parent="#accordion" aria-labelledby="heading-4">
									<div class="card-body">
										<form method="post" action="{{!empty($editIncident->id)?route('incident.violence.update',$editIncident->id):route('incident.violence.store')}}" id="survivorInfoForm" enctype="multipart/form-data" class="survivorInfoForm">
							          		{{csrf_field()}}
								            @include('backend.admin.incident.survivor-information')
								        </form>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="heading-5">
									<h5 class="mb-0">
										<a class="collapsed" role="button" data-toggle="collapse" href="#collapse-5" aria-expanded="false" aria-controls="collapse-5">
											Perpetrators information @if(@$editIncident->perpetrator_applicable_status=='1')<i class="fa fa-check-circle fa-success"></i>@elseif(@$editIncident->perpetrator_name!=null)<i class="fa fa-check-circle fa-success"></i>@endif
											<!-- Perpetrators information @if(@$editIncident['perpetrator_info']['0']['perpetrator_applicable_status']=='1')<i class="fa fa-check-circle fa-success"></i>@elseif(@$editIncident['perpetrator_info']['0']['perpetrator_name']!=null)<i class="fa fa-check-circle fa-success"></i>@endif -->
										</a>
									</h5>
								</div>
								<div id="collapse-5" class="collapse" data-parent="#accordion" aria-labelledby="heading-5">
									<div class="card-body">
										<form method="post" action="{{!empty($editIncident->id)?route('incident.violence.update',$editIncident->id):route('incident.violence.store')}}" id="perpetratorInfoForm" class="perpetratorInfoForm">
							          		{{csrf_field()}}
								            @include('backend.admin.incident.perpetrator-information')
								            <!-- <div class="form-group col-sm-4" style="padding-top: 20px;">
												<button type="submit" class="btn btn-primary btn-sm block">Save</button>
											</div> -->
							          	</form>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="heading-6">
									<h5 class="mb-0">
										<a class="collapsed" role="button" data-toggle="collapse" href="#collapse-6" aria-expanded="false" aria-controls="collapse-6">
											Legal Initiatives @if(@$editIncident->case_applicable_status=='1')<i class="fa fa-check-circle fa-success"></i>@elseif(@$editIncident->case_status!=null)<i class="fa fa-check-circle fa-success"></i>@endif
										</a>
									</h5>
								</div>
								<div id="collapse-6" class="collapse" data-parent="#accordion" aria-labelledby="heading-6">
									<div class="card-body">
										<form method="post" action="{{!empty($editIncident->id)?route('incident.violence.update',$editIncident->id):route('incident.violence.store')}}" id="ligalInitiativeForm" class="ligalInitiativeForm">
								          	{{csrf_field()}}
								            @include('backend.admin.incident.legal-initiative')
							        	</form>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="heading-7">
									<h5 class="mb-0">
										<a class="collapsed" role="button" data-toggle="collapse" href="#collapse-7" aria-expanded="false" aria-controls="collapse-7">
											Information on survivors current situation @if(@$editIncident->current_situation_applicable_status=='1')<i class="fa fa-check-circle fa-success"></i>@elseif(@$editIncident->survivor_initial_support_id!=null)<i class="fa fa-check-circle fa-success"></i>@endif
										</a>
									</h5>
								</div>
								<div id="collapse-7" class="collapse" data-parent="#accordion" aria-labelledby="heading-7">
									<div class="card-body">
										<form method="post" action="{{!empty($editIncident->id)?route('incident.violence.update',$editIncident->id):route('incident.violence.store')}}" id="currentSituationForm" class="currentSituationForm">
								          	{{csrf_field()}}
								            @include('backend.admin.incident.survivor-current-situation')
								        </form>
									</div>
								</div>
							</div>

							<div class="card">
								<div class="card-header" id="heading-8">
									<h5 class="mb-0">
										<a class="collapsed" role="button" data-toggle="collapse" href="#collapse-8" aria-expanded="false" aria-controls="collapse-8">
											Support for Survivors
											@if(@$editIncident['survivor_brac_support']['0']['survivor_support_applicable_status']=='1')
												<i class="fa fa-check-circle fa-success"></i>
											@elseif(@$editIncident['survivor_brac_support']['0']['survivor_final_support_id']!=null)
												<i class="fa fa-check-circle fa-success"></i>
											@elseif(@$editIncident['survivor_other_organization_support']['0']['survivor_final_support_id']!=null)
												<i class="fa fa-check-circle fa-success"></i>
											@endif
										</a>
									</h5>
								</div>
								<div id="collapse-8" class="collapse" data-parent="#accordion" aria-labelledby="heading-8">
									<div class="card-body">
										<form method="post" action="{{!empty($editIncident->id)?route('incident.violence.update',$editIncident->id):route('incident.violence.store')}}" id="survivorSupportForm" class="survivorSupportForm">
							          		{{csrf_field()}}
								            @include('backend.admin.incident.survivor-support')
								            <input type="hidden" name="initial_support_save" value="initial_support_save">
											<button type="submit" id="initial_support_save" class="btn btn-primary btn-sm">Submit</button>
								        </form>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Extra mode perpetrator information -->
<div style="display: none;">
	<div class="whole_extra_item_add" id="whole_extra_item_add">
		<div class="delete_whole_extra_item_add parent_div" id="delete_whole_extra_item_add">
			<hr style="background: #000000;padding: 1px;">
			<div class="form-row" style="background: #ddd">
				<div class="form-group col-sm-3">
					<label class="control-label">Name</label>
					<input type="text" name="perpetrator_name[]" class="form-control form-control-sm">
				</div>
				<div class="form-group col-sm-2">
					<label class="control-label">Marital Status</label>
					<select name="perpetrator_marital_status_id[]" id="marital_status_id" class="marital_status_id form-control form-control-sm">
						<option value="">Select Status</option>
						@foreach($marital_statuses as $mstatus)
						<option value="{{$mstatus->id}}">{{$mstatus->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-2">
					<label class="control-label">Gender</label>
					<select name="perpetrator_gender_id[]" id="perpetrator_gender_id" class="perpetrator_gender_id form-control form-control-sm">
						<option value="">Select Gender</option>
						@foreach($genders as $gender)
						<option value="{{$gender->id}}">{{$gender->name}}</option>
						@endforeach
						<option value="0">Others(specify)</option>
						<input type="text" name="perpetrator_others_gender[]" class="form-control form-control-sm perpetrator_others_gender" placeholder="Write Gender" id="perpetrator_others_gender" style="display: none">
					</select>
				</div>
				<div class="form-group col-sm-2">
					<label class="control-label">Age</label>
					<input type="text" name="perpetrator_age[]" class="form-control form-control-sm">
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Current Place of perpetrators</label>
					<select name="perpetrator_place_id[]" id="perpetrator_place_id" class="perpetrator_current_place_id form-control form-control-sm">
						<option value="">Select Place</option>
						@foreach($survivor_place as $place)
						<option value="{{$place->id}}">{{$place->name}}</option>
						@endforeach
						<option value="0">Others(specify)</option>
						<input type="text" name="perpetrator_others_place[]" class="form-control form-control-sm perpetrator_others_place" placeholder="Write Place" id="perpetrator_others_place" style="display: none">
					</select>
				</div>
				<div class="form-group col-sm-4">
					<label class="control-label">Occupation</label>
					<select name="perpetrator_occupation_id[]" id="occupation_id" class="occupation_id form-control form-control-sm">
						<option value="">Select Occupation</option>
						@foreach($occupations as $occupation)
						<option value="{{$occupation->id}}">{{$occupation->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-5">
					<label class="control-label">Relationship between survivors and perpetrators</label>
					<select name="perpetrator_relationship_id[]" id="perpetrator_relationship_id" class="perpetrator_relationship_id form-control form-control-sm">
						<option value="">Select Relationship</option>
						@foreach($survivor_relationships as $relation)
						<option value="{{$relation->id}}">{{$relation->name}}</option>
						@endforeach
						<option value="0">Others(specify)</option>
						<input type="text" name="perpetrator_others_relationship[]" class="form-control form-control-sm perpetrator_others_relationship" placeholder="Write Other Relationship" id="perpetrator_others_relationship" style="display: none">
					</select>
				</div>
				<div class="form-group col-sm-3">
					<div class="add_perpetrator_family_member_id" style="display: none;">
						<label class="control-label">If perpetrator is family member</label>
						<select name="perpetrator_family_member_id[]" id="perpetrator_family_member_id" class="perpetrator_family_member_id form-control form-control-sm">
							<option value="">Select Family Member</option>
							@foreach($family_members as $member)
							<option value="{{$member->id}}">{{$member->name}}</option>
							@endforeach
							<option value="0">Others(specify)</option>
							<input type="text" name="perpetrator_others_family_member[]" class="form-control form-control-sm perpetrator_others_family_member" placeholder="Write Other Family Member" id="perpetrator_others_family_member" style="display: none">
						</select>
					</div>
				</div>

				{{-- <div class="form-group col-sm-3">
					<label class="control-label">Religion</label>
					<select name="perpetrator_religion_id[]" id="perpetrator_religion_id" class="form-control form-control-sm">
						<option value="">Select Religion</option>
						@foreach($religions as $religion)
						<option value="{{$religion->id}}">{{$religion->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Social Status</label>
					<select name="perpetrator_social_status_id[]" id="perpetrator_social_status_id" class="form-control form-control-sm">
						<option value="">Select Social Status</option>
						@foreach($social_statuses as $social)
						<option value="{{$social->id}}">{{$social->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-3">
					<label class="control-label">Economic Condition</label>
					<select name="perpetrator_economic_condition_id[]" id="perpetrator_economic_condition_id" class="form-control form-control-sm">
						<option value="">Select Economic Condition</option>
						@foreach($economic_conditions as $economic)
						<option value="{{$economic->id}}">{{$economic->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-sm-6">
					<label class="control-label">Was there any previous enmity between survivor & oppressor</label>
					<select name="perpetrator_previous_enmity_status[]" id="perpetrator_previous_enmity_status" class="perpetrator_previous_enmity_status form-control form-control-sm">
						<option value="">Select previous enmity</option>
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
				</div> --}}
				<div class="form-group col-sm-12" style="margin-top: -12px;margin-bottom: -12px;">
					<p><strong><u>Address:</u></strong></p>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Division</label>
					<select name="perpetrator_division_id[]" id="division_id" class="division_id form-control form-control-sm">
						<option value="">Select Division</option>
						@foreach($divisions as $d)
						<option value="{{$d->id}}" {{(@$editData->division_id==$d->id)?"selected":""}}>{{$d->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">District</label>
					<select name="perpetrator_district_id[]" id="district_id" class="district_id form-control form-control-sm">
						<option value="">Select District</option>
					</select>
				</div>
				<div class="form-group col-md-4">
					<label class="control-label">Upazila</label>
					<select name="perpetrator_upazila_id[]" id="upazila_id" class="upazila_id form-control form-control-sm">
						<option value="">Select Upazila</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label class="control-label">Union</label>
					<select name="perpetrator_union_id[]" id="union_id" class="union_id form-control form-control-sm">
						<option value="">Select Union</option>
					</select>
				</div>
				<div class="form-group col-md-3">
					<label class="control-label">Village</label>
					<input type="text" name="perpetrator_village[]" id="name" class="form-control form-control-sm" value="{{@$editData->name}}" placeholder="Village Name">
				</div>
				<div class="form-group col-sm-2">
					<label class="control-label">House</label>
					<input type="text" name="perpetrator_house[]" class="form-control form-control-sm">
				</div>
				<div class="form-group col-sm-2">
					<label class="control-label">Road</label>
					<input type="text" name="perpetrator_road[]" class="form-control form-control-sm">
				</div>
				<div class="form-group col-sm-1" style="padding-top: 29px;">
					<div class="form-row">
						<i class="btn btn-success fa fa-plus-circle addeventmore"></i>
						<i class="btn btn-danger fa fa-minus-circle removeeventmore"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

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
					<input type="text" name="survivor_support_date[]" value="" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off">
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

<script type="text/javascript">
	$(function(){
		$('.datetime').daterangepicker({
			singleDatePicker: true,
			timePicker: true,
			timePicker24Hour: false,
			timePickerIncrement: 5,
			autoApply:true,
			locale: {
				format: 'H:mm'
			}
		}).on('show.daterangepicker',function(ev,picker){
			picker.container.find('.calendar-table').hide();
		});
	});


	$(document).ready(function() {
	    $('.test').select2();
	});
</script>

@if(@$editIncident)
	<script type="text/javascript">
		$(document).ready(function(){
			$('.removeeventmore:not(:first)').addClass('btn btn-danger fa fa-minus-circle ');
			$('.removeSupportEvent:not(:first)').addClass('btn btn-danger fa fa-minus-circle ');
			$('.removeOtherEvent:not(:first)').addClass('btn btn-danger fa fa-minus-circle ');
		});
	</script>
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('change','#case_status',function(){
        	// alert('ok');
            var case_status = $(this).val();
            if(case_status == 'Yes'){
            	$('#add_yes_case_status').show();
            }else if(case_status == 'Under Process'){
            	$('#add_yes_case_status').hide();
            }
            else{
            	$('#add_yes_case_status').hide();
            }
            if(case_status == 'No'){
            	$('#add_no_case_status').show();
            }else{
            	$('#add_no_case_status').hide();
            }
        });
    });
</script>

{{-- Extra Others Field --}}
<script type="text/javascript">
    $(document).ready(function(){
    	//Source name
        $(document).on('change','.provider_source_id',function(){
            var provider_source_id = $(this).val();
            if(provider_source_id == '0'){
                $('.provider_other_source').show();
            }else{
                $('.provider_other_source').hide();
            }
        });
        //Provider Other Gender
        $(document).on('change','.provider_gender_id',function(){
            var provider_gender_id = $(this).val();
            if(provider_gender_id == '0'){
                $('.provider_others_gender').show();
            }else{
                $('.provider_others_gender').hide();
            }
        });
         //Provider Other Relationship
        $(document).on('change','.provider_relationship_id',function(){
            var provider_relationship_id = $(this).val();
            if(provider_relationship_id == '0'){
                $('.provider_other_relationship').show();
            }else{
                $('.provider_other_relationship').hide();
            }
        });
        //Survivor Other Gender
        $(document).on('change','.survivor_gender_id',function(){
            var survivor_gender_id = $(this).val();
            if(survivor_gender_id == '0'){
                $('.survivor_others_gender').show();
            }else{
                $('.survivor_others_gender').hide();
            }
        });
        //Survivor Other Religion
        $(document).on('change','.survivor_religion_id',function(){
            var survivor_religion_id = $(this).val();
            if(survivor_religion_id == '0'){
                $('.survivor_others_religion').show();
            }else{
                $('.survivor_others_religion').hide();
            }
        });
        //Survivor Other Inicident Place
        $(document).on('change','.survivor_incident_place_id',function(){
            var survivor_incident_place_id = $(this).val();
            if(survivor_incident_place_id == '0'){
                $('.survivor_others_incident_place').show();
            }else{
                $('.survivor_others_incident_place').hide();
            }
        });
        //Survivor Other Autistic
        $(document).on('change','.survivor_autistic_id',function(){
            var survivor_autistic_id = $(this).val();
            if(survivor_autistic_id == '0'){
                $('.survivor_others_autistic').show();
            }else{
                $('.survivor_others_autistic').hide();
            }
        });
        //Perpetrator Other Gender
        $(document).on('change','.perpetrator_gender_id',function(){
            var perpetrator_gender_id = $(this).val();
            if(perpetrator_gender_id == '0'){
                $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_gender').show();
            }else{
                $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_gender').hide();
            }
        });
        //Perpetrator Other Current Place
        $(document).on('change','.perpetrator_current_place_id',function(){
            var perpetrator_current_place_id = $(this).val();
            if(perpetrator_current_place_id == '0'){
                $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_place').show();
            }else{
                $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_place').hide();
            }
        });
        //Perpetrator Other Relation
        $(document).on('change','.perpetrator_relationship_id',function(){
            var perpetrator_relationship_id = $(this).val();
            if(perpetrator_relationship_id == '0'){
                $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_relationship').show();
            }else{
                $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_relationship').hide();
            }
        });
        //Survivor Initial Support
        $(document).on('change','.survivor_initial_support_id',function(){
            var survivor_initial_support_id = $(this).val();
            if(survivor_initial_support_id == '0'){
                $('.survivor_initial_other_support').show();
            }else{
                $('.survivor_initial_other_support').hide();
            }
        });
        //Survivor Situation
        $(document).on('change','.survivor_situation_id',function(){
            var survivor_situation_id = $(this).val();
            if(survivor_situation_id == '0'){
                $('.survivor_other_situation').show();
            }else{
                $('.survivor_other_situation').hide();
            }
        });
        //Survivor Place
        $(document).on('change','.survivor_place_id',function(){
            var survivor_place_id = $(this).val();
            if(survivor_place_id == '0'){
                $('.survivor_other_place').show();
            }else{
                $('.survivor_other_place').hide();
            }
        });
        //Family Member
        $(document).on('change','.perpetrator_relationship_id',function(){
            var perpetrator_relationship_id = $(this).val();
            if(perpetrator_relationship_id == '1'){
                $(this).closest('.delete_whole_extra_item_add').find('.add_perpetrator_family_member_id').show();
            }else{
                $(this).closest('.delete_whole_extra_item_add').find('.add_perpetrator_family_member_id').hide();
            }
        });
        //Other Family Member
        $(document).on('change','.perpetrator_family_member_id',function(){
            var perpetrator_family_member_id = $(this).val();
            if(perpetrator_family_member_id == '0'){
                $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_family_member').show();
            }else{
                $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_family_member').hide();
            }
        });
    });
</script>

<script type="text/javascript">
	$(function(){
		var perpetrator_relationship_id = "1";
		if(perpetrator_relationship_id){
			$('.perpetrator_relationship_id').val(perpetrator_relationship_id).trigger('change');
		}
		$('#survivor_image').change(function (e) { //show Slider Image before upload
	    	var reader = new FileReader();
	    	reader.onload = function (e) {
	    		$('#showImage').attr('src', e.target.result);
	    	};
	    	reader.readAsDataURL(e.target.files[0]);
	    });
	});
</script>

<!-- extra_add_perpetrator_item -->
<script type="text/javascript">
    $(document).ready(function () {
        var counter = 0;

        $(document).on("click",".addeventmore", function () {
            var whole_extra_item_add = $("#whole_extra_item_add").html();
            $(this).closest(".add_item").append(whole_extra_item_add);
            counter++;
        });

        $(document).on("click", ".removeeventmore", function (event) {
            $(this).closest(".delete_whole_extra_item_add").remove();
            counter -= 1
        });
    });
</script>

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
        });

        $(document).on("click", ".removeOtherEvent", function (event) {
            $(this).closest(".delete_whole_extra_other_support_item_add").remove();
            counter -= 1
        });
    });
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('change','.division_id',function(){
			var btnThis = $(this);
			var division_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-district')}}",
				type : "GET",
				data : {division_id:division_id},
				success:function(data){
					var html = '<option value="">Select District</option>';
					$.each(data[0],function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$(btnThis).parents('.parent_div').find('.district_id').html(html);

					var html2 = '<option value="">Select City Corporation</option>';
					$.each(data[1],function(key,v){
						html2 +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$(btnThis).parents('.parent_div').find('.city_corporation_id').html(html2);
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('change','.district_id',function(){
			var btnThis = $(this);
			var district_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-upazila')}}",
				type : "GET",
				data : {district_id:district_id},
				success:function(data){
					var html = '<option value="">Select Upazila</option>';
					$.each(data[0],function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$(btnThis).parents('.parent_div').find('.upazila_id').html(html);

					var html2 = '<option value="">Select Pourosova</option>';
					$.each(data[1],function(key,v){
						html2 +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$(btnThis).parents('.parent_div').find('.pourosova_id').html(html2);
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('change','.upazila_id',function(){
			var btnThis = $(this);
			var upazila_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-union')}}",
				type : "GET",
				data : {upazila_id:upazila_id},
				success:function(data){
					var html = '<option value="">Select Union</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$(btnThis).parents('.parent_div').find('.union_id').html(html);
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('change','.organization_type_id',function(){
			var organization_type_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-organization-name')}}",
				type : "GET",
				data : {organization_type_id:organization_type_id},
				success:function(data){
					var html = '<option value="">Select Organization Type</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('.organization_name_id').html(html);
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('change','.violence_category_id',function(){
			var violence_category_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-violence-sub-category')}}",
				type : "GET",
				data : {violence_category_id:violence_category_id},
				success:function(data){
					var html = '<option value="">Select Violence Sub Category</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('.violence_sub_category_id').html(html);
				}
			});
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('change','.violence_sub_category_id',function(){
			var violence_sub_category_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-violence-name')}}",
				type : "GET",
				data : {violence_sub_category_id:violence_sub_category_id},
				success:function(data){
					var html = '<option value="">Select Violence Name</option>';
					$.each(data,function(key,v){
						html +='<option value="'+v.id+'">'+v.name+'</option>';
					});
					$('.violence_name_id').html(html);
				}
			});
		});
	});
</script>

<script>
    $(document).ready(function(){
    	$('#informationSenderForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	            'employee_name' : {
	                required : true,
	            },
	            'employee_mobile_number' : {
	                required : true,
	            },
	            'employee_designation' : {
	                required : true,
	            },
	            'employee_pin' : {
	                required : true,
	            },
	            'employee_division_id' : {
	                required : true,
	            },
	            'employee_district_id' : {
	                required : true,
	            },
	            // 'employee_upazila_id' : {
	            //     required : true,
	            // },
	            // 'employee_union_id' : {
	            //     required : true,
	            // },
	            // 'employee_village' : {
	            //     required : true,
	            // },
	            // 'employee_house' : {
	            //     required : true,
	            // },
	            // 'employee_road' : {
	            //     required : true,
	            // },
	        },
	        messages : {

	        }
	    });
    });
</script>

<script>
    $(document).ready(function(){
    	$('#informationProviderForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	        	// 'provider_source_id' : {
	         //        required :function(){
	         //        	return $('#provider_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'provider_mobile_no' : {
	         //        required :function(){
	         //        	return $('#provider_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	            // 'provider_organization_type_id' : {
	            //     required :function(){
	            //     	return $('#provider_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'provider_organization_name_id' : {
	            //     required :function(){
	            //     	return $('#provider_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'provider_gender_id' : {
	            //     required :function(){
	            //     	return $('#provider_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'provider_relationship_id' : {
	            //     required :function(){
	            //     	return $('#provider_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'provider_division_id' : {
	            //     required :function(){
	            //     	return $('#provider_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'provider_district_id' : {
	            //     required :function(){
	            //     	return $('#provider_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'provider_upazila_id' : {
	            //     required :function(){
	            //     	return $('#provider_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'provider_union_id' : {
	            //     required :function(){
	            //     	return $('#provider_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'provider_village' : {
	            //     required :function(){
	            //     	return $('#provider_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'provider_house' : {
	            //     required :function(){
	            //     	return $('#provider_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'provider_road' : {
	            //     required :function(){
	            //     	return $('#provider_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	        },
	        messages : {

	        }
	    });

    });
</script>

<script>
    $(document).ready(function(){
    	$('#violenceIncidentForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	        	// 'violence_category_id' : {
	         //        required :function(){
	         //        	return $('#violence_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'violence_sub_category_id' : {
	         //        required :function(){
	         //        	return $('#violence_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'violence_name_id' : {
	         //        required :function(){
	         //        	return $('#violence_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'violence_date' : {
	         //        required :function(){
	         //        	return $('#violence_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'violence_time' : {
	         //        required :function(){
	         //        	return $('#violence_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'violence_incident_place_id' : {
	         //        required :function(){
	         //        	return $('#violence_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'violence_reason_id' : {
	         //        required :function(){
	         //        	return $('#violence_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'violence_reason_details' : {
	         //        required :function(){
	         //        	return $('#violence_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	        },
	        messages : {

	        }
	    });

    });
</script>
<script>
    $(document).ready(function(){
    	$('#survivorInfoForm').validate({
    		ignore:[],
            errorPlacement: function(error, element){
                if (element.attr("name") == "survivor_organization_type_id[]" ){ error.insertAfter(element.next()); }
                else{error.insertAfter(element);}
            },
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	        	// 'survivor_name' : {
	         //        required :function(){
	         //        	return $('#survivor_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'survivor_father_name' : {
	         //        required :function(){
	         //        	return $('#survivor_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'survivor_mother_name' : {
	         //        required :function(){
	         //        	return $('#survivor_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'survivor_mobile_no' : {
	         //        required :function(){
	         //        	return $('#survivor_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'survivor_gender_id' : {
	         //        required :function(){
	         //        	return $('#survivor_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'survivor_religion_id' : {
	         //        required :function(){
	         //        	return $('#survivor_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'survivor_marital_status_id' : {
	         //        required :function(){
	         //        	return $('#survivor_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'survivor_age' : {
	         //        required :function(){
	         //        	return $('#survivor_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	            // 'survivor_monthly_income' : {
	            //     required :function(){
	            //     	return $('#survivor_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'survivor_occupation_id' : {
	            //     required :function(){
	            //     	return $('#survivor_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'survivor_organization_type_id[]' : {
	            //     required :function(){
	            //     	return $('#survivor_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'survivor_incident_place_id' : {
	            //     required :function(){
	            //     	return $('#survivor_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'survivor_autistic_id' : {
	            //     required :function(){
	            //     	return $('#survivor_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'survivor_division_id' : {
	            //     required :function(){
	            //     	return $('#survivor_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'survivor_district_id' : {
	            //     required :function(){
	            //     	return $('#survivor_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'survivor_upazila_id' : {
	            //     required :function(){
	            //     	return $('#survivor_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'survivor_union_id' : {
	            //     required :function(){
	            //     	return $('#survivor_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'survivor_village' : {
	            //     required :function(){
	            //     	return $('#survivor_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'survivor_house' : {
	            //     required :function(){
	            //     	return $('#survivor_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'survivor_road' : {
	            //     required :function(){
	            //     	return $('#survivor_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	        },
	        messages : {

	        }
	    });

    });
</script>
<script>
    $(document).ready(function(){
    	$('#perpetratorInfoForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	        	// 'perpetrator_name[]' : {
	         //        required :function(){
	         //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'perpetrator_marital_status_id[]' : {
	         //        required :function(){
	         //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'perpetrator_gender_id[]' : {
	         //        required :function(){
	         //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'perpetrator_age[]' : {
	         //        required :function(){
	         //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'perpetrator_place_id[]' : {
	         //        required :function(){
	         //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'perpetrator_occupation_id[]' : {
	         //        required :function(){
	         //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'perpetrator_relationship_id[]' : {
	         //        required :function(){
	         //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'perpetrator_family_member_id[]' : {
	         //        required :function(){
	         //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'perpetrator_division_id[]' : {
	         //        required :function(){
	         //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'perpetrator_district_id[]' : {
	         //        required :function(){
	         //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	            // 'perpetrator_upazila_id[]' : {
	            //     required :function(){
	            //     	return $('#perpetrator_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'perpetrator_union_id[]' : {
	            //     required :function(){
	            //     	return $('#perpetrator_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'perpetrator_village[]' : {
	            //     required :function(){
	            //     	return $('#perpetrator_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'perpetrator_house[]' : {
	            //     required :function(){
	            //     	return $('#perpetrator_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'perpetrator_road[]' : {
	            //     required :function(){
	            //     	return $('#perpetrator_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	        },
	        messages : {

	        }
	    });

    });
</script>
<script>
    $(document).ready(function(){
    	$('#ligalInitiativeForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	        	// 'case_status' : {
	         //        required :function(){
	         //        	return $('#case_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'thana_name' : {
	         //        required :function(){
	         //        	return $('#case_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'court_name' : {
	         //        required :function(){
	         //        	return $('#case_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'not_filing_reason' : {
	         //        required :function(){
	         //        	return $('#case_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	        },
	        messages : {

	        }
	    });

    });
</script>
<script>
    $(document).ready(function(){
    	$('#currentSituationForm').validate({
    		errorClass:'text-danger',
	      	validClass:'text-success',
	        rules : {
	        	// 'survivor_initial_support_id' : {
	         //        required :function(){
	         //        	return $('#current_situation_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'survivor_situation_id' : {
	         //        required :function(){
	         //        	return $('#current_situation_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'survivor_place_id' : {
	         //        required :function(){
	         //        	return $('#current_situation_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	        },
	        messages : {

	        }
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
	         //        required :function(){
	         //        	return $('#survivor_support_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'survivor_final_support_id[]' : {
	         //        required :function(){
	         //        	return $('#survivor_support_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'brac_program_id[]' : {
	         //        required :function(){
	         //        	return $('#survivor_support_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	         //    'brac_support_description' : {
	         //        required :function(){
	         //        	return $('#survivor_support_applicable_status').is(':not(:checked)');
	         //        },
	         //    },
	            // 'survivor_final_support_other_id[]' : {
	            //     required :function(){
	            //     	return $('#survivor_support_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'other_program[]' : {
	            //     required :function(){
	            //     	return $('#survivor_support_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	            // 'other_organization_support_description' : {
	            //     required :function(){
	            //     	return $('#survivor_support_applicable_status').is(':not(:checked)');
	            //     },
	            // },
	        },
	        messages : {

	        }
	    });

    });
</script>

@endsection