<!DOCTYPE html>
<html>
<head>
    <title></title>
    <!--Bootstrap Stylesheet [ REQUIRED ]-->
    <link href="{{asset('/backend')}}/css/bootstrap3.min.css" rel="stylesheet">
    <style type="text/css">
        @page {
            header: page-header;
            footer: page-footer;
            margin-top: 110px;
        }

        th {
            padding: 4px;
            border: 1px solid black;
            text-align: center;
            font-size: 9px;
        }
        td {
            padding: 8px;
            border: 1px solid black;
            text-align: center;
            font-size: 9px;
        }
        p{
            font-size: 12px;
        }
    </style>
    @yield('styles')
</head>
<body>
    <htmlpageheader name="page-header">
        <div class="col-sm-12">
            <div class="text-center">
            <img style="width: 100px;height: 40px;" src="{{asset('backend/images/logo-original.png')}}">
        </div>
        <p style="text-align: center; margin-bottom: 0px;"><strong>Community Empowerment Programme(CEP)</strong></p>
        <p style="text-align: center; margin-bottom: 0px;"><strong>Relationship with perpetrator Report on Stop Violence Initiative (SVI) General Activities</strong></p>
    </htmlpageheader>
    <div>
        @yield('content')
    </div>
    <htmlpagefooter name="page-footer">
        <div style="border-top: 1px solid #ddd;width: 100%;">
            <div style="font-size: 11px; float: left; width: 20%;text-align: left;">Printed Date : {{ $date }}</div>
            <div style="font-size: 11px; float: left; width: 70%;text-align: center;">BRAC Centre, 75 Mohakhali, Dhaka-1212, Bangladesh | <b>Tel:</b> 880-2-9881265 | <b>Fax: </b>880-2-9843614 | <b>Email: </b>info@brac.net </div>
            <div style="font-size: 11px; float: right; width: 10%; text-align: right;">{PAGENO}/{nb}</div>
        </div>
    </htmlpagefooter>
</body>
</html>
