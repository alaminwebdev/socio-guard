<form method="post" action="{{ route('incident.selp.step-2') }}">
    @csrf

    <input type="hidden" name="selp_incident_ref" value="{{ request()->selp_incident_ref }}">

    <input type="hidden" name="tab" value="2">
    <input type="hidden" name="step" value="3">
    <div class="form-row">
        <div class="form-group col-md-4">
            <p><strong><u>Is the applicant & survivor the same person?</u></strong></p>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <div class="form-check">
                    <input class="form-check-input"
                        {{ count($selpIncident) > 0 && $selpIncident[0]->applicant_survivor_same == 1 ? 'checked' : '' }}
                        type="radio" name="same_person" id="radio1" value="1">
                    <label class="form-check-label">Yes</label>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
                    <input class="form-check-input"
                        {{ count($selpIncident) > 0 && $selpIncident[0]->applicant_survivor_same == 2 ? 'checked' : '' }}
                        type="radio" name="same_person" id="radio2" value="2">
                    <label class="form-check-label">No</label>
                </div>
            </div>
        </div>
    </div>

    <div id="applicant_survivor_info_container"
        style="{{ (count($selpIncident) > 0 && $selpIncident[0]->applicant_survivor_same == 0) || (isset($selpIncident[0]) && $selpIncident[0]->applicant_survivor_same == null) ? 'display:none' : '' }}">
        {{-- Applicant's Information --}}
        <div class="form-row applicant_info"
            style="{{ count($selpIncident) > 0 && $selpIncident[0]->applicant_survivor_same == 2 ? '' : 'display:none' }}">
            <div class="form-group col-md-12">
                <p><strong><u>Applicant's Information : </u></strong></p>
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Applicant's Name <span class="text-danger">*</span></label>
                <input type="text" name="applicant_name"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->applicant_name : '' }}" id="survivor_name"
                    class="form-control form-control-sm @error('applicant_name') is-invalid @enderror">
                @error('applicant_name')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Father's Name</label>
                <input type="text" name="applicant_father_name"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->applicant_father_name : '' }}"
                    id="survivor_father_name" class="form-control form-control-sm">
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Mother's Name</label>
                <input type="text" name="applicant_mother_name"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->applicant_mother_name : '' }}"
                    id="survivor_mother_name" class="form-control form-control-sm">
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label" style="font-size: 10px">Husband's Name (If Applicable)</label>
                <input type="text" name="applicant_husband_name"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->applicant_husband_name : '' }}"
                    id="survivor_husband_name" class="form-control form-control-sm">
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Age</label>
                <input type="text" name="applicant_age"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->applicant_age : '' }}" id="survivor_name"
                    class="form-control form-control-sm InputPhone" maxlength="3"
                    onkeypress="return isNumberKey(event)">
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Cell number(self)</label>
                <input type="text" name="applicant_contact_no"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->applicant_mobile_number : '' }}"
                    id="survivor_name" class="form-control form-control-sm InputPhone" maxlength="11">
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Cell number(on request)</label>
                <input type="text" name="applicant_2nd_contact_no"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->applicant_mobile_number_on_request : '' }}"
                    id="survivor_name" class="form-control form-control-sm InputPhone" maxlength="11">
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Gender</label>
                <select name="applicant_sex" id="" class="form-control form-control-sm">
                    <option value="">Select Gender</option>
                    @foreach ($genders as $gender)
                        <option
                            {{ count($selpIncident) > 0 && $selpIncident[0]->applicant_gender_id == $gender->id ? 'selected' : '' }}
                            value="{{ $gender->id }}">{{ $gender->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Education</label>
                <select name="applicant_education" id="" class="form-control form-control-sm">
                    <option value="">Select Education</option>
                    @foreach ($educations as $education)
                        <option
                            {{ count($selpIncident) > 0 && $selpIncident[0]->applicant_education_id == $education->id ? 'selected' : '' }}
                            value="{{ $education->id }}">{{ $education->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Occupation</label>
                <select name="applicant_occupation" id="" class="form-control form-control-sm">
                    <option value="">Select Occupation</option>
                    @foreach ($occupations as $occupation)
                        <option
                            {{ count($selpIncident) > 0 && $selpIncident[0]->application_occupation_id == $occupation->id ? 'selected' : '' }}
                            value="{{ $occupation->id }}">{{ $occupation->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Religion</label>
                <select name="applicant_religion" id="" class="form-control form-control-sm">
                    <option value="">Select Religion</option>
                    @foreach ($religions as $religion)
                        <option
                            {{ count($selpIncident) > 0 && $selpIncident[0]->applicant_religion_id == $religion->id ? 'selected' : '' }}
                            value="{{ $religion->id }}">{{ $religion->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Division</label>
                <select name="applicant_division" id="applicant_division_id" class="form-control form-control-sm">
                    <option value="">Select Division</option>
                    @foreach ($divisions as $item)
                        <option
                            {{ count($selpIncident) > 0 && $selpIncident[0]->applicant_division_id == $item->id ? 'selected' : '' }}
                            value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">District</label>
                <select name="applicant_district" id="applicant_district_id" class="form-control form-control-sm">
                    @if (count($selpIncident) > 0)
                        {!! getdistrict($selpIncident[0]->applicant_division_id, $selpIncident[0]->applicant_district_id) !!};
                    @else
                        <option value="">Select District</option>
                    @endif
                </select>
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Upazila</label>
                <select name="applicant_upazila" id="applicant_upazila_id" class="form-control form-control-sm">
                    @if (count($selpIncident) > 0)
                        {!! getupazila($selpIncident[0]->applicant_district_id, $selpIncident[0]->applicant_upazila_id) !!};
                    @else
                        <option value="">Select Upazila</option>
                    @endif
                </select>
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Union</label>
                <select name="applicant_union" id="applicant_union_id" class="form-control form-control-sm">
                    @if (count($selpIncident) > 0)
                        {!! getunion($selpIncident[0]->applicant_upazila_id, $selpIncident[0]->applicant_union_id) !!};
                    @else
                        <option value="">Select Union</option>
                    @endif
                </select>
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Village</label>
                <input type="text"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->applicant_village_name : '' }}"
                    name="applicant_village_name" id="applicant_village_name" class="form-control form-control-sm">
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label">Applicant Ward/Para</label>
                {{-- <textarea name="applicant_ward_para" style="width:100%" id="" cols="30" rows="5"></textarea> --}}
                <input type="text" value="{{ count($selpIncident) > 0 ? $selpIncident[0]->applicant_ward : '' }}"
                    name="applicant_ward_para" value="" id="survivor_name"
                    class="form-control form-control-sm">
            </div>
        </div>

        {{-- Survivor's Information --}}
        <div class="form-row survivor_info"
            style="{{ count($selpIncident) > 0 && $selpIncident[0]->applicant_survivor_same == 1 ? 'checked' : '' }}">
            <div class="form-group col-md-12">
                <p><strong><u>Survivors Information : </u></strong></p>
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Survivor's Name <span class="text-danger">*</span></label>
                <input type="text" value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_name : '' }}"
                    name="survivor_name" value="" id="survivor_name"
                    class="form-control form-control-sm @error('survivor_name') is-invalid @enderror" required="">
                @error('survivor_name')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Father's Name</label>
                <input type="text" name="survivor_father_name"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_father_name : '' }}"
                    id="survivor_father_name" class="form-control form-control-sm">
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Mother's Name</label>
                <input type="text" name="survivor_mother_name"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_mother_name : '' }}"
                    id="survivor_mother_name" class="form-control form-control-sm">
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Husband's Name (If Applicable)</label>
                <input type="text" name="survivor_husband_name"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_husband_name : '' }}"
                    id="survivor_husband_name" class="form-control form-control-sm">
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Cell number self</label>
                <input type="text" name="survivor_contact_no"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_mobile_number : '' }}"
                    id="survivor_name" class="form-control form-control-sm InputPhone" maxlength="11">
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Cell number on request</label>
                <input type="text" name="survivor_2nd_contact_no"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_mobile_number_on_request : '' }}"
                    id="survivor_name" class="form-control form-control-sm InputPhone" maxlength="11">
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Age <span class="text-danger" style="font-size: 12px; font-weight:600;">* (Maximum Age : 100)</span></label>
                <input type="number" name="survivor_age"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_age : '' }}" id="survivor_name"
                    class="form-control form-control-sm InputPhone @error('survivor_age') is-invalid @enderror"
                    maxlength="3" max="100" onkeypress="return isNumberKey(event)" required="">
                @error('survivor_age')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Gender <span class="text-danger">*</span></label>
                <select name="survivor_sex" id=""
                    class="form-control form-control-sm @error('survivor_sex') is-invalid @enderror" required="">
                    <option value="">Select Gender</option>
                    @foreach ($genders as $gender)
                        <option
                            {{ (count($selpIncident) > 0 && $selpIncident[0]->survivor_gender_id == $gender->id) || old('survivor_sex') == $gender->id ? 'selected' : '' }}
                            value="{{ $gender->id }}">{{ $gender->name }}</option>
                    @endforeach
                </select>
                @error('survivor_sex')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Education</label>
                <select name="survivor_education" id="" class="form-control form-control-sm">
                    <option value="">Select Education</option>
                    @foreach ($educations as $education)
                        <option
                            {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_education_id == $education->id ? 'selected' : '' }}
                            value="{{ $education->id }}">{{ $education->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Occupation</label>
                <select name="survivor_occupation" id="" class="form-control form-control-sm">
                    <option value="">Select Occupation</option>
                    @foreach ($occupations as $occupation)
                        <option
                            {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_occupation_id == $occupation->id ? 'selected' : '' }}
                            value="{{ $occupation->id }}">{{ $occupation->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Religion</label>
                <select name="survivor_religion" id="" class="form-control form-control-sm">
                    <option value="">Select Religion</option>
                    @foreach ($religions as $religion)
                        <option
                            {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_religion_id == $religion->id ? 'selected' : '' }}
                            value="{{ $religion->id }}">{{ $religion->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Disability status </label>
                <select name="survivor_disability_status" id=""
                    class="form-control form-control-sm @error('survivor_disability_status') is-invalid @enderror"
                    required="">
                    <option value="">Select Disability status <span class="text-danger">*</span></option>
                    @foreach ($disabilityStatus as $disability)
                        <option
                            {{ (count($selpIncident) > 0 && $selpIncident[0]->survivor_disability_status == $disability->id) || old('survivor_disability_status') == $disability->id ? 'selected' : '' }}
                            value="{{ $disability->id }}">{{ $disability->name }}</option>
                    @endforeach
                </select>
                @error('survivor_disability_status')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Division <span class="text-danger">*</span></label>
                <select name="survivor_division" id="survivor_division_id"
                    class="form-control form-control-sm @error('survivor_division') is-invalid @enderror"
                    required="">
                    <option value="">Select Division</option>
                    @foreach ($divisions as $item)
                        <option
                            {{ (count($selpIncident) > 0 && $selpIncident[0]->survivor_division_id == $item->id) || old('survivor_division') == $item->id ? 'selected' : '' }}
                            value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('survivor_division')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">District <span class="text-danger">*</span></label>
                <select name="survivor_district" id="survivor_district_id"
                    class="form-control form-control-sm @error('survivor_district') is-invalid @enderror"
                    required="">
                    @if (count($selpIncident) > 0)
                        {!! getdistrict($selpIncident[0]->survivor_division_id, $selpIncident[0]->survivor_district_id) !!};
                    @else
                        <option value="">Select District</option>
                    @endif
                </select>
                @error('survivor_district')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Upazila<span class="text-danger">*</span></label>
                
                {{-- {{ dd(getupazila($selpIncident[0]->survivor_district_id, $selpIncident[0]->survivor_upazila_id)) }} --}}
                <select name="survivor_upazila" id="survivor_upazila_id"
                    class="form-control form-control-sm @error('survivor_upazila') is-invalid @enderror"
                    required="">
                    @if (count($selpIncident) > 0)
                        {!! getupazila($selpIncident[0]->survivor_district_id, $selpIncident[0]->survivor_upazila_id) !!};
                    @else
                        <option value="">Select Upazila</option>
                    @endif
                </select>
                @error('survivor_upazila')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Union <span class="text-danger">*</span></label>
                <select name="survivor_union" id="survivor_union_id"
                    class="form-control form-control-sm @error('survivor_union') is-invalid @enderror" required="">
                    @if (count($selpIncident) > 0)
                        {!! getunion($selpIncident[0]->survivor_upazila_id, $selpIncident[0]->survivor_union_id) !!};
                    @else
                        <option value="">Select Union</option>
                    @endif
                </select>
                @error('survivor_union')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Village <span class="text-danger">*</span></label>
                <input type="text"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_village_name : '' }}"
                    name="survivor_village_name" id="survivor_village_name"
                    class="form-control form-control-sm @error('survivor_village_name') is-invalid @enderror"
                    required="">
                @error('survivor_village_name')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label"> Ward/Para</label>
                {{-- <textarea name="survivor_ward_para" style="width:100%" id="" cols="30" rows="5"></textarea> --}}
                <input type="text" name="survivor_ward_para"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_ward : '' }}" id="survivor_name"
                    class="form-control form-control-sm">
            </div>
        </div>

        {{-- Defendant’s Information --}}
        <div class="form-row defendant_info" style="{{ count($selpIncident) > 0 ? '' : 'display:none' }}">
            <div class="form-group col-md-12">
                <p><strong><u>Defendant/Accused information : </u></strong></p>
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Number of the Accused(s) </label>
                <input type="text" name="number_of_defendant"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->number_of_defendants : old('number_of_defendant') }}"
                    id=""
                    class="form-control form-control-sm InputPhone @error('number_of_defendant') is-invalid @enderror"
                    maxlength="2" required="">
                @error('number_of_defendant')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Name of Main Accused </label>
                <input type="text" name="name_of_main_defendant"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->main_defendants_name : old('name_of_main_defendant') }}"
                    id=""
                    class="form-control form-control-sm @error('name_of_main_defendant') is-invalid @enderror"
                    required="">
                @error('name_of_main_defendant')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>

            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Survivors' Relationship with Accused </label>
                <select name="relation_with_main_defendant" id=""
                    class="form-control form-control-sm @error('relation_with_main_defendant') is-invalid @enderror"
                    required="">
                    <option value="">-- Select --</option>
                    @foreach ($accuseRelationship as $item)
                        <option
                            {{ (count($selpIncident) > 0 && $selpIncident[0]->main_defendant_relation_id == $item->id) || old('relation_with_main_defendant') == $item->id ? 'selected' : '' }}
                            value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('relation_with_main_defendant')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Gender </label>
                <select name="defendant_gender" id=""
                    class="form-control form-control-sm @error('defendant_gender') is-invalid @enderror"
                    required="">
                    <option value="">Select Gender</option>
                    @foreach ($genders as $gender)
                        <option
                            {{ (count($selpIncident) > 0 && $selpIncident[0]->main_defendant_gender_id == $gender->id) || old('defendant_gender') == $gender->id ? 'selected' : '' }}
                            value="{{ $gender->id }}">{{ $gender->name }}</option>
                    @endforeach
                </select>
                @error('defendant_gender')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Age </label>
                <input type="number" name="defendant_age"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->main_defendant_age : '' }}"
                    id="survivor_name" class="form-control form-control-sm InputPhone" maxlength="3"  max="100"
                    onkeypress="return isNumberKey(event)">
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Division</label>
                <select name="defendant_division" id="defendant_division_id" class="form-control form-control-sm">
                    <option value="">Select Division</option>
                    @foreach ($divisions as $item)
                        <option
                            {{ count($selpIncident) > 0 && $selpIncident[0]->defendant_division_id == $item->id ? 'selected' : '' }}
                            value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">District</label>
                <select name="defendant_district" id="defendant_district_id" class="form-control form-control-sm">

                    @if (count($selpIncident) > 0)
                        {!! getdistrict($selpIncident[0]->defendant_division_id, $selpIncident[0]->defendant_district_id) !!};
                    @else
                        <option value="">Select District</option>
                    @endif

                </select>
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Upazila</label>
                <select name="defendant_upazila" id="defendant_upazila_id" class="form-control form-control-sm">
                    @if (count($selpIncident) > 0)
                        {!! getupazila($selpIncident[0]->defendant_district_id, $selpIncident[0]->defendant_upazila_id) !!};
                    @else
                        <option value="">Select Upazila</option>
                    @endif
                </select>
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Union</label>
                <select name="defendant_union" id="defendant_union_id" class="form-control form-control-sm">
                    @if (count($selpIncident) > 0)
                        {!! getunion($selpIncident[0]->defendant_upazila_id, $selpIncident[0]->defendant_union_id) !!};
                    @else
                        <option value="">Select Union</option>
                    @endif
                </select>
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Village</label>
                <input type="text"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->defendant_village_name : '' }}"
                    name="defendant_village_name" id="defendant_village_name" class="form-control form-control-sm">
            </div>
            <div class="form-group col-sm-2 column_5_1">
                <label class="control-label"> Ward/Para</label>
                {{-- <textarea name="applicant_ward_para" style="width:100%" id="" cols="30" rows="5"></textarea> --}}
                <input type="text" name="defendant_ward_para"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->defendant_ward : '' }}" id="survivor_name"
                    class="form-control form-control-sm">
            </div>
        </div>


        <div class="form-row initiative_taken" style="">
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">First initiative taken from SELP <span
                        class="text-danger">*</span></label>
                <select name="selp_initiative" id="selp_initiative"
                    class="form-control form-control-sm @error('selp_initiative') is-invalid @enderror"
                    required="">
                    <option value=""> -- Select -- </option>
                    <option
                        {{ (count($selpIncident) > 0 && $selpIncident[0]->selp_initiative == 4) || old('selp_initiative') == 4 ? 'selected' : '' }}
                        value="4">Legal Advice </option>
                    <option
                        {{ (count($selpIncident) > 0 && $selpIncident[0]->selp_initiative == 1) || old('selp_initiative') == 1 ? 'selected' : '' }}
                        value="1"> Referral </option>
                    <option
                        {{ (count($selpIncident) > 0 && $selpIncident[0]->selp_initiative == 3) || old('selp_initiative') == 3 ? 'selected' : '' }}
                        value="3"> Violence Incident Documented </option>
                    <option {{ count($selpIncident) > 0 && $selpIncident[0]->selp_initiative == 2 ? 'selected' : '' }}
                        value="2"> Complain Received </option>
                </select>
                @error('selp_initiative')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
        </div>

        {{-- <div class="form-row advice_referrel" style="{{(count($selpIncident)>0 && $selpIncident[0]->selp_initiative!=1) || (count($selpIncident)>0 && $selpIncident[0]->selp_initiative==null) ? '' : 'display: none' }}"> --}}
        <div class="form-row advice_referrel"
            style="{{ count($selpIncident) > 0 && ($selpIncident[0]->selp_initiative != 1 || $selpIncident[0]->selp_initiative == null) ? 'display: none' : '' }}">
            <div class="form-group col-sm-3">
                <label class="control-label">Refferal No. <span class="text-danger">*</span></label>
                <input type="text" name="referral_no"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->referral_no : '' }}" id="survivor_name"
                    class="form-control form-control-sm @error('referral_no') is-invalid @enderror">
                @error('referral_no')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Refferal To <span class="text-danger">*</span></label>
                <select name="referral_to" id=""
                    class="form-control form-control-sm @error('referral_to') is-invalid @enderror">
                    <option value="">Select Refferal To</option>
                    @foreach ($refferals as $refferal)
                        <option
                            {{ count($selpIncident) > 0 && $selpIncident[0]->referral == $refferal->id ? 'selected' : '' }}
                            value="{{ $refferal->id }}">{{ $refferal->name }}</option>
                    @endforeach
                </select>
                @error('referral_to')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Date <span class="text-danger">*</span></label>
                <input type="text" name="referral_date"
                    value="{{ count($selpIncident) > 0 && $selpIncident[0]->referral_date != null ? date('d-m-Y', strtotime($selpIncident[0]->referral_date)) : '' }}"
                    id=""
                    class="form-control form-control-sm datepicker @error('referral_date') is-invalid @enderror">
                @error('referral_date')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
        </div>
        {{-- @if ($user_info['user_role'][0]['role_id'] == 4)
<p>District Manager</p>
@else
<p>Field Manager</p>
@endif --}}
        <br>
        <div class="form-row" style="float: right">
            <a href="{{ url('incident/selp/add?back=1&selp_incident_ref=' . request()->selp_incident_ref) }}"
                class="btn btn-success submit text-white mr-1">Back</a>
            {{-- <button type="submit" class="btn btn-info submit next text-white mr-1" style="{{count($selpIncident)>0 && ($selpIncident[0]->selp_initiative==null || $selpIncident[0]->selp_initiative==1 || $selpIncident[0]->selp_initiative==3) ? 'display: none' : '' }}">Save & Next</button> --}}
            <button type="submit" class="btn btn-info submit next text-white mr-1"
                style="{{ count($selpIncident) > 0 && $selpIncident[0]->selp_initiative != 2 ? 'display: none' : '' }}">Save
                & Next</button>


            <button type="submit" name="save_destroy" class="btn btn-primary draft_submit text-white mr-1"
                style="{{ count($selpIncident) > 0 && ($selpIncident[0]->selp_initiative == 1 || $selpIncident[0]->selp_initiative == 3 || $selpIncident[0]->selp_initiative == 4) && $selpIncident[0]->selp_initiative != null ? 'display: none' : '' }}">
                {{ count($selpIncident) > 0 && Auth::user()->pin == $selpIncident[0]->employee_pin ? ' Draft & Close ' : ' Close' }}
            </button>

            {{-- If FO Login ROLE ID - 5 --}}
            @if ($user_info['user_role'][0]['role_id'] == 5)
                @if (count($selpIncident) > 0 &&
                        ($selpIncident[0]->selp_initiative == 1 ||
                            $selpIncident[0]->selp_initiative == 3 ||
                            $selpIncident[0]->selp_initiative == 4))
                    <button type="submit" name="save_destroy"
                        class="btn btn-warning final text-white mr-1">Submit</button>
                @else
                    <button type="submit" name="save_destroy" class="btn btn-warning final text-white mr-1"
                        style="display: none;">Submit</button>
                @endif
            @endif

            {{-- If DM Login ROLE ID - 4 OR Temporary Zonal Manager Role ID - 12 --}}
            @if ($user_info['user_role'][0]['role_id'] == 4 || $user_info['user_role'][0]['role_id'] == 1 || $user_info['user_role'][0]['role_id'] == 12)
                @if (count($selpIncident) > 0 &&
                        ($selpIncident[0]->selp_initiative == 1 ||
                            $selpIncident[0]->selp_initiative == 3 ||
                            $selpIncident[0]->selp_initiative == 4))
                    <button type="submit" name="save_destroy" class="btn btn-warning final text-white mr-1"
                        style="">Approve</button>
                    <input type="hidden" name="dm_approve" value="2">
                @else
                    {{-- <button type="submit" name="save_destroy" class="btn btn-warning final text-white mr-1" style="display: none;">Submit</button> --}}
                    <button type="submit" name="save_destroy" class="btn btn-warning final text-white mr-1"
                        style="display:none">Approve</button>
                    {{-- <input type="hidden" name="dm_approve" value="2"> --}}
                @endif
            @endif

        </div>
