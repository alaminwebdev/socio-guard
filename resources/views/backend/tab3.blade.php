@extends('backend.layouts.app')
@section('content')
<style type="text/css">
  h4{
    padding-top:10px;
  }
  .card_body{
    border-radius: 10px;
    text-align: center;
  }
  .card-clock{
    background: transparent;
    border:none;
  }
  /*amchart*/
  #chartdiv1 {
    width: 100%;
    height: 500px;
  }
  #chartdiv2 {
    width: 100%;
    height: 200px;
  }
  .modal-backdrop{
    z-index: 123!important;
  }
  /*.modal .fade .show {
    z-index: 999!important;
  }*/
  .daterangepicker{
    z-index: 999999!important;
  }

  .info-box {
    background-color: #ec1e8c;
    height: 83px;
    border-radius: 8px;
  }

  .nav-pills .nav-item.show .nav-link, .nav-pills .nav-link.active {
    background-color: #ec1e8c;
  }

  .nav-item > a {
    color: #ec1e8c;
  }
</style>
<link href="{{asset('/css/step.css')}}" rel="stylesheet" type="text/css" />
<script src="{{asset('backend/amcharts4/core.js')}}"></script>
<script src="{{asset('backend/amcharts4/charts.js')}}"></script>
<script src="{{asset('backend/amcharts4/themes/animated.js')}}"></script>
<script src="{{asset('backend/amcharts4/themes/material.js')}}"></script>
<script src="{{asset('backend/amcharts4/themes/kelly.js')}}"></script>
<div class="container-fluid">
  <div class="row">
    <div class="col-xl-12">
      <div class="breadcrumb-holder">
        <!-- <h1 class="main-title float-left">Dashboard</h1>
        <ol class="breadcrumb float-right">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol> -->
          <div class="row">
            <div class="container">
              <!-- Trigger the modal with a button -->
              <button style="display: none;" type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Search</button>

              <!-- Modal -->
              <div class="modal fade" style="z-index: 999!important;" id="myModal" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <h4 class="modal-title">Select Search Criteria</h4>
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                      <div class="form-row">
                        <div class="form-group col-md-4">
                          <label class="control-label">Zone</label>
                          <select name="region_id" id="region_id" class="region_id form-control form-control-sm select2" required="">
                            <option value="">Select Zone</option>
                            @foreach($regions as $region)
                            @if(count(session()->get('userareaaccess.sregions')) ==1)
                            <option value="{{$region->id}}" {{(session()->get('userareaaccess.sregions')[0] == $region->id)?('selected'):''}}>{{$region->region_name}}</option>
                            @else
                            <option value="{{$region->id}}">{{$region->region_name}}</option>
                            @endif
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-md-4">
                          <label class="control-label">Division</label>
                          <select name="division_id" id="division_id" class="division_id form-control form-control-sm select2">
                            <option value="">Select Division</option>

                          </select>
                        </div>
                        <div class="form-group col-md-4">
                          <label class="control-label">District</label>
                          <select name="district_id" id="district_id" class="district_id form-control form-control-sm select2">
                            <option value="">Select District</option>
                          </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Violence Type</label>
                            <select name="violence_category_id" id="violence_category_id" class="violence_category_id form-control form-control-sm select2">
                              <option value="">Select Violence Type</option>
                              @foreach($violence_categories as $cat)
                              <option value="{{$cat->id}}" {{(@$editIncident->violence_category_id==$cat->id)?"selected":""}}>{{$cat->name}}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label">Violence Sub Type</label>
                            <select name="violence_sub_category_id" id="violence_sub_category_id" class="violence_sub_category_id form-control form-control-sm">
                                <option value="">Select Sub Type</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label class="control-label">Violence Name</label>
                            <select name="violence_name_id" id="violence_name_id" class="violence_name_id form-control form-control-sm">
                                <option value="">Select Name</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-3">
                          <label class="control-label">From Date</label>
                          <input type="text" name="start_date" id="start_date" class="singledatepicker form-control form-control-sm" placeholder="DD-MM-YYYY" autocomplete="off">
                        </div>
                        <div class="form-group col-sm-3">
                          <label class="control-label">End Date</label>
                          <input type="text" name="end_date" id="end_date" class="singledatepicker form-control form-control-sm" placeholder="DD-MM-YYYY" autocomplete="off">
                        </div>
                        <div class="form-group col-sm-1">
                          <a class="btn btn-sm btn-primary" id="search" style="margin-top: 29px; color: white">Search</a>
                        </div>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>

