@extends('backend.layouts.app')
@section('content')
    <style>
        button {
            min-width: auto;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected],
        .select2-container--default .select2-results__option--highlighted[aria-selected]:hover {
            background-color: rgb(153 14 80 / 90%);
        }

        .select2-container--default .select2-results__option--selected {
            background-color: #f8f9fa;
        }
    </style>
    <div class="col-xl-12">
        <div class="breadcrumb-holder" style="padding:30px 25px 0 25px;">
            <h1 class="main-title float-left">Swapnosarothi Group Wise Report</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home </li>
                <li class="breadcrumb-item active">Swapnosarothi Group Wise Report</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header border-bottom-0 brac-header">
                    <h6 class="mb-0 text-white">Swapnosarothi Group Wise Report</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('swapnosarothi.group.wise.report.index') }}" id="filterForm">
                        @csrf
                        <div class="form-row mb-3">
                            <div class="form-group col-md-3">
                                <label class="control-label">Report Type <span class="text-danger">*</span></label>
                                <select name="report_type" id="report_type" class="form-control form-control-sm select2" required>
                                    <option disabled selected value="">Select Report Type</option>
                                    <option value="1" {{ request()->report_type == 1 ? 'selected' : '' }}>1. No.of Girls</option>
                                    <option value="2" {{ request()->report_type == 2 ? 'selected' : '' }}>2. No.of PWD Girls</option>
                                    <option value="3" {{ request()->report_type == 3 ? 'selected' : '' }}>3. No.of Girls under cash support</option>
                                    <option value="4" {{ request()->report_type == 4 ? 'selected' : '' }}>4. No.of PWD Girls under cash support</option>
                                    <option value="5" {{ request()->report_type == 5 ? 'selected' : '' }}>5. No.of first time initiative of Child marriage prevention</option>
                                    <option value="6" {{ request()->report_type == 6 ? 'selected' : '' }}>6. No.of second time initiative of Child marriage prevention</option>
                                    <option value="7" {{ request()->report_type == 7 ? 'selected' : '' }}>7. No.of Third time initiative of Child marriage prevention</option>
                                    <option value="8" {{ request()->report_type == 8 ? 'selected' : '' }}>8. No.of Married Girl</option>
                                    <option value="9" {{ request()->report_type == 9 ? 'selected' : '' }}>9. No.of Married Girl under studenship</option>
                                    <option value="10" {{ request()->report_type == 10 ? 'selected' : '' }}>10. No.of Girls Attended in life skill session</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Zone </label>
                                <select name="region_id" id="region_id" class="region_id form-control form-control-sm select2">
                                    <option selected value="">Select All</option>
                                    @foreach ($regions as $item)
                                        @if (count(session()->get('userareaaccess.sregions')) == 1)
                                            <option value="{{ $item->id }}" {{ request()->region_id == $item->id ? 'selected' : '' }}>{{ $item->region_name }}</option>
                                        @else
                                            <option value="{{ $item->id }}" {{ request()->region_id == $item->id ? 'selected' : '' }}>{{ $item->region_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Division </label>
                                <select name="division_id" id="division_id" class="division_id form-control form-control-sm select2">
                                    <option value="">Select All</option>
                                    @if (request()->division_id)
                                        <option value="{{ $division->id }}" selected>{{ $division->name }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">District </label>
                                <select name="district_id" id="district_id" class="district_id form-control form-control-sm select2">
                                    <option value="">Select All</option>
                                    @if (request()->district_id)
                                        <option value="{{ $district->id }}" selected>{{ $district->name }}</option>
                                    @endif
                                </select>
                            </div>

                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label class="control-label">Upazila</label>
                                <select name="upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
                                    <option value="">Select All</option>
                                    @if (request()->upazila_id)
                                        <option value="{{ $upazila->id }}" selected>{{ $upazila->name }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Groups</label>
                                <select name="group_id" id="group_id" class="form-control form-control-sm">
                                    <option value="">Select Group</option>
                                    @isset($groups)
                                        @if (request()->upazila_id)
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}" {{ $group->id == request()->group_id ? 'selected' : '' }}>{{ $group->group_name }}</option>
                                            @endforeach
                                        @endif
                                    @endisset
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">From Date <span class="text-danger">*</span></label>
                                <!-- <select name="from_year" id="from_year" class="form-control form-control-sm select2" required="">
                                                    <option value="">Select From Year</option>
                                                        @php
                                                            $last_year = date('Y');
                                                            for ($i = $last_year; $i >= 1990; $i--) {
                                                                echo '<option value="' . $i . '">' . $i . '</option>';
                                                            }
                                                        @endphp
                                                </select> -->
                                <input type="text" name="from_date" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off" required="" value="{{ request()->from_date ? request()->from_date : '' }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">To Date <span class="text-danger">*</span></label>
                                <!-- <select name="to_year" id="to_year" class="form-control form-control-sm select2" required="">
                                                                <option value="">Select To Year</option>
                                                                @php
                                                                    $last_year = date('Y');
                                                                    for ($i = $last_year; $i >= 1990; $i--) {
                                                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                                                    }
                                                                @endphp
                                                               </select> -->
                                <input type="text" name="to_date" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off" required="" value="{{ request()->to_date ? request()->to_date : '' }}">
                            </div>

                            <div class="form-group col-md-2">
                                <label class="control-label">Data Source</label>
                                <select name="data_source" id="data_source" class="form-control form-control-sm">
                                    <option value="current_zone" {{ request()->data_source == 'current_zone' ? 'selected' : '' }}>Current Zone</option>
                                    <option value="old_zone" {{ request()->data_source == 'old_zone' ? 'selected' : '' }}>Previous Zone</option>
                                </select>
                            </div>

                            <div class="form-group col-sm-2">
                                <label class="control-label" style="visibility: hidden;">Search</label>
                                <button type="submit" name="type" value="search" class="btn btn-success btn-sm btn-block">Search</button>
                            </div>
                        </div>
                        @if (isset($array_data) && count($array_data) > 0)
                            <div class="d-flex justify-content-end">
                                <div class="mr-1">
                                    <button type="submit" class="btn btn-sm btn-block btn-danger" name="type" value="pdf"><i class="fa fa-file-pdf-o mr-1"></i>PDF</button>
                                </div>
                                <div class="">
                                    <button type="submit" class="btn btn-sm btn-block btn-info" name="type" value="xls"><i class="fa fa-file-excel-o mr-1"></i>Excel</button>
                                </div>
                            </div>
                        @endif
                    </form>

                    @isset($report_type)
                        @if ($report_type == 1 || $report_type == 2)
                            @include('backend.report.swapnosarothi.no_of_girls')
                        @elseif ($report_type == 3 || $report_type == 4)
                            @include('backend.report.swapnosarothi.girls_under_cash_support')
                        @elseif ($report_type == 5 || $report_type == 6 || $report_type == 7)
                            @include('backend.report.swapnosarothi.girls_under_initiative')
                        @elseif ($report_type == 8 || $report_type == 9)
                            @include('backend.report.swapnosarothi.married_girls')
                        @elseif ($report_type == 10)
                            @include('backend.report.swapnosarothi.girls_skills_session')
                        @endif
                    @endisset
                </div>
            </div>
        </div>
    </div>

    <script>
        // $(function() {
        //     window.onload = function() {
        //         $('.region_id').trigger('change');
        //     };
        // });
    </script>

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
                        var html = '<option value="">Select All</option>';
                        $.each(data, function(key, v) {
                            html += '<option value="' + v.division_id + '">' + v
                                .regional_division.name + '</option>';
                        });
                        $('#division_id').html(html);
                        $('#district_id').html('<option value="">Select All</option>');
                        $('#upazila_id').html('<option value="">Select All</option>');
                        $('#group_id').html('<option value="">Select All</option>');
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
                        var html = `<option value="">Select All</option>`;
                        $.each(data, function(key, v) {
                            html += '<option value="' + v.district_id + '">' + v
                                .regional_district.name + '</option>';
                        });
                        $('#district_id').html(html);
                        $('#upazila_id').html('<option value="">Select All</option>');
                        $('#group_id').html('<option value="">Select All</option>');
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
                        var html = `<option value="">Select All</option>`;
                        $.each(data, function(key, v) {
                            html += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        });
                        $('#upazila_id').html(html);
                        $('#group_id').html('<option value="">Select All</option>');
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#upazila_id', function() {
                var region_id = $('#region_id').val();
                var division_id = $('#division_id').val();
                var district_id = $('#district_id').val();
                var upazila_id = $(this).val();

                $.ajax({
                    url: "{{ route('default.get-swapnosarothi-groups') }}",
                    type: "GET",
                    data: {
                        region_id: region_id,
                        division_id: division_id,
                        district_id: district_id,
                        upazila_id: upazila_id
                    },
                    success: function(data) {
                        console.log(data);
                        var html = `<option value="">Select All</option>`;
                        $.each(data, function(key, v) {
                            html += '<option value="' + v.id + '">' + v.group_name +
                                '</option>';
                        });
                        $('#group_id').html(html);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('click', '[name=type]', function(e) {
                var type = $(this).attr('value');
                if (type == 'pdf' || type == 'xls') {
                    $('#filterForm').attr('target', '_blank');
                } else {
                    $('#filterForm').removeAttr('target');
                }
            });
        })
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dataSourceSelect = document.getElementById("data_source");
            const fromDateInput = document.querySelector("input[name='from_date']");
            const toDateInput = document.querySelector("input[name='to_date']");

            function toggleDateFields() {
                if (dataSourceSelect.value === "old_zone") {
                    fromDateInput.removeAttribute("required");
                    toDateInput.removeAttribute("required");
                    fromDateInput.setAttribute("readonly", true);
                    toDateInput.setAttribute("readonly", true);
                    fromDateInput.value = "";
                    toDateInput.value = "";
                } else {
                    fromDateInput.setAttribute("required", "required");
                    toDateInput.setAttribute("required", "required");
                    fromDateInput.removeAttribute("readonly");
                    toDateInput.removeAttribute("readonly");
                }
            }

            // Initial check
            toggleDateFields();

            // Listen for changes in the data_source dropdown
            dataSourceSelect.addEventListener("change", toggleDateFields);
        });
    </script>

@endsection
