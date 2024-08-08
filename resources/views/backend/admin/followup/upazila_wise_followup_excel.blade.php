<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District :
        {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$date_from }}
        |</b>&nbsp;<b>To Date : {{ @$date_to }}</b></p>
<table>
    <thead>
        <tr>
            <th>Division</th>
            <th>District</th>
            <th>Upazila</th>
            @foreach ($follow_number as $key => $number)
                <th>{{ $number }}</th>
            @endforeach
            @foreach ($followups as $key => $followup)
                <th>{{ $followup->title }}</th>
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
                @foreach ($follow_number as $key => $number)
                    @php
                        $row_total += (int) @$list['followup_number_id_' . $key];
                    @endphp
                    <td>{{ @$list['followup_number_id_' . $key] }}</td>
                @endforeach

                @foreach ($followups as $key => $provider)
                    @php
                        $row_total += (int) @$list['followup_findings_id_' . $provider->id];
                    @endphp
                    <td>{{ @$list['followup_findings_id_' . $provider->id] }}</td>
                @endforeach
                <td>{{ @$row_total }}</td>
            </tr>
        @endforeach

        <tr>
            @php
                $rowTotalValue = 0;
            @endphp
            <td colspan="3">Total</td>
            @foreach ($follow_number as $key => $number)
                <td>
                    {{ $selfDatas->sum('followup_number_id_' . $key) }}</td>
                @php
                    $rowTotalValue += $selfDatas->sum('followup_number_id_' . $key);
                @endphp
            @endforeach
            @foreach ($followups as $provider)
                <td>
                    {{ $selfDatas->sum('followup_findings_id_' . $provider->id) }}</td>
                @php
                    $rowTotalValue += $selfDatas->sum('followup_findings_id_' . $provider->id);
                @endphp
            @endforeach
            <td>{{ $rowTotalValue }}</td>
        </tr>
    </tbody>

</table>
