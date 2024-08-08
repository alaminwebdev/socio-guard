@extends('selp.layouts.selp_adr_completed_report_header')
@section('content')
<br>
<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
	<table class="table table-bordered">
		<thead>
		  	<tr>
				<th class="tg-0pky" rowspan="2">SL.</th>
				<th class="tg-c3ow" rowspan="2">Purpose of Money recovered</th>
				<th class="tg-c3ow" colspan="4">ADR Completed</th>
		  	</tr>
		  	<tr>
				@foreach ($adrs as $item)
				<th class="tg-c3ow" style="width: 170px;">{{ $item->title }}</th>
				{{-- @if ($item->title != "Money paid after ADR" )
				@endif --}}
				@endforeach
				<th class="tg-c3ow" style="width: 170px;">Amount of Money Received</th>
				<th class="tg-c3ow" style="width: 170px;">No. of participants benefited</th>
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
					<td class="tg-0pky">{{ $loop->iteration }}</td>
					<td class="tg-0pky">{{ $key }}</td>
					
					@foreach($information as $keyy => $info)
					    @if(is_numeric($keyy))
							@php
							$sum+=$info["Amount of Money Received"];
							$sum_participant+=$info["No. of participants benefited"];
							@endphp
						@else
						<td class="tg-0pky">{{$info}}</td>	
							{{-- @if ($keyy != "Money paid after ADR")
							@endif --}}
						@endif
					@endforeach
					<td class="tg-0pky">{{$sum}}</td>	
					<td class="tg-0pky">{{$sum_participant}}</td>	
				</tr>
			@endforeach
			{{-- <tr>
				<td></td>
				<td>Total</td>
			</tr> --}}
		</tbody>
	</table>
@endsection

