<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
<table class="table table-bordered">
    <thead>
        <tr>
            <th style="background-color: #cfcfcf;">Reporting Date</th>
            <th style="background-color: #cfcfcf;">Data Entry No.</th>
            <th style="background-color: #cfcfcf;">Zone</th>
            <th style="background-color: #cfcfcf;">Division</th>
            <th style="background-color: #cfcfcf;">District</th>
            <th style="background-color: #cfcfcf;">Upazila</th>
            <th style="background-color: #cfcfcf;width: 500px;">Meeting</th>
            <th style="background-color: #cfcfcf;width: 500px;">Training/Orientation</th>
            <th style="background-color: #cfcfcf;width: 500px;">Community Level Awareness</th>
            <th style="background-color: #cfcfcf;width: 500px;">Campaign and Day Observation</th>
            <th style="background-color: #cfcfcf;width: 500px;">PT Show</th>
            <th style="background-color: #cfcfcf;width: 500px;">PT Production Workshop</th>
        </tr>
    </thead>
    <tbody>
        @foreach($activities as $data)
            <tr>
                <td>{{ @$data['reporting_date'] == null ? '' : @$data['reporting_date']}}</td>
                <td>{{ @$data['id'] }}</td>
                <td>{{ @$data['zones']['region_name'] }}</td>
                <td>{{ @$data['division']['name'] }}</td>
                <td>{{ @$data['district']['name'] }}</td>
                <td>{{ @$data['upazilla']['name'] }}</td>
                <td>
                    @php
                        $types='';
                    @endphp
                    @foreach (@$data['meeting_activity'] as $item)
                    {{-- {{ dd(@$item->event_name->name) }} --}}
                    @php
                        $event_name = App\Model\Setup\MeetingEvent::where('id', @$item['event_id'])->first();
                        $types.=' { Event name - '.@$event_name->name.', No. of Events - '.@$item['no_of_event'].', Starting Date - '.(@$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null).', Ending Date - '.(@$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null).', Participants - (Boy - '.@$item['participant_boys'].', Girls - '.@$item['participant_girls'].', Men - '.@$item['participant_men'].', Women - '.@$item['participant_women'].', Other Gender - '.@$item['participant_other_gender'].', Total - '.@$item['participant_total'].'), PWD - (Boy - '.@$item['participant_pwd_boys'].', Girls - '.@$item['participant_pwd_girls'].', Men - '.@$item['participant_pwd_men'].', Women - '.@$item['participant_pwd_women'].', Other Gender - '.@$item['participant_pwd_other_gender'].', Total - '.@$item['participant_pwd_total'].')} , ';
                    @endphp
                        
                    @endforeach
    
                    {{$types}}
                </td>
                <td>
                    @php
                        $types='';
                    @endphp
                    @foreach (@$data['training_activity'] as $item)
                    {{-- {{ dd(@$item->event_name->name) }} --}}
                    @php
                        $event_name = App\Model\Setup\TrainingEvent::where('id', @$item['event_id'])->first();
                        $types.=' { Event name - '.@$event_name->name.', No. of Events - '.@$item['no_of_event'].', Starting Date - '.(@$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null).', Ending Date - '.(@$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null).', Participants - (Boy - '.@$item['participant_boys'].', Girls - '.@$item['participant_girls'].', Men - '.@$item['participant_men'].', Women - '.@$item['participant_women'].', Other Gender - '.@$item['participant_other_gender'].', Total - '.@$item['participant_total'].'), PWD - (Boy - '.@$item['participant_pwd_boys'].', Girls - '.@$item['participant_pwd_girls'].', Men - '.@$item['participant_pwd_men'].', Women - '.@$item['participant_pwd_women'].', Other Gender - '.@$item['participant_pwd_other_gender'].', Total - '.@$item['participant_pwd_total'].')} , ';
                    @endphp
                        
                    @endforeach
    
                    {{$types}}
                </td>
                <td>
                    @php
                        $types='';
                    @endphp
                    @foreach (@$data['community_activity'] as $item)
                    {{-- {{ dd(@$item->event_name->name) }} --}}
                    @php
                        $event_name = App\Model\Setup\CommunityEvent::where('id', @$item['event_id'])->first();
                        $types.=' { Event name - '.@$event_name->name.', No. of Events - '.@$item['no_of_event'].', Starting Date - '.(@$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null).', Ending Date - '.(@$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null).', Participants - (Boy - '.@$item['participant_boys'].', Girls - '.@$item['participant_girls'].', Men - '.@$item['participant_men'].', Women - '.@$item['participant_women'].', Other Gender - '.@$item['participant_other_gender'].', Total - '.@$item['participant_total'].'), PWD - (Boy - '.@$item['participant_pwd_boys'].', Girls - '.@$item['participant_pwd_girls'].', Men - '.@$item['participant_pwd_men'].', Women - '.@$item['participant_pwd_women'].', Other Gender - '.@$item['participant_pwd_other_gender'].', Total - '.@$item['participant_pwd_total'].')} , ';
                    @endphp
                        
                    @endforeach
    
                    {{$types}}
                </td>
                <td>
                    @php
                        $types='';
                    @endphp
                    @foreach (@$data['campaign_activity'] as $item)
                    {{-- {{ dd(@$item->event_name->name) }} --}}
                    @php
                        $event_name = App\Model\Setup\CampaignEvent::where('id', @$item['event_id'])->first();
                        $types.=' { Event name - '.@$event_name->name.', No. of Events - '.@$item['no_of_event'].', Starting Date - '.(@$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null).', Ending Date - '.(@$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null).', Participants - (Boy - '.@$item['participant_boys'].', Girls - '.@$item['participant_girls'].', Men - '.@$item['participant_men'].', Women - '.@$item['participant_women'].', Other Gender - '.@$item['participant_other_gender'].', Total - '.@$item['participant_total'].'), PWD - (Boy - '.@$item['participant_pwd_boys'].', Girls - '.@$item['participant_pwd_girls'].', Men - '.@$item['participant_pwd_men'].', Women - '.@$item['participant_pwd_women'].', Other Gender - '.@$item['participant_pwd_other_gender'].', Total - '.@$item['participant_pwd_total'].')} , ';
                    @endphp
                        
                    @endforeach
    
                    {{$types}}
                </td>
                <td>
                    @php
                        $types='';
                    @endphp
                    @foreach (@$data['pt_show_activity'] as $item)
                    {{-- {{ dd(@$item->event_name->name) }} --}}
                    @php
                        $event_name = App\Model\Setup\PTshowEvent::where('id', @$item['event_id'])->first();
                        $types.=' { Event name - '.@$event_name->name.', No. of Events - '.@$item['no_of_event'].', Starting Date - '.(@$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null).', Ending Date - '.(@$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null).', Participants - (Boy - '.@$item['participant_boys'].', Girls - '.@$item['participant_girls'].', Men - '.@$item['participant_men'].', Women - '.@$item['participant_women'].', Other Gender - '.@$item['participant_other_gender'].', Total - '.@$item['participant_total'].'), PWD - (Boy - '.@$item['participant_pwd_boys'].', Girls - '.@$item['participant_pwd_girls'].', Men - '.@$item['participant_pwd_men'].', Women - '.@$item['participant_pwd_women'].', Other Gender - '.@$item['participant_pwd_other_gender'].', Total - '.@$item['participant_pwd_total'].')} , ';
                    @endphp
                        
                    @endforeach
    
                    {{$types}}
                </td>
                <td>
                    @php
                        $types='';
                    @endphp
                    @foreach (@$data['pt_production_activity'] as $item)
                    {{-- {{ dd(@$item->event_name->name) }} --}}
                    @php
                        $event_name = App\Model\Setup\PTproductionEvent::where('id', @$item['event_id'])->first();
                        $types.=' { Event name - '.@$event_name->name.', No. of Events - '.@$item['no_of_event'].', Starting Date - '.(@$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null).', Ending Date - '.(@$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null).', Participants - (Boy - '.@$item['participant_boys'].', Girls - '.@$item['participant_girls'].', Men - '.@$item['participant_men'].', Women - '.@$item['participant_women'].', Other Gender - '.@$item['participant_other_gender'].', Total - '.@$item['participant_total'].'), PWD - (Boy - '.@$item['participant_pwd_boys'].', Girls - '.@$item['participant_pwd_girls'].', Men - '.@$item['participant_pwd_men'].', Women - '.@$item['participant_pwd_women'].', Other Gender - '.@$item['participant_pwd_other_gender'].', Total - '.@$item['participant_pwd_total'].')} , ';
                    @endphp
                        
                    @endforeach
    
                    {{$types}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