</form>
</div>
<script>
    $(document).ready(function() {
        $("#selp_initiative").change(function() {
            var selp_initiative = $("#selp_initiative").val();
            if (selp_initiative == 1) {
                $(".advice_referrel").show();
                $(".final").show();

                $("#section_A").hide();
                $("#section_B").hide();
                $(".next").hide();
                $(".submit-close").hide();
                $(".draft_submit").hide();
            } else if (selp_initiative == 2) {
                $("#section_A").show();
                $("#section_B").show();
                $(".draft_submit").show();
                $(".back").hide();
                $(".next").show();

                $(".advice_referrel").hide();
                $(".final").hide();
            } else if (selp_initiative == 3) {
                $(".advice_referrel").hide();
                $(".final").show();

                $("#section_A").hide();
                $("#section_B").hide();
                $(".next").hide();
                $(".submit-close").hide();
                $(".draft_submit").hide();
            } else if (selp_initiative == 4) {
                $(".advice_referrel").hide();
                $(".final").show();

                $("#section_A").hide();
                $("#section_B").hide();
                $(".next").hide();
                $(".submit-close").hide();
                $(".draft_submit").hide();
            } else {
                $("#section_A").hide();
                $("#section_B").hide();
                $(".next").hide();
                $(".submit-close").hide();
                $(".draft_submit").hide();
                $(".final").hide();
                $(".advice_referrel").hide();
            }
        });
    });
