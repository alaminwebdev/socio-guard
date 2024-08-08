<style>
    .table thead,
    .nested-table {
        background: #0b253a !important;
    }

    .table thead tr th {
        color: #f8f9fa !important;
        border-bottom-width: 1px;
        font-size: 12px;
    }
</style>

<div class="mt-3 pt-3 border-top">
    <p style="color: #0b253a;">
        <b>Zone : {{ @$region }} |</b>&nbsp;
        <b>Division : {{ @$division->name ?? 'All' }} |</b>&nbsp;
        <b>District : {{ @$district->name ?? 'All' }} |</b>&nbsp;
        <b>Upazila : {{ @$upazila->name ?? 'All' }} |</b>&nbsp;
        <b>From Date : {{ @$date_from }}</b>&nbsp;
        <b>To Date : {{ @$date_to }}</b>
    </p>

    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th style="vertical-align: middle; width:10%;" class="text-center">Zone</th>
                <th style="vertical-align: middle; width:10%;" class="text-center">Division</th>
                <th style="vertical-align: middle; width:10%;" class="text-center">District</th>
                <th style="vertical-align: middle; width:10%;" class="text-center">Upazila</th>
                <th style="vertical-align: middle; width:10%;" class="text-center">Group</th>
                <th colspan="6" style="padding: 0; vertical-align: middle; width:50%; border-bottom:0;">
                    <table class="table nested-table" style="margin-bottom: 0;">
                        <tr>
                            <th colspan="6" style="border-left:0; border-right:0; border-top:0" class="text-center">
                                {{ @$title }}</th>
                        </tr>
                        <tr>
                            <th style="vertical-align: middle; width:15%; border-left:0; border-bottom:0; border-top:0" class="text-center">Ongoing</th>
                            <th style="vertical-align: middle; width:15%; border-left:0; border-bottom:0; border-top:0" class="text-center">Married</th>
                            <th style="vertical-align: middle; width:15%; border-left:0; border-bottom:0; border-top:0" class="text-center">Migrated</th>
                            <th style="vertical-align: middle; width:15%; border-left:0; border-bottom:0; border-top:0" class="text-center">Dropout</th>
                            <th style="vertical-align: middle; width:20%; border-left:0; border-bottom:0; border-top:0" class="text-center">Graduated</th>
                            <th style="vertical-align: middle; width:20%; border:0" class="text-center">Total</th>
                        </tr>
                    </table>
                </th>
            </tr>
        </thead>

        <tbody>
            @if (!empty($array_data))
                @foreach ($array_data['division'] as $div_key => $division_list)
                    @foreach ($division_list['district'] as $dis_key => $district_list)
                        @foreach ($district_list['upazila'] as $upa_key => $upazila_list)
                            @foreach ($upazila_list['group'] as $group_key => $group_list)
                                <tr>
                                    <td>{{ $group_list['zone'] }}</td>
                                    <td>{{ $division_list['name'] }}</td>
                                    <td>{{ $district_list['name'] }}</td>
                                    <td>{{ $upazila_list['name'] }}</td>
                                    <td>{{ $group_list['name'] }}</td>
                                    
                                    <td colspan="6" class="parent-td" style="padding: 0;vertical-align: middle;">
                                        <table style="margin-bottom: 0; width:100%;" class="inner-table">
                                            <tr style="">
                                                <td style="width:15%; border-left:0; border-top:0; border-bottom:0" class="text-right" data-toggle="tooltip" data-placement="bottom" title="Ongoing">
                                                    {{ @$group_list['ongoing'] }}
                                                </td>
                                                <td style="width:15%; border-left:0; border-top:0; border-bottom:0" class="text-right" data-toggle="tooltip" data-placement="bottom" title="Married">
                                                    {{ @$group_list['married'] }}
                                                </td>
                                                <td style="width:15%; border-left:0; border-top:0; border-bottom:0" class="text-right" data-toggle="tooltip" data-placement="bottom" title="Migrated">
                                                    {{ @$group_list['migrated'] }}
                                                </td>
                                                <td style="width:15%; border-left:0; border-top:0; border-bottom:0" class="text-right" data-toggle="tooltip" data-placement="bottom" title="Dropout">
                                                    {{ @$group_list['droupout'] }}
                                                </td>
                                                <td style="width:20%; border-left:0; border-top:0; border-bottom:0" class="text-right" data-toggle="tooltip" data-placement="bottom" title="Graduated">
                                                    {{ @$group_list['graduated'] }}
                                                </td>
                                                <td style="width:20%; border:0" class="text-right" data-toggle="tooltip" data-placement="bottom" title="Total">
                                                    {{ @$group_list['total'] }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                @endforeach
            @else
                <tr>
                    <td colspan="10" class="text-center">No Data Found !</td>
                </tr>
            @endif

            {{-- <tr>

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
            </tr> --}}

        </tbody>

    </table>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get all elements with class "parent-td"
        var parentTds = document.querySelectorAll(".parent-td");

        // Loop through each "parent-td" and set the height of the inner table
        parentTds.forEach(function(parentTd) {
            var innerTable = parentTd.querySelector(".inner-table");
            var parentTdHeight = parentTd.clientHeight;

            // Set the height of the inner table in pixels
            innerTable.style.height = parentTdHeight + "px";
        });
    });
</script>
