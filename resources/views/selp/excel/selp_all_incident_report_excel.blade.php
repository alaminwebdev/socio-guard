
{{-- @php
    echo("<pre>");
    print_r($indicent_data[0]->direct_services);
    die(); 
@endphp --}}
<style>
    table tr {
        border: 1px solid !important;
    }
</style>

<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
<table>
    <thead>
        <tr style="border:1px solid !important;">
            <th>id</th>
            <th>Reporting Date</th>
            <th>Employee Name</th>
            <th>Employee Mobile Number</th>
            <th>Employee Designation</th>
            <th>Employee Pin</th>
            <th>Employee Zone</th>   
            <th>Employee Division</th>   
            <th>Employee District</th>   
            <th>Employee Upazila</th>   
            <th>Information Provider Source</th>   
            <th>BRAC Programe Name</th>   
            <th>Informer name</th>   
            <th>Informer Contact Number</th>   
            <th>Informer Gender</th>   
            <th>Informer Occupation</th> 
            <th>Reported Incident Type</th>   
            <th>Date of disputes</th>
            <th>Is the applicant and survivor the same person?</th>   
            <th>Applicant's Name</th>   
            <th>Applicant's Father's Name</th>   
            <th>Applicant's Mother's Name</th>   
            <th>Applicant's Husband's Name</th>   
            <th>Applicant's Age</th>   
            <th>Applicant's Cell number(self)</th>   
            <th>Applicant's Cell number(on request)</th>   
            <th>Applicant's Gender</th>   
            <th>Applicant's Education</th>   
            <th>Applicant's Occupation</th>   
            <th>Applicant's Religion</th>   
            <th>Applicant's Division</th>   
            <th>Applicant's District</th>   
            <th>Applicant's Upazila</th>   
            <th>Applicant's Union</th>   
            <th>Applicant's Village Name</th>   
            <th>Applicant's Ward</th>
            <th>Survivor's Name</th>   
            <th>Survivor's Father's Name</th>   
            <th>Survivor's Mother's Name</th>   
            <th>Survivor's Husband's Name</th>   
            <th>Survivor's Age</th>   
            <th>Survivor's Cell number self</th>   
            <th>Survivor's Cell number on request</th>   
            <th>Survivor's Gender</th>   
            <th>Survivor's Education</th>   
            <th>Survivor's Occupation</th>   
            <th>Survivor's Religion</th>   
            <th>Survivor's Disability status</th>   
            <th>Survivor's Division</th>   
            <th>Survivor's District</th>   
            <th>Survivor's Upazila</th>   
            <th>Survivor's Union</th>   
            <th>Survivor's Village Name</th>   
            <th>Survivor's Ward</th>
            <th>Number of the Accused(s)</th>   
            <th>Name of Main Accused</th>   
            <th>Survivors' Relationship with Accused</th>   
            <th>Main Defendant Gender</th>   
            <th>Main Defendant Age</th>   
            <th>Defendant Division</th>   
            <th>Defendant District</th>   
            <th>Defendant Upazila</th>   
            <th>Defendant Union</th>   
            <th>Defendant Village Name</th>   
            <th>Defendant Ward</th> 
            <th>First initiative taken from SELP</th>
            <th>Referral No.</th>   
            <th>Primary Refferal</th>   
            <th>Referral Date</th>
            <th>Survivor's Household Type</th>   
            <th>Survivor'sTotal Household Income/Month</th>   
            <th>Survivor's Violence Location</th>   
            <th>Survivor Marital Status</th>   
            <th>Your Age during marriage</th>   
            <th>Survivor's Organization Affiliation</th>   
            <th>Survivor's NID number</th>   
            <th>Survivor's Reason of violence</th>   
            <th>Survivor's Place of violence</th>  
            <th>If accused family member(s)</th>   
            <th>Defendant/Accused family member(s)</th>   
            <th>Defendant/Accused Education</th>   
            <th>Defendant/Accused Occupation</th>
            <th>Any initiatives taken by survivors earlier for this dispute</th>
            <th>If Yes where??</th>
            <th>Causes of failure/coming to SELP</th>
            <th>Direct Service</th>
            <th>ADR</th>
            <th>Court Case</th>
            <th>Follow Up</th>
            <th>Secondary Refferal</th>
            <th>Have you ever face any violence ?</th>
            <th>At what age</th>
            <th>Type of violence</th>
            <th>Did you seek support from BRAC for that?</th>
            <th>What support did you receive from BRAC?</th>
        </tr>
    </thead>
    <tbody>
        @foreach($indicent_data as $data)
        <tr>
            <td>{{ @$data['id'] }}</td>
            <td>{{ @$data['posting_date'] }}</td>
            <td>{{ @$data['employee_name'] }}</td>
            <td>{{ @$data['employee_mobile_number'] }}</td>
            <td>{{ @$data['employee_designation'] }}</td>
            <td>{{ @$data['employee_pin'] }}</td>
            <td>{{ @$data['employee_zone']['region_name'] }}</td>   
            <td>{{ @$data['employee_division']['name'] }}</td>   
            <td>{{ @$data['employee_district']['name'] }}</td>   
            <td>{{ @$data['employee_upazila']['name'] }}</td>   
            <td>{{ @$data['information_provider']['name'] }}</td>   
            <td>{{ @$data['brac_program_name']['title'] }}</td>   
            <td>{{ @$data['referral_name'] }}</td>   
            <td>{{ @$data['informer_mobile_number'] }}</td>
            <td>{{ @$data['referral_gender']['name'] }}</td>   
            <td>{{ @$data['referral_occupation']['name'] }}</td>   
            <td>{{ @$data['types_of_disputes']['name'] }}</td>   
            <td>{{ @$data['date_of_dispute'] }}</td>
            <td>{{ @$data['applicant_survivor_same'] == 1 ? "Yes":"No"}}</td>
            <td>{{ @$data['applicant_name'] }}</td>   
            <td>{{ @$data['applicant_father_name'] }}</td>   
            <td>{{ @$data['applicant_mother_name'] }}</td>   
            <td>{{ @$data['applicant_husband_name'] }}</td>   
            <td>{{ @$data['applicant_age'] }}</td>   
            <td>{{ @$data['applicant_mobile_number'] }}</td>   
            <td>{{ @$data['applicant_mobile_number_on_request'] }}</td>   
            <td>{{ @$data['applicant_gender']['name'] }}</td>   
            <td>{{ @$data['applicant_education']['title'] }}</td>   
            <td>{{ @$data['applicant_occupation']['name'] }}</td>   
            <td>{{ @$data['applicant_religion']['name'] }}</td>   
            <td>{{ @$data['applicant_division']['name'] }}</td>   
            <td>{{ @$data['applicant_district']['name'] }}</td>   
            <td>{{ @$data['applicant_upazila']['name'] }}</td>   
            <td>{{ @$data['applicant_union']['name'] }}</td>   
            <td>{{ @$data['applicant_village_name'] }}</td>   
            <td>{{ @$data['applicant_ward'] }}</td>
            <td>{{ @$data['survivor_name'] }}</td>   
            <td>{{ @$data['survivor_father_name'] }}</td>   
            <td>{{ @$data['survivor_mother_name'] }}</td>   
            <td>{{ @$data['survivor_husband_name'] }}</td>   
            <td>{{ @$data['survivor_age'] }}</td>   
            <td>{{ @$data['survivor_mobile_number'] }}</td>   
            <td>{{ @$data['survivor_mobile_number_on_request'] }}</td>   
            <td>{{ @$data['survivor_gender']['name'] }}</td>   
            <td>{{ @$data['survivor_education']['title'] }}</td>   
            <td>{{ @$data['survivor_occupation']['name'] }}</td>   
            <td>{{ @$data['survivor_religion']['name'] }}</td>   
            <td>{{ @$data['survivor_disability']['name'] }}</td>   
            <td>{{ @$data['survivor_division']['name'] }}</td>   
            <td>{{ @$data['survivor_district']['name'] }}</td>   
            <td>{{ @$data['survivor_upazila']['name'] }}</td>   
            <td>{{ @$data['survivor_union']['name'] }}</td>   
            <td>{{ @$data['survivor_village_name'] }}</td>   
            <td>{{ @$data['survivor_ward'] }}</td>
            <td>{{ @$data['number_of_defendants'] }}</td>   
            <td>{{ @$data['main_defendants_name'] }}</td>   
            <td>{{ @$data['relation_main_accused']['name'] }}</td>   
            <td>{{ @$data['defendant_gender']['name'] }}</td>   
            <td>{{ @$data['main_defendant_age'] }}</td>   
            <td>{{ @$data['defendant_division']['name'] }}</td>   
            <td>{{ @$data['defendant_district']['name'] }}</td>   
            <td>{{ @$data['defendant_upazila']['name'] }}</td>   
            <td>{{ @$data['defendant_union']['name'] }}</td>   
            <td>{{ @$data['defendant_village_name'] }}</td>   
            <td>{{ @$data['defendant_ward'] }}</td>
            <td>
                @if(@$data['selp_initiative'] == 1)
                  Advice and referrel
                @endif
                @if(@$data['selp_initiative'] == 2)
                  Complain Received 
                @endif
                @if(@$data['selp_initiative'] == 3)
                 Violence Incident Documented 
                @endif
                @if(@$data['selp_initiative'] == 4)
                  Advice
                @endif
            </td>
            <td>{{ @$data['referral_no'] }}</td>
            <td>{{ @$data['refferal']['name'] }}</td>   
            <td>{{ @$data['referral_date'] }}</td>
            <td>{{ @$data['house_hold_type']['title'] }}</td>   
            <td>{{ @$data['household_total_income'] }}</td>   
            <td>{{ @$data['violence_location']['title'] }}</td>   
            <td>{{ @$data['marital_status']['name'] }}</td>   
            <td>{{ @$data['survivor_age_of_marriage'] }}</td>   
            {{-- <td>{{ (@$data['survivor_organization_affiliation_id'] == 1) ? "BRAC participants": ((@$data['survivor_organization_affiliation_id'] == 2) ? "Other organization":"Not applicable")}}</td>    --}}
            <td>
                @if(@$data['survivor_organization_affiliation_id'] == 1)
                BRAC participants
                @endif
                @if(@$data['survivor_organization_affiliation_id'] == 2)
                Other organization 
                @endif
                @if(@$data['survivor_organization_affiliation_id'] == 3)
                Not applicable
                @endif
            </td>
            <td>{{ @$data['survivor_nid'] }}</td>   
            <td>{{ @$data['survivor_violence_reason']['name'] }}</td>   
            <td>{{ @$data['violence_place']['name'] }}</td>
            {{-- <td>{{ @$data['if_perpetrator_family_member_yes_or_no'] == 1 ? "Yes":"No"}}</td>  --}}
            <td>{{ @$data['if_perpetrator_family_member_yes_or_no'] == 1 ? " Yes ":  (@$data['if_perpetrator_family_member_yes_or_no'] == null ? " ": "No")}} </td>     
            <td>{{ @$data['accuse_family_member']['name'] }}</td>   
            <td>{{ @$data['defendant_education']['title'] }}</td>   
            <td>{{ @$data['defendant_occupation']['name'] }}</td>
            <td>
                @if(@$data['earlier_survivor_initiative'] == 1)
                Yes
                @endif
                @if(@$data['earlier_survivor_initiative'] == 2)
                No
                @endif
            </td>
            {{-- <td>{{ @$data['earlier_survivor_initiative'] == 1 ? "Yes":"No"}}</td>    --}}
            <td>{{ @$data['selp_initiative_place']['title'] }}</td>  
            <td>{{ @$data['selp_coming_failour']['title'] }}</td>
            <td>
                @php
                    $types='';
                @endphp
                @foreach (@$data['direct_services'] as $item)
                @php 
                    if(@$item->service_type_id == 1){
                        $types.='(Assistance to treatment /medical support '.','.@$item->service_date.'),';
                    }
                    if(@$item->service_type_id == 2){
                        $types.='(Assistance to OCC '.','.@$item->service_date.'),';
                    }
                    if(@$item->service_type_id == 3){
                        $types.='(Alternative Dispute Resolution (ADR) ),';
                    }
                    if(@$item->service_type_id == 4){
                        $types.='(Assistance with court case)';
                    }
                @endphp
                    
                @endforeach

                {{$types}}
            </td>
            <td>
                @php
                    $types='';
                @endphp
                @foreach (@$data['direct_support_adr'] as $item)
                @php 
                    $types.='('.@$item->alternative_dispute_resolution->title.','.@$item->adr_money_recovered->title.','.@$item->amount_of_money_received.','.@$item->no_of_adr_participants_benefited.','.@$item->starting_date.','.@$item->closing_date.'),';
                @endphp
                    
                @endforeach

                {{$types}}
            </td>
            <td>
                @php
                    $types='';
                @endphp
                @foreach (@$data['direct_service_courtcase'] as $item)
                @php 
                    if(@$item->case_type == 1){
                        $types.='(Civil Case,'.@$item->civil_case->title.','.@$item->moneyrecover_case->title.','.@$item->amount_of_money_received.','.@$item->no_of_case_participants_benefited.','.@$item->judgement_status->title.','.@$item->case_start_date.','.@$item->case_judjement_date.')';
                    }
                    if(@$item->case_type == 2){
                        $types.='(GR/Police Case,'.@$item->police_case->title.','.@$item->moneyrecover_case->title.','.@$item->amount_of_money_received.','.@$item->no_of_case_participants_benefited.','.@$item->judgement_status->title.','.@$item->case_start_date.','.@$item->case_judjement_date.')';
                    }
                    if(@$item->case_type == 3){
                        $types.='(CR/Petition Case,'.@$item->petition_case->title.','.@$item->moneyrecover_case->title.','.@$item->amount_of_money_received.','.@$item->no_of_case_participants_benefited.','.@$item->judgement_status->title.','.@$item->case_start_date.','.@$item->case_judjement_date.')';
                    }
                @endphp
                    
                @endforeach

                {{$types}}
            </td>
            <td>
                @php
                    $types='';
                @endphp
                @foreach (@$data['direct_service_followup'] as $item)
                @php 
                    if(@$item->followup_number == 1){
                        $types.='( First Time ,'.(@$item->followup_type == 1? " Physically/ In-person" : "Online").','.@$item->findings_followup->title.','.@$item->followup_date.')';
                    }
                    if(@$item->followup_number == 2){
                        $types.='( Second Time ,'.(@$item->followup_type == 1? " Physically/ In-person" : "Online").','.@$item->findings_followup->title.','.@$item->followup_date.')';
                    }
                    if(@$item->followup_number == 3){
                        $types.='( Third Time ,'.(@$item->followup_type == 1? " Physically/ In-person" : "Online").','.@$item->findings_followup->title.','.@$item->followup_date.')';
                    }
                @endphp
                    
                @endforeach

                {{$types}}
            </td>
            <td>
                @php
                    $types='';
                @endphp
                @foreach (@$data['survivor_referral'] as $item)
                @php
                    $types.='( Referral To - '.@$item->complain_received_refferal->name.' , Referral Date - '.@$item->referral_date.' )';
                @endphp
                    
                @endforeach

                {{$types}}
            </td>

            <td>{{ @$data['have_survivor_face_violence_before'] == 1 ? " Yes ":  (@$data['have_survivor_face_violence_before'] == null ? " ": "No")}}</td>
            <td>{{ @$data['survivor_first_face_violence_age'] }}</td>
            
            @php
                $violence_data = App\Model\Admin\Setup\PreviousViolenceCategory::whereIn('id', explode(",",@$data['survivor_first_face_violence_type']))->get()->pluck('name');
            @endphp
            
            <td style="width:300px" class="tg-0pky">{{ implode(',',@$violence_data->toArray())}}</td>
            <td>{{ @$data['survivor_seek_support_from_brac'] == 1 ? " Yes ":  (@$data['survivor_seek_support_from_brac'] == null ? " ": "No")}}</td>
            <td>{{@$data['brac_support_type']['title']}}</td>
        </tr>
        @endforeach
    </tbody>
</table>