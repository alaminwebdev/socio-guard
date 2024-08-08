<table>
    <tr>
        <td colspan="50">
            <p>Swapnosarothi Girl's Profile (Profile ID : {{ @$profileData->id }} | Creation Date : {{ @$profileData->created_at ? @$profileData->created_at->format('d-M-Y') : '' }})</p>
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

            @if (count($profileData->cmInitiatives) >= 1)
                @foreach ($profileData->cmInitiatives as $initiative)
                    <th><strong>({{ $loop->iteration }}) - Initiative</strong></th>
                    <th><strong>({{ $loop->iteration }}) - Prevention Type</strong></th>
                    <th><strong>({{ $loop->iteration }}) - Prevention</strong></th>
                    <th><strong>({{ $loop->iteration }}) - Age</strong></th>
                    <th><strong>({{ $loop->iteration }}) - Date</strong></th>
                @endforeach
            @endif

            @if (@$profileData->marriageInfo)
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
            @endif
        </tr>
    </thead>
    <tbody>
        <tr>
            <td valign="center">{{ @$profileData->employee->name }}</td>
            <td valign="center">{{ @$profileData->employee->mobile }}</td>
            <td valign="center">{{ @$profileData->employee->designation }}</td>
            <td valign="center">{{ @$profileData->employee->pin }}</td>
            <td valign="center">{{ @$profileData->employee_zone->region_name }}</td>
            <td valign="center">{{ @$profileData->employee_division->name }}</td>
            <td valign="center">{{ @$profileData->employee_district->name }}</td>
            <td valign="center">{{ @$profileData->employee_upazila->name }}</td>
            <td valign="center">{{ @$profileData->employee_union->name }}</td>

            <td valign="center">{{ @$profileData->groupName->group_name }}</td>
            <td valign="center">{{ @$profileData->groupName->start_date ? @$profileData->groupName->start_date->format('d-M-Y') : '' }}</td>
            <td valign="center">{{ @$profileData->groupName->status == 1 ? 'Active' : 'Deactive' }}</td>

            <td valign="center">{{ @$profileData->group_status }}</td>
            <td valign="center">{{ @$profileData->reason->name }}</td>
            <td valign="center">{{ @$profileData->status_date }}</td>
            <td valign="center">{{ @$profileData->start_date ? @$profileData->start_date->format('d-M-Y') : '' }}</td>

            <td valign="center">{{ @$profileData->name }}</td>
            <td valign="center">{{ @$profileData->age }}</td>
            <td valign="center">{{ @$profileData->date_of_birth ? @$profileData->date_of_birth->format('d-M-Y') : '' }} </td>

            <td valign="center">{{ @$profileData->age_completion_date ? @$profileData->age_completion_date->format('d-M-Y') : '' }}</td>
            <td valign="center">{{ @$profileData->phone }}</td>
            <td valign="center">{{ @$profileData->pwd->name }}</td>

            <td valign="center">{{ @$profileData->profile_division->name }}</td>
            <td valign="center">{{ @$profileData->profile_district->name }}</td>
            <td valign="center">{{ @$profileData->profile_upazila->name }}</td>

            <td valign="center">{{ @$profileData->profile_union->name }}</td>
            <td valign="center">{{ @$profileData->profile_village->name }} </td>
            <td valign="center">{{ @$profileData->landmark }} </td>

            <td valign="center">{{ @$profileData->fathers_name }}</td>
            <td valign="center">{{ @$profileData->mothers_name }}</td>
            <td valign="center">{{ @$profileData->guardian_name }}</td>

            <td valign="center">{{ @$profileData->total_family_member }}</td>
            <td valign="center">{{ @$profileData->father_phone }}</td>
            <td valign="center">{{ @$profileData->mother_phone }}</td>

            <td valign="center">{{ @$profileData->f_occupation->name }}</td>
            <td valign="center">{{ @$profileData->father_income }}</td>
            <td valign="center">{{ @$profileData->m_occupation->name }}</td>

            <td valign="center">{{ @$profileData->mother_income }}</td>
            <td valign="center">{{ @$profileData->o_occupation->name }}</td>
            <td valign="center">{{ @$profileData->other_income }}</td>

            <td valign="center">{{ @$profileData->amount_money ? 'Yes' : 'No' }}</td>
            <td valign="center">{{ @$profileData->amount_money }}</td>

            @if (count($skills) >= 1)
                @foreach ($skills as $skill)
                    @php
                        $found = false;
                        $skillCode = '';
                        $skillName = '';
                        $skillDate = '';
                    @endphp

                    @foreach ($profileData->profile_skills as $profile_skill)
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

                    <td>{{ $found ? $skillCode : '-' }}</td>
                    <td>{{ $found ? $skillName : '-' }}</td>
                    <td>{{ $found ? $skillDate : '-' }}</td>
                @endforeach
            @endif

            @if (count($profileData->cmInitiatives) >= 1)
                @foreach ($profileData->cmInitiatives as $initiative)
                    <td>{{ $initiative->initiative }}</td>
                    <td>{{ $initiative->preventionType->name }}</td>
                    <td>{{ $initiative->preventionBy->name }}</td>
                    <td>
                        {{-- {{ $initiative->age }}  --}}
                        @php
                            $age = $initiative->age;
                            $years = 0;
                            
                            if (str_contains($age, 'Years')) {
                                preg_match('/(\d+) Years/', $age, $matches);
                                $years = $matches[1] ?? 0;
                            }
                        @endphp
                        {{ $years }}
                    </td>
                    <td>{{ $initiative->date->format('d-M-Y') }}</td>
                @endforeach
            @endif

            @if (@$profileData->marriageInfo)
                <td>
                    {{ $profileData->marriageInfo->marriage_date ? @$profileData->marriageInfo->marriage_date->format('d-M-Y') : '' }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->registration_completed }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->whoRegistered->name }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->marriagePlace->name }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->marriageReason->name }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->asked_by_groom }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->dower_amount }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->marriagInitiatedPerson->name }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->girlEducational->title }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->studentship_status }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->educatinalInstitution->name }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->groom_age }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->groomProfession->name }}
                </td>

                <td>
                    {{ @$profileData->marriageInfo->groomEducation->title }}
                </td>
            @endif
    </tr>

</tbody>
</table>
