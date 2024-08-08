<!DOCTYPE html>
<html lang="en">
<title> ID - {{ formatIncidentId(@$childmarriageinformation->id) }}</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style type="text/css">
    table {
        border-collapse: collapse;
    }

    h2 h3 {
        margin: 0;
        padding: 0;
    }

    .table {
        width: 100%;
        margin-bottom: 1rem;
        background-color: transparent;
    }

    .table th,
    .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }

    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody+tbody {
        border-top: 2px solid #dee2e6;
    }

    .table .table {
        background-color: #fff;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    .table-bordered thead th,
    .table-bordered thead td {
        border-bottom-width: 2px;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    table tr td {
        padding: 5px;
    }

    .table-bordered thead th,
    .table-bordered td,
    .table-bordered th {
        border: 1px solid black !important;
    }

    .table-bordered thead th {
        background-color: #cacaca;
    }
</style>

<body>

    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="text-center">
                    <img style="width: 100px;height: 40px;" src="{{ asset('backend/images/logo-original.png') }}">
                </div>
                <div class="text-center">
                    <h4><strong>Social Empowerment and Legal Protection (SELP) </strong></h4>
                    <h5><strong>75 Mohakhali, Dhaka-1212</strong></h5>
                    <h5 style="font-weight: bold">Child Marriage Information( ID :
                        {{ formatIncidentId($childmarriageinformation->id) }} | Creation Date :
                        {{ $childmarriageinformation->created_at != null ? date('d-m-Y', strtotime($childmarriageinformation->created_at)) : '' }}
                    </h5>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-12">
                <table border="1" width="100%">
                    <tbody>
                        {{-- Data Insert By --}}
                        <tr>
                            <td width="4%" class="text-center" rowspan="4">
                                <p style="font-weight: bold;">1</p>
                            </td>
                            <td colspan="2">
                                <p style="font-weight: bold;">Data Insert By</p>
                            </td>
                            <td>
                                <p>Reporting Date :
                                    {{ $childmarriageinformation->reporting_date != null ? date('d-m-Y', strtotime($childmarriageinformation->reporting_date)) : '' }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Name: {{ @$childmarriageinformation->employee_name }}</p>
                            </td>
                            <td>
                                <p>Mobile No: {{ @$childmarriageinformation->employee_mobile_number }}</p>
                            </td>
                            <td>
                                <p>Designation: {{ @$childmarriageinformation->employee_designation }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>PIN : {{ @$childmarriageinformation->employee_pin }}</p>
                            </td>
                            <td>
                                <p>Zone : {{ @$childmarriageinformation->employee_zone->region_name }}</p>
                            </td>
                            <td>
                                <p>Division : {{ @$childmarriageinformation->employee_division->name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>District : {{ @$childmarriageinformation->employee_district->name }}</p>
                            </td>
                            <td colspan="2">
                                <p>Upazila : {{ @$childmarriageinformation->employee_upazila->name }}</p>
                            </td>
                        </tr>


                        {{-- Survivor Information --}}
                        <tr>
                            <td width="4%" class="text-center" rowspan="6">
                                <p style="font-weight: bold;">2</p>
                            </td>
                            <td colspan="3">
                                <p style="font-weight: bold;">Child Information</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Child's Name: {{ @$childmarriageinformation->child_name }}</p>
                            </td>
                            <td>
                                <p>Father's Name: {{ @$childmarriageinformation->child_father_name }}</p>
                            </td>
                            <td>
                                <p>Mother's Name: {{ @$childmarriageinformation->child_mother_name }}</p>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <p>Age: {{ @$childmarriageinformation->child_age }}</p>
                            </td>
                            <td>
                                <p>Gender: {{ @$childmarriageinformation->gender->name }}</p>
                            </td>
                            <td>
                                <p>Mobile: {{ @$childmarriageinformation->child_mobile_number }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Division: {{ @$childmarriageinformation->child_division->name }}</p>
                            </td>
                            <td>
                                <p>District: {{ @$childmarriageinformation->child_district->name }}</p>
                            </td>
                            <td>
                                <p>Upazila: {{ @$childmarriageinformation->child_upazila->name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Union: {{ @$childmarriageinformation->child_union->name }}</p>
                            </td>
                            <td>
                                <p>Village: {{ @$childmarriageinformation->child_village_name }}</p>
                            </td>
                            <td>
                                <p>Disability status: {{ @$childmarriageinformation->disability->name }}
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Initiative: {{ @$childmarriageinformation->child_marriage_initiative->name }}</p>
                            </td>
                            <td colspan="2">
                                <p>Assistance:
                                    @foreach (@$childmarriageinformation->assistanceTakens as $childmarriageassistance)
                                        <span class="bg-info">{{ $childmarriageassistance->name }}</span>,
                                    @endforeach
                                </p>
                            </td>
                        </tr>

                        {{-- Defendant Information --}}
                        <tr>
                            <td width="4%" class="text-center" rowspan="4">
                                <p style="font-weight: bold;">3</p>
                            </td>
                            <td colspan="3">
                                <p style="font-weight: bold;">Name of the person or institution, taking the first
                                    initiative</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Name : {{ @$childmarriageinformation->person_name }}</p>
                            </td>
                            <td>
                                <p>Mobile : {{ @$childmarriageinformation->person_mobile_number }}</p>
                            </td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>
                                <p>Division: {{ @$childmarriageinformation->person_division->name }}</p>
                            </td>
                            <td>
                                <p>District: {{ @$childmarriageinformation->person_district->name }}</p>
                            </td>
                            <td>
                                <p>Upazila: {{ @$childmarriageinformation->person_upazila->name }}</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Union: {{ @$childmarriageinformation->person_union->name }}</p>
                            </td>
                            <td>
                                <p>Village: {{ @$childmarriageinformation->person_village_name }}</p>
                            </td>
                            <td></td>
                        </tr>



                    </tbody>
                </table>


            </div>
        </div>
    </div>
</body>

</html>
