@extends('backend.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="col-md-12 px-0" style="margin-top: 68px; margin-bottom:15px">
            <div class="card border-0">
                <div class="card-header border-bottom-0 brac-header">
                    <h6 class="mb-0 text-white">Add Money Support</h6>
                </div>
                <div class="card-body">
                    <div class="form-row border-bottom  pb-3">
                        <div class="col-md-3" style="">
                            <label style="font-weight: bold;">Complaint ID:</label>
                            <input type="text" name="" value="{{ formatIncidentId($selp_incident->id) }}" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="col-md-3">
                            <label style="font-weight: bold;">Reporting Date:</label>
                            <input type="text" name="" value="{{ $selp_incident->posting_date != null ? date('d-m-Y', strtotime($selp_incident->posting_date)) : '' }}" id="posting_date" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="col-md-3">
                            <label style="font-weight: bold;">Survivor Name</label>
                            <input type="text" name="" value="{{ $selp_incident->survivor_name }}" id="survivor_name" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="control-label">First initiative taken from SELP</label>
                            <select id="selp_initiative" class="form-control form-control-sm" disabled>
                                <option {{ $selp_incident->selp_initiative == 4 ? 'selected' : '' }} value="4"> Legal Advice </option>
                                <option {{ $selp_incident->selp_initiative == 1 ? 'selected' : '' }} value="1"> Referral </option>
                                <option {{ $selp_incident->selp_initiative == 3 ? 'selected' : '' }} value="3"> Violence Incident Documented </option>
                                <option {{ $selp_incident->selp_initiative == 2 ? 'selected' : '' }} value="2"> Complain Received </option>
                            </select>
                        </div>
                    </div>

                    {{-- Error Information --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 mx-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" id="moneySupportServiceForm" action="{{ route('incident.selp.money.support', $selp_incident->id) }}">
                        @csrf
                        <div class="money_support">
                            <!-- Loop through edit data if available -->
                            @if (isset($selp_incident->money_supports) && count($selp_incident->money_supports) > 0)
                                @foreach ($selp_incident->money_supports as $money_support)
                                    <div style="background:#17a2b80d;" class="row mt-3 mx-3 py-4 border rounded align-items-center">
                                        <input type="hidden" name="selp_incident_money_support_id[]" value="{{ $money_support->id }}">

                                        <div class="col-md-4">
                                            <label class="control-label d-block" style="font-size: 12px;">Amount of Money Received</label>
                                            <input type="number" name="amount_of_money_received[]" class="form-control form-control-sm" value="{{ $money_support->amount_of_money_received }}" @if (!in_array(1, auth()->user()->user_role->pluck('role_id')->toArray())) readonly @endif>
                                        </div>

                                        @if (in_array(1, auth()->user()->user_role->pluck('role_id')->toArray()) || in_array(12, auth()->user()->user_role->pluck('role_id')->toArray()))
                                            <div class="col-md-2">
                                                <label class="control-label d-block" style="font-size: 12px;">Date</label>
                                                <input type="date" name="money_receive_date[]" value="{{ $money_support->money_receive_date }}" class="form-control form-control-sm" max="{{ $money_support->money_receive_date }}">
                                            </div>
                                        @else
                                            <div class="col-md-4">
                                                <label class="control-label d-block" style="font-size: 12px;">Date</label>
                                                <input type="date" name="money_receive_date[]" value="{{ $money_support->money_receive_date }}" class="form-control form-control-sm" min="{{ \Carbon\Carbon::parse($money_support->money_receive_date)->subDays(7)->format('Y-m-d') }}" max="{{ $money_support->money_receive_date }}" @if (!in_array(1, auth()->user()->user_role->pluck('role_id')->toArray())) readonly @endif>
                                            </div>
                                        @endif

                                        <div class="col-md-4">
                                            <label class="control-label d-block" style="font-size: 12px; visibility:hidden;"> Button</label>
                                            @if ($loop->last)
                                                <i btn_type="add_service" class="fa fa-plus btn btn-success" onclick="serviceAdd(this);"></i>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end align-items-center">
                            <a href="{{ route('incident.except_complain_received.list') }}" class="btn btn-sm btn-primary mr-2" style="box-shadow:rgba(13, 109, 253, 0.25) 0px 8px 18px 4px; min-width:auto;">Back</a>
                            <button type="submit" class="btn btn-sm btn-success text-white" style="box-shadow: rgb(13 253 155 / 25%) 0px 8px 18px 4px; min-width:auto;">Save</button>
                        </div>
                    </form>

                    <!-- Template for new entries (outside the form) -->
                    <div id="template" style="background:#17a2b80d; display:none;" class="row mt-3 mx-3 py-4 border rounded align-items-center">
                        <input type="hidden" name="selp_incident_money_support_id[]" value="">

                        <div class="col-md-4">
                            <label class="control-label d-block" style="font-size: 12px;">Amount of Money Received</label>
                            <input type="number" name="amount_of_money_received[]" class="form-control form-control-sm">
                        </div>

                        @if (in_array(1, auth()->user()->user_role->pluck('role_id')->toArray()) || in_array(12, auth()->user()->user_role->pluck('role_id')->toArray()))
                            <div class="col-md-2">
                                <label class="control-label d-block" style="font-size: 12px;">Date</label>
                                <input type="date" name="money_receive_date[]" class="form-control form-control-sm" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        @else
                            <div class="col-md-4">
                                <label class="control-label d-block" style="font-size: 12px;">Date</label>
                                <input type="date" name="money_receive_date[]" class="form-control form-control-sm" min="{{ \Carbon\Carbon::now()->subDays(7)->format('Y-m-d') }}" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        @endif

                        <div class="col-md-4">
                            <label class="control-label d-block" style="font-size: 12px; visibility:hidden;"> Date</label>
                            <i style="" btn_type="add_service" class="fa fa-plus btn btn-success" onclick="serviceAdd(this);"></i>
                            <i style="" btn_type="rm_service" class="fa fa-minus btn btn-danger btn-remove" onclick="serviceRemove(this);"></i>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Add form submission handler
            document.getElementById('directServiceForm').addEventListener('submit', (e) => {
                const saveButton = e.submitter;
                saveButton.disabled = true;
                if (!validateForm()) {
                    e.preventDefault(); // Prevent form submission
                    saveButton.disabled = false;
                } else {
                    saveButton.disabled = true;
                    saveButton.innerHTML = 'Sending…';
                }
            });
        });
    </script>

    <script>
        function validateForm() {
            let isValid = true;

            const mrta_selects = document.querySelectorAll('select[name="money_recovered_through_adr[]"]');
            for (let i = 0; i < mrta_selects.length; i++) {
                const mrta_select = mrta_selects[i];
                if (!mrta_select.value) {
                    alert("Please fill out all purpose of dispute fields.");
                    mrta_select.focus();
                    isValid = false;
                    return false; // Exit the function immediately
                }

                // Get the parent div of the current select element
                const parentDiv = mrta_select.closest('.row');

                // Find the corresponding adr_select field within the same parent div
                const adr_select = parentDiv.querySelector('select[name="selp_alternative_dispute_resolution[]"]');

                // Find the corresponding amount_of_money_received field within the same parent div
                const amountInput = parentDiv.querySelector('input[name="amount_of_money_received[]"]');

                // Find the corresponding no_of_adr_participants_benefited field within the same parent div
                const participantsInput = parentDiv.querySelector('input[name="no_of_adr_participants_benefited[]"]');

                // Find the corresponding closing_date field within the same parent div
                const closingDateInput = parentDiv.querySelector('input[name="selp_support_closing_date[]"]');

                // Get the value of the adr_select field
                const adrValue = adr_select.value;


            }
            return isValid;
        }
    </script> --}}

    <script>
        function serviceAdd(button) {
            // Clone the template
            var template = $('#template').clone().removeAttr('id').removeAttr('style');
            // Append the cloned template to the form
            $('.money_support').append(template);
        }

        function serviceRemove(button) {
            // Remove the row
            $(button).closest('.row').remove();
        }

        $(document).ready(function() {
            // If no edit data, add one initial entry
            @if (!isset($selp_incident->money_supports) || count($selp_incident->money_supports) == 0)
                serviceAdd($('.money_support'));
            @endif
        });
    </script>
@endsection
