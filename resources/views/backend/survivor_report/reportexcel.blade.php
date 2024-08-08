
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
            <th><strong>Starting Date</strong></th>
            <th><strong>Closing Date</strong></th>
            <th><strong>Case Type</strong></th>
            <th><strong>Case Status</strong></th>
            <th><strong>Starting Date</strong></th>
            <th><strong>Judgement/Installment date</strong></th>

        </tr>
    </thead>
    <tbody>

        @foreach ($directServices as $info)
            @if ($info->direct_services->count() > 0)
                @php
                    $rowSpanParent = 0;
                    $direct_adr_case_count = 0;
                    foreach ($info->direct_services as $direct_service) {
                        if($direct_service->service_type_id == 3 || $direct_service->service_type_id == 4){
                            $direct_adr_case_count = count($direct_service->direct_adrs) + count($direct_service->court_case);
                        }
                    }
                    $rowSpanParent += count($info->direct_services) + $direct_adr_case_count + 1 ;
                    
                @endphp
                <tr>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->id }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->posting_date->format('d-m-Y') }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->region_name }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->division_name }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->district_name }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->upazila_name }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->types_of_disputes->name }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->date_of_dispute->format('d-m-Y') }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->survivor_name }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->survivor_father_name }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->survivor_mother_name }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->survivor_husband_name }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->survivor_age }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->survivor_mobile_number }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->survivor_mobile_number_on_request }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->survivor_gender->name }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->survivor_disability->name }}</td>
                    <td valign="center" rowspan="{{  $rowSpanParent }}">{{ @$info->main_defendants_name }}</td>
                    
                </tr>
                @foreach ($info->direct_services as $direct_service)
                    @if (@$direct_service->service_type_id == 1)
                        <tr>
                            <td valign="center"> Assistance to treatment /medical support </td>
                            <td valign="center">{{ @$direct_service->service_date ? date('d-m-Y', strtotime(@$direct_service->service_date)): '-' }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    @elseif (@$direct_service->service_type_id == 2)
                        <tr>
                            <td valign="center"> Assistance to OCC </td>
                            <td valign="center">{{ @$direct_service->service_date ? date('d-m-Y', strtotime(@$direct_service->service_date)): '-' }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    @elseif (@$direct_service->service_type_id == 5)
                        <tr>
                            <td valign="center"> Assistance to Police Station  </td>
                            <td valign="center">{{ @$direct_service->service_date ? date('d-m-Y', strtotime(@$direct_service->service_date)): '-' }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    @elseif (@$direct_service->service_type_id == 6)
                        <tr>
                            <td valign="center">Phycosocial Counselling </td>
                            <td valign="center">{{ @$direct_service->service_date ? date('d-m-Y', strtotime(@$direct_service->service_date)): '-' }}</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                            <td>-</td>
                        </tr>
                    @elseif (@$direct_service->service_type_id == 3)
                        <tr>
                            
                            <td valign="center" rowspan="{{ count(@$direct_service->direct_adrs) + 1 }}">Alternative Dispute Resolution (ADR) </td>
                            <td valign="center" rowspan="{{ count(@$direct_service->direct_adrs) + 1 }}">-</td>
                        
                        </tr>

                        @foreach ($direct_service->direct_adrs as $adr)
                            <tr>
                                <td>{{ @$adr->alternative_dispute_resolution->title }}</td>
                                <td>
                                    {{ @$adr->starting_date ? date('d-m-Y', strtotime(@$adr->starting_date)) : '-' }}
                                    {{-- @if (@$adr->alternative_dispute_resolution->id == 7 || @$adr->alternative_dispute_resolution->id == 9 || @$adr->alternative_dispute_resolution->id == 10 || @$adr->alternative_dispute_resolution->id == 11 )
                                        
                                        {{ @$adr->closing_date ? date('d-m-Y', strtotime(@$adr->closing_date)) : '-' }}
                                    @else
                                        {{ @$adr->starting_date ? date('d-m-Y', strtotime(@$adr->starting_date)) : '-' }}
                                    @endif --}}
                                </td>
                                <td>
                                    {{ @$adr->closing_date ? date('d-m-Y', strtotime(@$adr->closing_date)) : '-' }}
                                </td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                        @endforeach
                
                    @elseif (@$direct_service->service_type_id == 4)
                        <tr>
                            <td valign="center" rowspan="{{ count(@$direct_service->court_case) + 1 }}">Assistance with court case   </td>
                            <td valign="center" rowspan="{{ count(@$direct_service->court_case) + 1 }}">-</td>
                            <td valign="center" rowspan="{{ count(@$direct_service->court_case) + 1 }}">-</td>
                            <td valign="center" rowspan="{{ count(@$direct_service->court_case) + 1 }}">-</td>
                            <td valign="center" rowspan="{{ count(@$direct_service->court_case) + 1 }}">-</td>
                        </tr>
                        @foreach ($direct_service->court_case as $cse)
                            @if (@$cse->case_type == 1)
                                <tr>
                                    <td>Civil cases</td>
                                    <td>{{ @$cse->civil_case->title }}</td>
                                    <td> 
                                        {{ @$cse->case_start_date ? date('d-m-Y', strtotime(@$cse->case_start_date)) : '-' }}
                                        {{-- @if (@$cse->civil_case->id == 23)
                                            {{ @$cse->case_judjement_date ? date('d-m-Y', strtotime(@$cse->case_judjement_date)) : '-' }}
                                        @else
                                            {{ @$cse->case_start_date ? date('d-m-Y', strtotime(@$cse->case_start_date)) : '-' }}
                                        @endif  --}}
                                    </td>
                                    <td>
                                        {{ @$cse->case_judjement_date ? date('d-m-Y', strtotime(@$cse->case_judjement_date)) : '-' }}
                                    </td>
                                </tr>
                            @elseif (@$cse->case_type == 2)
                                <tr>
                                    <td>GR/Police Case</td>
                                    <td>{{ @$cse->police_case->title }}</td>
                                    <td>
                                        {{ @$cse->case_start_date ? date('d-m-Y', strtotime(@$cse->case_start_date)) : '-' }}
                                        {{-- @if (@$cse->police_case->id == 22)
                                            {{ @$cse->case_judjement_date ? date('d-m-Y', strtotime(@$cse->case_judjement_date)) : '-' }}
                                        @else
                                            {{ @$cse->case_start_date ? date('d-m-Y', strtotime(@$cse->case_start_date)) : '-' }}
                                        @endif  --}}
                                    </td>
                                    <td>
                                        {{ @$cse->case_judjement_date ? date('d-m-Y', strtotime(@$cse->case_judjement_date)) : '-' }}
                                    </td>
                                </tr>
                            @elseif (@$cse->case_type == 3)
                                <tr>
                                    <td>CR/Petition Case</td>
                                    <td>{{ @$cse->petition_case->title }}</td>
                                    <td>
                                        {{ @$cse->case_start_date ? date('d-m-Y', strtotime(@$cse->case_start_date)) : '-' }}
                                        {{-- @if (@$cse->petition_case->id == 26)
                                            {{ @$cse->case_judjement_date ? date('d-m-Y', strtotime(@$cse->case_judjement_date)) : '-' }}
                                        @else
                                            {{ @$cse->case_start_date ? date('d-m-Y', strtotime(@$cse->case_start_date)) : '-' }}
                                        @endif  --}}
                                    </td>
                                    <td>
                                        {{ @$cse->case_judjement_date ? date('d-m-Y', strtotime(@$cse->case_judjement_date)) : '-' }}
                                    </td>
                                </tr>
                            @endif
                            
                        @endforeach
                    
                    @endif   
                @endforeach

            @endif    
        @endforeach

    </tbody>
</table>
