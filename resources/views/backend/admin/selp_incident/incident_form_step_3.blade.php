<form method="post" action="{{ route('incident.selp.step-3') }}">
    @csrf
    <input type="hidden" name="selp_incident_ref" value="{{ request()->selp_incident_ref }}">
    <input type="hidden" name="tab" value="2">
    <input type="hidden" name="step" value="4">
    <div class="form-row">
        <div class="form-group col-md-12">
            <p><strong><u>1. Survivor's Other Information : </u></strong></p>
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label">Household Type</label>
            <select name="survivor_household_id" id="" class="form-control form-control-sm">
                <option value="">Select Household Type</option>
                @foreach ($houseHoldType as $type)
                    <option {{ count($selpIncident) > 0 && $selpIncident[0]->household_type_id == $type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label">Total Household Income/Month</label>
            <input type="text" name="survivor_income" value="{{ count($selpIncident) > 0 ? $selpIncident[0]->household_total_income : '' }}" id="" class="form-control form-control-sm">
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label">Violence Location <span class="text-danger">*</span></label>
            <select name="survivor_violence_location" id="" class="form-control form-control-sm @error('survivor_violence_location') is-invalid @enderror">
                <option value="">Select Violence Location</option>
                @foreach ($violenceLocation as $location)
                    <option {{ (count($selpIncident) > 0 && $selpIncident[0]->violence_location_id == $location->id) || old('survivor_violence_location') == $location->id ? 'selected' : '' }} value="{{ $location->id }}">{{ $location->title }}</option>
                @endforeach
            </select>
            @error('survivor_violence_location')
                <p style="color:red; margin-top:5px;">This field is required</p>
            @enderror
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label">Marital Status</label>
            <select name="survivor_marital_status" id="maritalStatus" class="form-control form-control-sm">
                <option value="">Select Marital Status</option>
                @foreach ($maritalStatus as $marital)
                    <option {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_marital_status_id == $marital->id ? 'selected' : '' }} value="{{ $marital->id }}">{{ $marital->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label" style="font-size: 12px; height:35px;">Your Age During Marriage (First Marriage) - If Applicable</label>
            <input type="text" name="survivor_marriage_age" value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_age_of_marriage : '' }}" id="marriageAge" class="form-control form-control-sm InputPhone" maxlength="2">
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label" style="font-size: 12px;  height:35px;">Organizational affiliation (if any)</label>
            <select name="survivor_organization_affiliation_id" id="" class="form-control form-control-sm">
                <option value="">-- Select --</option>
                <option {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_organization_affiliation_id == 1 ? 'selected' : '' }} value="1">BRAC participants</option>
                <option {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_organization_affiliation_id == 2 ? 'selected' : '' }} value="2">Other organization</option>
                <option {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_organization_affiliation_id == 3 ? 'selected' : '' }} value="3">Not applicable</option>
            </select>
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label" style="font-size: 12px;  height:35px;">NID/Birth Reg. Number(If available)</label>
            <input type="text" name="survivor_nid" value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_nid : '' }}" id="" class="form-control form-control-sm" />
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label" style="font-size: 12px;  height:35px;">Reason of violence <span class="text-danger">*</span></label>
            <select name="survivor_reason_of_violence" id="" class="form-control form-control-sm @error('survivor_reason_of_violence') is-invalid @enderror">
                <option value="">Select Reason of violence</option>
                @foreach ($violenceReason as $reason)
                    <option {{ (count($selpIncident) > 0 && $selpIncident[0]->survivor_reason_id == $reason->id) || old('survivor_reason_of_violence') == $reason->id ? 'selected' : '' }} value="{{ $reason->id }}">{{ $reason->name }}</option>
                @endforeach
            </select>
            @error('survivor_reason_of_violence')
                <p style="color:red; margin-top:5px;">This field is required</p>
            @enderror
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label">Place of violence <span class="text-danger">*</span></label>
            <select name="survivor_place_of_violence" id="" class="form-control form-control-sm @error('survivor_place_of_violence') is-invalid @enderror">
                <option value="">Select Place of violence</option>
                @foreach ($violencePlace as $place)
                    <option {{ (count($selpIncident) > 0 && $selpIncident[0]->violence_place_id == $place->id) || old('survivor_place_of_violence') == $place->id ? 'selected' : '' }} value="{{ $place->id }}">{{ $place->name }}</option>
                @endforeach
            </select>
            @error('survivor_place_of_violence')
                <p style="color:red; margin-top:5px;">This field is required</p>
            @enderror
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-12">
            <p><strong><u>2. Defendant/Accused Other information : </u></strong></p>
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label">If accused family member(s) <span class="text-danger">*</span></label>
            <select name="if_perpetrator_family_member_yes_or_no" id="family_member_yes_or_no" class="form-control form-control-sm family_member_yes_or_no @error('if_perpetrator_family_member_yes_or_no') is-invalid @enderror">
                <option value=""> --Select-- </option>
                <option {{ count($selpIncident) > 0 && $selpIncident[0]->if_perpetrator_family_member_yes_or_no == 1 ? 'selected' : '' }} value="1"> Yes </option>
                <option {{ count($selpIncident) > 0 && $selpIncident[0]->if_perpetrator_family_member_yes_or_no == 2 ? 'selected' : '' }} value="2"> No </option>
            </select>
            @error('if_perpetrator_family_member_yes_or_no')
                <p style="color:red; margin-top:5px;">This field is required</p>
            @enderror
        </div>
        <div class="form-group col-sm-3 family-member" style="{{ (count($selpIncident) > 0 && $selpIncident[0]->defendant_family_member_id == 0) || (isset($selpIncident[0]) && $selpIncident[0]->defendant_family_member_id == null) ? 'display:none' : '' }}">
            <label class="control-label">family member(s) <span class="text-danger">*</span></label>
            <select name="if_perpetrator_family_member" id="" class="form-control form-control-sm">
                <option value="">Select family member</option>
                @foreach ($perpetratorRelation as $relation)
                    <option {{ count($selpIncident) > 0 && $selpIncident[0]->defendant_family_member_id == $relation->id ? 'selected' : '' }} value="{{ $relation->id }}">{{ $relation->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label">Education</label>
            <select name="perpetrator_education" id="" class="form-control form-control-sm">
                <option value="">Select Education</option>
                @foreach ($educations as $education)
                    <option {{ count($selpIncident) > 0 && $selpIncident[0]->defendant_education_id == $education->id ? 'selected' : '' }} value="{{ $education->id }}">{{ $education->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-sm-3">
            <label class="control-label">Occupation</label>
            <select name="perpetrator_occupation" id="" class="form-control form-control-sm">
                <option value="">Select Occupation</option>
                @foreach ($occupations as $occupation)
                    <option {{ count($selpIncident) > 0 && $selpIncident[0]->defendant_occupation_id == $occupation->id ? 'selected' : '' }} value="{{ $occupation->id }}">{{ $occupation->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <br>
    <div class="form-row" style="float: right">
        <a href="{{ route('incident.selp.add', ['tab' => 1, 'step' => 2, 'selp_incident_ref' => request()->selp_incident_ref]) }}" class="btn btn-success submit text-white mr-1">Back</a>
        <button type="submit" class="btn btn-info submit text-white mr-1" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Save & Next</button>
        @if ($user_info['user_role'][0]['role_id'] == 4)
            <button type="submit" name="save_destroy" class="btn btn-primary submit text-white mr-1">Close</button>
        @else
            <button type="submit" name="save_destroy" class="btn btn-primary submit text-white mr-1" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Draft & Close</button>
        @endif
        <button type="submit" name="save_destroy" class="btn btn-warning final text-white mr-1 d-none" onClick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Submit</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#section_A").show();
        $("#section_B").show();
    });

    $(document).ready(function() {
        $("#family_member_yes_or_no").change(function() {
            var if_perpetrator = $("#family_member_yes_or_no").val();
            // alert(if_perpetrator);
            if (if_perpetrator == 1) {
                $(".family-member").show();
            } else {
                $(".family-member").hide();
            }
        });

        const maritalStatusSelect = document.querySelector('#maritalStatus');
        const marriageAgeInput = document.querySelector('#marriageAge');

        // Function to set initial state based on marital status
        function setInitialState() {
            if (maritalStatusSelect.value == '2') { 
                marriageAgeInput.readOnly = true;
                marriageAgeInput.value = ''; // Clear the input value
            } else {
                marriageAgeInput.readOnly = false;
            }
        }

        // Set initial state on page load
        setInitialState();

        maritalStatusSelect.addEventListener('change', function () {
            if (this.value == '2') { // '2' is the value for 'Single'
                marriageAgeInput.readOnly = true;
                marriageAgeInput.value = ''; // Clear the input value
            } else {
                marriageAgeInput.readOnly = false;
            }
        });

    });
</script>
