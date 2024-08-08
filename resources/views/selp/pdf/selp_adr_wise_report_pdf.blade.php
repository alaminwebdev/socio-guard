@extends('selp.layouts.selp_refferel_report_header')
@section('content')
<br>
<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
	@if(@$informations['source'])
	<table class="table table-bordered">
		<thead>
			@foreach($informations['source'] as $source_key => $source )
			@if(key($informations['source']) == $source_key)
			<tr>
				<td>Area / ADR</td>
				@foreach($source['adr'] as $adr_key => $adr )
				<td>{{ $adr['title'] }}</td>
				@endforeach
				{{-- <td>Total</td> --}}
			</tr>
			@endif
			@endforeach

		</thead>
		<tbody>
			@foreach($informations['source'] as $source )
			<tr>
				<td>{{ $source['name'] }}</td>
				@php
				$total = 0;
				@endphp
				@foreach($source['adr'] as $adr_key => $adr )
				<td>{{ @$adr['count'] }}</td>
				@php
				$total += (int)@$adr['count'];
				@endphp
				@endforeach
				{{-- <td>{{ $total }}</td> --}}
			</tr>
			@endforeach
		</tbody>
	</table>
	@endif
@endsection

