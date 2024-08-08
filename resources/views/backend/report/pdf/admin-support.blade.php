@extends('backend.layouts.relationship-header')
@section('content')
<p><b>Zone : {{ $region['region_name'] }},</b>&nbsp;<b>Division : {{ $division['name'] }},</b>&nbsp;<b>District : {{ $district['name'] }},</b>&nbsp;<b>Upazila : {{ $upazila['name'] }},</b>&nbsp;<b>From Date : {{ $from_date }},</b>&nbsp;<b>To Date : {{ $to_date }}</b></p>
	<table class="table table-bordered">
		<thead>
			@foreach($informations['support'] as $support_key => $support )
			@if(key($informations['support']) == $support_key)
			<tr>
				<td>Relationship with perpetrator</td>
				@foreach($support['violence'] as $violence_key => $violence )
				<td>{{ $violence['name'] }}</td>
				@endforeach
				<td>Total</td>
			</tr>
			@endif
			@endforeach

		</thead>
		<tbody>
			@foreach($informations['support'] as $support )
			<tr>
				<td>{{ @$support['name'] }}</td>
				@php
				$total = 0;
				@endphp
				@foreach($support['violence'] as $violence_key => $violence )
				@php
				$total += (int)@$violence['count'];
				@endphp
				<td>{{ @$violence['count'] ?? 0 }}</td>
				@endforeach
				<td>{{ $total }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
@endsection

