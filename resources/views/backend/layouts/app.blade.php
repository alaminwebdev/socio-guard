<!DOCTYPE html>
<html lang="en">

<head>
    <noscript>
        <img src="{{ asset('backend/images/noscript.gif') }}" width="400px" height="400px">
        <style>
            div {
                display: none;
            }
        </style>
    </noscript>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo session()->get('title') == null ? 'SELP' : 'SELP || ' . session()->get('title'); ?></title>
    <meta name="description" content="Bootstrap 4 Admin Theme">
    <meta name="author" content="S&S Development">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{ asset('backend/js/moment.min.js') }}"></script>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('backend/images/logo2.png') }}" type="image/x-icon" sizes="16x16" />

    <!-- Bootstrap CSS -->
    <link href="{{ asset('/backend/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/backend/css/bootstrap-toggle.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('/css/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css" />

    <!-- Font Awesome CSS -->
    <link href="{{ asset('/backend/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Custom CSS -->
    <link href="{{ asset('/backend/css/style.css') }}" rel="stylesheet" type="text/css" />

    <!-- sweet alert -->
    <link href="{{ asset('/backend/css/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <!-- sweet alert -->
    <!-- color picker -->
    <link href="{{ asset('/backend/css/colorpicker.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('css/bootstrap-multiselect.min.css') }}">
    <!-- font -->
    {{-- <link href="https://fonts.maateen.me/kalpurush/font.css" rel="stylesheet"> --}}

    <!-- font -->
    <!-- BEGIN CSS for this page -->
    <link rel="stylesheet" type="text/css" href="{{ asset('/backend/plugins/datatables/dataTables.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/backend/plugins/datatables/buttons.dataTables.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/backend/plugins/datatables/jquery.dataTables.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('/backend/plugins/datatables/responsive.bootstrap4.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" />

    {{-- Css for tree view --}}
    <link href="{{ asset('/backend/plugins/jstree/style.css') }}" rel="stylesheet" type="text/css" />
    <!-- END CSS for this page -->
    <link href="{{ asset('backend/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('/backend/plugins/datetimepicker/css/daterangepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('/backend/custom/bcsaa.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/plugins/jquery.filer/css/jquery.filer.css') }}" rel="stylesheet">

    <link href="{{ asset('/backend/css/datatable-custom.css') }}" rel="stylesheet" type="text/css"/>
    <!-- facing error in course name inspect element box -->
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css"> -->
    <script src="{{ asset('backend/js/jquery.min.js') }}"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
    <?php
    // if(Auth()->user()->usertype == '1'){
    //     $usertype = 'admin';
    // }else{
    //     $usertype = Auth()->user()->usertype;
    // }
    // $dashboardColors = DB::table('dashboard_colors')->where('usertype',$usertype)->first();
    ?>
    <style>
        .required,
        .error {
            color: red;
        }

        .navbarbgcode {
            background: {{ @$dashboardColors->navbarbgcode ? $dashboardColors->navbarbgcode : '#4980b5' }};
        }

        .navbartxtcode {
            color: #ffffff;
        }

        table thead {
            /*background-color: #4980B5 !important;*/
            background: {{ @$dashboardColors->tablebgcode ? $dashboardColors->tablebgcode : '#dc354514 ' }} !important;
        }

        table thead tr th {
            /*background-color: #4980B5 !important;*/
            color: {{ @$dashboardColors->tablebgcode ? $dashboardColors->tabletxtcode : '#000000' }} !important;
        }

        .brac-header, .tooltip-inner {
            background: rgb(153 14 80 / 90%);
        }

        .bs-tooltip-bottom .arrow::before,
        .bs-tooltip-auto[x-placement^="bottom"] .arrow::before {
            border-bottom-color: rgb(153 14 80 / 90%);
        }

        /*pre - loader*/

        #loader-wrapper {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1000;
        }

        #loader {
            display: block;
            position: relative;
            left: 50%;
            top: 50%;
            width: 150px;
            height: 150px;
            margin: -75px 0 0 -75px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #3498db;

            -webkit-animation: spin 2s linear infinite;
            animation: spin 2s linear infinite;
            z-index: 1001;
        }

        #loader:before {
            content: "";
            position: absolute;
            top: 5px;
            left: 5px;
            right: 5px;
            bottom: 5px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #e74c3c;

            -webkit-animation: spin 3s linear infinite;
            animation: spin 3s linear infinite;
        }

        #loader:after {
            content: "";
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border-radius: 50%;
            border: 3px solid transparent;
            border-top-color: #f9c922;

            -webkit-animation: spin 1.5s linear infinite;
            animation: spin 1.5s linear infinite;
        }

        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg);
                /* IE 9 */
                transform: rotate(0deg);
                /* Firefox 16+, IE 10+, Opera */
            }

            100% {
                -webkit-transform: rotate(360deg);
                /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg);
                /* IE 9 */
                transform: rotate(360deg);
                /* Firefox 16+, IE 10+, Opera */
            }
        }

        @keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
                /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(0deg);
                /* IE 9 */
                transform: rotate(0deg);
                /* Firefox 16+, IE 10+, Opera */
            }

            100% {
                -webkit-transform: rotate(360deg);
                /* Chrome, Opera 15+, Safari 3.1+ */
                -ms-transform: rotate(360deg);
                /* IE 9 */
                transform: rotate(360deg);
                /* Firefox 16+, IE 10+, Opera */
            }
        }

        #loader-wrapper .loader-section {
            position: fixed;
            top: 0;
            width: 50%;
            height: 100%;
            background: #00000087;
            z-index: 1000;
        }

        #loader-wrapper .loader-section.section-left {
            left: 0;
        }

        #loader-wrapper .loader-section.section-right {
            right: 0;
        }

        /* Loaded styles */
        .loaded #loader-wrapper .loader-section.section-left {
            -webkit-transform: translateX(-100%);
            -ms-transform: translateX(-100%);
            transform: translateX(-100%);

            -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
            transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
        }

        .loaded #loader-wrapper .loader-section.section-right {
            -webkit-transform: translateX(100%);
            /* Chrome, Opera 15+, Safari 3.1+ */
            -ms-transform: translateX(100%);
            /* IE 9 */
            transform: translateX(100%);
            /* Firefox 16+, IE 10+, Opera */

            -webkit-transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
            /* Android 2.1+, Chrome 1-25, iOS 3.2-6.1, Safari 3.2-6  */
            transition: all 0.7s 0.3s cubic-bezier(0.645, 0.045, 0.355, 1.000);
            /* Chrome 26, Firefox 16+, iOS 7+, IE 10+, Opera, Safari 6.1+  */
        }

        .loaded #loader {
            opacity: 0;

            -webkit-transition: all 0.3s ease-out;
            transition: all 0.3s ease-out;

        }

        .loaded #loader-wrapper {
            visibility: hidden;

            -webkit-transform: translateY(-100%);
            -ms-transform: translateY(-100%);
            transform: translateY(-100%);

            -webkit-transition: all 0.3s 1s ease-out;
            transition: all 0.3s 1s ease-out;
        }

        #content {
            margin: 0 auto;
            padding-bottom: 50px;
            width: 80%;
            max-width: 978px;
        }


        /*Hide tyep number arrow sign*/
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }


        input[type=number] {
            -moz-appearance: textfield;
        }

        /*pre-loader end*/

        /* #hideAll{
   position: fixed;
   left: 0px;
   right: 0px;
   top: 0px;
   bottom: 0px;
   background-color: ;
   z-index: 9999999999;
 } */

        /* submit form and preloader css  */

        .from_loader {
            position: fixed;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, .5);
            z-index: 999;
            display: none;
        }

        .wrapper {
            position: absolute;
            top: 50%;
            left: 50%;
        }

        .loader {
            height: 25px;
            width: 1px;
            position: absolute;
            animation: rotate 3.5s linear infinite;
        }

        .loader .dot {
            top: 30px;
            height: 7px;
            width: 7px;
            background: #990e59;
            border-radius: 50%;
            position: relative;
        }

        @keyframes rotate {
            30% {
                transform: rotate(220deg);
            }

            40% {
                transform: rotate(450deg);
                opacity: 1;
            }

            75% {
                transform: rotate(720deg);
                opacity: 1;
            }

            76% {
                opacity: 0;
            }

            100% {
                opacity: 0;
                transform: rotate(0deg);
            }
        }

        .loader:nth-child(1) {
            animation-delay: 0.15s;
        }

        .loader:nth-child(2) {
            animation-delay: 0.3s;
        }

        .loader:nth-child(3) {
            animation-delay: 0.45s;
        }

        .loader:nth-child(4) {
            animation-delay: 0.6s;
        }

        .loader:nth-child(5) {
            animation-delay: 0.75s;
        }

        .loader:nth-child(6) {
            animation-delay: 0.9s;
        }

        /* submit form and preloader css end */
    </style>
