<form method="POST" action="{{ route('childmarriageinformation.store') }}" id="myForm">
    @csrf

    <div class="card-header">
        <div class="row align-items-center">
            @if (count($selpIncident) > 0)
                <input type="hidden" name="complain_id"
                        value="{{ count($selpIncident) > 0 ? $selpIncident[0]->id : '' }}"
                        class="form-control form-control-sm">
            @endif

            <div class="col-sm-2">
                <h6>Prevention ID: {{ $childmarriageinformation ? $childmarriageinformation->id + 1 : 1 }}</h6>
            </div>
            <div class=" col-sm-2 text-right">
                <h6 class="control-label">Reporting Date</h6>
            </div>
            <div class="col-sm-3">
                <input type="text" name="reporting_date" value="" id="posting_date"
                    class="form-control form-control-sm postingdatepicker" readonly>
            </div>
            <div class="col-sm-3">
                <h6 >Creation Date: {{ date('d-m-Y') }}</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="mt-2">
            <h6>Data Insert By:</h6>
        </div>
        <div class="form-row">
            <div class="form-group col-sm-3">
                <label class="control-label">Name</label>
                <input type="text" name="employee_name"
                    value="{{ @$user_info->name }}"
                    id="employee_name" class="form-control form-control-sm" readonly="">
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Cell</label>
                <input type="text" name="employee_mobile_number"
                    value="{{@$user_info->mobile }}"
                    id="employee_mobile_number" class="form-control form-control-sm" readonly="">
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Designation</label>
                <input type="text" name="employee_designation"
                    value="{{ @$user_info->designation }}"
                    id="employee_designation" class="form-control form-control-sm" readonly="">
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Pin</label>
                <input type="text" name="employee_pin"
                    value="{{ @$user_info->pin }}"
                    id="employee_pin" class="form-control form-control-sm" readonly="">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label class="control-label">Zone <span class="text-danger">*</span></label>
                @if (count(session()->get('userareaaccess.sregions')) > 0)
                    <select name="employee_zone_id" id="region_id1"
                        class="region_id form-control form-control-sm select2" required="">
                        <option value="">Select zone</option>
                        @foreach ($regions as $key => $region)
                            @if (in_array($region->id, session()->get('userareaaccess.sregions')))
                                <option value="{{ $region->id }}"
                                    {{ count($selpIncident) > 0 && $selpIncident[0]->employee_zone_id == $region->id ? 'selected' : '' }}>
                                    {{ $region->region_name }}</option>
                            @endif
                        @endforeach
                    </select>
                @else
                    <select name="employee_zone_id" id="region_id1"
                        class="region_id form-control form-control-sm select2" required="">
                        <option value="">Select Zone</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}" {{ checkCurrentRegion($region->id, $selpIncident) }}>
                                {{ $region->region_name }}</option>
                        @endforeach
                    </select>
                @endif

                {{-- </select> --}}
                @error('employee_zone_id')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Division <span class="text-danger">*</span></label>
                <select name="employee_division_id" id="division_id1" class="division_id form-control form-control-sm"
                    required="">
                    @if (count($selpIncident) > 0)
                        @if (count(session()->get('userareaaccess.sregions')) == 1)
                            {!! getUserDivisions(session()->get('userareaaccess.sregions')[0]) !!}
                        @else
                            {!! getRegionalDivision($selpIncident[0]->employee_zone_id, $selpIncident[0]->employee_division_id) !!};
                        @endif
                    @else
                        <option value="">Select Division</option>
                    @endif

                </select>
                @error('employee_division_id')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">District <span class="text-danger">*</span></label>
                <select name="employee_district_id" id="district_id1" class="district_id form-control form-control-sm"
                    required>
                    @if (count($selpIncident) > 0)
                        {!! getRegionalDivisionDistrict(
                            $selpIncident[0]->employee_zone_id,
                            $selpIncident[0]->employee_division_id,
                            $selpIncident[0]->employee_district_id,
                        ) !!};
                    @else
                        <option value="">Select District</option>
                    @endif
                </select>
                @error('employee_district_id')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-md-3">
                <label class="control-label">Upazila <span class="text-danger">*</span></label>
                <select name="employee_upazila_id" id="upazila_id1" class="upazila_id form-control form-control-sm"
                    required>
                    @if (count($selpIncident) > 0)
                        {!! getupazila($selpIncident[0]->employee_district_id, $selpIncident[0]->employee_upazila_id) !!};
                    @else
                        <option value="">Select Upazila</option>
                    @endif
                </select>
                @error('employee_upazila_id')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
        </div>

        <hr>
        <div class="form-row mt-3">
            <div class="form-group col-md-12">
                <h6>Child Information:</h6>
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Name <span class="text-danger">*</span></label>
                <input type="text" name="child_name" id="child_name"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_name : '' }}"
                    class="form-control form-control-sm" required {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_name ? 'readonly'  : '' }}>
                @error('child_name')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Age <span class="text-danger">*</span></label>
                <input type="text" name="child_age" id="child_age"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_age : '' }}"
                    class="form-control form-control-sm" required {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_age ? 'readonly'  : '' }}>
                @error('child_age')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Father Name</label>
                <input type="text" name="child_father_name"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_father_name : '' }}"
                    class="form-control form-control-sm" {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_father_name ? 'readonly'  : '' }}>
                @error('child_father_name')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Mother Name</label>
                <input type="text" name="child_mother_name"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_mother_name : '' }}"
                    class="form-control form-control-sm" {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_mother_name ? 'readonly'  : '' }}>
                @error('child_mother_name')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Mobile Number <span class="text-danger">*</span></label>
                <input type="text" name="child_mobile_number" id="child_mobile_number"
                    value="{{ count($selpIncident) > 0 ? $selpIncident[0]->survivor_mobile_number : '' }}"
                    class="form-control form-control-sm" required {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_mobile_number ? 'readonly'  : '' }}>
                @error('child_mobile_number')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Gender <span class="text-danger">*</span></label>
               @if (count($selpIncident) > 0 && $selpIncident[0]->survivor_gender_id)
                   <input type="hidden" name="child_gender" value="{{ $selpIncident[0]->survivor_gender->id }}">
                   <input type="text" class="form-control form-control-sm @error('child_gender') is-invalid @enderror" value="{{ $selpIncident[0]->survivor_gender->name }}" readonly>
               @else
               <select name="child_gender" id="child_gender"
               class="form-control form-control-sm @error('child_gender') is-invalid @enderror" required  >
                    <option value="">Select Gender</option>
                    @foreach ($child_gender as $gender)
                        <option value="{{ $gender->id }}">{{ $gender->name }}</option>
                    @endforeach

                </select>
               @endif
                
                @error('child_gender')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Disability status <span class="text-danger">*</span></label>

                @if (count($selpIncident) > 0 && $selpIncident[0]->survivor_disability_status)
                   <input type="hidden" name="survivor_disability_status" value="{{ $selpIncident[0]->survivor_disability->id }}">
                   <input type="text" class="form-control form-control-sm @error('survivor_disability_status') is-invalid @enderror" value="{{ $selpIncident[0]->survivor_disability->name }}" readonly>
               @else
                <select name="survivor_disability_status" id="" class="form-control form-control-sm @error('survivor_disability_status') is-invalid @enderror"
                        required>
                    <option value="">Select Disability status</option>
                    @foreach ($survivor_autistic_information as $disability)
                        <option value="{{ $disability->id }}">{{ $disability->name }}</option>
                    @endforeach
                </select>
               @endif
                
                @error('survivor_disability_status')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Division <span class="text-danger">*</span></label>
                @if (count($selpIncident) > 0 && $selpIncident[0]->survivor_division_id)
                   <input type="hidden" name="survivor_division" value="{{ $selpIncident[0]->survivor_division->id }}">
                   <input type="text" class="form-control form-control-sm @error('survivor_division') is-invalid @enderror" value="{{ $selpIncident[0]->survivor_division->name }}" readonly>
                @else
                    <select name="survivor_division" id="survivor_division_id"
                        class="form-control form-control-sm @error('survivor_division') is-invalid @enderror"
                        required="">
                        <option value="">Select Division</option>
                        @foreach ($divisions as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                @endif

                @error('survivor_division')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">District <span class="text-danger">*</span></label>

                @if (count($selpIncident) > 0 && $selpIncident[0]->survivor_district_id)
                   <input type="hidden" name="survivor_district" value="{{ $selpIncident[0]->survivor_district->id }}">
                   <input type="text" class="form-control form-control-sm @error('survivor_division') is-invalid @enderror" value="{{ $selpIncident[0]->survivor_district->name }}" readonly>
                @else
                    <select name="survivor_district" id="survivor_district_id"
                    class="form-control form-control-sm @error('survivor_district') is-invalid @enderror"
                    required="">
                        @if (count($selpIncident) > 0)
                            {!! getdistrict($selpIncident[0]->survivor_division_id, $selpIncident[0]->survivor_district_id) !!};
                        @else
                            <option value="">Select District</option>
                        @endif
                    </select>
                @endif

                
                @error('survivor_district')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Upazila <span class="text-danger">*</span></label>
                
                @if (count($selpIncident) > 0 && $selpIncident[0]->survivor_upazila_id)
                    <input type="hidden" name="survivor_upazila" value="{{ $selpIncident[0]->survivor_upazila->id }}">
                    <input type="text" class="form-control form-control-sm @error('survivor_division') is-invalid @enderror" value="{{ $selpIncident[0]->survivor_upazila->name }}" readonly>
                @else
                    <select name="survivor_upazila" id="survivor_upazila_id"
                    class="form-control form-control-sm @error('survivor_upazila') is-invalid @enderror"
                    required="">
                        @if (count($selpIncident) > 0)
                            {!! getupazila($selpIncident[0]->survivor_district_id, $selpIncident[0]->survivor_upazila_id) !!};
                        @else
                            <option value="">Select Upazila</option>
                        @endif
                    </select>
                @endif
                
                
                @error('survivor_upazila')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Union <span class="text-danger">*</span></label>
                    @if (count($selpIncident) > 0 && $selpIncident[0]->survivor_union_id)
                        <input type="hidden" name="survivor_union" value="{{ $selpIncident[0]->survivor_union->id }}">
                        <input type="text" class="form-control form-control-sm @error('survivor_division') is-invalid @enderror" value="{{ $selpIncident[0]->survivor_union->name }}" readonly>
                    @else
                        <select name="survivor_union" id="survivor_union_id" class="form-control form-control-sm @error('survivor_union') is-invalid @enderror" required="" >
                        @if (count($selpIncident) > 0)
                                {!! getunion($selpIncident[0]->survivor_upazila_id, $selpIncident[0]->survivor_union_id) !!};
                            @else
                                <option value="">Select Union</option>
                            @endif
                        </select>
                    @endif
                
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
                    required="" {{ count($selpIncident) > 0 && $selpIncident[0]->survivor_village_name ? 'readonly'  : '' }}>
                @error('survivor_village_name')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
        </div>
        <div class="form-row mt-3">
            <div class="form-group col-sm-4">
                <label class="control-label">Child Marriage Prevention First Initiative <span class="text-danger">*</span></label>
                <select name="child_marriage_initiative" id="child_marriage_initiative"
                    class="select2 information_provider form-control form-control-sm @error('child_marriage_initiative') is-invalid @enderror"
                    required="">
                    <option value="">-- Select --</option>
                    @foreach ($child_marriage_initiative as $initiative)
                        <option value="{{ $initiative->id }}">{{ $initiative->name }}</option>
                    @endforeach
    
                </select>
                @error('child_marriage_initiative')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-4">
                <label class="control-label">Child Marriage Prevention Assistance <span class="text-danger">*</span></label>
                <select name="child_marriage_assistance_taken[]" id="child_marriage_assistance_taken"
                    class="select2 information_provider form-control form-control-sm @error('child_marriage_assistance_taken') is-invalid @enderror"
                    required="" multiple>
                    <option disabled>-- Select --</option>
                    @foreach ($child_marriage_assistance_taken as $assistance)
                        <option value="{{ $assistance->id }}">{{ $assistance->name }}</option>
                    @endforeach

                </select>
                @error('child_marriage_assistance_taken')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
        </div>
        <hr>
        <div class="form-row mt-3">
            <div class="form-group col-md-12">
                <h6>Name of the person or institution, taking the first initiative:</h6>
            </div>
            <div class="form-group col-sm-3">
                <label class="control-label">Name</label>
                <input type="text" name="person_name" id="person_name" class="form-control form-control-sm">
                @error('person_name')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>

            <div class="form-group col-sm-3">
                <label class="control-label">Mobile Number</label>
                <input type="text" name="person_mobile_number" id="person_mobile_number"
                    class="form-control form-control-sm">
                @error('person_mobile_number')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>

            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Division</label>
                <select name="person_division_id" id="person_division_id"
                    class="form-control form-control-sm @error('person_division_id') is-invalid @enderror">
                    <option value="">Select Division</option>
                    @foreach ($divisions as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                @error('person_division_id')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">District</label>
                <select name="person_district_id" id="person_district_id"
                    class="form-control form-control-sm @error('person_district_id') is-invalid @enderror">
                    <option value="">Select District</option>
                </select>
                @error('person_district_id')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Upazila</label>
                <select name="person_upazila_id" id="person_upazila_id"
                    class="form-control form-control-sm @error('person_upazila_id') is-invalid @enderror">
                    <option value="">Select Upazila</option>
                </select>
                @error('person_upazila_id')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Union</label>
                <select name="person_union_id" id="person_union_id"
                    class="form-control form-control-sm @error('person_union_id') is-invalid @enderror">
                    <option value="">Select Union</option>
                </select>
                @error('person_union_id')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
            <div class="form-group col-sm-3 column_5_1">
                <label class="control-label">Village</label>
                <input type="text" name="person_village_name" id="person_village_name"
                    class="form-control form-control-sm @error('person_village_name') is-invalid @enderror">
                @error('person_village_name')
                    <p style="color:red; margin-top:5px;">This field is required</p>
                @enderror
            </div>
        </div>

        <div class="text-right">
            @if ($user_info['user_role'][0]['role_id'] == 5 || $user_info['user_role'][0]['role_id'] == 1)
                {{-- <button type="submit" name="save_draft" class="btn btn-warning btn-sm form_submit">Save &
                    Draft</button> --}}
                <button type="submit" class="btn btn-success btn-sm form_submit">Submit</button>
            @endif
            <button type="reset" class="btn btn-danger btn-sm">Reset</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $(function() {


        var submitBtn = $('.form_submit');
        submitBtn.on('click', function() {

            var zone = $(this).parents('form').find('#region_id1').val();
            var division = $(this).parents('form').find('#division_id1').val();
            var district = $(this).parents('form').find('#district_id1').val();
            var upazila_id = $(this).parents('form').find('#upazila_id1').val();
            var child_marriage_initiative = $(this).parents('form').find('#child_marriage_initiative')
                .val();
            var child_marriage_assistance_taken = $(this).parents('form').find(
                '#child_marriage_assistance_taken').val();
            var child_age = $(this).parents('form').find('#child_age').val();
            var child_mobile_number = $(this).parents('form').find('#child_mobile_number').val();
            var child_gender = $(this).parents('form').find('#child_gender').val();
            var survivor_division_id = $(this).parents('form').find('#survivor_division_id').val();
            var survivor_district_id = $(this).parents('form').find('#survivor_district_id').val();
            var survivor_upazila_id = $(this).parents('form').find('#survivor_upazila_id').val();
            var survivor_union_id = $(this).parents('form').find('#survivor_union_id').val();
            var survivor_village_name = $(this).parents('form').find('#survivor_village_name').val();
            var child_name = $(this).parents('form').find('#child_name').val();
            var person_name = $(this).parents('form').find('#person_name').val();
            var person_division_id = $(this).parents('form').find('#person_division_id').val();
            var person_district_id = $(this).parents('form').find('#person_district_id').val();
            var person_upazila_id = $(this).parents('form').find('#person_upazila_id').val();
            var person_union_id = $(this).parents('form').find('#person_union_id').val();
            var person_village_name = $(this).parents('form').find('#person_village_name').val();


            if (zone != "" && division != "" && district != "" && upazila_id != "" &&
                child_marriage_initiative != "" && child_marriage_assistance_taken != "" && child_age !=
                "" && child_mobile_number != "" && child_gender != "" && survivor_division_id != "" &&
                survivor_district_id != "" && survivor_upazila_id != "" && survivor_union_id != "" &&
                survivor_village_name != "" && child_name != "" && person_name != "" &&
                person_division_id != "" && person_district_id != "" && person_upazila_id != "" &&
                person_union_id != "" && person_village_name != "") {

                $('.from_loader').css({
                    "display": 'block'
                });
            }
        });


        $(document).on('change', '#region_id1', function() {
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
                    $('#division_id1').html(html);
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $(document).on('change', '#division_id1', function() {
            var region_id = $('#region_id1').val();
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
                    $('#district_id1').html(html);
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(function() {
        $(document).on('change', '#district_id1', function() {
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
                    $('#upazila_id1').html(html);
                }
            });
        });
    });
</script>


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


{{-- Name of the person or institution, taking the first initiative --}}
<script type="text/javascript">
    $(function() {
        $(document).on('change', '#person_division_id', function() {
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
                    $('#person_district_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#person_district_id', function() {
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
                    $('#person_upazila_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#person_upazila_id', function() {
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
                    $('#person_union_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        $(document).on('change', '#person_union_id', function() {
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
                    $('#person_village_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function() {
        var date = new Date();

        $('.postingdatepicker').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,

                //minDate: new Date(date.setDate(date.getDate() - 6)),

                maxDate: new Date(),

                autoApply: true,
                locale: {
                    format: 'DD-MM-YYYY',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    firstDay: 0
                },
            },
            function(start) {
                this.element.val(start.format('DD-MM-YYYY'));
                this.element.parent().parent().removeClass('has-error');
            },
            function(chosen_date) {
                this.element.val(chosen_date.format('DD-MM-YYYY'));
            });

        $('.singledatepicker').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY'));
        });
    });
</script>
