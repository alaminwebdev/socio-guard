<table>
    <tr>
        <td colspan="13">
            <p>SELP User List : </p>
        </td>
    </tr>
</table>
<table border="1">
    <thead>
        <tr>
            <th><strong>PIN</strong></th>
            <th><strong>Name</strong></th>
            <th><strong>Email</strong></th>
            <th><strong>Mobile</strong></th>
            <th><strong>Role</strong></th>
            <th><strong>Designation</strong></th>
            <th><strong>Zone</strong></th>
            <th><strong>Division</strong></th>
            <th><strong>District</strong></th>
            <th><strong>Upazila</strong></th>
            <th><strong>Union</strong></th>
            <th><strong>From Date</strong></th>
            <th><strong>To Date</strong></th>

        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            @php
                $rowSpan = count($user->setup_user_area);
            @endphp
            @if ($rowSpan > 0)
                @foreach ($user->setup_user_area as $index => $user_area)
                    <tr>
                        @if ($index === 0)
                            <td rowspan="{{ $rowSpan }}" valign="center">{{ @$user->pin }}</td>
                            <td rowspan="{{ $rowSpan }}" valign="center">{{ @$user->name }}</td>
                            <td rowspan="{{ $rowSpan }}" valign="center">{{ @$user->email }}</td>
                            <td rowspan="{{ $rowSpan }}" valign="center">{{ @$user->mobile }}</td>
                            <td rowspan="{{ $rowSpan }}" valign="center">
                                @if ($user->user_role->isEmpty())
                                    Has no role
                                @else
                                    @foreach ($user->user_role as $role)
                                        @if (!empty($role->role_details))
                                            {{ @$role->role_details->name }}
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td rowspan="{{ $rowSpan }}" valign="center">{{ @$user->designation }}</td>
                        @endif
                        <td valign="center">{{ @$user_area->setup_user_region->region_name }}</td>
                        <td valign="center">{{ @$user_area->setup_user_division->name }}</td>
                        <td valign="center">{{ @$user_area->setup_user_district->name }}</td>
                        <td valign="center">{{ @$user_area->setup_user_upazila->name }}</td>
                        <td valign="center">{{ @$user_area->setup_user_union->name }}</td>
                        <td valign="center">{{ @$user_area->date_from }}</td>
                        <td valign="center">{{ @$user_area->date_to }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td valign="center">{{ @$user->pin }}</td>
                    <td valign="center">{{ @$user->name }}</td>
                    <td valign="center">{{ @$user->email }}</td>
                    <td valign="center">{{ @$user->mobile }}</td>
                    <td valign="center">
                        @if ($user->user_role->isEmpty())
                            Has no role
                        @else
                            @foreach ($user->user_role as $role)
                                @if (!empty($role->role_details))
                                    {{ @$role->role_details->name }}
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td valign="center">{{ @$user->designation }}</td>
                    <td colspan="7" valign="center">No area information</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