<div class="container"></div>
    <div id="exTab1" class="container">

        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
          <li class="nav-item">
            <a class="nav-link" id="pills-home-tab" href="{{ route('dashboard') }}" role="tab" aria-controls="pills-home" aria-selected="true">State of Violence Incidents</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" href="{{ route('tab2') }}" role="tab" aria-controls="pills-profile" aria-selected="false">Violence Incident Details</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" id="pills-contact-tab" href="{{ route('tab3') }}" role="tab" aria-controls="pills-contact" aria-selected="false">Perpetrators</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="pills-contact-tab" href="{{ route('tab4') }}" role="tab" aria-controls="pills-contact" aria-selected="false">Survivor’s received services</a>
          </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
              <div class="text-center" style="color: #ec1e8c"><h6>Year {{ $current_year }}, Perpetrators</h6></div><br>
                <div class="row">
                  <div class="col-sm-1">

                  </div>
                  <div class="col-md-10">
                    <div class="row">
                      <div class="col-md-1">

                      </div>
                      <div class="icon-bx-wraper bx-style-2 m-b30 p-a20 right m-r50" style="background-color: #ec1f8c; color: #ffffff; min-width:220px;">
                          <div class="icon-content p-r40">
                              <h2>{{ $current_data_perpetrator_husband }}</h2>
                              <p><b>Husband</b></p>
                          </div>
                      </div>
                      <div class="icon-bx-wraper bx-style-2 m-b30 p-a20 right m-r50" style="background-color: #ec1f8c; color: #ffffff; min-width:220px;">
                          <div class="icon-content p-r40">
                              <h2>{{ $current_data_perpetrator_in_laws }}</h2>
                              <p><b>Family Member</b></p>
                          </div>
                      </div>
                      <div class="icon-bx-wraper bx-style-2 m-b30 p-a20 right m-r50" style="background-color: #ec1f8c; color: #ffffff; min-width:220px;">
                          <div class="icon-content p-r40">
                              <h2>{{ $current_data_perpetrator_neighbor }}</h2>
                              <p><b>Neighbor's </b></p>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-1">

                  </div>
                    <!-- <div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
                        <div class="card-box noradius noborder info-box">
                            <h2 class="text-white">3267</h2>
                            <p class="text-white m-b-20"> Girls<br></p>
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
                        <div class="card-box noradius noborder info-box">
                            <h2 class="text-white">675</h2>
                            <p class="text-white m-b-20">Boys<br></p>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                  <div class="col-sm-1">

                  </div>
                  <div class="col-md-10">
                    <div class="row">
                      <div class="col-md-1">

                      </div>
                      <div class="icon-bx-wraper bx-style-2 m-b30 p-a20 right m-r50" style="background-color: #ec1f8c; color: #ffffff; min-width:220px;">
                          <div class="icon-content p-r40">
                              <h2>{{ $current_data_perpetrator_acquaintance }}</h2>
                              <p><b>Acquaintances</b></p>
                          </div>
                      </div>
                      <div class="icon-bx-wraper bx-style-2 m-b30 p-a20 right m-r50" style="background-color: #ec1f8c; color: #ffffff; min-width:220px;">
                          <div class="icon-content p-r40">
                              <h2>{{ $current_data_perpetrator_relative }}</h2>
                              <p><b>Relatives</b></p>
                          </div>
                      </div>
                      <div class="icon-bx-wraper bx-style-2 m-b30 p-a20 right m-r50" style="background-color: #ec1f8c; color: #ffffff; min-width:220px;">
                          <div class="icon-content p-r40">
                              <h2>0</h2>
                              <p><b>Unknown</b></p>
                          </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-1">

                  </div>
                    <!-- <div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
                        <div class="card-box noradius noborder info-box">
                            <h2 class="text-white">3267</h2>
                            <p class="text-white m-b-20"> Girls<br></p>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">...</div>
            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div>
        </div>
        <!-- <ul class="nav nav-tabs">
            <li class="nav-item"><a class="nav-link active" href="#">Active</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
            <li class="nav-item"><a class="nav-link disabled" href="#">Disabled</a></li>
        </ul> -->
  </div>
