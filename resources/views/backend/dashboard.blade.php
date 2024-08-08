@extends('backend.layouts.app')
@section('content')
    <style>
        body {
            background-color: #fff;
        }
        .bg-light {
            background-color: #007bff0d !important;
        }
        .small-box>.inner {
            padding: 10px;
            color: white;
        }

        .small-box {
            margin-bottom: 10px;
            padding-bottom: 20px;
        }

        .bg-info {
            background-color: #3db9dc !important;
        }

        .bg-warning {
            background-color: #f1b53d !important;
        }

        .bg-success {
            background-color: #1bb99a !important;
        }

        .bg-danger {
            background-color: #ff5d48 !important;
        }

        .small-box .icon {
            color: rgba(0, 0, 0, .15);
            z-index: 0;
        }

        .small-box .icon>i {
            font-size: 90px;
            position: absolute;
            right: 15px;
            top: 15px;
            transition: all .3s linear;
        }

        .card-padding {
            padding: 2px;
             !important;
        }

        .card-footer-padding {
            padding: 10px 4px;
             !important;
        }

        .btn-custom {
            background-color: #a1a0a0 !important;
            border-color: #a1a0a0 !important;
            padding: 0;
            width: 63px;
        }

        .card-image {
            width: 100%;
            height: 100px;
        }

        .modal-backdrop {
            z-index: 999;
        }

        .modal {
            z-index: 1000;
        }

        #chartdiv {
            width: 100%;
            height: 650px;
        }

        #chartdiv2 {
            width: 100%;
            height: 450px;
        }

        #chartdiv3 {
            width: 100%;
            height: 300px;
        }

        #chartdiv4 {
            width: 100%;
            height: 330px;
        }

        #chartdiv5 {
            width: 100%;
            height: 300px;
        }

        #chartdiv6 {
            width: 100%;
            height: 300px;
        }

        #chartdiv7 {
            width: 100%;
            height: 300px;
        }
    </style>

    <div class="container-fluid" style="margin-top: 70px;">
        <div class="">
            <div class="">
                <div class="row align-items-center">
                    {{-- First --}}
                    <div class="col-md-4">
                        <div class="card bg-light mb-3  border-0 shadow">
                            <div class="card-body card-padding">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center p-3"><img
                                            src="{{ asset('images/vawc-incident-icn.svg') }}" class="card-image"
                                            alt="Filter icon"></div>
                                    <div class="col-md-8 text-center">
                                        <h2 id="incidentData">{{ $allFemaleIncidentData }}</h2>
                                        <p>VAWG Incidents Reported <br> out of <span id="incidentDataTotal">{{ $allIncidentData }}</span> disputes</p>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer card-footer-padding">
                                <div class="row align-items-center" style="margin: 0">
                                    <div class="col-md-8 text-start">
                                        <p class="mb-0" style="color: gray;" id="incident-date-filter">
                                            Oct 2021-Current, All locations</p>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" id="1" class="btn btn-sm btn-secondary btn-custom"
                                            style="min-width: 100%;" data-toggle="modal" data-target="#exampleModal"
                                            data-whatever="@getbootstrap">
                                            <img src="{{ asset('images/filter.png') }}" width="20" height="20"
                                                alt="Filter icon"> Filter
                                            {{-- <i class="fa-sharp fa-solid fa-sliders-up"></i> Filter --}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Second --}}
                    <div class="col-md-4">
                        <div class="card bg-light mb-3 border-0 shadow">
                            <div class="card-body card-padding">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center p-3"><img
                                            src="{{ asset('images/adr-complaints-icn.svg') }}" class="card-image"
                                            alt="Filter icon"></div>
                                    <div class="col-md-8 text-center">
                                        <h2 id="throughAdr">{{ $throughADR }}</h2>
                                        <p>Complaints resolved <br> through ADR</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer card-footer-padding">
                                <div class="row align-items-center" style="margin: 0">
                                    <div class="col-md-8 text-start">
                                        <p class="mb-0" style="color: gray;" id="through-date-filter">
                                            Oct 2021-Current, All locations</p>
                                    </div>
                                    <div class="col-md-4">
                                        <button id="2" class="btn btn-sm btn-secondary btn-custom" style="min-width: 100%;"
                                            data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">
                                            <img src="{{ asset('images/filter.png') }}" width="20" height="20"
                                                alt="Filter icon"> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Third --}}
                    <div class="col-md-4">
                        <div class="card bg-light mb-3 border-0 shadow">
                            <div class="card-body card-padding">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center p-3"><img
                                            src="{{ asset('images/taka-adr-icn.svg') }}" class="card-image"
                                            alt="Filter icon"></div>
                                    <div class="col-md-8 text-center">
                                        <h2 id="takaAdr">{{ $moneyADR }}</h2>
                                        <p>Taka Recovered <br> from ADR</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer card-footer-padding">
                                <div class="row align-items-center" style="margin: 0">
                                    <div class="col-md-8 text-start">
                                        <p class="mb-0" style="color: gray;" id="adr-date-filter">
                                            Oct 2021-Current, All locations</p>
                                    </div>
                                    <div class="col-md-4">
                                        <button id="3" class="btn btn-sm btn-secondary btn-custom" style="min-width: 100%;"
                                            data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">
                                            <img src="{{ asset('images/filter.png') }}" width="20"
                                                height="20" alt="Filter icon"> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fourth --}}
                    <div class="col-md-4">
                        <div class="card bg-light mb-3 border-0 shadow">
                            <div class="card-body card-padding">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center p-3"><img
                                            src="{{ asset('images/marriage-prevented-icn.svg') }}"
                                            class="card-image" alt="Filter icon"></div>
                                    <div class="col-md-8 text-center">
                                        <h2 id="childMarriagePre">{{ $childMarriagePravented }}</h2>
                                        <p>Child Marriage <br> Prevented by SELP</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer card-footer-padding">
                                <div class="row align-items-center" style="margin: 0">
                                    <div class="col-md-8 text-start">
                                        <p class="mb-0" style="color: gray;" id="pre-date-filter">
                                            Oct 2021-Current, All locations</p>
                                    </div>
                                    <div class="col-md-4">
                                        <button id="4" class="btn btn-sm btn-secondary btn-custom" style="min-width: 100%;"
                                            data-toggle="modal" data-target="#exampleModal"
                                            data-whatever="@getbootstrap">
                                            <img src="{{ asset('images/filter.png') }}" width="20"
                                                height="20" alt="Filter icon"> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Fiveth --}}
                    <div class="col-md-4">
                        <div class="card bg-light mb-3 border-0 shadow">
                            <div class="card-body card-padding">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center p-3"><img
                                            src="{{ asset('images/marriage-reported-icn.svg') }}"
                                            class="card-image" alt="Filter icon"></div>
                                    <div class="col-md-8 text-center">
                                        <h2 id="childMarriage">{{ $childMarriageReported }}</h2>
                                        <p>Child Marriages <br> reported</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer card-footer-padding">
                                <div class="row align-items-center" style="margin: 0">
                                    <div class="col-md-8 text-start">
                                        <p class="mb-0" style="color: gray;" id="reported-date-filter">
                                            Oct 2021-Current, All locations</p>
                                    </div>
                                    <div class="col-md-4">
                                        <button id="5" class="btn btn-sm btn-secondary btn-custom" style="min-width: 100%;"
                                            data-toggle="modal" data-target="#exampleModal"
                                            data-whatever="@getbootstrap">
                                            <img src="{{ asset('images/filter.png') }}" width="20"
                                                height="20" alt="Filter icon"> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Sixth --}}
                    <div class="col-md-4">
                        <div class="card bg-light mb-3 border-0 shadow">
                            <div class="card-body card-padding">
                                <div class="row align-items-center">
                                    <div class="col-md-4 text-center p-3"><img
                                            src="{{ asset('images/legal-support-icn.svg') }}" class="card-image"
                                            alt="Filter icon"></div>
                                    <div class="col-md-8 text-center">
                                        <h2 id="gotSupport"><img src="{{ asset('images/loader.gif') }}"
                                                alt="Loader" width="45" height="45"></h2>
                                        {{-- <h2 id="gotSupport">{{ @$caseOrAdr }}</h2> --}}
                                        <p>Survivors got Legal <br> Support (Case & ADR)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer card-footer-padding">
                                <div class="row align-items-center" style="margin: 0">
                                    <div class="col-md-8 text-start">
                                        <p class="mb-0" style="color: gray;" id="reported-date-filter">
                                            Oct 2021-Current, All locations</p>
                                    </div>
                                    <div class="col-md-4 ">
                                        <button id="6" class="btn btn-sm btn-secondary btn-custom" style="min-width: 100%;"
                                            data-toggle="modal" data-target="#exampleModal"
                                            data-whatever="@getbootstrap">
                                            <img src="{{ asset('images/filter.png') }}" width="20"
                                                height="20" alt="Filter icon"> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    {{-- Age Range of Survivors --}}
                    <div class="col-md-12">
                        <div class="card bg-light mb-3">
                            <div class="card-header card-footer-padding">
                                <div class="row" style="margin: 0">
                                    <div class="col-md-8 d-flex align-items-center text-start">
                                        <p class="mb-0" style="color: gray;font-weight:bold;"
                                            id="incident-date-filter">Age Range of Survivors, <span id="ager_filter_date_display">Oct 2021-Current</span></p>
                                    </div>
                                    <div class="col-md-4 d-flex justify-content-end">
                                        <button type="button" id="1" class="btn btn-sm btn-secondary btn-custom"
                                            style="" data-toggle="modal" data-target="#AgeRangeModal"
                                            data-whatever="@getbootstrap">
                                            <img src="{{ asset('images/filter.png') }}" width="20"
                                                height="20" alt="Filter icon"> Filter
                                            {{-- <i class="fa-sharp fa-solid fa-sliders-up"></i> Filter --}}
                                        </button>&nbsp&nbsp
                                        {{-- <button type="button" id="1" class="btn btn-sm btn-secondary btn-custom" style="" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">
                    <i class="fa fa-file"></i> PNG
                  </button>           --}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body card-padding">
                                <div class="row">
                                    <div id="chartdiv"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    {{-- Top 5 type of Violence --}}
                    <div class="col-md-6">
                        <div class="card bg-light mb-3">
                            <div class="card-header card-footer-padding">
                                <div class="row" style="margin: 0">
                                    <div class="col-md-8 d-flex align-items-center text-start">
                                        <p class="mb-0" style="color: gray;font-weight:bold;"
                                            id="incident-date-filter">Top 5 type of Violence - <span id="top_filter_date_display">Oct 2021-Current</span></p>
                                    </div>
                                    <div class="col-md-4 d-flex justify-content-end">
                                        <button type="button" id="1" class="btn btn-sm btn-secondary btn-custom"
                                            style="" data-toggle="modal" data-target="#TopViolenceModal"
                                            data-whatever="@getbootstrap">
                                            <img src="{{ asset('images/filter.png') }}" width="20"
                                                height="20" alt="Filter icon"> Filter
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body card-padding" style="height: 381px;">
                                <div class="row">
                                    <div id="chartdiv3"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Survivor Profile --}}
                    <div class="col-md-6">
                        <div class="card bg-light mb-3">
                            <div class="card-header card-footer-padding">
                                <div class="row" style="margin: 0">
                                    <div class="col-md-8 d-flex align-items-center text-start">
                                        <p class="mb-0" style="color: gray;font-weight:bold;"
                                            id="incident-date-filter">Survivor Profile</p>
                                    </div>
                                    {{-- <div class="col-md-4 d-flex justify-content-end">
                  <button type="button" id="1" class="btn btn-sm btn-secondary btn-custom" style="" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">
                    <img src="{{ asset('images/filter.png') }}" width="20" height="20" alt="Filter icon"> Filter
                  </button>
                </div> --}}
                                </div>
                            </div>
                            <br>
                            <div class="card-body card-padding">
                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-toggle="tab" href="#home">Early age of
                                                    Marriage(Female)</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#menu1">Recurrent
                                                    violence</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-toggle="tab" href="#menu2">Education</a>
                                            </li>
                                        </ul>

                                        <div class="tab-content">
                                            <div id="home" class="container tab-pane active"><br>
                                                {{-- <h3>Early age of Marriage</h3>
                      <p></p> --}}
                                                <div class="row">
                                                    <div class="col-md-12 d-flex justify-content-between text-left">
                                                        <p id="early_age_date_display" class="mb-0" style="color: gray;font-weight:bold;">Oct 2021-Current</p>
                                                        <button type="button" id="1"
                                                            class="btn btn-sm btn-secondary btn-custom" style=""
                                                            data-toggle="modal" data-target="#marriageModal"
                                                            data-whatever="@getbootstrap">
                                                            <img src="{{ asset('images/filter.png') }}"
                                                                width="20" height="20" alt="Filter icon"> Filter
                                                        </button>
                                                    </div>
                                                    <div id="chartdiv4"></div>
                                                </div>
                                            </div>
                                            <div id="menu1" class="container tab-pane fade"><br>
                                                <div class="row">
                                                    <div class="col-md-12 d-flex justify-content-between text-left">
                                                        <p id="recurrent_filter_date_display" class="mb-0" style="color: gray;font-weight:bold;">Oct 2021-Current</p>
                                                        <button type="button" id="1"
                                                            class="btn btn-sm btn-secondary btn-custom" style=""
                                                            data-toggle="modal" data-target="#recurrentViolenceModal"
                                                            data-whatever="@getbootstrap">
                                                            <img src="{{ asset('images/filter.png') }}"
                                                                width="20" height="20" alt="Filter icon"> Filter
                                                        </button>
                                                    </div>
                                                    <div class="col-md-12" style="margin-top: 15px;">
                                                        {{-- <h3>{{ $recurrentViolence }}</h3> --}}
                                                        {{-- <div class="card bg-light" style="width: 22rem; margin:82px;background-color:#8ccbe9;">
                            <div class="card-body">
                              <h2 class="card-title text-center" id="recurrentViolence">{{ $recurrentViolence }}</h2>
                            </div>
                          </div> --}}
                                                        <div class="card bg-light mb-3">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-4 text-center"><img
                                                                            src="{{ asset('images/vawc-incident-icn.svg') }}"
                                                                            class="card-image" alt="Filter icon"></div>
                                                                    <div class="col-md-8 text-center"
                                                                        style="padding-top: 18px;">
                                                                        <h2 id="recurrentViolence">
                                                                            {{ $recurrentViolence }}</h2>
                                                                        <p>Survivors Faced Recurrent Violence</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="menu2" class="container tab-pane fade"><br>
                                                <div class="col-md-12 d-flex justify-content-between text-left">
                                                    <p id="education_filter_date_display" class="mb-0" style="color: gray;font-weight:bold;">Oct 2021-Current</p>
                                                    <button type="button" id="1"
                                                        class="btn btn-sm btn-secondary btn-custom" style=""
                                                        data-toggle="modal" data-target="#educationModal"
                                                        data-whatever="@getbootstrap">
                                                        <img src="{{ asset('images/filter.png') }}" width="20"
                                                            height="20" alt="Filter icon"> Filter
                                                    </button>
                                                </div>
                                                <div id="chartdiv5"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                </div>
            </div>
        </div>


        {{-- Money Recovered through ADR --}}
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-light mb-3">
                            <div class="card-header card-footer-padding">
                                <div class="row" style="margin: 0">
                                    <div class="col-md-8 d-flex align-items-center text-start">
                                        <p class="mb-0" style="color: gray;font-weight:bold;"
                                            id="incident-date-filter">Money Recovered through ADR</p>
                                    </div>
                                    <div class="col-md-4 d-flex justify-content-end">
                                        <button type="button" id="1" class="btn btn-sm btn-secondary btn-custom"
                                            style="" data-toggle="modal" data-target="#AdrModal"
                                            data-whatever="@getbootstrap">
                                            <img src="{{ asset('images/filter.png') }}" width="20"
                                                height="20" alt="Filter icon"> Filter
                                            {{-- <i class="fa-sharp fa-solid fa-sliders-up"></i> Filter --}}
                                        </button>
                                        {{-- <button type="button" id="1" class="btn btn-sm btn-secondary btn-custom" style="" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">
                    <i class="fa fa-file"></i> PNG
                  </button>           --}}
                                    </div>
                                </div>
                            </div>
                            <div class="card-body card-padding">
                                <div class="row">
                                    <div id="chartdiv2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    {{-- Perpetrator Profile --}}
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="card" style="min-height: 100px;padding-top: 22px;">
                                <div class="card-body">
                                    <a href="{{ route('dashboardPerpetrator') }}" target="__blank"
                                        style="color: #d10074">Profile of the Accused</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Other violence pravented at community level --}}
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="card" style="min-height: 100px;padding-top: 20px;">
                                <div class="card-body">
                                    <a href="{{ route('dashboardCommunity') }}" target="__blank"
                                        style="color: #d10074">Other violence prevented at community level</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- ADR vs Case initiated against complaint --}}
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="card" style="min-height: 100px;padding-top: 22px;">
                                <div class="card-body">
                                    <a href="{{ route('dashboardAdrCase') }}" target="__blank"
                                        style="color: #d10074">ADR vs Case initiated against complaint</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- Modal 1 to 6 --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Filter Criteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="" id="filterForm">
                        <input type="hidden" name="hidden_field" id="hidden_field" value="" />
                        <input type="hidden" name="token" id="token" value="{{ csrf_token() }}" />
                        <div class="form-row">
                            <div class="form-group col-md-4">
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
                            <div class="form-group col-md-4">
                                <label class="control-label">Division</label>
                                <select name="division_id" id="division_id"
                                    class="division_id form-control form-control-sm">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">District</label>
                                <select name="district_id" id="district_id"
                                    class="district_id form-control form-control-sm">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Upazila</label>
                                <select name="upazila_id" id="upazila_id"
                                    class="upazila_id form-control form-control-sm">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">From Date</label>
                                <input type="text" name="from_date" id="from_date"
                                    class="form-control form-control-sm modaldatepicker" placeholder="From Date"
                                    autocomplete="off">
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">To Date</label>
                                <input type="text" name="to_date" id="to_date"
                                    class="form-control form-control-sm modaldatepicker" placeholder="To Date"
                                    autocomplete="off">
                            </div>
                            {{-- <div class="form-group col-sm-4">
                  <!-- <a class="btn btn-sm btn-primary" type="submit" style="margin-top: 29px; color: white">Search</a> -->
                  <button type="submit" class="btn btn-success btn-sm"  style="margin-top: 21px; color: white">Search</button>
                </div> --}}
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="modal_close" class="btn btn-secondary" data-dismiss="modal">Close</a>
                            <input type="submit" class="btn btn-success" value="Search" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Age Range of Survivors --}}
    <div class="modal fade" id="AgeRangeModal" tabindex="-1" role="dialog" aria-labelledby="AgeRangeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Filter Criteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="" id="AgeRangeFilterForm">
                        <input type="hidden" name="hidden_field" id="hidden_field" value="" />
                        <input type="hidden" name="token" id="token" value="{{ csrf_token() }}" />
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Zone</label>
                                @if (count(session()->get('userareaaccess.sregions')) > 0)
                                    <select name="region_id" id="age_region_id"
                                        class="age_region_id form-control form-control-sm select2">
                                        <option value="">Select zone</option>
                                        @foreach ($regions as $key => $region)
                                            @if (in_array($region->id, session()->get('userareaaccess.sregions')))
                                                <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select name="region_id" id="age_region_id"
                                        class="age_region_id form-control form-control-sm select2">
                                        <option value="">Select Zone</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Division</label>
                                <select name="division_id" id="age_division_id"
                                    class="age_division_id form-control form-control-sm">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">District</label>
                                <select name="district_id" id="age_district_id"
                                    class="age_district_id form-control form-control-sm">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Upazila</label>
                                <select name="upazila_id" id="age_upazila_id"
                                    class="age_upazila_id form-control form-control-sm">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Type of Dispute</label>
                                <select name="upazila_id" id="age_violence_id"
                                    class="age_violence_id form-control form-control-sm">
                                    <option value="">Select Dispute</option>
                                    @foreach ($violence_categories as $violence)
                                        <option value="{{ $violence->id }}">{{ $violence->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">From Date</label>
                                <input type="text" name="from_date" id="age_from_date"
                                    class="age_from_date form-control form-control-sm modaldatepicker"
                                    placeholder="From Date" autocomplete="off">
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">To Date</label>
                                <input type="text" name="to_date" id="age_to_date"
                                    class="age_to_date form-control form-control-sm modaldatepicker" placeholder="To Date"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="age_modal_close" class="btn btn-secondary"
                                data-dismiss="modal">Close</a>
                            <input type="submit" class="btn btn-success" value="Search" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Money Recovered through ADR --}}
    <div class="modal fade" id="AdrModal" tabindex="-1" role="dialog" aria-labelledby="AdrModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Filter Criteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="" id="AdrFilterForm">
                        <input type="hidden" name="hidden_field" id="hidden_field" value="" />
                        <input type="hidden" name="token" id="token" value="{{ csrf_token() }}" />
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Zone</label>
                                @if (count(session()->get('userareaaccess.sregions')) > 0)
                                    <select name="region_id" id="adr_region_id"
                                        class="adr_region_id form-control form-control-sm select2">
                                        <option value="">Select zone</option>
                                        @foreach ($regions as $key => $region)
                                            @if (in_array($region->id, session()->get('userareaaccess.sregions')))
                                                <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select name="region_id" id="adr_region_id"
                                        class="adr_region_id form-control form-control-sm select2">
                                        <option value="">Select Zone</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Division</label>
                                <select name="division_id" id="adr_division_id"
                                    class="adr_division_id form-control form-control-sm">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">District</label>
                                <select name="district_id" id="adr_district_id"
                                    class="adr_district_id form-control form-control-sm">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Upazila</label>
                                <select name="upazila_id" id="adr_upazila_id"
                                    class="adr_upazila_id form-control form-control-sm">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Year</label>
                                <select name="adr_year" id="adr_year" class="adr_year form-control form-control-sm">
                                    <option value="">Select Year</option>
                                    @php
                                        $current_year = date('Y');
                                    @endphp
                                    @for ($year = 2000; $year <= $current_year; $year++)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            {{-- <div class="form-group col-sm-4">
                  <label class="control-label">From Date</label>
                  <input type="text" name="from_date" id="adr_from_date" class="adr_from_date form-control form-control-sm modaldatepicker" placeholder="From Date" autocomplete="off">
                </div>
                <div class="form-group col-sm-4">
                  <label class="control-label">To Date</label>
                  <input type="text" name="to_date" id="adr_to_date" class="adr_to_date form-control form-control-sm modaldatepicker" placeholder="To Date" autocomplete="off">
                </div> --}}
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="adr_modal_close" class="btn btn-secondary"
                                data-dismiss="modal">Close</a>
                            <input type="submit" class="btn btn-success" value="Search" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Top 5 type of Violence --}}
    <div class="modal fade" id="TopViolenceModal" tabindex="-1" role="dialog" aria-labelledby="TopViolenceModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Filter Criteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="" id="TopViolenceFilterForm">
                        <input type="hidden" name="hidden_field" id="hidden_field" value="" />
                        <input type="hidden" name="token" id="token" value="{{ csrf_token() }}" />
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Zone</label>
                                @if (count(session()->get('userareaaccess.sregions')) > 0)
                                    <select name="region_id" id="violence_region_id"
                                        class="violence_region_id form-control form-control-sm select2">
                                        <option value="">Select zone</option>
                                        @foreach ($regions as $key => $region)
                                            @if (in_array($region->id, session()->get('userareaaccess.sregions')))
                                                <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select name="region_id" id="violence_region_id"
                                        class="violence_region_id form-control form-control-sm select2">
                                        <option value="">Select Zone</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Division</label>
                                <select name="division_id" id="violence_division_id"
                                    class="violence_division_id form-control form-control-sm">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">District</label>
                                <select name="district_id" id="violence_district_id"
                                    class="violence_district_id form-control form-control-sm">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Upazila</label>
                                <select name="upazila_id" id="violence_upazila_id"
                                    class="violence_upazila_id form-control form-control-sm">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Type of Dispute</label>
                                <select name="upazila_id" id="violence_violence_id"
                                    class="violence_violence_id form-control form-control-sm">
                                    <option value="">Select Dispute</option>
                                    @foreach ($violence_categories as $violence)
                                        <option value="{{ $violence->id }}">{{ $violence->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">From Date</label>
                                <input type="text" name="from_date" id="violence_from_date"
                                    class="violence_from_date form-control form-control-sm modaldatepicker"
                                    placeholder="From Date" autocomplete="off">
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">To Date</label>
                                <input type="text" name="to_date" id="violence_to_date"
                                    class="violence_to_date form-control form-control-sm modaldatepicker"
                                    placeholder="To Date" autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="violence_modal_close" class="btn btn-secondary"
                                data-dismiss="modal">Close</a>
                            <input type="submit" class="btn btn-success" value="Search" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Early age of Marriage --}}
    <div class="modal fade" id="marriageModal" tabindex="-1" role="dialog" aria-labelledby="marriageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Filter Criteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="" id="MarriageFilterForm">
                        <input type="hidden" name="hidden_field" id="hidden_field" value="" />
                        <input type="hidden" name="token" id="token" value="{{ csrf_token() }}" />
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Zone</label>
                                @if (count(session()->get('userareaaccess.sregions')) > 0)
                                    <select name="region_id" id="marriage_region_id"
                                        class="marriage_region_id form-control form-control-sm select2">
                                        <option value="">Select zone</option>
                                        @foreach ($regions as $key => $region)
                                            @if (in_array($region->id, session()->get('userareaaccess.sregions')))
                                                <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select name="region_id" id="marriage_region_id"
                                        class="marriage_region_id form-control form-control-sm select2">
                                        <option value="">Select Zone</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Division</label>
                                <select name="division_id" id="marriage_division_id"
                                    class="marriage_division_id form-control form-control-sm">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">District</label>
                                <select name="district_id" id="marriage_district_id"
                                    class="marriage_district_id form-control form-control-sm">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Upazila</label>
                                <select name="upazila_id" id="marriage_upazila_id"
                                    class="marriage_upazila_id form-control form-control-sm">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">From Date</label>
                                <input type="text" name="from_date" id="marriage_from_date"
                                    class="marriage_from_date form-control form-control-sm modaldatepicker"
                                    placeholder="From Date" autocomplete="off">
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">To Date</label>
                                <input type="text" name="to_date" id="marriage_to_date"
                                    class="marriage_to_date form-control form-control-sm modaldatepicker"
                                    placeholder="To Date" autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="marriage_modal_close" class="btn btn-secondary"
                                data-dismiss="modal">Close</a>
                            <input type="submit" class="btn btn-success" value="Search" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Recurrent violence --}}
    <div class="modal fade" id="recurrentViolenceModal" tabindex="-1" role="dialog"
        aria-labelledby="recurrentViolenceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Filter Criteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="" id="RecurrentViolenceFilterForm">
                        <input type="hidden" name="hidden_field" id="hidden_field" value="" />
                        <input type="hidden" name="token" id="token" value="{{ csrf_token() }}" />
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Zone</label>
                                @if (count(session()->get('userareaaccess.sregions')) > 0)
                                    <select name="region_id" id="recurrentviolence_region_id"
                                        class="recurrentviolence_region_id form-control form-control-sm select2">
                                        <option value="">Select zone</option>
                                        @foreach ($regions as $key => $region)
                                            @if (in_array($region->id, session()->get('userareaaccess.sregions')))
                                                <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select name="region_id" id="recurrentviolence_region_id"
                                        class="recurrentviolence_region_id form-control form-control-sm select2">
                                        <option value="">Select Zone</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Division</label>
                                <select name="division_id" id="recurrentviolence_division_id"
                                    class="recurrentviolence_division_id form-control form-control-sm">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">District</label>
                                <select name="district_id" id="recurrentviolence_district_id"
                                    class="recurrentviolence_district_id form-control form-control-sm">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Upazila</label>
                                <select name="upazila_id" id="recurrentviolence_upazila_id"
                                    class="recurrentviolence_upazila_id form-control form-control-sm">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">From Date</label>
                                <input type="text" name="from_date" id="recurrentviolence_from_date"
                                    class="recurrentviolence_from_date form-control form-control-sm modaldatepicker"
                                    placeholder="From Date" autocomplete="off">
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">To Date</label>
                                <input type="text" name="to_date" id="recurrentviolence_to_date"
                                    class="recurrentviolence_to_date form-control form-control-sm modaldatepicker"
                                    placeholder="To Date" autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="recurrentviolence_modal_close" class="btn btn-secondary"
                                data-dismiss="modal">Close</a>
                            <input type="submit" class="btn btn-success" value="Search" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Education --}}
    <div class="modal fade" id="educationModal" tabindex="-1" role="dialog" aria-labelledby="educationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Filter Criteria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="get" action="" id="EducationFilterForm">
                        <input type="hidden" name="hidden_field" id="hidden_field" value="" />
                        <input type="hidden" name="token" id="token" value="{{ csrf_token() }}" />
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="control-label">Zone</label>
                                @if (count(session()->get('userareaaccess.sregions')) > 0)
                                    <select name="region_id" id="education_region_id"
                                        class="education_region_id form-control form-control-sm select2">
                                        <option value="">Select zone</option>
                                        @foreach ($regions as $key => $region)
                                            @if (in_array($region->id, session()->get('userareaaccess.sregions')))
                                                <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select name="region_id" id="education_region_id"
                                        class="education_region_id form-control form-control-sm select2">
                                        <option value="">Select Zone</option>
                                        @foreach ($regions as $region)
                                            <option value="{{ $region->id }}">{{ $region->region_name }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Division</label>
                                <select name="division_id" id="education_division_id"
                                    class="education_division_id form-control form-control-sm">
                                    <option value="">Select Division</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">District</label>
                                <select name="district_id" id="education_district_id"
                                    class="education_district_id form-control form-control-sm">
                                    <option value="">Select District</option>
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">Upazila</label>
                                <select name="upazila_id" id="education_upazila_id"
                                    class="education_upazila_id form-control form-control-sm">
                                    <option value="">Select Upazila</option>
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">From Date</label>
                                <input type="text" name="from_date" id="education_from_date"
                                    class="education_from_date form-control form-control-sm modaldatepicker"
                                    placeholder="From Date" autocomplete="off">
                            </div>
                            <div class="form-group col-sm-4">
                                <label class="control-label">To Date</label>
                                <input type="text" name="to_date" id="education_to_date"
                                    class="education_to_date form-control form-control-sm modaldatepicker"
                                    placeholder="To Date" autocomplete="off">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="#" id="education_modal_close" class="btn btn-secondary"
                                data-dismiss="modal">Close</a>
                            <input type="submit" class="btn btn-success" value="Search" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        $(function() {
            $(document).on('click', function(e) {
                //console.log(e.target.parentNode.id)
                if (e.target.getAttribute('data-target') === "#exampleModal" || e.target.parentNode
                    .getAttribute('data-target') === "#exampleModal") {

                   // console.log(e.target.id);
                    document.getElementById('hidden_field').value = (e.target.id == '' ? e.target.parentNode
                        .id : e.target.id);
                }
                // var hidden_field= document.getElementById('hidden_field').value);



            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $(document).on('submit', function(e) {
                //console.log(document.getElementById('hidden_field').value);
                e.preventDefault();
                e.stopPropagation();
                var hidden_field = $('#hidden_field').val();
                var region_id = $('#region_id').val();
                var division_id = $('#division_id').val();
                var district_id = $('#district_id').val();
                var upazila_id = $('#upazila_id').val();
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var token = $('#token').val();
                // console.log(token);
                $.ajax({
                    url: "{{ route('filterData') }}",
                    type: "POST",
                    data: {
                        token: token,
                        hidden_field: hidden_field,
                        region_id: region_id,
                        division_id: division_id,
                        district_id: district_id,
                        upazila_id: upazila_id,
                        from_date: from_date,
                        to_date: to_date
                    },
                    success: function(data) {
                        if (hidden_field == 1) {
                            // console.log(data);
                            $('#incidentData').text(data.dataVawg);
                            $('#incidentDataTotal').text(data.dataTotal);
                            if (from_date != '') {
                                $('#incident-date-filter').text(from_date + " - " + to_date);
                            }
                        }
                        if (hidden_field == 2) {
                            $('#throughAdr').text(data);
                            if (from_date != '') {
                                $('#through-date-filter').text(from_date + " - " + to_date);
                            }
                        }
                        if (hidden_field == 3) {
                            $('#takaAdr').text(data);
                            if (from_date != '') {
                                $('#adr-date-filter').text(from_date + " - " + to_date);
                            }
                        }
                        if (hidden_field == 4) {
                            $('#childMarriagePre').text(data);
                            if (from_date != '') {
                                $('#pre-date-filter').text(from_date + " - " + to_date);
                            }
                        }
                        if (hidden_field == 5) {
                            $('#childMarriage').text(data);
                            if (from_date != '') {
                                $('#reported-date-filter').text(from_date + " - " + to_date);
                            }
                        }
                        if (hidden_field == 6) {
                            $('#gotSupport').text(data);
                            if (from_date != '') {
                                $('#reported-date-filter').text(from_date + " - " + to_date);
                            }
                        }
                        // $('#exampleModal').modal('hide');
                        document.getElementById('modal_close').click();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $("#RecurrentViolenceFilterForm").submit(function(event) {
                event.preventDefault();
                event.stopPropagation();

                var region_id = $('#recurrentviolence_region_id').val();
                var division_id = $('#recurrentviolence_division_id').val();
                var district_id = $('#recurrentviolence_district_id').val();
                var upazila_id = $('#recurrentviolence_upazila_id').val();
                var from_date = $('#recurrentviolence_from_date').val();
                var to_date = $('#recurrentviolence_to_date').val();
                var token = $('#token').val();
                // console.log(token);
                $.ajax({
                    type: "POST",
                    data: {
                        _token: token,
                        region_id: region_id,
                        division_id: division_id,
                        district_id: district_id,
                        upazila_id: upazila_id,
                        from_date: from_date,
                        to_date: to_date
                    },
                    url: "{{ route('filterRecurrentViolence') }}",
                    success: function(response) {
                        // console.log("Data successfully loaded from URL");
                        $('#recurrent_filter_date_display').html(from_date +' - '+to_date);
                       // console.log(response);
                        $('#recurrentViolence').text(response);
                    },
                    error: function(error) {
                        console.log("Error loading data from URL");
                        console.log(error);
                    }
                });
                document.getElementById('recurrentviolence_modal_close').click();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('getSupportData') }}",
                success: function(data) {
                    console.log("Data successfully loaded from URL");
                    //console.log(data);
                    // gotSupport
                    $('#gotSupport').text(data);
                },
                error: function(error) {
                    console.log("Error loading data from URL");
                    //console.log(error);
                }
            });
        });
    </script>

    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>
    <script>
        let root = am5.Root.new("chartdiv");
        let root_adr = am5.Root.new("chartdiv2");
        let root_violence = am5.Root.new("chartdiv3");
        let root_marriage = am5.Root.new("chartdiv4");
        let root_education = am5.Root.new("chartdiv5");
        let d_previous = null;
        let adr_previous = null;
        let violence_previous = null;
        let marriage_previous = null;
        let education_previous = null;
    </script>

    {{-- Age Range of Survivors --}}
    <script>
        $(document).ready(function() {

            $("#AgeRangeFilterForm").submit(function(event) {
                event.preventDefault();
                event.stopPropagation();

                var region_id = $('#age_region_id').val();
                var division_id = $('#age_division_id').val();
                var district_id = $('#age_district_id').val();
                var upazila_id = $('#age_upazila_id').val();
                var violence_id = $('#age_violence_id').val();
                var age_from_date = $('#age_from_date').val();
                var age_to_date = $('#age_to_date').val();
                var token = $('#token').val();
                // console.log(token);
                $.ajax({
                    type: "POST",
                    data: {
                        _token: token,
                        region_id: region_id,
                        division_id: division_id,
                        district_id: district_id,
                        upazila_id: upazila_id,
                        violence_id: violence_id,
                        from_date: age_from_date,
                        to_date: age_to_date
                    },
                    url: "{{ route('filterAgeRangeData') }}",
                    success: function(response) {
                        // console.log("Data successfully loaded from URL");
                        //console.log(response);
                        $('#ager_filter_date_display').html(age_from_date + ' - '+ age_to_date);

                        if (d_previous != null) {
                            d_previous.dispose();
                        }

                        am5.ready(function() {

                            // Create root element
                            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                            root = am5.Root.new("chartdiv");
                            d_previous = root;

                            // Set themes
                            // https://www.amcharts.com/docs/v5/concepts/themes/
                            root.setThemes([
                                am5themes_Animated.new(root)
                            ]);

                            // For Export
                            var exporting = am5plugins_exporting.Exporting.new(root, {
                                menu: am5plugins_exporting.ExportingMenu.new(
                                    root, {})
                            });
                            exporting.get("menu").set("items", [{
                                type: "format",
                                format: "png",
                                label: "Export image"
                            }]);

                            // Create chart
                            // https://www.amcharts.com/docs/v5/charts/xy-chart/
                            var chart = root.container.children.push(am5xy.XYChart.new(
                                root, {
                                    panX: false,
                                    panY: false,
                                    // wheelX: "panX",
                                    // wheelY: "zoomX",
                                    layout: root.verticalLayout
                                }));


                            // Add legend
                            // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                            var legend = chart.children.push(am5.Legend.new(root, {
                                centerX: am5.p50,
                                x: am5.p50
                            }))


                            // Data
                            var data = response;


                            // Create axes
                            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                            var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
                                categoryField: "age",
                                renderer: am5xy.AxisRendererY.new(root, {
                                    inversed: true,
                                    cellStartLocation: 0.1,
                                    cellEndLocation: 0.9
                                })
                            }));

                            yAxis.children.unshift(
                                am5.Label.new(root, {
                                    rotation: -90,
                                    text: "Age Range",
                                    y: am5.p50,
                                    centerX: am5.p50
                                })
                            );

                            yAxis.data.setAll(data);

                            var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                                renderer: am5xy.AxisRendererX.new(root, {}),
                                min: 0
                            }));

                            xAxis.children.push(
                                am5.Label.new(root, {
                                    text: "Total Number",
                                    x: am5.p50,
                                    centerX: am5.p50
                                })
                            );
                            // Add series
                            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                            function createSeries(field, name) {
                                var series = chart.series.push(am5xy.ColumnSeries.new(
                                    root, {
                                        name: name,
                                        xAxis: xAxis,
                                        yAxis: yAxis,
                                        valueXField: field,
                                        categoryYField: "age",
                                        sequencedInterpolation: true,
                                        tooltip: am5.Tooltip.new(root, {
                                            pointerOrientation: "horizontal",
                                            labelText: "[bold]{name}[/] - {categoryY}: {valueX}"
                                        })
                                    }));

                                series.columns.template.setAll({
                                    height: am5.p100
                                });


                                series.bullets.push(function() {
                                    return am5.Bullet.new(root, {
                                        locationX: 1,
                                        locationY: 0.5,
                                        sprite: am5.Label.new(root, {
                                            centerY: am5.p50,
                                            text: "{valueX}",
                                            populateText: true
                                        })
                                    });
                                });

                                series.bullets.push(function() {
                                    return am5.Bullet.new(root, {
                                        locationX: 1,
                                        locationY: 0.5,
                                        sprite: am5.Label.new(root, {
                                            centerX: am5.p100,
                                            centerY: am5.p50,
                                            // text: "{name}",
                                            fill: am5.color(
                                                0xffffff),
                                            populateText: true
                                        })
                                    });
                                });

                                series.data.setAll(data);
                                series.appear();

                                return series;
                            }

                            // for (var i = 0; i < response[0].length; i++) {
                            // console.log(response[0].length);
                            // if (i === 0) {
                            //   console.log("The first index is: " + response[i]);
                            //   break;
                            // }
                            // }
                            for (const [key, value] of Object.entries(response[0])) {
                               // console.log(`: ${value}`);
                                if (key != 'age') {
                                    createSeries(key, key);
                                }
                            }





                            // Add legend
                            // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                            var legend = chart.children.push(am5.Legend.new(root, {
                                centerX: am5.p50,
                                x: am5.p50
                            }));

                            legend.data.setAll(chart.series.values);


                            // Add cursor
                            // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                                behavior: "zoomY"
                            }));
                            cursor.lineY.set("forceHidden", true);
                            cursor.lineX.set("forceHidden", true);


                            // Make stuff animate on load
                            // https://www.amcharts.com/docs/v5/concepts/animations/
                            chart.appear(1000, 100);

                        }); // end am5.ready()
                    },
                    error: function(error) {
                        console.log("Error loading data from URL");
                        console.log(error);
                    }
                });
                document.getElementById('age_modal_close').click();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('ageRangeData') }}",
                success: function(response) {
                    // console.log("Data successfully loaded from URL");
                   // console.log(response);
                    am5.ready(function() {

                        // Create root element
                        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                        d_previous = root;

                        // Set themes
                        // https://www.amcharts.com/docs/v5/concepts/themes/
                        root.setThemes([
                            am5themes_Animated.new(root)
                        ]);

                        // For Export
                        var exporting = am5plugins_exporting.Exporting.new(root, {
                            menu: am5plugins_exporting.ExportingMenu.new(root, {})
                        });
                        exporting.get("menu").set("items", [{
                            type: "format",
                            format: "png",
                            label: "Export image"
                        }]);

                        // Create chart
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/
                        var chart = root.container.children.push(am5xy.XYChart.new(root, {
                            panX: false,
                            panY: false,
                            // wheelX: "panX",
                            // wheelY: "zoomX",
                            layout: root.verticalLayout
                        }));


                        // Add legend
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                        var legend = chart.children.push(am5.Legend.new(root, {
                            centerX: am5.p50,
                            x: am5.p50
                        }))


                        // Data
                        var data = response;


                        // Create axes
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                        var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
                            categoryField: "age",
                            renderer: am5xy.AxisRendererY.new(root, {
                                inversed: true,
                                cellStartLocation: 0.1,
                                cellEndLocation: 0.9
                            })
                        }));

                        yAxis.children.unshift(
                            am5.Label.new(root, {
                                rotation: -90,
                                text: "Age Range",
                                y: am5.p50,
                                centerX: am5.p50
                            })
                        );

                        yAxis.data.setAll(data);

                        var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                            renderer: am5xy.AxisRendererX.new(root, {}),
                            min: 0
                        }));
                        xAxis.children.push(
                            am5.Label.new(root, {
                                text: "Total Number",
                                x: am5.p50,
                                centerX: am5.p50
                            })
                        );


                        // Add series
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                        function createSeries(field, name) {
                            var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                                name: name,
                                xAxis: xAxis,
                                yAxis: yAxis,
                                valueXField: field,
                                categoryYField: "age",
                                sequencedInterpolation: true,
                                tooltip: am5.Tooltip.new(root, {
                                    pointerOrientation: "horizontal",
                                    labelText: "[bold]{name}[/] - {categoryY}: {valueX}"
                                })
                            }));

                            series.columns.template.setAll({
                                height: am5.p100
                            });


                            series.bullets.push(function() {
                                return am5.Bullet.new(root, {
                                    locationX: 1,
                                    locationY: 0.5,
                                    sprite: am5.Label.new(root, {
                                        centerY: am5.p50,
                                        text: "{valueX}",
                                        populateText: true
                                    })
                                });
                            });

                            series.bullets.push(function() {
                                return am5.Bullet.new(root, {
                                    locationX: 1,
                                    locationY: 0.5,
                                    sprite: am5.Label.new(root, {
                                        centerX: am5.p100,
                                        centerY: am5.p50,
                                        // text: "{name}",
                                        fill: am5.color(0xffffff),
                                        populateText: true
                                    })
                                });
                            });

                            series.data.setAll(data);
                            series.appear();

                            return series;
                        }

                        // for (var i = 0; i < response[0].length; i++) {
                       // console.log(response[0].length);
                        // if (i === 0) {
                        //   console.log("The first index is: " + response[i]);
                        //   break;
                        // }
                        // }
                        for (const [key, value] of Object.entries(response[0])) {
                           // console.log(`: ${value}`);
                            if (key != 'age') {
                                createSeries(key, key);
                            }
                        }





                        // Add legend
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
                        var legend = chart.children.push(am5.Legend.new(root, {
                            centerX: am5.p50,
                            x: am5.p50
                        }));

                        legend.data.setAll(chart.series.values);


                        // Add cursor
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
                            behavior: "zoomY"
                        }));
                        cursor.lineY.set("forceHidden", true);
                        cursor.lineX.set("forceHidden", true);


                        // Make stuff animate on load
                        // https://www.amcharts.com/docs/v5/concepts/animations/
                        chart.appear(1000, 100);

                    }); // end am5.ready()
                },
                error: function(error) {
                    console.log("Error loading data from URL");
                    console.log(error);
                }
            });
        });
    </script>

    {{-- ADR Money --}}
    <script>
        $(document).ready(function() {

            $("#AdrFilterForm").submit(function(event) {
                event.preventDefault();
                event.stopPropagation();

                var region_id = $('#adr_region_id').val();
                var division_id = $('#adr_division_id').val();
                var district_id = $('#adr_district_id').val();
                var upazila_id = $('#adr_upazila_id').val();
                var adr_year = $('#adr_year').val();
                // var adr_from_date   = $('#adr_from_date').val();
                // var adr_to_date     = $('#adr_to_date').val();
                var token = $('#token').val();
                // console.log(token);
                $.ajax({
                    type: "POST",
                    data: {
                        _token: token,
                        region_id: region_id,
                        division_id: division_id,
                        district_id: district_id,
                        upazila_id: upazila_id,
                        adr_year: adr_year
                        // from_date:adr_from_date,
                        // to_date:adr_to_date
                    },
                    url: "{{ route('filterAdrData') }}",
                    success: function(response) {
                        // console.log("Data successfully loaded from URL");
                        //console.log(response);
                        if (adr_previous != null) {
                            adr_previous.dispose();
                        }

                        am5.ready(function() {
                            root_adr = am5.Root.new("chartdiv2");
                            adr_previous = root_adr;

                            root_adr.setThemes([am5themes_Animated.new(root_adr)]);
                            var chart = root_adr.container.children.push(
                                am5xy.XYChart.new(root_adr, {
                                    panX: false,
                                    panY: false,
                                    // wheelX: "panX",
                                    // wheelY: "zoomX",
                                    layout: root_adr.verticalLayout
                                })
                            );
                            chart.set(
                                "scrollbarX",
                                am5.Scrollbar.new(root_adr, {
                                    orientation: "horizontal"
                                })
                            );
                            // For Export
                            var exporting = am5plugins_exporting.Exporting.new(
                            root_adr, {
                                menu: am5plugins_exporting.ExportingMenu.new(
                                    root_adr, {})
                            });
                            exporting.get("menu").set("items", [{
                                type: "format",
                                format: "png",
                                label: "Export image"
                            }]);

                            var data = response;
                            var xRenderer = am5xy.AxisRendererX.new(root_adr, {
                                minGridDistance: 30
                            });
                            var xAxis = chart.xAxes.push(
                                am5xy.CategoryAxis.new(root_adr, {
                                    categoryField: "month",
                                    renderer: xRenderer,
                                    tooltip: am5.Tooltip.new(root_adr, {})
                                })
                            );
                            xRenderer.grid.template.setAll({
                                location: 1
                            })
                            xAxis.children.push(
                                am5.Label.new(root_adr, {
                                    text: "Month",
                                    x: am5.p50,
                                    centerX: am5.p50
                                })
                            );

                            xAxis.data.setAll(data);

                            var yAxis = chart.yAxes.push(
                                am5xy.ValueAxis.new(root_adr, {
                                    min: 0,
                                    extraMax: 0.1,
                                    renderer: am5xy.AxisRendererY.new(
                                    root_adr, {
                                        strokeOpacity: 0.1
                                    })
                                })
                            );

                            yAxis.children.unshift(
                                am5.Label.new(root_adr, {
                                    rotation: -90,
                                    text: "Money Recovered (BDT)",
                                    y: am5.p50,
                                    centerX: am5.p50
                                })
                            );

                            var series2 = chart.series.push(
                                am5xy.LineSeries.new(root_adr, {
                                    name: "Through ADR - " + adr_year,
                                    xAxis: xAxis,
                                    yAxis: yAxis,
                                    valueYField: "money",
                                    categoryXField: "month",
                                    tooltip: am5.Tooltip.new(root_adr, {
                                        pointerOrientation: "horizontal",
                                        labelText: "{name} in {categoryX}: {valueY} {info}"
                                    })
                                })
                            );

                            series2.strokes.template.setAll({
                                strokeWidth: 3,
                                templateField: "strokeSettings"
                            });


                            series2.data.setAll(data);

                            series2.bullets.push(function() {
                                return am5.Bullet.new(root_adr, {
                                    sprite: am5.Circle.new(root_adr, {
                                        strokeWidth: 3,
                                        stroke: series2.get(
                                            "stroke"),
                                        radius: 5,
                                        fill: root_adr
                                            .interfaceColors
                                            .get("background")
                                    })
                                });
                            });

                            chart.set("cursor", am5xy.XYCursor.new(root_adr, {}));
                            var legend = chart.children.push(
                                am5.Legend.new(root_adr, {
                                    centerX: am5.p50,
                                    x: am5.p50
                                })
                            );
                            legend.data.setAll(chart.series.values);
                            chart.appear(1000, 100);
                        });

                    },
                    error: function(error) {
                        console.log("Error loading data from URL");
                        console.log(error);
                    }
                });
                document.getElementById('adr_modal_close').click();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('adrMoney') }}",
                success: function(response) {
                    // console.log("Data successfully loaded from URL");
                    //console.log(response);
                    am5.ready(function() {
                        // var root = am5.Root.new("chartdiv2");
                        adr_previous = root_adr;

                        root_adr.setThemes([am5themes_Animated.new(root_adr)]);
                        var chart = root_adr.container.children.push(
                            am5xy.XYChart.new(root_adr, {
                                panX: false,
                                panY: false,
                                // wheelX: "panX",
                                // wheelY: "zoomX",
                                layout: root_adr.verticalLayout
                            })
                        );
                        chart.set(
                            "scrollbarX",
                            am5.Scrollbar.new(root_adr, {
                                orientation: "horizontal"
                            })
                        );
                        // For Export
                        var exporting = am5plugins_exporting.Exporting.new(root_adr, {
                            menu: am5plugins_exporting.ExportingMenu.new(root_adr, {})
                        });
                        exporting.get("menu").set("items", [{
                            type: "format",
                            format: "png",
                            label: "Export image"
                        }]);

                        var data = response;
                        var xRenderer = am5xy.AxisRendererX.new(root_adr, {
                            minGridDistance: 30
                        });

                        var xAxis = chart.xAxes.push(
                            am5xy.CategoryAxis.new(root_adr, {
                                categoryField: "month",
                                renderer: xRenderer,
                                tooltip: am5.Tooltip.new(root_adr, {})
                            })
                        );
                        xRenderer.grid.template.setAll({
                            location: 1
                        })
                        xAxis.children.push(
                            am5.Label.new(root_adr, {
                                text: "Month",
                                x: am5.p50,
                                centerX: am5.p50
                            })
                        );

                        xAxis.data.setAll(data);

                        // yAxis
                        var yAxis = chart.yAxes.push(
                            am5xy.ValueAxis.new(root_adr, {
                                min: 0,
                                extraMax: 0.1,
                                renderer: am5xy.AxisRendererY.new(root_adr, {
                                    strokeOpacity: 0.1
                                })
                            })
                        );
                        yAxis.children.unshift(
                            am5.Label.new(root_adr, {
                                rotation: -90,
                                text: "Money Recovered (BDT)",
                                y: am5.p50,
                                centerX: am5.p50
                            })
                        );

                        const date = new Date();
                        const currentYear = date.getFullYear();
                        var series2 = chart.series.push(
                            am5xy.LineSeries.new(root_adr, {
                                name: "Through ADR - " + currentYear,
                                xAxis: xAxis,
                                yAxis: yAxis,
                                valueYField: "money",
                                categoryXField: "month",
                                tooltip: am5.Tooltip.new(root_adr, {
                                    pointerOrientation: "horizontal",
                                    labelText: "{name} in {categoryX}: {valueY} {info}"
                                })
                            })
                        );

                        series2.strokes.template.setAll({
                            strokeWidth: 3,
                            templateField: "strokeSettings"
                        });


                        series2.data.setAll(data);

                        series2.bullets.push(function() {
                            return am5.Bullet.new(root_adr, {
                                sprite: am5.Circle.new(root_adr, {
                                    strokeWidth: 3,
                                    stroke: series2.get("stroke"),
                                    radius: 5,
                                    fill: root_adr.interfaceColors.get(
                                        "background")
                                })
                            });
                        });

                        chart.set("cursor", am5xy.XYCursor.new(root_adr, {}));
                        var legend = chart.children.push(
                            am5.Legend.new(root_adr, {
                                centerX: am5.p50,
                                x: am5.p50
                            })
                        );
                        legend.data.setAll(chart.series.values);
                        chart.appear(1000, 100);
                    });
                },
                error: function(error) {
                    console.log("Error loading data from URL");
                    console.log(error);
                }
            });
        });
    </script>

    {{-- Top Violence Money --}}
    <script>
        $(document).ready(function() {

            $("#TopViolenceFilterForm").submit(function(event) {
                event.preventDefault();
                event.stopPropagation();

                var region_id = $('#violence_region_id').val();
                var division_id = $('#violence_division_id').val();
                var district_id = $('#violence_district_id').val();
                var upazila_id = $('#violence_upazila_id').val();
                var violence_id = $('#violence_violence_id').val();
                var violence_from_date = $('#violence_from_date').val();
                var violence_to_date = $('#violence_to_date').val();
                var token = $('#token').val();
                // console.log(token);
                $.ajax({
                    type: "POST",
                    data: {
                        _token: token,
                        region_id: region_id,
                        division_id: division_id,
                        district_id: district_id,
                        upazila_id: upazila_id,
                        violence_id: violence_id,
                        from_date: violence_from_date,
                        to_date: violence_to_date
                    },
                    url: "{{ route('filterTopViolence') }}",
                    success: function(response) {
                        // console.log("Data successfully loaded from URL");
                       // console.log(response);
                        $('#top_filter_date_display').html(violence_from_date + ' - '+ violence_to_date );

                        if (violence_previous != null) {
                            violence_previous.dispose();
                        }

                        am5.ready(function() {
                            root_violence = am5.Root.new("chartdiv3");
                            violence_previous = root_violence;
                            root.setThemes([
                                am5themes_Animated.new(root_violence)
                            ]);
                            // For Export
                            var exporting = am5plugins_exporting.Exporting.new(
                                root_violence, {
                                    menu: am5plugins_exporting.ExportingMenu.new(
                                        root_violence, {})
                                });
                            exporting.get("menu").set("items", [{
                                type: "format",
                                format: "png",
                                label: "Export image"
                            }]);

                            var chart = root_violence.container.children.push(am5percent
                                .PieChart.new(root_violence, {
                                    layout: root_violence.verticalLayout
                                }));

                            var series = chart.series.push(am5percent.PieSeries.new(
                                root_violence, {
                                    valueField: "value",
                                    categoryField: "category"
                                }));

                            series.data.setAll(response);
                            series.labels.template.setAll({
                                oversizedBehavior: "wrap", // You can replace it with "truncate".
                                maxWidth: 150, // Play with it and see what happens...
                                textAlign: "left",
                                text: "{category}: {value}"
                            });

                            var legend = chart.children.push(am5.Legend.new(
                                root_violence, {
                                    centerX: am5.percent(50),
                                    x: am5.percent(50),
                                    marginTop: 15,
                                    marginBottom: 15
                                }));

                            legend.data.setAll(series.dataItems);


                            series.appear(1000, 100);

                        });

                    },
                    error: function(error) {
                        console.log("Error loading data from URL");
                        console.log(error);
                    }
                });
                document.getElementById('violence_modal_close').click();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('topViolence') }}",
                success: function(response) {
                    // console.log("Data successfully loaded from URL");
                   //console.log(response);
                    am5.ready(function() {
                        // var root = am5.Root.new("chartdiv3");
                        violence_previous = root_violence;

                        root_violence.setThemes([
                            am5themes_Animated.new(root_violence)
                        ]);
                        // For Export
                        var exporting = am5plugins_exporting.Exporting.new(root_violence, {
                            menu: am5plugins_exporting.ExportingMenu.new(
                            root_violence, {})
                        });
                        exporting.get("menu").set("items", [{
                            type: "format",
                            format: "png",
                            label: "Export image"
                        }]);

                        var chart = root_violence.container.children.push(am5percent.PieChart
                            .new(root_violence, {
                                layout: root_violence.verticalLayout
                            }));

                        root_violence.interfaceColors.set("grid", am5.color(0x50b300));

                        var series = chart.series.push(am5percent.PieSeries.new(root_violence, {
                            valueField: "value",
                            categoryField: "category"

                        }));
                        // series.labels.template.maxWidth = 13;
                        // series.labels.template.wrap = true;

                        series.data.setAll(response);
                        series.labels.template.setAll({
                            oversizedBehavior: "wrap", // You can replace it with "truncate".
                            maxWidth: 150, // Play with it and see what happens...
                            textAlign: "left",
                            text: "{category}: {value}"
                        });

                        var legend = chart.children.push(am5.Legend.new(root_violence, {
                            centerX: am5.percent(50),
                            x: am5.percent(50),
                            marginTop: 15,
                            marginBottom: 15
                        }));

                        legend.data.setAll(series.dataItems);


                        series.appear(1000, 100);

                    });
                },
                error: function(error) {
                    console.log("Error loading data from URL");
                    console.log(error);
                }
            });
        });
    </script>

    {{-- early age of marriage --}}
    <script>
        $(document).ready(function() {

            $("#MarriageFilterForm").submit(function(event) {
                event.preventDefault();
                event.stopPropagation();

                var region_id = $('#marriage_region_id').val();
                var division_id = $('#marriage_division_id').val();
                var district_id = $('#marriage_district_id').val();
                var upazila_id = $('#marriage_upazila_id').val();
                var from_date = $('#marriage_from_date').val();
                var to_date = $('#marriage_to_date').val();
                var token = $('#token').val();
                // console.log(token);
                $.ajax({
                    type: "POST",
                    data: {
                        _token: token,
                        region_id: region_id,
                        division_id: division_id,
                        district_id: district_id,
                        upazila_id: upazila_id,
                        from_date: from_date,
                        to_date: to_date
                    },
                    url: "{{ route('filterSurvivorAge') }}",
                    success: function(response) {
                        // console.log("Data successfully loaded from URL");
                        //console.log(response);
                        $('#early_age_date_display').html(from_date +" - "+to_date);

                        if (marriage_previous != null) {
                            marriage_previous.dispose();
                        }

                        am5.ready(function() {

                            // Create root element
                            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                            root_marriage = am5.Root.new("chartdiv4");
                            marriage_previous = root_marriage;


                            // Set themes
                            // https://www.amcharts.com/docs/v5/concepts/themes/
                            root_marriage.setThemes([
                                am5themes_Animated.new(root_marriage)
                            ]);

                            // For Export
                            var exporting = am5plugins_exporting.Exporting.new(
                                root_marriage, {
                                    menu: am5plugins_exporting.ExportingMenu.new(
                                        root_marriage, {})
                                });
                            exporting.get("menu").set("items", [{
                                type: "format",
                                format: "png",
                                label: "Export image"
                            }]);
                            // Create chart
                            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                            var chart = root_marriage.container.children.push(am5percent
                                .PieChart.new(root_marriage, {
                                    layout: root_marriage.verticalLayout,
                                    innerRadius: am5.percent(50)
                                }));


                            // Create series
                            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                            var series = chart.series.push(am5percent.PieSeries.new(
                                root_marriage, {
                                    valueField: "value",
                                    categoryField: "category",
                                    alignLabels: false
                                    // legendLabelText: "{category}",
                                    // legendValueText: "{value}"
                                }));

                            series.labels.template.setAll({
                                textType: "circular",
                                centerX: 0,
                                centerY: 0,
                                text: "{category}: {value}"
                            });


                            // Set data
                            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
                            series.data.setAll(response);


                            // Create legend
                            // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
                            var legend = chart.children.push(am5.Legend.new(
                                root_marriage, {
                                    centerX: am5.percent(50),
                                    x: am5.percent(50),
                                    marginTop: 15,
                                    marginBottom: 15,
                                }));

                            legend.data.setAll(series.dataItems);


                            // Play initial series animation
                            // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
                            series.appear(1000, 100);

                        }); // end am5.ready()

                    },
                    error: function(error) {
                        console.log("Error loading data from URL");
                        console.log(error);
                    }
                });
                document.getElementById('marriage_modal_close').click();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('survivorAge') }}",
                success: function(response) {
                    // console.log("Data successfully loaded from URL");
                   // console.log(response);
                    am5.ready(function() {

                        // Create root element
                        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                        // var root = am5.Root.new("chartdiv4");
                        marriage_previous = root_marriage;

                        // Set themes
                        // https://www.amcharts.com/docs/v5/concepts/themes/
                        root_marriage.setThemes([
                            am5themes_Animated.new(root_marriage)
                        ]);

                        // For Export
                        var exporting = am5plugins_exporting.Exporting.new(root_marriage, {
                            menu: am5plugins_exporting.ExportingMenu.new(
                            root_marriage, {})
                        });
                        exporting.get("menu").set("items", [{
                            type: "format",
                            format: "png",
                            label: "Export image"
                        }]);
                        // Create chart
                        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
                        var chart = root_marriage.container.children.push(am5percent.PieChart
                            .new(root_marriage, {
                                layout: root_marriage.verticalLayout,
                                innerRadius: am5.percent(50)
                            }));


                        // Create series
                        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
                        var series = chart.series.push(am5percent.PieSeries.new(root_marriage, {
                            valueField: "value",
                            categoryField: "category",
                            alignLabels: false
                            // legendLabelText: "{category}",
                            // legendValueText: "{value}"
                        }));

                        series.labels.template.setAll({
                            textType: "circular",
                            centerX: 0,
                            centerY: 0,
                            text: "{category}: {value}"
                        });


                        // Set data
                        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
                        series.data.setAll(response);


                        // Create legend
                        // https://www.amcharts.com/docs/v5/charts/percent-charts/legend-percent-series/
                        var legend = chart.children.push(am5.Legend.new(root_marriage, {
                            centerX: am5.percent(50),
                            x: am5.percent(50),
                            marginTop: 15,
                            marginBottom: 15,
                        }));

                        legend.data.setAll(series.dataItems);


                        // Play initial series animation
                        // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
                        series.appear(1000, 100);

                    }); // end am5.ready()
                },
                error: function(error) {
                    console.log("Error loading data from URL");
                    console.log(error);
                }
            });
        });
    </script>

    {{-- survivor education --}}
    <script>
        $(document).ready(function() {

            $("#EducationFilterForm").submit(function(event) {
                event.preventDefault();
                event.stopPropagation();

                var region_id = $('#education_region_id').val();
                var division_id = $('#education_division_id').val();
                var district_id = $('#education_district_id').val();
                var upazila_id = $('#education_upazila_id').val();
                var from_date = $('#education_from_date').val();
                var to_date = $('#education_to_date').val();
                var token = $('#token').val();
                // console.log(token);
                $.ajax({
                    type: "POST",
                    data: {
                        _token: token,
                        region_id: region_id,
                        division_id: division_id,
                        district_id: district_id,
                        upazila_id: upazila_id,
                        from_date: from_date,
                        to_date: to_date
                    },
                    url: "{{ route('filterSurvivorEducation') }}",
                    success: function(response) {
                        // console.log("Data successfully loaded from URL");
                        //console.log(response);
                        $('#education_filter_date_display').html(from_date+' - '+to_date);

                        if (education_previous != null) {
                            education_previous.dispose();
                        }

                        am5.ready(function() {

                            // Create root element
                            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                            root_education = am5.Root.new("chartdiv5");
                            education_previous = root_education;

                            // Set themes
                            // https://www.amcharts.com/docs/v5/concepts/themes/
                            root_education.setThemes([
                                am5themes_Animated.new(root_education)
                            ]);

                            // For Export
                            var exporting = am5plugins_exporting.Exporting.new(
                                root_education, {
                                    menu: am5plugins_exporting.ExportingMenu.new(
                                        root_education, {})
                                });

                            exporting.get("menu").set("items", [{
                                type: "format",
                                format: "png",
                                label: "Export image"
                            }]);
                            // Create chart
                            // https://www.amcharts.com/docs/v5/charts/xy-chart/
                            var chart = root_education.container.children.push(am5xy
                                .XYChart.new(root_education, {
                                    panX: true,
                                    panY: true,
                                    // wheelX: "panX",
                                    // wheelY: "zoomX",
                                    pinchZoomX: true
                                }));

                            // Add cursor
                            // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                            var cursor = chart.set("cursor", am5xy.XYCursor.new(
                                root_education, {}));
                            cursor.lineY.set("visible", false);


                            // Create axes
                            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                            var xRenderer = am5xy.AxisRendererX.new(root_education, {
                                minGridDistance: 30
                            });
                            xRenderer.labels.template.setAll({
                                rotation: -90,
                                centerY: am5.p50,
                                centerX: am5.p100,
                                paddingRight: 15
                            });

                            xRenderer.grid.template.setAll({
                                location: 1
                            })

                            var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(
                                root_education, {
                                    maxDeviation: 0.3,
                                    categoryField: "country",
                                    renderer: xRenderer,
                                    tooltip: am5.Tooltip.new(root_education, {})
                                }));

                            xAxis.children.push(
                                am5.Label.new(root_education, {
                                    text: "Education",
                                    x: am5.p50,
                                    centerX: am5.p50
                                })
                            );

                            var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(
                                root_education, {
                                    maxDeviation: 0.3,
                                    renderer: am5xy.AxisRendererY.new(
                                        root_education, {
                                            strokeOpacity: 0.1
                                        })
                                }));

                            yAxis.children.unshift(
                                am5.Label.new(root_education, {
                                    rotation: -90,
                                    text: "No. of Person",
                                    y: am5.p50,
                                    centerX: am5.p50
                                })
                            );


                            // Create series
                            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                            var series = chart.series.push(am5xy.ColumnSeries.new(
                                root_education, {
                                    name: "Series 1",
                                    xAxis: xAxis,
                                    yAxis: yAxis,
                                    valueYField: "value",
                                    sequencedInterpolation: true,
                                    categoryXField: "country",
                                    tooltip: am5.Tooltip.new(root_education, {
                                        labelText: "{valueY}"
                                    })
                                }));

                            series.columns.template.setAll({
                                cornerRadiusTL: 5,
                                cornerRadiusTR: 5,
                                strokeOpacity: 0
                            });
                            series.columns.template.adapters.add("fill", function(fill,
                                target) {
                                return chart.get("colors").getIndex(series
                                    .columns.indexOf(target));
                            });

                            series.columns.template.adapters.add("stroke", function(
                                stroke, target) {
                                return chart.get("colors").getIndex(series
                                    .columns.indexOf(target));
                            });


                            // Set data
                            var data = response;

                            xAxis.data.setAll(data);
                            series.data.setAll(data);


                            // Make stuff animate on load
                            // https://www.amcharts.com/docs/v5/concepts/animations/
                            series.appear(1000);
                            chart.appear(1000, 100);

                        }); // end am5.ready()

                    },
                    error: function(error) {
                        console.log("Error loading data from URL");
                        console.log(error);
                    }
                });
                document.getElementById('education_modal_close').click();
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('survivorEducation') }}",
                success: function(response) {
                    // console.log("Data successfully loaded from URL");
                    //console.log(response);
                    am5.ready(function() {

                        // Create root element
                        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                        // var root = am5.Root.new("chartdiv5");
                        education_previous = root_education;

                        // Set themes
                        // https://www.amcharts.com/docs/v5/concepts/themes/
                        root_education.setThemes([
                            am5themes_Animated.new(root_education)
                        ]);

                        // For Export
                        var exporting = am5plugins_exporting.Exporting.new(root_education, {
                            menu: am5plugins_exporting.ExportingMenu.new(
                            root_education, {})
                        });

                        exporting.get("menu").set("items", [{
                            type: "format",
                            format: "png",
                            label: "Export image"
                        }]);
                        // Create chart
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/
                        var chart = root_education.container.children.push(am5xy.XYChart.new(
                            root_education, {
                                panX: true,
                                panY: true,
                                // wheelX: "panX",
                                // wheelY: "zoomX",
                                pinchZoomX: true
                            }));

                        // Add cursor
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                        var cursor = chart.set("cursor", am5xy.XYCursor.new(
                        root_education, {}));
                        cursor.lineY.set("visible", false);


                        // Create axes
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                        var xRenderer = am5xy.AxisRendererX.new(root_education, {
                            minGridDistance: 30
                        });
                        xRenderer.labels.template.setAll({
                            rotation: -90,
                            centerY: am5.p50,
                            centerX: am5.p100,
                            paddingRight: 15
                        });

                        xRenderer.grid.template.setAll({
                            location: 1
                        })

                        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root_education, {
                            maxDeviation: 0.3,
                            categoryField: "country",
                            renderer: xRenderer,
                            tooltip: am5.Tooltip.new(root_education, {})
                        }));

                        xAxis.children.push(
                            am5.Label.new(root_education, {
                                text: "Education",
                                x: am5.p50,
                                centerX: am5.p50
                            })
                        );

                        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root_education, {
                            maxDeviation: 0.3,
                            renderer: am5xy.AxisRendererY.new(root_education, {
                                strokeOpacity: 0.1
                            })
                        }));

                        yAxis.children.unshift(
                            am5.Label.new(root_education, {
                                rotation: -90,
                                text: "No. of Person",
                                y: am5.p50,
                                centerX: am5.p50
                            })
                        );
                        // Create series
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                        var series = chart.series.push(am5xy.ColumnSeries.new(root_education, {
                            name: "Series 1",
                            xAxis: xAxis,
                            yAxis: yAxis,
                            valueYField: "value",
                            sequencedInterpolation: true,
                            categoryXField: "country",
                            tooltip: am5.Tooltip.new(root_education, {
                                labelText: "{valueY}"
                            })
                        }));

                        series.columns.template.setAll({
                            cornerRadiusTL: 5,
                            cornerRadiusTR: 5,
                            strokeOpacity: 0
                        });
                        series.columns.template.adapters.add("fill", function(fill, target) {
                            return chart.get("colors").getIndex(series.columns.indexOf(
                                target));
                        });

                        series.columns.template.adapters.add("stroke", function(stroke,
                        target) {
                            return chart.get("colors").getIndex(series.columns.indexOf(
                                target));
                        });


                        // Set data
                        var data = response;

                        xAxis.data.setAll(data);
                        series.data.setAll(data);


                        // Make stuff animate on load
                        // https://www.amcharts.com/docs/v5/concepts/animations/
                        series.appear(1000);
                        chart.appear(1000, 100);

                    }); // end am5.ready()
                },
                error: function(error) {
                    console.log("Error loading data from URL");
                    console.log(error);
                }
            });
        });
    </script>

    {{-- Defendant Education --}}

    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('defendantEducation') }}",
                success: function(response) {
                    // console.log("Data successfully loaded from URL");
                    //console.log(response);
                    am5.ready(function() {

                        // Create root element
                        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                        var root = am5.Root.new("chartdiv6");


                        // Set themes
                        // https://www.amcharts.com/docs/v5/concepts/themes/
                        root.setThemes([
                            am5themes_Animated.new(root)
                        ]);

                        // For Export
                        var exporting = am5plugins_exporting.Exporting.new(root, {
                            menu: am5plugins_exporting.ExportingMenu.new(root, {})
                        });
                        exporting.get("menu").set("items", [{
                            type: "format",
                            format: "png",
                            label: "Export image"
                        }]);

                        // Create chart
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/
                        var chart = root.container.children.push(am5xy.XYChart.new(root, {
                            panX: true,
                            panY: true,
                            // wheelX: "panX",
                            // wheelY: "zoomX",
                            pinchZoomX: true
                        }));

                        // Add cursor
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                        cursor.lineY.set("visible", false);


                        // Create axes
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                        var xRenderer = am5xy.AxisRendererX.new(root, {
                            minGridDistance: 30
                        });
                        xRenderer.labels.template.setAll({
                            rotation: -90,
                            centerY: am5.p50,
                            centerX: am5.p100,
                            paddingRight: 15
                        });

                        xRenderer.grid.template.setAll({
                            location: 1
                        })

                        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                            maxDeviation: 0.3,
                            categoryField: "country",
                            renderer: xRenderer,
                            tooltip: am5.Tooltip.new(root, {})
                        }));

                        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                            maxDeviation: 0.3,
                            renderer: am5xy.AxisRendererY.new(root, {
                                strokeOpacity: 0.1
                            })
                        }));


                        // Create series
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                            name: "Series 1",
                            xAxis: xAxis,
                            yAxis: yAxis,
                            valueYField: "value",
                            sequencedInterpolation: true,
                            categoryXField: "country",
                            tooltip: am5.Tooltip.new(root, {
                                labelText: "{valueY}"
                            })
                        }));

                        series.columns.template.setAll({
                            cornerRadiusTL: 5,
                            cornerRadiusTR: 5,
                            strokeOpacity: 0
                        });
                        series.columns.template.adapters.add("fill", function(fill, target) {
                            return chart.get("colors").getIndex(series.columns.indexOf(
                                target));
                        });

                        series.columns.template.adapters.add("stroke", function(stroke,
                        target) {
                            return chart.get("colors").getIndex(series.columns.indexOf(
                                target));
                        });


                        // Set data
                        var data = response;

                        xAxis.data.setAll(data);
                        series.data.setAll(data);


                        // Make stuff animate on load
                        // https://www.amcharts.com/docs/v5/concepts/animations/
                        series.appear(1000);
                        chart.appear(1000, 100);

                    }); // end am5.ready()
                },
                error: function(error) {
                    console.log("Error loading data from URL");
                    console.log(error);
                }
            });
        });
    </script>

    {{-- Defendant Occupation --}}

    <script>
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ route('defendantOccupation') }}",
                success: function(response) {
                    // console.log("Data successfully loaded from URL");
                    //console.log(response);
                    am5.ready(function() {

                        // Create root element
                        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
                        var root = am5.Root.new("chartdiv7");


                        // Set themes
                        // https://www.amcharts.com/docs/v5/concepts/themes/
                        root.setThemes([
                            am5themes_Animated.new(root)
                        ]);

                        // For Export
                        var exporting = am5plugins_exporting.Exporting.new(root, {
                            menu: am5plugins_exporting.ExportingMenu.new(root, {})
                        });
                        exporting.get("menu").set("items", [{
                                type: "format",
                                format: "png",
                                label: "Export image"
                            }
                            // , {
                            //   type: "format",
                            //   format: "csv",
                            //   label: "Export CSV"
                            // }, {
                            //   type: "separator"
                            // }, {
                            //   type: "format",
                            //   format: "print",
                            //   label: "Print"
                            // }
                        ]);
                        // Create chart
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/
                        var chart = root.container.children.push(am5xy.XYChart.new(root, {
                            panX: true,
                            panY: true,
                            // wheelX: "panX",
                            // wheelY: "zoomX",
                            pinchZoomX: true
                        }));

                        // Add cursor
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
                        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
                        cursor.lineY.set("visible", false);


                        // Create axes
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
                        var xRenderer = am5xy.AxisRendererX.new(root, {
                            minGridDistance: 30
                        });
                        xRenderer.labels.template.setAll({
                            rotation: -90,
                            centerY: am5.p50,
                            centerX: am5.p100,
                            paddingRight: 15
                        });

                        xRenderer.grid.template.setAll({
                            location: 1
                        })

                        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                            maxDeviation: 0.3,
                            categoryField: "country",
                            renderer: xRenderer,
                            tooltip: am5.Tooltip.new(root, {})
                        }));

                        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                            maxDeviation: 0.3,
                            renderer: am5xy.AxisRendererY.new(root, {
                                strokeOpacity: 0.1
                            })
                        }));


                        // Create series
                        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
                        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                            name: "Series 1",
                            xAxis: xAxis,
                            yAxis: yAxis,
                            valueYField: "value",
                            sequencedInterpolation: true,
                            categoryXField: "country",
                            tooltip: am5.Tooltip.new(root, {
                                labelText: "{valueY}"
                            })
                        }));

                        series.columns.template.setAll({
                            cornerRadiusTL: 5,
                            cornerRadiusTR: 5,
                            strokeOpacity: 0
                        });
                        series.columns.template.adapters.add("fill", function(fill, target) {
                            return chart.get("colors").getIndex(series.columns.indexOf(
                                target));
                        });

                        series.columns.template.adapters.add("stroke", function(stroke,
                        target) {
                            return chart.get("colors").getIndex(series.columns.indexOf(
                                target));
                        });


                        // Set data
                        var data = response;

                        xAxis.data.setAll(data);
                        series.data.setAll(data);


                        // Make stuff animate on load
                        // https://www.amcharts.com/docs/v5/concepts/animations/
                        series.appear(1000);
                        chart.appear(1000, 100);

                    }); // end am5.ready()
                },
                error: function(error) {
                    console.log("Error loading data from URL");
                    console.log(error);
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(function() {
            $('.modaldatepicker').daterangepicker({
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

    {{-- First six item  --}}
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
                       // console.log(data);
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

    {{-- Age Range  --}}
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#age_region_id', function() {
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
                        $('#age_division_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#age_division_id', function() {
                var region_id = $('#age_region_id').val();
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
                        $('#age_district_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#age_district_id', function() {
                var district_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-region-upazila') }}",
                    type: "GET",
                    data: {
                        district_id: district_id
                    },
                    success: function(data) {
                       // console.log(data);
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
                        $('#age_upazila_id').html(html);
                    }
                });
            });
        });
    </script>

    {{-- Adr  --}}
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#adr_region_id', function() {
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
                        $('#adr_division_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#adr_division_id', function() {
                var region_id = $('#adr_region_id').val();
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
                        $('#adr_district_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#adr_district_id', function() {
                var district_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-region-upazila') }}",
                    type: "GET",
                    data: {
                        district_id: district_id
                    },
                    success: function(data) {
                       // console.log(data);
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
                        $('#adr_upazila_id').html(html);
                    }
                });
            });
        });
    </script>

    {{-- Top Violence  --}}
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#violence_region_id', function() {
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
                        $('#violence_division_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#violence_division_id', function() {
                var region_id = $('#violence_region_id').val();
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
                        $('#violence_district_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#violence_district_id', function() {
                var district_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-region-upazila') }}",
                    type: "GET",
                    data: {
                        district_id: district_id
                    },
                    success: function(data) {
                        //console.log(data);
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
                        $('#violence_upazila_id').html(html);
                    }
                });
            });
        });
    </script>

    {{-- Early age of Marriage  --}}
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#marriage_region_id', function() {
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
                        $('#marriage_division_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#marriage_division_id', function() {
                var region_id = $('#marriage_region_id').val();
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
                        $('#marriage_district_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#marriage_district_id', function() {
                var district_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-region-upazila') }}",
                    type: "GET",
                    data: {
                        district_id: district_id
                    },
                    success: function(data) {
                      //  console.log(data);
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
                        $('#marriage_upazila_id').html(html);
                    }
                });
            });
        });
    </script>

    {{-- Recurrent violence  --}}
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#recurrentviolence_region_id', function() {
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
                        $('#recurrentviolence_division_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#recurrentviolence_division_id', function() {
                var region_id = $('#recurrentviolence_region_id').val();
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
                        $('#recurrentviolence_district_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#recurrentviolence_district_id', function() {
                var district_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-region-upazila') }}",
                    type: "GET",
                    data: {
                        district_id: district_id
                    },
                    success: function(data) {
                        //console.log(data);
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
                        $('#recurrentviolence_upazila_id').html(html);
                    }
                });
            });
        });
    </script>

    {{-- Education  --}}
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#education_region_id', function() {
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
                        $('#education_division_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#education_division_id', function() {
                var region_id = $('#education_region_id').val();
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
                        $('#education_district_id').html(html);
                    }
                });
            });
        });
    </script>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#education_district_id', function() {
                var district_id = $(this).val();
                $.ajax({
                    url: "{{ route('default.get-region-upazila') }}",
                    type: "GET",
                    data: {
                        district_id: district_id
                    },
                    success: function(data) {
                        //console.log(data);
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
                        $('#education_upazila_id').html(html);
                    }
                });
            });
        });
    </script>

@endsection
