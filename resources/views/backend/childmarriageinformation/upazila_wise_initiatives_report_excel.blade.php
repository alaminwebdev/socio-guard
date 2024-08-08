<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District :
        {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$date_from }}
        |</b>&nbsp;<b>To Date : {{ @$date_to }}</b></p>
<table>
    <thead>
        <tr>
            <th>Division</th>
            <th>District</th>
            <th>Upazila</th>
            @foreach ($ChildMarriageInitiative as $key => $Initiative)
                <th>{{ $Initiative->name }}</th>
            @endforeach
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($selfDatas as $list)
            <tr>
                <td>{{ @$list['division_name'] }}</td>
                <td>{{ @$list['district_name'] }}</td>
                <td>{{ @$list['upazila_name'] }}</td>
                @php
                    $row_total = 0;
                @endphp
                @foreach ($ChildMarriageInitiative as $key => $provider)
                    @php
                        $row_total += (int) @$list['child_marriage_initiative_id_' . $provider->id];
                    @endphp
                    <td>{{ @$list['child_marriage_initiative_id_' . $provider->id] }}</td>
                @endforeach
                <td>{{ @$row_total }}</td>
            </tr>
        @endforeach

        <tr>
            @php
                $rowTotalValue = 0;
            @endphp
            <td colspan="3">Total</td>
            @foreach ($ChildMarriageInitiative as $provider)
                <td>
                    {{ $selfDatas->sum('child_marriage_initiative_id_' . $provider->id) }}</td>
                @php
                    $rowTotalValue += $selfDatas->sum('child_marriage_initiative_id_' . $provider->id);
                @endphp
            @endforeach
            <td>{{ $rowTotalValue }}
            </td>
        </tr>
    </tbody>

</table>
