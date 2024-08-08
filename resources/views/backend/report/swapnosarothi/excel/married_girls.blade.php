<p style="color: #0b253a;">
    <b>Zone : {{ @$region }} |</b>&nbsp;
    <b>Division : {{ @$division->name ?? 'All' }} |</b>&nbsp;
    <b>District : {{ @$district->name ?? 'All' }} |</b>&nbsp;
    <b>Upazila : {{ @$upazila->name ?? 'All' }} |</b>&nbsp;
    <b>From Date : {{ @$date_from }}</b>&nbsp;
    <b>To Date : {{ @$date_to }}</b>
</p>
<table class="">
    <thead>
        <tr>
            <th valign="center" rowspan="2"><strong>Zone</strong></th>
            <th valign="center" rowspan="2"><strong>Division</strong></th>
            <th valign="center" rowspan="2"><strong>District</strong></th>
            <th valign="center" rowspan="2"><strong>Upazila</strong></th>
            <th valign="center" rowspan="2"><strong>Group</strong></th>
            <th valign="center" colspan="3"><strong>{{ @$title }}</strong></th>
        </tr>
        <tr>
            <th><strong>Below 18</strong></th>
            <th><strong>After 18</strong></th>
            <th><strong>Total</strong></th>
        </tr>
    </thead>

    <tbody>
        @if (!empty($array_data))
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
                                <td>
                                    {{ @$group_list['below_18'] }}
                                </td>
                                <td>
                                    {{ @$group_list['after_18'] }}
                                </td>
                                <td>
                                    {{ @$group_list['total'] }}
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            @endforeach
        @endif
    </tbody>
</table>
