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
            <th valign="center" ><strong>SN.</strong></th>
            <th valign="center" ><strong>Indicator</strong></th>
            <th valign="center" ><strong>Indicator Statement</strong></th>
            {{-- <th valign="center" ><strong>Year</strong></th> --}}
            {{-- <th valign="center" ><strong>Date</strong></th> --}}
            <th valign="center" ><strong>TN</strong></th>
            <th valign="center" ><strong>Men</strong></th>
            <th valign="center" ><strong>Women</strong></th>
            <th valign="center" ><strong>Other Gender</strong></th>
            <th valign="center" ><strong>PWD Men</strong></th>
            <th valign="center" ><strong>PWD Women</strong></th>
            <th valign="center" ><strong>PWD Other Gender</strong></th>
            <th valign="center" ><strong>Outcome</strong></th>
            <th valign="center" ><strong>Outcome Statement</strong></th>
            <th valign="center" ><strong>% in outcome</strong></th>
        </tr>
    </thead>

    <tbody id="table-body">
        @foreach($processed_data as $index => $report)
                <tr>
                    <td> {{ $loop->iteration }}</td>
                    <td> {{ $report['data']['indicator_ref'] }} </td>
                    <td> {{ $report['data']['indicator_title'] }} </td>
                    {{-- <td> {{ $report['data']['year'] }}</td> --}}
                    {{-- <td> {{ $report['data']['from_date'] }} - {{ $report['data']['to_date'] }} </td> --}}
                    <td> {{ $report['data']['total'] }} </td>
                    <td> {{ $report['data']['men'] }} </td>
                    <td> {{ $report['data']['women'] }} </td>
                    <td> {{ $report['data']['other_gender'] }} </td>
                    <td> {{ $report['data']['pwd_men'] }} </td>
                    <td> {{ $report['data']['pwd_women'] }} </td>
                    <td> {{ $report['data']['pwd_other_gender'] }} </td>
                    <td> {{ $report['data']['outcome_ref'] ?? '-' }}</td>
                    <td> {{ $report['data']['outcome_title'] ?? '-' }}</td>
                    <td> {{ $report['data']['percentage_in_outcome'] }} </td>
                </tr>
        @endforeach
    </tbody>
</table>
