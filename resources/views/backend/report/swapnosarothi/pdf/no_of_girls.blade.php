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
                <th colspan="5" class="tg-0pky" style="padding: 0">
                    <table class="table" style="margin-bottom: 0;">
                        <tr>
                            <th colspan="5" class="tg-0pky" style="border-left:0; border-right:0; border-top:0">{{ @$title }}</th>
                        </tr>
                        <tr>
                            <th class="tg-0pky" style="max-width:20%; border-left:0">Ongoing <br> 1 </th>
                            <th class="tg-0pky" style="width:20%">Married <br> 2</th>
                            <th class="tg-0pky" style="width:20%">Migrated <br> 3</th>
                            <th class="tg-0pky" style="width:20%; border-right:0">Dropout <br> 4</th>
                            <th class="tg-0pky" style="width:20%; border-right:0">Graduated <br> 5</th>
                        </tr>
                    </table>
                </th>
                <th class="tg-0pky" style="background-color: #e6e5e5; vertical-align: middle">Total <br> (1+2+3+4+5) </th>
            </tr>
        </thead>

        <tbody>
            @php
                $ongoing = 0;
                $married = 0;
                $migrated = 0;
                $dropout = 0;
                $graduated = 0;
                $total = 0;
            @endphp


            @if (!empty($array_data))
                @foreach ($array_data['division'] as $div_key => $division_list)
                    @foreach ($division_list['district'] as $dis_key => $district_list)
                        @foreach ($district_list['upazila'] as $upa_key => $upazila_list)
                            @foreach ($upazila_list['group'] as $group_key => $group_list)
                                <tr>
                                    @php
                                        $ongoing += @$group_list['ongoing'];
                                        $married += @$group_list['married'];
                                        $migrated += @$group_list['migrated'];
                                        $dropout += @$group_list['droupout'];
                                        $graduated += @$group_list['graduated'];
                                        $total += @$group_list['total'];
                                    @endphp
                                    <td>{{ $group_list['zone'] }}</td>
                                    <td>{{ $division_list['name'] }}</td>
                                    <td>{{ $district_list['name'] }}</td>
                                    <td>{{ $upazila_list['name'] }}</td>
                                    <td>{{ $group_list['name'] }}</td>

                                    <td colspan="5" class="tg-0pky" style="padding: 0">
                                        <table style="margin-bottom: 0; width:100%;">
                                            <tr style="border:0">
                                                <td class="tg-0pky" style="max-width:20%; border-left:0">
                                                    {{ @$group_list['ongoing'] }}
                                                </td>
                                                <td class="tg-0pky" style="width:20%;">
                                                    {{ @$group_list['married'] }}
                                                </td>
                                                <td class="tg-0pky" style="width:20%;">
                                                    {{ @$group_list['migrated'] }}
                                                </td>
                                                <td class="tg-0pky" style="width:20%; border-right:0">
                                                    {{ @$group_list['droupout'] }}
                                                </td>
                                                <td class="tg-0pky" style="width:20%; border-right:0">
                                                    {{ @$group_list['graduated'] }}
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
                    {{ @$ongoing }}
                </td>
                <td style="background-color: #ffe9e9">
                    {{ @$married }}
                </td>
                <td style="background-color: #ffe9e9">
                    {{ @$migrated }}
                </td>
                <td style="background-color: #ffe9e9">
                    {{ @$dropout }}
                </td>
                <td style="background-color: #ffe9e9">
                    {{ @$graduated }}
                </td>
                <td style="background-color: #000000; color:#fff;font-size: 14px; font-weight:bold">
                    {{ @$total }}
                </td>
            </tr>
        </tbody>
    </table>
@endsection
