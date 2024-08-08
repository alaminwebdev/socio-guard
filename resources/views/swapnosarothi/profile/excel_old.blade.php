<table>
    <tr>
        <td colspan="50">
            <p>Swapnosarothi Girl's Profile (Profile ID : {{ @$pofileData->id }} | Creation Date : {{ @$pofileData->created_at ? @$pofileData->created_at->format('d-M-Y') : '' }})</p>

        </td>
    </tr>

</table>

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
            <th><strong>Profile Status </strong></th>
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

            <th><strong>Skill Code </strong></th>
            <th><strong>Skill Name </strong></th>
            <th><strong>Session Date </strong></th>

            <th><strong>Initiative </strong></th>
            <th><strong>Prevention Type </strong></th>
            <th><strong>Prevention </strong></th>
            <th><strong>Age </strong></th>
            <th><strong>Date </strong></th>

            <th><strong>Marriage Date</strong></th>
            <th><strong>Registration Completed</strong></th>
            <th><strong> Who Registered</strong></th>
            <th><strong>Marriage Place </strong></th>
            <th><strong> Marriage Reason</strong></th>
            <th><strong> Asked by Groom </strong></th>
            <th><strong>Dower Amount</strong></th>
            <th><strong>Initiated Person </strong></th>
            <th><strong>Girl Education</strong></th>
            <th><strong>Studentship Status</strong></th>
            <th><strong> Institution</strong></th>
            <th><strong>Groom's Age</strong></th>
            <th><strong>Groom's Profession</strong></th>
            <th><strong>Groom's Education</strong></th>
        </tr>
    </thead>
    <tbody>
        @php
            $collSpan = count($pofileData->cmInitiatives) + count($pofileData->profile_skills) + 1 + ($pofileData->marriageInfo ? 1 : 0);
        @endphp
        <tr>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->employee->name }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->employee->mobile }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->employee->designation }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->employee->pin }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->employee_zone->region_name }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->employee_division->name }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->employee_district->name }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->employee_upazila->name }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->employee_union->name }}</td>

            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->groupName->group_name }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->groupName->start_date ? @$pofileData->groupName->start_date->format('d-M-Y') : '' }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->groupName->status == 1 ? 'Active' : 'Deactive' }}</td>

            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->group_status }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->start_date ? @$pofileData->start_date->format('d-M-Y') : '' }}</td>

            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->name }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->age }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->date_of_birth ? @$pofileData->date_of_birth->format('d-M-Y') : '' }} </td>

            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->age_completion_date ? @$pofileData->age_completion_date->format('d-M-Y') : '' }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->phone }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->pwd->name }}</td>

            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->profile_division->name }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->profile_district->name }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->profile_upazila->name }}</td>

            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->profile_union->name }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->profile_village->name }} </td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->landmark }} </td>

            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->fathers_name }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->mothers_name }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->guardian_name }}</td>

            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->total_family_member }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->father_phone }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->mother_phone }}</td>

            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->father_occupation }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->father_income }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->mother_occupation }}</td>

            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->mother_income }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->other_occupation }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->other_income }}</td>

            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->amount_money ? 'Yes' : 'No' }}</td>
            <td rowspan="{{ $collSpan }}" valign="center">{{ @$pofileData->amount_money }}</td>

        </tr>

        @if (count($pofileData->profile_skills) >= 1)
            @foreach ($pofileData->profile_skills as $profile_skill)
                <tr>
                    <td>{{ $profile_skill->skill->code }}</td>
                    <td>{{ $profile_skill->skill->name }}</td>
                    <td>{{ $profile_skill->skill_date->format('d-M-Y') }}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
            @endforeach

        @endif

        @if (count($pofileData->cmInitiatives) >= 1)
            @foreach ($pofileData->cmInitiatives as $initiative)
                <tr>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>{{ $initiative->initiative }}</td>
                    <td>{{ $initiative->preventionType->name }}</td>
                    <td>{{ $initiative->preventionBy->name }}</td>
                    <td>{{ $initiative->age }} </td>
                    <td>{{ $initiative->date->format('d-M-Y') }}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>

                </tr>
            @endforeach

        @endif

        @if (@$pofileData->marriageInfo)
            <tr>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>

                <td>{{ $pofileData->marriageInfo->marriage_date ? @$pofileData->marriageInfo->marriage_date->format('d-M-Y') : '' }}</td>
                <td>{{ @$pofileData->marriageInfo->registration_completed }}</td>
                <td>
                    {{ @$pofileData->marriageInfo->whoRegistered->name }}
                </td>

                <td>
                    {{ @$pofileData->marriageInfo->marriagePlace->name }}
                </td>
                <td>
                    {{ @$pofileData->marriageInfo->marriageReason->name }}
                </td>
                <td>
                    {{ @$pofileData->marriageInfo->asked_by_groom }}
                </td>

                <td>
                    {{ @$pofileData->marriageInfo->dower_amount }}
                </td>
                <td>
                    {{ @$pofileData->marriageInfo->marriagInitiatedPerson->name }}
                </td>
                <td>
                    {{ @$pofileData->marriageInfo->girlEducational->title }}
                </td>

                <td>
                    {{ @$pofileData->marriageInfo->studentship_status }}
                </td>
                <td>
                    {{ @$pofileData->marriageInfo->educatinalInstitution->name }}
                </td>
                <td>
                    {{ @$pofileData->marriageInfo->groom_age }}
                </td>

                <td>
                    {{ @$pofileData->marriageInfo->groomProfession->name }}
                </td>
                <td>
                    {{ @$pofileData->marriageInfo->groomEducation->title }}
                </td>
            </tr>
        @endif

    </tbody>
</table>