</div>
<br>
  <div class="row">
    <div class="col-md-12">
        <div class="row">
            <!-- <div class="col-md-6" id="chartdiv5Display" style="display: none; background-color: #dbf9db; ">
                <h6 class="text-center">Age of women violence survivors</h6>
                <div class="row">
                <div class="col-md-12">
                  <div id="chartdiv5" style="height: 350px"></div>
                  <p class="text-center"><strong> Age of women violence survivors</strong></p>
                </div>
              </div>
            </div> -->
            <div class="col-md-12" id="chartdiv4Display" style="display: none; background-color: #eafeff; ">
              <h6 class="text-center">Age Group of Perpetrator</h6>
                <div class="col-md-12">
                  <div id="chartdiv4" style="height: 400px"></div>
                  <!-- <p class="text-center"><strong>Age of Children violence survivors </strong></p> -->
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function(){
    $(document).on('change','#region_id',function(){
      var region_id = $(this).val();
      $.ajax({
        url : "{{route('default.get-division')}}",
        type : "GET",
        data : {region_id:region_id},
        success:function(data){
          var html = '<option value="">Select Division</option>';
          $.each(data,function(key,v){
            html +='<option value="'+v.division_id+'">'+v.regional_division.name+'</option>';
          });
          $('#division_id').html(html);
        }
      });
    });
  });
</script>

<script type="text/javascript">
  $(function(){
    $(document).on('change','#division_id',function(){
      var region_id = $('#region_id').val();
      var division_id = $(this).val();
      $.ajax({
        url : "{{route('default.get-region-district')}}",
        type : "GET",
        data : {region_id:region_id,division_id:division_id},
        success:function(data){
          var html = '<option value="">Select District</option>';
          $.each(data,function(key,v){
            html +='<option value="'+v.district_id+'">'+v.regional_district.name+'</option>';
          });
          $('#district_id').html(html);
        }
      });
    });
  });
</script>

