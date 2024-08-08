<table>
      <tr>
        <th colspan="10" style="font-weight: bold">Data Entry for month: {{ date('d-M-Y', strtotime($activity->created_at)) }}<span>Reporting Date: {{ $activity->reporting_date  == null ? '' : date('d-M-Y', strtotime($activity->reporting_date)) }}</span></th>
      </tr>
      <tr>
        <td><strong>Name</strong></td>
        <td>{{ @$activity->employee_name }}</td>
        <td><strong>Mobile N</strong></td>
        <td>{{ @$activity->employee_mobile_number }}</td>
        <td><strong>Designatio</strong></td>
        <td>{{ @$activity->employee_designation }}</td>
        <td><strong>PI</strong></td>
        <td>{{ @$activity->employee_pin }}</td>
        <td><strong>Zon</strong></td>
        <td>{{ @$activity['zones']['region_name'] }}</td>
        <td><strong>Divisio</strong></td>
        <td>{{ @$activity['division']['name'] }}</td>
        <td><strong>Distric</strong></td>
        <td>{{ @$activity['district']['name'] }}</td>
        <td><strong>Upazila</strong></td>
        <td >{{ @$activity['upazilla']['name'] }}</td>
      </tr>
  </table>

  @if (count(@$activity['meeting_activity']) > 0)
    <table>
        <tr>
        <td colspan="8" style="font-weight: bold">1. Meeting/Workshop</td>
        </tr>
    </table>
  @endif
  @foreach (@$activity['meeting_activity'] as $item)
    @php
        $event_name = App\Model\Setup\MeetingEvent::where('id', @$item['event_id'])->first();
    @endphp
    <table>
        <tr>
          <td><strong>Event name</strong></td>
          <td>{{ @$event_name->name }}</td>
          <td><strong>No. of Events </strong></td>
          <td>{{ @$item['no_of_event'] }}</td>
          <td><strong>Starting Date </strong></td>
          <td>{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null }}</td>
          <td><strong>Ending Date </strong></td>
          <td>{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null }}</td>
        </tr>
        <tr>
          <td colspan="2"></td>
          <td><strong>Boys</strong></td>
          <td><strong>Girls</strong></td>
          <td><strong>Male</strong></td>
          <td><strong>Female</strong></td>
          <td><strong>Transgender</strong></td>
          <td><strong>Total</strong></td>
        </tr>
        <tr>
          <td colspan="2"><strong>No. of Participants</strong></td>
          <td>{{ @$item['participant_boys'] }}</td>
          <td>{{ @$item['participant_girls'] }}</td>
          <td>{{ @$item['participant_men'] }}</td>
          <td>{{ @$item['participant_women'] }}</td>
          <td>{{ @$item['participant_other_gender'] }}</td>
          <td>{{ @$item['participant_total'] }}</td>
        </tr>
        <tr>
          <td colspan="2"><strong>PWD</strong></td>
          <td>{{ @$item['participant_pwd_boys'] }}</td>
          <td>{{ @$item['participant_pwd_girls'] }}</td>
          <td>{{ @$item['participant_pwd_men'] }}</td>
          <td>{{ @$item['participant_pwd_women'] }}</td>
          <td>{{ @$item['participant_pwd_other_gender'] }}</td>
          <td>{{ @$item['participant_pwd_total'] }}</td>
        </tr>
    </table>
  @endforeach

  @if (count(@$activity['training_activity']) > 0)
    <table>
        <tr>
        <td colspan="8" style="font-weight: bold">2. Training/ Orientation</td>
        </tr>
    </table>
  @endif
  
  @foreach (@$activity['training_activity'] as $item)
    @php
        $event_name = App\Model\Setup\TrainingEvent::where('id', @$item['event_id'])->first();
    @endphp
    <table>
        <tr>
          <td><strong>Event name </strong></td>
          <td>{{ @$event_name->name }}</td>
          <td><strong>No. of Events </strong></td>
          <td>{{ @$item['no_of_event'] }}</td>
          <td><strong>Starting Date </strong></td>
          <td>{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null }}</td>
          <td><strong>Ending Date </strong></td>
          <td>{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null }}</td>
        </tr>

        <tr>
          <td colspan="2"></td>
          <td><strong>Boys </strong></td>
          <td><strong>Girls </strong></td>
          <td><strong>Male </strong></td>
          <td><strong>Female </strong></td>
          <td><strong>Transgender </strong></td>
          <td><strong>Total </strong></td>
        </tr>

        <tr>
          <td colspan="2"><strong>No. of Participants </strong></td>
          <td>{{ @$item['participant_boys'] }}</td>
          <td>{{ @$item['participant_girls'] }}</td>
          <td>{{ @$item['participant_men'] }}</td>
          <td>{{ @$item['participant_women'] }}</td>
          <td>{{ @$item['participant_other_gender'] }}</td>
          <td>{{ @$item['participant_total'] }}</td>
        </tr>

        <tr>
          <td colspan="2"><strong>PWD</strong></td>
          <td>{{ @$item['participant_pwd_boys'] }}</td>
          <td>{{ @$item['participant_pwd_girls'] }}</td>
          <td>{{ @$item['participant_pwd_men'] }}</td>
          <td>{{ @$item['participant_pwd_women'] }}</td>
          <td>{{ @$item['participant_pwd_other_gender'] }}</td>
          <td>{{ @$item['participant_pwd_total'] }}</td>
        </tr>
    </table>
  @endforeach

  @if (count(@$activity['community_activity']) > 0)
    <table >
        <tr>
        <td colspan="8" style="font-weight: bold">3. Community Level Awareness</td>
        </tr>
    </table>      
  @endif
  @foreach (@$activity['community_activity'] as $item)
    @php
        $event_name = App\Model\Setup\CommunityEvent::where('id', @$item['event_id'])->first();
    @endphp
    <table>
      <tbody>
        <tr>
          <td><strong>Event name </strong></td>
          <td>{{ @$event_name->name }}</td>
          <td><strong>No. of Events </strong></td>
          <td>{{ @$item['no_of_event'] }}</td>
          <td><strong>Starting Date </strong></td>
          <td>{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null }}</td>
          <td><strong>Ending Date </strong></td>
          <td>{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null }}</td>
        </tr>

        <tr>
          <td colspan="2"></td>
          <td><strong>Boys </strong></td>
          <td><strong>Girls </strong></td>
          <td><strong>Male </strong></td>
          <td><strong>Female </strong></td>
          <td><strong>Transgender </strong></td>
          <td><strong>Total </strong></td>
        </tr>

        <tr>
          <td colspan="2"><strong>No. of Participants</strong></td>
          <td>{{ @$item['participant_boys'] }}</td>
          <td>{{ @$item['participant_girls'] }}</td>
          <td>{{ @$item['participant_men'] }}</td>
          <td>{{ @$item['participant_women'] }}</td>
          <td>{{ @$item['participant_other_gender'] }}</td>
          <td>{{ @$item['participant_total'] }}</td>
        </tr>

        <tr>
          <td colspan="2"><strong>PWD</strong></td>
          <td>{{ @$item['participant_pwd_boys'] }}</td>
          <td>{{ @$item['participant_pwd_girls'] }}</td>
          <td>{{ @$item['participant_pwd_men'] }}</td>
          <td>{{ @$item['participant_pwd_women'] }}</td>
          <td>{{ @$item['participant_pwd_other_gender'] }}</td>
          <td>{{ @$item['participant_pwd_total'] }}</td>
        </tr>
      </tbody>
    </table>
  @endforeach

  @if (count(@$activity['campaign_activity']) > 0)
    <table>
        <tr>
        <td colspan="8" style="font-weight: bold">4. Campaign and Day Observation</td>
        </tr>
    </table>
  @endif
  @foreach (@$activity['campaign_activity'] as $item)
    @php
        $event_name = App\Model\Setup\CampaignEvent::where('id', @$item['event_id'])->first();
    @endphp
    <table>
      <tbody>
        <tr>
          <td><strong>Event name </strong></td>
          <td>{{ @$event_name->name }}</td>
          <td><strong>No. of Events </strong></td>
          <td>{{ @$item['no_of_event'] }}</td>
          <td><strong>Starting Date </strong></td>
          <td>{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null }}</td>
          <td><strong>Ending Date </strong></td>
          <td>{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null }}</td>
        </tr>

        <tr>
          <td colspan="2"></td>
          <td><strong>Boys </strong></td>
          <td><strong>Girls </strong></td>
          <td><strong>Male </strong></td>
          <td><strong>Female </strong></td>
          <td><strong>Transgender </strong></td>
          <td><strong>Total </strong></td>
        </tr>

        <tr>
          <td colspan="2"><strong>No. of Participants</strong></td>
          <td>{{ @$item['participant_boys'] }}</td>
          <td>{{ @$item['participant_girls'] }}</td>
          <td>{{ @$item['participant_men'] }}</td>
          <td>{{ @$item['participant_women'] }}</td>
          <td>{{ @$item['participant_other_gender'] }}</td>
          <td>{{ @$item['participant_total'] }}</td>
        </tr>

        <tr>
          <td colspan="2"><strong>PWD</strong></td>
          <td>{{ @$item['participant_pwd_boys'] }}</td>
          <td>{{ @$item['participant_pwd_girls'] }}</td>
          <td>{{ @$item['participant_pwd_men'] }}</td>
          <td>{{ @$item['participant_pwd_women'] }}</td>
          <td>{{ @$item['participant_pwd_other_gender'] }}</td>
          <td>{{ @$item['participant_pwd_total'] }}</td>
        </tr>
      </tbody>
    </table>
  @endforeach


  @if (count(@$activity['pt_show_activity']) > 0)
    <table class="tg" width="100%">
        <tr>
        <td colspan="8" style="font-weight: bold">5. PT Show</td>
        </tr>
    </table>
  @endif
  @foreach (@$activity['pt_show_activity'] as $item)
    @php
        $event_name = App\Model\Setup\PTshowEvent::where('id', @$item['event_id'])->first();
    @endphp
    <table class="tg" width="100%">
      <tbody>
        <tr>
          <td><strong>Event name </strong></td>
          <td>{{ @$event_name->name }}</td>
          <td><strong>No. of Events </strong></td>
          <td>{{ @$item['no_of_event'] }}</td>
          <td><strong>Starting Date </strong></td>
          <td>{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null }}</td>
          <td><strong>Ending Date </strong></td>
          <td>{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null }}</td>
        </tr>

        <tr>
          <td colspan="2"></td>
          <td><strong>Boys </strong></td>
          <td><strong>Girls </strong></td>
          <td><strong>Male </strong></td>
          <td><strong>Female </strong></td>
          <td><strong>Transgender </strong></td>
          <td><strong>Total </strong></td>
        </tr>

        <tr>
          <td colspan="2"><strong>No. of Participants</strong></td>
          <td>{{ @$item['participant_boys'] }}</td>
          <td>{{ @$item['participant_girls'] }}</td>
          <td>{{ @$item['participant_men'] }}</td>
          <td>{{ @$item['participant_women'] }}</td>
          <td>{{ @$item['participant_other_gender'] }}</td>
          <td>{{ @$item['participant_total'] }}</td>
        </tr>

        <tr>
          <td colspan="2"><strong>PWD</strong></td>
          <td>{{ @$item['participant_pwd_boys'] }}</td>
          <td>{{ @$item['participant_pwd_girls'] }}</td>
          <td>{{ @$item['participant_pwd_men'] }}</td>
          <td>{{ @$item['participant_pwd_women'] }}</td>
          <td>{{ @$item['participant_pwd_other_gender'] }}</td>
          <td>{{ @$item['participant_pwd_total'] }}</td>
        </tr>
      </tbody>
    </table>
  @endforeach

  @if (count(@$activity['pt_production_activity']) > 0)
    <table>
        <tr>
        <th colspan="8" style="font-weight: bold">6. PT Production Workshop</th>
        </tr>
    </table>
  @endif
  @foreach (@$activity['pt_production_activity'] as $item)
    @php
        $event_name = App\Model\Setup\PTproductionEvent::where('id', @$item['event_id'])->first();
    @endphp
    <table>
      <tbody>
        <tr>
          <td><strong>Event name </strong></td>
          <td>{{ @$event_name->name }}</td>
          <td><strong>No. of Events </strong></td>
          <td>{{ @$item['no_of_event'] }}</td>
          <td><strong>Starting Date </strong></td>
          <td>{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null }}</td>
          <td><strong>Ending Date </strong></td>
          <td>{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null }}</td>
        </tr>

        <tr>
          <td colspan="2"></td>
          <td><strong>Boys </strong></td>
          <td><strong>Girls </strong></td>
          <td><strong>Male </strong></td>
          <td><strong>Female </strong></td>
          <td><strong>Transgender </strong></td>
          <td><strong>Total </strong></td>
        </tr>

        <tr>
          <td colspan="2"><strong>No. of Participants</strong></td>
          <td>{{ @$item['participant_boys'] }}</td>
          <td>{{ @$item['participant_girls'] }}</td>
          <td>{{ @$item['participant_men'] }}</td>
          <td>{{ @$item['participant_women'] }}</td>
          <td>{{ @$item['participant_other_gender'] }}</td>
          <td>{{ @$item['participant_total'] }}</td>
        </tr>

        <tr>
          <td colspan="2"><strong>PWD</strong></td>
          <td>{{ @$item['participant_pwd_boys'] }}</td>
          <td>{{ @$item['participant_pwd_girls'] }}</td>
          <td>{{ @$item['participant_pwd_men'] }}</td>
          <td>{{ @$item['participant_pwd_women'] }}</td>
          <td>{{ @$item['participant_pwd_other_gender'] }}</td>
          <td>{{ @$item['participant_pwd_total'] }}</td>
        </tr>
      </tbody>
    </table>
  @endforeach