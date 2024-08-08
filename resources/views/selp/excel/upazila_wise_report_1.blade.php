<table>
	<tr>
        <td colspan="10">
            <strong>Report Name:{{ @$title }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="20">
            <p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District :
                {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$date_from }}
                |</b>&nbsp;<b>To Date : {{ @$date_to }}</b></p>
        </td>
    </tr>
</table>
<table class="table table-bordered">
	<thead>
		<tr>
			  <th >Division</th>
			  <th>District</th>
			  <th>Upazila</th>
			  @foreach($information_providers as $key => $provider)
				<th>{{ $provider->name }}</th>
			@endforeach
		  <th>Total</th>
		</tr>
	</thead>
		<tbody>
			@foreach($selfDatas as $list )
				<tr>
					<td>{{ @$list['division_name'] }}</td>
					<td>{{ @$list['district_name'] }}</td>
					<td>{{ @$list['upazila_name'] }}</td>
					@php
						$row_total = 0;
					@endphp
					@foreach($information_providers as $key => $provider)
					@php
						$row_total += (int)@$list['information_provider_source_id_'.$provider->id];
					@endphp
					<td>{{ @$list['information_provider_source_id_'.$provider->id] }}</td>
					@endforeach
					<td>{{ @$row_total }}</td>
				</tr>
			@endforeach
			
			<tr >
				@php
					$rowTotalValue = 0;
				@endphp
				<td colspan="3">Total</td>
				@foreach ($information_providers as $provider)
					<td >{{ $selfDatas->sum('information_provider_source_id_'.$provider->id) }}</td>
					@php
						$rowTotalValue += $selfDatas->sum('information_provider_source_id_'.$provider->id);
					@endphp
				@endforeach
				<td>{{ $rowTotalValue }}</td>
			</tr>
		</tbody>
	
</table>

