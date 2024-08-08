<table class="table table-bordered">
    <tr>
        <td colspan="200">
            <p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District :
                    {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date :
                    {{ @$from_date }}
                    |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
        </td>
    </tr>
    <tr>
        <td colspan="200">
            <p style="font-weight: bold;"><b>Case Status Wise Report</b></p>
        </td>
    </tr>
</table>


<p style="font-weight: bold;">Civil Case</p>
<table class="table table-bordered">
    <thead>
        <tr>
            <th class="tg-0pky" rowspan="2">SL.</th>
            <th class="tg-c3ow" rowspan="2">Purpose of Money recovered</th>
            <th class="tg-c3ow">Case status</th>
        </tr>
        <tr>
            @foreach ($civilCase as $item)
                <th class="tg-c3ow" style="width: 130px;">{{ $item->title }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($informations_civil_case as $key => $information)
            <tr>
                <td class="tg-0pky">{{ $loop->iteration }}</td>
                <td class="tg-0pky">{{ $key }}</td>
                @foreach ($information as $keyy => $info)
                    <td class="tg-0pky">{{ $info }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
<p style="font-weight: bold;">GR/Police Case</p>
<table class="table table-bordered">
    <thead>
        <tr>
            <th class="tg-0pky" rowspan="2">SL.</th>
            <th class="tg-c3ow" rowspan="2">Purpose of Money recovered</th>
            <th class="tg-c3ow">Case status</th>
        </tr>
        <tr>
            @foreach ($policeCase as $item)
                <th class="tg-c3ow" style="width: 130px;">{{ $item->title }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($informations_police_case as $key => $information)
            <tr>
                <td class="tg-0pky">{{ $loop->iteration }}</td>
                <td class="tg-0pky">{{ $key }}</td>
                @foreach ($information as $keyy => $info)
                    <td class="tg-0pky">{{ $info }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
<p style="font-weight: bold;">Petition Case</p>
<table class="table table-bordered">
    <thead>
        <tr>
            <th class="tg-0pky" rowspan="2">SL.</th>
            <th class="tg-c3ow" rowspan="2">Purpose of Money recovered</th>
            <th class="tg-c3ow">Case status</th>
        </tr>
        <tr>
            @foreach ($pititionCase as $item)
                <th class="tg-c3ow" style="width: 130px;">{{ $item->title }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($informations_petition_case as $key => $information)
            <tr>
                <td class="tg-0pky">{{ $loop->iteration }}</td>
                <td class="tg-0pky">{{ $key }}</td>
                @foreach ($information as $keyy => $info)
                    <td class="tg-0pky">{{ $info }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
