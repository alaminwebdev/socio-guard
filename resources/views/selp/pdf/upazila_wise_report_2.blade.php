@extends('selp.layouts.test_report_header')
@section('content')
    <p><b>Zone : {{ @$region }} |</b>&nbsp;<b>Division : {{ @$division }} |</b>&nbsp;<b>District :
            {{ @$district }} |</b>&nbsp;<b>Upazila : {{ @$upazila }} |</b>&nbsp;<b>From Date : {{ @$date_from }}
            |</b>&nbsp;<b>To Date : {{ @$date_to }}</b></p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="tg-0pky" width="100" style="vertical-align: middle">Division</th>
                <th class="tg-0pky" width="100" style="vertical-align: middle">District</th>
                <th class="tg-0pky" width="120" style="vertical-align: middle">Upazila</th>
                <th colspan="4" class="tg-0pky" style="padding: 0">
                    <table class="table" style="margin-bottom: 0;">
                        <tr>
                            <th colspan="4" class="tg-0pky">General</th>
                        </tr>
                        <tr>
                            <th class="tg-0pky" style="max-width:25%; border-left:0">Women <br> 1 </th>
                            <th class="tg-0pky" style="width:25%">Men <br> 2</th>
                            <th class="tg-0pky" style="width:25%">Girls <br> 3</th>
                            <th class="tg-0pky" style="width:25%; border-right:0">Boys <br> 4</th>
                        </tr>
                    </table>
                </th>
                <th colspan="4" class="tg-0pky" style="padding: 0">
                    <table class="table" style="margin-bottom: 0;">
                        <tr>
                            <th colspan="4" class="tg-0pky">PWD</th>
                        </tr>
                        <tr>
                            <th class="tg-0pky" style="max-width:25%; border-left:0">Women <br> 5</th>
                            <th class="tg-0pky" style="width:25%;">Men <br> 6</th>
                            <th class="tg-0pky" style="width:25%;">Girls <br> 7</th>
                            <th class="tg-0pky" style="width:25%; border-right:0">Boys <br> 8</th>
                        </tr>
                    </table>

                </th>
                <th class="tg-0pky" style="vertical-align: middle">Othres <br> 9</th>
                @if (@$report_type14 == 14)
                    <th>Benefited</th>
                @endif
                <th class="tg-0pky" style="background-color: #e6e5e5; vertical-align: middle">Total <br> (1+2+3+4+9) </th>
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
                                <td colspan="4" class="tg-0pky" style="padding: 0">
                                    <table style="margin-bottom: 0; width:100%;">
                                        <tr style="border:0">
                                            <td class="tg-0pky" style="max-width:25%; border-left:0">
                                                {{ $upazila_list['g_women'] }}
                                                @isset($array_data['report_type'])
                                                    @if ($upazila_list['g_women_count'])
                                                        ({{ $upazila_list['g_women_count'] }})
                                                    @endif
                                                @endisset
                                            </td>
                                            <td class="tg-0pky" style="width:25%;">{{ $upazila_list['g_men'] }}
                                                @isset($array_data['report_type'])
                                                    @if ($upazila_list['g_men_count'])
                                                        ({{ $upazila_list['g_men_count'] }})
                                                    @endif
                                                @endisset
                                            </td>
                                            <td class="tg-0pky" style="width:25%;">{{ $upazila_list['g_girl'] }}
                                                @isset($array_data['report_type'])
                                                    @if ($upazila_list['g_girl_count'])
                                                        ({{ $upazila_list['g_girl_count'] }})
                                                    @endif
                                                @endisset
                                            </td>
                                            <td class="tg-0pky" style="width:25%; border-right:0">
                                                {{ $upazila_list['g_boy'] }}
                                                @isset($array_data['report_type'])
                                                    @if ($upazila_list['g_boy_count'])
                                                        ({{ $upazila_list['g_boy_count'] }})
                                                    @endif
                                                @endisset
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td colspan="4" class="tg-0pky" style="padding: 0">
                                    <table style="margin-bottom: 0; width:100%;">
                                        <tr style="border:0">
                                            <td class="tg-0pky" style="max-width:25%; border-left:0">
                                                {{ $upazila_list['p_women'] }}
                                                @isset($array_data['report_type'])
                                                    @if ($upazila_list['p_women_count'])
                                                        ({{ $upazila_list['p_women_count'] }})
                                                    @endif
                                                @endisset
                                            </td>
                                            <td class="tg-0pky" style="width:25%;">{{ $upazila_list['p_men'] }}
                                                @isset($array_data['report_type'])
                                                    @if ($upazila_list['p_men_count'])
                                                        ({{ $upazila_list['p_men_count'] }})
                                                    @endif
                                                @endisset
                                            </td>
                                            <td class="tg-0pky" style="width:25%;">{{ $upazila_list['p_girl'] }}
                                                @isset($array_data['report_type'])
                                                    @if ($upazila_list['p_girl_count'])
                                                        ({{ $upazila_list['p_girl_count'] }})
                                                    @endif
                                                @endisset
                                            </td>
                                            <td class="tg-0pky" style="width:25%; border-right:0">
                                                {{ $upazila_list['p_boy'] }}
                                                @isset($array_data['report_type'])
                                                    @if ($upazila_list['p_boy_count'])
                                                        ({{ $upazila_list['p_boy_count'] }})
                                                    @endif
                                                @endisset
                                            </td>
                                        </tr>
                                    </table>
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
                                <td style="background-color: #e6e5e5">
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

                <td style="background-color: #ffe9e9; font-size: 16px;" colspan="3">Total</td>
                <td style="background-color: #ffe9e9">
                    {{ $gWomens }}
                    @isset($array_data['report_type'])
                        @if ($gWomens_count)
                            <br>
                            ({{ $gWomens_count }})
                        @endif
                    @endisset
                </td>
                <td style="background-color: #ffe9e9">{{ $gMens }}
                    @isset($array_data['report_type'])
                        @if ($gMens_count)
                            <br>
                            ( {{ $gMens_count }})
                        @endif
                    @endisset
                </td>
                <td style="background-color: #ffe9e9">{{ $gGirls }}
                    @isset($array_data['report_type'])
                        @if ($gGirls_count)
                            <br>
                            ({{ $gGirls_count }})
                        @endif
                    @endisset
                </td>
                <td style="background-color: #ffe9e9">{{ $gBoys }}
                    @isset($array_data['report_type'])
                        @if ($gBoys_count)
                            <br>
                            ({{ $gBoys_count }})
                        @endif
                    @endisset
                </td>
                <td style="background-color: #ffe9e9">{{ $pWomens }}
                    @isset($array_data['report_type'])
                        @if ($pWomens_count)
                            <br>
                            ({{ $pWomens_count }})
                        @endif
                    @endisset

                </td>
                <td style="background-color: #ffe9e9">{{ $pMens }}
                    @isset($array_data['report_type'])
                        @if ($pMens_count)
                            <br>
                            ({{ $pMens_count }})
                        @endif
                    @endisset
                </td>
                <td style="background-color: #ffe9e9">{{ $pGirls }}
                    @isset($array_data['report_type'])
                        @if ($pGirls_count)
                            <br>
                            ({{ $pGirls_count }})
                        @endif
                    @endisset
                </td>
                <td style="background-color: #ffe9e9">{{ $pBoys }}
                    @isset($array_data['report_type'])
                        @if ($pBoys_count)
                            <br>
                            ({{ $pBoys_count }})
                        @endif
                    @endisset
                </td>
                <td style="background-color: #ffe9e9">{{ $others }}
                    @isset($array_data['report_type'])
                        @if ($others_count)
                            <br>
                            ({{ $others_count }})
                        @endif
                    @endisset
                </td>
                @if (@$report_type14 == 14)
                    <td style="background-color: #ffe9e9">{{ $benefited_total }}</td>
                @endif
                <td style="background-color: #000000; color:#fff;font-size: 14px; font-weight:bold">
                    {{ $gWomens + $gMens + $gGirls + $gBoys + $others }}
                    @isset($array_data['report_type'])
                        <br>
                        ({{ $gWomens_count + $gMens_count + $gGirls_count + $gBoys_count + $others_count }})
                    @endisset
                </td>
                @if (@$report_type15 == 15)
                    <td style="background-color: #ffe9e9">
                        {{ $amount_money }}</td>
                @endif
            </tr>

        </tbody>

    </table>
@endsection
