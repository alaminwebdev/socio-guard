@extends('selp.layouts.selp_activity_header')
@section('content')
<style type="text/css">
  .tg-0pky{
    font-weight: bold;
  }
  p {
    font-weight: bold;
  }    
</style>
<br>
<p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th class="tg-0pky" colspan="11"></th>
          <th class="tg-0pky" colspan="6">Participants</th>
          <th class="tg-0pky" colspan="6">Persons With Disabilities (PWD)</th>
        </tr>
        <tr>
          <td class="tg-0pky">Data Entry No.</td>
          <td class="tg-0pky">Reporting Date</td>
          <td class="tg-0pky">Zone</td>
          <td class="tg-0pky">Division</td>
          <td class="tg-0pky">District</td>
          <td class="tg-0pky">Upazila</td>
          <td class="tg-0pky">Category</td>
          <td class="tg-0pky">Event Type</td>
          <td class="tg-0pky">No. of Events</td>
          <td class="tg-0pky">Starting Date</td>
          <td class="tg-0pky">Ending Date</td>
          <td class="tg-0pky">Boys</td>
          <td class="tg-0pky">Girls</td>
          <td class="tg-0pky">Men</td>
          <td class="tg-0pky">Women</td>
          <td class="tg-0pky" style="width: 80px;">Other Gender</td>
          <td class="tg-0pky">Total</td>
          <td class="tg-0pky">Boys</td>
          <td class="tg-0pky">Girls</td>
          <td class="tg-0pky">Men</td>
          <td class="tg-0pky">Women</td>
          <td class="tg-0pky" style="width: 80px;">Other Gender</td>
          <td class="tg-0pky">Total</td>
        </tr>
      </thead>
      <tbody>
        @foreach ($information as $key_data_cat => $data_cat)
        @php
        $filterArray = array_filter($data_cat, function($item){ return is_array($item);});
          $first_td_rowspan = array_sum(array_map("count", $filterArray));
          
          $first_td_rowspan_start = 0;
        @endphp
              @foreach ($filterArray as $key_data => $data)
              
              @php
              $second_td_rowspan = count($data);
              $second_td_rowspan_start = 0;
              @endphp
                @foreach ($data as $item)
                <tr>
                  @if($first_td_rowspan_start == 0)
                  <td class="tg-0pky" rowspan="{{$first_td_rowspan}}">{{ $key_data_cat }}</td>
                  <td class="tg-0pky" rowspan="{{$first_td_rowspan}}">{{ @$data_cat['reporting_date'] != null ? date("d-m-Y", strtotime(@$data_cat['reporting_date'])) : '' }}</td>
                  <td class="tg-0pky" rowspan="{{$first_td_rowspan}}">{{ @$data_cat['zone'] }}</td>
                  <td class="tg-0pky" rowspan="{{$first_td_rowspan}}">{{ @$data_cat['division'] }}</td>
                  <td class="tg-0pky" rowspan="{{$first_td_rowspan}}">{{ @$data_cat['district'] }}</td>
                  <td class="tg-0pky" rowspan="{{$first_td_rowspan}}">{{ @$data_cat['upazila'] }}</td>
                  @endif             
                  @php 
                  $first_td_rowspan_start=+1;
                  @endphp
                  @if($second_td_rowspan_start == 0)
                  {{-- <td class="tg-0pky" rowspan="{{$second_td_rowspan}}">{{ $item['category_name'] }}</td> --}}
                  {{-- @dd($second_td_rowspan); --}}
                  <td class="tg-0pky" rowspan="{{$second_td_rowspan}}">{{ @$item['category_name'] }}</td>
                  @endif
                  @php 
                  $second_td_rowspan_start=+1;
                  @endphp
                  
                  
                  <td class="tg-0pky">{{ @$item['event'] }}</td>
                  <td class="tg-0pky">{{ @$item['no_of_event'] }}</td>
                  <td class="tg-0pky">{{ @$item['starting_date'] != null ? date("d-m-Y", strtotime(@$item['starting_date'])) : '' }}</td>
                  <td class="tg-0pky">{{ @$item['ending_date'] != null ? date("d-m-Y", strtotime(@$item['ending_date'])) : '' }}</td>
                  <td class="tg-0pky">{{ @$item['participant_boys'] }}</td>
                  <td class="tg-0pky">{{ @$item['participant_girls'] }}</td>
                  <td class="tg-0pky">{{ @$item['participant_men'] }}</td>
                  <td class="tg-0pky">{{ @$item['participant_women'] }}</td>
                  <td class="tg-0pky">{{ @$item['participant_other_gender'] }}</td>
                  <td class="tg-0pky">{{ @$item['participant_total'] }}</td>
                  <td class="tg-0pky">{{ @$item['participant_pwd_boys'] }}</td>
                  <td class="tg-0pky">{{ @$item['participant_pwd_girls'] }}</td>
                  <td class="tg-0pky">{{ @$item['participant_pwd_men'] }}</td>
                  <td class="tg-0pky">{{ @$item['participant_pwd_women'] }}</td>
                  <td class="tg-0pky">{{ @$item['participant_pwd_other_gender'] }}</td>
                  <td class="tg-0pky">{{ @$item['participant_pwd_total'] }}</td>
                </tr>
                @endforeach
              @endforeach
        @endforeach
      </tbody>
    </table>
@endsection