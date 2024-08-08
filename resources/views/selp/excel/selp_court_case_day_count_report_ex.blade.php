
<table>
	<tr>
        <td colspan="10">
            <strong>Report Name:{{ @$title }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="20">
            <p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District :
                {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }}
                |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
        </td>
    </tr>
</table>
<table>
	<thead>
		<tr>
			<th>SL.</th>
			<th>Complain Id</th>
			<th>Case type</th>
			<th >Start Date</th>
			<th>Close Date</th>
			<th >Total Day</th>
		</tr>
	</thead>
	<tbody>
		{{-- @foreach($indicent_data as $key => $information)
		
			<tr>
				<td>{{ $loop->iteration }}</td>
				<td>{{ $key }}</td>
				<td>{{$information['type']}}</td>	
				<td>{{$information['start_date']->format('d-m-Y')}}</td>	
				<td>{{$information['close_date']->format('d-m-Y')}}</td>	
				<td>{{$information['day']}}</td>	
			</tr>
		@endforeach --}}

		@foreach($indicent_data as $key => $information)
				@foreach ($information as $data)
					<tr>
						<td>{{ ++$loop->parent->index }}</td>
						<td>{{ $key }}</td>
						<td>{{ $data['type'] }}</td>
						<td>{{$data['start_date']->format('d-m-Y')}}</td>	
						<td>{{$data['close_date']->format('d-m-Y')}}</td>	
						<td>{{$data['day']}}</td>	
					</tr>
				@endforeach
				
			@endforeach
	</tbody>
</table>


