@extends('backend.layouts.app')
@section('content')

    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Manage User Setup</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home </li>
                <li class="breadcrumb-item active">User Setup</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container fullbody">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        Add User Setup
                        <a class="btn btn-sm btn-success float-right" href="{{ route('user.setup.view') }}"><i
                                class="fa fa-list"></i> User Setup List</a>
                    </h5>
                </div>
                <!-- Form Start-->
                <form method="post" action="{{ route('user.setup.update', $user_id) }}" id="myForm" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <div class="show_module_more_event">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label class="control-label">PIN</label>
                                    <select name="employee_pin" class="form-control form-control-sm select2 employee_pin"
                                        onchange="getUser(this.options[this.selectedIndex].value, $(this));">
                                        <option value="">Select PIN</option>
                                        @foreach ($employee_pins as $employee_pin)
                                            <option value="{{ $employee_pin->pin }}"
                                                {{ $employee_pin->pin == $editData[0]->employee_pin ? 'selected' : '' }}>
                                                {{ $employee_pin->pin }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="user_id" class="form-control form-control-sm user_id"
                                        value="{{ $editData[0]->user_id }}" readonly="">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Name</label>
                                    <input type="text" name="employee_name"
                                        class="form-control form-control-sm employee_name"
                                        value="{{ $editData[0]->employee_name }}" readonly="">
                                </div>
                                <div class="form-group col-md-3">
                                    <label class="control-label">Role</label>
                                    <input type="text" class="form-control form-control-sm role_name"
                                        value="{{ $editData[0]->user->designation }}" readonly="">
                                </div>

                            </div>
                            <div class="region_area">
                                @php
                                    $render = true;
                                @endphp

                                @for ($i = 0; $i < count($editData); $i++)
                                
                                    {{-- @if (count($editData[$i]->setup_user_area) == 0)
                                        @if ($render)
                                            @include('backend.admin.setup.cep_region.user.useradd')
                                            @php
                                                $render = false;
                                            @endphp
                                        @endif
                                    @else --}}
                                        @foreach ($editData[$i]->setup_user_area as $user_area)
                                            <div class="form-row region_area_info">
                                                <div class="row">
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Zone</label>
                                                        <select name="region_id[]"
                                                            class="form-control form-control-sm region_id"
                                                            onchange="getRegionalDivision(this.options[this.selectedIndex].value, $(this));">
                                                            <option value="">Select Zone</option>
                                                            @foreach ($regions as $region)
                                                                <option value="{{ $region->id }}"
                                                                    {{ $editData[$i]->region->id == $region->id ? 'selected' : '' }}>
                                                                    {{ $region->region_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Division</label>
                                                        <select name="division_id[]"
                                                            class="form-control form-control-sm division_id"
                                                            onchange="getRegionalDivisionDistrict(this.options[this.selectedIndex].value, $(this));">
                                                            <option value="">Select Division</option>
                                                            @foreach ($divisions as $division)
                                                                <option value="{{ $division->id }}"
                                                                    {{ $user_area->division_id == $division->id ? 'selected' : '' }}>
                                                                    {{ $division->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">District</label>
                                                        <select name="district_id[]"
                                                            class="form-control form-control-sm district_id"
                                                            onchange="getDistrictUpazila(this.options[this.selectedIndex].value, $(this));">
                                                            <option value="">Select District</option>
                                                            @foreach ($districts as $district)
                                                                <option value="{{ $district->id }}"
                                                                    {{ $user_area->district_id == $district->id ? 'selected' : '' }}>
                                                                    {{ $district->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Upazila</label>
                                                        <select name="upazila_id[]"
                                                            class="form-control form-control-sm upazila_id"
                                                            onchange="getUpazilaUnion(this.options[this.selectedIndex].value, $(this));">
                                                            <option value="">Select Upazila</option>
                                                            @foreach ($upazilas as $upazila)
                                                                <option value="{{ $upazila->id }}"
                                                                    {{ $user_area->upazila_id == $upazila->id ? 'selected' : '' }}>
                                                                    {{ $upazila->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Union</label>
                                                        <select name="union_id[]"
                                                            class="form-control form-control-sm union_id">
                                                            <option value="">Select Union</option>
                                                            @foreach ($unions as $union)
                                                                <option value="{{ $union->id }}"
                                                                    {{ $user_area->union_id == $union->id ? 'selected' : '' }}>
                                                                    {{ $union->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Date from</label>
                                                        <input type="date" class="form-control form-control-sm date_from"
                                                            name="date_from[]" value="{{ $user_area->date_from }}">
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Date to </label>
                                                        <input type="date" class="form-control form-control-sm date_to"
                                                            value="{{ $user_area->date_to }}" name="date_to[]"
                                                            id="">
                                                    </div>
                                                    <div class="form-group col-md-1" style="margin-top: 22px;">
                                                        <i class="fa fa-plus btn btn-sm btn-info"
                                                            onclick="add($(this));"></i>
                                                        <i class="fa fa-minus btn btn-sm btn-danger btn-remove"
                                                            data-type="delete" onclick="remove($(this));"></i>
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    {{-- @endif --}}
                                @endfor

                                <div class="extra_region_area_info"></div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm">Submit</button>
                        <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                    </div>
                </form>
                <!--Form End-->
            </div>
        </div>
    </div>
    <!-- extra html -->

    <script>
        $(document).ready(function() {
            $('#myForm').validate({
                errorClass: 'text-danger',
                validClass: 'text-success',
                rules: {
                    'employee_name': {
                        required: true,
                    },
                    'employee_pin': {
                        required: true,
                    },
                },
                messages: {

                }
            });
        });

        function add(item) {
            var extra_region_area_info = item.closest('.region_area_info').clone();

            extra_region_area_info.find('.btn-remove').removeClass('d-none');
            extra_region_area_info.find('input, select').each(function() {
                $(this).val('');
            });

            item.closest('.region_area').find('.extra_region_area_info').append(extra_region_area_info);
        }

        function remove(item) {
            console.log(item.closest('.region_area_info').find('.region_id').val());

            let region_id = item.closest('.region_area_info').find('.region_id').val();
            let division_id = item.closest('.region_area_info').find('.division_id').val();
            let district_id = item.closest('.region_area_info').find('.district_id').val();
            let upazila_id = item.closest('.region_area_info').find('.upazila_id').val();
            let union_id = item.closest('.region_area_info').find('.union_id').val();
            let user_id = item.closest('.show_module_more_event').find('.user_id').val();
            let date_from = item.closest('.region_area_info').find('.date_from').val();
            let date_to = item.closest('.region_area_info').find('.date_to').val();

            var url = "{{ route('setup.user.removeuserzonedistrict') }}";
            var data = {
                region_id: region_id,
                division_id: division_id,
                district_id: district_id,
                upazila_id: upazila_id,
                union_id: union_id,
                user_id: user_id,
                date_from: date_from,
                date_to: date_to
            }

            $.get(url, data, function(response) {
                console.log(response);
                // item.closest('.show_module_more_event').find('.division_id').html(response);
                //item.closest('.region_area_info').find('.division_id').html(response);

            });
            item.closest('.region_area_info').remove();
        }

        function getUser(employee_pin, item) {
            var url = "{{ route('setup.getUser') }}";
            var data = {
                employee_pin: employee_pin
            }

            $.get(url, data, function(response) {
                var role_name = '';
                $.each(response.user_role, function(index, value) {
                    role_name += value.role_details.name + ', ';
                });

                item.closest('.show_module_more_event').find('.user_id').val(response.id);
                item.closest('.show_module_more_event').find('.employee_name').val(response.name);
                item.closest('.show_module_more_event').find('.role_name').val(role_name);
            });
        }

        function getRegionalDivision(region_id, item) {
            var url = "{{ route('setup.getRegionalDivision') }}";
            var data = {
                region_id: region_id
            }

            $.get(url, data, function(response) {
                // console.log(response);
                // item.closest('.show_module_more_event').find('.division_id').html(response);
                item.closest('.region_area_info').find('.division_id').html(response);

            });
        }

        function getRegionalDivisionDistrict(division_id, item) {
            console.log(item.val)
            var region_id = item.closest('.region_area_info').find('.region_id').val(); //$('.region_id').val();
            var url = "{{ route('setup.getRegionalDivisionDistrict') }}";
            var data = {
                region_id: region_id,
                division_id: division_id
            }

            $.get(url, data, function(response) {
                // console.log(response);
                item.closest('.region_area_info').find('.district_id').html(response);
            });
        }

        function getDistrictUpazila(district_id, item) {
            var url = "{{ route('setup.getDistrictUpazila') }}";
            var data = {
                district_id: district_id
            }

            $.get(url, data, function(response) {
                // console.log(response);
                item.closest('.region_area_info').find('.upazila_id').html(response);
            });
        }

        function getUpazilaUnion(upazila_id, item) {
            var url = "{{ route('setup.getUpazilaUnion') }}";
            var data = {
                upazila_id: upazila_id
            }

            $.get(url, data, function(response) {
                // console.log(response);
                item.closest('.region_area_info').find('.union_id').html(response);
            });
        }
    </script>

@endsection
