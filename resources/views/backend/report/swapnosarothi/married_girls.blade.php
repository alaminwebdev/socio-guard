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
                <th style="vertical-align: middle; width:15%;" class="text-center">Division</th>
                <th style="vertical-align: middle; width:15%;" class="text-center">District</th>
                <th style="vertical-align: middle; width:10%;" class="text-center">Upazila</th>
                <th style="vertical-align: middle; width:15%;" class="text-center">Group</th>
                <th colspan="3" style="padding: 0; vertical-align: middle; width:35%; border-bottom:0;">
                    <table class="table nested-table" style="margin-bottom: 0;">
                        <tr>
                            <th colspan="3" style="border-left:0; border-right:0; border-top:0" class="text-center">
                                {{ @$title }}</th>
                        </tr>
                        <tr>
                            <th style="vertical-align: middle; width:33%; border-left:0; border-bottom:0; border-top:0" class="text-center">Below 18</th>
                            <th style="vertical-align: middle; width:33%; border-left:0; border-bottom:0; border-top:0" class="text-center">After 18</th>
                            <th style="vertical-align: middle; width:34%; border:0" class="text-center">Total</th>
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
                                    <td colspan="3" class="parent-td" style="padding: 0;vertical-align: middle;">
                                        <table style="margin-bottom: 0; width:100%;" class="inner-table">
                                            <tr style="">
                                                <td style="width:33%; border-left:0; border-top:0; border-bottom:0" class="text-right" data-toggle="tooltip" data-placement="bottom" title="Below 18">
                                                    {{ @$group_list['below_18'] }}
                                                </td>
                                                <td style="width:33%; border-left:0; border-top:0; border-bottom:0" class="text-right" data-toggle="tooltip" data-placement="bottom" title="After 18">
                                                    {{ @$group_list['after_18'] }}
                                                </td>
                                                <td style="width:36%; border:0" class="text-right" data-toggle="tooltip" data-placement="bottom" title="Total">
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
