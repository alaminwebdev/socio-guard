@extends('selp.layouts.selp_mis_report_header')
{{-- <p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p> --}}
@section('content')
	<table class="table table-bordered">
	<thead>
	  <tr>
		{{-- <th class="tg-0pky" style="width: 100px;padding:0px;margin:0px;">District</th> --}}
		<th class="tg-0pky">Violence</th>
		<th class="tg-0pky">0-5</th>
		<th class="tg-0pky">6-12</th>
		<th class="tg-0pky"><span style="font-weight:400;font-style:normal;text-decoration:none">13-17</span></th>
		<th class="tg-0lax">18-22</th>
		<th class="tg-0lax">23-30</th>
		<th class="tg-0lax">31-40</th>
		<th class="tg-0lax">41-50</th>
		<th class="tg-0lax">50-above</th>
		<th class="tg-0lax">Total</th>
	  </tr>
	</thead>
	{{-- @php
	$district_id = -1;
	@endphp --}}
	<tbody>
		{{-- @foreach($informations['district'] as $key=>$district ) --}}
			@foreach($informations['violence'] as $violence )
				{{-- @if($key!=$district_id)
					@php
						$key=$district_id;
					@endphp --}}
					{{-- <tr>
						<td class="tg-0pky" colspan="11"></td>
					</tr> --}}
					<tr>
						{{-- <td style="width: 100px;padding:0px;margin:0px;" class="tg-0pky" rowspan="{{ $violence_count }}">{{ $district['name'] }}</td> --}}
						<td class="tg-0pky">{{ $violence['name'] }}</td>
						<td class="tg-0pky">{{ $violence['age']['0-5'] }}</td>
						<td class="tg-0pky">{{ $violence['age']['6-12'] }}</td>
						<td class="tg-0pky">{{ $violence['age']['13-17'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['18-22'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['23-30'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['31-40'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['40-50'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['51-above'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['0-5'] +
							$violence['age']['6-12']+
							$violence['age']['13-17']+
							$violence['age']['18-22']+
							$violence['age']['23-30']+
							$violence['age']['31-40']+
							$violence['age']['40-50']+
							$violence['age']['51-above'] }}</td>
					</tr>
				{{-- @else
					<tr>
						<td class="tg-0pky">{{ $violence['name'] }}</td>
						<td class="tg-0pky">{{ $violence['age']['0-5'] }}</td>
						<td class="tg-0pky">{{ $violence['age']['6-12'] }}</td>
						<td class="tg-0pky">{{ $violence['age']['13-17'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['18-22'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['23-30'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['31-40'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['40-50'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['51-above'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['0-5'] +
							$violence['age']['6-12']+
							$violence['age']['13-17']+
							$violence['age']['18-22']+
							$violence['age']['23-30']+
							$violence['age']['31-40']+
							$violence['age']['40-50']+
							$violence['age']['51-above'] }}</td>
					</tr>
				@endif --}}
			@endforeach
		{{-- @endforeach --}}
	</tbody>
	</table>
@endsection

