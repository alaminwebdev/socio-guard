@extends('selp.layouts.selp_refferel_report_header')
@section('content')
<div style="padding-top: 30px;">
	<br>
	<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
	<table class="table table-bordered">
		<thead>
			<tr>
              <th class="tg-0pky">{{@$label_name}}</th>
			  <th class="tg-0pky"> No. Child Marriage Reported by Pollishomaj </th>
			  
			</tr>
		  </thead>
		  <tbody>

            @for ($i = 0; $i < count($child_marriage_prevention_number); $i++)
				<tr>
					<td class="tg-0pky">{{@$child_marriage_prevention_number[$i]->name}}</td>
					<td class="tg-0pky">{{@$child_marriage_prevention_number[$i]->child_marriage_prevention=='' ? '-' : @$child_marriage_prevention_number[$i]->child_marriage_prevention }}</td>
				</tr>
			  
			@endfor
			
		  </tbody>
	</table>
</div>
@endsection

