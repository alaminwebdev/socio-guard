<style>
    table tr {
        border: 1px solid !important;
    }
</style>

<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District :
        {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$date_from }}
        |</b>&nbsp;<b>To Date : {{ @$date_to }}</b></p>

<table border="1">
    <thead>
        <tr>
            <th><strong>Id</strong></th>
            <th><strong>Reporting Date</strong></th>
            <th><strong>Employee Zone</strong></th>
            <th><strong>Employee Division</strong></th>
            <th><strong>Employee District</strong></th>
            <th><strong>Employee Upazila</strong></th>
            <th><strong>Reported Incident Type</strong></th>
            <th><strong>Date of disputes</strong></th>
            <th><strong>Survivor's Name</strong></th>
            <th><strong>Survivor's Father's Name</strong></th>
            <th><strong>Survivor's Mother's Name</strong></th>
            <th><strong>Survivor's Husband's Name</strong></th>
            <th><strong>Survivor's Age</strong></th>
            <th><strong>Survivor's Cell number self</strong></th>
            <th><strong>Survivor's Cell number on request</strong></th>
            <th><strong>Survivor's Gender</strong></th>
            <th><strong>Survivor's Disability status</strong></th>
            <th><strong>Name of Main Deffendent /Accused</strong></th>
            <th><strong>Direct Service</strong></th>
            <th><strong>Date</strong></th>
            <th><strong>Alternative Dispute Resolution</strong></th>
            <th><strong>Date</strong></th>
            <th><strong>Case Type</strong></th>
            <th><strong>Case Status</strong></th>
            <th><strong>Date</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($directServices as $complain_id => $info)
            {{-- @dd($info); --}}
            @if (count($info) > 0)
                @php
                    $rowSpanParent = 0;
                    $direct_adr_case_count = 0;
                    $other_service_count = 0;

                    foreach ($info['service_types'] as $direct_service_type => $direct_service) {
                        if ($direct_service_type == 3 || $direct_service_type == 4) {
                            $direct_adr_case_count += count($direct_service);
                        } else {
                            $other_service_count += 1;
                        }
                    }

                    $rowSpanParent = $other_service_count + $direct_adr_case_count + 2;
                    //dd($rowSpanParent)
                @endphp
                <tr>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['id'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['posting_date']->format('d-m-Y') }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['region_name'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['division_name'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['district_name'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['upazila_name'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['violence_reason'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['date_of_dispute']->format('d-m-Y') }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['survivor_name'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['survivor_father_name'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['survivor_mother_name'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['survivor_husband_name'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['survivor_age'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['survivor_mobile_number'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['survivor_mobile_number_on_request'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['survivor_gender'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['survivor_disability_name'] }}</td>
                    <td valign="center" rowspan="{{ $rowSpanParent }}">{{ @$info['main_defendants_name'] }}</td>
                </tr>

                @if (count($info['service_types']) > 0)
                    @foreach ($info['service_types'] as $direct_service_type => $direct_service)
                        @if ($direct_service_type == 1 || $direct_service_type == 2 || $direct_service_type == 5 || $direct_service_type == 6)
                            <tr>
                                <td valign="center">{{ getServiceTypeText($direct_service_type) }}</td>
                                <td valign="center">{{ @$direct_service['service_date'] ? date('d-m-Y', strtotime(@$direct_service['service_date'])) : '-' }}</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        @elseif ($direct_service_type == 3)
                            <tr>
                                <td valign="center" rowspan="{{ count($direct_service) + 1  }}">Alternative Dispute Resolution (ADR)</td>
                                <td valign="center" rowspan="{{ count($direct_service) + 1  }}">-</td>
                            </tr>
                            @foreach ($direct_service as $adr)
                                <tr>
                                    <td>{{ $adr['title'] }}</td>
                                    <td>{{ $adr['starting_date'] }}</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>  
                                </tr>
                            @endforeach
                        @elseif ($direct_service_type == 4)
                            <tr>
                                <td valign="center" rowspan="{{ count($direct_service) + 1 }}">Assistance with court case</td>
                                <td valign="center" rowspan="{{ count($direct_service) + 1 }}">-</td>
                                <td valign="center" rowspan="{{ count($direct_service) + 1 }}">-</td>
                                <td valign="center" rowspan="{{ count($direct_service) + 1}}">-</td>
                                
                            </tr>
                            @foreach ($direct_service as $case)
                                <tr>
                                    <td>{{ getCaseType($case['case_type']) }}</td>
                                    <td>{{ $case['title'] }}</td>
                                    <td>{{ $case['case_judjement_date'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">No direct services</td>
                    </tr>
                @endif
            @endif
        @endforeach
    </tbody>
</table>

@php
    function getServiceTypeText($type)
    {
        // Return the appropriate service type text based on the type
        switch ($type) {
            case 1:
                return 'Assistance to treatment /medical support';
            case 2:
                return 'Assistance to OCC';
            case 5:
                return 'Assistance to Police Station';
            case 6:
                return 'Phycosocial Counselling';
            default:
                return '';
        }
    }

    function getCaseType($type)
    {
        switch ($type) {
            case 1:
                return 'Civil cases';
            case 2:
                return 'GR/Police Case';
            case 3:
                return 'CR/Petition Case';
            default:
                return '';
        }
    }
@endphp
