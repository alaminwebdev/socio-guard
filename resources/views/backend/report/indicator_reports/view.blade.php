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

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: solid #aaa 1px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: rgb(153 14 80 / 70%);
            border: 1px solid #fff;
            color: #fff;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
        }
    </style>
    <div class="col-xl-12">
        <div class="breadcrumb-holder" style="padding:30px 25px 0 25px;">
            <h1 class="main-title float-left">Indicator Report</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home </li>
                <li class="breadcrumb-item active">Indicator Report</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header border-bottom-0 brac-header">
                    <h6 class="mb-0 text-white">Indicator Report</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('indicator.wise.report.process') }}" id="filterForm">
                        @csrf
                        <div class="form-row mb-3">
                            <div class="form-group col-md-12 border-bottom pb-3">
                                <label class="control-label">
                                    Indicator Report
                                </label>
                                {{-- <span>(
                                    <input type="checkbox" id="select_all_checkbox">
                                    <label for="select_all_checkbox" style="cursor: pointer">Select All</label>
                                    )
                                </span> --}}
                                <span class="text-danger">*</span>
                                <select name="report_types[]" id="report_types" class="form-control form-control-sm select2" multiple="multiple" required>
                                    @foreach ($indicator_reports as $id => $indicator_report)
                                        <option value="{{ $id }}" {{ in_array($id, $report_types) ? 'selected' : '' }}>{{ $indicator_report['reference'] . '. ' . $indicator_report['title'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Zone <span class="text-danger">*</span> </label>
                                <select name="region_id" id="region_id" class="region_id form-control form-control-sm select2">
                                    <option selected value="">All</option>
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
                            <div class="form-group col-md-3">
                                <label class="control-label">Upazila</label>
                                <select name="upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
                                    <option value="">Select All</option>
                                    @if (request()->upazila_id)
                                        <option value="{{ $upazila->id }}" selected>{{ $upazila->name }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label class="control-label">From Date <span class="text-danger">*</span></label>
                                <input type="text" id="from_date" name="from_date" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off" required value="{{ request()->from_date ? request()->from_date : '' }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">To Date <span class="text-danger">*</span></label>
                                <input type="text" id="to_date" name="to_date" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off" required value="{{ request()->to_date ? request()->to_date : '' }}">
                            </div>

                            <div class="form-group col-sm-2">
                                <label class="control-label" style="visibility: hidden;">Search</label>
                                <button type="submit" name="type" value="search" class="btn btn-success btn-sm btn-block">Search</button>
                            </div>
                        </div>
                    </form>
                    @include('backend.report.indicator_reports.table')
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

    {{-- <script>
        $(function() {
            $('.indicatordatepicker').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoUpdateInput: false,
                    autoApply: true,
                    locale: {
                        format: 'DD-MM-YYYY',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                        firstDay: 0
                    },
                    minDate: '01-01-2000',
                    maxDate: new Date(),
                },
                function(start) {
                    this.element.val(start.format('DD-MM-YYYY'));
                    this.element.parent().parent().removeClass('has-error');
                },
                function(chosen_date) {
                    this.element.val(chosen_date.format('DD-MM-YYYY'));
                });

            $('#from_date').on('apply.daterangepicker', function(ev, picker) {
                var fromDate = picker.startDate;
                var maxDate = fromDate.clone().add(6, 'months').subtract(1, 'days');
                var currentDate = moment();
                
                // Ensure maxDate doesn't exceed the current date
                if (maxDate.isAfter(currentDate)) {
                    maxDate = currentDate;
                }

                $('#to_date').val(maxDate.format('DD-MM-YYYY'));
                $('#to_date').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoUpdateInput: false,
                    autoApply: true,
                    locale: {
                        format: 'DD-MM-YYYY',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                        firstDay: 0
                    },
                    minDate: fromDate.toDate(),
                    maxDate: maxDate.toDate(),
                });
            });

            $('#to_date').on('apply.daterangepicker', function(ev, picker) {
                var fromDate = moment($('#from_date').val(), 'DD-MM-YYYY');
                var toDate = picker.startDate;
                var diff = toDate.diff(fromDate, 'days');

                if (diff > 180) { // 6 months = 180 days
                    var maxDate = fromDate.clone().add(6, 'months').subtract(1, 'days');
                    $(this).val(maxDate.format('DD-MM-YYYY'));
                    alert('Date range should not exceed 6 months.');
                } else {
                    $(this).val(picker.startDate.format('DD-MM-YYYY'));
                }
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#report_types').select2();

            // Listen for changes in the "Select All" checkbox
            $('#select_all_checkbox').on('change', function() {
                if ($(this).prop('checked')) {
                    // If checked, select all options
                    $('#report_types option').prop('selected', true);
                } else {
                    // If unchecked, unselect all options
                    $('#report_types option').prop('selected', false);
                }

                // Trigger the change event to update Select2
                $('#report_types').trigger('change');
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
        $(document).ready(function() {
            var processedReportTypes = [];
            var rowNumber = 1;
            var formData = null; 
            var processedData   = [];

            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                if (!formData) {
                    formData = $(this).serialize();
                    // Disable all form fields except for report_types and submit button
                    $(this).find('input[type!="submit"]').not('#report_types').prop('disabled', true);
                    $(this).find('select').not('#report_types').prop('disabled', true);
                } else {
                    formData = formData;
                }

                var reportTypes = $(this).find('select[name="report_types[]"]').val();

                processReports(formData, reportTypes);

            });

            function processReports(formData, reportTypes) {
                var index           = 0;
                var totalReports    = reportTypes.length;
                var percentage      = Math.round(( processedReportTypes.length / totalReports) * 100);
                
                $('#indicator-progress').css('width', percentage + '%').attr('aria-valuenow', percentage).text(percentage + '%');
                $('#indicator-loader-container').show();

                function processReportType() {
                    if (index < reportTypes.length) {
                        var reportType = reportTypes[index];

                        // Check if the report type is already processed
                        if (processedReportTypes.includes(reportType)) {
                            // processed, skip to the next report type
                            index++;
                            // processReportType();
                            setTimeout(processReportType, 1000);
                            return;
                        }

                        formData += '&report_type=' + reportType;

                        $.ajax({
                            url: "{{ route('indicator.wise.report.process') }}",
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {

                                renderDataInTable(response, rowNumber);
                                rowNumber++;

                                processedReportTypes.push(reportType);
                                processedData.push(response);

                                $.notify("One report processed successfully.", {
                                    globalPosition: 'top right',
                                    className: 'success'
                                });

                                // Process the next report type
                                index++;

                                // Update the progress bar
                                percentage = Math.round(( processedReportTypes.length / totalReports) * 100);
                                $('#indicator-progress').css('width', percentage + '%').attr('aria-valuenow', percentage).text(percentage + '%');
                                
                                // processReportType();
                                setTimeout(processReportType, 3000);
                            },
                            error: function(xhr, status, error) {
                                $.notify("An error occurred while processing the report. Please try again later.", {
                                    globalPosition: 'top right',
                                    className: 'error'
                                });
                                $('#indicator-loader-container').hide();
                            }
                        });
                    } else {
                        // All report types processed
                        $('#indicator-loader-container').hide();
                        $('#excel-button-container').show();
                    }
                }

                // Start processing report types
                processReportType();
            }

            function renderDataInTable(data, row) {
                // Check if indicator_span is greater than 1
                if (data['indicator_span'] > 1) {
                    // Generate HTML for the outcome info row
                    var outcomeRowHTML = `
                        <tr>
                            <td rowspan="${data['indicator_span']}">${row}</td>
                            <td>${data['data']['outcome_ref']}</td>
                            <td>${data['data']['outcome_title']}</td>
                            <td rowspan="${data['indicator_span']}">${data['data']['year']}</td>
                            <td rowspan="${data['indicator_span']}">${data['data']['from_date']} - ${data['data']['to_date']}</td>
                            <td class="text-center"></td>
                            <td class="text-center">${data['data']['percentage_in_outcome']}</td>
                            <td class="text-center" rowspan="${data['indicator_span']}">${data['data']['men']}</td>
                            <td class="text-center" rowspan="${data['indicator_span']}">${data['data']['women']}</td>
                            <td class="text-center" rowspan="${data['indicator_span']}">${data['data']['other_gender']}</td>
                            <td class="text-center" rowspan="${data['indicator_span']}">${data['data']['pwd_men']}</td>
                            <td class="text-center" rowspan="${data['indicator_span']}">${data['data']['pwd_women']}</td>
                            <td class="text-center" rowspan="${data['indicator_span']}">${data['data']['pwd_other_gender']}</td>
                        </tr>
                    `;
                    // Append the outcome info row to the table body
                    $('#table-body').append(outcomeRowHTML);

                    // Generate HTML for the output info row
                    var outputRowHTML = `
                        <tr>
                            <td>${data['data']['indicator_ref']}</td>
                            <td>${data['data']['indicator_title']}</td>
                            <td class="text-center">${data['data']['total']}</td>
                            <td class="text-center"></td>
                        </tr>
                    `;

                    // Append the output info row to the table body
                    $('#table-body').append(outputRowHTML);

                } else {
                    // Generate HTML for the normal row
                    var normalRowHTML = `
                        <tr>
                            <td>${row}</td>
                            <td>${data['data']['indicator_ref']}</td>
                            <td>${data['data']['indicator_title']}</td>
                            <td>${data['data']['year']}</td>
                            <td>${data['data']['from_date']} - ${data['data']['to_date']}</td>
                            <td class="text-center">${data['data']['total']}</td>
                            <td class="text-center">${data['data']['percentage_in_outcome']}</td>
                            <td class="text-center">${data['data']['men']}</td>
                            <td class="text-center">${data['data']['women']}</td>
                            <td class="text-center">${data['data']['other_gender']}</td>
                            <td class="text-center">${data['data']['pwd_men']}</td>
                            <td class="text-center">${data['data']['pwd_women']}</td>
                            <td class="text-center">${data['data']['pwd_other_gender']}</td>
                        </tr>
                    `;
                    // Append the normal row to the table body
                    $('#table-body').append(normalRowHTML);
                }
            }


            $('#generateExcelBtn').on('click', function() {
                // Check if processedData is not empty
                if (processedData.length > 0) {
                    var button = $(this);
                    var buttonText = $('#button-text');

                    button.prop('disabled', true);
                    buttonText.text('Processing...');

                    // Send processedData to the server to generate Excel
                    $.ajax({
                        url: "{{ route('indicator.wise.report.excel') }}",
                        type: 'POST',
                        data: { 
                            _token: '{{ csrf_token() }}',
                            processedData: processedData,
                            formData: formData
                        },
                        xhrFields: {
                            responseType: 'blob'
                        },
                        success: function(response, status, xhr) {
                            // Check if the request was successful
                            if (xhr.status === 200) {
                                // Create a blob URL for the Excel file
                                var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                                var url = window.URL.createObjectURL(blob);

                                // Create a temporary link element and trigger a click event to download the file
                                var a = document.createElement('a');
                                a.href = url;
                                a.download = 'indicator_reports.xlsx'; // Specify the file name
                                a.click();

                                // Release the blob URL
                                window.URL.revokeObjectURL(url);

                                // Re-enable the button and revert its text
                                button.prop('disabled', false);
                                buttonText.text('Excel');

                            } else {
                                console.error('Error: Unable to generate Excel file.');
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle error
                            console.error('Error: Unable to generate Excel file.');
                        }
                    });
                } else {
                    // If processedData is empty, notify the user
                    alert('No data available to generate Excel file.');
                }
            });


        });
    </script>
@endsection
