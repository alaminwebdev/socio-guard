<!DOCTYPE html>
<html lang="en">
<title>Complaint ID - {{ formatIncidentId(@$incident->id) }}</title>
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
  @php
      $followupnumber=array('1'=>"First Followup",'2'=>"Second Followup",'3'=>"Third Followup");
      // $referralsTitle=array('1'=>"NGO shelter home",'2'=>"Govt.shelter home",'3'=>"Skill/IGA for Govt. department",'4'=>'BRAC programme');
      $referralsTitle= \App\Model\Setup\Refferal::where('status', 1)->get();
      // dd($referralsTitle);
      $directServicearr=array('1'=>"Assistance to treatment /medical support ",'2'=>"Assistance to OCC",'3'=>"Alternative Dispute Resolution (ADR)",'4'=>'Assistance with court case');
      $casetype=array('1'=>"Civil cases",'2'=>"GR/Police Case",'3'=>"CR/Petition Case");
      $casestatus=array(
                        '16'=>"Case filed",
                        '17'=>"Summon Issued to defendant",
                        '18'=>"Written response from defendant",
                        '19'=>"Primary hearing",
                        '20'=>"Formation of the subject matter of judgment",
                        '21'=>"Witness and interrogation",
                        '22'=>"Final hearing",
                        '23'=>"Judgment",
                        '24'=>"Decree",
                      );

            $courtcasemoneyrecover=array('11'=>"Not applicable",'12'=>"Dower",'13'=>"Maintenance",'14'=>'Inheritance rights');
            $judjementStatus=array('1'=>"In-favour",'2'=>"Disfavour",'3'=>"Ad-interim disposal",'4'=>'Disposal in investigation stage','5'=>'Void complaints');                
  @endphp
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
          <h5><strong>75 Mohakhali, Dhaka-1212</strong></h5>
          <h5 style="font-weight: bold">Violence Incident Information(Complaint ID : {{ formatIncidentId($incident->id) }} | Creation Date : {{ $incident->created_at != null ? date("d-m-Y", strtotime($incident->created_at)) : ''}}</h5>
      </div>
    </div>

    <div class="row">
    </div>
    </div>
    <div class="row"> 
      <div class="col-sm-12">
        <table border="1" width="100%">
          <tbody>
            {{-- Data Insert By --}}
            <tr>
              <td width="4%" class="text-center" rowspan="4"><p style="font-weight: bold;">1</p></td>
              <td colspan="2"><p style="font-weight: bold;">Data Insert By</p></td>
              <td><p>Reporting Date : {{ $incident->posting_date != null ? date("d-m-Y", strtotime($incident->posting_date)) : ''}}</p></td>
            </tr>
            <tr>
              <td><p>Name: {{@$incident->employee_name}}</p></td>
              <td><p>Mobile No: {{@$incident->employee_mobile_number}}</p></td>
              <td><p>Designation: {{@$incident->employee_designation}}</p></td>
            </tr>
            <tr>
              <td><p>PIN : {{@$incident->employee_pin}}</p></td>
              <td><p>Zone : {{@$incident['employee_zone']['region_name']}}</p></td>
              <td><p>Division : {{@$incident['employee_division']['name']}}</p></td>
              {{-- <td colspan="2"><p>Address: {{@$incident['employee_upazila']['name']}},{{@$incident['employee_district']['name']}},{{@$incident['employee_division']['name']}}</p></td> --}}
            </tr>
            <tr>
              <td><p>District : {{@$incident['employee_district']['name']}}</p></td>
              <td colspan="2"><p>Upazila : {{@$incident['employee_upazila']['name']}}</p></td>
            </tr>
            {{-- <tr>
              <td colspan="3"><p style="font-weight: bold;">Address</p></td>
            </tr> --}}
            {{-- <tr>
              <td><p>Zone : </p></td>
              <td><p>Division : </p></td>
              <td><p>District : </p></td>
            </tr> --}}

            {{-- Referred By --}}
            <tr>
              <td width="4%" class="text-center" rowspan="4"><p style="font-weight: bold;">2</p></td>
              <td colspan="3"><p style="font-weight: bold;">Referred by</p></td>
            </tr>
            <tr>
              <td><p>Information Provider: {{@$incident['information_provider']['name']}}</p></td>
              <td><p>BRAC Programme:{{ @$incident['brac_program_name']['title'] }} </p></td>
              <td><p>Informer Name: {{@$incident->referral_name}}</p></td>
            </tr>
            <tr>
              <td><p>Informer Contact Number : {{ @$incident->informer_mobile_number }}</p></td>
              <td><p>Gender : {{@$incident['referral_gender']['name']}}</p></td>
              <td><p>Occupation : {{@$incident['referral_occupation']['name']}}</p></td>
            </tr>

            <tr>
              <td colspan="2"><p>Reported Incident Type : {{@$incident['types_of_disputes']['name']}}</p></td>
              <td><p>Date of disputes : {{ $incident->date_of_dispute != null ? date("d-m-Y", strtotime($incident->date_of_dispute)) : ''}}</p></td>
            </tr>
            {{-- <tr>
              <td><p>Relation between Survivor’s : {{ @$incident['referral_reletionship']['name'] }}</p></td>
              <td><p>Occupation : {{@$incident['referral_occupation']['name']}}</p></td>
              <td><p>Gender : {{@$incident['referral_gender']['name']}}</p></td>
            </tr> --}}

            {{-- Types of reported disputes/problems --}}
            {{-- <tr>
              <td width="4%" class="text-center"><p style="font-weight: bold;">3</p></td>
              <td colspan="3"><p style="font-weight: bold;">Types of reported disputes/problems : {{@$incident['types_of_disputes']['name']}}</p></td>
            </tr> --}}

            {{-- Date of disputes --}}
            {{-- <tr>
              <td width="4%" class="text-center"><p style="font-weight: bold;">4</p></td>
              <td colspan="3"><p style="font-weight: bold;">Date of disputes : {{ $incident->date_of_dispute != null ? date("d-m-Y", strtotime($incident->date_of_dispute)) : ''}}</p></td>
            </tr> --}}

            {{-- Is the applicant / survivor the same person? --}}
            <tr>
              <td width="4%" class="text-center"><p style="font-weight: bold;">3</p></td>
              <td colspan="3"><p style="font-weight: bold;">Is the applicant / survivor the same person? : {{@$incident->applicant_survivor_same == 1 ? " Yes ": (@$incident->applicant_survivor_same == null ? " ": "No") }} </p></td>
            </tr>

            {{-- Applicant Information --}}
            <tr>
              <td width="4%" class="text-center" rowspan="7"><p style="font-weight: bold;">4</p></td>
              <td colspan="3"><p style="font-weight: bold;">Applicant Information</p></td>
            </tr>
            <tr>
              <td><p>Applicant's Name: {{@$incident->applicant_name}}</p></td>
              <td><p>Father's Name: {{@$incident->applicant_father_name}}</p></td>
              <td><p>Mother's Name: {{@$incident->applicant_mother_name}}</p></td>
            </tr>
            <tr>
              <td><p>Husband's Name: {{@$incident->applicant_husband_name}}</p></td>
              <td><p>Age: {{@$incident->applicant_age}}</p></td>
              <td><p>Cell number self: {{@$incident->applicant_mobile_number}}</p></td>
            </tr>
            <tr>
              <td><p>Cell number on request: {{@$incident->applicant_mobile_number_on_request}}</p></td>
              <td><p>Gender: {{@$incident['applicant_gender']['name']}}</p></td>  
              <td><p>Education: {{@$incident['applicant_education']['title']}}</p></td>
            </tr>
            <tr>
              <td><p>Occupation:{{@$incident['applicant_occupation']['name']}} </p></td>
              <td colspan="2"><p>Religion: {{@$incident['applicant_religion']['name']}}</p></td>
            </tr>
            <tr>
              <td><p>Division: {{@$incident['applicant_division']['name']}}</p></td>
              <td><p>District: {{@$incident['applicant_district']['name']}}</p></td>
              <td><p>Upazila: {{@$incident['applicant_upazila']['name']}}</p></td>
            </tr>
            <tr>
              <td><p>Union: {{@$incident['applicant_union']['name']}}</p></td>
              <td><p>Village: {{@$incident->applicant_village_name}}</p></td>
              <td><p>Ward/Para: {{@$incident->applicant_ward}}</p></td>
            </tr>
            {{-- <tr>
              <td colspan="3"><p>Address: {{@$incident['applicant_upazila']['name']}},{{@$incident['applicant_district']['name']}},{{@$incident['applicant_division']['name']}}</p></td>
            </tr> --}}

            {{-- Survivor Information --}}
            <tr>
              <td width="4%" class="text-center" rowspan="7"><p style="font-weight: bold;">5</p></td>
              <td colspan="3"><p style="font-weight: bold;">Survivor Information</p></td>
            </tr>
            <tr>
              <td><p>Survivor's Name: {{@$incident->survivor_name}}</p></td>
              <td><p>Father's Name: {{@$incident->survivor_father_name}}</p></td>
              <td><p>Mother's Name: {{@$incident->survivor_mother_name}}</p></td>
            </tr>
            <tr>
              <td><p>Husband's Name: {{@$incident->survivor_husband_name}}</p></td>
              <td><p>Cell number self: {{@$incident->survivor_mobile_number}}</p></td>
              <td><p>Cell number on request: {{@$incident->survivor_mobile_number_on_request}}</p></td>
            </tr>
            <tr>
              <td><p>Age: {{@$incident->survivor_age}}</p></td>
              <td><p>Gender: {{@$incident['survivor_gender']['name']}}</p></td>  
              <td><p>Education: {{@$incident['survivor_education']['title']}}</p></td>
            </tr>
            <tr>
              <td><p>Occupation: {{@$incident['survivor_occupation']['name']}}</p></td>
              <td><p>Religion: {{@$incident['survivor_religion']['name']}}</p></td>
              <td><p>Disability status: {{@$incident['survivor_disability']['name']}}</p></td>
            </tr>
            <tr>
              <td><p>Division: {{@$incident['survivor_division']['name']}}</p></td>
              <td><p>District: {{@$incident['survivor_district']['name']}}</p></td>
              <td><p>Upazila: {{@$incident['survivor_upazila']['name']}}</p></td>
            </tr>
            <tr>
              <td><p>Union: {{@$incident['survivor_union']['name']}}</p></td>
              <td><p>Village: {{@$incident->survivor_village_name}}</p></td>
              <td><p>Ward/Para: {{@$incident->survivor_ward}}</p></td>
            </tr>
            {{-- <tr>
              <td><p>Household Type: {{@$incident['house_hold_type']['title']}}</p></td>
              <td><p>Total Household Income/Month: {{@$incident->household_total_income}}</p></td>
              <td><p>Violence Location: {{@$incident['violence_location']['title']}}</p></td>
              <td><p>Marital Status: {{@$incident['marital_status']['name']}}</p></td>
            </tr> --}}
            {{-- <tr>
              <td><p>Age of marriage: {{@$incident->survivor_age_of_marriage}}</p></td>
              <td>Organizational affiliation : 
                @if(@$incident->survivor_organization_affiliation_id == 1)
                BRAC participants
                @endif
                @if(@$incident->survivor_organization_affiliation_id == 2)
                Other organization 
                @endif
                @if(@$incident->survivor_organization_affiliation_id == 3)
                Not applicable
                @endif
              </td>
              <td><p>Organizational affiliation: {{ (@$incident->survivor_organization_affiliation_id == 1) ? "BRAC participants": ((@$incident->survivor_organization_affiliation_id == 2) ? "Other organization":"Not applicable")}}</p></td>
              <td><p>NID number: {{@$incident->survivor_nid}}</p></td>
            </tr>
            <tr>
              <td><p>Reason of violence: {{@$incident['survivor_violence_reason']['name']}}</p></td>
              <td><p>Place of violence: {{@$incident['violence_place']['name']}}</p></td>
              <td><p>Disability status: {{@$incident['survivor_disability']['name']}}</p></td>
            </tr>
            <tr>
              <td colspan="3"><p>Address: {{@$incident['survivor_upazila']['name']}},{{@$incident['survivor_district']['name']}},{{@$incident['survivor_division']['name']}}</p></td>
            </tr> --}}
            

            {{-- Defendant Information --}}
            <tr>
              <td width="4%" class="text-center" rowspan="5"><p style="font-weight: bold;">6</p></td>
              <td colspan="3"><p style="font-weight: bold;">Defendant Information</p></td>
            </tr>
            <tr>
              <td><p>Number of the Accused(s) : {{@$incident->number_of_defendants}}</p></td>
              <td><p>Name of Main Accused : {{@$incident->main_defendants_name}}</p></td>
              <td><p>Survivors' Relationship with Accused : {{@$incident['relation_main_accused']['name']}}</p></td>
            </tr>
            <tr>
              <td><p>Gender: {{@$incident['defendant_gender']['name']}}</p></td>
              <td colspan="2"><p>Age: {{@$incident->main_defendant_age}}</p></td>
            </tr>
            <tr>
              <td><p>Division: {{@$incident['defendant_division']['name']}}</p></td>
              <td><p>District: {{@$incident['defendant_district']['name']}}</p></td>
              <td><p>Upazila: {{@$incident['defendant_upazila']['name']}}</p></td>
            </tr>
            <tr>
              <td><p>Union: {{@$incident['defendant_union']['name']}}</p></td>
              <td><p>Village: {{@$incident->defendant_village_name}}</p></td>
              <td><p>Ward/Para: {{@$incident->defendant_ward}}</p></td>
            </tr>

            {{-- <tr>
              <td><p>Education: {{@$incident['defendant_education']['title']}}</p></td>
            </tr>
            <tr>
              <td><p>Occupation: {{@$incident['defendant_occupation']['name']}}</p></td>
              <td colspan="2"><p>Address: {{@$incident['defendant_upazila']['name']}},{{@$incident['defendant_district']['name']}},{{@$incident['defendant_division']['name']}}</p></td>
            </tr> --}}
            
            {{-- First initiative taken from SELP --}}
            <tr>
              <td width="4%" class="text-center" rowspan="{{ @$incident->selp_initiative == 1 ? 2 : '' }}"><p style="font-weight: bold;">7</p></td>
              <td colspan="3"><p style="font-weight: bold;">First initiative taken from SELP : 
                @if(@$incident->selp_initiative == 1)
                  Advice and referrel
                @endif
                @if(@$incident->selp_initiative == 2)
                  Complain Received 
                  @endif
                  @if(@$incident->selp_initiative == 3)
                  Violence Incident Documented 
                  @endif
                  @if(@$incident->selp_initiative == 4)
                  Advice
                  @endif
                </tr>
                
                @if(@$incident->selp_initiative == 1)
                <tr>
                  <td><p>Refferal No: {{@$incident->referral_no}}</p></td>
                  <td><p>Primary Refferal: {{@$incident['refferal']['name']}}</p></td>
                  <td><p>Date: {{ $incident->referral_date != null ? date("d-m-Y", strtotime($incident->referral_date)) : ''}}</p></td>
                </tr>
                @endif
            
              </td>
            </tr>

            @if(@$incident->selp_initiative == 2)
            {{-- Survivor's Other Information  --}}
            <tr>
              <td width="4%" class="text-center" rowspan="4"><p style="font-weight: bold;">8</p></td>
              <td colspan="3"><p style="font-weight: bold;">Survivor's Other Information :</p></td>
            </tr>
            <tr>
              <td><p>Household Type: {{@$incident['house_hold_type']['title']}}</p></td>
              <td><p>Total Household Income/Month: {{@$incident->household_total_income}}</p></td>
              <td><p>Violence Location: {{@$incident['violence_location']['title']}}</p></td>
            </tr>
            <tr>
              <td><p>Marital Status: {{@$incident['marital_status']['name']}}</p></td>
              <td><p>Your Age during marriage(If Applicable) : {{@$incident->survivor_age_of_marriage}}</p></td>
              <td>Organizational affiliation (if any) : 
                @if(@$incident->survivor_organization_affiliation_id == 1)
                BRAC participants
                @endif
                @if(@$incident->survivor_organization_affiliation_id == 2)
                Other organization 
                @endif
                @if(@$incident->survivor_organization_affiliation_id == 3)
                Not applicable
                @endif
              </td>
            </tr>
            <tr>
              <td><p>NID/Birth Reg. Number(If available): {{@$incident->survivor_nid}}</p></td>
              <td><p>Reason of violence: {{@$incident['survivor_violence_reason']['name']}}</p></td>
              <td><p>Place of violence: {{@$incident['violence_place']['name']}}</p></td>
            </tr>

            
            {{-- Defendant/Accused Other information  --}}
            <tr>
              <td width="4%" class="text-center" rowspan="3"><p style="font-weight: bold;">9</p></td>
              <td colspan="3"><p style="font-weight: bold;">Defendant/Accused Other information :</p></td>
            </tr>
            <tr>
              <td colspan="3">If perpetrator family member(s): {{@$incident->if_perpetrator_family_member_yes_or_no == 1 ? " Yes ": (@$incident->if_perpetrator_family_member_yes_or_no == null ? " ": "No") }} </td>
            </tr>
            <tr>
              <td><p>Family member(s): {{@$incident['accuse_family_member']['name']}}</p></td>
              <td><p>Education: {{@$incident['defendant_education']['title']}}</p></td>
              <td><p>Occupation: {{@$incident['defendant_occupation']['name']}}</p></td>
            </tr>

            

            {{-- Status of initiative taken for this complaint --}}
            <tr>
              <td width="4%" class="text-center" rowspan="{{ @$incident->earlier_survivor_initiative == 1 ? 4 : 2 }}"><p style="font-weight: bold;">10</p></td>
              <td colspan="3"><p style="font-weight: bold;">Status of initiative taken for this complaint</p></td>
            </tr>
            <tr>
              <td colspan="3"><p>Any initiatives taken by survivors earlier for this dispute: {{@$incident->earlier_survivor_initiative == 1 ? " Yes ": (@$incident->earlier_survivor_initiative == null ? " ": "No") }} </p></td>
            </tr>
            @if (@$incident->earlier_survivor_initiative == 1)
            <tr>
              <td colspan="3"><p>If Yes where??: {{@$incident->selp_initiative_place->title}}</p></td>
            </tr>
            <tr>
              <td colspan="3"><p>Causes of failure/coming to SELP: {{@$incident['selp_coming_failour']['title']}}</p></td>
            </tr>
            @endif

            

            {{-- Detail of direct services --}}
            {{-- <tr>
              <td width="4%" class="text-center" rowspan="3"><p style="font-weight: bold;">10</p></td>
              <td colspan="3"><p style="font-weight: bold;">Detail of direct services </p></td>
            </tr>
            <tr>
              <td colspan="2"><p>Direct Service: {{ (@$incident->survivor_organization_affiliation_id == 1) ? " Assistance to treatment /medical support ": ((@$incident->survivor_organization_affiliation_id == 2) ? " Assistance to OCC ": ((@$incident->survivor_organization_affiliation_id == 3)? " Alternative Dispute Resolution (ADR) ": " Assistance with court case "))}}</p></td>
              <td><p>Date: {{@$incident->direct_service_date}}</p></td>
            </tr>
            <tr>
              <td><p>Alternative Dispute Resolution (ADR): </p></td>
              <td><p>Starting Date: </p></td>
              <td><p>Closing Date: </p></td>
            </tr> --}}

            {{-- Court case status --}}
            {{-- <tr>
              <td width="4%" class="text-center" rowspan="4"><p style="font-weight: bold;">11</p></td>
              <td colspan="3"><p style="font-weight: bold;">Court case status</p></td>
            </tr>
            <tr>
              <td><p>Case Type: </p></td>
              <td colspan="2"><p>Case list: </p></td>
            </tr>
            <tr>
              <td colspan="3"><p>Money recovered through court case: </p></td>
            </tr>
            <tr>
              <td><p>Judgement status: </p></td>
              <td><p>Starting Date: </p></td>
              <td><p>Judgement Date: </p></td>
            </tr> --}}

            {{-- Followup --}}
            {{-- <tr>
              <td width="4%" class="text-center" rowspan="{{(count($followups)*3)+1}}"><p style="font-weight: bold;">12</p></td>
              <td colspan="3"><p style="font-weight: bold;">Followup</p></td>
            </tr>
            @for ($i = 0; $i < count($followups); $i++)
              <tr>
                <td colspan="3"><p>Programme participants followed up: {{@$followups[$i]->program_participant_followup == 1 ? " Physically/ In-person ":" Online "}}</p></td>
              </tr>
              <tr>
                <td colspan="3"><p>No.of follow up made by SELP staff: {{@$followupnumber[@$followups[$i]->followup_number]}}</p></td>
              </tr>
              <tr>
                <td colspan="3"><p>Findings from follow up: {{@$followups[$i]->followup_findings}}</p></td>
              </tr>
              <tr colspan="3">
                
              </tr>
            @endfor --}}
            
            
            
            

            {{-- Referral --}}
            {{-- <tr>
              <td width="4%" class="text-center" rowspan="2"><p style="font-weight: bold;">13</p></td>
              <td colspan="3"><p style="font-weight: bold;">Referral</p></td>
            </tr>
            <tr>
              <td colspan="2"><p>Referral and rehabilitation: {{ (@$incident->referral_service_id == 1) ? " NGO shelter home ": ((@$incident->survivor_organization_affiliation_id == 2) ? " Govt.shelter home ": ((@$incident->survivor_organization_affiliation_id == 3)? " Skill/IGA for Govt. department ": " BRAC programme "))}}</p></td>
              <td><p>Date: </p></td>
            </tr> --}}

            {{-- Survivor's previous violence history --}}
            {{-- <tr>
              <td width="4%" class="text-center" rowspan="4"><p style="font-weight: bold;">14</p></td>
              <td colspan="3"><p style="font-weight: bold;">Survivor's previous violence history</p></td>
            </tr>
            <tr>
              <td colspan="3"><p>Have you ever face any violence ?: {{@$incident->have_survivor_face_violence_before == 1 ? " Yes ":" No "}}</p></td>
            </tr>
            <tr>
              <td><p>At what age: {{@$incident->survivor_first_face_violence_age}}</p></td>
              <td><p>what type of violence was that: </p></td>
              <td><p>Did you seek support from BRAC for that?: {{@$incident->survivor_seek_support_from_brac == 1 ? " Yes ":" No "}} </p></td>
            </tr>
            <tr>
              <td><p>Type of violence: </p></td>
              <td colspan="2"><p>What support did you receive from BRAC?: {{@$incident['brac_support_type']['title']}}</p></td>
            </tr>   --}}
          </tbody>
        </table>
        <h4 style="font-weight:bold">11. Detail of direct services</h4>
          @for ($i = 0; $i < count($direct_service_type); $i++)
            <table border="1" style="margin-top:5px;width:100%" class="tg">
              <thead>
                <tr>
                  <td class="tg-0pky">Direct service</td>
                  <td class="tg-0pky" style="width: 300px;"><b>{{@$directServicearr[@$direct_service_type[$i]->service_type_id]}}</b></td>
                </tr>
              </thead>
              @if (@$direct_service_type[$i]->service_type_id == 1 || @$direct_service_type[$i]->service_type_id == 2)
              <tbody>
                  <tr>
                    <td class="tg-0pky">Direct Service Date</td>
                    <td style="width:300px" class="tg-0pky">{{@$direct_service_type[$i]->service_date==null ? '--' : date_format(date_create($direct_service_type[$i]->service_date),'d-M-Y')}}</td>
                  </tr>
                  
                </tbody>   
                @endif
              </table>
              @if (@$direct_service_type[$i]->service_type_id==3 && count($adrSupport)>0)
                  @for ($j = 0; $j < count($adrSupport); $j++)
                    <table border="0" style="margin-top:7px;background:ghostwhite;width:100%" class="tg">
                      <thead>
                        <tr>
                          <td class="tg-0pky">Alternative Dispute Resolution (ADR)</td>
                          <td class="tg-0pky"><b>{{@$adrSupport[$j]->title}}</b></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="tg-0pky">Money recovered through ADR</td>
                          {{-- <td style="width:300px" class="tg-0pky">{{@$adrSupport[$j]->money_recovered_through_adr}}</td> --}}
                          <td style="width:300px" class="tg-0pky">{{@$adrSupport[$j]['adr_money_recovered']['title']}}</td>
                        </tr>
                        <tr>
                          <td class="tg-0pky">Amount of Money Received</td>
                          <td style="width:300px" class="tg-0pky">{{@$adrSupport[$j]->amount_of_money_received}}</td>
                        </tr>
                        <tr>
                          <td class="tg-0pky">No. of participants benefited</td>
                          <td style="width:300px" class="tg-0pky">{{@$adrSupport[$j]->no_of_adr_participants_benefited}}</td>
                        </tr>
                        <tr>
                          <td class="tg-0pky">Starting Date</td>
                          <td style="width:300px" class="tg-0pky">{{@$adrSupport[$j]->starting_date==null ? '--' : date_format(date_create($adrSupport[$j]->starting_date),'d-M-Y')}}</td>
                        </tr>
                        <tr>
                          <td class="tg-0pky">Ending Date</td>
                          <td style="width:300px" class="tg-0pky">{{@$adrSupport[$j]->closing_date==null ? '--' : date_format(date_create($adrSupport[$j]->closing_date),'d-M-Y')}}</td>
                        </tr>
                        
                      </tbody>
                    </table>
                  @endfor
              @endif


              @if (@$direct_service_type[$i]->service_type_id==4 && count($caseSupport)>0)
                  @for ($j = 0; $j < count($caseSupport); $j++)
                    <table border="0" style="margin-top:7px;background:ghostwhite;width:100%" class="tg">
                      <thead>
                        <tr>
                          <td class="tg-0pky"><b>Case Type</b></td>
                          <td class="tg-0pky"><b>{{@$casetype[@$caseSupport[$j]->case_type]}}</b></td>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="tg-0pky">Case Status</td>
                          <td style="width:300px" class="tg-0pky">{{@getCaseStatusForIncidentSingleView(@$caseSupport[$j]->case_type,@$caseSupport[$j]->court_case_id)->title}}</td>
                        </tr>
                        <tr>
                          <td class="tg-0pky">Money recovered through court case</td>
                          <td style="width:300px" class="tg-0pky">{{@$caseSupport[$j]['moneyrecover_case']['title']}}</td>
                        </tr>
                        <tr>
                          <td class="tg-0pky">Amount of Money Received</td>
                          <td style="width:300px" class="tg-0pky">{{@$caseSupport[$j]->amount_of_money_received}}</td>
                        </tr>
                        <tr>
                          <td class="tg-0pky">No. of participants benefited</td>
                          <td style="width:300px" class="tg-0pky">{{@$caseSupport[$j]->no_of_case_participants_benefited}}</td>
                        </tr>
                        <tr>
                          <td class="tg-0pky">Judgement status</td>
                          <td style="width:300px" class="tg-0pky">{{@$caseSupport[$j]['judgement_status']['title']}}</td>
                        </tr>
                        <tr>
                          <td class="tg-0pky">Starting Date</td>
                          <td style="width:300px" class="tg-0pky">{{@$caseSupport[$j]->case_start_date==null ? '--' : date_format(date_create($caseSupport[$j]->case_start_date),'d-M-Y')}}</td>
                        </tr>
                        <tr>
                          <td class="tg-0pky">Ending Date</td>
                          <td style="width:300px" class="tg-0pky">{{@$caseSupport[$j]->case_judjement_date==null ? '--' : date_format(date_create($caseSupport[$j]->case_judjement_date),'d-M-Y')}}</td>
                        </tr>
                        
                      </tbody>
                    </table>
                  @endfor
              @endif
          @endfor
        <h4 style="font-weight:bold">12. Followup</h4>
          @for ($i = 0; $i < count($followups); $i++)
            <table border="1" style="margin-top:5px;width:100%" class="tg">
              <thead>
                <tr>
                  <td class="tg-0pky">No.of follow up made by SELP staff</td>
                  <td class="tg-0pky"><b>{{@$followupnumber[@$followups[$i]->followup_number]}}</b></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="tg-0pky">Programme participants followed up</td>
                  <td style="width:300px" class="tg-0pky">{{@$followups[$i]->followup_type == 1 ? " Physically/ In-person ":" Online "}}</td>
                </tr>
                <tr>
                  <td class="tg-0pky">Findings from follow up</td>
                  {{-- <td style="width:300px" class="tg-0pky">{{@$followups[$i]->followup_findings==null ? '--' : \App\Model\Followup::find($followups[$i]->followup_findings)->title}}</td> --}}
                  <td style="width:300px" class="tg-0pky">{{@$followups[$i]->followup_findings==null ? '--' : @$followups[$i]['findings_followup']['title']}}</td>
                </tr>

                <tr>
                  <td class="tg-0pky">Followup Date</td>
                  <td style="width:300px" class="tg-0pky">{{@$followups[$i]->followup_date==null ? '--' : date_format(date_create($followups[$i]->followup_date),'d-M-Y')}}</td>
                </tr>
                
              </tbody>
              </table>
          @endfor


          <h4 style="font-weight:bold">13. Secondary Referral</h4>
          @for ($i = 0; $i < count($referrals); $i++)
            <table border="1" style="margin-top:5px;width:100%" class="tg">
              <thead>
                <tr>
                  <td class="tg-0pky">Secondary Referral</td>
                  {{-- <td class="tg-0pky"><b>{{@$referralsTitle[@$referrals[$i]->referral_id]}}</b></td> --}}
                  <td class="tg-0pky"><b>{{@$referrals[$i]['complain_received_refferal']['name']}}</b></td>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="tg-0pky">Referral Date</td>
                  <td style="width:300px" class="tg-0pky">{{@$referrals[$i]->referral_date==null ? '--' : date_format(date_create($referrals[$i]->referral_date),'d-M-Y')}}</td>
                </tr>
                
              </tbody>
              </table>
          @endfor  
          
          <h4 style="font-weight:bold">14. Survivor's previous violence history</h4>
          <table border="1" style="margin-top:5px;width:100%" class="tg">
            <thead>
              <tr>
                <td class="tg-0pky">Have you ever face any violence ?: </td>
                <td class="tg-0pky"><b> {{@$incident->have_survivor_face_violence_before == 1 ? " Yes ": (@$incident->have_survivor_face_violence_before == null ? " ": "No") }}</b></td>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="tg-0pky">At what age:</td>
                <td style="width:300px" class="tg-0pky">{{@$incident->survivor_first_face_violence_age}}</td>
              </tr>
              <tr>
                <td class="tg-0pky">Type of violence: </td>
                @php
                  $data = App\Model\Admin\Setup\PreviousViolenceCategory::whereIn('id', explode(",",@$incident->survivor_first_face_violence_type))->get()->pluck('name');
                @endphp
                
                <td style="width:300px" class="tg-0pky">{{ implode(',',@$data->toArray())}}</td>
              </tr>
              <tr>
                <td class="tg-0pky">Did you seek support from BRAC for that?:</td>
                <td style="width:300px" class="tg-0pky">{{@$incident->survivor_seek_support_from_brac == 1 ? " Yes ": (@$incident->survivor_seek_support_from_brac == null ? " ": "No") }}</td>
              </tr>
              <tr>
                <td class="tg-0pky">What support did you receive from BRAC?:</td>
                <td style="width:300px" class="tg-0pky">{{@$incident['brac_support_type']['title']}}</td>
              </tr>
            @endif
              
            </tbody>
            </table>
      </div>
    </div>
  </div>
</body>
</html>
