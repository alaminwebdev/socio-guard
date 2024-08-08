<table>
    <tr>
        <td colspan="5">
            <p>Child Marriage Information</p>
        </td>
        <td>
            Id: {{ formatIncidentId($childmarriageinformation->id) }}
        </td>

        <td colspan="5">
            Reporting Date :
            {{ $childmarriageinformation->reporting_date != null ? date('d-m-Y', strtotime($childmarriageinformation->reporting_date)) : '' }}

        </td>
    </tr>
</table>
<table>
    <tbody>
        <tr>
            <th>employee name</th>
            <th>employee mobile number</th>
            <th>employee designation</th>
            <th>employee pin</th>
            <th>region name</th>
            <th>employee division</th>
            <th>employee district</th>
            <th>employee upazila</th>
            <th>child name</th>
            <th>Father's Name</th>
            <th>Mother's Name</th>
            <th>child age</th>
            <th>Gender</th>
            <th>child mobile_number</th>
            <th>child division</th>
            <th>child district</th>
            <th>child upazila</th>
            <th>Child union</th>
            <th>Disability</th>
            <th>child marriage initiative</th>
            <th>Assistance</th>
            <th>Initiative taking person </th>
            <th>Initiative taking person mobile </th>
            <th>Initiative taking person division </th>
            <th>Initiative taking person district </th>
            <th>Initiative taking person upazila </th>
            <th>Initiative taking person union </th>
            <th>Initiative taking person village </th>
        </tr>
        <tr>
            <td>
                {{ @$childmarriageinformation->employee_name }}
            </td>
            <td>
                {{ @$childmarriageinformation->employee_mobile_number }}
            </td>
            <td>
                {{ @$childmarriageinformation->employee_designation }}
            </td>
            <td>
                {{ @$childmarriageinformation->employee_pin }}
            </td>
            <td>
                {{ @$childmarriageinformation->employee_zone->region_name }}
            </td>
            <td>
                {{ @$childmarriageinformation->employee_division->name }}
            </td>
            <td>
                {{ @$childmarriageinformation->employee_district->name }}
            </td>
            <td>
                {{ @$childmarriageinformation->employee_upazila->name }}
            </td>
            <td>
                {{ @$childmarriageinformation->child_name }}
            </td>
            <td>
                {{ @$childmarriageinformation->child_father_name }}
            </td>
            <td>
                {{ @$childmarriageinformation->child_mother_name }}
            </td>

            <td>
                {{ @$childmarriageinformation->child_age }}
            </td>
            <td>
                {{ @$childmarriageinformation->gender->name }}
            </td>
            <td>
                {{ @$childmarriageinformation->child_mobile_number }}
            </td>

            <td>
                {{ @$childmarriageinformation->child_division->name }}
            </td>
            <td>
                {{ @$childmarriageinformation->child_district->name }}
            </td>
            <td>
                {{ @$childmarriageinformation->child_upazila->name }}
            </td>

            <td>
                {{ @$childmarriageinformation->child_union->name }}
            </td>
            <td>
                {{ @$childmarriageinformation->child_village_name }}
            </td>
            <td>
                {{ @$childmarriageinformation->disability->name }}
            </td>

            <td>
                {{ @$childmarriageinformation->child_marriage_initiative->name }}
            </td>
            <td>
                @foreach (@$childmarriageinformation->assistanceTakens as $childmarriageassistance)
                    {{ $childmarriageassistance->name }},
                @endforeach
            </td>

            <td>
                {{ @$childmarriageinformation->person_name }}
            </td>
            <td>
                {{ @$childmarriageinformation->person_mobile_number }}
            </td>
            <td>
                {{ @$childmarriageinformation->person_division->name }}
            </td>
            <td>
                {{ @$childmarriageinformation->person_district->name }}
            </td>
            <td>
                {{ @$childmarriageinformation->person_upazila->name }}
            </td>
            <td>
                {{ @$childmarriageinformation->person_union->name }}
            </td>
            <td>
                {{ @$childmarriageinformation->person_village_name }}
            </td>
        </tr>



    </tbody>
</table>
