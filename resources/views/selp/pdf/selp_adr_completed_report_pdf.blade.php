@extends('selp.layouts.selp_adr_completed_report_header')
@section('content')
    <br>
    <p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2">SL.</th>
                <th rowspan="2">Purpose of Money recovered</th>
                <th colspan="{{ count($adrs) }}">ADR Completed</th>
                <th rowspan="2" style="width: 170px;">Amount of Money Received</th>
                <th rowspan="2" style="width: 170px;">No. of participants benefited</th>
            </tr>
            <tr>
                @foreach ($adrs as $item)
                    <th style="width: 170px;">{{ $item->title }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($informations as $purpose => $adrData)
                @php
                    $sumAmount          = 0;
                    $sumParticipants    = 0;
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $purpose }}</td>
                    @foreach ($adrs as $adr)
                        @php
                            $adrId              =  $adr->id;
                            $count              =  isset($adrData[$adrId]) ? $adrData[$adrId]['count'] : 0;
                            $sumAmount          += isset($adrData[$adrId]) ? $adrData[$adrId]['Amount of Money Received'] : 0;
                            $sumParticipants    += isset($adrData[$adrId]) ? $adrData[$adrId]['No. of participants benefited'] : 0;
                        @endphp
                        <td>{{ $count }}</td>
                    @endforeach
                    <td>{{ $sumAmount }}</td>
                    <td>{{ $sumParticipants }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
