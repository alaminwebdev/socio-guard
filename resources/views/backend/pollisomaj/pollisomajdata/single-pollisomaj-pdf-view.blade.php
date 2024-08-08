<!DOCTYPE html>
<html lang="en">
<title>Data Entry No - {{ formatIncidentId($pollisomaj->id) }}</title>
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
          <h5><strong>Community Mobilisation</strong></h5>
          <h5><strong>75 Mohakhali, Dhaka-1212</strong></h5>
          <h5 style="font-weight: bold">Data Entry No : {{ formatIncidentId($pollisomaj->id) }} | Posting Date : {{ date('d-m-Y', strtotime($pollisomaj->created_at)) }}</h5>
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
              <th class="tg-0pky table_bg" colspan="6" style="font-weight: bold">1. Data Entry for month: {{ date('d-M-Y', strtotime($pollisomaj->created_at)) }} &nbsp;&nbsp;,&nbsp;&nbsp; <span>Reporting Date: {{ $pollisomaj->reporting_date  == null ? '' : date('d-M-Y', strtotime($pollisomaj->reporting_date)) }}</span></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky data_entry">Zone</td>
              <td class="tg-0pky data_entry">{{ @$pollisomaj['zones']['region_name'] }}</td>
              <td class="tg-0pky data_entry">Division</td>
              <td class="tg-0pky data_entry">{{ @$pollisomaj['division']['name'] }}</td>
              <td class="tg-0pky data_entry">District</td>
              <td class="tg-0pky data_entry">{{ @$pollisomaj['district']['name'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky data_entry">Upazila:</td>
              <td class="tg-0pky data_entry">{{ @$pollisomaj['upazilla']['name'] }}</td>
              <td class="tg-0pky data_entry">Union</td>
              <td class="tg-0pky data_entry">{{ @$pollisomaj['union']['name'] }}</td>
              <td class="tg-0pky data_entry">Village</td>
              <td class="tg-0pky data_entry">{{ @$pollisomaj['village_name'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky data_entry">Ward No:</td>
              <td class="tg-0pky data_entry">{{ @$pollisomaj['ward_no'] }}</td>
              <td class="tg-0pky data_entry">Pollisomaj Name</td>
              <td class="tg-0pky data_entry">{{ @$pollisomaj['pollisomaj_info']['pollisomaj_name'] }}</td>
              <td class="tg-0pky data_entry">Pollisomaj No</td>
              <td class="tg-0pky data_entry">{{ @$pollisomaj['pollisomaj_no'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky data_entry">Date of pollisomaj Reformation:</td>
              <td class="tg-0pky data_entry" colspan="5">{{@$pollisomaj['ps_reform_date'] != null ? date("d-m-Y", strtotime(@$pollisomaj['ps_reform_date'])) : ''}}</td>
            </tr>
          </tbody>
        </table>

        <br>
        {{-- 2. Member Details --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="12" style="font-weight: bold">2. Member Details</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky member_width">Girls</td>
              <td class="tg-0pky member_width">{{ @$pollisomaj['member_girls'] }}</td>
              <td class="tg-0pky member_width">Boys</td>
              <td class="tg-0pky member_width">{{ @$pollisomaj['member_boys'] }}</td>
              <td class="tg-0pky member_width">Female</td>
              <td class="tg-0pky member_width">{{ @$pollisomaj['member_female'] }}</td>
              <td class="tg-0pky member_width">Male</td>
              <td class="tg-0pky member_width">{{ @$pollisomaj['member_male'] }}</td>
              <td class="tg-0pky member_width">Transgender</td>
              <td class="tg-0pky member_width">{{ @$pollisomaj['member_transgender'] }}</td>
              <td class="tg-0pky member_width">Total</td>
              <td class="tg-0pky member_width">{{ @$pollisomaj['general_member_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="12"><span style="font-weight:500;font-style:normal">Person with disabilities (PWD)</span></td>
            </tr>
            <tr>
              <td class="tg-0pky member_width">Girls</td>
              <td class="tg-0pky member_width">{{ @$pollisomaj['member_girls_pwd'] }}</td>
              <td class="tg-0pky member_width">Boys</td>
              <td class="tg-0pky member_width">{{ @$pollisomaj['member_boys_pwd'] }}</td>
              <td class="tg-0pky member_width">Female</td>
              <td class="tg-0pky member_width">{{ @$pollisomaj['member_female_pwd'] }}</td>
              <td class="tg-0pky member_width">Male</td>
              <td class="tg-0pky member_width">{{ @$pollisomaj['member_male_pwd'] }}</td>
              <td class="tg-0pky member_width">Transgender</td>
              <td class="tg-0pky member_width">{{ @$pollisomaj['member_transgender_pwd'] }}</td>
              <td class="tg-0pky member_width">Total</td>
              <td class="tg-0pky member_width">{{ @$pollisomaj['general_member_pwd_total'] }}</td>
            </tr>
          </tbody>
        </table>

        <br>
        {{-- 3. The contact number of key 3 persons --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="2" style="font-weight: bold">3. The contact number of key 3 persons</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky" style="width: 240px;">President Contact Number</td>
              <td class="tg-0pky">{{ @$pollisomaj['p_number'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" style="width: 240px;">Secretary Contact Number</td>
              <td class="tg-0pky">{{ @$pollisomaj['s_number'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" style="width: 240px;">Cashier Contact Number</td>
              <td class="tg-0pky">{{ @$pollisomaj['c_number'] }}</td>
            </tr>
          </tbody>
        </table>

        <br>
        {{-- 4. Taken preventive initiative --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="3" style="font-weight: bold"><span style="font-weight:400;font-style:normal">4. Taken preventive initiative</span></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky"><span style="font-weight:400;font-style:normal">Number of Child Marriage Reported</span></td>
              <td class="tg-0pky" colspan="2">{{ @$pollisomaj['number_of_child_marriage'] }}</td>
            </tr>
            <tr>
              <td class="tg-0lax table_bg" colspan="3" style="font-weight: bold">4.1. Initiatives taken to prevent child marriage</td>
            </tr>
            <tr>
              <td class="tg-0pky"></td>
              <td class="tg-0pky"><span style="font-weight:400;font-style:normal">Within PS members</span></td>
              <td class="tg-0pky"><span style="font-weight:400;font-style:normal">Beyond PS members</span></td>
            </tr>
            <tr>
              <td class="tg-0pky">Contacted UP</td>
              <td class="tg-0pky"  style="text-align: center">{{ @$pollisomaj['contacted_up_within_ps_member'] }}</td>
              <td class="tg-0pky"  style="text-align: center">{{ @$pollisomaj['contacted_up_beyond_ps_member'] }}</td>
            </tr>
            <tr>
              <td class="tg-0lax">Contacted Local Thana</td>
              <td class="tg-0lax"  style="text-align: center">{{ @$pollisomaj['contacted_local_within_ps_member'] }}</td>
              <td class="tg-0lax"  style="text-align: center">{{ @$pollisomaj['contacted_local_beyond_ps_member'] }}</td>
            </tr>
            <tr>
              <td class="tg-0lax">Family Consultation</td>
              <td class="tg-0lax"  style="text-align: center">{{ @$pollisomaj['family_consultation_within_ps_member'] }}</td>
              <td class="tg-0lax"  style="text-align: center">{{ @$pollisomaj['family_consultation_beyond_ps_member'] }}</td>
            </tr>
            <tr>
              <td class="tg-0lax">Contacted Upazila administration</td>
              <td class="tg-0lax"  style="text-align: center">{{ @$pollisomaj['contacted_upazila_within_ps_member'] }}</td>
              <td class="tg-0lax"  style="text-align: center">{{ @$pollisomaj['contacted_upazila_beyond_ps_member'] }}</td>
            </tr>
            <tr>
              <td class="tg-0lax">Dialed on Hotline numbers</td>
              <td class="tg-0lax"  style="text-align: center">{{ @$pollisomaj['hotline_number_within_ps_member'] }}</td>
              <td class="tg-0lax"  style="text-align: center">{{ @$pollisomaj['hotline_number_beyond_ps_member'] }}</td>
            </tr>
          </tbody>
        </table>

        <div class="page_break">
        </div>

        <br>
        {{-- 4.2. Girls at a risk of Child marriage mapping --}}
        <table class="tg">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="5" style="font-weight: bold">4.2. Girls at a risk of Child marriage mapping</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky"></td>
              <td class="tg-0pky" colspan="2" style="width: 200px; text-align:center">Girls</td>
              <td class="tg-0pky" colspan="2" style="width: 200px; text-align:center">PWD</td>
            </tr>
            <tr>
              <td class="tg-0pky">Number of girls identified as at risk of child marriage</td>
              <td class="tg-0pky" colspan="2" style="text-align: center">{{ @$pollisomaj['girls_risk_of_child_marriage'] }}</td>
              <td class="tg-0pky" colspan="2" style="text-align: center">{{ @$pollisomaj['girls_risk_of_child_marriage_pwd'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">Card provided among girls/families Box for number</td>
              <td class="tg-0pky" colspan="2" style="text-align: center">{{ @$pollisomaj['card_provided_among_girls'] }}</td>
              <td class="tg-0pky" colspan="2" style="text-align: center">{{ @$pollisomaj['card_provided_among_pwd'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">Number of identified girls/ families are referred/connected to service</td>
              <td class="tg-0pky" colspan="2" style="text-align: center">{{ @$pollisomaj['girls_connected_to_service'] }}</td>
              <td class="tg-0pky" colspan="2" style="text-align: center">{{ @$pollisomaj['girls_connected_to_service_pwd'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="5"></td>
            </tr>
            <tr>
              <td class="tg-0pky"></td>
              <td class="tg-0pky" style="text-align: center">Girls</td>
              <td class="tg-0pky" style="text-align: center">PWD</td>
              <td class="tg-0pky" style="text-align: center">Married at 18+</td>
              <td class="tg-0pky" style="text-align: center">Married under 18</td>
            </tr>
            <tr>
              <td class="tg-0pky">Number of identified girls got married finally</td>
              <td class="tg-0pky" style="text-align: center">{{ @$pollisomaj['girls_got_married_finally'] }}</td>
              <td class="tg-0pky" style="text-align: center">{{ @$pollisomaj['girls_got_married_finally_pwd'] }}</td>
              <td class="tg-0pky" style="text-align: center">{{ @$pollisomaj['girls_got_married_at_18_finally'] }}</td>
              <td class="tg-0pky" style="text-align: center">{{ @$pollisomaj['girls_got_married_under_18_finally_pwd'] }}</td>
            </tr>
          </tbody>
        </table>

        <br>
        {{-- 4.3. VAWC Preventive initiative --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="8" style="font-weight: bold">4.3. VAWC Preventive initiative</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky">Illegal divorce</td>
              <td class="tg-0pky">{{ @$pollisomaj['illegal_divorce'] }}</td>
              <td class="tg-0pky">Illegal polygamy</td>
              <td class="tg-0pky">{{ @$pollisomaj['illegal_polygamy'] }}</td>
              <td class="tg-0pky">Family Conflict</td>
              <td class="tg-0pky">{{ @$pollisomaj['family_conflict'] }}</td>
              <td class="tg-0pky">Hilla marriage</td>
              <td class="tg-0pky">{{ @$pollisomaj['hilla_marriage'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">Illegal arbitration</td>
              <td class="tg-0pky">{{ @$pollisomaj['illegal_arbitration'] }}</td>
              <td class="tg-0pky">Illegal fatwa</td>
              <td class="tg-0pky">{{ @$pollisomaj['illegal_fatwah'] }}</td>
              <td class="tg-0pky">Physical torture</td>
              <td class="tg-0pky">{{ @$pollisomaj['physical_torture'] }}</td>
              <td class="tg-0pky">Sexual harassment</td>
              <td class="tg-0pky">{{ @$pollisomaj['sexual_harassment'] }}</td>
            </tr>
          </tbody>
        </table>

        <br>
        {{-- 5. Involvement with Local power structure --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="5" style="font-weight: bold">5. Involvement with Local power structure</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky"></td>
              <td class="tg-0pky" style="width: 80px;">Men</td>
              <td class="tg-0pky" style="width: 80px;">Womens</td>
              <td class="tg-0pky" style="width: 80px;">Transgender</td>
              <td class="tg-0pky" style="width: 80px;">PWD</td>
            </tr>
            <tr>
              <td class="tg-0pky">No. of PS members contests in Local Government Election (Persons):</td>
              <td class="tg-0pky">{{ @$pollisomaj['ps_mem_gov_elec_men'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['ps_mem_gov_elec_women'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['ps_mem_gov_elec_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['ps_mem_gov_elec_pwd'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">No.of PS members elected in Local Government Election (Persons):</td>
              <td class="tg-0pky">{{ @$pollisomaj['ps_mem_gov_elec_men_elected'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['ps_mem_gov_elec_women_elected'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['ps_mem_gov_elec_transgender_elected'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['ps_mem_gov_elec_pwd_elected'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="5"></td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="2"></td>
              <td class="tg-0pky">Contested as Joyeeta</td>
              <td class="tg-0pky">Womens</td>
              <td class="tg-0pky">PWD</td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="2">No.of PS members in Joyeeta Contested</td>
              <td class="tg-0pky">{{ @$pollisomaj['contested_as_joyeeta'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['joyeeta_contested_women'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['joyeeta_contested_pwd'] }}</td>
            </tr>
            <tr>
              <td class="tg-0lax" colspan="5"></td>
            </tr>
            <tr>
              <td class="tg-0lax" colspan="2"></td>
              <td class="tg-0lax">Selected at the upazila level</td>
              <td class="tg-0lax">Selected at the district level</td>
              <td class="tg-0lax">Selected at the national level</td>
            </tr>
            <tr>
              <td class="tg-0lax" colspan="2">No.of PS members in Joyeeta selected</td>
              <td class="tg-0pky">{{ @$pollisomaj['joyeeta_dis_selected'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['joyeeta_div_selected'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['joyeeta_national_selected'] }}</td>
            </tr>
          </tbody>
        </table>



        <div class="page_break">
        </div>


        <br>
        {{-- 5.1. No.of PS members selected/elected in different committees --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="8" style="font-weight: bold">5.1. No.of PS members selected/elected in different committees</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky"></td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">Boys</td>
              <td class="tg-0pky">Girls</td>
              <td class="tg-0pky">Male</td>
              <td class="tg-0pky">Female</td>
              <td class="tg-0pky">Transgender</td>
              <td class="tg-0pky">Total</td>
            </tr>

            <tr>
              <td class="tg-0pky" rowspan="2">School/Madrasah committee</td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">{{ @$pollisomaj['school_committee_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['school_committee_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['school_committee_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['school_committee_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['school_committee_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['school_committee_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">PWD</td>
              <td class="tg-0pky">{{ @$pollisomaj['school_committee_pwd_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['school_committee_pwd_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['school_committee_pwd_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['school_committee_pwd_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['school_committee_pwd_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['school_committee_pwd_total'] }}</td>
            </tr>

            <tr>
              <td class="tg-0pky" rowspan="2">Hat-Bazar committee</td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">{{ @$pollisomaj['hatbazar_committee_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['hatbazar_committee_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['hatbazar_committee_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['hatbazar_committee_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['hatbazar_committee_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['hatbazar_committee_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">PWD</td>
              <td class="tg-0pky">{{ @$pollisomaj['hatbazar_committee_pwd_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['hatbazar_committee_pwd_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['hatbazar_committee_pwd_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['hatbazar_committee_pwd_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['hatbazar_committee_pwd_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['hatbazar_committee_pwd_total'] }}</td>
            </tr>

            <tr>
              <td class="tg-0pky" rowspan="2">UP Standing committee</td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">{{ @$pollisomaj['stading_committee_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['stading_committee_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['stading_committee_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['stading_committee_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['stading_committee_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['stading_committee_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">PWD</td>
              <td class="tg-0pky">{{ @$pollisomaj['stading_committee_pwd_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['stading_committee_pwd_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['stading_committee_pwd_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['stading_committee_pwd_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['stading_committee_pwd_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['stading_committee_pwd_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" rowspan="2">Community clinic committee:</td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">{{ @$pollisomaj['clinic_committee_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['clinic_committee_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['clinic_committee_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['clinic_committee_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['clinic_committee_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['clinic_committee_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">PWD</td>
              <td class="tg-0pky">{{ @$pollisomaj['clinic_committee_pwd_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['clinic_committee_pwd_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['clinic_committee_pwd_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['clinic_committee_pwd_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['clinic_committee_pwd_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['clinic_committee_pwd_total'] }}</td>
            </tr>

            <tr>
              <td class="tg-0pky" rowspan="2">Religion institution committee</td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">{{ @$pollisomaj['institution_committee_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['institution_committee_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['institution_committee_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['institution_committee_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['institution_committee_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['institution_committee_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">PWD</td>
              <td class="tg-0pky">{{ @$pollisomaj['institution_committee_pwd_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['institution_committee_pwd_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['institution_committee_pwd_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['institution_committee_pwd_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['institution_committee_pwd_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['institution_committee_pwd_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" rowspan="2">Village Social Solidarity Committee (VSSC)</td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">{{ @$pollisomaj['solidarity_committee_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['solidarity_committee_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['solidarity_committee_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['solidarity_committee_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['solidarity_committee_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['solidarity_committee_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">PWD</td>
              <td class="tg-0pky">{{ @$pollisomaj['solidarity_committee_pwd_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['solidarity_committee_pwd_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['solidarity_committee_pwd_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['solidarity_committee_pwd_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['solidarity_committee_pwd_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['solidarity_committee_pwd_total'] }}</td>
            </tr>

            <tr>
              <td class="tg-0pky" rowspan="2">NGO/Club/Social welfare committee</td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">{{ @$pollisomaj['welfare_committee_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['welfare_committee_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['welfare_committee_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['welfare_committee_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['welfare_committee_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['welfare_committee_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">PWD</td>
              <td class="tg-0pky">{{ @$pollisomaj['welfare_committee_pwd_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['welfare_committee_pwd_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['welfare_committee_pwd_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['welfare_committee_pwd_female'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['welfare_committee_pwd_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['welfare_committee_pwd_total'] }}</td>
            </tr>
          </tbody>
        </table>


        <br>
        {{-- 6.1. Number of people received/assisted with IGA training --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="8" style="font-weight: bold">6.1. Number of people received/assisted with IGA training</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky"></td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">Boys</td>
              <td class="tg-0pky">Girls</td>
              <td class="tg-0pky">Male</td>
              <td class="tg-0pky">Female</td>
              <td class="tg-0pky">Transgender</td>
              <td class="tg-0pky">Total</td>
            </tr>

            <tr>
              <td class="tg-0pky" rowspan="2">PS Members</td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_ps_mem_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_ps_mem_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_ps_mem_men'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_ps_mem_women'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_ps_mem_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_ps_mem_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">PWD</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_ps_mem_pwd_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_ps_mem_pwd_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_ps_mem_pwd_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_ps_mem_pwd_women'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_ps_mem_pwd_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_ps_mem_pwd_total'] }}</td>
            </tr>

            <tr>
              <td class="tg-0pky" rowspan="2">Out of PS</td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_without_ps_mem_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_without_ps_mem_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_without_ps_mem_men'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_without_ps_mem_women'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_without_ps_mem_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_without_ps_mem_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">PWD</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_without_ps_mem_pwd_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_without_ps_mem_pwd_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_without_ps_mem_pwd_male'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_without_ps_mem_pwd_women'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_without_ps_mem_pwd_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_financial_without_ps_mem_pwd_total'] }}</td>
            </tr>
          </tbody>
        </table>


        <br>
        {{-- 6.2. Persons involved in financial activities after receiving IGA Training --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="8" style="font-weight: bold">6.2. Persons involved in financial activities after receiving IGA Training</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky"></td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">Boys</td>
              <td class="tg-0pky">Girls</td>
              <td class="tg-0pky">Male</td>
              <td class="tg-0pky">Female</td>
              <td class="tg-0pky">Transgender</td>
              <td class="tg-0pky">Total</td>
            </tr>

            <tr>
              <td class="tg-0pky" rowspan="2">PS Members</td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_ps_mem_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_ps_mem_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_ps_mem_men'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_ps_mem_women'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_ps_mem_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_ps_mem_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">PWD</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_ps_mem_pwd_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_ps_mem_pwd_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_ps_mem_pwd_men'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_ps_mem_pwd_women'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_ps_mem_pwd_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_ps_mem_pwd_total'] }}</td>
            </tr>

            <tr>
              <td class="tg-0pky" rowspan="2">Out of PS</td>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_without_ps_mem_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_without_ps_mem_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_without_ps_mem_men'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_without_ps_mem_women'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_without_ps_mem_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_without_ps_mem_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky">PWD</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_without_ps_mem_pwd_boys'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_without_ps_mem_pwd_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_without_ps_mem_pwd_men'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_without_ps_mem_pwd_women'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_without_ps_mem_pwd_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['iga_training_without_ps_mem_pwd_total'] }}</td>
            </tr>
          </tbody>
        </table>


        <div class="page_break">
        </div>


        <br>
        {{-- 7. Awareness sessions/meetings of Polli Shomaj --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="9" style="font-weight: bold">7. Awareness sessions/meetings of Polli Shomaj</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky text-center"></td>
              <td class="tg-0pky text-center" colspan="3">No. of Session</td>
              <td class="tg-0pky text-center" colspan="3">Total participent</td>
              <td class="tg-0pky text-center" colspan="2">PWD</td>
            </tr>
            <tr>
              <td class="tg-0pky text-center">Number of Session with Men</td>
              <td class="tg-0pky text-center" colspan="3">{{ @$pollisomaj['no_of_session_with_men'] }}</td>
              <td class="tg-0pky text-center" colspan="3">{{ @$pollisomaj['session_with_men_total'] }}</td>
              <td class="tg-0pky text-center" colspan="2">{{ @$pollisomaj['session_with_men_pwd_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky text-center">Number of Session with Women</td>
              <td class="tg-0pky text-center" colspan="3">{{ @$pollisomaj['no_of_session_with_women'] }}</td>
              <td class="tg-0pky text-center" colspan="3">{{ @$pollisomaj['session_with_women_total'] }}</td>
              <td class="tg-0pky text-center" colspan="2">{{ @$pollisomaj['session_with_women_pwd_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0lax" colspan="9"></td>
            </tr>
            <tr>
              <td class="tg-0lax text-center"></td>
              <td class="tg-0lax text-center" colspan="2">No. of Session</td>
              <td class="tg-0lax text-center" colspan="2">Boys</td>
              <td class="tg-0lax text-center">Girl</td>
              <td class="tg-0lax text-center">Total</td>
              <td class="tg-0lax text-center" colspan="2">PWD</td>
            </tr>
            <tr>
              <td class="tg-0pky text-center">Number of Session with Adolescents</td>
              <td class="tg-0pky text-center" colspan="2">{{ @$pollisomaj['no_of_session_with_adolescent'] }}</td>
              <td class="tg-0pky text-center" colspan="2">{{ @$pollisomaj['session_with_adolescent_boys'] }}</td>
              <td class="tg-0pky text-center">{{ @$pollisomaj['session_with_adolescent_girls'] }}</td>
              <td class="tg-0lax text-center">{{ @$pollisomaj['session_with_adolescent_total'] }}</td>
              <td class="tg-0lax text-center" colspan="2">{{ @$pollisomaj['session_with_adolescent_pwd_total'] }}</td>
            </tr>
            <tr>
              <td class="tg-0pky" colspan="9"></td>
            </tr>
            <tr>
              <td class="tg-0lax"></td>
              <td class="tg-0lax">No. of Session</td>
              <td class="tg-0lax">Boys</td>
              <td class="tg-0lax">Girl</td>
              <td class="tg-0lax">Men</td>
              <td class="tg-0lax">Women</td>
              <td class="tg-0lax">Transgender</td>
              <td class="tg-0lax">PWD</td>
              <td class="tg-0lax">Total</td>
            </tr>
            <tr>
              <td class="tg-0lax text-center">Number of sessions with PS</td>
              <td class="tg-0lax text-center">{{ @$pollisomaj['no_of_session_with_ps'] }}</td>
              <td class="tg-0lax text-center">{{ @$pollisomaj['session_with_ps_boys'] }}</td>
              <td class="tg-0lax text-center">{{ @$pollisomaj['session_with_ps_girls'] }}</td>
              <td class="tg-0lax text-center">{{ @$pollisomaj['session_with_ps_men'] }}</td>
              <td class="tg-0lax text-center">{{ @$pollisomaj['session_with_ps_women'] }}</td>
              <td class="tg-0lax text-center">{{ @$pollisomaj['session_with_ps_transgender'] }}</td>
              <td class="tg-0lax text-center">{{ @$pollisomaj['session_with_ps_pwd'] }}</td>
              <td class="tg-0lax text-center">{{ @$pollisomaj['session_with_ps_total'] }}</td>
            </tr>
          </tbody>
          </table>




        <br>
        {{-- 8. PS leaders received orientation/ capacity building training by SELP --}}
        <table class="tg" width="100%">
          <thead>
            <tr>
              <th class="tg-0pky table_bg" colspan="7" style="font-weight: bold">8. PS leaders received orientation/ capacity building training by SELP</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td class="tg-0pky"></td>
              <td class="tg-0pky">Boys</td>
              <td class="tg-0pky">Girls</td>
              <td class="tg-0pky">Male</td>
              <td class="tg-0pky">Female</td>
              <td class="tg-0pky">Transgender</td>
              <td class="tg-0pky">Total</td>
            </tr>

            <tr>
              <td class="tg-0pky">No. of Participants</td>
              <td class="tg-0pky">{{ @$pollisomaj['capacity_building_training_by_selp_boy'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['capacity_building_training_by_selp_girls'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['capacity_building_training_by_selp_men'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['capacity_building_training_by_selp_women'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['capacity_building_training_by_selp_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['capacity_building_training_by_selp_total'] }}</td>
            </tr>

            <tr>
              <td class="tg-0pky">PWD</td>
              <td class="tg-0pky">{{ @$pollisomaj['capacity_building_training_by_selp_boy_pwd'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['capacity_building_training_by_selp_girls_pwd'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['capacity_building_training_by_selp_men_pwd'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['capacity_building_training_by_selp_women_pwd'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['capacity_building_training_by_selp_girls_transgender'] }}</td>
              <td class="tg-0pky">{{ @$pollisomaj['capacity_building_training_by_selp_pwd_total'] }}</td>
            </tr>
          </tbody>
        </table>



      </div>
    </div>
  </div>
</body>
</html>
