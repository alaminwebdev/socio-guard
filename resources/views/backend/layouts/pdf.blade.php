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
        <p style="text-align: center; margin-bottom: 0px;"><strong>BRAC</strong></p>
        <p style="text-align: center; margin-bottom: 0px;"><strong>Community Empowerment Programme(CEP)</strong></p>
        <p style="text-align: center; margin-bottom: 0px;"><strong>Monthly MIS Report on Stop Violence Initiative (SVI) General Activities Violence Report & Support Given</strong></p>
        <!-- <p style="text-align: center; margin: 0px;">{{isset($report_title)?$report_title:''}}</p> -->

    </htmlpageheader>
    <div>
        @yield('content')
    </div>
    <htmlpagefooter name="page-footer">
        <div style="border-top: 1px solid #ddd;">
            <p style="text-align: center; font-size: 11px;">BRAC Centre, 75 Mohakhali, Dhaka-1212, Bangladesh | <b>Tel:</b> 880-2-9881265 | <b>Fax: </b>880-2-9843614 | <b>Email: </b>info@brac.net</p>
        </div>
    </htmlpagefooter>
</body>
</html>