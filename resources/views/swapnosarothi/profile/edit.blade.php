@extends('backend.layouts.app')
@section('content')
    <div class="col-xl-12">
        <div class="breadcrumb-holder">
            <h1 class="main-title float-left">Swapnosarothi Profile Edit</h1>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item">Home </li>
                <li class="breadcrumb-item active"> Swapnosarothi Profile Edit</li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card border-0">
                <div class="card-header">
                    <h5>
                        <a class="btn btn-sm btn-success float-right" href="{{ route('swapnosarothiprofile.index') }}"><i class="fa fa-list"></i> Profile List</a>
                    </h5>
                </div>
                <!-- Form Start-->
                @include('swapnosarothi.profile.form')
                <!--Form End-->
            </div>
        </div>
    </div>
    <!-- extra html -->

    {{-- <script>
        $(function() {
            $('#group_status').on('change', function() {
                var group_status = $(this).val();
                var status_date = $('#status_date');
                var reason = $('#reason');
                if (group_status == "ongoing") {
                    status_date.html('');
                    status_date.html(`<input type="hidden" class="form-control form-control-sm" value=""  name="status_date" required>`);

                    reason.html('');
                    reason.html(`<input type="hidden" class="form-control form-control-sm" value=""  name="reason"> `);

                } else if (group_status == "droupout" || group_status == "migrated") {
                    status_date.html('');
                    status_date.html(`<label class="control-label">Date <span class="text-danger">*</span> </label>
                    <input type="date" class="form-control form-control-sm"  name="status_date">
                    @error('status_date')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror`);

                    reason.html('');
                    reason.html(` <label class="control-label">Reason</label>
                    <input type="text" class="form-control form-control-sm"  name="reason">
                    @error('reason')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror`);
                } else if (group_status == "graduated") {
                    status_date.html('');
                    status_date.html(`<label class="control-label">Date <span class="text-danger">*</span> </label>
                    <input type="date" class="form-control form-control-sm"  name="status_date">
                    @error('status_date')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror`);

                    reason.html('');
                    reason.html(`<input type="hidden" class="form-control form-control-sm" value=""  name="reason"> `);
                } else {
                    status_date.html('');
                    status_date.html(`<input type="hidden" class="form-control form-control-sm" value=""  name="status_date" required>`);

                    reason.html('');
                    reason.html(`<input type="hidden" class="form-control form-control-sm" value=""  name="reason"> `);
                }

            });
        });
    </script> --}}

	<script>
        $(function() {
			$('#group_status').on('change', function() {
                var group_status = $(this).val();
                var status_date = $('#status_date');
                var reason = $('#reason');
                if (group_status == "ongoing") {
                    status_date.html('');
                    status_date.html(`<input type="hidden" class="form-control form-control-sm" value=""  name="status_date" required>`);

                    reason.html('');
                    reason.html(`<input type="hidden" class="form-control form-control-sm" value=""  name="reason_id"> `);

                } else if (group_status == "droupout") {
                    status_date.html('');
                    status_date.html(`<label class="control-label">Date <span class="text-danger">*</span> </label>
                    <input type="date" class="form-control form-control-sm"  name="status_date">
                    @error('status_date')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror`);

                    reason.html('');
                    reason.html(`<label class="control-label">Dropout Reason <span class="text-danger">*</span></label>
					<select name="reason_id" id="" class="dropout_reason form-control form-control-sm" required>
                        <option value="">Select Dropout Reason</option>
                        @foreach ($dropout_reasons as $reason)
                            <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                        @endforeach
                    </select>
                    @error('reason_id')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror`);
                } else if (group_status == "migrated") {
					status_date.html('');
                    status_date.html(`<label class="control-label">Date <span class="text-danger">*</span> </label>
                    <input type="date" class="form-control form-control-sm"  name="status_date">
                    @error('status_date')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror`);

                    reason.html('');
                    reason.html(`<label class="control-label">Migrated Reason <span class="text-danger">*</span></label>
					<select name="reason_id" id="" class="migrated_reason form-control form-control-sm" required>
                        <option value="">Select Migrated Reason</option>
                        @foreach ($migrated_reasons as $reason)
                            <option value="{{ $reason->id }}">{{ $reason->name }}</option>
                         @endforeach
                    </select>
                    @error('reason_id')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror`);
				} else if (group_status == "graduated") {
                    status_date.html('');
                    status_date.html(`<label class="control-label">Date <span class="text-danger">*</span> </label>
                    <input type="date" class="form-control form-control-sm"  name="status_date">
                    @error('status_date')
                        <p class="text-danger pb-0">{{ $message }}</p>
                    @enderror`);

                    reason.html('');
                    reason.html(`<input type="hidden" class="form-control form-control-sm" value=""  name="reason_id"> `);
                } else {
                    status_date.html('');
                    status_date.html(`<input type="hidden" class="form-control form-control-sm" value=""  name="status_date" required>`);

                    reason.html('');
                    reason.html(`<input type="hidden" class="form-control form-control-sm" value=""  name="reason_id"> `);
                }

            });
        });
    </script>
@endsection
