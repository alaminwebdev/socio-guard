<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
<table class="table table-bordered">
	<thead>
		  <tr>
			<th class="tg-0pky" rowspan="2">SL.</th>
			<th class="tg-c3ow" rowspan="2">Purpose of Money recovered</th>
			<th class="tg-c3ow" colspan="6">Initiatives of ADR</th>
		  </tr>
		  <tr>
			@foreach ($adrs as $item)
			<th class="tg-c3ow" style="width: 170px;">{{ $item->title }}</th>
			@endforeach
		</tr>
	</thead>
	<tbody>
		@foreach($informations as $key => $information)
			<tr>
				<td class="tg-0pky">{{ $loop->iteration }}</td>
				<td class="tg-0pky">{{ $key }}</td>
				@foreach($information as $keyy => $info)
					<td class="tg-0pky">{{ $info }}</td>
				@endforeach
			</tr>
		@endforeach
		{{-- <tr>
			<td></td>
			<td>Total</td>
		</tr> --}}
	</tbody>
</table>