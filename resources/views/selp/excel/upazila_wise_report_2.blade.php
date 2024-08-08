<table>
    <tr>
        <td colspan="10">
            <strong>Report Name:{{ @$title }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="20">
            <p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District :
                {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$date_from }}
                |</b>&nbsp;<b>To Date : {{ @$date_to }}</b></p>
        </td>
    </tr>
</table>


<table class="table table-bordered">
    <thead>
        <tr>
            <th><strong>Division</strong></th>
            <th><strong>District</strong></th>
            <th><strong>Upazila</strong></th>
            <th><strong>General Girls (1)</strong></th>
            <th><strong>General Boys (2)</strong></th>
            <th><strong>PWD Girls (3)</strong></th>
            <th><strong>PWD Boys (4)</strong></th>
            <th><strong>Total (1+2)</strong></th>
        </tr>
    </thead>

    <tbody>
        @php
            
            $gGirls = 0;
            $gBoys = 0;
            $pGirls = 0;
            $pBoys = 0;
        @endphp
        @if (!empty($array_data))
            @foreach ($array_data['division'] as $div_key => $division_list)
                @foreach ($division_list['district'] as $dis_key => $district_list)
                    @foreach ($district_list['upazila'] as $upa_key => $upazila_list)
                        <tr>
                            @php
                                $gGirls += $upazila_list['g_girl'];
                                $gBoys += $upazila_list['g_boy'];
                                $pGirls += $upazila_list['p_girl'];
                                $pBoys += $upazila_list['p_boy'];
                            @endphp
                            <td>{{ $division_list['name'] }}</td>
                            <td>{{ $district_list['name'] }}</td>
                            <td>{{ $upazila_list['name'] }}</td>
                            
                            <td>
                                {{ $upazila_list['g_girl'] }}
                            </td>
                            <td>
                                {{ $upazila_list['g_boy'] }}
                            </td>
                            
                            <td>
                                {{ $upazila_list['p_girl'] }}
                            </td>
                            <td>
                                {{ $upazila_list['p_boy'] }}
                            </td>
                            <td>
                                {{ $upazila_list['total'] }}
                            
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endforeach
        @endif

        <tr>
            <td></td>
            <td></td>
            
            <td><strong>Total</strong></td>
                
                <td><strong>
                    {{ $gGirls }}
                     </strong>
                </td>
                <td ><strong>
                    {{ $gBoys }}
                     </strong>
                </td>
                
                <td ><strong>{{ $pGirls }}
                     </strong>
                </td>
                <td ><strong>{{ $pBoys }}
                     </strong>
                </td>
               
                <td align="center"><strong>
                    {{  $gGirls + $gBoys  }}
                </strong>
                </td>
        </tr>
    </tbody>

</table>
