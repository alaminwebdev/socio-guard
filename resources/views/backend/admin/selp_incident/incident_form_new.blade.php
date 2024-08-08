@extends('backend.layouts.app')
@section('content')
    <style type="text/css">
        .mb-0>a {
            display: block;
            position: relative;
        }

        .mb-0>a:after {
            content: "\f078";
            /* fa-chevron-down */
            font-family: 'FontAwesome';
            position: absolute;
            right: 0;
        }

        .mb-0>a[aria-expanded="true"]:after {
            content: "\f077";
            /* fa-chevron-up */
        }


        /* .form-control-sm,
        .input-group-sm>.form-control,
        .input-group-sm>.input-group-append>.btn,
        .input-group-sm>.input-group-append>.input-group-text,
        .input-group-sm>.input-group-prepend>.btn,
        .input-group-sm>.input-group-prepend>.input-group-text {
            padding: 0.25rem 0.5rem;
            font-size: 11px;
            line-height: 1.5;
            border-radius: 0.2rem;
        } */

        .column_5_1 {
            max-width: 20% !important;
            flex: 20%;
        }
    </style>

    @php
        $tempIncidentId = \App\Model\SelpIncidentModel::count();
        // function formatIncidentId($id){
        // 	if($id<10){
        // 		return '00'.$id;
        // 	}
        
        // 	if($id<100){
        // 		return '0'.$id;
        // 	}
        
        // 	return $id;
        // }
    @endphp
    <div class="container-fluid">
        <div class="col-md-12" style="margin-top: 75px; margin-bottom:15px">
            <div class="card border-0">
                <div class="card-header border-bottom-0 brac-header d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 text-white">
                        VAWC and Legal Protection Form
                    </h6>
                    <a class="btn btn-sm btn-success" href="{{ route('incident.list') }}"><i class="fa fa-list"></i> Violence Incident List</a>
                </div>

                <div class="card-body">
                    <div class="form-row border-bottom  pb-3">
                        <div class="col-md-4" style="">
                            <label style="font-weight: bold;">Complaint ID:</label>
                            <input type="text" name="" value="{{ count($selpIncident) > 0 ? formatIncidentId($selpIncident[0]->id) : formatIncidentId($tempIncidentId + 1) }}"  class="form-control form-control-sm" readonly>
                            {{-- <p style="font-weight: bold;font-size: 13px;padding-left: 5px;">Complaint ID:
                                {{ count($selpIncident) > 0 ? formatIncidentId($selpIncident[0]->id) : formatIncidentId($tempIncidentId + 1) }}
                            </p> --}}
                        </div>

                        <div class="col-md-4" style="">
                            <label style="font-weight: bold;">Reporting Date:</label>
                            {{-- <p style="font-weight: bold;font-size: 13px;padding-left: 18px;padding-top: 7px;">Reporting Date:</p> --}}
                            @php
                                if (Session::has('edit_mode') && Session::get('edit_mode') && (count($selpIncident) > 0 && $selpIncident[0]->posting_date != null)) {
                                    $today = date('Y-m-d');
                                    $posting_today = $selpIncident[0]->posting_date;
                                    $date = date_diff(date_create($today), date_create($posting_today));
                                    $days = $date->format('%a');
                                }
                                
                            @endphp
                            <div class="">
                                {{-- <input type="text" name=""
                                    value="{{ count($selpIncident) > 0 && $selpIncident[0]->posting_date != null ? date('d-m-Y', strtotime($selpIncident[0]->posting_date)) : '' }}"
                                    id="posting_date"
                                    class="form-control form-control-sm {{ @$days >= 7 ? '' : 'postingdatepicker' }}"
                                    {{ request()->has('step') ? 'disabled' : '' }} readonly> --}}
                                @if (
                                    isset($user_info['user_role'][0]['role_id']) &&
                                    ($user_info['user_role'][0]['role_id'] == 1 || $user_info['user_role'][0]['role_id'] == 12) &&
                                    Session::has('edit_mode')
                                )
                                    <input type="date" id="posting_date"
                                        value="{{ count($selpIncident) > 0 && $selpIncident[0]->posting_date != null ? date('Y-m-d', strtotime($selpIncident[0]->posting_date)) : '' }}"
                                        class="form-control form-control-sm " {{ request()->has('step') ? 'disabled' : '' }}>
                                @else
                                    <input type="text" name=""
                                        value="{{ count($selpIncident) > 0 && $selpIncident[0]->posting_date != null ? date('d-m-Y', strtotime($selpIncident[0]->posting_date)) : '' }}"
                                        id="posting_date"
                                        class="form-control form-control-sm {{ @$days >= 7 ? '' : 'postingdatepicker' }}"
                                        {{ request()->has('step') ? 'disabled' : '' }} readonly>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4" style="">
                            <label style="font-weight: bold;">Creation Date:</label>
                            <input type="text" name="" value="{{count($selpIncident) > 0 && $selpIncident[0]->created_at != null ? date('d-m-Y', strtotime($selpIncident[0]->created_at)) : date('d-m-Y') }}"  class="form-control form-control-sm" readonly>
                        </div>
                        {{-- <div class="col-md-2">
                            <p style="font-weight: bold;font-size: 13px;padding-left: 5px;padding-top: 7px;">
                                {{ count($selpIncident) > 0 && $selpIncident[0]->created_at != null ? date('d-m-Y', strtotime($selpIncident[0]->created_at)) : date('d-m-Y') }}
                            </p>
                        </div> --}}
                    </div>
                    <ul class="nav nav-tabs mt-3 pb-3" id="custom-content-above-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link parent ptab1 {{ request()->tab == 1 || request()->tab == null ? 'active show' : '' }}"
                                id="data-entry" data-toggle="pill" href="#custom-content-above-home" role="tab"
                                aria-controls="custom-content-above-home" aria-selected="true">Data Insert By</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link parent ptab2 {{ request()->tab == 2 ? 'active show' : '' }}"
                                style="display: none;" id="section_A" data-toggle="pill" href="#custom-content-above-test"
                                role="tab" aria-controls="custom-content-above-profile" aria-selected="false">Section
                                A</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link parent ptab3  {{ request()->tab == 3 ? 'active show' : '' }}"
                                style="display: none;" id="section_B" data-toggle="pill"
                                href="#custom-content-above-messages" role="tab"
                                aria-controls="custom-content-above-messages" aria-selected="false">Section B</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="custom-content-above-tabContent">
                        <br>




                        @if (request()->step == 2)
                            @include('backend.admin.selp_incident.incident_form_step_2')
                        @elseif(request()->step == 3)
                            @include('backend.admin.selp_incident.incident_form_step_3')
                        @elseif(request()->step == 4)
                            @include('backend.admin.selp_incident.incident_form_step_4')
                        @elseif(request()->step == 5)
                            @include('backend.admin.selp_incident.incident_form_step_5')
                        @elseif(request()->step == 6)
                            @include('backend.admin.selp_incident.incident_form_step_6')
                        @else
                            @include('backend.admin.selp_incident.incident_form_step_1')
                        @endif



                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>



    <script>
        $(document).on("input", ".InputPhone", function() {
            this.value = this.value.replace(/\D/g, '');
        });
    </script>

    <script>
        $('#posting_date').change("input", function() {
            var dInput = this.value;
            console.log(dInput);
            $('#test').val(dInput);
        });
    </script>

    <!-- Start JS for Date time Picker -->
    <script type="text/javascript">
        $(function() {
            var date = new Date();
            @if (Session::has('edit_mode') &&
                    Session::get('edit_mode') &&
                    (count($selpIncident) > 0 && $selpIncident[0]->posting_date != null))
                var editDate = Math.floor(Math.abs((new Date()) - (new Date(
                    "{{ $selpIncident[0]->posting_date }}"))) / (1000 * 60 * 60 * 24));
                var rrr = new Date("{{ $selpIncident[0]->posting_date }}");
                // alert(new Date(rrr.setDate((rrr.getDate()+editDate))));
                var result = new Date("{{ $selpIncident[0]->posting_date }}") + editDate;
            @endif
            $('.postingdatepicker').daterangepicker({

                    // console.log(date);
                    singleDatePicker: true,
                    showDropdowns: true,
                    @if (
                        !(Session::has('edit_mode') && Session::get('edit_mode')) &&
                            (count($selpIncident) > 0 && $selpIncident[0]->posting_date != null))
                        autoUpdateInput: false,
                    @else
                        minDate: new Date(date.setDate(date.getDate() - 6)),
                        @if (Session::has('edit_mode') &&
                                Session::get('edit_mode') &&
                                (count($selpIncident) > 0 && $selpIncident[0]->posting_date != null))
                            // let diffTime = Math.abs(date2 - date1);
                            // let diffDays = (diffTime / (1000 * 60 * 60 * 24));
                            maxDate: new Date(rrr.setDate((rrr.getDate() + editDate))),
                            // maxDate :  new Date("{{ $selpIncident[0]->posting_date }}"),
                        @else
                            maxDate: new Date(),
                        @endif
                    @endif

                    // drops: "up",
                    autoApply: true,
                    locale: {
                        format: 'DD-MM-YYYY',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                        firstDay: 0
                    },
                    // minDate: new Date(date.setDate(date.getDate() - 30)),
                    // maxDate: new Date(),
                },
                function(start) {
                    this.element.val(start.format('DD-MM-YYYY'));
                    this.element.parent().parent().removeClass('has-error');
                },
                function(chosen_date) {
                    this.element.val(chosen_date.format('DD-MM-YYYY'));
                });

            $('.singledatepicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY'));
            });
        });
    </script>

    <!-- Start JS for Date time Picker -->
    <script type="text/javascript">
        $(function() {
            $('.datepicker').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoUpdateInput: false,
                    // @if (
                        !(Session::has('edit_mode') && Session::get('edit_mode')) &&
                            (count($selpIncident) > 0 && $selpIncident[0]->posting_date != null))
                    // @endif

                    // drops: "up",
                    autoApply: true,
                    locale: {
                        format: 'DD-MM-YYYY',
                        daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                        firstDay: 0
                    },
                    minDate: '01/01/2000',
                    maxDate: new Date(),
                },
                function(start) {
                    this.element.val(start.format('DD-MM-YYYY'));
                    this.element.parent().parent().removeClass('has-error');
                },
                function(chosen_date) {
                    this.element.val(chosen_date.format('DD-MM-YYYY'));
                });

            $('.singledatepicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY'));
            });
        });
    </script>

    <script>
        $(function() {
            $("input[name=same_person]:radio").click(function() {
                $("#applicant_survivor_info_container").show();
                if ($('input[name=same_person]:checked').val() == 1) {
                    // alert("radio1");
                    $(".survivor_info").show();
                    $(".defendant_info").show();
                    $(".initiative_taken").show();
                    $(".applicant_info").hide();

                } else if ($('input[name=same_person]:checked').val() == 2) {
                    $(".applicant_info").show();
                    $(".survivor_info").show();
                    $(".initiative_taken").show();
                    $(".defendant_info").show();

                }
            });
        });
    </script>

    <script>
        $(function() {
            $('.next').click(function() {

                //     var activeChild = $('.nav-item-sub > .active').data('child');
                //     $('.nav-item-sub > .active').modal('hide');
                //     $('.nav-item-sub > .active').parents('.fullbody').find('[data-child='+(activeChild+1)+']').trigger('click');
                // console.log(activeChild+1);
                // $('.child').each(function(index,element){
                //   var activeChild = $(this).hasClass('active');
                //   $(activeChild).parents()
                //     $('.child:last').trigger('click');
                // });



                // $('.nav-tabs > .nav-item > .active').parent().prev('li').find('a').trigger('click');


                // $('.parent:first').trigger('click');
                // $('.child:first').trigger('click');



                // var has_class_ptab1 = $('.ptab1').hasClass('active');
                // var has_class_ptab2 = $('.ptab2').hasClass('active');
                // var has_class_ptab3 = $('.ptab3').hasClass('active');
                // var has_class_p1ctab1 = $('.p1ctab1').hasClass('active');
                // var has_class_p1ctab2 = $('.p1ctab2').hasClass('active');
                // var has_class_p2ctab1 = $('.p2ctab1').hasClass('active');
                // var has_class_p2ctab2 = $('.p2ctab2').hasClass('active');
                // var has_class_p2ctab3 = $('.p2ctab3').hasClass('active');

                // if(has_class_ptab1){
                //   $('.ptab2').trigger('click');
                // }


                // if(has_class_ptab1 && has_class_p1ctab1){
                //   $('.p1ctab2').trigger('click');
                // }else if(has_class_ptab1 && has_class_p1ctab2){
                //   $('.ptab2').trigger('click');
                // }else{
                //   $('.p1ctab1').trigger('click');
                // }


                // if(has_class_ptab2 && has_class_p2ctab1){
                //   $('.p2ctab2').trigger('click');
                // }else if(has_class_ptab2 && has_class_p2ctab2){
                //   $('.p2ctab3').trigger('click');
                // }else if(has_class_ptab2 && has_class_p2ctab3){
                //   $('.ptab3').trigger('click');
                // }else{
                //   $('.p2ctab1').trigger('click');
                // }
            });
            $('.back').click(function() {
                // $('.nav-tabs > .nav-item > .active').parent().prev('li').find('a').trigger('click');
                // var has_class_ptab1 = $('.ptab1').hasClass('active');
                // var has_class_ptab2 = $('.ptab2').hasClass('active');
                // var has_class_ptab3 = $('.ptab3').hasClass('active');
                // var has_class_p2ctab1 = $('.p2ctAlternative Dispute Resolution (ADR)
                // if(has_class_ptab1){
                //   $('.ptab1').trigger('click');
                //   return true;
                // }else if(has_class_ptab3){
                //   $('.ptab2').trigger('click');
                //   $('.p2ctab3').trigger('click');
                //   return true;
                // }

                // if(has_class_ptab2 && has_class_p2ctab1){
                //   $('.ptab1').trigger('click');
                //   return true;
                // }else if(has_class_ptab2 && has_class_p2ctab2){
                //   $('.p2ctab1').trigger('click');
                //   return true;
                // }else if(has_class_ptab2 && has_class_p2ctab3){
                //   $('.p2ctab2').trigger('click');
                //   return true;
                // }else{
                //   $('.p2ctab1').trigger('click');
                //   return true;
                // }
            });


            // $('.parent:first').trigger('click');
            // $('.child:first').trigger('click');
        });


        $(document).ready(function() {
            $("#case_type").change(function() {
                var case_type = $("#case_type").val();
                if (case_type == 1) {
                    $(".civil").show();
                    $(".police").hide();
                    $(".petition").hide();
                } else if (case_type == 2) {
                    $(".civil").hide();
                    $(".police").show();
                    $(".petition").hide();
                } else if (case_type == 3) {
                    $(".civil").hide();
                    $(".police").hide();
                    $(".petition").show();
                } else {
                    $(".civil").hide();
                    $(".police").hide();
                    $(".petition").hide();
                }
            });
        });

        $(document).ready(function() {
            $("#selp_adr").change(function() {
                var selp_adr = $("#selp_adr").val();
                if (selp_adr == 7) {
                    $(".through_adr").show();
                } else {
                    $(".through_adr").hide();
                }
            });
        });

        $(document).ready(function() {
            $("#section_B").click(function() {
                $(".next").hide();
                $(".back").show();
                $(".submit").hide();
                $(".final").show();
            });
        });

        $(document).ready(function() {
            $("#section_A").click(function() {
                $(".back").show();
            });
        });

        $(document).ready(function() {
            $("#data-entry").click(function() {
                $(".back").hide();
            });
        });

        $(document).ready(function() {
            $("#initiatives").change(function() {
                var initiatives = $("#initiatives").val();
                if (initiatives == 1) {
                    $(".direct-support").show();
                    $(".if_direct_support").show();
                    $(".directsupport").show();
                    $(".referralsupport").hide();
                } else if (initiatives == 2) {
                    $(".directsupport").hide();
                    $(".referralsupport").show();
                    $(".direct-support").hide();
                    $(".if_direct_support").hide();
                } else {
                    $(".directsupport").hide();
                    $(".referralsupport").hide();
                    $(".direct-support").hide();
                    $(".if_direct_support").hide();
                }
            });
        });

        $(document).ready(function() {
            $(".if_money_recovered").change(function() {
                var if_money_recovered = $(".if_money_recovered").val();
                if (if_money_recovered == 1) {
                    $(".from_adr").show();
                    $(".no_benify").show();
                } else if (if_money_recovered == 2) {
                    $(".from_adr").hide();
                    $(".no_benify").hide();
                } else {
                    $(".from_adr").hide();
                    $(".no_benify").hide();
                }
            });
        });

        $(document).ready(function() {
            $("#initiative_taken").change(function() {
                var initiative_taken = $("#initiative_taken").val();
                if (initiative_taken == 1) {
                    $(".initiative_yes").show();
                } else if (initiative_taken == 2) {
                    $(".initiative_yes").hide();
                } else {
                    $(".initiative_yes").hide();
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $('.datetime').daterangepicker({
                singleDatePicker: true,
                timePicker: true,
                timePicker24Hour: false,
                timePickerIncrement: 5,
                autoApply: true,
                locale: {
                    format: 'H:mm'
                }
            }).on('show.daterangepicker', function(ev, picker) {
                picker.container.find('.calendar-table').hide();
            });
        });


        $(document).ready(function() {
            $('.test').select2();
        });
    </script>

    @if (@$editIncident)
        <script type="text/javascript">
            $(document).ready(function() {
                $('.removeeventmore:not(:first)').addClass('btn btn-danger fa fa-minus-circle ');
                $('.removeSupportEvent:not(:first)').addClass('btn btn-danger fa fa-minus-circle ');
                $('.removeOtherEvent:not(:first)').addClass('btn btn-danger fa fa-minus-circle ');
            });
        </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('change', '#case_status', function() {
                // alert('ok');
                var case_status = $(this).val();
                if (case_status == 'Yes') {
                    $('#add_yes_case_status').show();
                } else if (case_status == 'Under Process') {
                    $('#add_yes_case_status').hide();
                } else {
                    $('#add_yes_case_status').hide();
                }
                if (case_status == 'No') {
                    $('#add_no_case_status').show();
                } else {
                    $('#add_no_case_status').hide();
                }
            });
        });
    </script>

    {{-- Extra Others Field --}}
    <script type="text/javascript">
        $(document).ready(function() {
            //Source name
            $(document).on('change', '.provider_source_id', function() {
                var provider_source_id = $(this).val();
                if (provider_source_id == '0') {
                    $('.provider_other_source').show();
                } else {
                    $('.provider_other_source').hide();
                }
            });
            //Provider Other Gender
            $(document).on('change', '.provider_gender_id', function() {
                var provider_gender_id = $(this).val();
                if (provider_gender_id == '0') {
                    $('.provider_others_gender').show();
                } else {
                    $('.provider_others_gender').hide();
                }
            });
            //Provider Other Relationship
            $(document).on('change', '.provider_relationship_id', function() {
                var provider_relationship_id = $(this).val();
                if (provider_relationship_id == '0') {
                    $('.provider_other_relationship').show();
                } else {
                    $('.provider_other_relationship').hide();
                }
            });
            //Survivor Other Gender
            $(document).on('change', '.survivor_gender_id', function() {
                var survivor_gender_id = $(this).val();
                if (survivor_gender_id == '0') {
                    $('.survivor_others_gender').show();
                } else {
                    $('.survivor_others_gender').hide();
                }
            });
            //Survivor Other Religion
            $(document).on('change', '.survivor_religion_id', function() {
                var survivor_religion_id = $(this).val();
                if (survivor_religion_id == '0') {
                    $('.survivor_others_religion').show();
                } else {
                    $('.survivor_others_religion').hide();
                }
            });
            //Survivor Other Inicident Place
            $(document).on('change', '.survivor_incident_place_id', function() {
                var survivor_incident_place_id = $(this).val();
                if (survivor_incident_place_id == '0') {
                    $('.survivor_others_incident_place').show();
                } else {
                    $('.survivor_others_incident_place').hide();
                }
            });
            //Survivor Other Autistic
            $(document).on('change', '.survivor_autistic_id', function() {
                var survivor_autistic_id = $(this).val();
                if (survivor_autistic_id == '0') {
                    $('.survivor_others_autistic').show();
                } else {
                    $('.survivor_others_autistic').hide();
                }
            });
            //Perpetrator Other Gender
            $(document).on('change', '.perpetrator_gender_id', function() {
                var perpetrator_gender_id = $(this).val();
                if (perpetrator_gender_id == '0') {
                    $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_gender')
                        .show();
                } else {
                    $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_gender')
                        .hide();
                }
            });
            //Perpetrator Other Current Place
            $(document).on('change', '.perpetrator_current_place_id', function() {
                var perpetrator_current_place_id = $(this).val();
                if (perpetrator_current_place_id == '0') {
                    $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_place')
                        .show();
                } else {
                    $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_place')
                        .hide();
                }
            });
            //Perpetrator Other Relation
            $(document).on('change', '.perpetrator_relationship_id', function() {
                var perpetrator_relationship_id = $(this).val();
                if (perpetrator_relationship_id == '0') {
                    $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_relationship')
                        .show();
                } else {
                    $(this).closest('.delete_whole_extra_item_add').find('.perpetrator_others_relationship')
                        .hide();
                }
            });
            //Survivor Initial Support
            $(document).on('change', '.survivor_initial_support_id', function() {
                var survivor_initial_support_id = $(this).val();
                if (survivor_initial_support_id == '0') {
                    $('.survivor_initial_other_support').show();
                } else {
                    $('.survivor_initial_other_support').hide();
                }
            });
            //Survivor Situation
            $(document).on('change', '.survivor_situation_id', function() {
                var survivor_situation_id = $(this).val();
                if (survivor_situation_id == '0') {
                    $('.survivor_other_situation').show();
                } else {
                    $('.survivor_other_situation').hide();
                }
            });
            //Survivor Place
            $(document).on('change', '.survivor_place_id', function() {
                var survivor_place_id = $(this).val();
                if (survivor_place_id == '0') {
                    $('.survivor_other_place').show();
                } else {
                    $('.survivor_other_place').hide();
                }
            });
            //Family Member
            $(document).on('change', '.perpetrator_relationship_id', function() {
                var perpetrator_relationship_id = $(this).val();
                if (perpetrator_relationship_id == '1') {
                    $(this).closest('.delete_whole_extra_item_add').find(
                        '.add_perpetrator_family_member_id').show();
                } else {
                    $(this).closest('.delete_whole_extra_item_add').find(
                        '.add_perpetrator_family_member_id').hide();
                }
            });
            //Other Family Member
            $(document).on('change', '.perpetrator_family_member_id', function() {
                var perpetrator_family_member_id = $(this).val();
                if (perpetrator_family_member_id == '0') {
                    $(this).closest('.delete_whole_extra_item_add').find(
                        '.perpetrator_others_family_member').show();
                } else {
                    $(this).closest('.delete_whole_extra_item_add').find(
                        '.perpetrator_others_family_member').hide();
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            var perpetrator_relationship_id = "1";
            if (perpetrator_relationship_id) {
                $('.perpetrator_relationship_id').val(perpetrator_relationship_id).trigger('change');
            }
            $('#survivor_image').change(function(e) { //show Slider Image before upload
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>

    <!-- extra_add_perpetrator_item -->
    <script type="text/javascript">
        $(document).ready(function() {
            var counter = 0;

            $(document).on("click", ".addeventmore", function() {
                var whole_extra_item_add = $("#whole_extra_item_add").html();
                $(this).closest(".add_item").append(whole_extra_item_add);
                counter++;
            });

            $(document).on("click", ".removeeventmore", function(event) {
                $(this).closest(".delete_whole_extra_item_add").remove();
                counter -= 1
            });
        });
    </script>

    <!-- extra_add_brac_support_item -->
    <script type="text/javascript">
        $(document).ready(function() {
            var counter = 0;

            $(document).on("click", ".addSupportEvent", function() {
                var whole_extra_support_item_add = $("#whole_extra_support_item_add").html();
                $(this).closest(".add_support_item").append(whole_extra_support_item_add);
                counter++;
                $('.singledatepicker').daterangepicker({
                        singleDatePicker: true,
                        showDropdowns: false,
                        autoUpdateInput: false,
                        // drops: "up",
                        autoApply: true,
                        locale: {
                            format: 'YYYY-MM-SS',
                            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                            firstDay: 0
                        },
                        minDate: '01-01-1930',
                        // maxDate: new Date(),
                    },
                    function(start) {
                        this.element.val(start.format('DD-MM-YYYY'));
                        this.element.parent().parent().removeClass('has-error');
                    },
                    function(chosen_date) {
                        this.element.val(chosen_date.format('DD-MM-YYYY'));
                    });
            });

            $(document).on("click", ".removeSupportEvent", function(event) {
                $(this).closest(".delete_whole_extra_support_item_add").remove();
                counter -= 1
            });
        });
    </script>

    <!-- extra_add_other_support_item -->
    <script type="text/javascript">
        $(document).ready(function() {
            var counter = 0;

            $(document).on("click", ".addOtherEvent", function() {
                var whole_extra_other_support_item_add = $("#whole_extra_other_support_item_add").html();
                $(this).closest(".add_other_support_item").append(whole_extra_other_support_item_add);
                counter++;
            });

            $(document).on("click", ".removeOtherEvent", function(event) {
                $(this).closest(".delete_whole_extra_other_support_item_add").remove();
                counter -= 1
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('change', '.division_id', function() {
                var btnThis = $(this);
                var division_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-district') }}",
                    type: "GET",
                    data: {
                        division_id: division_id
                    },
                    success: function(data) {
                        var html = '<option value="">Select District</option>';
                        $.each(data[0], function(key, v) {
                            html += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        });
                        $(btnThis).parents('.parent_div').find('.district_id').html(html);

                        var html2 = '<option value="">Select City Corporation</option>';
                        $.each(data[1], function(key, v) {
                            html2 += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        });
                        $(btnThis).parents('.parent_div').find('.city_corporation_id').html(
                            html2);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('change', '.district_id', function() {
                var btnThis = $(this);
                var district_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-upazila') }}",
                    type: "GET",
                    data: {
                        district_id: district_id
                    },
                    success: function(data) {
                        var html = '<option value="">Select Upazila</option>';
                        $.each(data[0], function(key, v) {
                            html += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        });
                        $(btnThis).parents('.parent_div').find('.upazila_id').html(html);

                        var html2 = '<option value="">Select Pourosova</option>';
                        $.each(data[1], function(key, v) {
                            html2 += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        });
                        $(btnThis).parents('.parent_div').find('.pourosova_id').html(html2);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('change', '.upazila_id', function() {
                var btnThis = $(this);
                var upazila_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-union') }}",
                    type: "GET",
                    data: {
                        upazila_id: upazila_id
                    },
                    success: function(data) {
                        var html = '<option value="">Select Union</option>';
                        $.each(data, function(key, v) {
                            html += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        });
                        $(btnThis).parents('.parent_div').find('.union_id').html(html);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('change', '.organization_type_id', function() {
                var organization_type_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-organization-name') }}",
                    type: "GET",
                    data: {
                        organization_type_id: organization_type_id
                    },
                    success: function(data) {
                        var html = '<option value="">Select Organization Type</option>';
                        $.each(data, function(key, v) {
                            html += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        });
                        $('.organization_name_id').html(html);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('change', '.violence_category_id', function() {
                var violence_category_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-violence-sub-category') }}",
                    type: "GET",
                    data: {
                        violence_category_id: violence_category_id
                    },
                    success: function(data) {
                        var html = '<option value="">Select Violence Sub Category</option>';
                        $.each(data, function(key, v) {
                            html += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        });
                        $('.violence_sub_category_id').html(html);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('change', '.violence_sub_category_id', function() {
                var violence_sub_category_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-violence-name') }}",
                    type: "GET",
                    data: {
                        violence_sub_category_id: violence_sub_category_id
                    },
                    success: function(data) {
                        var html = '<option value="">Select Violence Name</option>';
                        $.each(data, function(key, v) {
                            html += '<option value="' + v.id + '">' + v.name +
                                '</option>';
                        });
                        $('.violence_name_id').html(html);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#informationSenderForm').validate({
                errorClass: 'text-danger',
                validClass: 'text-success',
                rules: {
                    'employee_name': {
                        required: true,
                    },
                    'employee_mobile_number': {
                        required: true,
                    },
                    'employee_designation': {
                        required: true,
                    },
                    'employee_pin': {
                        required: true,
                    },
                    'employee_division_id': {
                        required: true,
                    },
                    'employee_district_id': {
                        required: true,
                    },
                    // 'employee_upazila_id' : {
                    //     required : true,
                    // },
                    // 'employee_union_id' : {
                    //     required : true,
                    // },
                    // 'employee_village' : {
                    //     required : true,
                    // },
                    // 'employee_house' : {
                    //     required : true,
                    // },
                    // 'employee_road' : {
                    //     required : true,
                    // },
                },
                messages: {

                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#informationProviderForm').validate({
                errorClass: 'text-danger',
                validClass: 'text-success',
                rules: {
                    // 'provider_source_id' : {
                    //        required :function(){
                    //        	return $('#provider_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'provider_mobile_no' : {
                    //        required :function(){
                    //        	return $('#provider_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    // 'provider_organization_type_id' : {
                    //     required :function(){
                    //     	return $('#provider_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'provider_organization_name_id' : {
                    //     required :function(){
                    //     	return $('#provider_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'provider_gender_id' : {
                    //     required :function(){
                    //     	return $('#provider_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'provider_relationship_id' : {
                    //     required :function(){
                    //     	return $('#provider_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'provider_division_id' : {
                    //     required :function(){
                    //     	return $('#provider_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'provider_district_id' : {
                    //     required :function(){
                    //     	return $('#provider_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'provider_upazila_id' : {
                    //     required :function(){
                    //     	return $('#provider_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'provider_union_id' : {
                    //     required :function(){
                    //     	return $('#provider_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'provider_village' : {
                    //     required :function(){
                    //     	return $('#provider_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'provider_house' : {
                    //     required :function(){
                    //     	return $('#provider_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'provider_road' : {
                    //     required :function(){
                    //     	return $('#provider_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                },
                messages: {

                }
            });

        });
    </script>

    <script>
        $(document).ready(function() {
            $('#violenceIncidentForm').validate({
                errorClass: 'text-danger',
                validClass: 'text-success',
                rules: {
                    // 'violence_category_id' : {
                    //        required :function(){
                    //        	return $('#violence_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'violence_sub_category_id' : {
                    //        required :function(){
                    //        	return $('#violence_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'violence_name_id' : {
                    //        required :function(){
                    //        	return $('#violence_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'violence_date' : {
                    //        required :function(){
                    //        	return $('#violence_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'violence_time' : {
                    //        required :function(){
                    //        	return $('#violence_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'violence_incident_place_id' : {
                    //        required :function(){
                    //        	return $('#violence_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'violence_reason_id' : {
                    //        required :function(){
                    //        	return $('#violence_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'violence_reason_details' : {
                    //        required :function(){
                    //        	return $('#violence_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                },
                messages: {

                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#survivorInfoForm').validate({
                ignore: [],
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "survivor_organization_type_id[]") {
                        error.insertAfter(element.next());
                    } else {
                        error.insertAfter(element);
                    }
                },
                errorClass: 'text-danger',
                validClass: 'text-success',
                rules: {
                    // 'survivor_name' : {
                    //        required :function(){
                    //        	return $('#survivor_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'survivor_father_name' : {
                    //        required :function(){
                    //        	return $('#survivor_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'survivor_mother_name' : {
                    //        required :function(){
                    //        	return $('#survivor_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'survivor_mobile_no' : {
                    //        required :function(){
                    //        	return $('#survivor_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'survivor_gender_id' : {
                    //        required :function(){
                    //        	return $('#survivor_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'survivor_religion_id' : {
                    //        required :function(){
                    //        	return $('#survivor_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'survivor_marital_status_id' : {
                    //        required :function(){
                    //        	return $('#survivor_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'survivor_age' : {
                    //        required :function(){
                    //        	return $('#survivor_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    // 'survivor_monthly_income' : {
                    //     required :function(){
                    //     	return $('#survivor_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'survivor_occupation_id' : {
                    //     required :function(){
                    //     	return $('#survivor_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'survivor_organization_type_id[]' : {
                    //     required :function(){
                    //     	return $('#survivor_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'survivor_incident_place_id' : {
                    //     required :function(){
                    //     	return $('#survivor_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'survivor_autistic_id' : {
                    //     required :function(){
                    //     	return $('#survivor_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'survivor_division_id' : {
                    //     required :function(){
                    //     	return $('#survivor_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'survivor_district_id' : {
                    //     required :function(){
                    //     	return $('#survivor_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'survivor_upazila_id' : {
                    //     required :function(){
                    //     	return $('#survivor_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'survivor_union_id' : {
                    //     required :function(){
                    //     	return $('#survivor_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'survivor_village' : {
                    //     required :function(){
                    //     	return $('#survivor_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'survivor_house' : {
                    //     required :function(){
                    //     	return $('#survivor_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'survivor_road' : {
                    //     required :function(){
                    //     	return $('#survivor_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                },
                messages: {

                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#perpetratorInfoForm').validate({
                errorClass: 'text-danger',
                validClass: 'text-success',
                rules: {
                    // 'perpetrator_name[]' : {
                    //        required :function(){
                    //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'perpetrator_marital_status_id[]' : {
                    //        required :function(){
                    //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'perpetrator_gender_id[]' : {
                    //        required :function(){
                    //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'perpetrator_age[]' : {
                    //        required :function(){
                    //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'perpetrator_place_id[]' : {
                    //        required :function(){
                    //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'perpetrator_occupation_id[]' : {
                    //        required :function(){
                    //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'perpetrator_relationship_id[]' : {
                    //        required :function(){
                    //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'perpetrator_family_member_id[]' : {
                    //        required :function(){
                    //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'perpetrator_division_id[]' : {
                    //        required :function(){
                    //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'perpetrator_district_id[]' : {
                    //        required :function(){
                    //        	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    // 'perpetrator_upazila_id[]' : {
                    //     required :function(){
                    //     	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'perpetrator_union_id[]' : {
                    //     required :function(){
                    //     	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'perpetrator_village[]' : {
                    //     required :function(){
                    //     	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'perpetrator_house[]' : {
                    //     required :function(){
                    //     	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'perpetrator_road[]' : {
                    //     required :function(){
                    //     	return $('#perpetrator_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                },
                messages: {

                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#ligalInitiativeForm').validate({
                errorClass: 'text-danger',
                validClass: 'text-success',
                rules: {
                    // 'case_status' : {
                    //        required :function(){
                    //        	return $('#case_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'thana_name' : {
                    //        required :function(){
                    //        	return $('#case_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'court_name' : {
                    //        required :function(){
                    //        	return $('#case_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'not_filing_reason' : {
                    //        required :function(){
                    //        	return $('#case_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                },
                messages: {

                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#currentSituationForm').validate({
                errorClass: 'text-danger',
                validClass: 'text-success',
                rules: {
                    // 'survivor_initial_support_id' : {
                    //        required :function(){
                    //        	return $('#current_situation_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'survivor_situation_id' : {
                    //        required :function(){
                    //        	return $('#current_situation_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'survivor_place_id' : {
                    //        required :function(){
                    //        	return $('#current_situation_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                },
                messages: {

                }
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#survivorSupportForm').validate({
                errorClass: 'text-danger',
                validClass: 'text-success',
                rules: {
                    // 'survivor_support_date' : {
                    //        required :function(){
                    //        	return $('#survivor_support_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'survivor_final_support_id[]' : {
                    //        required :function(){
                    //        	return $('#survivor_support_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'brac_program_id[]' : {
                    //        required :function(){
                    //        	return $('#survivor_support_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    //    'brac_support_description' : {
                    //        required :function(){
                    //        	return $('#survivor_support_applicable_status').is(':not(:checked)');
                    //        },
                    //    },
                    // 'survivor_final_support_other_id[]' : {
                    //     required :function(){
                    //     	return $('#survivor_support_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'other_program[]' : {
                    //     required :function(){
                    //     	return $('#survivor_support_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                    // 'other_organization_support_description' : {
                    //     required :function(){
                    //     	return $('#survivor_support_applicable_status').is(':not(:checked)');
                    //     },
                    // },
                },
                messages: {

                }
            });

        });
    </script>
@endsection
