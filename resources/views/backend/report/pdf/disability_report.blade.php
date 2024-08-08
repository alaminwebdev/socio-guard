@extends('backend.layouts.disability-header')
@section('content')
{{-- <p style="text-align: center"><b>Zone : {{ $region['region_name'] }},</b>&nbsp;<b>Division : {{ $division['name'] }},</b>&nbsp;<b>District : {{ $district['name'] }},</b>&nbsp;<b>Upazila : {{ $upazila['name'] }},</b>&nbsp;<b>Gender : {{ $gender['name'] }},</b>&nbsp;<b>From Date : {{ $from_date }},</b>&nbsp;<b>To Date : {{ $to_date }}</b></p> --}}
	@if(@$informations['source'])
	<table class="table table-bordered">
		<thead>
			@foreach($informations['source'] as $source_key => $source )
			@if(key($informations['source']) == $source_key)
			<tr>
				<td>Type of disability</td>
				@foreach($source['violence'] as $violence_key => $violence )
				<td>{{ $violence['name'] }}</td>
				@endforeach
				<td>Total</td>
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
				@foreach($source['violence'] as $violence_key => $violence )
				@php
				$total += (int)@$violence['count'];
				@endphp
				<td>{{ @$violence['count'] }}</td>
				@endforeach
				<td>{{ $total }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	@endif
@endsection

