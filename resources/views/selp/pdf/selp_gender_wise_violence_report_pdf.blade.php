@extends('selp.layouts.selp_mis_report_header')
@section('content')
<style type="text/css">
	
	</style>
{{-- <p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p> --}}
	<table class="table table-bordered">
		<thead>
			<tr>
			  	<th class="tg-0pky">sl</th>
			  	<th class="tg-0pky">Violence</th>
			  	@foreach($violence_place as $key => $place)
					<th class="tg-0pky">{{ $place->name }}</th>
				@endforeach
			  <th class="tg-0pky">Total</th>
			</tr>
		</thead>
		@php
			$district_id = -1;
			@endphp
			<tbody>
				@foreach($informations['district'] as $key=>$district )
					
					@foreach($district['violence'] as $violence )
					@php
					$count = 0;
					@endphp
						@if($key!=$district_id)
							@php
								$key=$district_id;
								@endphp
							<tr>
								<td style="width: 100px;padding:0px;margin:0px;" class="tg-0pky" rowspan="{{ $violence_count }}">{{ $district['name'] }}</td>
								<td class="tg-0pky">{{ $violence['name'] }}</td>
								@for($i = 0 ; $i < count($violence['gender']); $i++)
									<td class="tg-0pky">{{ $violence['gender'][$i] }}</td>
									@php
										$count+=$violence['gender'][$i];
									@endphp
								@endfor
								<td class="tg-0pky">{{ $count }}</td>
							</tr>
							@else
							<tr>
								<td class="tg-0pky">{{ $violence['name'] }}</td>
								@for($i = 0 ; $i < count($violence['gender']); $i++)
									<td class="tg-0pky">{{ $violence['gender'][$i] }}</td>
									@php
										$count+=$violence['gender'][$i];
									@endphp
								@endfor
								<td class="tg-0pky">{{ $count }}</td>
							</tr>
						@endif
					@endforeach
				@endforeach
			</tbody>
		{{-- <tbody>
			<tr>
			  <td class="tg-0pky" rowspan="3">Dhaka</td>
			  <td class="tg-0pky">V1</td>
			  <td class="tg-0pky">1</td>
			  <td class="tg-0pky">0</td>
			  <td class="tg-0pky">2</td>
			  <td class="tg-0pky">3</td>
			</tr>
			<tr>
			  <td class="tg-0pky">V2</td>
			  <td class="tg-0pky">0</td>
			  <td class="tg-0pky">1</td>
			  <td class="tg-0pky">2</td>
			  <td class="tg-0pky">3</td>
			</tr>
			<tr>
			  <td class="tg-0pky">V3</td>
			  <td class="tg-0pky">0</td>
			  <td class="tg-0pky">1</td>
			  <td class="tg-0pky">0</td>
			  <td class="tg-0pky">1</td>
			</tr>
			<tr>
			  <td class="tg-0pky" rowspan="3">Comilla</td>
			  <td class="tg-0pky">V1</td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			</tr>
			<tr>
			  <td class="tg-0pky">V2</td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			</tr>
			<tr>
			  <td class="tg-0pky">V3</td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			</tr>
			<tr>
			  <td class="tg-0pky" rowspan="3">Rajshahi</td>
			  <td class="tg-0pky">V1</td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			</tr>
			<tr>
			  <td class="tg-0pky">V2</td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			  <td class="tg-0pky"></td>
			</tr>
			<tr>
			  <td class="tg-0lax">V3</td>
			  <td class="tg-0lax"></td>
			  <td class="tg-0lax"></td>
			  <td class="tg-0lax"></td>
			  <td class="tg-0lax"></td>
			</tr>
		  </tbody>	 --}}

	{{-- <thead>@foreach($violence['place'] as $key => $place )
							<td class="tg-0pky">{{ $place }}</td>
						@endforeach
		@endforeach
		<th class="tg-0lax">Total</th>
	  </tr>
	</thead> --}}
	{{-- @php
	$district_id = -1;
	@endphp
	<tbody>
		@foreach($informations['district'] as $key=>$district )
			@foreach($district['violence'] as $violence )
				@if($key!=$district_id)
					@php
						$key=$district_id;
					@endphp
					<tr>
						<td style="width: 100px;padding:0px;margin:0px;" class="tg-0pky" rowspan="{{ $violence_count }}">{{ $district['name'] }}</td>
						<td class="tg-0pky">{{ $violence['name'] }}</td>
						@foreach($violence['place'] as $key => $place )
							<td class="tg-0pky">{{ $place }}</td>
						@endforeach
					</tr>
				@else
					<tr>
						<td class="tg-0pky">{{ $violence['name'] }}</td>
						@foreach($violence['place'] as $key => $place )
							<td class="tg-0pky">{{ $place }}</td>
						@endforeach
					</tr>
				@endif
			@endforeach
		@endforeach
	</tbody> --}}
	</table>
@endsection

