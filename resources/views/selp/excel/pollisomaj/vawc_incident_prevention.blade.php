
<div style="padding-top: 30px;">
	<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
	<table class="table table-bordered">
		<thead>
			<tr>
			  <th class="tg-0pky">{{@$label_name}}</th>
			  <th class="tg-0pky">Illegal Divorce</th>
			  <th class="tg-0pky">Illegal Polygamy</th>
			  <th class="tg-0pky">Family Conflict</th>
			  <th class="tg-0pky">Hilla Marriage</th>
			  <th class="tg-0pky">Illegal Arbitration</th>
			  <th class="tg-0pky">Illegal Fatwah</th>
			  <th class="tg-0pky">Physical Torture</th>
			  <th class="tg-0pky">Sexual Harassment</th>
			  <th class="tg-0pky">Total</th>
			</tr>
		  </thead>
		  <tbody>
			@for ($i = 0; $i < count($vawc_prevention_number); $i++)
				<tr>
					<td class="tg-0pky">{{@$vawc_prevention_number[$i]->name}}</td>
					<td class="tg-0pky">{{@$vawc_prevention_number[$i]->illegal_divorce=='' ? '-' : @$vawc_prevention_number[$i]->illegal_divorce }}</td>
					<td class="tg-0pky">{{@$vawc_prevention_number[$i]->illegal_polygamy=='' ? '-' : @$vawc_prevention_number[$i]->illegal_polygamy }}</td>
					<td class="tg-0pky">{{@$vawc_prevention_number[$i]->family_conflict=='' ? '-' : @$vawc_prevention_number[$i]->family_conflict }}</td>
					<td class="tg-0pky">{{@$vawc_prevention_number[$i]->hilla_marriage=='' ? '-' : @$vawc_prevention_number[$i]->hilla_marriage }}</td>
					<td class="tg-0pky">{{@$vawc_prevention_number[$i]->illegal_arbitration=='' ? '-' : @$vawc_prevention_number[$i]->illegal_arbitration }}</td>
					<td class="tg-0pky">{{@$vawc_prevention_number[$i]->illegal_fatwah=='' ? '-' : @$vawc_prevention_number[$i]->illegal_fatwah }}</td>
                    <td class="tg-0pky">{{@$vawc_prevention_number[$i]->physical_torture=='' ? '-' : @$vawc_prevention_number[$i]->physical_torture }}</td>
					<td class="tg-0pky">{{@$vawc_prevention_number[$i]->sexual_harassment=='' ? '-' : @$vawc_prevention_number[$i]->sexual_harassment }}</td>
                    <td class="tg-0pky">{{
                        @$vawc_prevention_number[$i]->illegal_divorce +
                        @$vawc_prevention_number[$i]->illegal_polygamy+
                        @$vawc_prevention_number[$i]->family_conflict+
                        @$vawc_prevention_number[$i]->hilla_marriage+
                        @$vawc_prevention_number[$i]->illegal_arbitration+
                        @$vawc_prevention_number[$i]->illegal_fatwah+
                        @$vawc_prevention_number[$i]->physical_torture+
                        @$vawc_prevention_number[$i]->sexual_harassment

                    }}
                    </td>
					
				</tr>
			  
			@endfor
			
		  </tbody>
	</table>
</div>