</head>

<body class="adminbody">
    <div style="display: none;" id="hideAll">&nbsp;</div>
    <script type="text/javascript">
        document.getElementById("hideAll").style.display = "block";
    </script>
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>

    {{-- form submit load this loader --}}
    <div class="from_loader">
        <div class="wrapper">
            <div class="loader">
                <div class="dot"></div>
            </div>
            <div class="loader">
                <div class="dot"></div>
            </div>
            <div class="loader">
                <div class="dot"></div>
            </div>
            <div class="loader">
                <div class="dot"></div>
            </div>
            <div class="loader">
                <div class="dot"></div>
            </div>
            <div class="loader">
                <div class="dot"></div>
            </div>
        </div>
    </div>
    {{-- form submit load this loader end --}}

    <div id="main">

        <!-- top bar navigation -->
        <div class="headerbar">
            <!-- LOGO -->
            <div class="headerbar-left navbarbgcode" style="background-color: #0b253a; box-shadow: 0 1px 48px rgb(0 0 0 / 76%);">
                <a href="{{ route('dashboard') }}" class="logo">
                    <img alt="Logo" src="{{ asset('backend/images/brac-logo.png') }}" /> <span>

                    </span>
                </a>
            </div>

            <nav class="navbar-custom navbarbgcode" style="background-color: #0b253a;">

                <ul class="list-inline float-right mb-0">
                    <li class="list-inline-item dropdown notif">
                        <!-- <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="fa fa-fw fa-bell-o"></i><span class="notif-bullet" id="has-notification-signal" style="display:none"></span>
                        </a> -->
                        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-lg" x-placement="bottom-end" style="position: absolute; transform: translate3d(-237px, 50px, 0px); top: 0px; left: 0px; will-change: transform; background: #64b0f2;">
                            <div id="notifications">

                            </div>
                            <!-- All-->
                            <a href="#" class="dropdown-item notify-item notify-all">
                                View All Alerts
                            </a>

                        </div>
                    </li>
                    <li class="list-inline-item">
                        <a class="navbartxtcode" href="#" style="color: #ffffff;">
                            {{ auth()->user()->name }} ({{ auth()->user()->pin }})
                            @foreach (loginUserRole()->user_role as $role)
                                @if (!empty($role->role_details))
                                    <label class="badge badge-success">{{ $role->role_details->name }}</label>
                                @endif
                            @endforeach
                            @php

                                $usertype = Auth()->user()->usertype;
                            @endphp
                        </a>
                    </li>

                    <li class="list-inline-item dropdown notif">
                        <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset('backend/images/avatars/admin.png') }}" alt="Profile image" class="avatar-rounded">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown" style="transform: translate3d(-240px, 5px, 0px);">
                            <!-- item-->
                            {{--   <div class="dropdown-item noti-title">
                                <h5 class="text-overflow"><small>Hello, admin</small> </h5>
                            </div> --}}

                            {{-- @php
                            $employee=App\Model\Admin\Employee\Employee::with(['academy_designation','department'])->where('user_id',auth()->user()->id)->first();
                                // echo'<pre>';  print_r($employee->toArray()); die;
                            @endphp

                            @if ($employee)
                            <!-- item-->
                            <a href="#" class="dropdown-item notify-item">
                                <i class="fa fa-info-circle"></i><span>Department: {{$employee->department['department_name_en']}}</span>
                            </a>
                            <a href="#" class="dropdown-item notify-item">
                                <i class="fa fa-info-circle"></i><span>Designation: {{$employee->academy_designation['designation_name_en']}}</span>
                            </a>



                            @endif --}}

                            <!-- item-->
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item notify-item">
                                <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                                <i class="fa fa-power-off"></i> <span>Logout</span>
                            </a>
                        </div>
                    </li>

                </ul>

                <ul class="list-inline menu-left mb-0">
                    <li class="float-left">
                        <button class="button-menu-mobile open-left">
                            <i class="fa fa-fw fa-bars" style="color: #ffffff;"></i>
                        </button>
                    </li>
                </ul>
            </nav>

        </div>
        <!-- End Navigation -->


        <!-- Left Sidebar -->
        @include('backend.layouts.navbar')
        <!-- End Sidebar -->


        <div class="content-page">
            @include('backend.layouts.notification')
            <!-- Start content -->
            <div class="content">

                @yield('content')
                <!-- END container-fluid -->

            </div>
            <!-- END content -->

        </div>
        <!-- END content-page -->

        <footer class="footer">
            <span class="text-left">
                &nbsp; Copyright <a target="_blank" href="#"><strong>{{ date('Y') }}</strong></a>
            </span>
            <span class="float-right">
                <a target="_blank" href="http://nanoit.biz"><b>Developed by Nanosoft </b></a>
            </span>
        </footer>

        {{-- delete confirmation Modal --}}
        <div class="modal fade custom-modal" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="customModal" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">You are about to delete</h5>
                    </div>
                    <div class="modal-body">
                        <p>Do you want to proceed?</p>
                    </div>
                    <div class="modal-footer">
                        <a id="yes_button" href="" class="btn btn-danger" style="padding:6px 35px">Yes</a>
                        <button type="button" class="btn btn-info" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END main -->

    <script src="{{ asset('backend/js/modernizr.min.js') }}"></script>

    <script src="{{ asset('backend/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap-toggle.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-tagsinput.js') }}"></script>
    <script src="{{ asset('backend/js/fastclick.js') }}"></script>
    <script src="{{ asset('backend/js/detect.js') }}"></script>

    <script src="{{ asset('backend/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.nicescroll.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('backend/js/pikeadmin.js') }}"></script>
    <script src="{{ asset('backend/js/colorpicker.js') }}"></script>

    <!-- BEGIN Java Script for this page -->

    <script src="{{ asset('backend/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="https://cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>
    <script src="{{ asset('backend/plugins/datetimepicker/js/moment.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datetimepicker/js/daterangepicker.js') }}"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.7/pagination/input.js"></script>

    <script src="{{ asset('backend/plugins/jquery.filer/js/tstjquery.filer.min.js') }}"></script>
    <script src="{{ asset('backend/plugins/datatables/vfs_fonts.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    // 'copyHtml5',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ]
            });
        });
    </script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="{{ asset('backend/js/validate.min.js') }}"></script>
    <script src="{{ asset('backend/js/additional-methods.js') }}"></script>
    <!-- sweet alert -->
    <script src="{{ asset('backend/js/sweetalert.js') }}"></script>
    <!-- sweet alert -->
    {{-- Js for tree view --}}
    <script src="{{ asset('backend/plugins/jstree/jstree.js') }}"></script>
    <!--Notify JS [ RECOMMENDED ]-->
    <script src="{{ asset('backend/js/notify.js') }}"></script>
    <!-- custom -->
    <script src="{{ asset('backend/custom/js.js') }}"></script>
    <!-- END Java Script for this page -->

    <!-- typeahead js -->
    <script src="{{ asset('backend/js/bootstrap3-typeahead.min.js') }}"></script>

    <script src="{{ asset('backend/custom/bcsaa.js') }}"></script>

    <!-- tooltip problem if jquery-ui on -->
    <!-- <script src="{{ asset('backend/plugins/jquery-ui/jquery-ui.js') }}"></script> -->
    <!-- Handle bar -->
    <script src="{{ asset('backend/js/handlebars-v4.0.12.js') }}"></script>
    <script src="{{ asset('js/bootstrap-multiselect.min.js') }}"></script>
    <!-- map -->
    {{-- <script src="{{asset('common')}}/plugins/gmapsjs/gmaps.js"></script> --}}
    <!-- tooltip -->
    <script>
        $(function() {
            $('#violence_multiple_select').multiselect({
                filterPlaceholder: 'Search',
                enableFiltering: true,

            });
        });
    </script>
    <script type="text/javascript">
        var duration = 5000,
            interval = 2000,
            xhrPending = false,
            intervalTimer;

        var notifications = [];

        const NOTIFICATION_TYPES = {
            user_registration: 'App\\Notifications\\UserRegistration',
            leave_application: 'App\\Notifications\\LeaveApplication',
            participant_leave_notification: 'App\\Notifications\\ParticipantLeaveNotification',
            dormitory_notification: 'App\\Notifications\\DormitoryNotification'
        };


        // show notification
        // $(document).ready(function() {
        //     intervalTimer = setInterval(function(){
        //         if(xhrPending) return;

        //         $.get('{{ route('notifications') }}', function (data) {
        //             addNotifications(data, "#notifications");
        //         }).done(function(){
        //             xhrPending = false;
        //         });
        //         xhrPending = true;
        //     }, interval);
        // });


        function addNotifications(newNotifications, target) {
            notifications = $.merge([], newNotifications);
            showNotifications(notifications, target);
        }

        function showNotifications(notifications, target) {
            if (notifications.length) {
                $('#has-notification-signal').show();
                var htmlElements = notifications.map(function(notification) {
                    return makeNotification(notification);
                });
                $(target).html(htmlElements.join(''));
            } else {
                $(target).html('<a href="#" class="dropdown-item notify-item"><p class="notify-details">No Notifications Available</p></a>');
                $('#has-notification-signal').hide();
            }
        }

        function makeNotification(notification) {
            var to = routeNotification(notification);
            var notificationText = makeNotificationText(notification);
            return '<a href="' + to + '" class="dropdown-item notify-item"><p class="notify-details">' + notificationText + '</p></a>';
        }

        //Here register route for every notification
        function routeNotification(notification) {
            var to = '?read=' + notification.id;
            if (notification.type === NOTIFICATION_TYPES.user_registration) {
                if (notification.data.user_type == 'admin') {
                    to = '{{ url('employee/approval') }}/' + notification.data.user_id + '' + to;
                } else if (notification.data.user_type == 'participant') {
                    to = '{{ url('training/participant/manage/participant') }}/' + to;
                } else if (notification.data.user_type == 'guestspeaker') {
                    to = '{{ url('training/speaker/guest/edit') }}/' + notification.data.user_id + '' + to;
                }
            }

            if (notification.type === NOTIFICATION_TYPES.leave_application) {
                to = notification.data.redirect_to + '/' + to;
            }

            if (notification.type === NOTIFICATION_TYPES.participant_leave_notification) {
                to = notification.data.redirect_to + '/' + to;
            }

            if (notification.type === NOTIFICATION_TYPES.dormitory_notification) {
                to = notification.data.redirect_to + '/' + to;
            }

            return to;
        }


        //Here register every new type of notification
        function makeNotificationText(notification) {
            var text = '';
            if (notification.type === NOTIFICATION_TYPES.user_registration) {
                const name = notification.data.user_name;
                text += '<strong>' + name + '</strong> make registration.';
            }

            if (notification.type === NOTIFICATION_TYPES.leave_application) {
                const name = notification.data.user_name;
                text += notification.data.message + '<strong> ' + name + '</strong> ';
            }

            if (notification.type === NOTIFICATION_TYPES.participant_leave_notification) {
                const name = notification.data.user_name;
                text += notification.data.message + '<strong> ' + name + '</strong> ';
            }

            if (notification.type === NOTIFICATION_TYPES.dormitory_notification) {
                const name = notification.data.name;
                text += notification.data.message + '<strong> ' + name + '</strong> ';
            }

            return text;
        }
    </script>

    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <!-- start Java Script for this page -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.select2').select2();

            $('button[type="reset"]').bind("click", function() {
                $("input[type=text], textarea").val("");
                $('.select2').val(null).trigger('change');
            });

            $('.numeric_only').keypress(function(e) {
                if (isNaN(this.value + "" + String.fromCharCode(e.charCode))) return false;
            }).on("cut copy paste", function(e) {
                e.preventDefault();
            });

            // $(".numeric_only").keypress(function (e) {
            //     if (String.fromCharCode(e.keyCode).match(/[^0-9//.]/g)) return false;
            // });
        });
    </script>
    <!-- END Java Script for dropdown select2 -->

    <script>
        $(document).on('click', '.delete', function(e) {
            e.preventDefault();
            var href = $(this).attr('href');
            $('#yes_button').attr('href', href);
            $('#deleteModal').modal('show');
        });
    </script>



    <script type="text/javascript">
        $(function() {
            $('.singledatepicker').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    autoUpdateInput: false,
                    // drops: "up",
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

            $('.singledatepicker').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY'));
            });
        });
    </script>
    <!-- End Java Script for Data time Picker -->

    <!-- Start Java Script for Data table -->
    <script type="text/javascript">
        $(document).ready(function() {
            $('.checkboxesTree').jstree({
                'core': {
                    'themes': {
                        'responsive': false
                    }
                },

                'types': {
                    'default': {
                        'icon': 'fa fa-file-text-o'
                    },
                    'file': {
                        'icon': 'fa fa-file-text'
                    }
                },

                'plugins': ['types', 'checkbox']
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatable').DataTable({
                pageLength: 25,
                ordering: false
            });

            $('#status').on('change', function() {
                $('#chkvalue').val(this.checked ? 1 : 0);
            });

        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) { //show Image before upload
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#show_image').attr('src', e.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $('input[name=status]').change(function() {
                var value = $('input[name=status]:checked').val();
            });
        })
    </script>

    <!-- preloader -->
    <script type="text/javascript">
        $(document).ready(function() {

            setTimeout(function() {
                $('#loader-wrapper').show();
                $('body').addClass('loaded');
            }, 300);

        });
    </script>
    <!-- preloader end -->
    <script type="text/javascript">
        $(document).ready(function() {
            $.validator.addMethod(
                "regex",
                function(value, element, regexp) {
                    var re = new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },
                "Please type in Bangla"
            );
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.validator.addMethod(
                "mobile",
                function(value, element, regexp) {
                    var re = new RegExp(regexp);
                    return this.optional(element) || re.test(value);
                },
                "Please enter your valid mobile number"
            );
        });
    </script>

    <!-- END Java Script for Data table -->

    @yield('page_script')
    <script type="text/javascript">
        window.onload = function() {
            document.getElementById("hideAll").style.display = "none";
        }

        //sajal

        // var submitBtn = $('button[type="submit"],input[type="submit"]');
        // submitBtn.on('click', function(){
        //    // alert($(this).val());
        //     // $(this).parents('form').submit(); 
        //     // $(this).prop('disabled', true); 
        //     // $(this).val('Saveing..');
        //     var zone = $(this).parents('form').find('#region_id');
        //     var division = $(this).parents('form').find('#division_id');
        //     var district = $(this).parents('form').find('#district_id');


        //     if(zone.val() != "" && division.val() != "" && district.val() != ""){

        //        $('.from_loader').css({"display": 'block'});
        //        $(this).parents('form').submit(); 
        //     }
        // });
    </script>
</body>

</html>
