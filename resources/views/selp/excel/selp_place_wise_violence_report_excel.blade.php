<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
<table class="table table-bordered">
	<thead>
		<tr>
			  <th class="tg-0pky">sl</th>
			  <th class="tg-0pky">Violence</th>
			  @foreach($violence_place as $key => $place)
				<th class="tg-0pky">{{ $place->name }}</th>
			@endforeach
		  <th class="tg-0pky">Total</th>
		</tr>
	</thead>
	@php
		$district_id = -1;
		@endphp
		<tbody>
			@foreach($informations['district'] as $key=>$district )
				
				@foreach($district['violence'] as $violence )
				@php
				$count = 0;
				@endphp
					@if($key!=$district_id)
						@php
							$key=$district_id;
							@endphp
						<tr>
							<td style="width: 100px;padding:0px;margin:0px;" class="tg-0pky" rowspan="{{ $violence_count }}">{{ $district['name'] }}</td>
							<td class="tg-0pky">{{ $violence['name'] }}</td>
							@for($i = 0 ; $i < count($violence['place']); $i++)
								<td class="tg-0pky">{{ $violence['place'][$i] }}</td>
								@php
									$count+=$violence['place'][$i];
								@endphp
							@endfor
							<td class="tg-0pky">{{ $count }}</td>
						</tr>
						@else
						<tr>
							<td class="tg-0pky">{{ $violence['name'] }}</td>
							@for($i = 0 ; $i < count($violence['place']); $i++)
								<td class="tg-0pky">{{ $violence['place'][$i] }}</td>
								@php
									$count+=$violence['place'][$i];
								@endphp
							@endfor
							<td class="tg-0pky">{{ $count }}</td>
						</tr>
					@endif
				@endforeach
			@endforeach
		</tbody>
</table>