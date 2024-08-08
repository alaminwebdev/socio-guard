@extends('selp.layouts.selp_mis_report_header')
@section('content')
<style type="text/css">
	
	</style>
	<br>
<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
	<table class="table table-bordered">
	<thead>
	  <tr>
		<th class="tg-0pky" style="width: 100px;padding:0px;margin:0px;">Area</th>
		<th class="tg-0lax">0-15</th>
		<th class="tg-0lax">16-17</th>
		<th class="tg-0lax">18-above</th>
		<th class="tg-0lax">Total</th>
	  </tr>
	</thead>
	<tbody>
		@foreach($informations['district'] as $data )
			<tr>
				<td class="tg-0lax">{{ $data['name'] }}</td>
				<td class="tg-0lax">{{ $data['age']['0-15'] }}</td>
				<td class="tg-0lax">{{ $data['age']['16-17'] }}</td>
				<td class="tg-0lax">{{ $data['age']['18-above'] }}</td>
				<td class="tg-0lax">{{ $data['age']['0-15']+$data['age']['16-17']+$data['age']['18-above'] }}</td>
			</tr>
		@endforeach
	  </tbody>
	</table>
@endsection

