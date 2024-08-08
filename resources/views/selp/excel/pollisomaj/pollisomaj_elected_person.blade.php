<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
<table class="table table-bordered" style="padding-top:70px;width:100%">
    <thead>
      <tr>
        <th style="text-align:left" class="tg-0lax" colspan="2">{{@$label_name}}</th>
        <th class="tg-0lax">Men</th>
        <th class="tg-0lax">Women</th>
        <th class="tg-0lax">Transgender</th>
        <th class="tg-0lax">PWD</th>
      </tr>
    </thead>
    <tbody>
      @for ($i = 0; $i < count($pollisomaj_elected_person); $i++)
          
      
      <tr>
        <td class="tg-0lax" rowspan="3">{{@$pollisomaj_elected_person[$i]->name}}</td>
        <td class="tg-0lax" style="width:300px">No. of PS members contests in Local Government Election (Persons):</td>
        <td class="tg-0lax">{{@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_men==null ? 0 : @$pollisomaj_elected_person[$i]->ps_mem_gov_elec_men}}</td>
        <td class="tg-0lax">{{@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_women==null ? 0 : @$pollisomaj_elected_person[$i]->ps_mem_gov_elec_women}}</td>
        <td class="tg-0lax">{{@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_transgender==null ? 0 : @$pollisomaj_elected_person[$i]->ps_mem_gov_elec_transgender }}</td>
        <td class="tg-0lax">{{@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_pwd==null ? 0 : @$pollisomaj_elected_person[$i]->ps_mem_gov_elec_pwd}}</td>
      </tr>
      <tr>
        <td class="tg-0lax" style="width:300px">No.of PS members elected in Local Government Election (Persons):</td>
        <td class="tg-0lax">{{@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_men_elected ==null ? 0 : @$pollisomaj_elected_person[$i]->ps_mem_gov_elec_men_elected }}</td>
        <td class="tg-0lax">{{@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_women_elected ==null ? 0 : @$pollisomaj_elected_person[$i]->ps_mem_gov_elec_women_elected}}</td>
        <td class="tg-0lax">{{@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_transgender_elected ==null ? 0 : @$pollisomaj_elected_person[$i]->ps_mem_gov_elec_transgender_elected}}</td>
        <td class="tg-0lax">{{@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_pwd_elected ==null ? 0 : @$pollisomaj_elected_person[$i]->ps_mem_gov_elec_pwd_elected}}</td>
      </tr>
      <tr>
        <td class="tg-0lax" style="text-align:left">Percentage (%)</td>
        <td class="tg-0lax">
          {{
            @$pollisomaj_elected_person[$i]->ps_mem_gov_elec_men==0 ? '0' : round((@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_men_elected/@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_men)*100,2)
          }}
        </td>
        <td class="tg-0lax">
          {{
            @$pollisomaj_elected_person[$i]->ps_mem_gov_elec_women==0 ? '0' : round((@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_women_elected/@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_women)*100,2)
          }}
        </td>
        <td class="tg-0lax">
          {{
            @$pollisomaj_elected_person[$i]->ps_mem_gov_elec_transgender==0 ? '0' : round((@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_men_elected/@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_transgender)*100,2)
          }}
        </td>
        <td class="tg-0lax">
          {{
            @$pollisomaj_elected_person[$i]->ps_mem_gov_elec_pwd==0 ? '0' : round((@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_pwd_elected/@$pollisomaj_elected_person[$i]->ps_mem_gov_elec_pwd)*100,2)
          }}
        </td>
      </tr>
      @endfor   
    </tbody>
    </table>

    