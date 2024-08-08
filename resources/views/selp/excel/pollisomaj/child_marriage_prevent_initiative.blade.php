<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
<table class="table table-bordered">
		<thead>
			<tr>
			  <th class="tg-0pky">{{@$label_name}}</th>
			  <th class="tg-0pky">Contacted up within ps member</th>
			  <th class="tg-0pky">Contacted up beyond ps member</th>
			  <th class="tg-0pky">Contacted local within ps member</th>
			  <th class="tg-0pky">Contacted local beyond ps member</th>
			  <th class="tg-0pky">Family consultation within ps member</th>
			  <th class="tg-0pky">Family consultation beyond ps member</th>
			  <th class="tg-0pky">Contacted upazila within ps member</th>
			  <th class="tg-0pky">Contacted upazila beyond ps member</th>
			  <th class="tg-0lax">Hotline number within ps member</th>
			  <th class="tg-0pky">Hotline number beyond ps member</th>
			  <th class="tg-0pky">Total</th>
			</tr>
		  </thead>
		  <tbody>
			@for ($i = 0; $i < count($child_marriage_prevention_number); $i++)
				<tr>
					<td class="tg-0pky">{{@$child_marriage_prevention_number[$i]->name}}</td>
					<td class="tg-0pky">{{@$child_marriage_prevention_number[$i]->contacted_up_within_ps_member=='' ? '-' : @$child_marriage_prevention_number[$i]->contacted_up_within_ps_member }}</td>
					<td class="tg-0pky">{{@$child_marriage_prevention_number[$i]->contacted_up_beyond_ps_member=='' ? '-' : @$child_marriage_prevention_number[$i]->contacted_up_beyond_ps_member }}</td>
					<td class="tg-0pky">{{@$child_marriage_prevention_number[$i]->contacted_local_within_ps_member=='' ? '-' : @$child_marriage_prevention_number[$i]->contacted_local_within_ps_member }}</td>
					<td class="tg-0pky">{{@$child_marriage_prevention_number[$i]->contacted_local_beyond_ps_member=='' ? '-' : @$child_marriage_prevention_number[$i]->contacted_local_beyond_ps_member }}</td>
					<td class="tg-0pky">{{@$child_marriage_prevention_number[$i]->family_consultation_within_ps_member=='' ? '-' : @$child_marriage_prevention_number[$i]->family_consultation_within_ps_member }}</td>
					<td class="tg-0pky">{{@$child_marriage_prevention_number[$i]->family_consultation_beyond_ps_member=='' ? '-' : @$child_marriage_prevention_number[$i]->family_consultation_beyond_ps_member }}</td>
					<td class="tg-0pky">{{@$child_marriage_prevention_number[$i]->contacted_upazila_within_ps_member=='' ? '-' : @$child_marriage_prevention_number[$i]->contacted_upazila_within_ps_member }}</td>
					<td class="tg-0pky">{{@$child_marriage_prevention_number[$i]->contacted_upazila_beyond_ps_member=='' ? '-' : @$child_marriage_prevention_number[$i]->contacted_upazila_beyond_ps_member }}</td>
					<td class="tg-0lax">{{@$child_marriage_prevention_number[$i]->hotline_number_within_ps_member=='' ? '-' : @$child_marriage_prevention_number[$i]->hotline_number_within_ps_member }}</td>
					<td class="tg-0pky">{{@$child_marriage_prevention_number[$i]->hotline_number_beyond_ps_member=='' ? '-' : @$child_marriage_prevention_number[$i]->hotline_number_beyond_ps_member }}</td>
					<td class="tg-0pky">
						{{ @$child_marriage_prevention_number[$i]->contacted_up_within_ps_member+
						@$child_marriage_prevention_number[$i]->contacted_up_beyond_ps_member+
						@$child_marriage_prevention_number[$i]->contacted_local_within_ps_member+
						@$child_marriage_prevention_number[$i]->contacted_local_beyond_ps_member+
						@$child_marriage_prevention_number[$i]->family_consultation_within_ps_member+
						@$child_marriage_prevention_number[$i]->family_consultation_beyond_ps_member+
						@$child_marriage_prevention_number[$i]->contacted_upazila_within_ps_member+
						@$child_marriage_prevention_number[$i]->contacted_upazila_beyond_ps_member+
						@$child_marriage_prevention_number[$i]->hotline_number_within_ps_member+
						@$child_marriage_prevention_number[$i]->hotline_number_beyond_ps_member }}

					</td>
				</tr>
			  
			@endfor
			
		  </tbody>
	</table>


