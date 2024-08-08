@extends('backend.layouts.app')
@section('content')
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Survivor Wise SELP Report</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home </li>
                <li class="breadcrumb-item active">Survivor Wise SELP Report</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container fullbody">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Survivor Wise Report</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('survivor.wise.report.create') }}" id="filterForm"
                        target="_blank">
                        @csrf
                        <div class="form-row mb-3">
                            <div class="form-group col-4">
                                <label class="control-label">Report Type <span class="text-danger">*</span></label>
                                <select name="report_type" id="report_type" class="form-control form-control-sm select2"
                                    required>
                                    {{-- <option disabled selected value="">Select Report Type</option> --}}
                                    <option value="1">1. Survivor wise direct service </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label class="control-label">Zone </label>
                                <select name="region_id" id="region_id"
                                    class="region_id form-control form-control-sm select2">
                                    <option selected value="">Select All</option>
                                    @foreach ($regions as $region)
                                        @if (count(session()->get('userareaaccess.sregions')) == 1)
                                            <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                        @else
                                            <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Division </label>
                                <select name="division_id" id="division_id"
                                    class="division_id form-control form-control-sm select2">
                                    <option value="">Select All</option>

                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">District </label>
                                <select name="district_id" id="district_id"
                                    class="district_id form-control form-control-sm select2">
                                    <option value="">Select All</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Upazila</label>
                                <select name="upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
                                    <option value="">Select All</option>
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
                                <input type="text" name="from_date" class="form-control form-control-sm singledatepicker"
                                    placeholder="DD-MM-YYYY" autocomplete="off" required="">
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
                                <input type="text" name="to_date" class="form-control form-control-sm singledatepicker"
                                    placeholder="DD-MM-YYYY" autocomplete="off" required="">
                            </div>


                            <div class="form-group col-sm-3">
                                <label class="control-label">Document Type</label>
                                <select name="format_download" id="format_download"
                                    class="format_download form-control form-control-sm" required="">
                                    {{-- <option value="">Select Document Type</option>
                                    <option value="1"> PDF </option> --}}
                                    <option value="2"> Excel </option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <!-- <a class="btn btn-sm btn-primary" type="submit" style="margin-top: 29px; color: white">Search</a> -->
                                <button type="submit" class="btn btn-success btn-sm"
                                    style="margin-top: 29px; color: white">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
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
                        var html = `<option value="">Select District</option>`;
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
                        var html = `<option value="">Select District</option>`;
                        $.each(data, function(key, v) {
                            html += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        });
                        $('#upazila_id').html(html);
                    }
                });
            });
        });
    </script>
@endsection
