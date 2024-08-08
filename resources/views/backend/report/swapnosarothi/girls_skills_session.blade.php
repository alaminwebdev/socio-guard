<style>
    .table thead,
    .nested-table {
        background: #0b253a !important;
    }

    .table thead tr th {
        color: #f8f9fa !important;
        border-bottom-width: 1px;
        font-size: 12px;
    }
</style>

<div class="mt-3 pt-3 border-top">
    <p style="color: #0b253a;">
        <b>Zone : {{ @$region }} |</b>&nbsp;
        <b>Division : {{ @$division->name ?? 'All' }} |</b>&nbsp;
        <b>District : {{ @$district->name ?? 'All' }} |</b>&nbsp;
        <b>Upazila : {{ @$upazila->name ?? 'All' }} |</b>&nbsp;
        <b>From Date : {{ @$date_from }}</b>&nbsp;
        <b>To Date : {{ @$date_to }}</b>
    </p>

    <table class="table table-bordered table-responsive">
        <thead>
            <tr>
                <th style="vertical-align: middle;" rowspan="2" class="text-center">Zone</th>
                <th style="vertical-align: middle;" rowspan="2" class="text-center">Division</th>
                <th style="vertical-align: middle;" rowspan="2" class="text-center">District</th>
                <th style="vertical-align: middle;" rowspan="2" class="text-center">Upazila</th>
                <th style="vertical-align: middle;" rowspan="2" class="text-center">Group</th>
                <th style="vertical-align: middle;" colspan="{{ count($swapnosarothi_skills) }}" class="text-center">{{ @$title }}</th>
            <tr>
                @foreach ($swapnosarothi_skills as $swapnosarothi_skill)
                    <th style="vertical-align: middle; border-left:0; border-bottom:0; border-top:0; cursor: pointer;" class="text-center" data-toggle="tooltip" data-placement="bottom" title="{{ $swapnosarothi_skill->name }}">
                        Skill - {{ $loop->iteration }}
                    </th>
                @endforeach
            </tr>
            </tr>
        </thead>

        <tbody>
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

        {{-- @if (!empty($array_data))
                @foreach ($array_data['division'] as $div_key => $division_list)
                    @foreach ($division_list['district'] as $dis_key => $district_list)
                        @foreach ($district_list['upazila'] as $upa_key => $upazila_list)
                            @foreach ($upazila_list['group'] as $group_key => $group_list)
                                <tr>
                                    <td>{{ $group_list['zone'] }}</td>
                                    <td>{{ $division_list['name'] }}</td>
                                    <td>{{ $district_list['name'] }}</td>
                                    <td>{{ $upazila_list['name'] }}</td>
                                    <td>{{ $group_list['name'] }}</td>
                                    @foreach ($swapnosarothi_skills as $sw_skill)
                                        <td class="text-right" data-toggle="tooltip" data-placement="bottom" title="{{ $sw_skill->name }}">
                                            {{ $group_list['skill'][$sw_skill->id] ?? 0 }}
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @else
                <tr>
                    <td colspan="{{ count($swapnosarothi_skills) + 6 }}" class="text-center">No Data Found !</td>
                </tr>
            @endif --}}
        </tbody>

    </table>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get all elements with class "parent-td"
        var parentTds = document.querySelectorAll(".parent-td");

        // Loop through each "parent-td" and set the height of the inner table
        parentTds.forEach(function(parentTd) {
            var innerTable = parentTd.querySelector(".inner-table");
            var parentTdHeight = parentTd.clientHeight;

            // Set the height of the inner table in pixels
            innerTable.style.height = parentTdHeight + "px";
        });
    });
</script>
