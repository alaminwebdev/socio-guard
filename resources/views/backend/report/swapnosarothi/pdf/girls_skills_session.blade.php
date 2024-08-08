@extends('selp.layouts.test_report_header')
@section('content')
    <style>
        td {
            border: 1px solid #ddd;
        }
    </style>
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
                <th class="tg-0pky" width="100" style="vertical-align: middle" rowspan="2">Zone</th>
                <th class="tg-0pky" width="100" style="vertical-align: middle" rowspan="2">Division</th>
                <th class="tg-0pky" width="100" style="vertical-align: middle" rowspan="2">District</th>
                <th class="tg-0pky" width="120" style="vertical-align: middle" rowspan="2">Upazila</th>
                <th class="tg-0pky" width="120" style="vertical-align: middle" rowspan="2">Group</th>
                <th class="tg-0pky" width="120" style="vertical-align: middle" colspan="{{ count($swapnosarothi_skills) }}">{{ @$title }}</th>
            <tr>
                @foreach ($swapnosarothi_skills as $swapnosarothi_skill)
                    <th style="vertical-align: middle; border-left:0; border-bottom:0; border-top:0; ">
                        Skill - {{ $loop->iteration }}
                    </th>
                @endforeach
            </tr>
            </tr>
        </thead>

        <tbody>
            @php
                $groupedByDivision = $array_data->groupBy('employee_division_id');
            @endphp

            @foreach ($groupedByDivision as $divisionId => $divisionGroup)
                @php
                    $divisionName = $divisionGroup->first()->employee_division->name ?? 'Unknown Division';
                    $groupedByDistrict = $divisionGroup->groupBy('employee_district_id');
                @endphp

                @foreach ($groupedByDistrict as $districtId => $districtGroup)
                    @php
                        $districtName = $districtGroup->first()->employee_district->name ?? 'Unknown District';
                        $groupedByUpazila = $districtGroup->groupBy('employee_upazila_id');
                    @endphp

                    @foreach ($groupedByUpazila as $upazilaId => $upazilaGroup)
                        @php
                            $upazilaName = $upazilaGroup->first()->employee_upazila->name ?? 'Unknown Upazila';
                            $groupedByGroup = $upazilaGroup->groupBy('group_id');
                        @endphp

                        @foreach ($groupedByGroup as $groupId => $group)
                            @php
                                $groupName = $group->first()->groupName->group_name ?? 'Unknown Group';
                                $zoneName = $group->first()->employee_zone->region_name ?? 'Unknown Zone';
                            @endphp

                            <tr>
                                <td>{{ $zoneName }}</td>
                                <td>{{ $divisionName }}</td>
                                <td>{{ $districtName }}</td>
                                <td>{{ $upazilaName }}</td>
                                <td>{{ $groupName }}</td>
                                @foreach ($swapnosarothi_skills as $sw_skill)
                                    <td class="text-right" data-toggle="tooltip" data-placement="bottom" title="{{ $sw_skill->name }}">
                                        {{ $group->where('skill_table_id', $sw_skill->id)->sum('total_girls') }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach

            @if ($array_data->isEmpty())
                <tr>
                    <td colspan="{{ count($swapnosarothi_skills) + 5 }}" class="text-center">No Data Found!</td>
                </tr>
            @endif
        </tbody>
    </table>
@endsection
