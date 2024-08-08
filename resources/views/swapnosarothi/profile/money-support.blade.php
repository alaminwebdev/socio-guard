@extends('backend.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="col-md-12 px-0" style="margin-top: 68px; margin-bottom:15px">
            <div class="card border-0">
                <div class="card-header border-bottom-0 brac-header">
                    <h6 class="mb-0 text-white">Add Swapnosarothi Girls Money Support</h6>
                </div>
                <div class="card-body">
                    <div class="form-row border-bottom  pb-3">
                        <div class="col-md-3" style="">
                            <label style="font-weight: bold;">Profile ID:</label>
                            <input type="text" name="" value="{{ $swapnosarothi_profile->id }}" class="form-control form-control-sm" readonly>
                        </div>

                        <div class="col-md-3">
                            <label style="font-weight: bold;">Name:</label>
                            <input type="text" name="" value="{{ $swapnosarothi_profile->name }}" id="posting_date" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="col-md-3">
                            <label style="font-weight: bold;">Fathers Name:</label>
                            <input type="text" name="" value="{{ $swapnosarothi_profile->fathers_name }}" id="fathers_name" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="col-md-3">
                            <label style="font-weight: bold;">Mothers Name:</label>
                            <input type="text" name="" value="{{ $swapnosarothi_profile->mothers_name }}" id="mothers_name" class="form-control form-control-sm" readonly>
                        </div>
                        <div class="col-md-3 mt-3">
                            <label style="font-weight: bold;">Group:</label>
                            <input type="text" name="" value="{{ $swapnosarothi_profile->groupName->group_name }}" id="group_name" class="form-control form-control-sm" readonly>
                        </div>
                    </div>

                    {{-- Error Information --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3 mx-3">
                            <ul class="mb-0" style="padding-left: 15px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" id="moneySupportServiceForm" action="{{ route('swapnosarothi.profile.money.support', $swapnosarothi_profile->id) }}">
                        @csrf
                        <div class="money_support">
                            <!-- Loop through edit data if available -->
                            @if (isset($swapnosarothi_profile->money_supports) && count($swapnosarothi_profile->money_supports) > 0)
                                @foreach ($swapnosarothi_profile->money_supports as $money_support)
                                    <div style="background:#17a2b80d;" class="row mt-3 mx-3 py-4 border rounded align-items-center">
                                        <input type="hidden" name="swapnosarothi_profile_money_support_id[]" value="{{ $money_support->id }}">

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
                            <a href="{{ route('swapnosarothi.profile.approve.list') }}" class="btn btn-sm btn-primary mr-2" style="box-shadow:rgba(13, 109, 253, 0.25) 0px 8px 18px 4px; min-width:auto;">Back</a>
                            <button type="submit" class="btn btn-sm btn-success text-white" style="box-shadow: rgb(13 253 155 / 25%) 0px 8px 18px 4px; min-width:auto;">Save</button>
                        </div>
                    </form>

                    <!-- Template for new entries (outside the form) -->
                    <div id="template" style="background:#17a2b80d; display:none;" class="row mt-3 mx-3 py-4 border rounded align-items-center">
                        <input type="hidden" name="swapnosarothi_profile_money_support_id[]" value="">

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
            @if (!isset($swapnosarothi_profile->money_supports) || count($swapnosarothi_profile->money_supports) == 0)
                serviceAdd($('.money_support'));
            @endif
        });
    </script>
@endsection
