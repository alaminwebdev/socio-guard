<!DOCTYPE html>
<html lang="en">
<title>Complaint ID - {{ @$pofileData->id}}</title>
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
            <div class="col-sm-12">
                <div class="text-center">
                    <img style="width: 100px;height: 40px;" src="{{asset('backend/images/logo-original.png')}}">
                </div>
                <div class="text-center">
                    <h4><strong>Social Empowerment and Legal Protection (SELP) </strong></h4>
                    <h5><strong>75 Mohakhali, Dhaka-1212</strong></h5>
                    <h5 style="font-weight: bold">Swapnosarothi Girl's Profile (Profile ID : {{ @$pofileData->id}}  | Creation Date : {{ @$pofileData->created_at ? @$pofileData->created_at->format('d-M-Y') : '' }})</h5>
                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="col-sm-12">
                <table border="1" width="100%">
                    <tbody>
                        <tr>
                            <td width="4%" class="text-center" rowspan="4"><p style="font-weight: bold;">1</p></td>
                            <td colspan="3"><p style="font-weight: bold;">Data Insert By</p></td>
                        </tr>
                        <tr>
                            <td><p>Name:  {{ @$pofileData->employee->name}}</p></td>
                            <td><p>Mobile No:  {{ @$pofileData->employee->mobile}}</p></td>
                            <td><p>Designation:  {{ @$pofileData->employee->designation}}</p></td>
                        </tr>
                        <tr>
                            <td><p>PIN : {{ @$pofileData->employee->pin}}</p></td>
                            <td><p>Zone : {{ @$pofileData->employee_zone->region_name}}</p></td>
                            <td><p>Division : {{ @$pofileData->employee_division->name}}</p></td>
                        </tr>
                        <tr>
                            <td><p>District : {{ @$pofileData->employee_district->name}}</p></td>
                            <td><p>Upazila : {{ @$pofileData->employee_upazila->name}}</p></td>
                            <td><p>Union : {{ @$pofileData->employee_union->name}}</p></td>
                        </tr>
                        <tr>
                            <td width="4%" class="text-center" rowspan="2"><p style="font-weight: bold;">2</p></td>
                            <td colspan="3"><p style="font-weight: bold;">Group Information</p></td>
                        </tr>
                        <tr>
                            <td><p>Group Name : {{ @$pofileData->groupName->group_name}}</p></td>
                            <td><p>Group Start : {{ @$pofileData->groupName->start_date ? @$pofileData->groupName->start_date->format('d-M-Y') : ''}}</p></td>
                            <td><p> Group Status: {{ @$pofileData->groupName->status == 1 ? 'Active' : 'Deactive' }}</p></td>
                        </tr>

                        <tr>
                            <td width="4%" class="text-center" rowspan="6"><p style="font-weight: bold;">3</p></td>
                            <td colspan="3"><p style="font-weight: bold;">Girl's Profile Information</p></td>
                            
                        </tr>
                        <tr>
                            <td><p>Profile Status : {{ @$pofileData->group_status}}</p></td>
                            <td colspan="3"><p>Profile Start : {{ @$pofileData->start_date ? @$pofileData->start_date->format('d-M-Y'): ''}}</p></td>
                        </tr>
                        <tr>
                            <td><p>Name: {{ @$pofileData->name}}</p></td>
                            <td><p>Age: {{ @$pofileData->age}}</p></td>
                            <td><p>Date Of Birth: {{ @$pofileData->date_of_birth ? @$pofileData->date_of_birth->format('d-M-Y'): ''}} </p></td>
                        </tr>
                        <tr>
                            <td><p>18 Year's completion Data: {{ @$pofileData->age_completion_date ? @$pofileData->age_completion_date->format('d-M-Y') : ''}}</p></td>
                            <td><p>Cell number: {{ @$pofileData->phone}}</p></td>
                            <td><p>Types of PWD: {{ @$pofileData->pwd->name}}</p></td>
                        </tr>
                        <tr>
                            <td><p>Division:  {{ @$pofileData->profile_division->name}}</p></td>
                            <td><p>District:  {{ @$pofileData->profile_district->name}}</p></td>
                            <td><p>Upazila: {{ @$pofileData->profile_upazila->name}}</p></td>
                        </tr>
                        <tr>
                            <td><p>Union: {{ @$pofileData->profile_union->name}}</p></td>
                            <td><p>Village: {{ @$pofileData->profile_village->name}} </p></td>
                            <td><p>Landmark: {{ @$pofileData->landmark}} </p></td>
                        </tr>
                      
                        <tr>
                            <td width="4%" class="text-center" rowspan="5"><p style="font-weight: bold;">4</p></td>
                            <td colspan="3"><p style="font-weight: bold;">Parents Information</p></td>
                        </tr>
                        <tr>
                            <td><p>Father's Name: {{ @$pofileData->fathers_name}}</p></td>
                            <td><p>Mother's Name:{{ @$pofileData->mothers_name}}</p></td>
                            <td><p>Guardian Name: {{ @$pofileData->guardian_name}}</p></td>
                        </tr>
                        <tr>
                            <td><p>Family Member: {{ @$pofileData->total_family_member}}</p></td>
                            <td><p>Father's Phone:{{ @$pofileData->father_phone}}</p></td>
                            <td><p>Mother's Phone: {{ @$pofileData->mother_phone}}</p></td>
                        </tr>
                        <tr>
                            <td><p>Father's occupation: {{ @$pofileData->f_occupation->name}}</p></td>
                            <td><p>Father's Income:{{ @$pofileData->father_income}}</p></td>
                            <td><p>Mother's Occupation: {{ @$pofileData->m_occupation->name}}</p></td>
                        </tr>
                        <tr>
                            <td><p>Mother Income: {{ @$pofileData->mother_income}}</p></td>
                            <td><p>Other Occupation:{{ @$pofileData->o_occupation->name}}</p></td>
                            <td><p>Other Income: {{ @$pofileData->other_income}}</p></td>
                        </tr>
                        @if (@$pofileData->amount_money)
                        <tr>
                            <td width="4%" class="text-center" rowspan="3"><p style="font-weight: bold;">5</p></td>
                            <td colspan="2"><p style="font-weight: bold;">Financial beneficiary (Is she financial beneficiary?) : Yes</p></td>
                            <td><p>Amount Of Money:{{ @$pofileData->amount_money}}</p></td>
                        </tr>
                        @endif
                        
                        
                        
                    </tbody>
                </table>
                <h4 style="font-weight:bold">6. Profile Skills</h4>
                @if ( count($pofileData->profile_skills) >= 1)
                <table border="1" width="100%">
                    <thead>
                        <tr >
                            <th align="center">Sl.</th>
                            <th align="center">Skill Code</th>
                            <th align="center">Skill Name</th>
                            <th align="center">Session Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pofileData->profile_skills as $profile_skill)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $profile_skill->skill->code }}</td>
                                <td>{{ $profile_skill->skill->name }}</td>
                                <td>{{ $profile_skill->skill_date->format('d-M-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif
                <h4 style="font-weight:bold">7. CM Initiatives</h4>
                @if ( count($pofileData->cmInitiatives) >= 1)
                <table border="1" width="100%">
                    <thead>
                        <tr>
                            <th align="center">Sl.</th>
                            <th align="center">Initiative</th>
                            <th align="center"> P.Type</th>
                            <th align="center">Prevention</th>
                            <th align="center">Age</th>
                            <th align="center">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pofileData->cmInitiatives as $initiative)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $initiative->initiative }}</td>
                                <td>
                                    {{ $initiative->preventionType->name }}
                                </td>
                                <td>
                                    {{ $initiative->preventionBy->name }}
                                </td>
                                <td>
                                    {{ $initiative->age }}
                                </td>
                                <td>{{ $initiative->date->format('d-M-Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @endif

                <h4 style="font-weight:bold">8. Marriage Info</h4>
                @if ( @$pofileData->marriageInfo)
                    <table border="1" width="100%">
                        <tbody>
                            <tr>
                                <td><p>Marriage Date:{{ $pofileData->marriageInfo->marriage_date ? @$pofileData->marriageInfo->marriage_date->format('d-M-Y') : ''  }}</p></td>
                                <td><p>Registration Completed:{{ @$pofileData->marriageInfo->registration_completed }}</p></td>
                                <td>
                                    <p>Who Registered: {{ @$pofileData->marriageInfo->whoRegistered->name }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Marriage Place:{{ @$pofileData->marriageInfo->marriagePlace->name }}</p>
                                </td>
                                <td>
                                    <p>Marriage Reason: {{ @$pofileData->marriageInfo->marriageReason->name }}</p>
                                </td>
                                <td>
                                    <p>Asked by Groom: {{ @$pofileData->marriageInfo->asked_by_groom }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Dower Amount:  {{ @$pofileData->marriageInfo->dower_amount }}</p>
                                </td>
                                <td>
                                    <p>Initiated Person: {{ @$pofileData->marriageInfo->marriagInitiatedPerson->name }}</p>
                                </td>
                                <td>
                                    <p>Girl Education: {{ @$pofileData->marriageInfo->girlEducational->title }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Studentship Status: {{ @$pofileData->marriageInfo->studentship_status }}</p>
                                </td>
                                <td>
                                    <p>Institution: {{ @$pofileData->marriageInfo->educatinalInstitution->name }}</p>
                                </td>
                                <td>
                                    <p>Groom's Age: {{ @$pofileData->marriageInfo->groom_age }}</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Groom's Profession: {{ @$pofileData->marriageInfo->groomProfession->name }}</p>
                                </td>
                                <td>
                                    <p>Groom's Education: {{ @$pofileData->marriageInfo->groomEducation->title }}</p>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>

                @endif
            </div>
        </div>
    </div>
</body>
</html>
