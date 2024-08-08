@extends('backend.layouts.app')
@section('content')
    <style>
        .table thead {
            /* background: #0b253a !important; */
        }

        .table thead tr th {
            /* color: #f8f9fa !important; */
            border-bottom-width: 1px;
            font-size: 12px;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table.table-bordered.dataTable th:last-child {
            border-right-width: 1px !important;
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
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Manage Head Office Activity</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home </li>
                <li class="breadcrumb-item active">Head Office Activity</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header border-bottom-0 brac-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-white">Head Office Activity List</h6>
                    <a class="btn btn-sm btn-success" href="{{ route('head.office.activity.add') }}"><i class="fa fa-plus-circle"></i> Add</a>
                </div>
                <div class="card-body">
                    <form method="get" action="" id="filterForm">
                        <div class="form-row border-bottom mb-4 pb-2">
                            <div class="form-group col-md-6">
                                <label class="control-label">Event Type: <span class="text-danger">*</span></label>
                                <select name="ho_event_id" id="ho_event_id" class="form-control form-control-sm select2 ">
                                    <option value="">Select Event</option>
                                    @foreach ($ho_events as $ho_event)
                                        <option value="{{ $ho_event->id }}">{{ $ho_event->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-sm-2">
                                <label class="control-label">From Date</label>
                                <input type="text" name="from_date" id="from_date" class="form-control form-control-sm singledatepicker" placeholder="From Date" autocomplete="off">
                            </div>

                            <div class="form-group col-sm-2">
                                <label class="control-label">To Date</label>
                                <input type="text" name="to_date" id="to_date" class="form-control form-control-sm singledatepicker" placeholder="To Date" autocomplete="off">
                            </div>


                            <div class="form-group col-sm-2">
                                <label class="control-label d-block" style="visibility: hidden;">Search</label>
                                <button type="submit" class="btn btn-success btn-sm" style="color: white">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="data-table">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" rowspan="2">SN.</th>
                                    <th class="text-center align-middle" rowspan="2">Event Name</th>
                                    <th class="text-center align-middle" rowspan="2">No.of Event/Person</th>
                                    <th class="text-center align-middle" rowspan="2">Date</th>
                                    <th class="text-center align-middle" colspan="6">Participants</th>
                                    <th class="text-center align-middle" colspan="6">Persons With Disabilities (PWD)</th>
                                    <th class="text-center align-middle" rowspan="2">Action</th>
                                </tr>
                                <tr>
                                    <th class="text-center align-middle">Boys</th>
                                    <th class="text-center align-middle">Girls</th>
                                    <th class="text-center align-middle">Men</th>
                                    <th class="text-center align-middle">Women</th>
                                    <th class="text-center align-middle">Other Gender</th>
                                    <th class="text-center align-middle">Total</th>

                                    <th class="text-center align-middle">Boys</th>
                                    <th class="text-center align-middle">Girls</th>
                                    <th class="text-center align-middle">Men</th>
                                    <th class="text-center align-middle">Women</th>
                                    <th class="text-center align-middle">Other Gender</th>
                                    <th class="text-center align-middle">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($ho_activity as $key => $item)
                                    <tr class="{{ $item->id }} tr-row">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ @$item->ho_event->name }}</td>
                                        <td>{{ @$item->no_of_event }}</td>
                                        <td>{{ @$item->ending_date }}</td>
                                        <td>{{ @$item->participant_boys }}</td>
                                        <td>{{ @$item->participant_girls }}</td>
                                        <td>{{ @$item->participant_men }}</td>
                                        <td>{{ @$item->participant_women }}</td>
                                        <td>{{ @$item->participant_other_gender }}</td>
                                        <td>{{ @$item->participant_total }}</td>

                                        <td>{{ @$item->participant_pwd_boys }}</td>
                                        <td>{{ @$item->participant_pwd_girls }}</td>
                                        <td>{{ @$item->participant_pwd_men }}</td>
                                        <td>{{ @$item->participant_pwd_women }}</td>
                                        <td>{{ @$item->participant_pwd_other_gender }}</td>
                                        <td>{{ @$item->participant_pwd_total }}</td>
                                        <td>
                                            <a class="btn btn-sm btn-success" title="Edit" href="{{ route('head.office.activity.edit', $item->id) }}"><i class="fa fa-edit"></i></a>
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: false,
                orderable: false,
                ajax: {
                    url: "{{ route('get.head.office.activity.list.datatable') }}",
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.ho_event_id = $('select[name=ho_event_id]').val();
                        d.start_date = $('input[name=from_date]').val();
                        d.end_date = $('input[name=to_date]').val();
                    }
                },
                lengthMenu: [10, 25, 50, 100, 150], // Set the default entries and available options
                pageLength: 10, // Set the default page length
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: false
                    },
                    {
                        data: 'ho_event',
                        name: 'ho_event'
                    },
                    {
                        data: 'no_of_event',
                        name: 'no_of_event',
                        searchable: false,
                    },
                    {
                        data: 'ending_date',
                        name: 'ending_date',
                        searchable: false,
                    },
                    {
                        data: 'participant_boys',
                        name: 'participant_boys',
                        searchable: false,
                    },
                    {
                        data: 'participant_girls',
                        name: 'participant_girls',
                        searchable: false,
                    },
                    {
                        data: 'participant_men',
                        name: 'participant_men',
                        searchable: false,
                    },
                    {
                        data: 'participant_women',
                        name: 'participant_women',
                        searchable: false,
                    },
                    {
                        data: 'participant_other_gender',
                        name: 'participant_other_gender',
                        searchable: false,
                    },
                    {
                        data: 'participant_total',
                        name: 'participant_total',
                        searchable: false,
                    },
                    {
                        data: 'participant_pwd_boys',
                        name: 'participant_pwd_boys',
                        searchable: false,
                    },
                    {
                        data: 'participant_pwd_girls',
                        name: 'participant_pwd_girls',
                        searchable: false,
                    },
                    {
                        data: 'participant_pwd_men',
                        name: 'participant_pwd_men',
                        searchable: false,
                    },
                    {
                        data: 'participant_pwd_women',
                        name: 'participant_pwd_women',
                        searchable: false,
                    },
                    {
                        data: 'participant_pwd_other_gender',
                        name: 'participant_pwd_other_gender',
                        searchable: false,
                    },
                    {
                        data: 'participant_pwd_total',
                        name: 'participant_pwd_total',
                        searchable: false,
                    },
                    {
                        data: 'action_column',
                        name: 'action_column',
                        searchable: false,
                    }
                ],
                // createdRow: function(row, data, dataIndex) {
                //     $('td:eq(6)', row).addClass('text-center');
                // }
            });
            $('#filterForm').on('submit', function(e) {
                dTable.draw();
                e.preventDefault();
            });

        });
    </script>
@endsection
