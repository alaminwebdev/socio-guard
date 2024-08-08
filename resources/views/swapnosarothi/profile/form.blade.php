@if (@$editData)
    <form method="post" action="{{ route('swapnosarothiprofile.update', @$editData->id) }}" id="swapnoSarothiForm" enctype="multipart/form-data">
        @method('PUT')
        <input type="hidden" value="{{ auth()->user()->id }}" name="updated_by">
    @else
        <form method="post" action="{{ route('swapnosarothiprofile.store') }}" id="swapnoSarothiForm" enctype="multipart/form-data">
            <input type="hidden" value="{{ auth()->user()->id }}" name="craeted_by">
@endif
@csrf
<div class="card-body">
    <div class="show_module_more_event">
        <div class="row">
            <div class="form-group col-md-4">
                <label class="control-label">Profile Id <span class="text-danger">*</span></label>
                <input type="text" name="profile_id" id="profile_id" class="form-control form-control-sm" value="{{ old('profile_id', @$editData->profile_id) }}" placeholder="Profile Id" readonly>
            </div>
            <div class="form-group col-md-4">
                <label class="control-label">Profile Start Date <span class="text-danger">*</span> </label>
                @if (@$editData)
                    @php
                        $start_date = @$editData->start_date ? @$editData->start_date->format('Y-m-d') : '';
                    @endphp
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ old('start_date', $start_date) }}">
                @else
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ old('start_date') }}">
                @endif
                @error('start_date')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class=" col-md-4 align-self-center">
                <strong>Created Date: {{ @$editData ? @$editData->created_at->format('d-M-Y') : date('d-M-Y') }}
                </strong>
            </div>
        </div>
        <hr>

        <div class="form-row" style="margin-top: -12px;margin-bottom: -12px;">
            <div class="form-group col-md-12">
                <p class="mb-0"><strong><u>Employee Address:</u></strong></p>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Zone <span class="text-danger">*</span></label>
                @if (@$editData)
                    <select name="employee_zone_id" class="region_id form-control form-control-sm" required="" readonly>
                        <option value="{{ @$editData->employee_zone_id }}" selected>{{ @$editData->employee_zone->region_name }}</option>
                    </select>
                @else
                    @if (count(session()->get('userareaaccess.sregions')) > 0)
                        <select name="employee_zone_id" id="emp_region_id" class="region_id form-control form-control-sm select2" required="">
                            <option value="">Select zone</option>
                            @foreach ($zones as $key => $region)
                                @if (in_array($region->id, session()->get('userareaaccess.sregions')))
                                    <option value="{{ $region->id }}" {{ @$editData->employee_zone_id == $region->id ? 'selected' : '' }}>
                                        {{ $region->region_name }}</option>
                                @endif
                            @endforeach
                        </select>
                    @else
                        <select name="employee_zone_id" id="emp_region_id" class="region_id form-control form-control-sm select2" required="">
                            <option value="">Select Zone</option>
                            @foreach ($zones as $region)
                                <option value="{{ $region->id }}" {{ @$editData->employee_zone_id == $region->id ? 'selected' : '' }}>
                                    {{ $region->region_name }}</option>
                            @endforeach
                        </select>
                    @endif
                @endif

                @error('employee_zone_id')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Division <span class="text-danger">*</span></label>
                @if (@$editData)
                    <select name="employee_division_id" class="division_id form-control form-control-sm" required="" readonly>
                        <option value="{{ @$editData->employee_division_id }}" selected>{{ @$editData->employee_division->name }}</option>
                    </select>
                @else
                    <select name="employee_division_id" id="emp_division_id" class="division_id form-control form-control-sm" required="">
                        {{-- @if (@$editData) --}}

                        {{-- @if (count(session()->get('userareaaccess.sregions')) == 1)
                            {!! getUserDivisions(session()->get('userareaaccess.sregions')[0]) !!}
                        @else
                            {!! getRegionalDivision(@$editData->employee_zone_id, @$editData->employee_division_id) !!};
                        @endif --}}
                        {{-- @else --}}
                        @if (count(session()->get('userareaaccess.sregions')) == 1)
                            {!! getUserDivisions(session()->get('userareaaccess.sregions')[0]) !!}
                        @else
                            <option value="">Select Division</option>
                        @endif
                        {{-- @endif --}}
                    </select>

                @endif
                @error('employee_division_id')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">District <span class="text-danger">*</span></label>
                @if (@$editData)
                    <select name="employee_district_id" class="district_id form-control form-control-sm" required="" readonly>
                        <option value="{{ @$editData->employee_district_id }}" selected>{{ @$editData->employee_district->name }}</option>
                    </select>
                @else
                    <select name="employee_district_id" id="emp_district_id" class="district_id form-control form-control-sm" required>
                        <option value="">Select District</option>
                    </select>
                @endif
                {{-- <select name="employee_district_id" id="emp_district_id" class="district_id form-control form-control-sm" required>
                    @if (@$editData)
                        {!! getRegionalDivisionDistrict(@$editData->employee_zone_id, @$editData->employee_division_id, @$editData->employee_district_id) !!};
                    @else
                        <option value="">Select District</option>
                    @endif
                </select> --}}
                @error('employee_district_id')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Upazila <span class="text-danger">*</span></label>
                @if (@$editData)
                    <select name="employee_upazila_id" class="upazila_id form-control form-control-sm" required="" readonly>
                        <option value="{{ @$editData->employee_upazila_id }}" selected>{{ @$editData->employee_upazila->name }}</option>
                    </select>
                @else
                    <select name="employee_upazila_id" id="emp_upazila_id" class="upazila_id emp_upazila_id form-control form-control-sm" required>
                        <option value="">Select Upazila</option>
                    </select>
                @endif
                {{-- <select name="employee_upazila_id" id="emp_upazila_id" class="upazila_id emp_upazila_id form-control form-control-sm" required>
                    @if (@$editData)
                        {!! getupazila(@$editData->employee_district_id, @$editData->employee_upazila_id) !!};
                    @else
                        <option value="">Select Upazila</option>
                    @endif
                </select> --}}
                @error('employee_upazila_id')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
        </div>
        <hr>

        <div class="form-row">
            <div class="form-group col-md-12">
                <p class="mb-0"><strong><u>Girl's Profile Info:</u></strong></p>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Group Name <span class="text-danger">*</span> </label>
                <select name="group_id" id="group_id" class="form-control form-control-sm select2">
                    @if (@$editData)
                        <option value="">Select Group</option>
                        @foreach (@$group_names as $group_name)
                            <option value="{{ @$group_name->id }}" {{ @$editData->group_id == @$group_name->id ? 'selected' : '' }}>
                                {{ @$group_name->group_name }} 
                            </option>
                        @endforeach
                    @else
                        <option value="">Select Group</option>
                    @endif

                </select>
                @error('group_id')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Status <span class="text-danger">*</span> </label>
                @if (@$editData)
                    <select name="group_status" id="group_status" class="form-control form-control-sm">
                        <option value="">Select Status</option>
                        @if (@$editData->group_status == 'married')
                            <option value="married" selected>Married</option>
                        @else
                            <option value="ongoing" {{ @$editData->group_status == 'ongoing' ? 'selected' : '' }}>
                                Ongoing</option>
                            <option value="migrated" {{ @$editData->group_status == 'migrated' ? 'selected' : '' }}>
                                Migrated</option>
                            <option value="droupout" {{ @$editData->group_status == 'droupout' ? 'selected' : '' }}>
                                Drop out</option>
                            <option value="graduated" {{ @$editData->group_status == 'graduated' ? 'selected' : '' }}>
                                Graduated</option>
                        @endif
                    </select>
                @else
                    <input type="text" name="group_status" class="form-control form-control-sm" value="ongoing" placeholder="Group Status" readonly>
                @endif
                @error('group_status')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3" id="status_date">
                @if (@$editData->status_date)
                    <label class="control-label">Date <span class="text-danger">*</span> </label>
                    <input type="date" class="form-control form-control-sm" value="{{ @$editData->status_date }}" name="status_date" required>
                    @error('status_date')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                @endif

            </div>
            <div class="form-group col-md-3" id="reason">
                {{-- @if (@$editData->reason)
                    <label class="control-label">Reason</label>
                    <input type="text" value="{{ @$editData->reason }}" class="form-control form-control-sm" name="reason">
                    @error('reason')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                @endif --}}
                @if (@$editData->reason_id)
                    @if (@$editData->group_status == 'migrated')
                        <label class="control-label">Migrated Reason <span class="text-danger">*</span></label>
                        <select name="reason_id" id="" class="migrated_reason form-control form-control-sm" required>
                            <option value="">Select Migrated Reason</option>
                            @foreach ($migrated_reasons as $reason)
                                <option value="{{ $reason->id }}" {{ @$editData->reason_id == $reason->id ? 'selected' : '' }}>{{ $reason->name }}</option>
                            @endforeach
                        </select>
                    @elseif(@$editData->group_status == 'droupout')
                        <label class="control-label">Dropout Reason <span class="text-danger">*</span></label>
                        <select name="reason_id" id="" class="dropout_reason form-control form-control-sm" required>
                            <option value="">Select Dropout Reason</option>
                            @foreach ($dropout_reasons as $reason)
                                <option value="{{ $reason->id }}" {{ @$editData->reason_id == $reason->id ? 'selected' : '' }}>{{ $reason->name }}</option>
                            @endforeach
                        </select>
                    @endif
                    @error('reason_id')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror
                @endif

            </div>
        </div>
        <hr>
        <div class="form-row">

            <div class="form-group col-md-3">
                <label class="control-label">Name <span class="text-danger">*</span> </label>
                <input type="text" name="name" class="form-control form-control-sm" value="{{ old('name', @$editData->name) }}" placeholder="Name">
                @error('name')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Date Of Birth <span class="text-danger">*</span> </label>
                <input type="text" name="date_of_birth" class="form-control form-control-sm dateofbirth">
                @error('date_of_birth')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Age</label>
                <input type="text" name="age" class="form-control form-control-sm age" value="{{ @$editData->age }}" placeholder="Age" readonly>
                @error('age')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Date of completion of 18 years</label>
                <input type="text" value="{{ @$editData->age_completion_date ? @$editData->age_completion_date->format('d-m-Y') : '' }}" name="age_completion_date" class="form-control form-control-sm age_completion_date" readonly>
                @error('age_completion_date')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Phone</label>
                <input type="text" name="phone" class="form-control form-control-sm" placeholder="Phone" value="{{ old('phone', @$editData->phone) }}">
                @error('phone')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Disability status?</label>
                <select class="form-control form-control-sm disability_status">
                    <option value="0" {{ @$editData->disability_type == null ? 'selected' : '' }}>No</option>
                    <option value="1" {{ @$editData->disability_type ? 'selected' : '' }}>Yes</option>
                </select>
            </div>
            <div class="form-group col-md-3  disability_type_div {{ @$editData->disability_type == null ? 'd-none' : '' }}">
                <label class="control-label">Types of PWD</label>
                <select class="form-control form-control-sm disability_type" name="disability_type">
                    <option value="">Select PWD Type</option>
                    @foreach ($disabilities as $disabilitye)
                        <option value="{{ $disabilitye->id }}" {{ @$editData->disability_type == $disabilitye->id ? 'selected' : '' }}>
                            {{ $disabilitye->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label class="control-label">Division <span class="text-danger">*</span> </label>

                <select name="division_id" id="division_id" class="form-control form-control-sm">
                    <option value="">Select Division</option>
                    @foreach ($divisions as $division)
                        <option value="{{ $division->id }}" {{ @$editData->division_id == $division->id ? 'selected' : '' }}>{{ $division->name }}
                        </option>
                    @endforeach
                </select>

                @error('division_id')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">District <span class="text-danger">*</span> </label>
                <select name="district_id" id="district_id" class="form-control form-control-sm">
                    @if (@$editData)
                        {!! getdistrict($editData->division_id, $editData->district_id) !!};
                    @else
                        <option value="">Select District</option>
                    @endif

                </select>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Upazila <span class="text-danger">*</span> </label>
                <select name="upazila_id" id="upazila_id" class="form-control form-control-sm">
                    @if (@$editData)
                        {!! getupazila(@$editData->district_id, @$editData->upazila_id) !!};
                    @else
                        <option value="">Select Upazila</option>
                    @endif
                </select>
                @error('upazila_id')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Union <span class="text-danger">*</span> </label>
                <select name="union_id" id="union_id" class="form-control form-control-sm">
                    @if (@$editData)
                        {!! getunion(@$editData->upazila_id, @$editData->union_id) !!};
                    @else
                        <option value="">Select Union</option>
                    @endif
                </select>
                @error('union_id')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Village </label>
                <select name="village_id" id="village_id" class="form-control form-control-sm">
                    @if (@$editData)
                        {!! getvillage(@$editData->union_id, @$editData->village_id) !!};
                    @else
                        <option value="">Select Union</option>
                    @endif
                </select>
                @error('village_id')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Landmark</label>
                <input type="text" name="landmark" class="form-control form-control-sm" placeholder="Landmark" value="{{ old('landmark', @$editData->landmark) }}">
                @error('landmark')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-12">
                <p class="mb-0"><strong><u>Parents Info:</u></strong></p>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Father's Name </label>
                <input type="text" name="fathers_name" class="form-control form-control-sm" value="{{ old('fathers_name', @$editData->fathers_name) }}" placeholder="Father's Name">
                @error('fathers_name')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Mother's Name</label>
                <input type="text" name="mothers_name" class="form-control form-control-sm" value="{{ old('mothers_name', @$editData->mothers_name) }}" placeholder="Mother's Name">
                @error('mothers_name')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Guardian Name (If needed)</label>
                <input type="text" name="guardian_name" class="form-control form-control-sm" value="{{ old('guardian_name', @$editData->guardian_name) }}" placeholder="Guardian Name">
                @error('guardian_name')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Total family (HH) members</label>
                <input type="text" name="total_family_member" class="form-control form-control-sm" value="{{ old('total_family_member', @$editData->total_family_member) }}" placeholder="Total family (HH) members">
                @error('total_family_member')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Father's Phone</label>
                <input type="text" name="father_phone" class="form-control form-control-sm" placeholder="Father's Phone" value="{{ old('father_phone', @$editData->father_phone) }}">
                @error('father_phone')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Mother's Phone</label>
                <input type="text" name="mother_phone" class="form-control form-control-sm" placeholder="Mother's Phone" value="{{ old('mother_phone', @$editData->mother_phone) }}">
                @error('mother_phone')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <hr>
        <div class="form-row">
            <div class="form-group col-md-12">
                <p class="mb-0"><strong><u>House hold and occupation:</u></strong></p>
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Father's occupation</label>
                <select name="father_occupation" id="" class="form-control form-control-sm">
                    <option value="">Select occupation</option>
                    @foreach ($occupations as $occupation)
                        <option value="{{ $occupation->id }}" {{ @$editData->father_occupation == $occupation->id ? 'selected' : '' }}>
                            {{ $occupation->name }}</option>
                    @endforeach
                </select>
                @error('father_occupation')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Father's Income(monthly)</label>
                <input type="text" name="father_income" class="form-control form-control-sm" placeholder="Father's Income" value="{{ old('father_income', @$editData->father_income) }}">
                @error('father_income')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Mother's occupation</label>
                <select name="mother_occupation" id="" class="form-control form-control-sm">
                    <option value="">Select occupation</option>
                    @foreach ($occupations as $occupation)
                        <option value="{{ $occupation->id }}" {{ @$editData->mother_occupation == $occupation->id ? 'selected' : '' }}>
                            {{ $occupation->name }}</option>
                    @endforeach
                </select>
                @error('mother_occupation')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Mother's Income(monthly)</label>
                <input type="text" name="mother_income" class="form-control form-control-sm" placeholder="Mother's Income" value="{{ old('mother_income', @$editData->mother_income) }}">
                @error('mother_income')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Other's occupation</label>
                <select name="other_occupation" id="" class="form-control form-control-sm">
                    <option value="">Select occupation</option>
                    @foreach ($occupations as $occupation)
                        <option value="{{ $occupation->id }}" {{ @$editData->other_occupation == $occupation->id ? 'selected' : '' }}>
                            {{ $occupation->name }}</option>
                    @endforeach
                </select>
                @error('other_occupation')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Other's Income(monthly)</label>
                <input type="text" name="other_income" class="form-control form-control-sm" placeholder="Other's Income" value="{{ old('other_income', @$editData->other_income) }}">
                @error('other_income')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-6">
                <div><strong class="mr-3">Financial beneficiary (Is she financial beneficiary?)</strong>
                    <label class="mr-3"><input class="financial" type="radio" value="1" name="financial" {{ @$editData->amount_money ? 'checked' : '' }}> Yes</label>
                    <label><input class="financial" type="radio" value="0" name="financial" {{ @$editData && @$editData->amount_money == null ? 'checked' : '' }}> No</label>
                </div>
            </div>
            <div class="form-group col-md-3 cash_support_div  {{ @$editData->amount_money ? '' : 'd-none' }}">
                <label class="control-label">Cash Support Type <span class="text-danger">*</span></label>
                <select name="cash_support_type" id="" class="form-control form-control-sm">
                    <option value="">Select Cash Support Type</option>
                    <option value="1" {{ @$editData->cash_support_type == 1 ? 'selected' : '' }}>Low Cash</option>
                    <option value="2" {{ @$editData->cash_support_type == 2 ? 'selected' : '' }}>Medium Cash</option>
                </select>
            </div>
            <div class="form-group col-md-3 money_div  {{ @$editData->amount_money ? '' : 'd-none' }}">
                <label class="control-label">Amount of Money <span class="text-danger">*</span></label>
                <input type="text" name="amount_money" class="form-control form-control-sm" placeholder="Amount of Money" value="{{ old('amount_money', @$editData->amount_money) }}">
                @error('amount_money')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
            </div>

        </div>
        <hr>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label class="control-label">Profile Photo</label>
                <input type="file" name="profile_photo" class="form-control form-control-sm" id="file_input">
                <p style="color: #8d8b8b">Max image size 512kb, dimensions 200x200</p>
                @error('profile_photo')
                    <p class="text-danger pb-0">{{ $message }}</p>
                @enderror
                @if (@$editData)
                    <img src="{{ asset('swapnosarothi_profile/' . @$editData->profile_image) }}" alt="" id="show_img" class="mt-3" width="200" />
                @else
                    <img src="logo.png" alt="" id="show_img" class="mt-3" width="200" />
                @endif
            </div>
        </div>

    </div>

    @if ($auth_user->user_role[0]['role_id'] == 1)
        <button type="submit" name="update_submit" class="btn btn-success btn-sm">{{ @$editData ? 'Update' : 'Submit' }}</button>
    @else
        @if (@$editData)
            <button type="submit" name="save_draft" class="btn btn-primary btn-sm">Save & Close</button> 
        @endif
        <button type="submit" name="update_submit" class="btn btn-success btn-sm">{{ @$editData ? 'Update' : 'Submit' }}</button>
    @endif
    <input type="hidden" name="submit_action" id="submit_action" value="">

    {{-- <button type="reset" class="btn btn-danger btn-sm">Reset</button> --}}
</div>
</form>

<script>
    let imgf = document.getElementById("file_input");
    let output = document.getElementById("show_img");

    imgf.addEventListener("change", function() {
        // Check if any file is selected
        if (imgf.files.length > 0) {
            // Create a URL for the selected file
            let imageUrl = URL.createObjectURL(imgf.files[0]);

            // Set the source of the image element to the created URL
            output.src = imageUrl;

            // Optionally, revoke the object URL to release resources
            // URL.revokeObjectURL(imageUrl);
        }
    });
</script>

<script type="text/javascript">
    $(function() {

        //get-region-upazila-group
        $('.emp_upazila_id').on('change', function() {
            var emp_upazila_id = $(this).val();
            var emp_region_id = $('#emp_region_id').val();
            var emp_district_id = $('#emp_district_id').val();
            var emp_division_id = $('#emp_division_id').val();

            $.ajax({
                url: "{{ route('get-region-upazila-setupgroup') }}",
                type: "GET",
                data: {
                    emp_region_id: emp_region_id,
                    emp_division_id: emp_division_id,
                    emp_district_id: emp_district_id,
                    emp_upazila_id: emp_upazila_id
                },
                success: function(data) {
                    var html = '<option value="">Select Group</option>';
                    $.each(data, function(key, v) {
                        if (v.groups == undefined) {
                            html += '<option value="' + v.id + '">' + v.group_name +
                                '</option>';
                        } else {
                            html += '<option value="' + v.groups.id + '">' + v
                                .groups.group_name + '</option>';
                        }
                    });
                    $('#group_id').html(html);
                }
            });
        });


        $('.financial').on('click', function() {
            var financial = $(this).val();
            if (financial == 1) {
                $('.money_div').removeClass('d-none');
                $('.cash_support_div').removeClass('d-none');
            } else {
                $('.money_div').addClass('d-none');
                $('.cash_support_div').addClass('d-none');
            }
        });

        $('.disability_status').on('change', function() {
            var disability_status = $(this).val();
            if (disability_status == 1) {
                $('.disability_type_div').removeClass('d-none');
            } else {
                $('.disability_type_div').addClass('d-none');
            }
        });

        //date picker
        var editStartDate = "{{ $editData->date_of_birth ?? 0 }}";
        if (editStartDate) {
            var formattedDate = new Date(editStartDate).toLocaleDateString('en-US', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit'
            });
        } else {
            formattedDate = null;
        }

        console.log(formattedDate);

        $('.dateofbirth').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            // locale: { 
            //     format: 'MM-DD-YYYY'
            // },
            startDate: formattedDate
        });
        //age calculate

        $('.dateofbirth').on('change', function() {

            var dob = new Date($(this).val());
            var today = new Date();

            //age calculate
            var cyear = today.getFullYear() - dob.getFullYear();
            var cmonth = today.getMonth() - dob.getMonth();
            var cday = today.getDate() - dob.getDate();

            if (cmonth < 0 || (cmonth === 0 && cday < 0)) {
                cyear--;
                cmonth += 12;
            }

            $('.age').val(cyear);


            // Display the approximate 18th birthday

            var eighteenYearsLater = new Date(dob);
            eighteenYearsLater.setFullYear(dob.getFullYear() + 18);
            var formattedDate = eighteenYearsLater.toISOString().split('T')[0];
            $('.age_completion_date').val(formattedDate);
        });



        //employee

        $(document).on('change', '#emp_region_id', function() {
            var region_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-division') }}",
                type: "GET",
                data: {
                    region_id: region_id
                },
                success: function(data) {
                    var html = '<option value="">Select Division</option>';
                    $.each(data, function(key, v) {
                        html += '<option value="' + v.division_id + '">' + v
                            .regional_division.name + '</option>';
                    });
                    $('#emp_division_id').html(html);
                }
            });
        });

        $(document).on('change', '#emp_division_id', function() {
            var region_id = $('#emp_region_id').val();
            var division_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-region-district') }}",
                type: "GET",
                data: {
                    region_id: region_id,
                    division_id: division_id
                },
                success: function(data) {

                    var html = '<option value="">Select District</option>';
                    $.each(data, function(key, v) {
                        html += '<option value="' + v.district_id + '">' + v
                            .regional_district.name + '</option>';
                    });
                    $('#emp_district_id').html(html);
                }
            });
        });

        $(document).on('change', '#emp_district_id', function() {
            var district_id = $(this).val();
            $.ajax({
                url: "{{ route('default.get-region-upazila') }}",
                type: "GET",
                data: {
                    district_id: district_id
                },
                success: function(data) {
                    var html = '<option value="">Select Upazila</option>';
                    $.each(data, function(key, v) {
                        if (v.setup_user_upazila == undefined) {
                            html += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        } else {
                            html += '<option value="' + v.setup_user_upazila.id +
                                '">' + v.setup_user_upazila.name + '</option>';
                        }
                    });
                    $('#emp_upazila_id').html(html);
                }
            });
        });

        // profile

        $(document).on('change', '#division_id', function() {

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
                    $('#district_id').html(html);
                }
            });
        });

        $(document).on('change', '#district_id', function() {
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
                    $('#upazila_id').html(html);
                }
            });
        });

        $(document).on('change', '#upazila_id', function() {
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
                    $('#union_id').html(html);
                }
            });
        });

        $(document).on('change', '#union_id', function() {
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
                    $('#village_id').html(html);
                }
            });
        });

    });
