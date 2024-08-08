<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style type="text/css">

table {
  border-collapse: collapse;
}
h2 h3{
  margin:0;
  padding:0;
}
.table {
  width: 100%;
  margin-bottom: 1rem;
  background-color: transparent;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table .table {
  background-color: #fff;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

.text-center{
  text-align: center;
}
.text-right{
  text-align: right;
}
table tr td{
  padding: 5px;
}

.table-bordered thead th, .table-bordered td, .table-bordered th{
   border: 1px solid black !important;
}

.table-bordered thead th{
  background-color:  #cacaca;
}

.tg  {border-collapse:collapse;border-spacing:0;}
.tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  overflow:hidden;padding:10px 5px;word-break:normal;}
.tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
  font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
.tg .tg-0pky{border-color:inherit;text-align:left;vertical-align:top}
.tg .table_th{text-align:right !important;}

.data_entry {
  width: 60px;
}

.member_width {
  width: 60px;
}

@media print {
  .page_break {page-break-after: always;}
}

.table_bg{
  background-color: #c9c9c9e7 !important;
}

.width-fixed {
  width: 100px;
}

.text-bold {
  font-weight: bold;
}

</style>
<body>
  <div class="container">
    <!-- <div class="row">
      <div style="width: 17%; float: left;" class="text-center">
        <img src="{{asset('backend/images/logo.png')}}">
      </div>
      <div class="text-center" style="width: 68%; float: left;">
          <h4><strong>Violence Against Women and Children </strong></h4>
          <h5><strong>75 Mohakhali, Dhaka-1212</strong></h5>
      </div>
    </div> -->
    <div class="row">
      <div class="col-sm-12">
        <div class="text-center">
        <img style="width: 100px;height: 40px;" src="{{asset('backend/images/logo-original.png')}}">
      </div>
      <div class="text-center">
          <h4><strong>Social Empowerment and Legal Protection (SELP) </strong></h4>
          <h5><strong>Activity</strong></h5>
          <h5><strong>75 Mohakhali, Dhaka-1212</strong></h5>
          <h5 style="font-weight: bold">Data Entry No : {{ formatIncidentId($activity->id) }} | Posting Date : {{ date('d-m-Y', strtotime($activity->created_at)) }}</h5>
      </div>
    </div>

    <div class="row">
    </div>
    </div>
    <div class="row"> 
      <div class="col-sm-12">

        {{-- 1. Data Entry for month --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="6" style="font-weight: bold">1. Data Entry for month: {{ date('d-M-Y', strtotime($activity->created_at)) }} &nbsp;&nbsp;,&nbsp;&nbsp; <span>Reporting Date: {{ $activity->reporting_date  == null ? '' : date('d-M-Y', strtotime($activity->reporting_date)) }}</span></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky data_entry">Name</td>
              <td class="tg-0pky data_entry">{{ @$activity->employee_name }}</td>
              <td class="tg-0pky data_entry">Mobile No</td>
              <td class="tg-0pky data_entry">{{ @$activity->employee_mobile_number }}</td>
              <td class="tg-0pky data_entry">Designation</td>
              <td class="tg-0pky data_entry">{{ @$activity->employee_designation }}</td>
            </tr>
            <tr>
              <td class="tg-0pky data_entry">PIN</td>
              <td class="tg-0pky data_entry">{{ @$activity->employee_pin }}</td>
              <td class="tg-0pky data_entry">Zone</td>
              <td class="tg-0pky data_entry">{{ @$activity['zones']['region_name'] }}</td>
              <td class="tg-0pky data_entry">Division</td>
              <td class="tg-0pky data_entry">{{ @$activity['division']['name'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky data_entry">District</td>
              <td class="tg-0pky data_entry">{{ @$activity['district']['name'] }}</td>
              <td class="tg-0pky data_entry">Upazila:</td>
              <td class="tg-0pky data_entry" colspan="3" >{{ @$activity['upazilla']['name'] }}</td>
            </tr>
          </tbody>
        </table>

        <br>
        {{-- 1. Meeting --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="7" style="font-weight: bold">1. Meeting/Workshop</th>
            </tr>
          </thead>
        </table>
        @foreach (@$activity['meeting_activity'] as $item)
          @php
              $event_name = App\Model\Setup\MeetingEvent::where('id', @$item['event_id'])->first();
          @endphp
          <br>
          <table class="tg" width="100%">
            <tbody>
              <tr>
                <td class="tg-0pky width-fixed">Event name</td>
                <td class="tg-0pky width-fixed">{{ @$event_name->name }}</td>
                <td class="tg-0pky width-fixed">No. of Events</td>
                <td class="tg-0pky width-fixed">{{ @$item['no_of_event'] }}</td>
                <td class="tg-0pky width-fixed">Starting Date</td>
                <td class="tg-0pky width-fixed">{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null }}</td>
                <td class="tg-0pky width-fixed">Ending Date</td>
                <td class="tg-0pky width-fixed">{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null }}</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2"></td>
                <td class="tg-0pky">Boys</td>
                <td class="tg-0pky">Girls</td>
                <td class="tg-0pky">Male</td>
                <td class="tg-0pky">Female</td>
                <td class="tg-0pky">Transgender</td>
                <td class="tg-0pky">Total</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2">No. of Participants</td>
                <td class="tg-0pky">{{ @$item['participant_boys'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_girls'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_men'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_women'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_other_gender'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_total'] }}</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2">PWD</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_boys'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_girls'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_men'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_women'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_other_gender'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_total'] }}</td>
              </tr>
            </tbody>
          </table>
        @endforeach
        <br>

        {{-- 3. Training/ Orientation --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="7" style="font-weight: bold">2. Training/ Orientation</th>
            </tr>
          </thead>
        </table>
        @foreach (@$activity['training_activity'] as $item)
          @php
              $event_name = App\Model\Setup\TrainingEvent::where('id', @$item['event_id'])->first();
          @endphp
          <br>
          <table class="tg" width="100%">
            <tbody>
              <tr>
                <td class="tg-0pky width-fixed">Event name</td>
                <td class="tg-0pky width-fixed">{{ @$event_name->name }}</td>
                <td class="tg-0pky width-fixed">No. of Events</td>
                <td class="tg-0pky width-fixed">{{ @$item['no_of_event'] }}</td>
                <td class="tg-0pky width-fixed">Starting Date</td>
                <td class="tg-0pky width-fixed">{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null }}</td>
                <td class="tg-0pky width-fixed">Ending Date</td>
                <td class="tg-0pky width-fixed">{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null }}</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2"></td>
                <td class="tg-0pky">Boys</td>
                <td class="tg-0pky">Girls</td>
                <td class="tg-0pky">Male</td>
                <td class="tg-0pky">Female</td>
                <td class="tg-0pky">Transgender</td>
                <td class="tg-0pky">Total</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2">No. of Participants</td>
                <td class="tg-0pky">{{ @$item['participant_boys'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_girls'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_men'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_women'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_other_gender'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_total'] }}</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2">PWD</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_boys'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_girls'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_men'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_women'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_other_gender'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_total'] }}</td>
              </tr>
            </tbody>
          </table>
        @endforeach
        <br>

        {{-- 3. Community Level Awareness --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="7" style="font-weight: bold">3. Community Level Awareness</th>
            </tr>
          </thead>
        </table>
        @foreach (@$activity['community_activity'] as $item)
          @php
              $event_name = App\Model\Setup\CommunityEvent::where('id', @$item['event_id'])->first();
          @endphp
          <br>
          <table class="tg" width="100%">
            <tbody>
              <tr>
                <td class="tg-0pky width-fixed">Event name</td>
                <td class="tg-0pky width-fixed">{{ @$event_name->name }}</td>
                <td class="tg-0pky width-fixed">No. of Events</td>
                <td class="tg-0pky width-fixed">{{ @$item['no_of_event'] }}</td>
                <td class="tg-0pky width-fixed">Starting Date</td>
                <td class="tg-0pky width-fixed">{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null }}</td>
                <td class="tg-0pky width-fixed">Ending Date</td>
                <td class="tg-0pky width-fixed">{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null }}</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2"></td>
                <td class="tg-0pky">Boys</td>
                <td class="tg-0pky">Girls</td>
                <td class="tg-0pky">Male</td>
                <td class="tg-0pky">Female</td>
                <td class="tg-0pky">Transgender</td>
                <td class="tg-0pky">Total</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2">No. of Participants</td>
                <td class="tg-0pky">{{ @$item['participant_boys'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_girls'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_men'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_women'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_other_gender'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_total'] }}</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2">PWD</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_boys'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_girls'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_men'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_women'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_other_gender'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_total'] }}</td>
              </tr>
            </tbody>
          </table>
        @endforeach
        <br>

        {{-- 4. Campaign and Day Observation --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="7" style="font-weight: bold">4. Campaign and Day Observation</th>
            </tr>
          </thead>
        </table>
        @foreach (@$activity['campaign_activity'] as $item)
          @php
              $event_name = App\Model\Setup\CampaignEvent::where('id', @$item['event_id'])->first();
          @endphp
          <br>
          <table class="tg" width="100%">
            <tbody>
              <tr>
                <td class="tg-0pky width-fixed">Event name</td>
                <td class="tg-0pky width-fixed">{{ @$event_name->name }}</td>
                <td class="tg-0pky width-fixed">No. of Events</td>
                <td class="tg-0pky width-fixed">{{ @$item['no_of_event'] }}</td>
                <td class="tg-0pky width-fixed">Starting Date</td>
                <td class="tg-0pky width-fixed">{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null }}</td>
                <td class="tg-0pky width-fixed">Ending Date</td>
                <td class="tg-0pky width-fixed">{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null }}</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2"></td>
                <td class="tg-0pky">Boys</td>
                <td class="tg-0pky">Girls</td>
                <td class="tg-0pky">Male</td>
                <td class="tg-0pky">Female</td>
                <td class="tg-0pky">Transgender</td>
                <td class="tg-0pky">Total</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2">No. of Participants</td>
                <td class="tg-0pky">{{ @$item['participant_boys'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_girls'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_men'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_women'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_other_gender'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_total'] }}</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2">PWD</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_boys'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_girls'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_men'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_women'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_other_gender'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_total'] }}</td>
              </tr>
            </tbody>
          </table>
        @endforeach
        <br>

        {{-- 5. PT Show --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="7" style="font-weight: bold">5. PT Show</th>
            </tr>
          </thead>
        </table>
        @foreach (@$activity['pt_show_activity'] as $item)
          @php
              $event_name = App\Model\Setup\PTshowEvent::where('id', @$item['event_id'])->first();
          @endphp
          <br>
          <table class="tg" width="100%">
            <tbody>
              <tr>
                <td class="tg-0pky width-fixed">Event name</td>
                <td class="tg-0pky width-fixed">{{ @$event_name->name }}</td>
                <td class="tg-0pky width-fixed">No. of Events</td>
                <td class="tg-0pky width-fixed">{{ @$item['no_of_event'] }}</td>
                <td class="tg-0pky width-fixed">Starting Date</td>
                <td class="tg-0pky width-fixed">{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null }}</td>
                <td class="tg-0pky width-fixed">Ending Date</td>
                <td class="tg-0pky width-fixed">{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null }}</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2"></td>
                <td class="tg-0pky">Boys</td>
                <td class="tg-0pky">Girls</td>
                <td class="tg-0pky">Male</td>
                <td class="tg-0pky">Female</td>
                <td class="tg-0pky">Transgender</td>
                <td class="tg-0pky">Total</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2">No. of Participants</td>
                <td class="tg-0pky">{{ @$item['participant_boys'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_girls'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_men'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_women'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_other_gender'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_total'] }}</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2">PWD</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_boys'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_girls'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_men'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_women'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_other_gender'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_total'] }}</td>
              </tr>
            </tbody>
          </table>
        @endforeach
        <br>

        {{-- 6. PT Production Workshop --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="7" style="font-weight: bold">6. PT Production Workshop</th>
            </tr>
          </thead>
        </table>
        @foreach (@$activity['pt_production_activity'] as $item)
          @php
              $event_name = App\Model\Setup\PTproductionEvent::where('id', @$item['event_id'])->first();
          @endphp
          <br>
          <table class="tg" width="100%">
            <tbody>
              <tr>
                <td class="tg-0pky width-fixed">Event name</td>
                <td class="tg-0pky width-fixed">{{ @$event_name->name }}</td>
                <td class="tg-0pky width-fixed">No. of Events</td>
                <td class="tg-0pky width-fixed">{{ @$item['no_of_event'] }}</td>
                <td class="tg-0pky width-fixed">Starting Date</td>
                <td class="tg-0pky width-fixed">{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : null }}</td>
                <td class="tg-0pky width-fixed">Ending Date</td>
                <td class="tg-0pky width-fixed">{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : null }}</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2"></td>
                <td class="tg-0pky">Boys</td>
                <td class="tg-0pky">Girls</td>
                <td class="tg-0pky">Male</td>
                <td class="tg-0pky">Female</td>
                <td class="tg-0pky">Transgender</td>
                <td class="tg-0pky">Total</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2">No. of Participants</td>
                <td class="tg-0pky">{{ @$item['participant_boys'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_girls'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_men'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_women'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_other_gender'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_total'] }}</td>
              </tr>

              <tr>
                <td class="tg-0pky" colspan="2">PWD</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_boys'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_girls'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_men'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_women'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_other_gender'] }}</td>
                <td class="tg-0pky">{{ @$item['participant_pwd_total'] }}</td>
              </tr>
            </tbody>
          </table>
        @endforeach
        <br>
      </div>
    </div>
  </div>
</body>
</html>
