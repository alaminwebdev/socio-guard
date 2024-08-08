@extends('selp.layouts.test_report_header')
@section('content')
    <p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District :
            {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$date_from }}
            |</b>&nbsp;<b>To Date : {{ @$date_to }}</b></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="120" style="vertical-align: middle">Division</th>
                <th width="120" style="vertical-align: middle">District</th>
                <th width="120" style="vertical-align: middle">Upazila</th>
                <th colspan="2" style="padding: 0">
                    <table class="table" style="margin-bottom: 0;">
                        <tr>
                            <th colspan="2">General</th>
                        </tr>
                        <tr>
                            <th style="width:50%">Girls <br> 1</th>
                            <th style="width:50%; border-right:0">Boys <br> 2</th>
                        </tr>
                    </table>
                </th>
                <th colspan="2" style="padding: 0">
                    <table class="table" style="margin-bottom: 0;">
                        <tr>
                            <th colspan="2">PWD</th>
                        </tr>
                        <tr>
                            <th style="width:50%;">Girls <br> 3</th>
                            <th style="width:50%; border-right:0">Boys <br> 4</th>
                        </tr>
                    </table>

                </th>
                <th style="background-color: #e6e5e5; vertical-align: middle">Total <br> (1+2) </th>
            </tr>
        </thead>

        <tbody>
            @php
                $gGirls = 0;
                $gBoys = 0;
                $pGirls = 0;
                $pBoys = 0;
            @endphp
            @if (!empty($array_data))
                @foreach ($array_data['division'] as $div_key => $division_list)
                    @foreach ($division_list['district'] as $dis_key => $district_list)
                        @foreach ($district_list['upazila'] as $upa_key => $upazila_list)
                            <tr>
                                @php
                                    $gGirls += $upazila_list['g_girl'];
                                    $gBoys += $upazila_list['g_boy'];
                                    $pGirls += $upazila_list['p_girl'];
                                    $pBoys += $upazila_list['p_boy'];
                                    
                                @endphp
                                <td >{{ $division_list['name'] }}</td>
                                <td >{{ $district_list['name'] }}</td>

                                <td >{{ $upazila_list['name'] }}</td>
                                <td colspan="2" style="padding: 0">
                                    <table style="margin-bottom: 0; width:100%;" width="100%">
                                        <tr style="border:0">
                                            <td width="50%">
												{{ $upazila_list['g_girl'] }}
                                            </td>
                                            <td width="50%" style="border-right:0">
                                                {{ $upazila_list['g_boy'] }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td colspan="2" style="padding: 0">
                                    <table style="margin-bottom: 0; width:100%;" width="100%">
                                        <tr style="border:0">
                                            <td width="50%">{{ $upazila_list['p_girl'] }}
                                            </td>
                                            <td width="50%" style="border-right:0">
                                                {{ $upazila_list['p_boy'] }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="background-color: #e6e5e5">
                                    {{ $upazila_list['total'] }} 
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endif

            <tr>

                <td style="background-color: #ffe9e9; font-size: 16px;" colspan="3">Total</td>
                
                <td style="background-color: #ffe9e9">{{ $gGirls }}
                </td>
                <td style="background-color: #ffe9e9">{{ $gBoys }}
                </td>
                <td style="background-color: #ffe9e9">{{ $pGirls }}
                </td>
                <td style="background-color: #ffe9e9">{{ $pBoys }}
                </td>
                <td style="background-color: #000000; color:#fff;font-size: 14px; font-weight:bold">
                    {{ $gGirls + $gBoys }}
                </td>
            </tr>

        </tbody>

    </table>
@endsection
