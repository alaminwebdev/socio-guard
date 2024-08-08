@extends('selp.layouts.selp_refferel_report_header')
@section('content')
<br>
<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
	@if(@$informations['area'])
	<table class="table table-bordered">
		<thead>
			<tr>
			  	<th class="tg-0pky">Area / Refferal</th>
			  	@foreach($refferel_to as $key => $refferel)
					<th class="tg-0pky">{{ $refferel->name }}</th>
				@endforeach
			  <th class="tg-0pky">Total</th>
			</tr>
		</thead>
		<tbody>
			@foreach($informations['area'] as $key=>$area )
			<tr>
				<td>{{ $area['name'] }}</td>
				@php
				$total = 0;
				@endphp
				@foreach($area['refferel'] as $refferel_key => $refferel )
				@php
				$total += (int)@$refferel;
				@endphp
				<td>{{ @$refferel }}</td>
				@endforeach
				<td>{{ $total }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@endif
@endsection

