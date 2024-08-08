@extends('backend.layouts.app')
@section('content')
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Child Marriage Prevention</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home </li>
                <li class="breadcrumb-item active"> Add Child Marriage Prevention </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container fullbody">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        Add Child Marriage Prevention
                        <a class="btn btn-sm btn-success float-right"
                            href="{{ route('childmarriageinformation.index') }}"><i class="fa fa-list"></i> Child Marriage
                            Prevention List</a>
                    </h5>
                </div>
                {{-- <div class="card-body">
                    <form action="">
                        <label class="mr-3">
                            <input type="radio" name="childmarriage" value="2" class="load_complain_form" checked>
                            Add New Child Marriage Prevention
                        </label>
                        <label>
                            <input type="radio" name="childmarriage" value="1" class="load_complain_form">
                            Complain Id wise Child Marriage Prevention
                        </label>

                    </form>
                </div> --}}
            </div>
        </div>

        <div class="col-md-12 mt-4 d-none" id="get_complain">
            <div class="card">
                <div class="card-body">
                    <form method="get" action="" id="filterForm">
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="control-label">Zone</label>
                                @if (count(session()->get('userareaaccess.sregions')) > 0)
                                    <select name="region_id" id="region_id"
                                        class="region_id form-control form-control-sm select2">
                                        <option value="">Select zone</option>
                                        @foreach ($regions as $key => $region)
                                            @if (in_array($region->id, session()->get('userareaaccess.sregions')))
                                                <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select name="region_id" id="region_id"
                                        class="region_id form-control form-control-sm select2">
                                        <option value="">Select Zone</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Division</label>
                                <select name="division_id" id="division_id"
                                    class="division_id form-control form-control-sm">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">District</label>
                                <select name="district_id" id="district_id"
                                    class="district_id form-control form-control-sm">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Upazila</label>
                                <select name="upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-2">
                                <label class="control-label">From Date</label>
                                <input type="text" name="from_date" id="from_date"
                                    class="form-control form-control-sm singledatepicker" placeholder="From Date"
                                    autocomplete="off">
                            </div>
                            <div class="form-group col-sm-2">
                                <label class="control-label">To Date</label>
                                <input type="text" name="to_date" id="to_date"
                                    class="form-control form-control-sm singledatepicker" placeholder="To Date"
                                    autocomplete="off">
                            </div>
                            <div class="form-group col-sm-2">
                                <!-- <a class="btn btn-sm btn-primary" type="submit" style="margin-top: 29px; color: white">Search</a> -->
                                <button type="submit" class="btn btn-success btn-sm"
                                    style="margin-top: 21px; color: white">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%"
                        id="data-table">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Complain ID.</th>
                                <th>Survivor Name</th>
                                <th>Survivor Age</th>
                                <th>Reporting Date</th>
                                <th>Creation Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-4" id="get_form">
            <div class="card">
                @include('backend/childmarriageinformation/form')
            </div>
        </div>
        <!-- extra html -->
        <script type="text/javascript">
            $(document).ready(function() {
                $('.load_complain_form').on('click', function() {
                    if ($(this).val() == 1) {
                        $("#data-table").dataTable().fnDestroy();

                        $('#get_complain').removeClass('d-none');
                        $('#get_complain').addClass('d-block');
                        $('#get_form').removeClass('d-block');
                        $('#get_form').addClass('d-none');

                        var dTable = $('#data-table').DataTable({
                            processing: true,
                            serverSide: true,

                            ajax: {
                                url: '{{ route('child.marriage.information.complain') }}',
                                data: function(d) {
                                    console.log(d);
                                    d._token = "{{ csrf_token() }}";
                                    d.region_id = $('select[name=region_id]').val();
                                    d.division_id = $('select[name=division_id]').val();
                                    d.district_id = $('select[name=district_id]').val();
                                    d.upazila_id = $('select[name=upazila_id]').val();
                                    d.union_id = $('select[name=union_id]').val();
                                    d.violence_category_id = $('select[name=violence_category_id]')
                                        .val();
                                    d.violence_sub_category_id = $(
                                        'select[name=violence_sub_category_id]').val();
                                    d.violence_name_id = $('select[name=violence_name_id]').val();
                                    d.survivor_id = $('input[name=survivor_id]').val();
                                    d.from_date = $('input[name=from_date]').val();
                                    d.to_date = $('input[name=to_date]').val();
                                }
                            },
                            columns: [{
                                    data: 'DT_RowIndex',
                                    name: 'selp_incident_informations.id'
                                },
                                {
                                    data: 'selp_incident_ref',
                                    name: 'selp_incident_informations.selp_incident_ref'
                                },
                                {
                                    data: 'survivor_name',
                                    name: 'selp_incident_informations.survivor_name'
                                },
                                {
                                    data: 'survivor_age',
                                    name: 'selp_incident_informations.survivor_age'
                                },
                                {
                                    data: 'posting_date',
                                    name: 'selp_incident_informations.posting_date'
                                },
                                {
                                    data: 'created_at',
                                    name: 'selp_incident_informations.created_at'
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
                    } else {


                        $('#get_complain').removeClass('d-block');
                        $('#get_complain').addClass('d-none');
                        $('#get_form').removeClass('d-none');
                        $('#get_form').addClass('d-block');

                    }

                });
            });
        </script>

        <script>
            $(document).ready(function() {
                $('#data-table').on('click.dt', function(e) {
                    if (e.target.getAttribute("action_type") == "inc_del") {
                        remove(e.target.id, e, '');
                    }
                    //console.log(e.target.getAttribute("action_type"));

                });
            });

            function remove(id, e, item) {
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "would you like to delete this complain record and relevant information? You will not be able to recover this item!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonClass: 'btn-danger',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: "No, cancel plx!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            var url = "{{ route('incident.delete', '') }}" + "/" + id;
                            // console.log(url);

                            $.get(url, function(response) {
                                if (response == 'Deleted Successfully') {
                                    swal("Deleted!", "Your item has been deleted!", "success");
                                    // item.closest('.tr-row').remove();
                                    var dTable = $('#data-table').DataTable();
                                    dTable.draw();
                                    e.preventDefault();

                                } else {
                                    swal("Ops!", "Something went wrong. Your item hasn't been deleted!", "error");
                                }
                            });
                        } else {
                            swal("Cancelled", "Your item is safe :)", "error");
                        }
                    });
            }
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
            $(document).ready(function() {
                $(".deleteincident").click(function() {
                    alert("sfas");
                    if (!confirm("Do you want to delete")) {
                        return false;
                    }
                });
            });
        </script>
    @endsection
