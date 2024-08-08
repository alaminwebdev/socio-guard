@extends('backend.layouts.app')
@section('content')
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Child Marriage Prevention</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home </li>
                <li class="breadcrumb-item active"> Edit Child Marriage Prevention</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container fullbody">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        Edit Child Marriage Prevention
                        <a class="btn btn-sm btn-success float-right"
                            href="{{ route('childmarriageinformation.index') }}"><i class="fa fa-list"></i> Child Marriage
                            Info List</a>
                    </h5>
                </div>
            </div>
        </div>


        <div class="col-md-12 mt-4" id="get_form">
            <div class="card">
                <form method="POST" action="{{ route('childmarriageinformation.update', $childmarriageinformation->id) }}"
                    id="myForm">
                    @csrf
                    @method('PUT')

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-3">
                                <h6>Prevention ID: {{ $childmarriageinformation->id }}</h6>
                            </div>
                            <div class="col-sm-2 text-right">
                                <h6 class="control-label">Reporting Date</h6>
                            </div>
                            <div class="col-sm-3">
                                @php
                                    $today = date('Y-m-d');
                                    $posting_today = $childmarriageinformation->reporting_date;
                                    $date = date_diff(date_create($today), date_create($posting_today));
                                    $days = $date->format('%a');
                                @endphp
                                <input type="text" name="reporting_date"
                                    value="{{ $childmarriageinformation->reporting_date != null ? date('d-m-Y', strtotime($childmarriageinformation->reporting_date)) : '' }}"
                                    id="posting_date"
                                    class="form-control form-control-sm {{ @$days >= 7 ? '' : 'postingdatepicker' }}"
                                    readonly>
                            </div>
                            <div class="col-sm-4 text-right">
                                <h6 class=" pl-2">Creation Date: {{ date('d-m-Y') }}</h6>
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
                                <input type="text" name="employee_name" id="employee_name"
                                    class="form-control form-control-sm"
                                    value="{{ $childmarriageinformation->employee_name }}" readonly="">
                            </div>
                            <div class="form-group col-sm-3">
                                <label class="control-label">Cell</label>
                                <input type="text" name="employee_mobile_number" id="employee_mobile_number"
                                    class="form-control form-control-sm"
                                    value="{{ $childmarriageinformation->employee_mobile_number }}" readonly="">
                            </div>
                            <div class="form-group col-sm-3">
                                <label class="control-label">Designation</label>
                                <input type="text" name="employee_designation"
                                    value="{{ $childmarriageinformation->employee_designation }}" id="employee_designation"
                                    class="form-control form-control-sm" readonly="">
                            </div>
                            <div class="form-group col-sm-3">
                                <label class="control-label">Pin</label>
                                <input type="text" name="employee_pin"
                                    value="{{ $childmarriageinformation->employee_pin }}" id="employee_pin"
                                    class="form-control form-control-sm" readonly="">
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
                                                    {{ $childmarriageinformation->employee_zone_id == $region->id ? 'selected' : '' }}>
                                                    {{ $region->region_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select name="employee_zone_id" id="region_id1"
                                        class="region_id form-control form-control-sm select2" required="">
                                        <option value="">Select Zone</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}"
                                                {{ $childmarriageinformation->employee_zone_id == $region->id ? 'selected' : '' }}>
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
                                <select name="employee_division_id" id="division_id1"
                                    class="division_id form-control form-control-sm" required="">
                                    {!! getRegionalDivision(
                                        $childmarriageinformation->employee_zone_id,
                                        $childmarriageinformation->employee_division_id,
                                    ) !!};

                                </select>
                                @error('employee_division_id')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">District <span class="text-danger">*</span></label>
                                <select name="employee_district_id" id="district_id1"
                                    class="district_id form-control form-control-sm" required>
                                    {!! getRegionalDivisionDistrict(
                                        $childmarriageinformation->employee_zone_id,
                                        $childmarriageinformation->employee_division_id,
                                        $childmarriageinformation->employee_district_id,
                                    ) !!};
                                </select>
                                @error('employee_district_id')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Upazila <span class="text-danger">*</span></label>
                                <select name="employee_upazila_id" id="upazila_id1"
                                    class="upazila_id form-control form-control-sm" required>
                                    {!! getupazila($childmarriageinformation->employee_district_id, $childmarriageinformation->employee_upazila_id) !!};
                                </select>
                                @error('employee_upazila_id')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                        </div>
                        <hr>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <h6>Child Information:</h6>
                            </div>
                            <div class="form-group col-sm-3">
                                <label class="control-label">Child Name <span class="text-danger">*</span></label>
                                <input type="text" name="child_name" id="child_name"
                                    value="{{ old('child_name', $childmarriageinformation->child_name) }}"
                                    class="form-control form-control-sm" required>
                                @error('child_name')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-sm-3">
                                <label class="control-label">Age <span class="text-danger">*</span></label>
                                <input type="text" name="child_age" id="child_age"
                                    value="{{ old('child_age', $childmarriageinformation->child_age) }}"
                                    class="form-control form-control-sm" required>
                                @error('child_age')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-sm-3">
                                <label class="control-label">Father Name</label>
                                <input type="text" name="child_father_name"
                                    value="{{ old('child_father_name', $childmarriageinformation->child_father_name) }}"
                                    class="form-control form-control-sm">
                                @error('child_father_name')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-sm-3">
                                <label class="control-label">Mother Name</label>
                                <input type="text" name="child_mother_name"
                                    value="{{ old('child_mother_name', $childmarriageinformation->child_mother_name) }}"
                                    class="form-control form-control-sm">
                                @error('child_mother_name')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-sm-3">
                                <label class="control-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="text" name="child_mobile_number" id="child_mobile_number"
                                    value="{{ old('child_mobile_number', $childmarriageinformation->child_mobile_number) }}"
                                    class="form-control form-control-sm" required>
                                @error('child_mobile_number')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-sm-3">
                                <label class="control-label">Gender <span class="text-danger">*</span></label>

                                <select name="child_gender" id="child_gender"
                                    class="form-control form-control-sm @error('child_gender') is-invalid @enderror"
                                    required="">
                                    <option value="">Select Gender</option>
                                    @foreach ($child_gender as $gender)
                                        <option
                                            {{ $childmarriageinformation->child_gender_id == $gender->id ? 'selected' : '' }}
                                            value="{{ $gender->id }}">{{ $gender->name }}</option>
                                    @endforeach

                                </select>
                                @error('child_gender')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-sm-3">
                                <label class="control-label">Disability status </label>
                                <select name="survivor_disability_status" id=""
                                    class="form-control form-control-sm @error('survivor_disability_status') is-invalid @enderror">
                                    <option value="">Select Disability status <span class="text-danger">*</span>
                                    </option>
                                    @foreach ($survivor_autistic_information as $disability)
                                        <option
                                            {{ $childmarriageinformation->survivor_autistic_information_id == $disability->id ? 'selected' : '' }}
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
                                            {{ $childmarriageinformation->child_division_id == $item->id || old('survivor_division') == $item->id ? 'selected' : '' }}
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
                                    @if ($childmarriageinformation)
                                        {!! getdistrict($childmarriageinformation->child_division_id, $childmarriageinformation->child_district_id) !!};
                                    @else
                                        <option value="">Select District</option>
                                    @endif
                                </select>
                                @error('survivor_district')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-sm-3 column_5_1">
                                <label class="control-label">Upazila <span class="text-danger">*</span></label>
                                <select name="survivor_upazila" id="survivor_upazila_id"
                                    class="form-control form-control-sm @error('survivor_upazila') is-invalid @enderror"
                                    required="">
                                    @if ($childmarriageinformation)
                                        {!! getupazila($childmarriageinformation->child_district_id, $childmarriageinformation->child_upazila_id) !!};
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
                                    class="form-control form-control-sm @error('survivor_union') is-invalid @enderror"
                                    required="">
                                    @if ($childmarriageinformation)
                                        {!! getunion($childmarriageinformation->child_upazila_id, $childmarriageinformation->child_union_id) !!};
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
                                    value="{{ old('survivor_village_name', $childmarriageinformation->child_village_name) }}"
                                    name="survivor_village_name" id="survivor_village_name"
                                    class="form-control form-control-sm @error('survivor_village_name') is-invalid @enderror"
                                    required="">
                                @error('survivor_village_name')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            
                            <div class="form-group col-sm-4">
                                <label class="control-label">Child Marriage Prevention First Initiative <span
                                        class="text-danger">*</span></label>
                                <select name="child_marriage_initiative" id="child_marriage_initiative"
                                    class="select2 information_provider form-control form-control-sm @error('child_marriage_initiative') is-invalid @enderror"
                                    required="">
                                    <option value="">-- Select --</option>
                                    @foreach ($child_marriage_initiative as $initiative)
                                        <option value="{{ $initiative->id }}"
                                            {{ $childmarriageinformation->child_marriage_initiative_id == $initiative->id ? 'selected' : '' }}>
                                            {{ $initiative->name }}</option>
                                    @endforeach

                                </select>
                                @error('child_marriage_initiative')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">Child Marriage Assistance <span
                                        class="text-danger">*</span></label>

                                <select name="child_marriage_assistance_taken[]" id="child_marriage_assistance_taken"
                                    class="select2 information_provider form-control form-control-sm @error('child_marriage_assistance_taken') is-invalid @enderror"
                                    required="" multiple>
                                    <option disabled>-- Select --</option>
                                    @foreach ($child_marriage_assistance_taken as $assistance)
                                        <option value="{{ $assistance->id }}"
                                            {{ in_array($assistance->id, $childmarriageinformation->assistanceTakens->pluck('id')->toArray()) ? 'selected' : '' }}>
                                            {{ $assistance->name }}</option>
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
                                <input type="text" name="person_name" id="person_name"
                                    class="form-control form-control-sm" required
                                    value="{{ old('person_name', $childmarriageinformation->person_name) }}">
                                @error('person_name')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>

                            <div class="form-group col-sm-3">
                                <label class="control-label">Mobile Number</label>
                                <input type="text" name="person_mobile_number" id="person_mobile_number"
                                    class="form-control form-control-sm"
                                    value="{{ old('person_mobile_number', $childmarriageinformation->person_mobile_number) }}"
                                    required>
                                @error('person_mobile_number')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>

                            <div class="form-group col-sm-3 column_5_1">
                                <label class="control-label">Division</label>
                                <select name="person_division_id" id="person_division_id"
                                    class="form-control form-control-sm @error('person_division_id') is-invalid @enderror"
                                    required="">
                                    <option value="">Select Division</option>
                                    @foreach ($divisions as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $childmarriageinformation->person_division_id == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('person_division_id')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-sm-3 column_5_1">
                                <label class="control-label">District</label>
                                <select name="person_district_id" id="person_district_id"
                                    class="form-control form-control-sm @error('person_district_id') is-invalid @enderror"
                                    required="">
                                    {!! getdistrict($childmarriageinformation->person_division_id, $childmarriageinformation->person_district_id) !!};
                                </select>
                                @error('person_district_id')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-sm-3 column_5_1">
                                <label class="control-label">Upazila</label>
                                <select name="person_upazila_id" id="person_upazila_id"
                                    class="form-control form-control-sm @error('person_upazila_id') is-invalid @enderror"
                                    required="">
                                    {!! getupazila($childmarriageinformation->person_district_id, $childmarriageinformation->person_upazila_id) !!};
                                </select>
                                @error('person_upazila_id')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-sm-3 column_5_1">
                                <label class="control-label">Union</label>
                                <select name="person_union_id" id="person_union_id"
                                    class="form-control form-control-sm @error('person_union_id') is-invalid @enderror"
                                    required="">
                                    {!! getunion($childmarriageinformation->person_upazila_id, $childmarriageinformation->person_union_id) !!};
                                </select>
                                @error('person_union_id')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                            <div class="form-group col-sm-3 column_5_1">
                                <label class="control-label">Village</label>
                                <input type="text" name="person_village_name" id="person_village_name"
                                    class="form-control form-control-sm @error('person_village_name') is-invalid @enderror"
                                    required="" value="{{ $childmarriageinformation->person_village_name }}">
                                @error('person_village_name')
                                    <p style="color:red; margin-top:5px;">This field is required</p>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right">
                            @if ($user_info['user_role'][0]['role_id'] == 4 || $user_info['user_role'][0]['role_id'] == 1)
                                <button type="submit" class="btn btn-success btn-sm form_submit">Approved</button>
                                <input type="hidden" name="dm_approved" value="2">
                            @endif
                            @if ($user_info['user_role'][0]['role_id'] == 5)
                                <button type="submit" class="btn btn-success btn-sm form_submit">Submit</button>
                            @endif

                        </div>
                    </div>
                </form>
            </div>
        </div>


        <script type="text/javascript">
            $(function() {
                $(document).on('change', '#region_id', function() {
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
                            $('#division_id').html(html);
                            console.log($('#division_id').html());
                        }
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(function() {
                $(document).on('change', '#division_id', function() {
                    var region_id = $('#region_id').val();
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
                            $('#district_id').html(html);
                        }
                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(function() {
                $(document).on('change', '#district_id', function() {
                    var district_id = $(this).val();
                    $.ajax({
                        url: "{{ route('default.get-region-upazila') }}",
                        type: "GET",
                        data: {
                            district_id: district_id
                        },
                        success: function(data) {
                            console.log(data);
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
                            $('#upazila_id').html(html);
                        }
                    });
                });
            });
        </script>




        <script type="text/javascript">
            $(function() {




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

                        minDate: new Date(date.setDate(date.getDate() - 6)),

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
    @endsection
