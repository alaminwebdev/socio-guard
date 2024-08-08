@extends('selp.layouts.test_report_header')
@section('content')
    <p style="color: #0b253a;">
        <b>Zone : {{ @$region }} |</b>&nbsp;
        <b>Division : {{ @$division->name ?? 'All' }} |</b>&nbsp;
        <b>District : {{ @$district->name ?? 'All' }} |</b>&nbsp;
        <b>Upazila : {{ @$upazila->name ?? 'All' }} |</b>&nbsp;
        <b>From Date : {{ @$date_from }}</b>&nbsp;
        <b>To Date : {{ @$date_to }}</b>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="tg-0pky" width="100" style="vertical-align: middle">Zone</th>
                <th class="tg-0pky" width="100" style="vertical-align: middle">Division</th>
                <th class="tg-0pky" width="100" style="vertical-align: middle">District</th>
                <th class="tg-0pky" width="120" style="vertical-align: middle">Upazila</th>
                <th class="tg-0pky" width="120" style="vertical-align: middle">Group</th>
                <th colspan="3" class="tg-0pky" style="padding: 0">
                    <table class="table" style="margin-bottom: 0;">
                        <tr>
                            <th colspan="3" class="tg-0pky" style="border-left:0; border-right:0; border-top:0">{{ @$title }}</th>
                        </tr>
                        <tr>
                            <th class="tg-0pky" style="max-width:30%; border-left:0">Medium Cash <br> 1 </th>
                            <th class="tg-0pky" style="width:30%">Low Cash <br> 2</th>
                            <th class="tg-0pky" style="width:40%">No Cash Support <br> 3</th>
                        </tr>
                    </table>
                </th>
                <th class="tg-0pky" style="background-color: #e6e5e5; vertical-align: middle">Total <br> (1+2+3) </th>
            </tr>
        </thead>

        <tbody>
            @php
                $medium = 0;
                $low = 0;
                $none = 0;
                $total = 0;
            @endphp


            @if (!empty($array_data))
                @foreach ($array_data['division'] as $div_key => $division_list)
                    @foreach ($division_list['district'] as $dis_key => $district_list)
                        @foreach ($district_list['upazila'] as $upa_key => $upazila_list)
                            @foreach ($upazila_list['group'] as $group_key => $group_list)
                                <tr>
                                    @php
                                        $medium += @$group_list['medium'];
                                        $low += @$group_list['low'];
                                        $none += @$group_list['none'];
                                        $total += @$group_list['total'];
                                    @endphp
                                    <td>{{ $group_list['zone'] }}</td>
                                    <td>{{ $division_list['name'] }}</td>
                                    <td>{{ $district_list['name'] }}</td>
                                    <td>{{ $upazila_list['name'] }}</td>
                                    <td>{{ $group_list['name'] }}</td>

                                    <td colspan="3" class="tg-0pky" style="padding: 0">
                                        <table style="margin-bottom: 0; width:100%;">
                                            <tr style="border:0">
                                                <td class="tg-0pky" style="max-width:30%; border-left:0">
                                                    {{ @$group_list['medium'] }}
                                                </td>
                                                <td class="tg-0pky" style="width:30%;">
                                                    {{ @$group_list['low'] }}
                                                </td>
                                                <td class="tg-0pky" style="width:40%;">
                                                    {{ @$group_list['none'] }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td style="background-color: #e6e5e5">
                                        {{ @$group_list['total'] }}
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @endif
            <tr>
                <td style="background-color: #ffe9e9; font-size: 16px;" colspan="5">Total</td>
                <td style="background-color: #ffe9e9; max-width:20%">
                    {{ @$medium }}
                </td>
                <td style="background-color: #ffe9e9">
                    {{ @$low }}
                </td>
                <td style="background-color: #ffe9e9">
                    {{ @$none }}
                </td>
                <td style="background-color: #000000; color:#fff;font-size: 14px; font-weight:bold">
                    {{ @$total }}
                </td>
            </tr>
        </tbody>
    </table>
@endsection
