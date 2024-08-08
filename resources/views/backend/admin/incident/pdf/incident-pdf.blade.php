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

</style>
<body>
  <div class="container">
    <div class="row">
      <div style="width: 17%; float: left;" class="text-center">
        <img src="{{asset('backend/images/logo.png')}}">
      </div>
      <div class="text-center" style="width: 68%; float: left;">
          <h4><strong>Violence Against Women and Children </strong></h4>
          <h5><strong>75 Mohakhali, Dhaka-1212</strong></h5>
      </div>
    </div>

    <div class="row">
      <div class="col col-sm-12 text-center">
        <h5 style="font-weight: bold">Incident/Violence Information(Violence/Incident ID : {{$incident->survivor_id}})</h5>
      </div>
    </div>
    </div>
    <div class="row">
      <div class="col-sm-12">
        <table border="1" width="100%">
          <tbody>
                <tr>
                  <td width="4%" class="text-center"><p style="font-weight: bold;">1</p></td>
                  <td colspan="3"><p style="font-weight: bold;">Information Sender</p></td>
                </tr>
                {{-- Provider Start --}}
                <tr>
                  <td width="4%" class="text-center" rowspan="3"><p style="font-weight: bold;">2</p></td>
                  <td colspan="3"><p style="font-weight: bold;">Source of Primary Information Provider</p></td>
                </tr>
                @if($incident->provider == "1" || $incident->provider == NULL)
                  <tr>
                    <td width="32%"><p>Name: @if($incident->provider_source_id!='0'){{$incident['information_provider_source']['name']}}@else{{$incident->provider_other_source}}@endif</p></td>
                    <td width="32%"><p>Mobile No: {{$incident->provider_mobile_no}}</p></td>
                    <td width="32%"><p>Platform: {{$incident['organization_name']['name']}}</p></td>
                  </tr>
                  <tr>
                    <td><p>Gender: @if($incident->provider_gender_id!='0'){{$incident['gender']['name']}}@else{{$incident->provider_others_gender}}@endif</p></td>
                    <td><p>Relationship with survivors: @if($incident->provider_relationship_id!='0'){{$incident['provider_reationship']['name']}}@else{{$incident->provider_other_relationship}}@endif</p></td>
                    <td><p>Address: {{$incident['provider_union']['name']}},{{$incident['provider_upazila']['name']}},{{$incident['provider_district']['name']}},{{$incident['provider_division']['name']}}</p></td>
                  </tr>
                @else
                  <tr>
                    <td colspan="3"><p>Source: @if($incident->provider!='0'){{$incident['information_provider_source']['name']}}@else{{$incident->provider_other_source}}@endif</p></td>
                    <!-- <td width="32%"><p>Mobile No: {{$incident->provider_mobile_no}}</p></td>
                    <td width="32%"><p>Platform: {{$incident['organization_name']['name']}}</p></td> -->
                  </tr>
                  <tr>
                    <!-- <td><p>Gender: @if($incident->provider_gender_id!='0'){{$incident['gender']['name']}}@else{{$incident->provider_others_gender}}@endif</p></td>
                    <td><p>Relationship with survivors: @if($incident->provider_relationship_id!='0'){{$incident['provider_reationship']['name']}}@else{{$incident->provider_other_relationship}}@endif</p></td> -->
                    <td colspan="3"><p>Address: {{$incident['provider_union']['name']}},{{$incident['provider_upazila']['name']}},{{$incident['provider_district']['name']}},{{$incident['provider_division']['name']}}</p></td>
                  </tr>
                @endif
                {{-- Provider End --}}
                {{-- Violence-Incident Start --}}
                <tr>
                  <td width="4%" class="text-center" rowspan="3"><p style="font-weight: bold;">3</p></td>
                  <td colspan="3"><p style="font-weight: bold;">Particulars of Violence Incidents</p></td>
                </tr>
                <tr>
                  <td><p>Violence Type: {{$incident['provider_violence_name']['name']}}</p></td>
                  <td><p>Date: {{date('d-m-Y',strtotime($incident->violence_date))}}</p></td>
                  <td><p>Time: {{date('h:i a',strtotime($incident->violence_date))}}</p></td>
                </tr>
                <tr>
                  <td><p>Place: {{$incident['provider_place']['name']}}</p></td>
                  <td colspan="2"><p>Reason of Violence: {{$incident->violence_reason_details}}</p></td>
                </tr>
                {{-- Violence-Incident End --}}
                {{-- Survivor Information Start --}}
                <tr>
                  <td width="4%" class="text-center" rowspan="7"><p style="font-weight: bold;">4</p></td>
                  <td colspan="3"><p style="font-weight: bold;">Survivor Information</p></td>
                </tr>
                <tr>
                  <td><p>Name: {{$incident->survivor_name}}</p></td>
                  <td><p>Mobile No: {{$incident->survivor_mobile_no}}</p></td>
                  <td><p>Religion: @if($incident->survivor_religion_id!='0'){{$incident['survivor_religion']['name']}}@else{{$incident->survivor_others_religion}}@endif</p></td>
                </tr>
                <tr>
                  <td><p>Mother's Name: {{$incident->survivor_mother_name}}</p></td>
                  <td><p>Marital Status: {{$incident['survivor_marital_status']['name']}}</p></td>
                  <td><p>Age: {{$incident->survivor_age}}</p></td>
                </tr>
                <tr>
                  <td><p>Father's Name: {{$incident->survivor_father_name}}</p></td>
                  <td><p>Monthly Income: {{$incident->survivor_monthly_income}}</p></td>
                  <td><p>Occupation: {{$incident['survivor_occupation']['name']}}</p></td>
                </tr>
                <tr>
                  <td><p>Husband Name: {{$incident->survivor_husband_name}}</p></td>
                  <td><p>Gender: @if($incident->survivor_gender_id!='0'){{$incident['survivor_gender']['name']}}@else{{$incident->survivor_others_gender}}@endif</p></td>
                  @php
                    $allOrganization = explode(',', $incident->survivor_organization_type_id);
                  @endphp
                  <td>
                    <p>Organization:
                      {{implode(' , ',App\Model\Admin\Setup\SurvivorSupportOrganization::whereIn('id',$allOrganization)->get()->pluck('name')->toArray())}}
                    </p>
                  </td>
                </tr>
                <tr>
                  <td><p>Place: @if($incident->survivor_incident_place_id!='0'){{$incident['survivor_place']['name']}}@else{{$incident->survivor_others_incident_place}}@endif</p></td>
                  <td><p>Address: {{$incident['survivor_union']['name']}},{{$incident['survivor_upazila']['name']}},{{$incident['survivor_district']['name']}},{{$incident['survivor_division']['name']}}</p></td>
                  <td><p>Disability Status: @if($incident->survivor_autistic_id!='0'){{$incident['survivor_disability']['name']}}@else{{$incident->survivor_others_autistic}}@endif</p></td>
                </tr>
                <tr>
                  <td><p>NID: {{$incident->survivor_nid}}</p></td>
                  <td><p>Birth Registration No: {{$incident->survivor_birth_registration_no}}</p></td>
                  <td></td>
                </tr>
                {{-- Survivor Information End --}}
                {{-- Perpetraton Info Start --}}

                <tr>
                  <!-- <td width="4%" class="text-center" rowspan="{{1+3*count($incident['perpetrator_info'])}}"><p style="font-weight: bold;">5</p></td> -->
                  <td width="4%" class="text-center" rowspan="5"><p style="font-weight: bold;">5</p></td>
                  <td colspan="2"><p style="font-weight: bold;">Perpetrators Information</p></td>
                </tr>
                <tr>
                  <td><p>Name: {{$incident->perpetrator_name}}</p></td>
                  <td><p>Marital Status: {{$incident['perpetrator_marital_status']['name']}}</p></td>
                  <td><p>Address: {{$incident['perpetrator_union']['name']}},{{$incident['perpetrator_upazila']['name']}},{{$incident['perpetrator_district']['name']}},{{$incident['perpetrator_division']['name']}}</p></td>
                </tr>
                <tr>
                  <td><p>Occupation: {{$incident['perpetrator_occupation']['name']}}</p></td>
                  <td><p>Age: {{$incident->perpetrator_age}}</p></td>
                  <td><p>Gender: @if($incident->perpetrator_gender_id!='0'){{$incident['perpetrator_gender']['name']}}@else{{$incident->perpetrator_others_gender}}@endif</p></td>
                </tr>
                <tr>
                  <td><p>Current Place: @if($incident->perpetrator_place_id!='0'){{$incident['perpetrator_place']['name']}}@else{{$incident->perpetrator_others_place}}@endif</p></td>
                  <td><p>Relationship between survivors and perpetrators: @if($incident->perpetrator_relationship_id!='0'){{$incident['perpetrator_relationship']['name']}}@else{{$incident->perpetrator_others_relationship}}@endif</p></td>
                  <td><p>If Perpetrator family member: @if($incident->perpetrator_family_member_id!='0'){{$incident['perpetrator_family_member']['name']}}@else{{$incident->perpetrator_others_family_member}}@endif</p></td>
                </tr>
                <tr>
                  <td><p>No of Perpetrator : {{$incident->no_of_perpetrator}}</p></td>
                </tr>
                <!-- @foreach($incident['perpetrator_info'] as $perpetrator) -->
                <!-- <tr>
                  <td><p>Name: {{$incident->perpetrator_name}}</p></td>
                  <td><p>Marital Status: {{$incident['perpetrator_marital_status']['name']}}</p></td>
                  <td><p>Address: {{$incident['perpetrator_union']['name']}},{{$incident['perpetrator_upazila']['name']}},{{$incident['perpetrator_district']['name']}},{{$incident['perpetrator_division']['name']}}</p></td>
                </tr>
                <tr>
                  <td><p>Occupation: {{$incident['purpetrator_occupation']['name']}}</p></td>
                  <td><p>Age: {{$incident->perpetrator_age}}</p></td>
                  <td><p>Gender: @if($incident->perpetrator_gender_id!='0'){{$incident['purpetrator_gender']['name']}}@else{{$incident->perpetrator_others_gender}}@endif</p></td>
                </tr>
                <tr>
                  <td><p>Current Place: @if($incident->perpetrator_place_id!='0'){{$incident['purpetrator_place']['name']}}@else{{$incident->perpetrator_others_place}}@endif</p></td>
                  <td><p>Relationship between survivors and perpetrators: @if($incident->perpetrator_relationship_id!='0'){{$incident['purpetrator_relationship']['name']}}@else{{$incident->perpetrator_others_relationship}}@endif</p></td>
                  <td><p>If Perpetrator family member: @if($incident->perpetrator_family_member_id!='0'){{$incident['purpetrator_family_member']['name']}}@else{{$incident->perpetrator_others_family_member}}@endif</p></td>
                </tr> -->
                <!-- @endforeach -->
                {{-- Perpetraton Info End --}}
                {{-- Legal Initiaves Start --}}
                <tr>
                  <td width="4%" class="text-center" rowspan="3"><p style="font-weight: bold;">6</p></td>
                  <td colspan="3"><p style="font-weight: bold;">Legal Initiaves</p></td>
                </tr>
                <tr>
                  <td><p>Status of case filing: {{$incident->case_status}}</p></td>
                  <td><p>Name of Thana: {{$incident->thana_name}}</p></td>
                  <td><p>Name of the court: {{$incident->court_name}}</p></td>
                </tr>
                <tr>
                  <td colspan="3"><p>Reason of not filing a case against perpetrator: {{$incident->not_filing_reason}}</p></td>
                </tr>
                {{-- Legal Initiaves End --}}
                {{-- Survivor Current Situation Start --}}
                <tr>
                  <td width="4%" class="text-center" rowspan="2"><p style="font-weight: bold;">7</p></td>
                  <td colspan="3"><p style="font-weight: bold;">Information on survivors current situation</p></td>
                </tr>
                <tr>
                  <td><p>Survivor's situation during data collection: @if($incident->survivor_situation_id!='0'){{$incident['survivor_situation']['name']}}@else{{$incident->survivor_other_situation}}@endif</p></td>
                  <td><p>Survivors place during data collection: @if($incident->survivor_place_id!='0'){{$incident['survivor_during_place']['name']}}@else{{$incident->survivor_other_place}}@endif</p></td>
                  <td><p>Survivor received any support: @if($incident->survivor_initial_support_id!='0'){{$incident['survivor_initial_support']['name']}}@else{{$incident->survivor_initial_other_support}}@endif</p></td>
                </tr>
                {{-- Survivor Current Situation End --}}
                {{-- Survivor Supports Start --}}
                <tr>
                  <td width="4%" class="text-center" rowspan="{{2+2*count($incident['survivor_brac_support'])+2*count($incident['survivor_other_organization_support'])}}"><p style="font-weight: bold;">8</p></td>
                  <td colspan="3"><p style="font-weight: bold;">Support for survivors</p></td>
                </tr>
                {{-- Brac Support --}}
                <tr>
                  <td colspan="3"><p>Date: {{date('d-m-Y',strtotime($incident['survivor_brac_support']['0']['survivor_support_date']))}}</p></td>
                </tr>
                @foreach($incident['survivor_brac_support'] as $brac_support)
                <tr>
                  <td><p>Brac Support Name: {{$brac_support['brac_final_support']['name']}}</p></td>
                  <td colspan="2"><p>Brac Program Name: {{$brac_support['brac_program']['name']}}</p></td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="3"><p>Brac Support Description: {{$incident['survivor_brac_support']['0']['brac_support_description']}}</p></td>
                </tr>
                {{-- Orther Organization Support --}}
                @foreach($incident['survivor_other_organization_support'] as $other_support)
                <tr>
                  <td><p>Other Organization Support Name: {{$other_support['other_organization_final_support']['name']}}</p></td>
                  <td colspan="2"><p>Other Program Name: {{$other_support->other_program}}</p></td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="3"><p>Other Support Description: {{$incident['survivor_other_organization_support']['0']['other_organization_support_description']}}</p></td>
                </tr>
                {{-- Survivor Supports End --}}
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>
