@php
    $maxCmInitiatives = $profiles->max(function ($profile) {
        return count($profile->cmInitiatives);
    });
@endphp

<table border="1">
    <thead>
        <tr>
            <th><strong>Employee Name</strong></th>
            <th><strong>Employee Mobile No </strong></th>
            <th><strong>Employee Designation </strong></th>
            <th><strong>Employee PIN </strong></th>
            <th><strong>Employee Zone </strong></th>
            <th><strong>Employee Division </strong></th>
            <th><strong>Employee District </strong></th>
            <th><strong>Employee Upazila </strong></th>
            <th><strong>Employee Union </strong></th>
            <th><strong>Group Name </strong></th>
            <th><strong>Group Start </strong></th>
            <th><strong>Group Status </strong></th>

            <th><strong>Profile ID</strong></th>
            <th><strong>Profile Status </strong></th>
            <th><strong>Reason </strong></th>
            <th><strong>Reason Date </strong></th>
            <th><strong>Profile Start </strong></th>
            <th><strong>Girl's Name </strong></th>
            <th><strong>Age </strong></th>
            <th><strong>Date Of Birth </strong></th>

            <th><strong>18 Year's completion Data </strong></th>
            <th><strong>Number </strong></th>
            <th><strong>Types of PWD </strong></th>

            <th><strong>Division </strong></th>
            <th><strong>District </strong></th>
            <th><strong>Upazila </strong></th>

            <th><strong>Union </strong></th>
            <th><strong>Village </strong></th>
            <th><strong>Landmark </strong></th>
            <th><strong>Father's Name </strong></th>
            <th><strong>Mother's Name </strong></th>
            <th><strong>Guardian Name </strong></th>

            <th><strong>Family Member </strong></th>
            <th><strong>Father's Phone </strong></th>
            <th><strong>Mother's Phone </strong></th>

            <th><strong>Father's occupation </strong></th>
            <th><strong>Father's Income </strong></th>
            <th><strong>Mother's Occupation </strong></th>

            <th><strong>Mother Income </strong></th>
            <th><strong>Other Occupation </strong></th>
            <th><strong>Other Income </strong></th>

            <th><strong>Financial beneficiary (Is she financial beneficiary?) </strong></th>
            <th><strong>Amount Of Money </strong></th>


            @if (count($skills) >= 1)
                @foreach ($skills as $skill)
                    <th><strong>Skill Code - ({{ $skill->code }})</strong></th>
                    <th><strong>{{ $skill->name }}</strong></th>
                    <th><strong>Session Date</strong></th>
                @endforeach
            @endif

            @if ($maxCmInitiatives > 0)
                @for ($i = 0; $i < $maxCmInitiatives; $i++)
                    <th><strong>{{ $i + 1 }} : Initiative</strong></th>
                    <th><strong>{{ $i + 1 }} : Prevention Type</strong></th>
                    <th><strong>{{ $i + 1 }} : Prevention</strong></th>
                    <th><strong>{{ $i + 1 }} : Age</strong></th>
                    <th><strong>{{ $i + 1 }} : Date</strong></th>
                @endfor
            @endif

            <th><strong>Marriage Date</strong></th>
            <th><strong>Registration Completed</strong></th>
            <th><strong>Who Registered</strong></th>
            <th><strong>Marriage Place </strong></th>
            <th><strong>Marriage Reason</strong></th>
            <th><strong>Asked by Groom </strong></th>
            <th><strong>Dower Amount</strong></th>
            <th><strong>Initiated Person </strong></th>
            <th><strong>Girl Education</strong></th>
            <th><strong>Studentship Status</strong></th>
            <th><strong>Institution</strong></th>
            <th><strong>Groom's Age</strong></th>
            <th><strong>Groom's Profession</strong></th>
            <th><strong>Groom's Education</strong></th>

        </tr>
    </thead>
    <tbody>
        @foreach ($profiles as $profile)
            @php
                $numInitiatives = count($profile->cmInitiatives);
            @endphp
            <tr>
                <td valign="center">{{ @$profile->employee->name }}</td>
                <td valign="center">{{ @$profile->employee->mobile }}</td>
                <td valign="center">{{ @$profile->employee->designation }}</td>
                <td valign="center">{{ @$profile->employee->pin }}</td>
                <td valign="center">{{ @$profile->employee_zone->region_name }}</td>
                <td valign="center">{{ @$profile->employee_division->name }}</td>
                <td valign="center">{{ @$profile->employee_district->name }}</td>
                <td valign="center">{{ @$profile->employee_upazila->name }}</td>
                <td valign="center">{{ @$profile->employee_union->name }}</td>

                <td valign="center">{{ @$profile->groupName->group_name }}</td>
                <td valign="center">{{ @$profile->groupName->start_date ? @$profile->groupName->start_date->format('d-M-Y') : '' }}</td>
                <td valign="center">{{ @$profile->groupName->status == 1 ? 'Active' : 'Deactive' }}</td>

                <td valign="center">{{ @$profile->id }}</td>
                <td valign="center">{{ @$profile->group_status }}</td>
                <td valign="center">{{ @$profile->reason->name }}</td>
                <td valign="center">{{ @$profile->status_date }}</td>
                <td valign="center">{{ @$profile->start_date ? @$profile->start_date->format('d-M-Y') : '' }}</td>

                <td valign="center">{{ @$profile->name }}</td>
                <td valign="center">{{ @$profile->age }}</td>
                <td valign="center">{{ @$profile->date_of_birth ? @$profile->date_of_birth->format('d-M-Y') : '' }} </td>

                <td valign="center">{{ @$profile->age_completion_date ? @$profile->age_completion_date->format('d-M-Y') : '' }}</td>
                <td valign="center">{{ @$profile->phone }}</td>
                <td valign="center">{{ @$profile->pwd->name }}</td>

                <td valign="center">{{ @$profile->profile_division->name }}</td>
                <td valign="center">{{ @$profile->profile_district->name }}</td>
                <td valign="center">{{ @$profile->profile_upazila->name }}</td>

                <td valign="center">{{ @$profile->profile_union->name }}</td>
                <td valign="center">{{ @$profile->profile_village->name }} </td>
                <td valign="center">{{ @$profile->landmark }} </td>

                <td valign="center">{{ @$profile->fathers_name }}</td>
                <td valign="center">{{ @$profile->mothers_name }}</td>
                <td valign="center">{{ @$profile->guardian_name }}</td>

                <td valign="center">{{ @$profile->total_family_member }}</td>
                <td valign="center">{{ @$profile->father_phone }}</td>
                <td valign="center">{{ @$profile->mother_phone }}</td>

                <td valign="center">{{ @$profile->f_occupation->name }}</td>
                <td valign="center">{{ @$profile->father_income }}</td>
                <td valign="center">{{ @$profile->m_occupation->name }}</td>

                <td valign="center">{{ @$profile->mother_income }}</td>
                <td valign="center">{{ @$profile->o_occupation->name }}</td>
                <td valign="center">{{ @$profile->other_income }}</td>

                <td valign="center">{{ @$profile->amount_money ? 'Yes' : 'No' }}</td>
                <td valign="center">{{ @$profile->amount_money }}</td>

                @if (count($skills) >= 1)
                    @foreach ($skills as $skill)
                        @php
                            $found = false;
                            $skillCode = '';
                            $skillName = '';
                            $skillDate = '';
                        @endphp

                        @foreach ($profile->profile_skills as $profile_skill)
                            @if ($profile_skill->skill_table_id == $skill->id)
                                @php
                                    $found = true;
                                    $skillCode = $skill->code;
                                    $skillName = $skill->name;
                                    $skillDate = $profile_skill->skill_date->format('d-M-Y');
                                @endphp
                                @break
                            @endif
                         @endforeach

                        <td valign="center">{{ $found ? $skillCode : '-' }}</td>
                        <td valign="center">{{ $found ? $skillName : '-' }}</td>
                        <td valign="center">{{ $found ? $skillDate : '-' }}</td>
                    @endforeach
                @endif


            @if ($numInitiatives >= 1)
                @for ($i = 0; $i < $maxCmInitiatives; $i++)
                    @if ($i < $numInitiatives)
                        <!-- Display CM initiative data -->
                        <td>{{ $profile->cmInitiatives[$i]->initiative }}</td>
                        <td>{{ $profile->cmInitiatives[$i]->preventionType->name }}</td>
                        <td>{{ $profile->cmInitiatives[$i]->preventionBy->name }}</td>
                        <td>
                            @php
                                $age = $profile->cmInitiatives[$i]->age;
                                $years = 0;
                                if (str_contains($age, 'Years')) {
                                    preg_match('/(\d+) Years/', $age, $matches);
                                    $years = $matches[1] ?? 0;
                                }
                            @endphp
                            {{ $years }}
                        </td>
                        <td>{{ $profile->cmInitiatives[$i]->date->format('d-M-Y') }}</td>
                    @else
                        <!-- If no initiative available, display '-' for remaining columns -->
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    @endif
                @endfor
            @else
                <!-- If no initiatives, display '-' for all initiative columns -->
                @for ($i = 0; $i < $maxCmInitiatives; $i++)
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                @endfor
            @endif

            <td>{{ @$profile->marriageInfo->marriage_date ? @$profile->marriageInfo->marriage_date->format('d-M-Y') : '' }}</td>

            <td>{{ @$profile->marriageInfo->registration_completed }}</td>

            <td>{{ @$profile->marriageInfo->whoRegistered->name }} </td>

            <td>{{ @$profile->marriageInfo->marriagePlace->name }}</td>

            <td>{{ @$profile->marriageInfo->marriageReason->name }}</td>

            <td>{{ @$profile->marriageInfo->asked_by_groom }}</td>

            <td>{{ @$profile->marriageInfo->dower_amount }}</td>

            <td>{{ @$profile->marriageInfo->marriagInitiatedPerson->name }}</td>

            <td>{{ @$profile->marriageInfo->girlEducational->title }}</td>

            <td>{{ @$profile->marriageInfo->studentship_status }}</td>

            <td>{{ @$profile->marriageInfo->educatinalInstitution->name }}</td>

            <td>{{ @$profile->marriageInfo->groom_age }}</td>

            <td>{{ @$profile->marriageInfo->groomProfession->name }}</td>

            <td>{{ @$profile->marriageInfo->groomEducation->title }}</td>

        </tr>
    @endforeach

</tbody>
</table>
