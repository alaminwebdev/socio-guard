@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left"> Edit CM Initiative Prevention</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active">Edit CM Initiative Prevention</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
                    <h3 class="float-left">Edit CM Initiative Prevention</h3>
					<a class="btn btn-sm btn-success float-right" href="{{ route('cminitiative.create', ['profile_id' => $cminitiative->swapnosarothi_profile_id]) }}">Back To Initiative Page</a>
			</div>
		</div>
	</div>

    <div class="col-md-12 mt-3">

		<div class="card">
            <div class="card-header">
                <h5>Girl's Profile Info:</h5>
            </div>  
            <div class="card-body">
                <div class="row">
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Profile Id:</strong> {{ $cminitiative->profile->id }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Group Id:</strong> {{ @$cminitiative->profile->groupName->group_id }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Group Name:</strong> {{ @$cminitiative->profile->groupName->group_name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Girl's Name:</strong> {{ $cminitiative->profile->name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Date Of Birth:</strong> {{ $cminitiative->profile->date_of_birth ? $cminitiative->profile->date_of_birth->format('d M Y') : '' }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Start Date:</strong> {{ $cminitiative->profile->start_date ? $cminitiative->profile->start_date->format('d M Y') : '' }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Division:</strong> {{ @$cminitiative->profile->profile_division->name }} </p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>District:</strong> {{ @$cminitiative->profile->profile_district->name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Upazila:</strong> {{ @$cminitiative->profile->profile_upazila->name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Union:</strong> {{ @$cminitiative->profile->profile_union->name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Village:</strong> {{ @$cminitiative->profile->profile_village->name }}</p>
                    </div>
                </div>
            </div>
		</div>
	</div>

	<div class="col-md-12 mt-3">
		<div class="card">
           <div class="card-body">
                <p><strong>Have you recently CM initiative?</strong></p>
                <form action="{{ route('cminitiative.update', $cminitiative->id) }}" method="POST" >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="swapnosarothi_profile_id" value="{{ $cminitiative->swapnosarothi_profile_id }}">
                   
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label class="control-label">Initiative <span class="text-danger">*</span> </label>
                            <input type="text" name="initiative" class="form-control form-control-sm"
                                value ="{{  $cminitiative->initiative }}"
                                 readonly required>
                            @error('initiative')
                                <p class="text-danger pb-0">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-2">
                            <label >Date <span class="text-danger">*</span> </label>
                            <input type="date" name="date" class="form-control form-control-sm initiativeDate" value="{{ $cminitiative->date->format('Y-m-d') }}">
                            @error('date')
                                <p class="text-danger pb-0">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            
                            <label >Prevention Type <span class="text-danger">*</span> </label>
                            @if ($cminitiative->prevention_type == 1)
                            <select name="prevention_type" id="prevention_type" class="form-control form-control-sm" readonly >
                                <option value="{{ $cminitiative->prevention_type }}" selected>{{ $cminitiative->preventionType->name }}</option>
                            </select>
                            @else
                            <select name="prevention_type" id="prevention_type" class="form-control form-control-sm" required >
                                <option value="">Select Prevention Type</option>
                                @foreach ($cm_prevention_types->skip(1) as $cm_prevention_type)
                                    <option value="{{ $cm_prevention_type->id }}" 
                                    {{ $cminitiative->prevention_type == $cm_prevention_type->id ? 'selected' : ''}} 
                                >{{ $cm_prevention_type->name }}</option>
                                @endforeach
                            </select>
                            @endif
                            @error('prevention_type')
                                <p class="text-danger pb-0">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group col-md-3">
                            <label class="control-label">Prevention <span class="text-danger">*</span> </label>
                            <select name="prevention_by" id="prevention_by"  class="form-control form-control-sm" required>
                                <option value="">Select Prevention</option>
                                @foreach ($cm_preventions as $cm_prevention)
                                    <option value="{{ $cm_prevention->id }}" {{ $cminitiative->prevention_by == $cm_prevention->id ? 'selected' : ''  }}>{{ $cm_prevention->name }}</option>
                                    
                                @endforeach
                            </select>
                            @error('prevention_by')
                                <p class="text-danger pb-0">{{ $message }}</p>
                            @enderror
                        </div>
                    
                        <div class="form-group col-md-2" >
                            <label class="control-label">Girl's Age:</label>
                            <input type="text" id="displayAge" name="age" class="form-control form-control-sm" value="{{ $cminitiative->age }}" readonly>
                            <input type="hidden" id="girl_age_year" name="girl_age" class="form-control form-control-sm">
                            
                        </div>
                    </div>

                    @if ($cminitiative->profile->marriageInfo)
                        <div class="mt-3">
                            <p><strong>Marriage Info:</strong></p>
                            <div class="child_marriage_info mb-4">
                                <div class="form-row ">
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Date of marriage <span class="text-danger">*</span></label>
                                        <input type="date" name="marriage_date" class="form-control form-control-sm" value="{{ @$cminitiative->profile->marriageInfo->marriage_date->format('Y-m-d') }}" required>
                                        @error('marriage_date')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">is marriage registration completed? <span class="text-danger">*</span></label>
                                        <select name="registration_completed" class="form-control form-control-sm" required>
                                            <option value="">Select Type</option>
                                            <option value="Yes" {{ $cminitiative->profile->marriageInfo->registration_completed == 'Yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="No" {{ $cminitiative->profile->marriageInfo->registration_completed == 'No' ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('registration_completed')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Who registered marriage? <span class="text-danger">*</span></label>
                                        <select name="who_registered" class="form-control form-control-sm" required>
                                            <option value="">Select Registered Type</option>
                                            @foreach ($cm_marriage_registers as $cm_marriage_register)
                                                <option value="{{ $cm_marriage_register->id }}" {{ $cminitiative->profile->marriageInfo->who_registered == $cm_marriage_register->id ? 'selected' : '' }}>{{ $cm_marriage_register->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('who_registered')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Place of marriage (If marriage is registered)</label>
                                        <select name="marriage_place" class="form-control form-control-sm">
                                            <option value="">Select Place</option>
                                            @foreach ($cm_marriage_places as $cm_marriage_place)
                                                <option value="{{ $cm_marriage_place->id }}" 
                                                    {{ $cminitiative->profile->marriageInfo->marriage_place == $cm_marriage_place->id ? 'selected' : '' }}
                                                    >{{ $cm_marriage_place->name }}</option>
                                        @endforeach
                                        </select>
                                        @error('marriage_place')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Reason behind marrying of her</label>
                                        <select name="marriage_reason" class="form-control form-control-sm">
                                            <option value="">Select marriage reason</option>
                                            @foreach ($cm_marriag_reasons as $cm_marriag_reason)
                                                <option value="{{ $cm_marriag_reason->id }}"
                                                    {{ $cminitiative->profile->marriageInfo->marriage_reason == $cm_marriag_reason->id ? 'selected' : '' }}
                                                    >{{ $cm_marriag_reason->name }}</option>
                                        @endforeach
                                        </select>
                                        @error('marriage_reason')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Dowry asked by or given to groom</label>
                                        <select name="asked_by_groom" class="form-control form-control-sm">
                                            <option value="">Select Option</option>
                                            <option value="Yes" {{ $cminitiative->profile->marriageInfo->asked_by_groom == 'Yes' ? 'selected' : '' }}>Yes</option>
                                            <option value="No" {{ $cminitiative->profile->marriageInfo->asked_by_groom == 'No' ? 'selected' : '' }}>No</option>
                                        </select>
                                        @error('asked_by_groom')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Amount of Dowry</label>
                                        <input type="number" name="dower_amount" class="form-control form-control-sm" value="{{  $cminitiative->profile->marriageInfo->dower_amount }}">
                                        @error('dower_amount')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Who initiated for the marriag?</label>
                                        <select name="marriag_initiated_person" class="form-control form-control-sm">
                                            <option value="">Select Option</option>
                                            @foreach ($cm_who_initiated_marriags as $cm_who_initiated_marriag)
                                                <option value="{{ $cm_who_initiated_marriag->id }}"
                                                    {{ @$cminitiative->profile->marriageInfo->marriag_initiated_person ==  $cm_who_initiated_marriag->id  ? 'selected' : '' }}
                                                    >{{ $cm_who_initiated_marriag->name }}</option>
                                        @endforeach
                                        </select>
                                        @error('marriag_initiated_person')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <hr>
                                <p><strong>Education status of girls who got married:</strong></p>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Educational qualification (Last class completed)</label>
                                        <select name="girl_educational" class="form-control form-control-sm">
                                            <option value="">Select Educational</option>
                                            @foreach ($educations as $cm_girl_education)
                                                <option value="{{ $cm_girl_education->id }}"
                                                    {{ @$cminitiative->profile->marriageInfo->girlEducational->id ==  $cm_girl_education->id  ? 'selected' : '' }}
                                                    >{{ @$cm_girl_education->title }}</option>
                                        @endforeach
                                        </select>
                                        @error('girl_educational')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Studentship status</label>
                                        <select name="studentship_status" class="form-control form-control-sm">
                                            <option value="">Select Studentship status</option>
                                            <option value="Regular" {{ $cminitiative->profile->marriageInfo->studentship_status == 'Regular' ? 'selected' : '' }}>Regular</option>
                                            <option value="Dropout" {{ $cminitiative->profile->marriageInfo->studentship_status == 'Dropout' ? 'selected' : '' }}>Dropout</option>
                                            <option value="Not applicable" {{ $cminitiative->profile->marriageInfo->studentship_status == 'Not applicable' ? 'selected' : '' }}>Not applicable</option>
                                        </select>
                                        @error('studentship_status')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Type of educatinal institution</label>
                                        <select name="educatinal_institution" class="form-control form-control-sm">
                                            <option value="">Select Studentship status</option>
                                            @foreach ($cm_girl_instituteon_types as $cm_girl_instituteon_type)
                                                <option value="{{ $cm_girl_instituteon_type->id }}" 
                                                    {{ @$cminitiative->profile->marriageInfo->educatinal_institution ==  $cm_girl_instituteon_type->id  ? 'selected' : '' }}
                                                    >{{ $cm_girl_instituteon_type->name }}</option>
                                        @endforeach
                                        </select>
                                        @error('educatinal_institution')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <hr>
                                <p><strong>Groom's Perspective:</strong></p>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Groom's Age</label>
                                        <input type="number" name="groom_age" class="form-control form-control-sm" value="{{ @$cminitiative->profile->marriageInfo->groom_age }}">
                                        @error('groom_age')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Groom's Profession</label>
                                        <select name="groom_profession" class="form-control form-control-sm">
                                            <option value="">Select profession</option>
                                            @foreach ($occupations as $occupation)
                                                <option value="{{ $occupation->id }}" {{  @$cminitiative->profile->marriageInfo->groomProfession->id == $occupation->id ? 'selected' : '' }}>{{ $occupation->name }}</option>
                                           @endforeach
                                        </select>
                                        @error('groom_profession')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Groom's Education</label>
                                        <select name="groom_education" class="form-control form-control-sm">
                                            <option value="">Select Education</option>
                                            @foreach ($educations as $education)
                                                <option value="{{ $education->id }}" {{  @$cminitiative->profile->marriageInfo->groomEducation->id == $education->id ? 'selected' : '' }}>{{ $education->title }}</option>
                                           @endforeach
                                        </select>
                                        @error('groom_education')
                                            <p class="text-danger pb-0">{{ $message }}</p>
                                        @enderror
                                    </div> 
                                </div>
                            </div>
                        </div>
                    @endif

                    <button type="submit" class="btn btn-success btn-sm" onclick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">Update</button>
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                </form>
           </div>
		</div>
	</div>
</div>
<!-- extra html -->

<script>
   $(document).ready(function() {
    
        // preventions 
        $(document).on('change', '#prevention_type', function(){
            var prevention_type = $(this).val();
            var prevention_by = $('#prevention_by');
            $.ajax({
                url: "{{ route('prevention.type.wise.prevention') }}",
                type: 'GET',
                data:{prevention_type},
                success:function(data){
                    prevention_by.html('');
                    prevention_by.html(data);
                },
            });
        });

        //display age
        $('.initiativeDate').on('change', function(){
            var profileDateOfBirth = "{{ $cminitiative->profile->date_of_birth }}";
            var initiativeDate = $(this).val();

            var dob = new Date(profileDateOfBirth);
            var today = new Date(initiativeDate);

            // age calculate
            var cyear = today.getFullYear() - dob.getFullYear();
            var cmonth = today.getMonth() - dob.getMonth();
            var cday = today.getDate() - dob.getDate();

            if (cday < 0) {
                // If the day difference is negative, adjust the month and day
                cmonth--;
                var lastMonth = new Date(today.getFullYear(), today.getMonth() - 1, dob.getDate());
                cday = Math.floor((today - lastMonth) / (24 * 60 * 60 * 1000));
            }

            if (cmonth < 0) {
                cyear--;
                cmonth += 12;
            }

            $('#displayAge').val(cday + " Days, " + cmonth + " Months, " + cyear + " Years");
            $('#girl_age_year').val( cyear);
        });
            
    });
</script>

@endsection