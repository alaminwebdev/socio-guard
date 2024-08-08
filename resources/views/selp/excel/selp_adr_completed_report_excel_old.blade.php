<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
<table class="table table-bordered">
	<thead>
		  <tr>
			<th  rowspan="2">SL.</th>
			<th  rowspan="2">Purpose of Money recovered</th>
			<th  colspan="4">ADR Completed</th>
		  </tr>
		  <tr>
			@foreach ($adrs as $item)
			<th>{{ $item->title }}</th>
			@endforeach
			<th >Amount of Money Received</th>
			<th>No. of participants benefited</th>
		</tr>
	</thead>
	<tbody>
		{{-- @dd($informations) --}}
		@foreach($informations as $key => $information)
		{{-- @dd($information); --}}
		@php
			$sum=0;
			$sum_participant=0;
		@endphp
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $key }}</td>
				@foreach($information as $keyy => $info)
					@if(is_numeric($keyy))
						@php
						$sum+=$info["Amount of Money Received"];
						$sum_participant+=$info["No. of participants benefited"];
						@endphp
					@else
					 <td>{{$info}}</td>	
					@endif
					
				@endforeach
				<td>{{$sum}}</td>	
				<td>{{$sum_participant}}</td>	
			</tr>
		@endforeach
		{{-- <tr>
			<td></td>
			<td>Total</td>
		</tr> --}}
	</tbody>
</table>