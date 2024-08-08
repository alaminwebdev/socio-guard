@php
    // foreach ($locationAndCases as $key => $value){
    //     foreach ($value['civilcase'] as $key=>$civilcase){
    //         echo "<pre>";
    //         print_r($value);
    //     }
    // }
   //dd();                 
                    
@endphp

<style type="text/css">
    .tg  {border-collapse:collapse;border-spacing:0;}
    .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
      overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
      font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
    .tg .tg-0lax{text-align:left;vertical-align:top}
    </style>



    {{-- Dynamic table --}}
    <table class="tg">
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
                                <td class="tg-0lax">{{$civilcase['case_title']}}</td>
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
                                <td class="tg-0lax">{{$civilcase['case_title']}}</td>
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


    <table class="tg">
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
                                <td class="tg-0lax">{{$policecase['case_title']}}</td>
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
                                <td class="tg-0lax">{{$policecase['case_title']}}</td>
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
    <table class="tg">
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
                                <td class="tg-0lax">{{$pititioncase['case_title']}}</td>
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
                                <td class="tg-0lax">{{$pititioncase['case_title']}}</td>
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