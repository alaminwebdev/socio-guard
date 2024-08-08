@extends('backend.layouts.app')
@section('content')
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Upazila Wise SELP Report</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home </li>
                <li class="breadcrumb-item active">Upazila Wise SELP Report</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container fullbody">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Upazila Wise Report</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('upazila.wise.report.create') }}" id="filterForm" target="_blank">
                        @csrf
                        <div class="form-row mb-3">
                            <div class="form-group col-4">
                                <label class="control-label">Report Type <span class="text-danger">*</span></label>
                                <select name="report_type" id="report_type" class="form-control form-control-sm select2"
                                    required>
                                    <option disabled selected value="">Select Report Type</option>
                                    <option value="1">1. Dispute reported by BRAC participants</option>
                                    <option value="2">2. No of disputes reported</option>
                                    <option value="3">3. No. of provided legal advices</option>
                                    <option value="4">4. No. of complaints received</option>
                                    <option value="5">5. No of ADR completed</option>
                                    <option value="6">6. No of court cases filed</option>
                                    <option value="7">7. No of judgement received</option>
                                    <option value="8">8. No of survivors provided referral services(Primary and
                                        secondary)</option>
                                    <option value="9">9. No.of ADR recovered money</option>
                                    <option value="10">10. Amount of money recovered through ADRs</option>
                                    <option value="11">11. No. of court cases recovered money</option>
                                    <option value="12">12. Amount of money recovered through court cases</option>
                                    <option value="13">13. No of Complains completed on Dower, maintanance, inheritance
                                        rights and dower and maintanance through ADR and Court case</option>
                                    <option value="14">14. No.of People benefited for
                                        dower, Maintenance, Inheritance, Dower and Maintenance through ADR and Court case
                                    </option>
                                    <option value="15">15. No.of Survivors received Assistance to treatment/Medical
                                        support</option>
                                    <option value="16">16. No.of Survivors received Assistance to One stop Crisis Centre
                                        (OCC)</option>
                                    <option value="17">17. No.of Survivors received Assistance to Police station
                                    </option>
                                    <option value="18">18. No.of Survivors received Provided to Phycosocial counselling
                                    </option>
                                    <option value="19">19. No.of child marriage incident report</option>
                                    <option value="20">20. No.of child marriage prevented </option>
                                    <option value="21">21. Types of first initiative taken to prevent child marriage
                                    </option>
                                    <option value="22">22. Assistance taken to Prevent child marriage initiatives
                                    </option>

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
                                    <option value="">Select Document Type</option>
                                    <option value="1"> PDF </option>
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
