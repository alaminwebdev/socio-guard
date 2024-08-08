
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
        <tr>
            <td>{{ @$incident_data['id'] }}</td>
            <td>{{ @$incident_data['posting_date'] }}</td>
            <td>{{ @$incident_data['employee_name'] }}</td>
            <td>{{ @$incident_data['employee_mobile_number'] }}</td>
            <td>{{ @$incident_data['employee_designation'] }}</td>
            <td>{{ @$incident_data['employee_pin'] }}</td>
            <td>{{ @$incident_data['employee_zone']['region_name'] }}</td>   
            <td>{{ @$incident_data['employee_division']['name'] }}</td>   
            <td>{{ @$incident_data['employee_district']['name'] }}</td>   
            <td>{{ @$incident_data['employee_upazila']['name'] }}</td>   
            <td>{{ @$incident_data['information_provider']['name'] }}</td>   
            <td>{{ @$incident_data['brac_program_name']['title'] }}</td>   
            <td>{{ @$incident_data['referral_name'] }}</td>   
            <td>{{ @$incident_data['informer_mobile_number'] }}</td>
            <td>{{ @$incident_data['referral_gender']['name'] }}</td>   
            <td>{{ @$incident_data['referral_occupation']['name'] }}</td>   
            <td>{{ @$incident_data['types_of_disputes']['name'] }}</td>   
            <td>{{ @$incident_data['date_of_dispute'] }}</td>
            <td>{{ @$incident_data['applicant_survivor_same'] == 1 ? " Yes ":  (@$incident_data['applicant_survivor_same'] == null ? " ": "No")}}</td>
            <td>{{ @$incident_data['applicant_name'] }}</td>   
            <td>{{ @$incident_data['applicant_father_name'] }}</td>   
            <td>{{ @$incident_data['applicant_mother_name'] }}</td>   
            <td>{{ @$incident_data['applicant_husband_name'] }}</td>   
            <td>{{ @$incident_data['applicant_age'] }}</td>   
            <td>{{ @$incident_data['applicant_mobile_number'] }}</td>   
            <td>{{ @$incident_data['applicant_mobile_number_on_request'] }}</td>   
            <td>{{ @$incident_data['applicant_gender']['name'] }}</td>   
            <td>{{ @$incident_data['applicant_education']['title'] }}</td>   
            <td>{{ @$incident_data['applicant_occupation']['name'] }}</td>   
            <td>{{ @$incident_data['applicant_religion']['name'] }}</td>   
            <td>{{ @$incident_data['applicant_division']['name'] }}</td>   
            <td>{{ @$incident_data['applicant_district']['name'] }}</td>   
            <td>{{ @$incident_data['applicant_upazila']['name'] }}</td>   
            <td>{{ @$incident_data['applicant_union']['name'] }}</td>   
            <td>{{ @$incident_data['applicant_village_name'] }}</td>   
            <td>{{ @$incident_data['applicant_ward'] }}</td>
            <td>{{ @$incident_data['survivor_name'] }}</td>   
            <td>{{ @$incident_data['survivor_father_name'] }}</td>   
            <td>{{ @$incident_data['survivor_mother_name'] }}</td>   
            <td>{{ @$incident_data['survivor_husband_name'] }}</td>   
            <td>{{ @$incident_data['survivor_age'] }}</td>   
            <td>{{ @$incident_data['survivor_mobile_number'] }}</td>   
            <td>{{ @$incident_data['survivor_mobile_number_on_request'] }}</td>   
            <td>{{ @$incident_data['survivor_gender']['name'] }}</td>   
            <td>{{ @$incident_data['survivor_education']['title'] }}</td>   
            <td>{{ @$incident_data['survivor_occupation']['name'] }}</td>   
            <td>{{ @$incident_data['survivor_religion']['name'] }}</td>   
            <td>{{ @$incident_data['survivor_disability']['name'] }}</td>   
            <td>{{ @$incident_data['survivor_division']['name'] }}</td>   
            <td>{{ @$incident_data['survivor_district']['name'] }}</td>   
            <td>{{ @$incident_data['survivor_upazila']['name'] }}</td>   
            <td>{{ @$incident_data['survivor_union']['name'] }}</td>   
            <td>{{ @$incident_data['survivor_village_name'] }}</td>   
            <td>{{ @$incident_data['survivor_ward'] }}</td>
            <td>{{ @$incident_data['number_of_defendants'] }}</td>   
            <td>{{ @$incident_data['main_defendants_name'] }}</td>   
            <td>{{ @$incident_data['relation_main_accused']['name'] }}</td>   
            <td>{{ @$incident_data['defendant_gender']['name'] }}</td>   
            <td>{{ @$incident_data['main_defendant_age'] }}</td>   
            <td>{{ @$incident_data['defendant_division']['name'] }}</td>   
            <td>{{ @$incident_data['defendant_district']['name'] }}</td>   
            <td>{{ @$incident_data['defendant_upazila']['name'] }}</td>   
            <td>{{ @$incident_data['defendant_union']['name'] }}</td>   
            <td>{{ @$incident_data['defendant_village_name'] }}</td>   
            <td>{{ @$incident_data['defendant_ward'] }}</td>
            <td>
                @if(@$incident_data['selp_initiative'] == 1)
                  Advice and referrel
                @endif
                @if(@$incident_data['selp_initiative'] == 2)
                  Complain Received 
                @endif
                @if(@$incident_data['selp_initiative'] == 3)
                 Violence Incident Documented 
                @endif
                @if(@$incident_data['selp_initiative'] == 4)
                  Advice
                @endif
            </td>
            <td>{{ @$incident_data['referral_no'] }}</td>
            <td>{{  @$incident_data['refferal']['name'] }}</td>   
            <td>{{ @$incident_data['referral_date'] }}</td>
            <td>{{ @$incident_data['house_hold_type']['title'] }}</td>   
            <td>{{ @$incident_data['household_total_income'] }}</td>   
            <td>{{ @$incident_data['violence_location']['title'] }}</td>   
            <td>{{ @$incident_data['marital_status']['name'] }}</td>   
            <td>{{ @$incident_data['survivor_age_of_marriage'] }}</td>
            
            <td>
                @if(@$incident_data['survivor_organization_affiliation_id'] == 1)
                BRAC participants
                @endif
                @if(@$incident_data['survivor_organization_affiliation_id'] == 2)
                Other organization 
                @endif
                @if(@$incident_data['survivor_organization_affiliation_id'] == 3)
                Not applicable
                @endif
            </td>

            {{-- <td>{{ (@$incident_data['survivor_organization_affiliation_id'] == 1) ? "BRAC participants": ((@$incident_data['survivor_organization_affiliation_id'] == 2) ? "Other organization":"Not applicable")}}</td>    --}}
            <td>{{ @$incident_data['survivor_nid'] }}</td>   
            <td>{{ @$incident_data['survivor_violence_reason']['name'] }}</td>   
            <td>{{ @$incident_data['violence_place']['name'] }}</td>
            <td>{{ @$incident_data['if_perpetrator_family_member_yes_or_no'] == 1 ? " Yes ":  (@$incident_data['if_perpetrator_family_member_yes_or_no'] == null ? " ": "No")}} </td>   
            <td>{{ @$incident_data['accuse_family_member']['name'] }}</td>   
            <td>{{ @$incident_data['defendant_education']['title'] }}</td>   
            <td>{{ @$incident_data['defendant_occupation']['name'] }}</td>
            <td>{{ @$incident_data['earlier_survivor_initiative'] == 1 ? "Yes":"No"}}</td>   
            <td>{{ @$incident_data['selp_initiative_place']['title'] }}</td>  
            <td>{{ @$incident_data['selp_coming_failour']['title'] }}</td>
            <td>
                @php
                    $types='';
                @endphp
                @foreach (@$incident_data['direct_services'] as $item)
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
                @foreach (@$incident_data['direct_support_adr'] as $item)
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
                @foreach (@$incident_data['direct_service_courtcase'] as $item)
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
                @foreach (@$incident_data['direct_service_followup'] as $item)
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
                    @foreach (@$incident_data['survivor_referral'] as $item)
                    @php 
                        $types.='( Referral To - '.@$item->complain_received_refferal->name.' , Referral Date - '.@$item->referral_date.' )';
                    @endphp
                    
                    @endforeach

                {{$types}}
            </td>

            <td>{{ @$incident_data['have_survivor_face_violence_before'] == 1 ? " Yes ":  (@$incident_data['have_survivor_face_violence_before'] == null ? " ": "No")}}</td>
            <td>{{ @$incident_data['survivor_first_face_violence_age'] }}</td>
            
            @php
                $data = App\Model\Admin\Setup\PreviousViolenceCategory::whereIn('id', explode(",",@$incident_data['survivor_first_face_violence_type']))->get()->pluck('name');
            @endphp
            
            <td style="width:300px" class="tg-0pky">{{ implode(',',@$data->toArray())}}</td>
            <td>{{ @$incident_data['survivor_seek_support_from_brac'] == 1 ? " Yes ":  (@$incident_data['survivor_seek_support_from_brac'] == null ? " ": "No")}}</td>
            <td>{{@$incident_data['brac_support_type']['title']}}</td>
        </tr>
    </tbody>
</table>