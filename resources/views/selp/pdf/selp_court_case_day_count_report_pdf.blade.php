@extends('selp.layouts.test_report_header')
@section('content')
<br>
<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
	<table class="table table-bordered">
		<thead>
		  	<tr>
				<th class="tg-0pky">SL.</th>
				<th class="tg-c3ow">Complain Id</th>
				<th class="tg-c3ow">Case Type</th>
				<th class="tg-c3ow">Start Date</th>
				<th class="tg-c3ow">Close Date</th>
				<th class="tg-c3ow">Total Day</th>
		  	</tr>
		</thead>
		<tbody>
			@foreach($indicent_data as $key => $information)
				@foreach ($information as $data)
					<tr>
						<td class="tg-0pky">{{ ++$loop->parent->index }}</td>
						<td class="tg-0pky">{{ $key }}</td>
						<td class="tg-0pky">{{ $data['type'] }}</td>
						<td class="tg-0pky">{{$data['start_date']->format('d-m-Y')}}</td>	
						<td class="tg-0pky">{{$data['close_date']->format('d-m-Y')}}</td>	
						<td class="tg-0pky">{{$data['day']}}</td>	
					</tr>
				@endforeach
				
			@endforeach
		</tbody>
	</table>
@endsection

