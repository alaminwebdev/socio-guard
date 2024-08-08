<p style="color: #0b253a;">
    <b>Zone : {{ @$region }} |</b>&nbsp;
    <b>Division : {{ @$division->name ?? 'All' }} |</b>&nbsp;
    <b>District : {{ @$district->name ?? 'All' }} |</b>&nbsp;
    <b>Upazila : {{ @$upazila->name ?? 'All' }} |</b>&nbsp;
    <b>From Date : {{ @$date_from }}</b>&nbsp;
    <b>To Date : {{ @$date_to }}</b>
</p>

<table>
    <thead>
        <tr>
            <th valign="center" rowspan="2"><strong>Zone</strong></th>
            <th valign="center" rowspan="2"><strong>Division</strong></th>
            <th valign="center" rowspan="2"><strong>District</strong></th>
            <th valign="center" rowspan="2"><strong>Upazila</strong></th>
            <th valign="center" rowspan="2"><strong>Group</strong></th>
            <th valign="center" colspan="{{ count($swapnosarothi_skills) }}"><strong>{{ @$title }}</strong></th>
        </tr>
        <tr>
            @foreach ($swapnosarothi_skills as $swapnosarothi_skill)
                <th valign="center">
                    <strong>{{ $swapnosarothi_skill->name }}</strong>
                </th>
            @endforeach
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
