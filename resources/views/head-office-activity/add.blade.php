@extends('backend.layouts.app')
@section('content')
    <style>
        .select2-container--default .select2-results__option--highlighted[aria-selected],
        .select2-container--default .select2-results__option--highlighted[aria-selected]:hover {
            background-color: rgb(153 14 80 / 90%);
        }

        .select2-container--default .select2-results__option--selected {
            background-color: #f8f9fa;
        }

        .errormsg {
            font-weight: 600;
            font-size: 12px;
            margin-bottom: 0;
            color: #dc3545;
            padding-top: 3px;
        }
    </style>
    <div class="col-xl-12">
        <div class="breadcrumb-holder" style="padding:30px 25px 0 25px;">
            <h1 class="main-title float-left">Head Office Actitvity</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home </li>
                <li class="breadcrumb-item active">
                    {{ @$editData ? 'Edit Head Office Actitvity Event' : 'Add Head Office Actitvity Event' }}
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header border-bottom-0 brac-header">
                    <h6 class="mb-0 text-white">{{ @$editData ? 'Edit Head Office Actitvity Event' : 'Add Head Office Actitvity Event' }}</h6>
                </div>
                <div class="card-body">
                    <form action="{{ @$editData ? route('head.office.activity.update', @$editData->id) : route('head.office.activity.store') }}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <label class="control-label">HO Activity ID:</label>
                                <input value="{{ @$editData ?  @$editData->ho_activity_ref : @$ho_activity_ref }}" type="text" class="form-control form-control-sm" name="ho_activity_ref" id="ho_activity_ref" readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Creation Date:</label>
                                <input value="{{ @$editData ? date('d-m-Y', strtotime(@$editData->created_at)) : date('d-m-Y') }}" type="text" class="form-control form-control-sm" readonly>
                            </div>
                        </div>
                        <div class="form-row mb-3 border-bottom">
                            <div class="form-group col-md-5">
                                <label class="control-label">Event Type: <span class="text-danger">*</span></label>
                                <select name="ho_event_id" id="ho_event_id" class="form-control form-control-sm select2 ">
                                    <option value="">Select Event</option>
                                    @foreach ($ho_events as $ho_event)
                                        <option value="{{ $ho_event->id }}" @if (old('ho_event_id', @$editData->ho_event_id) == $ho_event->id) selected @endif>{{ $ho_event->name }}</option>
                                    @endforeach
                                </select>
                                @error('ho_event_id')
                                    <p class="errormsg">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">No. of Events/Person: <span class="text-danger">*</span></label>
                                <input type="number" class="form-control form-control-sm" name="no_of_event" value="{{ @$editData->no_of_event }}">
                                @error('no_of_event')
                                    <p class="errormsg">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Starting Date: <span class="text-danger">*</span></label>
                                <input type="text" name="start_date" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off" required="" value="{{ @$editData->starting_date ? date('d-m-Y', strtotime(@$editData->starting_date)) : '' }}">
                                @error('start_date')
                                    <p class="errormsg">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Ending Date: <span class="text-danger">*</span></label>
                                <input type="text" name="end_date" class="form-control form-control-sm singledatepicker" placeholder="DD-MM-YYYY" autocomplete="off" required="" value="{{ @$editData->ending_date ? date('d-m-Y', strtotime(@$editData->ending_date)) : '' }}">
                                @error('end_date')
                                    <p class="errormsg">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row mb-3 border-bottom">
                            <div class="form-group col-md-12">
                                <p class="mb-0" style="font-weight: 600;">Participants:</p>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys:</label>
                                <input value="{{ @$editData->participant_boys }}" type="number" class="form-control form-control-sm participant_input" name="participant_boys" id="participant_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls:</label>
                                <input value="{{ @$editData->participant_girls }}" type="number" class="form-control form-control-sm participant_input" name="participant_girls" id="participant_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Men:</label>
                                <input value="{{ @$editData->participant_men }}" type="number" class="form-control form-control-sm participant_input" name="participant_men" id="participant_men">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Women:</label>
                                <input value="{{ @$editData->participant_women }}" type="number" class="form-control form-control-sm participant_input" name="participant_women" id="participant_women">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender:</label>
                                <input value="{{ @$editData->participant_other_gender }}" type="number" class="form-control form-control-sm participant_input" name="participant_other_gender" id="participant_other_gender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total: <span class="text-danger">*</span></label>
                                <input value="" type="number" class="form-control form-control-sm" name="participant_total" id="participant_total" readonly>
                                @error('participant_total')
                                    <p class="errormsg">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <p class="mb-0" style="font-weight: 600;">Persons With Disabilities (PWD):</p>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Boys:</label>
                                <input value="{{ @$editData->participant_pwd_boys }}" type="number" class="form-control form-control-sm participant_pwd_input" name="participant_pwd_boys" id="participant_pwd_boys">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Girls:</label>
                                <input value="{{ @$editData->participant_pwd_girls }}" type="number" class="form-control form-control-sm participant_pwd_input" name="participant_pwd_girls" id="participant_pwd_girls">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Men:</label>
                                <input value="{{ @$editData->participant_pwd_men }}" type="number" class="form-control form-control-sm participant_pwd_input" name="participant_pwd_men" id="participant_pwd_men">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Women:</label>
                                <input value="{{ @$editData->participant_pwd_women }}" type="number" class="form-control form-control-sm participant_pwd_input" name="participant_pwd_women" id="participant_pwd_women">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Other Gender:</label>
                                <input value="{{ @$editData->participant_pwd_other_gender }}" type="number" class="form-control form-control-sm participant_pwd_input" name="participant_pwd_other_gender" id="participant_pwd_other_gender">
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">Total: <span class="text-danger">*</span></label>
                                <input value="" type="number" class="form-control form-control-sm" name="participant_pwd_total" id="participant_pwd_total" readonly>
                                @error('participant_pwd_total')
                                    <p class="errormsg">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="text-right">
                            <a href="{{ route('head.office.activity.index') }}" class="btn btn-sm btn-danger mr-1">Cancel</a>
                            <input type="submit" value="{{ @$editData ? 'Update' : 'Submit' }}" class="btn btn-sm btn-success" onClick="this.form.submit(); this.disabled=true; this.value='Sending…';">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Function to calculate total participants
            function calculateTotalParticipants() {
                var participant_boys = +$("#participant_boys").val() || 0;
                var participant_girls = +$("#participant_girls").val() || 0;
                var participant_men = +$("#participant_men").val() || 0;
                var participant_women = +$("#participant_women").val() || 0;
                var participant_other_gender = +$("#participant_other_gender").val() || 0;
                var total_participants = participant_boys + participant_girls + participant_men + participant_women + participant_other_gender;
                $("#participant_total").val(total_participants);
            }

            // Function to calculate total PWD participants
            function calculateTotalPWDParticipants() {
                var pwd_boys = +$("#participant_pwd_boys").val() || 0;
                var pwd_girls = +$("#participant_pwd_girls").val() || 0;
                var pwd_men = +$("#participant_pwd_men").val() || 0;
                var pwd_women = +$("#participant_pwd_women").val() || 0;
                var pwd_other_gender = +$("#participant_pwd_other_gender").val() || 0;
                var total_pwd = pwd_boys + pwd_girls + pwd_men + pwd_women + pwd_other_gender;
                $("#participant_pwd_total").val(total_pwd);
            }

            // Trigger calculation on keyup event of participant fields
            $(".participant_input").keyup(function() {
                calculateTotalParticipants();
            });

            $(".participant_pwd_input").keyup(function() {
                calculateTotalPWDParticipants();
            });

            // Trigger calculation on document ready if edit values are present
            if ("{{ @$editData->participant_total }}") {
                calculateTotalParticipants();
            }
            if ("{{ @$editData->participant_pwd_total }}") {
                calculateTotalPWDParticipants();
            }
        });
    </script>
@endsection