</script>

<script>
    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>

{{-- Script for applicant data --}}
<script type="text/javascript">
    $(function() {
        $(document).on('change', '#applicant_division_id', function() {
            // var region_id = $('#region_id').val();
            var division_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-district') }}",
                type: "GET",
                data: {
                    division_id: division_id
                },
                success: function(data) {

                    var html = '<option value="">Select District</option>';
                    for (var i = 0; i < data[0].length; i++) {
                        html += '<option value="' + data[0][i].id + '">' + data[0][i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#applicant_district_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#applicant_district_id', function() {
            // var region_id = $('#region_id').val();
            var district_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-upazila') }}",
                type: "GET",
                data: {
                    district_id: district_id
                },
                success: function(data) {

                    var html = '<option value="">Select Upazila</option>';
                    for (var i = 0; i < data[0].length; i++) {
                        html += '<option value="' + data[0][i].id + '">' + data[0][i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#applicant_upazila_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#applicant_upazila_id', function() {
            // var region_id = $('#region_id').val();
            var upazila_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-union') }}",
                type: "GET",
                data: {
                    upazila_id: upazila_id
                },
                success: function(data) {

                    var html = '<option value="">Select Union</option>';
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#applicant_union_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#applicant_union_id', function() {
            // var region_id = $('#region_id').val();
            var union_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-village') }}",
                type: "GET",
                data: {
                    union_id: union_id
                },
                success: function(data) {

                    var html = '<option value="">Select Village</option>';
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#applicant_village_id').html(html);
                }
            });
        });
    });
</script>

{{-- Script for applicant data --}}



{{-- Script for survivor data --}}
<script type="text/javascript">
    $(function() {
        $(document).on('change', '#survivor_division_id', function() {
            // var region_id = $('#region_id').val();
            var division_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-district') }}",
                type: "GET",
                data: {
                    division_id: division_id
                },
                success: function(data) {

                    var html = '<option value="">Select District</option>';
                    for (var i = 0; i < data[0].length; i++) {
                        html += '<option value="' + data[0][i].id + '">' + data[0][i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#survivor_district_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#survivor_district_id', function() {
            // var region_id = $('#region_id').val();
            var district_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-upazila') }}",
                type: "GET",
                data: {
                    district_id: district_id
                },
                success: function(data) {

                    var html = '<option value="">Select Upazila</option>';
                    for (var i = 0; i < data[0].length; i++) {
                        html += '<option value="' + data[0][i].id + '">' + data[0][i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#survivor_upazila_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#survivor_upazila_id', function() {
            // var region_id = $('#region_id').val();
            var upazila_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-union') }}",
                type: "GET",
                data: {
                    upazila_id: upazila_id
                },
                success: function(data) {

                    var html = '<option value="">Select Union</option>';
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#survivor_union_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#survivor_union_id', function() {
            // var region_id = $('#region_id').val();
            var union_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-village') }}",
                type: "GET",
                data: {
                    union_id: union_id
                },
                success: function(data) {

                    var html = '<option value="">Select Village</option>';
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#survivor_village_id').html(html);
                }
            });
        });
    });
</script>

{{-- Script for survivor data --}}



{{-- Script for defendant data --}}
<script type="text/javascript">
    $(function() {
        $(document).on('change', '#defendant_division_id', function() {
            // var region_id = $('#region_id').val();
            var division_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-district') }}",
                type: "GET",
                data: {
                    division_id: division_id
                },
                success: function(data) {

                    var html = '<option value="">Select District</option>';
                    for (var i = 0; i < data[0].length; i++) {
                        html += '<option value="' + data[0][i].id + '">' + data[0][i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#defendant_district_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#defendant_district_id', function() {
            // var region_id = $('#region_id').val();
            var district_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-upazila') }}",
                type: "GET",
                data: {
                    district_id: district_id
                },
                success: function(data) {

                    var html = '<option value="">Select Upazila</option>';
                    for (var i = 0; i < data[0].length; i++) {
                        html += '<option value="' + data[0][i].id + '">' + data[0][i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#defendant_upazila_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#defendant_upazila_id', function() {
            // var region_id = $('#region_id').val();
            var upazila_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-union') }}",
                type: "GET",
                data: {
                    upazila_id: upazila_id
                },
                success: function(data) {

                    var html = '<option value="">Select Union</option>';
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#defendant_union_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#defendant_union_id', function() {
            // var region_id = $('#region_id').val();
            var union_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-village') }}",
                type: "GET",
                data: {
                    union_id: union_id
                },
                success: function(data) {

                    var html = '<option value="">Select Village</option>';
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name +
                            '</option>';
                    }
                    // $.each(data,function(key,v){
                    //   console.log(data[key]);
                    // 	//html +='<option value="'+v[key].district_id+'">'+v[key].name+'</option>';
                    // });
                    $('#defendant_village_id').html(html);
                }
            });
        });
    });
</script>

{{-- Script for defendant data --}}
