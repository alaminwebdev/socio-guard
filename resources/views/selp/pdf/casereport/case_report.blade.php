@extends('selp.layouts.selp_refferel_report_header')
@section('content')

<style>
    .tg-0lax{
        text-align: left;
    }
</style>
<div style="padding-top: 30px;">
    <p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District : {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$from_date }} |</b>&nbsp;<b>To Date : {{ @$to_date }}</b></p>
    {{-- Dynamic table --}}
    <table class="table table-bordered" style="padding-top:70px;width:100%">
        <thead>
            <tr>
                <td class="tg-0lax">{{$label_name}}</td>
                <td class="tg-0lax">civilcase</td>
                @for ($i = 0; $i < count($allJudjement); $i++)
                    <td class="tg-0lax">{{$allJudjement[$i]->title}}</td>
                @endfor
                
            </tr>
        </thead>
        <tbody>
            @foreach ($locationAndCases as $key => $value)
                    
                    @php
                        $dis_counter=0;
                        $disup=$key;
                    @endphp 
                    @foreach ($value['civilcase'] as $key=>$civilcase)
                        @php
                            $caseType=$key;
                        @endphp
                        @if ($dis_counter==0)
                            <tr>
                                <td class="tg-0lax" rowspan="{{count($allCivilCase)}}">{{$value['label']}}</td>
                                <td style="width:300px" class="tg-0lax">{{$civilcase['case_title']}}</td>
                                @foreach ($civilcase['status'] as $key=>$case_status)
                                    
                                    @php
                                        $statusId=$key;
                                        $total_count=caseJudjementStatusTotalCount($disup,$caseType,$statusId,1,$reportType);
                                    @endphp
                                    <td class="tg-0lax">{{$total_count}}</td>
                                @endforeach
                                
                            </tr> 
                        @else
                            <tr>
                                <td style="width:300px" class="tg-0lax">{{$civilcase['case_title']}}</td>
                                @foreach ($civilcase['status'] as $key=>$case_status)
                                    @php
                                        $statusId=$key;
                                        $total_count=caseJudjementStatusTotalCount($disup,$caseType,$statusId,1,$reportType);
                                    @endphp
                                    <td class="tg-0lax">{{$total_count}}</td>
                                @endforeach
                            </tr>
                        @endif
                        @php
                            $dis_counter++;
                        @endphp 
                    @endforeach
               
            @endforeach


           
        </tbody>
    </table>


    <table class="table table-bordered" style="padding-top:70px;width:100%">
        <thead>
            <tr>
                <td class="tg-0lax">{{$label_name}}</td>
                <td class="tg-0lax">Police case</td>
                @for ($i = 0; $i < count($allJudjement); $i++)
                    <td class="tg-0lax">{{$allJudjement[$i]->title}}</td>
                @endfor
                
            </tr>
        </thead>
        <tbody>
            @foreach ($locationAndCases as $key => $value)
                    
                    @php
                        $dis_counter=0;
                        $disup=$key;
                    @endphp 
                    @foreach ($value['policecase'] as $key=>$policecase)
                        @php
                            $caseType=$key;
                        @endphp
                        @if ($dis_counter==0)
                            <tr>
                                <td class="tg-0lax" rowspan="{{count($allPoliceCase)}}">{{$value['label']}}</td>
                                <td style="width:300px" class="tg-0lax">{{$policecase['case_title']}}</td>
                                @foreach ($policecase['status'] as $key=>$case_status)
                                    
                                    @php
                                        $statusId=$key;
                                        $total_count=caseJudjementStatusTotalCount($disup,$caseType,$statusId,2,$reportType);
                                    @endphp
                                    <td class="tg-0lax">{{$total_count}}</td>
                                @endforeach
                                
                            </tr> 
                        @else
                            <tr>
                                <td style="width:300px" class="tg-0lax">{{$policecase['case_title']}}</td>
                                @foreach ($policecase['status'] as $key=>$case_status)
                                    @php
                                        $statusId=$key;
                                        $total_count=caseJudjementStatusTotalCount($disup,$caseType,$statusId,2,$reportType);
                                    @endphp
                                    <td class="tg-0lax">{{$total_count}}</td>
                                @endforeach
                            </tr>
                        @endif
                        @php
                            $dis_counter++;
                        @endphp 
                    @endforeach
               
            @endforeach


           
        </tbody>
    </table>



    {{-- Dynamic table --}}
    <table class="table table-bordered" style="padding-top:70px;width:100%">
        <thead>
            <tr>
                <td class="tg-0lax">{{$label_name}}</td>
                <td class="tg-0lax">Pitition case</td>
                @for ($i = 0; $i < count($allJudjement); $i++)
                    <td class="tg-0lax">{{$allJudjement[$i]->title}}</td>
                @endfor
                
            </tr>
        </thead>
        <tbody>
            @foreach ($locationAndCases as $key => $value)
                    
                    @php
                        $dis_counter=0;
                        $disup=$key;
                    @endphp 
                    @foreach ($value['pititioncase'] as $key=>$pititioncase)
                        @php
                            $caseType=$key;
                        @endphp
                        @if ($dis_counter==0)
                            <tr>
                                <td class="tg-0lax" rowspan="{{count($allPititionCase)}}">{{$value['label']}}</td>
                                <td style="width:300px" class="tg-0lax">{{$pititioncase['case_title']}}</td>
                                @foreach ($pititioncase['status'] as $key=>$case_status)
                                    
                                    @php
                                        $statusId=$key;
                                        $total_count=caseJudjementStatusTotalCount($disup,$caseType,$statusId,1,$reportType);
                                    @endphp
                                    <td class="tg-0lax">{{$total_count}}</td>
                                @endforeach
                                
                            </tr> 
                        @else
                            <tr>
                                <td style="width:300px" class="tg-0lax">{{$pititioncase['case_title']}}</td>
                                @foreach ($pititioncase['status'] as $key=>$case_status)
                                    @php
                                        $statusId=$key;
                                        $total_count=caseJudjementStatusTotalCount($disup,$caseType,$statusId,3,$reportType);
                                    @endphp
                                    <td class="tg-0lax">{{$total_count}}</td>
                                @endforeach
                            </tr>
                        @endif
                        @php
                            $dis_counter++;
                        @endphp 
                    @endforeach
               
            @endforeach


           
        </tbody>
    </table>    

</div>    

@endsection