@extends('backend.layouts.platform-header')
@section('content')
<div style="padding-top: 30px;">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th rowspan="2">SL. No.</th>
				<th rowspan="2">Particulars</th>
				<th rowspan="2">Type</th>
				<th colspan="3">{{ $from_year }} to {{ $to_year }}</th>
				<th colspan="3">{{ $month }}</th>
				<th colspan="3">For the year {{ date('Y') }}</th>
				<!-- <th colspan="3">2000 to present month</th> -->
			</tr>
			<tr>
				<th>M</th>
				<th>F</th>
				<th>T</th>
				<th>M</th>
				<th>F</th>
				<th>T</th>
				<th>M</th>
				<th>F</th>
				<th>T</th>
				<!-- <th>M</th>
				<th>F</th>
				<th>T</th> -->
			</tr>
			<tr>
				<th colspan="15" style="text-align: left;">Platform</th>
			</tr>
		</thead>
		<tbody>
		@php
			$year_between_male_total = 0;
			$year_between_female_total = 0;
			$year_between_total = 0;
			$current_month_male_total = 0;
			$current_month_female_total = 0;
			$current_month_total = 0;
			$for_year_male_total = 0;
			$for_year_female_total = 0;
			$for_year_total = 0;
			$year_to_present_month_male_total = 0;
			$year_to_present_month_female_total = 0;
			$year_to_present_month_total = 0;
		@endphp
			@foreach($survivor_info as $info)
				<tr>
					@if($loop->index == 0)
					<td rowspan="{{$info['rows']+1}}">{{$loop->iteration}}</td>
					<td rowspan="{{$info['rows']+1}}">No. of survivors information reported by</td>
					@endif
					<td>{{$info['type']}}</td>
					<td>{{ $info['year_between']['male']}} @php  $year_between_male_total +=  $info['year_between']['male'] @endphp</td>
					<td>{{ $info['year_between']['female'] }} @php  $year_between_female_total +=  $info['year_between']['female'] @endphp</td>
					<td>{{ $info['year_between']['total'] }} @php  $year_between_total +=  $info['year_between']['total'] @endphp</td>
					<td>{{ $info['current_month']['male'] }} @php  $current_month_male_total +=  $info['current_month']['male'] @endphp</td>
					<td>{{ $info['current_month']['female'] }} @php  $current_month_female_total +=  $info['current_month']['female'] @endphp</td>
					<td>{{ $info['current_month']['total'] }} @php  $current_month_total +=  $info['current_month']['total'] @endphp</td>
					<td>{{ $info['for_year']['male'] }} @php  $for_year_male_total +=  $info['for_year']['male'] @endphp</td>
					<td>{{ $info['for_year']['female'] }} @php  $for_year_female_total +=  $info['for_year']['female'] @endphp</td>
					<td>{{ $info['for_year']['total'] }} @php  $for_year_total +=  $info['for_year']['total'] @endphp</td>
					<!-- <td>{{ $info['year_to_present_month']['male'] }} @php  $year_to_present_month_male_total +=  $info['year_to_present_month']['male'] @endphp</td>
					<td>{{ $info['year_to_present_month']['female'] }} @php  $year_to_present_month_female_total +=  $info['year_to_present_month']['female'] @endphp</td>
					<td>{{ $info['year_to_present_month']['total'] }} @php  $year_to_present_month_total +=  $info['year_to_present_month']['total'] @endphp</td> -->
				</tr>
			@endforeach
				<tr>
					<td>Total</td>
					<td>{{$year_between_male_total}}</td>
					<td>{{$year_between_female_total}}</td>
					<td>{{$year_between_total}}</td>
					<td>{{$current_month_male_total}}</td>
					<td>{{$current_month_female_total}}</td>
					<td>{{$current_month_total}}</td>
					<td>{{$for_year_male_total}}</td>
					<td>{{$for_year_female_total}}</td>
					<td>{{$for_year_total}}</td>
					<!-- <td>{{$year_to_present_month_male_total}}</td>
					<td>{{$year_to_present_month_female_total}}</td>
					<td>{{$year_to_present_month_total}}</td> -->

				</tr>
		</tbody>
	</table>
</div>
@endsection

