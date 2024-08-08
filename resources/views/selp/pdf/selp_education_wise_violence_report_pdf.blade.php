@extends('selp.layouts.selp_mis_report_header')
@section('content')
<style type="text/css">
	
	</style>
{{-- <p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p> --}}
	<table class="table table-bordered">
	<thead>
	  <tr>
		<th class="tg-0pky" style="width: 100px;padding:0px;margin:0px;">Education</th>
		<th class="tg-0pky">Violence</th>
		<th class="tg-0pky">0-17</th>
		<th class="tg-0pky">18-25</th>
		<th class="tg-0pky"><span style="font-weight:400;font-style:normal;text-decoration:none">26-35</span></th>
		<th class="tg-0lax">36-45</th>
		<th class="tg-0lax">46-above</th>
		<th class="tg-0lax">Total</th>
	  </tr>
	</thead>
	@php
	$district_id = -1;
	@endphp
	<tbody>
		@foreach($informations['education'] as $key=>$district )
			@foreach($district['violence'] as $violence )
				@if($key!=$district_id)
					@php
						$key=$district_id;
					@endphp
					{{-- <tr>
						<td class="tg-0pky" colspan="11"></td>
					</tr> --}}
					<tr>
						<td style="width: 100px;padding:0px;margin:0px;" class="tg-0pky" rowspan="{{ $violence_count }}">{{ $district['title'] }}</td>
						<td class="tg-0pky">{{ $violence['name'] }}</td>
						<td class="tg-0pky">{{ $violence['age']['0-17'] }}</td>
						<td class="tg-0pky">{{ $violence['age']['18-25'] }}</td>
						<td class="tg-0pky">{{ $violence['age']['26-35'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['36-45'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['46-above'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['0-17'] +
							$violence['age']['18-25']+
							$violence['age']['26-35']+
							$violence['age']['36-45']+
							$violence['age']['46-above'] }}</td>
					</tr>
				@else
					<tr>
						<td class="tg-0pky">{{ $violence['name'] }}</td>
						<td class="tg-0pky">{{ $violence['age']['0-17'] }}</td>
						<td class="tg-0pky">{{ $violence['age']['18-25'] }}</td>
						<td class="tg-0pky">{{ $violence['age']['26-35'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['36-45'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['46-above'] }}</td>
						<td class="tg-0lax">{{ $violence['age']['0-17'] +
							$violence['age']['18-25']+
							$violence['age']['26-35']+
							$violence['age']['36-45']+
							$violence['age']['46-above'] }}</td>
					</tr>
				@endif
			@endforeach
		@endforeach
	</tbody>
	</table>
@endsection

