@extends('backend.layouts.app')
@section('content')

<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">CM Initiative Prevention</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item">Home </li>
			<li class="breadcrumb-item active"> CM Initiative Prevention</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
                    <h3 class="float-left">Add CM Initiative Prevention</h3>
					<a class="btn btn-sm btn-success float-right" href="{{ route('swapnosarothiprofile.index') }}"><i class="fa fa-list"></i> Prifile List</a>
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
                        <p><strong>Profile Id:</strong> {{ $profile->id }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Group Id:</strong> {{ @$profile->groupName->group_id }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Group Name:</strong> {{ @$profile->groupName->group_name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Girl's Name:</strong> {{ @$profile->name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Date Of Birth:</strong> {{ $profile->date_of_birth ? $profile->date_of_birth->format('d M Y') : '' }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Start Date:</strong> {{ $profile->start_date ? $profile->start_date->format('d M Y') : '' }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Division:</strong> {{ @$profile->profile_division->name }} </p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>District:</strong> {{ @$profile->profile_district->name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Upazila:</strong> {{ @$profile->profile_upazila->name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Union:</strong> {{ @$profile->profile_union->name }}</p>
                    </div>
                    <div class=" col-md-3 align-self-center">
                        <p><strong>Village:</strong> {{ @$profile->profile_village->name }}</p>
                    </div>
                </div>
            </div>
		</div>
	</div>
    @if (count($profile->cmInitiatives) > 0)
    <div class="col-md-12 mt-3">
        
        <div class="card mt-2">
            <div class="card-header">
                <h5>Previous Initiative:</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Initiative</th>
                            <th>Date</th>
                            <th>Prevention Type</th>
                            <th>Prevention</th>
                            <th>Age</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    @foreach ($profile->cmInitiatives as $cmInitiative)
                
                    <tbody>
                        <tr>
                            <td>{{ $cmInitiative->initiative }}</td>
                            <td>{{ $cmInitiative->date ? $cmInitiative->date->format('d M Y') : '' }}</td>
                            <td>{{ $cmInitiative->preventionType->name }}</td>
                            <td>{{ $cmInitiative->preventionBy->name }}</td>
                            <td>{{ $cmInitiative->age }}</td>
                            <td>{{ $cmInitiative->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('cminitiative.edit', $cmInitiative->id) }}" class="btn btn-sm btn-info" title="Edit"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('cminitiative.destroy', $cmInitiative->id) }}" class="d-inline initativeDelete" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger" style="min-width: auto" title="Delete"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    
                    @endforeach
                </table>
            </div>
        </div>
                
        @foreach ($profile->cmInitiatives as $cmInitiative)
            
            @if ($cmInitiative->prevention_type == 2 || $cmInitiative->prevention_type == 3)
                <div class="card mt-2">
                    <div class="card-header">
                        <h5>Marriage Info:</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <p><strong>Marriage Date: </strong>{{ @$profile->marriageInfo->marriage_date  }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Registration Completed: </strong>{{ @$profile->marriageInfo->registration_completed }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Who Registered: </strong>{{ @$profile->marriageInfo->whoRegistered->name }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Marriage Place: </strong>{{ @$profile->marriageInfo->marriagePlace->name }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Marriage Reason: </strong>{{ @$profile->marriageInfo->marriageReason->name }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Asked by Groom: </strong> {{ @$profile->marriageInfo->asked_by_groom }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Dower Amount: </strong> {{ @$profile->marriageInfo->dower_amount }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Initiated Person: </strong> {{ @$profile->marriageInfo->marriagInitiatedPerson->name }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Girl Education: </strong> {{ @$profile->marriageInfo->girlEducational->title }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Studentship Status: </strong> {{ @$profile->marriageInfo->studentship_status }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Institution: </strong> {{ @$profile->marriageInfo->educatinalInstitution->name }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Groom's Age: </strong> {{ @$profile->marriageInfo->groom_age }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Groom's Profession: </strong> {{ @$profile->marriageInfo->groomProfession->name }}</p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Groom's Education: </strong> {{ @$profile->marriageInfo->groomEducation->title }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
                
        @endforeach
    </div>
    @endif

    @if (@!$profile->marriageInfo && $profile->group_status == 'ongoing')
	<div class="col-md-12 mt-3">
		<div class="card">
           <div class="card-body">
                <p><strong>Have you recently CM initiative?</strong></p>
                <form action="{{ route('cminitiative.store') }}" method="POST" >
                    @csrf
                    <input type="hidden" name="swapnosarothi_profile_id" value="{{ $profile->id }}">
                   
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label class="control-label">Initiative <span class="text-danger">*</span> </label>
                            <input type="text" name="initiative" class="form-control form-control-sm"
                                @if ($cmlastInitiative)
                                value ="{{ (int) $cmlastInitiative + 1 }}"
                                @else
                                value ="1"
                                @endif readonly required>
                            @error('initiative')
                                <p class="text-danger pb-0">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-2">
                            <label >Date <span class="text-danger">*</span> </label>
                            <input type="date" name="date" class="form-control form-control-sm initiativeDate">
                            @error('date')
                                <p class="text-danger pb-0">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group col-md-3">
                            <label >Prevention Type <span class="text-danger">*</span> </label>
                            <select name="prevention_type" id="prevention_type" class="form-control form-control-sm" required>
                                <option value="">Select Prevention Type</option>
                                @foreach ($cm_prevention_types as $cm_prevention_type)
                                    <option value="{{ $cm_prevention_type->id }}">{{ $cm_prevention_type->name }}</option>
                                @endforeach
                            </select>
                            @error('prevention_type')
                                <p class="text-danger pb-0">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div id="prevented_by_select" class="form-group"></div>

                        <div class="form-group col-md-2" >
                            <label class="control-label">Girl's Age:</label>
                            <input type="text" id="displayAge" name="age" class="form-control form-control-sm" readonly>
                            <input type="hidden" id="girl_age_year" name="girl_age" class="form-control form-control-sm">
                            
                        </div>
                    </div>

                    <div id="girl_marriage_form"></div>

                    <button type="submit" class="btn btn-success btn-sm" onclick="this.form.submit(); this.disabled=true; this.innerHTML='Sending…';">{{  @$editData ? 'Update' : 'Submit' }}</button>
                    <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                </form>
           </div>
		</div>
	</div>
    @endif
</div>
<!-- extra html -->

<script>
   $(document).ready(function() {
  


        // prevention wise select box display
        var marriage_form = `<hr>
                    <p><strong>Marriage Info:</strong></p>
                    <div class="child_marriage_info mb-4">
                        <div class="form-row ">
                            <div class="form-group col-md-4">
                                <label class="control-label">Date of marriage <span class="text-danger">*</span></label>
                                <input type="date" name="marriage_date" class="form-control form-control-sm" required>
                                @error('marriage_date')
                                    <p class="text-danger pb-0">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">is marriage registration completed? <span class="text-danger">*</span></label>
                                <select name="registration_completed" id="registration_completed" class="form-control form-control-sm" required>
                                    <option value="">Select Type</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                @error('registration_completed')
                                    <p class="text-danger pb-0">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-4 d-none" id="who_registered">
                                <label class="control-label">Who registered marriage?</label>
                                <select name="who_registered"  class="form-control form-control-sm" required>
                                    <option value="">Select Registered Type</option>
                                    @foreach ($cm_marriage_registers as $cm_marriage_register)
                                        <option value="{{ $cm_marriage_register->id }}">{{ $cm_marriage_register->name }}</option>
                                    @endforeach
                                </select>
                                @error('who_registered')
                                    <p class="text-danger pb-0">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-4 d-none" id="marriage_place">
                                <label class="control-label">Place of marriage (If marriage is registered)</label>
                                <select name="marriage_place"  class="form-control form-control-sm">
                                    <option value="">Select Place</option>
                                    @foreach ($cm_marriage_places as $cm_marriage_place)
                                        <option value="{{ $cm_marriage_place->id }}">{{ $cm_marriage_place->name }}</option>
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
                                        <option value="{{ $cm_marriag_reason->id }}">{{ $cm_marriag_reason->name }}</option>
                                   @endforeach
                                </select>
                                @error('marriage_reason')
                                    <p class="text-danger pb-0">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Who initiated for the marriage?</label>
                                <select name="marriag_initiated_person" class="form-control form-control-sm">
                                    <option value="">Select Option</option>
                                    @foreach ($cm_who_initiated_marriags as $cm_who_initiated_marriag)
                                        <option value="{{ $cm_who_initiated_marriag->id }}">{{ $cm_who_initiated_marriag->name }}</option>
                                   @endforeach
                                </select>
                                @error('marriag_initiated_person')
                                    <p class="text-danger pb-0">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Dowry asked by or given to groom</label>
                                <select name="asked_by_groom" id="asked_by_groom" class="form-control form-control-sm">
                                    <option value="">Select Option</option>
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                                @error('asked_by_groom')
                                    <p class="text-danger pb-0">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-4 d-none" id="dower_amount">
                                <label class="control-label">Amount of Dowry</label>
                                <input type="number" name="dower_amount" class="form-control form-control-sm">
                                @error('dower_amount')
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
                                        <option value="{{ $cm_girl_education->id }}">{{ $cm_girl_education->title }}</option>
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
                                    <option value="Regular">Regular</option>
                                    <option value="Dropout">Dropout</option>
                                    <option value="Not applicable">Not applicable</option>
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
                                        <option value="{{ $cm_girl_instituteon_type->id }}">{{ $cm_girl_instituteon_type->name }}</option>
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
                                <input type="number" name="groom_age" class="form-control form-control-sm">
                                @error('groom_age')
                                    <p class="text-danger pb-0">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Groom's Profession</label>
                                <select name="groom_profession" class="form-control form-control-sm">
                                    <option value="">Select profession</option>
                                    @foreach ($occupations as $occupation)
                                        <option value="{{ $occupation->id }}">{{ $occupation->name }}</option>
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
                                        <option value="{{ $education->id }}">{{ $education->title }}</option>
                                   @endforeach
                                </select>
                                @error('groom_education')
                                    <p class="text-danger pb-0">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>`;

        $('#prevention_type').on('change', function(){
            var preventionTypeValue = $(this).val();
            var preventedBySelect = $('#prevented_by_select');
            if(preventionTypeValue == 1){
                preventedBySelect.addClass('col-md-3');
                var selectOne = `<label class="control-label">Prevention <span class="text-danger">*</span> </label>
                                    <select name="prevention_by" class="form-control form-control-sm" required>
                                        <option value="">Select Prevention</option>
                                        @foreach ($cm_preventions as $cm_prevention)
                                            @if($cm_prevention->prevention_type_id == 1)
                                                <option value="{{ $cm_prevention->id }}">{{ $cm_prevention->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('prevention_by')
                                        <p class="text-danger pb-0">{{ $message }}</p>
                                    @enderror`;
                preventedBySelect.html(selectOne);
                $('#girl_marriage_form').html('');
            }else if(preventionTypeValue == 2){
                preventedBySelect.addClass('col-md-3');
                var selectOne = `<label class="control-label">Prevented By <span class="text-danger">*</span> </label>
                            <select name="prevention_by"  class="form-control form-control-sm" required>
                                <option value="">Select Prevention</option>
                                @foreach ($cm_preventions as $cm_prevention)
                                    @if($cm_prevention->prevention_type_id == 2)
                                        <option value="{{ $cm_prevention->id }}">{{ $cm_prevention->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('prevention_by')
                                <p class="text-danger pb-0">{{ $message }}</p>
                            @enderror`;
                preventedBySelect.html(selectOne);
                $('#girl_marriage_form').html(marriage_form);
            }else if(preventionTypeValue == 3){
                preventedBySelect.addClass('col-md-3');
                var selectOne = `<label class="control-label">Prevented By <span class="text-danger">*</span> </label>
                            <select name="prevention_by" class="form-control form-control-sm">
                                <option value="">Select Prevention Type</option>
                                @foreach ($cm_preventions as $cm_prevention)
                                    @if($cm_prevention->prevention_type_id == 3)
                                        <option value="{{ $cm_prevention->id }}">{{ $cm_prevention->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('prevention_by')
                                <p class="text-danger pb-0">{{ $message }}</p>
                            @enderror`;
                preventedBySelect.html(selectOne);
                $('#girl_marriage_form').html(marriage_form);
            }else{
                preventedBySelect.html('');
                
                preventedBySelect.removeClass('col-md-3');
            }
        })

        $(document).on('change', '#registration_completed', function(){
            var value = $(this).val();
            if(value == 'Yes'){
                $('#who_registered').removeClass('d-none');
                $('#marriage_place').removeClass('d-none');
            }else{
                $('#who_registered').addClass('d-none');
                $('#marriage_place').addClass('d-none');
            }
        });

        $(document).on('change', '#asked_by_groom', function(){
            var value = $(this).val();
            if(value == 'Yes'){
                $('#dower_amount').removeClass('d-none');
            }else{
                $('#dower_amount').addClass('d-none');
            }
        });

        


        //display age
        $('.initiativeDate').on('change', function(){
            var profileDateOfBirth = "{{ $profile->date_of_birth }}";
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

        $('.initativeDelete').on('click', function(e){
            e.preventDefault();
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $(this).submit();
                }
            });
        });
            
    });
</script>

@endsection