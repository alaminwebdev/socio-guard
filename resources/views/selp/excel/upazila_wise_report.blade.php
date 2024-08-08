<table>
    <tr>
        <td colspan="10">
            <strong>Report Name:{{ @$title }}</strong>
        </td>
    </tr>
    <tr>
        <td colspan="20">
            <p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District :
                    {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date :
                    {{ @$date_from }}
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
            <th><strong>General Women (1)</strong></th>
            <th><strong>General Men (2)</strong></th>
            <th><strong>General Girls (3)</strong></th>
            <th><strong>General Boys (4)</strong></th>
            <th><strong>PWD Women (5)</strong></th>
            <th><strong>PWD Men (6)</strong></th>
            <th><strong>PWD Girls (7)</strong></th>
            <th><strong>PWD Boys (8)</strong></th>
            <th><strong>Othres (9)</strong></th>
            @if (@$report_type14 == 14)
                <th><strong>Benefited</strong></th>
            @endif
            <th><strong>Total (1+2+3+4+9)</strong></th>
            @if (@$report_type15 == 15)
                <th>Total Taka</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @php
            $gWomens = 0;
            $gMens = 0;
            $gGirls = 0;
            $gBoys = 0;
            $pWomens = 0;
            $pMens = 0;
            $pGirls = 0;
            $pBoys = 0;
            $others = 0;
            $amount_money = 0.0;
            if (isset($array_data['report_type'])) {
                $gWomens_count = 0;
                $gMens_count = 0;
                $gGirls_count = 0;
                $gBoys_count = 0;
                $pWomens_count = 0;
                $pMens_count = 0;
                $pGirls_count = 0;
                $pBoys_count = 0;
                $others_count = 0;
            }
            if (isset($report_type14)) {
                $benefited_total = 0;
            }
        @endphp
        @if (!empty($array_data))
            @foreach ($array_data['division'] as $div_key => $division_list)
                @foreach ($division_list['district'] as $dis_key => $district_list)
                    @foreach ($district_list['upazila'] as $upa_key => $upazila_list)
                        <tr>
                            @php
                                $gWomens += $upazila_list['g_women'];
                                $gMens += $upazila_list['g_men'];
                                $gGirls += $upazila_list['g_girl'];
                                $gBoys += $upazila_list['g_boy'];
                                $pWomens += $upazila_list['p_women'];
                                $pMens += $upazila_list['p_men'];
                                $pGirls += $upazila_list['p_girl'];
                                $pBoys += $upazila_list['p_boy'];
                                $others += $upazila_list['other'];
                                $amount_money += $upazila_list['receive_money'] ?? 0;
                                if (isset($array_data['report_type'])) {
                                    $gWomens_count += $upazila_list['g_women_count'];
                                    $gMens_count += $upazila_list['g_men_count'];
                                    $gGirls_count += $upazila_list['g_girl_count'];
                                    $gBoys_count += $upazila_list['g_boy_count'];
                                    $pWomens_count += $upazila_list['p_women_count'];
                                    $pMens_count += $upazila_list['p_men_count'];
                                    $pGirls_count += $upazila_list['p_girl_count'];
                                    $pBoys_count += $upazila_list['p_boy_count'];
                                    $others_count += $upazila_list['other_count'];
                                }
                                if (isset($report_type14)) {
                                    $benefited_total += $upazila_list['benefited'];
                                }
                            @endphp
                            <td>{{ $division_list['name'] }}</td>
                            <td>{{ $district_list['name'] }}</td>
                            <td>{{ $upazila_list['name'] }}</td>
                            <td>
                                {{ $upazila_list['g_women'] }}
                                @isset($array_data['report_type'])
                                    @if ($upazila_list['g_women_count'])
                                        ({{ $upazila_list['g_women_count'] }})
                                    @endif
                                @endisset
                            </td>
                            <td>
                                {{ $upazila_list['g_men'] }}
                                @isset($array_data['report_type'])
                                    @if ($upazila_list['g_men_count'])
                                        ({{ $upazila_list['g_men_count'] }})
                                    @endif
                                @endisset
                            </td>
                            <td>
                                {{ $upazila_list['g_girl'] }}
                                @isset($array_data['report_type'])
                                    @if ($upazila_list['g_girl_count'])
                                        ({{ $upazila_list['g_girl_count'] }})
                                    @endif
                                @endisset
                            </td>
                            <td>
                                {{ $upazila_list['g_boy'] }}
                                @isset($array_data['report_type'])
                                    @if ($upazila_list['g_boy_count'])
                                        ({{ $upazila_list['g_boy_count'] }})
                                    @endif
                                @endisset
                            </td>
                            <td>
                                {{ $upazila_list['p_women'] }}
                                @isset($array_data['report_type'])
                                    @if ($upazila_list['p_women_count'])
                                        ({{ $upazila_list['p_women_count'] }})
                                    @endif
                                @endisset
                            </td>
                            <td>
                                {{ $upazila_list['p_men'] }}
                                @isset($array_data['report_type'])
                                    @if ($upazila_list['p_men_count'])
                                        ({{ $upazila_list['p_men_count'] }})
                                    @endif
                                @endisset
                            </td>
                            <td>
                                {{ $upazila_list['p_girl'] }}
                                @isset($array_data['report_type'])
                                    @if ($upazila_list['p_girl_count'])
                                        ({{ $upazila_list['p_girl_count'] }})
                                    @endif
                                @endisset
                            </td>
                            <td>
                                {{ $upazila_list['p_boy'] }}
                                @isset($array_data['report_type'])
                                    @if ($upazila_list['p_boy_count'])
                                        ({{ $upazila_list['p_boy_count'] }})
                                    @endif
                                @endisset
                            </td>
                            <td>
                                {{ $upazila_list['other'] }}
                                @isset($array_data['report_type'])
                                    @if ($upazila_list['other_count'])
                                        ({{ $upazila_list['other_count'] }})
                                    @endif
                                @endisset
                            </td>
                            @if (@$report_type14 == 14)
                                <td>
                                    {{ $upazila_list['benefited'] ?? 0 }}
                                </td>
                            @endif
                            <td>
                                {{ $upazila_list['total'] }}
                                @isset($array_data['report_type'])
                                    @if ($upazila_list['total_count'])
                                        ({{ $upazila_list['total_count'] }})
                                    @endif
                                @endisset

                            </td>
                            @if (@$report_type15 == 15)
                                <td>
                                    {{ $upazila_list['receive_money'] ?? 0.0 }}
                                </td>
                            @endif
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
                    {{ $gWomens }}
                    @isset($array_data['report_type'])
                        @if ($gWomens_count)
                            <br>
                            ({{ $gWomens_count }})
                        @endif
                    @endisset
                </strong>
            </td>
            <td><strong>
                    {{ $gMens }}
                    @isset($array_data['report_type'])

                        @if ($gMens_count)
                            <br>
                            ( {{ $gMens_count }})
                        @endif
                    @endisset
                </strong>
            </td>
            <td><strong>
                    {{ $gGirls }}
                    @isset($array_data['report_type'])

                        @if ($gGirls_count)
                            <br>
                            ({{ $gGirls_count }})
                        @endif
                    @endisset
                </strong>
            </td>
            <td><strong>
                    {{ $gBoys }}
                    @isset($array_data['report_type'])
                        @if ($gBoys_count)
                            <br>
                            ({{ $gBoys_count }})
                        @endif
                    @endisset
                </strong>
            </td>
            <td><strong>
                    {{ $pWomens }}
                    @isset($array_data['report_type'])
                        @if ($pWomens_count)
                            <br>
                            ({{ $pWomens_count }})
                        @endif
                    @endisset
                </strong>

            </td>
            <td><strong>
                    {{ $pMens }}
                    @isset($array_data['report_type'])

                        @if ($pMens_count)
                            <br>
                            ({{ $pMens_count }})
                        @endif
                    @endisset
                </strong>
            </td>
            <td><strong>{{ $pGirls }}
                    @isset($array_data['report_type'])
                        @if ($pGirls_count)
                            <br>
                            ({{ $pGirls_count }})
                        @endif
                    @endisset
                </strong>
            </td>
            <td><strong>{{ $pBoys }}
                    @isset($array_data['report_type'])
                        @if ($pBoys_count)
                            <br>
                            ({{ $pBoys_count }})
                        @endif
                    @endisset
                </strong>
            </td>
            <td><strong>{{ $others }}
                    @isset($array_data['report_type'])
                        @if ($others_count)
                            <br>
                            ({{ $others_count }})
                        @endif

                    @endisset
                </strong>
            </td>
            @if (@$report_type14 == 14)
                <td style="background-color: #ffe9e9">{{ $benefited_total }}</td>
            @endif
            <td align="center"><strong>
                    {{ $gWomens + $gMens + $gGirls + $gBoys + $others }}
                    @isset($array_data['report_type'])
                        <br>
                        ({{ $gWomens_count + $gMens_count + $gGirls_count + $gBoys_count + $others_count }})
                    @endisset
                </strong>
            </td>
            @if (@$report_type15 == 15)
                <td> {{ $amount_money }}</td>
            @endif
        </tr>
    </tbody>

</table>