<script type="text/javascript">
  $(document).on('click','#search',function(){
    $('#myModal').modal('toggle');
    search();
  });

  function search(){
    var region_id = $('#region_id').val();
    var division_id = $('#division_id').val();
    var district_id = $('#district_id').val();
    var violence_category_id = $('#violence_category_id').val();
    var violence_sub_category_id = $('#violence_sub_category_id').val();
    var violence_name_id = $('#violence_name_id').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();
    $('#chartdiv4Display').hide();
    $('#chartdiv5Display').hide();
    chartdiv4(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv5(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
  }
</script>



<script type="text/javascript">
  $(document).on('click','#searchpie4',function(){
    var region_id = $('#region_id').val();
    var division_id = $('#division_id').val();
    var district_id = $('#district_id').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    var violence_category_id = $('#age_group_violence_category_id').val();
    var violence_sub_category_id = $('#age_group_violence_sub_category_id').val();
    var violence_name_id = $('#age_group_violence_name_id').val();
    var violence_reason_id = $('#age_group_violence_reason_id').val();

    chartdiv4(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id);
  });
</script>

<script type="text/javascript">
  $(document).on('click','#searchpie5',function(){
    var region_id = $('#region_id').val();
    var division_id = $('#division_id').val();
    var district_id = $('#district_id').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    var violence_category_id = $('#age_group_violence_category_id').val();
    var violence_sub_category_id = $('#age_group_violence_sub_category_id').val();
    var violence_name_id = $('#age_group_violence_name_id').val();
    var violence_reason_id = $('#age_group_violence_reason_id').val();

    chartdiv5(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id);
  });
</script>

<script type="text/javascript">
  function chartdiv4(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart5')}}",
      type : "GET",
      data : {
        region_id:region_id,
        division_id:division_id,
        district_id:district_id,
        start_date:start_date,
        end_date:end_date,
        violence_category_id:violence_category_id,
        violence_sub_category_id:violence_sub_category_id,
        violence_name_id:violence_name_id,
        violence_reason_id:violence_reason_id,
      },
      success:function(data){
        console.log(data);
        $('#chartdiv4Display').show();


        am4core.ready(function() {
          am4core.useTheme(am4themes_material);
          var chart = am4core.create("chartdiv4", am4charts.XYChart);
          chart.scrollbarX = new am4core.Scrollbar();


          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var age_group_data = tmpArr;

          chart.data = age_group_data;

          var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
          categoryAxis.dataFields.category = "age_group_name";
          categoryAxis.renderer.grid.template.location = 0;
          categoryAxis.renderer.minGridDistance = 30;
          categoryAxis.renderer.labels.template.horizontalCenter = "right";
          categoryAxis.renderer.labels.template.verticalCenter = "middle";
          // categoryAxis.renderer.labels.template.rotation = 270;
          categoryAxis.tooltip.disabled = true;
          categoryAxis.renderer.minHeight = 110;

          var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
          valueAxis.renderer.minWidth = 50;

          var series = chart.series.push(new am4charts.ColumnSeries());
          series.sequencedInterpolation = true;
          series.dataFields.valueY = "age_group_total";
          series.dataFields.categoryX = "age_group_name";
          series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
          series.columns.template.strokeWidth = 0;

          series.tooltip.pointerOrientation = "vertical";

          series.columns.template.column.cornerRadiusTopLeft = 10;
          series.columns.template.column.cornerRadiusTopRight = 10;
          series.columns.template.column.fillOpacity = 0.8;

          var hoverState = series.columns.template.column.states.create("hover");
          hoverState.properties.cornerRadiusTopLeft = 0;
          hoverState.properties.cornerRadiusTopRight = 0;
          hoverState.properties.fillOpacity = 1;

          series.columns.template.adapter.add("fill", function(fill, target) {
            return chart.colors.getIndex(target.dataItem.index);
          });

          chart.cursor = new am4charts.XYCursor();

        });

      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv5(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart11')}}",
      type : "GET",
      data : {
        region_id:region_id,
        division_id:division_id,
        district_id:district_id,
        start_date:start_date,
        end_date:end_date,
        violence_category_id:violence_category_id,
        violence_sub_category_id:violence_sub_category_id,
        violence_name_id:violence_name_id,
        violence_reason_id:violence_reason_id,
      },
      success:function(data){
        console.log(data);
        $('#chartdiv5Display').show();


        am4core.ready(function() {
          am4core.useTheme(am4themes_kelly);
          var chart = am4core.create("chartdiv5", am4charts.XYChart);
          chart.scrollbarX = new am4core.Scrollbar();


          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var age_group_data = tmpArr;

          chart.data = age_group_data;

          var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
          categoryAxis.dataFields.category = "age_group_name";
          categoryAxis.renderer.grid.template.location = 0;
          categoryAxis.renderer.minGridDistance = 30;
          categoryAxis.renderer.labels.template.horizontalCenter = "right";
          categoryAxis.renderer.labels.template.verticalCenter = "middle";
          // categoryAxis.renderer.labels.template.rotation = 270;
          categoryAxis.tooltip.disabled = true;
          categoryAxis.renderer.minHeight = 110;

          var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
          valueAxis.renderer.minWidth = 50;

          var series = chart.series.push(new am4charts.ColumnSeries());
          series.sequencedInterpolation = true;
          series.dataFields.valueY = "age_group_total";
          series.dataFields.categoryX = "age_group_name";
          series.tooltipText = "[{categoryX}: bold]{valueY}[/]";
          series.columns.template.strokeWidth = 0;

          series.tooltip.pointerOrientation = "vertical";

          series.columns.template.column.cornerRadiusTopLeft = 10;
          series.columns.template.column.cornerRadiusTopRight = 10;
          series.columns.template.column.fillOpacity = 0.8;

          var hoverState = series.columns.template.column.states.create("hover");
          hoverState.properties.cornerRadiusTopLeft = 0;
          hoverState.properties.cornerRadiusTopRight = 0;
          hoverState.properties.fillOpacity = 1;

          series.columns.template.adapter.add("fill", function(fill, target) {
            return chart.colors.getIndex(target.dataItem.index);
          });

          chart.cursor = new am4charts.XYCursor();

        });

      }
    });
  }
</script>

<script type="text/javascript">
    $(function(){
        $(document).on('change','.violence_category_id',function(){
            var violence_category_id = $(this).val();
            $.ajax({
                url : "{{route('default.get-violence-sub-category')}}",
                type : "GET",
                data : {violence_category_id:violence_category_id},
                success:function(data){
                    var html = '<option value="">Select Violence Sub Category</option>';
                    $.each(data,function(key,v){
                        html +='<option value="'+v.id+'">'+v.name+'</option>';
                    });
                    $('.violence_sub_category_id').html(html);
                }
            });
        });
    });
</script>

<script type="text/javascript">
    $(function(){
        $(document).on('change','.violence_sub_category_id',function(){
            var violence_sub_category_id = $(this).val();
            $.ajax({
                url : "{{route('default.get-violence-name')}}",
                type : "GET",
                data : {violence_sub_category_id:violence_sub_category_id},
                success:function(data){
                    var html = '<option value="">Select Violence Name</option>';
                    $.each(data,function(key,v){
                        html +='<option value="'+v.id+'">'+v.name+'</option>';
                    });
                    $('.violence_name_id').html(html);
                }
            });
        });
    });
</script>
@endsection
@section('page_script')
<script>
  $(function() {
    showTime();
  });

  function showTime()
  {
    var date = new Date();
    var h = date.getHours();
    var m = date.getMinutes();
    var s = date.getSeconds();
    var session = "AM";

    if(h == 0)
    {
      h = 12;
    }

    if(h > 12)
    {
      h = h - 12;
      session = "PM";
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("clock").innerText = time;
    setTimeout(showTime, 1000);
  }
</script>
<script type="text/javascript">
  $(function(){
    search();
    $('#region_id').trigger('change');
  });
</script>
@endsection