</script>

{{-- <script>
    $(document).ready(function() {
        // Event listener for the Submit button
        $('button[type="submit"]').on('click', function(event) {

            var financialValue = $('.financial:checked').val();
            var amountMoneyValue = $('input[name="amount_money"]').val();
            var cashSupportTypeValue = $('select[name="cash_support_type"]').val();


            if (financialValue == 1 && amountMoneyValue != '' && cashSupportTypeValue == '') {
                // If financial is yes, amount of money has value, but cash support type is not selected
                alert('Please select Cash Support Type when Amount of Money has a value.');
                event.preventDefault(); // Prevent default form submission
            } else {
                // Disable the button and show "Submitting..." message
                $(this).prop('disabled', true).html('Submitting...');
                $('#swapnoSarothiForm').submit();
            }
        });
    });
</script> --}}

<script>
    $(document).ready(function() {
        // Event listener for the Save & Draft button
        $('button[name="save_draft"]').on('click', function(event) {
            setSubmitAction('draft', event);
        });

        // Event listener for the Update/Submit button
        $('button[name="update_submit"]').on('click', function(event) {
            setSubmitAction('update', event);
        });

        function setSubmitAction(action, event) {
            var financialValue = $('.financial:checked').val();
            var amountMoneyValue = $('input[name="amount_money"]').val();
            var cashSupportTypeValue = $('select[name="cash_support_type"]').val();

            if (financialValue == 1 && cashSupportTypeValue !== '' && amountMoneyValue === '') {
                // If financial is yes, amount of money has value, but cash support type is not selected
                alert('Please select the amount of money when she is the financial beneficiary.');
                event.preventDefault();
            } else {
                // Set the value of submit_action based on the button clicked
                $('#submit_action').val(action);

                // Disable the button and show "Submitting..." message
                $(event.target).prop('disabled', true).html('Submitting...');
                $('#swapnoSarothiForm').submit();
            }

        }
    });
</script>


<script>
    $(function () {
        @if ($errors->has('status_date'))
            $.notify("{{ $errors->first('status_date') }}", {globalPosition: 'top right', className: 'error'});    
        @endif
        @if ($errors->has('reason_id'))
            $.notify("{{ $errors->first('reason_id') }}", {globalPosition: 'top right', className: 'error'});    
        @endif
    });
</script>

