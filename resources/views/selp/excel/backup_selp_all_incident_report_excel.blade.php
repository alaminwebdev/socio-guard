<table class="table table-bordered">
    <thead>
        <tr>
            {{-- Step 1 --}}
            {{-- <th style="background-color: #cfcfcf;">Reporting Date</th> --}}

            {{-- Data Insert by --}}
            <th>id</th>
            <th>Posting Date</th>
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

            <th>Is the applicant & survivor the same person?</th>   

            {{-- Applicant's Information : --}}

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
            
            {{-- Survivors Information --}}
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
            
            {{-- Defendant/Accused information --}}
            <th>Number of the Accused(s)</th>   
            <th>Name of Main Accused</th>   
            <th>Relation with main Accused</th>   
            <th>Main Defendant Gender</th>   
            <th>Main Defendant Age</th>   
            <th>Defendant Division</th>   
            <th>Defendant District</th>   
            <th>Defendant Upazila</th>   
            <th>Defendant Union</th>   
            <th>Defendant Village Name</th>   
            <th>Defendant Ward</th> 
            
            {{-- First initiative taken from SELP --}}
            <th>First initiative taken from SELP</th>

            {{-- if advice and referral --}}
            <th>Referral No.</th>   
            <th>Refferal To</th>   
            <th>Referral Date</th> 
            
            {{-- Survivor's Other Information --}}
            <th>Survivor's Household Type</th>   
            <th>Survivor'sTotal Household Income/Month</th>   
            <th>Survivor's Violence Location</th>   
            <th>Survivor Marital Status</th>   
            <th>What was the age of marriage?</th>   
            <th>Survivor's Organization Affiliation</th>   
            <th>Survivor's NID number</th>   
            <th>Survivor's Reason of violence</th>   
            <th>Survivor's Place of violence</th>  
            
            {{-- Defendant/Accused Other information --}}
            <th>If accused family member(s)</th>   
            <th>Defendant/Accused family member(s)</th>   
            <th>Defendant/Accused Education</th>   
            <th>Defendant/Accused Occupation</th>
            
            {{-- Status of initiative taken for this complaint --}}
            <th>Any initiatives taken by survivors earlier for this dispute</th>
            <th>If Yes where??</th>
            <th>Causes of failure/coming to SELP</th>

            {{-- Detail of direct services --}}
            {{-- Court Case --}}
            {{-- Followup --}}
            {{-- Referral --}}
            {{-- Survivor's previous violence history --}}
        </tr>
    </thead>
    <tbody>
        @foreach($indicent_data as $data)
        <tr>
            {{-- Data Insert by --}}
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

            {{-- Applicant's Information : --}}
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
            <td>{{ @$data['applicant_division_id'] }}</td>   
            <td>{{ @$data['applicant_district_id'] }}</td>   
            <td>{{ @$data['applicant_upazila']['name'] }}</td>   
            <td>{{ @$data['applicant_union']['name'] }}</td>   
            <td>{{ @$data['applicant_village_name'] }}</td>   
            <td>{{ @$data['applicant_ward'] }}</td>
            
            {{-- Survivors Information --}}
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
            
            {{-- Defendant/Accused information --}}
            <td>{{ @$data['number_of_defendants'] }}</td>   
            <td>{{ @$data['main_defendants_name'] }}</td>   
            <td>{{ @$data['main_defendant_reletionship']['name'] }}</td>   
            <td>{{ @$data['defendant_gender']['name'] }}</td>   
            <td>{{ @$data['main_defendant_age'] }}</td>   
            <td>{{ @$data['defendant_division']['name'] }}</td>   
            <td>{{ @$data['defendant_district']['name'] }}</td>   
            <td>{{ @$data['defendant_upazila']['name'] }}</td>   
            <td>{{ @$data['defendant_union']['name'] }}</td>   
            <td>{{ @$data['defendant_village_name'] }}</td>   
            <td>{{ @$data['defendant_ward'] }}</td>
            
            {{-- First initiative taken from SELP --}}
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
            
            {{-- if advice and referral --}}
            <td>{{ @$data['referral_no'] }}</td>   
            {{-- <td>{{ @$data['referral'] }}</td>    --}}
            <td>
                @if(@$data->referral == 1)
                Family/relatives
                @endif
                @if(@$data->referral == 2)
                Local leaders 
                @endif
                @if(@$data->referral == 3)
                DLAC 
                @endif
                @if(@$data->referral == 4)
                109/VAWC
                @endif
                @if(@$data->referral == 5)
                999/ police station
                @endif
                @if(@$data->referral == 6)
                1098 (help for children)
                @endif
                @if(@$data->referral == 7)
                NGO shelter home
                @endif
                @if(@$data->referral == 8)
                Govt. shelter home
                @endif
                @if(@$data->referral == 9)
                OCC
                @endif
                @if(@$data->referral == 10)
                Psychosocial counseling
                @endif
                @if(@$data->referral == 11)
                Upazila admin
                @endif
            </td>   
            <td>{{ @$data['referral_date'] }}</td>
            
            {{-- Survivor's Other Information --}}
            <td>{{ @$data['house_hold_type']['title'] }}</td>   
            <td>{{ @$data['household_total_income'] }}</td>   
            <td>{{ @$data['violence_location']['title'] }}</td>   
            <td>{{ @$data['marital_status']['name'] }}</td>   
            <td>{{ @$data['survivor_age_of_marriage'] }}</td>   
            <td>{{ (@$data['survivor_organization_affiliation_id'] == 1) ? "BRAC participants": ((@$data['survivor_organization_affiliation_id'] == 2) ? "Other organization":"Not applicable")}}</td>   
            <td>{{ @$data['survivor_nid'] }}</td>   
            <td>{{ @$data['survivor_violence_reason']['name'] }}</td>   
            <td>{{ @$data['violence_place']['name'] }}</td>

            {{-- Defendant/Accused Other information --}}
            <td>{{ @$data['if_perpetrator_family_member_yes_or_no'] == 1 ? "Yes":"No"}}</td>   
            <td>{{ @$data['defendant_family_member']['title'] }}</td>   
            <td>{{ @$data['defendant_education']['title'] }}</td>   
            <td>{{ @$data['defendant_occupation']['name'] }}</td>  
            
            {{-- Status of initiative taken for this complaint --}}
            <td>{{ @$data['earlier_survivor_initiative'] == 1 ? "Yes":"No"}}</td>   
            <td>{{ @$data['selp_initiative_place']['title'] }}</td>  
            <td>{{ @$data['selp_coming_failour']['title'] }}</td>
        <tr>
        @endforeach
    </tbody>
</table>