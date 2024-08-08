@extends('backend.layouts.app')
@section('content')

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
                        <a class="btn btn-sm btn-success" href="{{ route('swapnosarothiprofile.create') }}">
                            <i class="fa fa-list"></i> Add Profile</a>
                    {{-- @endif --}}
                </div>

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
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                                    @endforeach
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
                            <div class="form-group col-sm-2 mb-0">
                                <button type="submit" class="btn btn-success btn-sm" style="color: white">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12 ">
            <div class="card border-0">
                <div class="card-header">

                    <a href="{{ route('swapnosarothiprofile.index') }}"><button type="submit"
                            class="btn btn-warning active" style="color: white"> <i class="fa fa-check-circle"
                                aria-hidden="true"></i> Draft
                            List</button></a>
                    <a href="{{ route('swapnosarothi.profile.pending.list') }}"><button type="submit"
                            class="btn btn-primary btn-sm" style="color: white">Pending
                            List</button></a>
                    <a href="{{ route('swapnosarothi.profile.approve.list') }}"><button type="submit"
                            class="btn btn-success btn-sm" style="color: white">Approved List</button></a>
                </div>
                <div class="card-body">
                    <table class="table-sm table-bordered table-striped dt-responsive nowrap" style="width: 100%"
                        id="data-table">
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
                    url: '{{ route('get.swapnosarothi.profile.list.datatable') }}',
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
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
                    },
                    {
                        data: 'profile_id',
                        name: 'profile_id'
                    },
                    {
                        data: 'group',
                        name: 'group'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'start_date',
                        name: 'start_date'
                    },

                    {
                        data: 'age',
                        name: 'age'
                    },

                    {
                        data: 'group_status',
                        name: 'group_status'
                    },
                    {
                        data:'employee_zone_id',
                        name:'employee_zone_id'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action_column',
                        name: 'action_column'
                    }
                ]
            });
            $('#filterForm').on('submit', function(e) {
                dTable.draw();
                e.preventDefault();
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
@endsection
