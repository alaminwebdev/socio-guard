@extends('selp.layouts.test_report_header')
@section('content')
<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$date_from }} |</b>&nbsp;<b>To Date : {{ @$date_to }}</b></p>
	<table class="table table-bordered">
		<thead>
			<tr>
			  	<th >Division</th>
			  	<th>District</th>
			  	<th>Upazila</th>
			  	@foreach($information_providers as $key => $provider)
					<th>{{ $provider->name }}</th>
				@endforeach
			  <th style="background-color: #e6e5e5">Total</th>
			</tr>
		</thead>
			<tbody>
				@foreach($selfDatas as $list )
					<tr>
						<td style="width: 100px;padding:0px;margin:0px;"  >{{ @$list['division_name'] }}</td>
						<td style="width: 100px;padding:0px;margin:0px;"  >{{ @$list['district_name'] }}</td>
						<td style="width: 100px;padding:0px;margin:0px;">{{ @$list['upazila_name'] }}</td>
						@php
							$row_total = 0;
						@endphp
						@foreach($information_providers as $key => $provider)
						@php
							$row_total += (int)@$list['information_provider_source_id_'.$provider->id];
						@endphp
						<td>{{ @$list['information_provider_source_id_'.$provider->id] }}</td>
						@endforeach
						<td>{{ @$row_total }}</td>
					</tr>
				@endforeach
				
				<tr >
					@php
						$rowTotalValue = 0;
					@endphp
					<td style="background-color: #ffe9e9; font-size: 16px;" colspan="3">Total</td>
					@foreach ($information_providers as $provider)
						<td style="background-color: #ffe9e9">{{ $selfDatas->sum('information_provider_source_id_'.$provider->id) }}</td>
						@php
							$rowTotalValue += $selfDatas->sum('information_provider_source_id_'.$provider->id);
						@endphp
					@endforeach
					<td style="background-color: #000000; color:#fff;font-size: 14px; font-weight:bold">{{ $rowTotalValue }}</td>
				</tr>
			</tbody>
		
	</table>
@endsection


{{-- @extends('selp.layouts.test_report_header')
@section('content')


<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$date_from }} |</b>&nbsp;<b>To Date : {{ @$date_to }}</b></p>
	<table class="table table-bordered">
		<thead>
			<tr>
			  	<th >Division</th>
			  	<th>District</th>
			  	<th>Upazila</th>
			  	@foreach($information_providers as $key => $provider)
					<th>{{ $provider->name }}</th>
				@endforeach
			  <th style="background-color: #e6e5e5">Total</th>
			</tr>
		</thead>
		
			<tbody>
				@php
					$rowTotal = 0;
				@endphp
				@foreach($informations['division'] as $key=>$division )
					
					@foreach($division['district'] as $districtkey =>$district )
						@foreach($district['upazila'] as $upazilakey => $upazila )
						<tr>
							<td style="width: 100px;padding:0px;margin:0px;"  >{{ $division['name'] }}</td>
							<td style="width: 100px;padding:0px;margin:0px;"  >{{ $district['name'] }}</td>
							<td style="width: 100px;padding:0px;margin:0px;">{{ $upazila['name'] }}</td>
							@foreach($upazila['information_provider'] as $providerkey => $provider )
								<td  >{{ $provider}}</td>
								@php
									$rowTotal += $provider;
								@endphp
							@endforeach
								<td  style="background-color: #e6e5e5">{{ $rowTotal }}</td>
							</tr>
						@php
							$rowTotal = 0;
						@endphp
						@endforeach
					@endforeach
				@endforeach

				<tr >
					@php
						$rowTotalValue = 0;
					@endphp
					<td style="background-color: #ffe9e9; font-size: 16px;" colspan="3">Total</td>
					@foreach ($information_providers as $infoTotal)
						<td style="background-color: #ffe9e9">{{ $selfDatas->where('information_provider_source_id', $infoTotal->id)->sum('total_count') }}</td>
						@php
							$rowTotalValue += $selfDatas->where('information_provider_source_id', $infoTotal->id)->sum('total_count');
						@endphp
					@endforeach
					<td style="background-color: #000000; color:#fff;font-size: 14px; font-weight:bold">{{ $rowTotalValue }}</td>
				</tr>
			</tbody>
		
	</table>
@endsection
 --}}
