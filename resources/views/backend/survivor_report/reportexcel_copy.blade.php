<style>
    table tr {
        border: 1px solid !important;
    }
</style>

<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District :
        {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }}
        |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
<table border="1">
    <thead>
        <tr style="border:1px solid !important;">
            <th>Id</th>
            <th>Reporting Date</th>
            <th>Employee Zone</th>
            <th>Employee Division</th>
            <th>Employee District</th>
            <th>Employee Upazila</th>
            {{-- <th>Reported Incident Type</th>
            <th>Date of disputes</th>
            <th>Survivor's Name</th>
            <th>Survivor's Father's Name</th>
            <th>Survivor's Mother's Name</th>
            <th>Survivor's Husband's Name</th>
            <th>Survivor's Age</th>
            <th>Survivor's Cell number self</th>
            <th>Survivor's Cell number on request</th>
            <th>Survivor's Gender</th>
            <th>Survivor's Disability status</th>
            <th>Name of Main Deffendent /Accused</th> --}}
            <th>Direct Service</th>
            <th>Date</th>
            <th>Alternative Dispute Resolution</th>
            <th>Date</th>
            <th>Case Type</th>
            <th>Case Status</th>
            <th>Date</th>

        </tr>
    </thead>
    <tbody>

        
        @foreach ($directServices as $selp_info)
            @php
                $a = $selp_info->groupBy('service_type_id');
            @endphp
            @foreach($a as $b)
               @php
                    $adr = $b->groupBy('alternative_dispute_resolution_id');
               @endphp
                @foreach($adr as $key => $d)
                    @if (!empty($key))
                        @php
                            $uniqdata = $d->unique('id');
                        @endphp
                        @foreach ($uniqdata as $info)
                            <tr>
                                <td>{{ $info->id }}</td>
                                <td>{{ $info->posting_date }}</td>
                                <td>{{ $info->region_name }}</td>
                                <td>{{ $info->division_name }}</td>
                                <td>{{ $info->district_name }}</td>
                                <td>{{ $info->upazila_name }}</td>
                                @if ($info->service_type_id == 1)
                                    <td> Assistance to treatment /medical support </td>
                                    <td>{{ $info->service_date ?? '-' }}</td>
                                @elseif ($info->service_type_id == 2)
                                    <td> Assistance to OCC </td>
                                    <td>{{ $info->service_date ?? '-' }}</td>
                                @elseif ($info->service_type_id == 3)
                                    <td> Alternative Dispute Resolution (ADR) </td>
                                    <td></td>
                                @elseif ($info->service_type_id == 4)
                                    <td> Assistance with court case </td>
                                    <td></td>
                                @elseif ($info->service_type_id == 5)
                                    <td> Assistance to Police Station </td>
                                    <td>{{ $info->service_date ?? '-' }}</td>
                                @elseif ($info->service_type_id == 5)
                                    <td> Phycosocial Counselling </td>
                                    <td>{{ $info->service_date ?? '-' }}</td>
                                @else
                                    <td> </td>
                                    <td></td>
                                @endif
                                @if ($info->service_type_id == 3)
                                    <td>{{ $info->alternative_dispute ?? '-' }}</td>
                                    <td>
                                        @if (
                                            $info->alternative_dispute_resolution_id == 1 ||
                                                $info->alternative_dispute_resolution_id == 2 ||
                                                $info->alternative_dispute_resolution_id == 3)
                                            {{ $info->starting_date ?? '-' }}
                                        @else
                                            {{ $info->closing_date ?? '-' }}
                                        @endif
                                    </td>
                                @else
                                    <td></td>
                                    <td></td>
                                @endif
            
                                @if ($info->service_type_id == 4)
                                    @if ($info->case_type == 1)
                                        @php
                                            $caseStatus = App\Model\Civilcase::where('id', $info->court_case_id)->first();
                                        @endphp
                                        <td> Civil cases </td>
                                        <td>{{ $caseStatus->title }}</td>
                                        <td>{{ $info->case_judjement_date ? $info->case_judjement_date : $info->case_start_date }}
                                        </td>
                                    @elseif ($info->case_type == 2)
                                        @php
                                            $caseStatus = App\Model\Policecase::where('id', $info->court_case_id)->first();
                                        @endphp
                                        <td> GR/Police Case </td>
                                        <td>{{ $caseStatus->title }}</td>
                                        <td>{{ $info->case_judjement_date ? $info->case_judjement_date : $info->case_start_date }}
                                        </td>
                                    @elseif ($info->case_type == 3)
                                        @php
                                            $caseStatus = App\Model\Pititioncase::where('id', $info->court_case_id)->first();
                                        @endphp
                                        <td> CR/Petition Case </td>
                                        <td>{{ $caseStatus->title }}</td>
                                        <td>{{ $info->case_judjement_date ? $info->case_judjement_date : $info->case_start_date }}
                                        </td>
                                    @endif
                                @else
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                    @endif

                @endforeach
            @endforeach
        @endforeach
        
        @foreach ($directServices as $selp_info)
            @php
                $a = $selp_info->groupBy('service_type_id');
            @endphp
            @foreach($a as $b)
               @php
                    $court = $b->groupBy('court_case_id');
               @endphp
                @foreach( $court as $key => $d)
                    @if (!empty( $key))
                    @php
                    $uniqdata = $d->unique('id');
                @endphp
                @foreach ($uniqdata as $info)
                    <tr>
                        <td>{{ $info->id }}</td>
                        <td>{{ $info->posting_date }}</td>
                        <td>{{ $info->region_name }}</td>
                        <td>{{ $info->division_name }}</td>
                        <td>{{ $info->district_name }}</td>
                        <td>{{ $info->upazila_name }}</td>
                        @if ($info->service_type_id == 1)
                            <td> Assistance to treatment /medical support </td>
                            <td>{{ $info->service_date ?? '-' }}</td>
                        @elseif ($info->service_type_id == 2)
                            <td> Assistance to OCC </td>
                            <td>{{ $info->service_date ?? '-' }}</td>
                        @elseif ($info->service_type_id == 3)
                            <td> Alternative Dispute Resolution (ADR) </td>
                            <td></td>
                        @elseif ($info->service_type_id == 4)
                            <td> Assistance with court case </td>
                            <td></td>
                        @elseif ($info->service_type_id == 5)
                            <td> Assistance to Police Station </td>
                            <td>{{ $info->service_date ?? '-' }}</td>
                        @elseif ($info->service_type_id == 5)
                            <td> Phycosocial Counselling </td>
                            <td>{{ $info->service_date ?? '-' }}</td>
                        @else
                            <td> </td>
                            <td></td>
                        @endif
                        @if ($info->service_type_id == 3)
                            <td>{{ $info->alternative_dispute ?? '-' }}</td>
                            <td>
                                @if (
                                    $info->alternative_dispute_resolution_id == 1 ||
                                        $info->alternative_dispute_resolution_id == 2 ||
                                        $info->alternative_dispute_resolution_id == 3)
                                    {{ $info->starting_date ?? '-' }}
                                @else
                                    {{ $info->closing_date ?? '-' }}
                                @endif
                            </td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
    
                        @if ($info->service_type_id == 4)
                            @if ($info->case_type == 1)
                                @php
                                    $caseStatus = App\Model\Civilcase::where('id', $info->court_case_id)->first();
                                @endphp
                                <td> Civil cases </td>
                                <td>{{ $caseStatus->title }}</td>
                                <td>{{ $info->case_judjement_date ? $info->case_judjement_date : $info->case_start_date }}
                                </td>
                            @elseif ($info->case_type == 2)
                                @php
                                    $caseStatus = App\Model\Policecase::where('id', $info->court_case_id)->first();
                                @endphp
                                <td> GR/Police Case </td>
                                <td>{{ $caseStatus->title }}</td>
                                <td>{{ $info->case_judjement_date ? $info->case_judjement_date : $info->case_start_date }}
                                </td>
                            @elseif ($info->case_type == 3)
                                @php
                                    $caseStatus = App\Model\Pititioncase::where('id', $info->court_case_id)->first();
                                @endphp
                                <td> CR/Petition Case </td>
                                <td>{{ $caseStatus->title }}</td>
                                <td>{{ $info->case_judjement_date ? $info->case_judjement_date : $info->case_start_date }}
                                </td>
                            @endif
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif
                    </tr>
                @endforeach
                    @endif

                @endforeach
            @endforeach
        @endforeach



    </tbody>
</table>
