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


    .form-control-sm, .input-group-sm>.form-control, .input-group-sm>.input-group-append>.btn, .input-group-sm>.input-group-append>.input-group-text, .input-group-sm>.input-group-prepend>.btn, .input-group-sm>.input-group-prepend>.input-group-text {
        padding: 0.25rem 0.5rem;
        font-size: 11px;
        line-height: 1.5;
        border-radius: 0.2rem;
    }
</style>

{{-- <div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Manage Violence Incident</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Violence Incident</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div> --}}
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
                    Incident Form
					<a class="btn btn-sm btn-success float-right" href="{{url('view_incident')}}"><i class="fa fa-list"></i> Violence Incident List</a>
				</h5>
			</div>
			<div class="card-body">
        {{-- <div class="form-row">
					<div class="col-md-3">

					</div>
					<div class="col-md-2">
						<p style="font-weight: bold;font-size: 16px;">Violence Incident ID:</p>
					</div>
					<div class="col-md-1">
						<p style="font-weight: bold;font-size: 16px;">{{ rand(1000,9999) }}</p>
					</div>
					<div class="col-md-2">
						<p style="font-weight: bold;font-size: 16px;">Posting Date:</p>
					</div>
					<div class="col-md-2">
						<p style="font-weight: bold;font-size: 16px;">{{ date("d-m-Y") }}</p>
					</div>
				</div> --}}
        <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link active ptab1" id="data-entry" data-toggle="pill" href="#custom-content-above-home" role="tab" aria-controls="custom-content-above-home" aria-selected="true">Data Insert By</a>
          </li>
          <li class="nav-item">
            <a class="nav-link ptab2" id="section_A" style="display: none;" data-toggle="pill" href="#custom-content-above-test" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Section A</a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link" id="section_A" style="display: none;" data-toggle="pill" href="#custom-content-above-profile" role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Section A</a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link ptab3" id="section_B" style="display: none;" data-toggle="pill" href="#custom-content-above-messages" role="tab" aria-controls="custom-content-above-messages" aria-selected="false">Section B</a>
          </li>
        </ul>
        <form action="{{url('create_incident')}}" method="post">
          {{ csrf_field() }}

        <div class="tab-content" id="custom-content-above-tabContent">
          <br>
          
       
          <div class="tab-pane fade active show" id="custom-content-above-home" role="tabpanel" aria-labelledby="custom-content-above-home-tab">
            <br>
            <div class="form-row">
              <div class="form-group col-sm-3">
                <label class="control-label">Name</label>
                <input type="text" name="employee_name" value="{{ @$user_info->name }}" id="employee_name" class="form-control form-control-sm" readonly="">
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label">Cell</label>
                <input type="text" name="employee_mobile_number" value="{{ @$user_info->mobile }}" id="employee_mobile_number" class="form-control form-control-sm" readonly="">
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label">Designation</label>
                <input type="text" name="employee_designation" value="{{ @$user_info->designation }}" id="employee_designation" class="form-control form-control-sm" readonly="">
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label">Pin</label>
                <input type="text" name="employee_pin" value="{{ @$user_info->pin }}" id="employee_pin" class="form-control form-control-sm" readonly="">
              </div>
            </div>
            <div class="form-row" style="margin-top: -12px;margin-bottom: -12px;">
              <div class="form-group col-md-12">
              <p><strong><u>Address:</u></strong></p>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Zone</label>
                <select name="employee_zone_id" id="zone_id" class="zone_id form-control form-control-sm">
                  <option value="">Select Zone</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Division</label>
                <select name="employee_division_id" id="division_id" class="division_id form-control form-control-sm">
                  <option value="">Select Division</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">District</label>
                <select name="employee_district_id" id="district_id" class="district_id form-control form-control-sm">
                  <option value="">Select District</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label class="control-label">Upazila</label>
                <select name="employee_upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
                  <option value="">Select Upazila</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-12">
                <p><strong><u>Source of Primary Information : </u></strong></p>
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label">Information Provider</label>
                <select name="employee_information_provider" id="information_provider" class="information_provider form-control form-control-sm">
                  <option value="">-- Select --</option>
                  @foreach($informationProvider as $provide)
                  <option value="{{ $provide->id }}">{{ $provide->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label">Name of BRAC Programme</label>
                <select name="employee_information_provider" id="information_provider" class="information_provider form-control form-control-sm">
                  <option value="">-- Select --</option>
                  @foreach($bracProgram as $program)
                  <option value="{{ $program->id }}">{{ $program->title }}</option>
                  @endforeach
                </select>
              </div>
              {{-- <div class="form-group col-md-12">
                <p><strong><u>Types fo disputes : </u></strong></p>
              </div> --}}
              <div class="form-group col-sm-3">
                <label class="control-label">Types fo disputes</label>
                <select name="dispute" id="dispute" class="form-control form-control-sm">
                  <option value=""> -- Select -- </option>
                  @foreach($violenceReason as $reason)
                  <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-sm-3">
                <label class="control-label">First initiative taken from SELP</label>
                <select name="selp_initiative" id="selp_initiative" class="form-control form-control-sm">
                  <option value=""> -- Select -- </option>
                  <option value="1"> Advice and referrel </option>
                  <option value="2"> Complain received </option>
                </select>
              </div>
            </div>
            <div class="form-row advice_referrel" style="display: none;">
              <div class="form-group col-sm-3">
                <label class="control-label">Complaint against gender</label>
                <select name="complaint_against_gender_id" id="" class="form-control form-control-sm">
                  <option value=""> -- Select -- </option>
                  @foreach($genders as $gender)
                  <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label">Survivor's Name</label>
                <input type="text" name="survivor_name_front" value="" id="survivor_name" class="form-control form-control-sm">
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label">Contact Number</label>
                <input type="text" name="survivor_contact_no_front" value="" id="" class="form-control form-control-sm">
              </div>
            </div>

          </div>

          {{-- Sub Tab Section A --}}
          <div class="tab-pane fade" id="custom-content-above-test" role="tabpanel" aria-labelledby="custom-content-above-test-tab">
            <ul class="nav nav-tabs d-none" id="custom-content-above-tab" role="tablist">
              <li class="nav-item-sub">
                <a class="nav-link ctab1" id="sub_section_A" data-toggle="pill" href="#custom-content-above-sub-section-a" role="tab" aria-controls="custom-content-above-test" aria-selected="false">Tab 1</a>
              </li>
              <li class="nav-item-sub">
                <a class="nav-link ctab2" id="sub_section_A2" data-toggle="pill" href="#custom-content-above-sub-section-a2" role="tab" aria-controls="custom-content-above-test2" aria-selected="false">Tab 2</a>
              </li>
              <li class="nav-item-sub">
                <a class="nav-link ctab3" id="sub_section_A3" data-toggle="pill" href="#custom-content-above-sub-section-a3" role="tab" aria-controls="custom-content-above-test2" aria-selected="false">Tab 3</a>
              </li>
            </ul>
            <div class="tab-content" id="custom-content-above-tabContent">
              <div class="tab-pane fade" id="custom-content-above-sub-section-a" role="tabpanel" aria-labelledby="custom-content-above-test-tab">
                <br>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <p><strong><u>1. Survivors Information : </u></strong></p>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Dispute ID</label>
                    <input type="text" name="dispute_id" value="{{ rand(1000,9999) }}" id="dispute_id" class="form-control form-control-sm" readonly>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Survivor's Name</label>
                    <input type="text" name="survivor_name" value="" id="survivor_name" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Father's Name</label>
                    <input type="text" name="survivor_father_name" value="" id="survivor_father_name" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Mother's Name</label>
                    <input type="text" name="survivor_mother_name" value="" id="survivor_mother_name" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Husband's Name (If Applicable)</label>
                    <input type="text" name="survivor_husband_name" value="" id="survivor_husband_name" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">1st Contact Number</label>
                    <input type="text" name="survivor_contact_no" value="" id="survivor_name" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">2nd Contact Number</label>
                    <input type="text" name="survivor_2nd_contact_no" value="" id="survivor_name" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Age</label>
                    <input type="text" name="survivor_age" value="" id="survivor_name" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Sex</label>
                    <select name="survivor_sex" id="" class="form-control form-control-sm">
                      <option value="">Select Sex</option>
                      @foreach($genders as $gender)
                      <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Education</label>
                    <select name="survivor_education" id="" class="form-control form-control-sm">
                      <option value="">Select Education</option>
                      @foreach($educations as $education)
                      <option value="{{ $education->id }}">{{ $education->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Religion</label>
                    <select name="survivor_religion" id="" class="form-control form-control-sm">
                      <option value="">Select Religion</option>
                      @foreach($religions as $religion)
                      <option value="{{ $religion->id }}">{{ $religion->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Household Type</label>
                    <select name="survivor_household_id" id="" class="form-control form-control-sm">
                      <option value="">Select Household Type</option>
                      @foreach($houseHoldType as $type)
                      <option value="{{ $type->id }}">{{ $type->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Total Income/Month</label>
                    <input type="text" name="survivor_income" value="" id="" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Violence Location</label>
                    <select name="survivor_violence_location" id="" class="form-control form-control-sm">
                      <option value="">Select Violence Location</option>
                      @foreach($violenceLocation as $location)
                      <option value="{{ $location->id }}">{{ $location->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Marital Status</label>
                    <select name="survivor_marital_status" id="" class="form-control form-control-sm">
                      <option value="">Select Marital Status</option>
                      @foreach($maritalStatus as $marital)
                      <option value="{{ $marital->id }}">{{ $marital->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Age of marriage(If Applicable)</label>
                    <input type="text" name="survivor_marriage_age" value="" id="" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label" style="font-size: 13px;">Organizational affiliation (if any)</label>
                    <select name="survivor_organization_affiliation_id" id="" class="form-control form-control-sm">
                      <option value="">-- Select --</option>
                      <option value="1">BRAC participants</option>
                      <option value="2">Other organization</option>
                      <option value="3">Not applicable</option>
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">NID number(If available)</label>
                    <input type="text" name="survivor_nid" value="" id="" class="form-control form-control-sm"/>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Reason of violence </label>
                    <select name="survivor_reason_of_violence" id="" class="form-control form-control-sm">
                      <option value="">Select Reason of violence</option>
                      @foreach($violenceReason as $reason)
                      <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Place of violence </label>
                    <select name="survivor_place_of_violence" id="" class="form-control form-control-sm">
                      <option value="">Select Place of violence</option>
                      @foreach($violencePlace as $place)
                      <option value="{{ $place->id }}">{{ $place->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Disability status </label>
                    <select name="survivor_disability_status" id="" class="form-control form-control-sm">
                      <option value="">Select Disability status</option>
                      @foreach($disabilityStatus as $disability)
                      <option value="{{ $disability->id }}">{{ $disability->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <p><strong><u>2. Perpetrator information : </u></strong></p>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Number of perpetrator(s)</label>
                    <input type="text" name="number_of_perpetrator" value="" id="" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Relation with main perpetrator</label>
                    <select name="relation_with_main_perpetrator" id="" class="form-control form-control-sm">
                      <option value="">Select Relation</option>
                      <option value="Neighbor">Neighbor</option>
                      <option value="Acquaintance">Acquaintance</option>
                      <option value="Unacquainted">Unacquainted</option>
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">If perpetrator family member(s)</label>
                    <select name="if_perpetrator_family_member" id="" class="form-control form-control-sm">
                      <option value="">Select family member</option>
                      @foreach($perpetratorRelation as $relation)
                      <option value="{{ $relation->id }}">{{ $relation->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Gender</label>
                    <select name="perpetrator_gender" id="" class="form-control form-control-sm">
                      <option value="">Select Gender</option>
                      @foreach($genders as $gender)
                      <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Age </label>
                    <input type="text" name="perpetrator_age" value="" id="survivor_name" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Education</label>
                    <select name="perpetrator_education" id="" class="form-control form-control-sm">
                      <option value="">Select Education</option>
                      @foreach($educations as $education)
                      <option value="{{ $education->id }}">{{ $education->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Occupation</label>
                    <select name="perpetrator_occupation" id="" class="form-control form-control-sm">
                      <option value="">Select Occupation</option>
                      @foreach($occupations as $occupation)
                      <option value="{{ $occupation->id }}">{{ $occupation->name }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="custom-content-above-sub-section-a2" role="tabpanel" aria-labelledby="custom-content-above-test-tab">
                <br>
                <div class="form-row">
                  <div class="form-group col-md-12">
                    <p><strong><u>3. Status of initiative taken for this complaint : </u></strong></p>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Any initiatives taken by survivors earlier for this dispute </label>
                   
                    <select name="earlier_survivor_initiative" id="initiative_taken" class="form-control form-control-sm">
                      <option value="">-- Select --</option>
                      <option value="1"> Yes </option>
                      <option value="2"> No </option>
                    </select>
                  </div>
                  <div class="form-group col-sm-3 initiative_yes" style="display: none;">
                    <label class="control-label" style="margin-top: 13px;">If Yes where??</label>
                    <select name="earlier_survivor_initiative_place" id="" class="form-control form-control-sm">
                      <option value="">-- Select --</option>
                      @foreach($survivorInitiatives as $initiative)
                      <option value="{{ $initiative->id }}">{{ $initiative->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label" style="margin-top: 13px;">Causes of failure/coming to SELP</label>
                    <select name="cause_of_failour_coming_to_selp" id="" class="form-control form-control-sm">
                      <option value="">-- Select --</option>
                      @foreach($selpFailour as $failour)
                      <option value="{{ $failour->id }}">{{ $failour->title }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <p><strong><u>4. Initiative taken by SELP : </u></strong></p>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Types of initiatives </label>
                    <select name="selp_types_of_initiative" id="initiatives" class="form-control form-control-sm">
                      <option value="">-- Select --</option>
                      <option value="1"> Direct support </option>
                      <option value="2"> Referral </option>
                    </select>
                  </div>
                  <div class="form-group col-sm-3 directsupport"  style="display: none;">
                    <label class="control-label"> Direct Support </label>
                    <select name="selp_direct_support" id="" class="form-control form-control-sm">
                      <option value="">-- Select --</option>
                      <option value="ADR"> ADR</option>
                      <option value="Assistance to a court case"> Assistance to a court case</option>
                      <option value="Assistance to treatment /medical support"> Assistance to treatment /medical support</option>
                      <option value="Assistance to OCC"> Assistance to OCC</option>
                      <option value="Assistance to police station"> Assistance to police station</option>
                    </select>
                  </div>
                  <div class="form-group col-sm-3 referralsupport"  style="display: none;">
                    <label class="control-label"> Referral Support </label>
                    <select name="selp_referral_initiatives" id="" class="form-control form-control-sm">
                      <option value="">-- Select --</option>
                      <option value="NGO shelter home">NGO shelter home</option>
                      <option value="Govt.shelter home">Govt.shelter home</option>
                      <option value="Skill/IGA for Govt. department">Skill/IGA for Govt. department</option>
                      <option value="BRAC programme">BRAC programme</option>
                    </select>
                  </div>
                </div>

                <div class="form-row direct-support" style="display: none;">
                  <div class="form-group col-md-12">
                    <p><strong><u>5. Detail of direct services : </u></strong></p>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label" style="font-size: 12px;">Alternative Dispute Resolution (ADR) </label>
                    <select name="selp_alternative_dispute_resolution" id="" class="form-control form-control-sm">
                      <option value="">-- Select --</option>
                      @foreach($adrs as $adr)
                      <option value="{{ $adr->id }}">{{ $adr->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label"> Starting Date </label>
                    <input type="date" name="selp_support_start_date" value="" id="" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label"> Closing Date </label>
                    <input type="date" name="selp_support_closing_date" value="" id="" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3">
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">If Money recovered through ADR </label>
                    <select name="selp_adrmoneyrecover" id="" class="form-control form-control-sm if_money_recovered">
                      <option value="">-- Select --</option>
                      <option value="1"> Yes </option>
                      <option value="2"> No </option>
                    </select>
                  </div>
                  <div class="form-group col-sm-3 from_adr" style="display: none;">
                    <label class="control-label"> Amount of Money from ADR </label>
                    <input type="text" name="selp_amount_of_money_from_adr" value="" id="" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-3 no_benify" style="display: none;">
                    <label class="control-label"> No. of Benifitiaries </label>
                    <input type="text" name="selp_adr_money_recover_benifitiaries" value="" id="" class="form-control form-control-sm">
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="custom-content-above-sub-section-a3" role="tabpanel" aria-labelledby="custom-content-above-test-tab">
                <br>
                <div class="form-row if_direct_support" style="display: none;">
                  <div class="form-group col-md-12">
                    <p><strong><u>6. Court case status : </u></strong></p>
                  </div>
                  <div class="form-group col-sm-2">
                    <label class="control-label"> Case Type </label>
                    <select name="case_type" id="case_type" class="form-control form-control-sm">
                      <option value="">-- Select --</option>
                      <option value="1"> Civil cases </option>
                      <option value="2"> GR/Police Case </option>
                      <option value="3"> CR/Petition Case </option>
                    </select>
                  </div>
                  <div class="form-group col-sm-3 civil" style="display: none;">
                    <label class="control-label"> Civil cases </label>
                    <select name="civilcase_id" id="" class="form-control form-control-sm">
                      <option value="">-- Select --</option>
                      @foreach($civilCase as $civil)
                      <option value="{{ $civil->id }}">{{ $civil->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3 police" style="display: none;">
                    <label class="control-label"> GR/Police Case </label>
                    <select name="policecase_id" id="" class="form-control form-control-sm">
                      <option value="">-- Select --</option>
                      @foreach($policeCase as $police)
                      <option value="{{ $police->id }}">{{ $police->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3 petition" style="display: none;">
                    <label class="control-label"> CR/Petition Case </label>
                    <select name="pititioncase_id" id="" class="form-control form-control-sm">
                      <option value="">-- Select --</option>
                      @foreach($petitionCase as $petition)
                      <option value="{{ $petition->id }}">{{ $petition->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label" style="font-size: 12px;"> Money recovered through court case </label>
                    <select name="moneyrecover_id" id="division_id" class="division_id form-control form-control-sm">
                      <option value="">-- Select --</option>
                      @foreach($moneyRecoverCourteCase as $CourteCase)
                      <option value="{{ $CourteCase->id }}">{{ $CourteCase->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label"> Judgement status </label>
                    <select name="judgementstatus_id" id="division_id" class="division_id form-control form-control-sm">
                      <option value="">-- Select --</option>judgementStatus
                      @foreach($judgementStatus as $status)
                      <option value="{{ $status->id }}">{{ $status->title }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-sm-2">
                    <label class="control-label"> Starting Date </label>
                    <input type="date" name="case_start_date" value="" id="" class="form-control form-control-sm">
                  </div>
                  <div class="form-group col-sm-2">
                    <label class="control-label"> Judgement Date </label>
                    <input type="date" name="judgement_date" value="" id="" class="form-control form-control-sm">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-12">
                    <p><strong><u>7. Followup : </u></strong></p>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label" style="font-size: 12px;">Programme participants followed up </label>
                    <select name="program_participent_followup" id="division_id" class="division_id form-control form-control-sm">
                      <option value="">-- Select --</option>
                      <option value="Physically/ In-person"> Physically/ In-person</option>
                      <option value="Online"> Online</option>
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">No.of follow up made by SELP staff </label>
                    <select name="no_of_followup_madeby_selp_staff" id="division_id" class="division_id form-control form-control-sm">
                      <option value="">-- Select --</option>
                      <option value="Physically/ In-person"> Physically/ In-person</option>
                      <option value="Online"> Online</option>
                    </select>
                  </div>
                  <div class="form-group col-sm-3">
                    <label class="control-label">Findings from follow up </label>
                    <select name="followup_id" id="division_id" class="division_id form-control form-control-sm">
                      <option value="">-- Select --</option>
                      @foreach($findingsFromFollowUp as $FollowUp)
                      <option value="{{ $FollowUp->id }}">{{ $FollowUp->title }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="tab-pane fade" id="custom-content-above-messages" role="tabpanel" aria-labelledby="custom-content-above-messages-tab">
            <div class="form-row">
              <div class="form-group col-md-12">
                <p><strong><u>1. Survivor's previous violence history </u></strong></p>
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label" style="margin-top: 26px;">Have you ever face any violence ? </label>
                <select name="have_survivor_face_violence_before" id="division_id" class="division_id form-control form-control-sm">
                  <option value="">-- Select --</option>
                  <option value="Yes"> Yes</option>
                  <option value="No"> No</option>
                </select>
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label" style="margin-top: 26px;">At what age </label>
                <input type="text" name="survivor_first_violence_age" value="" id="survivor_name" class="form-control form-control-sm">
              </div>
              <div class="form-group col-sm-3">
               
                <label class="control-label" style="margin-top: 13px;">If yes, what type of violence was that (multiple answers from dropdown) </label>
                <select name="violence_type_multiple_list" id="division_id" class="division_id form-control form-control-sm">
                  <option value="">-- Select --</option>
                  <option value="Yes"> Yes</option>
                  <option value="No"> No</option>
                </select>
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label" style="margin-top: 13px;">Did you seek support from BRAC for that? </label>
                <select name="survivor_seek_support_from_brac" id="division_id" class="division_id form-control form-control-sm">
                  <option value="">-- Select --</option>
                  <option value="Yes"> Yes</option>
                  <option value="No"> No</option>
                </select>
              </div>
              <div class="form-group col-sm-3">
                <label class="control-label">What support did you receive from BRAC? </label>
                <select name="bracsupporttype_id" id="division_id" class="division_id form-control form-control-sm">
                  <option value="">-- Select --</option>
                  @foreach($bracSupport as $support)
                  <option value="{{ $support->id }}">{{ $support->title }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div class="form-row" style="float: right">
          <a class="btn btn-primary back text-white" style="display: none;">Back</a>&nbsp
          <a class="btn btn-primary next text-white">Next</a>&nbsp
          <button class="btn btn-warning submit text-white">Save & Close</button>

          <button class="btn btn-success final text-white" style="display: none;">Submit</button>
        </div>
      </form>
      </div>
		</div>
	</div>
</div>

<script>
    $('.next').click(function(){
      // $('.nav-tabs > .nav-item > .active').parent().next('li').find('a').trigger('click');
      var has_class_ptab1 = $('.ptab1').hasClass('active');
      var has_class_ptab2 = $('.ptab2').hasClass('active');
      var has_class_ptab3 = $('.ptab3').hasClass('active');
      var has_class_ctab1 = $('.ctab1').hasClass('active');
      var has_class_ctab2 = $('.ctab2').hasClass('active');
      var has_class_ctab3 = $('.ctab3').hasClass('active');

      if(has_class_ptab1){
        $('.ptab2').trigger('click');
      }
      if(has_class_ptab2 && has_class_ctab1){
        $('.ctab2').trigger('click');
      }else if(has_class_ptab2 && has_class_ctab2){
        $('.ctab3').trigger('click');
      }else if(has_class_ptab2 && has_class_ctab3){
        $('.ptab3').trigger('click');
      }else{
        $('.ctab1').trigger('click');
      }
    });
    $('.back').click(function(){
      // $('.nav-tabs > .nav-item > .active').parent().prev('li').find('a').trigger('click');
      var has_class_ptab1 = $('.ptab1').hasClass('active');
      var has_class_ptab2 = $('.ptab2').hasClass('active');
      var has_class_ptab3 = $('.ptab3').hasClass('active');
      var has_class_ctab1 = $('.ctab1').hasClass('active');
      var has_class_ctab2 = $('.ctab2').hasClass('active');
      var has_class_ctab3 = $('.ctab3').hasClass('active');

      if(has_class_ptab1){
        $('.ptab1').trigger('click');
        return true;
      }else if(has_class_ptab3){
        $('.ptab2').trigger('click');
        $('.ctab3').trigger('click');
        return true;
      }

      if(has_class_ptab2 && has_class_ctab1){
        $('.ptab1').trigger('click');
        return true;
      }else if(has_class_ptab2 && has_class_ctab2){
        $('.ctab1').trigger('click');
        return true;
      }else if(has_class_ptab2 && has_class_ctab3){
        $('.ctab2').trigger('click');
        return true;
      }else{
        $('.ctab1').trigger('click');
        return true;
      }
    });



    $(document).ready(function() {
      $("#selp_initiative").change(function() {
        var selp_initiative = $("#selp_initiative").val();
        if (selp_initiative == 1) {
          // $(".direct-support").show();
          $(".advice_referrel").show();
        } else if(selp_initiative == 2){
          $("#section_A").show();
          $("#section_B").show();
          $(".advice_referrel").hide();
          $(".back").hide();
          $(".next").show();
        } else {
          $("#section_A").hide();
          $("#section_B").hide();
          $(".advice_referrel").hide();
        }
      });
    });

    $(document).ready(function() {
      $("#case_type").change(function() {
        var case_type = $("#case_type").val();
        if (case_type == 1) {
          $(".civil").show();
          $(".police").hide();
          $(".petition").hide();
        } else if(case_type == 2){
          $(".civil").hide();
          $(".police").show();
          $(".petition").hide();
        } else if(case_type == 3){
          $(".civil").hide();
          $(".police").hide();
          $(".petition").show();
        } else {
          $(".civil").hide();
          $(".police").hide();
          $(".petition").hide();
        }
      });
    });

    $(document).ready(function() {
      $("#section_B").click(function() {
        $(".next").hide();
        $(".back").show();
        $(".submit").hide();
        $(".final").show();
      });
    });

    $(document).ready(function() {
      $("#section_A").click(function() {
        $(".back").show();
      });
    });

    $(document).ready(function() {
      $("#data-entry").click(function() {
        $(".back").hide();
    });
});

  $(document).ready(function() {
    $("#initiatives").change(function() {
        var initiatives = $("#initiatives").val();
        if (initiatives == 1) {
            $(".direct-support").show();
            $(".if_direct_support").show();
            $(".directsupport").show();
            $(".referralsupport").hide();
          } else if(initiatives == 2){
            $(".directsupport").hide();
            $(".referralsupport").show();
            $(".direct-support").hide();
            $(".if_direct_support").hide();
          } else {
            $(".directsupport").hide();
            $(".referralsupport").hide();
            $(".direct-support").hide();
            $(".if_direct_support").hide();
        }
      });
    });

  $(document).ready(function() {
    $(".if_money_recovered").change(function() {
        var if_money_recovered = $(".if_money_recovered").val();
        if (if_money_recovered == 1) {
            $(".from_adr").show();
            $(".no_benify").show();
          } else if(if_money_recovered == 2){
            $(".from_adr").hide();
            $(".no_benify").hide();
          } else {
            $(".from_adr").hide();
            $(".no_benify").hide();
        }
      });
    });

  $(document).ready(function() {
    $("#initiative_taken").change(function() {
        var initiative_taken = $("#initiative_taken").val();
        if (initiative_taken == 1) {
            $(".initiative_yes").show();
          } else if(initiative_taken == 2){
            $(".initiative_yes").hide();
          } else {
            $(".initiative_yes").hide();
        }
      });
    });
</script>

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