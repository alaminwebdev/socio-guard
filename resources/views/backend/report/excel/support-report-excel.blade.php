<table class="table table-bordered">
<thead>
    <tr>
        <th rowspan="2">SL. No.</th>
        <th rowspan="2">Particulars</th>
        <th rowspan="2">Type</th>
        <th colspan="3">{{ $from_date }} to {{ $to_date }}</th>
    </tr>
    <tr>
        <th>M</th>
        <th>F</th>
        <th>T</th>
    </tr>
</thead>
<tbody>
    @php
    $year_between_male_total = 0;
    $year_between_female_total = 0;
    $year_between_total = 0;
    @endphp
    @foreach($survivor_info as $info)
    <tr>
        @if($loop->index == 0)
        <td rowspan="{{$info['rows']+1}}">{{$loop->iteration}}</td>
        <td rowspan="{{$info['rows']+1}}">{{ $support_name->name }}</td>
        @endif
        <td>{{$info['type']}}</td>
        <td>{{ $info['year_between']['male']}} @php  $year_between_male_total +=  $info['year_between']['male'] @endphp</td>
        <td>{{ $info['year_between']['female'] }} @php  $year_between_female_total +=  $info['year_between']['female'] @endphp</td>
        <td>{{ $info['year_between']['total'] }} @php  $year_between_total +=  $info['year_between']['total'] @endphp</td>
        </tr>
        @endforeach
        <tr>
            <td>Total</td>
            <td>{{$year_between_male_total}}</td>
            <td>{{$year_between_female_total}}</td>
            <td>{{$year_between_total}}</td>
        </tr>
    </tbody>
</table>