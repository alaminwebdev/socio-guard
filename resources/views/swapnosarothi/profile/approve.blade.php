@extends('backend.layouts.app')
@section('content')

    <style>
        div:where(.swal2-container) .swal2-html-container {
            overflow: hidden;
        }
    </style>
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Swapnosarothi Profile</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home </li>
                <li class="breadcrumb-item active"> Swapnosarothi Profile</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-md-12 mb-4">
            <div class="card border-0">
                <div class="card-header border-bottom-0 brac-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-white">Search Critieria</h6>
                    {{-- @if ($auth_user->user_role[0]['role_id'] == 5) --}}
                        <a class="btn btn-sm btn-success" href="{{ route('swapnosarothiprofile.create') }}"><i class="fa fa-list"></i> Add Profile</a>
                    {{-- @endif --}}
                </div>

                <div class="card-body">
                    <form method="get" action="" id="filterForm">
                        @csrf
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
                                <label class="control-label">Union</label>
                                <select name="union_id" id="union_id" class=" form-control form-control-sm">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Village</label>
                                <select name="village_id" id="village_id" class=" form-control form-control-sm">
                                    <option value="">Select Village</option>
                                </select>
                            </div>

                            {{-- <div class="form-group col-sm-2">
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
                            </div> --}}
                            <div class="form-group col-md-3">
                                <label class="control-label">Groups</label>
                                <select name="group" id="group_id" class="form-control form-control-sm">
                                    <option value="">Select Group</option>
                                    {{-- @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Profile Status</label>
                                <select name="group_status" id="group_status" class="form-control form-control-sm">
                                    <option value="">Select Status</option>
                                    <option value="ongoing">Ongoing</option>
                                    <option value="migrated">Migrated</option>
                                    <option value="droupout">Droup out</option>
                                    <option value="graduated">Graduated</option>
                                    <option value="married">Married</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Data Source</label>
                                <select name="data_source" id="data_source" class="form-control form-control-sm">
                                    <option value="current_zone">Current Zone</option>
                                    <option value="old_zone">Previous Zone</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4 mb-0">
                                <label class="control-label" style="visibility: hidden;" >Search</label>
                                <div>
                                    <button type="submit" name="type" value="search" class="btn btn-success btn-sm mr-1" style="box-shadow:rgba(23, 162, 184, 0.25) 0px 8px 18px 4px; min-width: auto;"><i class="fa fa-search mr-1"></i>Search</button>
                                    <button type="submit" name="type" value="excel" class="btn btn-sm btn-primary" style="box-shadow:rgba(13, 109, 253, 0.25) 0px 8px 18px 4px"><i class="fa fa-file-excel-o mr-1"></i>Download as Excel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="col-md-12 ">
            <div class="card border-0">
                <div class="card-header">
                    <a href="{{ route('swapnosarothiprofile.index') }}"><button type="submit" class="btn btn-sm btn-warning " style="color: white"> Draft List</button></a>
                    <a href="{{ route('swapnosarothi.profile.pending.list') }}"><button type="submit" class="btn btn-primary btn-sm" style="color: white">Pending List</button></a>
                    <a href="{{ route('swapnosarothi.profile.approve.list') }}"><button type="submit" class="btn btn-success active" style="color: white"><i class="fa fa-check-circle" aria-hidden="true"></i> Approved List</button></a>
                </div>
                <div class="card-body">
                    <table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%" id="data-table">
                        <thead>
                            <tr>
                                <th>Sl.</th>
                                <th>Profile ID</th>
                                <th>Group Name & Id</th>
                                <th>Name</th>
                                <th>Start Date</th>
                                <th>Age</th>
                                <th>Status</th>
                                <th>Zone</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- extra html -->


    <script>
        $(document).ready(function() {
            
            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route('get.swapnosarothi.profile.approve.list.datatable') }}',
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.region_id = $('select[name=region_id]').val();
                        d.division_id = $('select[name=division_id]').val();
                        d.district_id = $('select[name=district_id]').val();
                        d.upazila_id = $('select[name=upazila_id]').val();
                        d.start_date = $('input[name=from_date]').val();
                        d.end_date = $('input[name=to_date]').val();
                        d.group_id = $('select[name=group]').val();
                        d.group_status = $('select[name=group_status]').val();
                        d.union = $('select[name=union_id]').val();
                        d.village = $('select[name=village_id]').val();
                        d.data_source = $('select[name=data_source]').val();
                    }
                },
                lengthMenu: [25, 50, 100, 150],
                pageLength: 25,
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        searchable:false
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'group',
                        name: 'group',
                        searchable:false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        searchable:false
                    },
                    {
                        data: 'start_date',
                        name: 'start_date',
                        searchable:false
                    },

                    {
                        data: 'age',
                        name: 'age',
                        searchable:false
                    },
                    {
                        data: 'group_status',
                        name: 'group_status',
                        searchable:false
                    },
                    {
                        data: 'employee_zone_id',
                        name: 'employee_zone_id',
                        searchable:false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        searchable:false
                    },
                    {
                        data: 'action_column',
                        name: 'action_column',
                        searchable:false
                    }
                ]
            });

            $('#filterForm').on('submit', function(e) {
                //dTable.draw();
                e.preventDefault();

                // Check which button is clicked
                var buttonType = $(document.activeElement).val();

                if (buttonType === 'search') {
                    // Perform search action
                    dTable.draw();
                } else if (buttonType === 'excel') {
                    // Submit the form with POST method
                    $(this).attr('method', 'post');
                    $(this).attr('action', '{{ route('swapnosarothi.profile.list.generate') }}');
                    $(this).attr('target', '_blank');
                    this.submit();
                }
            });

            //delete action
            $(document).on('click', '.swapnosarothiprofileDelete', function(e) {
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
            $(document).on('change', '#upazila_id', function() {
                var upazila_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-union') }}",
                    type: "GET",
                    data: {
                        upazila_id: upazila_id
                    },
                    success: function(data) {
                        console.log(data);
                        var html = '<option value="">Select Union</option>';
                        $.each(data, function(key, v) {
                            if (v.setup_user_union == undefined) {
                                html += '<option value="' + v.id + '">' + v.name +
                                    '</option>';
                            } else {
                                html += '<option value="' + v.setup_user_union.id +
                                    '">' + v.setup_user_union.name + '</option>';
                            }
                        });
                        $('#union_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#union_id', function() {
                var union_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-village') }}",
                    type: "GET",
                    data: {
                        union_id: union_id
                    },
                    success: function(data) {
                        console.log(data);
                        var html = '<option value="">Select Village</option>';
                        $.each(data, function(key, v) {
                            html += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        });
                        $('#village_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#union_id', function() {
                var region_id = $('#region_id').val();
                var division_id = $('#division_id').val();
                var district_id = $('#district_id').val();
                var upazila_id  = $('#upazila_id').val();
                var union_id    = $(this).val();

                $.ajax({
                    url: "{{ route('default.get-swapnosarothi-groups') }}",
                    type: "GET",
                    data: {
                        region_id: region_id,
                        division_id: division_id,
                        district_id: district_id,
                        upazila_id: upazila_id,
                        union_id: union_id
                    },
                    success: function(data) {
                        console.log(data);
                        var html = `<option value="">Select Group</option>`;
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

    <script>
        $(document).on('click', '.changeProfileStatus', function() {
            var id = $(this).data('id');

            Swal.fire({
                title: "Change Profile Status",
                html: `
                    <div class="row">
                        <div class="col-lg-6">
                            <select name="group_status" id="swal_group_status" class="group_status form-control form-control-sm">
                                <option value="">Select Status</option>
                                <option value="migrated">Migrated</option>
                                <option value="droupout">Drop out</option>
                                <option value="graduated">Graduated</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <input type="date" id="swal_status_date" class="form-control form-control-sm" name="status_date">
                        </div>
                        <div class="col-lg-12 mt-4" id="swal_dropout_reason_container" style="display:none;">
                            <select name="dropout_reason" id="swal_dropout_reason" class="dropout_reason form-control form-control-sm">
                                <option value="">Select Dropout Reason</option>
                                @foreach ($dropout_reasons as $reason)
                                    <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-12 mt-4" id="swal_migrated_reason_container" style="display:none;">
                            <select name="migrated_reason" id="swal_migrated_reason" class="migrated_reason form-control form-control-sm">
                                <option value="">Select Migrated Reason</option>
                                @foreach ($migrated_reasons as $reason)
                                    <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                `,
                denyButtonText: `Don't change`,
                confirmButtonText: 'Change Status',
                focusConfirm: false,
                showLoaderOnConfirm: true,
                showDenyButton: true,
                preConfirm: () => {

                    // Get the values of form fields
                    var group_status = $('#swal_group_status').val();
                    var status_date = $('#swal_status_date').val();
                    var migrated_reason = '';
                    var dropout_reason = '';

                    if (group_status === 'migrated') {
                        migrated_reason = $('#swal_migrated_reason').val();
                    } else if (group_status === 'droupout') {
                        dropout_reason = $('#swal_dropout_reason').val();
                    }

                    if (!group_status || !status_date || (group_status === 'migrated' && !migrated_reason) || (group_status === 'droupout' && !dropout_reason)) {
                        Swal.showValidationMessage('Please fill in all required fields');
                        return false;
                    }

                    // Prepare data to be sent
                    var formData = {
                        id: id,
                        group_status: group_status,
                        status_date: status_date,
                        migrated_reason: migrated_reason,
                        dropout_reason: dropout_reason,
                    };

                    // Include CSRF token
                    formData['_token'] = '{{ csrf_token() }}';

                    // Send the form data to the controller via AJAX using POST method
                    return $.ajax({
                        url: '{{ route('swapnosarothi.profile.status.change') }}',
                        type: 'post',
                        data: formData
                    }).then(response => {
                        if (response.status == 'error') {
                            Swal.showValidationMessage(response.message);
                        } else {
                            return response;
                        }
                    });

                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Done!',
                        'Status Changed Successfully!.',
                        'success'
                    );
                    location.reload();
                } else if (result.isDenied) {
                    Swal.fire('Changes are not saved', '', 'info')
                }
            });

            $('#swal_group_status').change(function() {
                var selectedStatus = $(this).val();
                if (selectedStatus == 'droupout') {
                    $('#swal_dropout_reason_container').show();
                    $('#swal_migrated_reason_container').hide();
                } else if (selectedStatus == 'migrated') {
                    $('#swal_migrated_reason_container').show();
                    $('#swal_dropout_reason_container').hide();
                } else {
                    $('#swal_dropout_reason_container').hide();
                    $('#swal_migrated_reason_container').hide();
                }
            });
        });
    </script>

@endsection
