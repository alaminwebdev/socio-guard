@extends('backend.layouts.app')
@section('content')

    <style type="text/css">
        
    </style>

    <div class="container-fluid">
        <div class="col-md-12 px-0" style="margin-top: 68px; margin-bottom:15px">
            <div class="card border-0">
                <div class="card-header border-bottom-0 brac-header">
                    <h6 class="mb-0 text-white">Search Criteria</h6>
                </div>
                <div class="card-body">
                    <form method="get" action="" id="filterForm">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="control-label">Zone</label>
                                @if (count(session()->get('userareaaccess.sregions')) > 0)
                                    <select name="region_id" id="region_id" class="region_id form-control form-control-sm select2">
                                        <option value="">Select zone</option>
                                        @foreach ($regions as $key => $region)
                                            @if (in_array($region->id, session()->get('userareaaccess.sregions')))
                                                <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select name="region_id" id="region_id" class="region_id form-control form-control-sm select2">
                                        <option value="">Select Zone</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Division</label>
                                <select name="division_id" id="division_id" class="division_id form-control form-control-sm">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">District</label>
                                <select name="district_id" id="district_id" class="district_id form-control form-control-sm">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Upazila</label>
                                <select name="upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">First initiative taken from SELP </label>
                                <select name="selp_initiative" id="selp_initiative" class="form-control form-control-sm">
                                    <option value=""> -- All -- </option>
                                    <option value="4">Legal Advice </option>
                                    <option value="1"> Referral </option>
                                    <option value="3"> Violence Incident Documented </option>
                                    {{-- <option value="2"> Complain Received </option> --}}
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label class="control-label d-block" style="visibility: hidden;">Search</label>
                                <button type="submit" class="btn btn-sm btn-primary" style="box-shadow:rgba(13, 109, 253, 0.25) 0px 8px 18px 4px; min-width:auto;"><i class="fa fa-search mr-1"></i>Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>

            <div class="card border-0">
                <div class="card-body">
                    <table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="data-table">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Complain ID.</th>
                                <th>Survivor Name</th>
                                <th>First initiative taken from SELP</th>
                                <th>Posting Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('incident.except_complain_received.datatable') }}",
                    data: function(d) {
                        console.log(d);
                        d._token = "{{ csrf_token() }}";
                        d.region_id = $('select[name=region_id]').val();
                        d.division_id = $('select[name=division_id]').val();
                        d.district_id = $('select[name=district_id]').val();
                        d.upazila_id = $('select[name=upazila_id]').val();
                        d.selp_initiative = $('select[name=selp_initiative]').val();
                        d.from_date = $('input[name=from_date]').val();
                        d.to_date = $('input[name=to_date]').val();
                    }
                },
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'selp_incident_informations.id'
                    },
                    {
                        data: 'complain_id',
                        name: 'selp_incident_informations.id'
                    },
                    {
                        data: 'survivor_name',
                        name: 'selp_incident_informations.survivor_name'
                    },
                    {
                        data: 'selp_initiative',
                        name: 'selp_incident_informations.selp_initiative'
                    },
                    {
                        data: 'posting_date',
                        name: 'selp_incident_informations.posting_date'
                    },
                    {
                        data: 'status',
                        name: 'selp_incident_informations.status'
                    },
                    {
                        data: 'action_column',
                        name: 'action_column'
                    }
                ]
            });

            $('#filterForm').on('submit', function(e) {
                console.log("asf");
                dTable.draw();
                e.preventDefault();
            });
        });
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
                        var html = '<option value="">Select Division</option>';
                        $.each(data, function(key, v) {
                            html += '<option value="' + v.division_id + '">' + v.regional_division.name + '</option>';
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
                        var html = '<option value="">Select District</option>';
                        $.each(data, function(key, v) {
                            html += '<option value="' + v.district_id + '">' + v.regional_district.name + '</option>';
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
                                html += '<option value="' + v.id + '">' + v.name + '</option>';
                            } else {
                                html += '<option value="' + v.setup_user_upazila.id + '">' + v.setup_user_upazila.name + '</option>';
                            }
                        });
                        $('#upazila_id').html(html);
                    }
                });
            });
        });
    </script>
@endsection
