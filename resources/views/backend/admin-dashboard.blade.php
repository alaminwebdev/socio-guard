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
</style>
<script src="{{asset('backend/amcharts4/core.js')}}"></script>
<script src="{{asset('backend/amcharts4/charts.js')}}"></script>
<script src="{{asset('backend/amcharts4/themes/kelly.js')}}"></script>
<script src="{{asset('backend/amcharts4/themes/animated.js')}}"></script>
<div class="container-fluid">
  <div class="row">
    <div class="col-xl-12">
      <div class="breadcrumb-holder">
        <h1 class="main-title float-left">Dashboard</h1>
        <ol class="breadcrumb float-right">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
          <div class="row">
            <div class="container">
              <!-- Trigger the modal with a button -->
              <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal">Search</button>

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

<div class="row">
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
        <div class="card-box noradius noborder bg-danger" style="height: 155px;">
            <h6 class="text-white text-uppercase m-b-20">Incidents of Violence Reported</h6>
            <h2 class="text-white">{{ $survivor_count }}</h2>
            <p class="text-white m-b-20">{{ number_format((float)$today_per, 2, '.', '') }}% - Everyday | {{ number_format((float)$monthly_per, 2, '.', '') }}% - Monthly<br></p>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
        <div class="card-box noradius noborder bg-success" style="height: 155px;">
            <h6 class="text-white text-uppercase m-b-20">Perpetrator's Gender</h6>
            <p class="m-b-20 text-white counter"><i class="fa fa-male" aria-hidden="true"></i> Men-<strong>{{ number_format((float)$male_per, 2, '.', '') }}%</strong><i class="fa fa-female" aria-hidden="true"></i>Women-<strong>{{ number_format((float)$female_per, 2, '.', '') }}%</strong></p>
        </div>
    </div>
    <div class="col-xs-12 col-md-6 col-lg-6 col-xl-4">
        <div class="card-box noradius noborder bg-info" style="height: 155px;">
            <h6 class="text-white text-uppercase m-b-20">Even Children faced violence</h6>
            <br>
            <p class="m-b-20 text-white counter"><strong>{{ number_format((float)$women_per, 2, '.', '') }}%</strong> - Against Women</p>
            <p class="m-b-20 text-white counter"><strong>{{ number_format((float)$child_per, 2, '.', '') }}%</strong> - Girl Child</p>
        </div>
    </div>
</div>
  <div class="row">
    <div class="col-md-12">
        <!-- <div id="accordion">
          <div class="card-header" id="heading-1">
            <h5 class="mb-0">
              <a class="collapsed" role="button" data-toggle="collapse" href="#collapse-1" aria-expanded="false" aria-controls="collapse-1">
                Select search criteria
              </a>
            </h5>
          </div>
          <div id="collapse-1" class="collapse show" data-parent="#accordion" aria-labelledby="heading-1">
            <div class="card-body">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label class="control-label">Zone</label>
                  <select name="region_id" id="region_id" class="region_id form-control form-control-sm select2">
                    <option value="">Select Zone</option>
                    @foreach($regions as $region)
                    <option value="{{$region->id}}">{{$region->region_name}}</option>
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
          </div>
        </div> -->


        {{-- start chart1 --}}
        <div class="row">
            <div class="col-md-6" id="chartdiv1Display" style="display: none; ">
              <h6 class="text-center">Violence Information tracking</h6>
              <div id="chartdiv1" style="height: 350px"></div>
              <p class="text-center"><strong> District wise number of violence and type of violence </strong></p>
            </div>
            <div class="col-md-6" id="chartdiv2Display" style="display: none; background-color: #f4f7e7;">
              <h6 class="text-center">Violence Incident Analysis</h6>
                <div class="col-md-12">
                  <div id="chartdiv2" style="height: 200px"></div>
                  <p class="text-center"><strong> Type of violence and reasons behind the violence </strong></p>
                </div>
            </div>
        </div>
        {{-- end chart1 --}}

        <div class="row">
            <div class="col-md-6" id="chartdiv3Display" style="display: none; background-color: #dbf9db; ">
                <h6 class="text-center">Survivor's Info Analysis</h6>
                <div class="row">
                <div class="col-md-12">
                  <div id="chartdiv3" style="height: 300px"></div>
                  <p class="text-center"><strong> Type of violence and disability status </strong></p>
                </div>
              </div>
            </div>
            <div class="col-md-6" id="chartdiv4Display" style="display: none; background-color: #eafeff; ">
              <h6 class="text-center">Age Group of Survivor</h6>
                <div class="col-md-12">
                  <div id="chartdiv4" style="height: 350px"></div>
                  <p class="text-center"><strong> Type of violence and age group of survivors </strong></p>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6" id="chartdiv5Display" style="display: none; background-color: #f8ffea; ">
                <h6 class="text-center">Age Group of Perpetrator</h6>
                <div class="row">
                <div class="col-md-12">
                  <div id="chartdiv5" style="height: 350px"></div>
                  <p class="text-center"><strong> Type of violence and perpetrators age analysis </strong></p>
                </div>
              </div>
            </div>
            <div class="col-md-6" id="chartdiv6Display" style="display: none; background-color: #dbf9db; ">
                <h6 class="text-center">Perpetrator Relationship</h6>
                <div class="col-md-12">
                  <div id="chartdiv6" style="height: 300px"></div>
                  <p class="text-center"><strong> Type of violence and relationship between perpetrators and survivors </strong></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="chartdiv7Display" style="display: none; background-color: #fefaf8; ">
              <h6 class="text-center">Perpetrator Current Situation</h6>
              <div class="row">
                <div class="col-md-12">
                  <div id="chartdiv7" style="height: 300px"></div>
                  <p class="text-center"><strong> Type of violence and current situation of perpetrator </strong></p>
                </div>
              </div>
            </div>
            <div class="col-md-6" id="chartdiv8Display" style="display: none; background-color: #dbf9db; ">
                <h6 class="text-center">Places of Violence Place</h6>
                <div class="col-md-12">
                  <div id="chartdiv8" style="height: 300px"></div>
                  <p class="text-center"><strong> Violence Place </strong></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="chartdiv9Display" style="display: none; background-color: #f8ffea; ">
              <h6 class="text-center">Status of Legal Initiatives</h6>
              <div class="row">
                <div class="col-md-12">
                  <div id="chartdiv9" style="height: 285px"></div>
                  <p class="text-center"><strong> Type of violence and Status of legal initiatives </strong></p>
                </div>
              </div>
            </div>
            <div class="col-md-6" id="chartdiv12Display" style="display: none;">
                <h6 class="text-center">Survivor's Maritial Status</h6>
                <div class="col-md-12">
                  <div id="chartdiv12" style="height: 300px"></div>
                  <p class="text-center"><strong> Type of violence and marital status </strong></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="chartdiv13Display" style="display: none; background-color: #f8ffea; ">
              <h6 class="text-center">Perpetrator Maritial Status</h6>
              <div class="row">
                <div class="col-md-12">
                  <div id="chartdiv13" style="height: 285px"></div>
                  <p class="text-center"><strong> Type of violence and marital status </strong></p>
                </div>
              </div>
            </div>
            <div class="col-md-6" id="chartdiv14Display" style="display: none;">
                <h6 class="text-center">Survivor's Occupation</h6>
                <div class="col-md-12">
                  <div id="chartdiv14" style="height: 300px"></div>
                  <p class="text-center"><strong> Type of violence and occupation </strong></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="chartdiv15Display" style="display: none; background-color: #f8ffea; ">
              <h6 class="text-center">Perpetrator Occupation</h6>
              <div class="row">
                <div class="col-md-12">
                  <div id="chartdiv15" style="height: 285px"></div>
                  <p class="text-center"><strong> Type of violence and occupation </strong></p>
                </div>
              </div>
            </div>
            <div class="col-md-6" id="chartdiv16Display" style="display: none;">
                <h6 class="text-center">Perpetrators analysis- in terms of family members</h6>
                <div class="col-md-12">
                  <div id="chartdiv16" style="height: 300px"></div>
                  <p class="text-center"><strong> Type of violence and perpetrators analysis- in terms of family members </strong></p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6" id="chartdiv17Display" style="display: none; background-color: #f8ffea; ">
              <h6 class="text-center">Reasons of not taking legal initiatives</h6>
              <div class="row">
                <div class="col-md-12">
                  <div id="chartdiv17" style="height: 285px"></div>
                  <p class="text-center"><strong> Type of violence and reasons of not taking legal initiatives </strong></p>
                </div>
              </div>
            </div>
            <div class="col-md-6" id="chartdiv18Display" style="display: none;">
                <h6 class="text-center">survivors situation</h6>
                <div class="col-md-12">
                  <div id="chartdiv18" style="height: 300px"></div>
                  <p class="text-center"><strong> Type of violence and Comparison among survivors situation </strong></p>
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
    $('#chartdiv1Display').hide();
    $('#chartdiv2Display').hide();
    $('#chartdiv3Display').hide();
    $('#chartdiv4Display').hide();
    $('#chartdiv5Display').hide();
    $('#chartdiv6Display').hide();
    $('#chartdiv7Display').hide();
    $('#chartdiv8Display').hide();
    $('#chartdiv9Display').hide();
    $('#chartdiv12Display').hide();
    $('#chartdiv13Display').hide();
    $('#chartdiv14Display').hide();
    $('#chartdiv15Display').hide();
    $('#chartdiv16Display').hide();
    $('#chartdiv17Display').hide();
    $('#chartdiv18Display').hide();
    chartdiv1(region_id,division_id,district_id,start_date,end_date);
    chartdiv2(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv3(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv4(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv5(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv6(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv7(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv8(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv9(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv12(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv13(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv14(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv15(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv16(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv17(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
    chartdiv18(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id);
  }
</script>

<script type="text/javascript">
  $(document).on('click','#searchpie',function(){
    var region_id = $('#region_id').val();
    var division_id = $('#division_id').val();
    var district_id = $('#district_id').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    var violence_category_id = $('#violence_category_id').val();
    var violence_sub_category_id = $('#violence_sub_category_id').val();
    var violence_name_id = $('#violence_name_id').val();
    var violence_reason_id = $('#violence_reason_id').val();

    chartdiv2(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id);
  });
</script>

<script type="text/javascript">
  $(document).on('click','#searchpie3',function(){
    var region_id = $('#region_id').val();
    var division_id = $('#division_id').val();
    var district_id = $('#district_id').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    var violence_category_id = $('#autistic_violence_category_id').val();
    var violence_sub_category_id = $('#autistic_violence_sub_category_id').val();
    var violence_name_id = $('#autistic_violence_name_id').val();
    var violence_reason_id = $('#autistic_violence_reason_id').val();

    chartdiv3(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id);
  });
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

    var violence_category_id = $('#perpetrator_age_group_violence_category_id').val();
    var violence_sub_category_id = $('#perpetrator_age_group_violence_sub_category_id').val();
    var violence_name_id = $('#perpetrator_age_group_violence_name_id').val();
    var violence_reason_id = $('#perpetrator_age_group_violence_reason_id').val();

    chartdiv5(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id);
  });
</script>

<script type="text/javascript">
  $(document).on('click','#searchpie6',function(){
    var region_id = $('#region_id').val();
    var division_id = $('#division_id').val();
    var district_id = $('#district_id').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    var violence_category_id = $('#relationship_violence_category_id').val();
    var violence_sub_category_id = $('#relationship_violence_sub_category_id').val();
    var violence_name_id = $('#relationship_violence_name_id').val();
    var violence_reason_id = $('#relationship_violence_reason_id').val();

    chartdiv6(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id);
  });
</script>


<script type="text/javascript">
  $(document).on('click','#searchpi12',function(){
    var region_id = $('#region_id').val();
    var division_id = $('#division_id').val();
    var district_id = $('#district_id').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    var violence_category_id = $('#relationship_violence_category_id').val();
    var violence_sub_category_id = $('#relationship_violence_sub_category_id').val();
    var violence_name_id = $('#relationship_violence_name_id').val();
    var violence_reason_id = $('#relationship_violence_reason_id').val();

    chartdiv12(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id);
  });
</script>


<script type="text/javascript">
  $(document).on('click','#searchpi13',function(){
    var region_id = $('#region_id').val();
    var division_id = $('#division_id').val();
    var district_id = $('#district_id').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    var violence_category_id = $('#relationship_violence_category_id').val();
    var violence_sub_category_id = $('#relationship_violence_sub_category_id').val();
    var violence_name_id = $('#relationship_violence_name_id').val();
    var violence_reason_id = $('#relationship_violence_reason_id').val();

    chartdiv13(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id);
  });
</script>

<script type="text/javascript">
  $(document).on('click','#searchpie7',function(){
    var region_id = $('#region_id').val();
    var division_id = $('#division_id').val();
    var district_id = $('#district_id').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    var violence_category_id = $('#p_place_violence_category_id').val();
    var violence_sub_category_id = $('#p_place_violence_sub_category_id').val();
    var violence_name_id = $('#p_place_violence_name_id').val();
    var violence_reason_id = $('#p_place_violence_reason_id').val();

    chartdiv7(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id);
  });
</script>

<script type="text/javascript">
  $(document).on('click','#searchpie8',function(){
    var region_id = $('#region_id').val();
    var division_id = $('#division_id').val();
    var district_id = $('#district_id').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    var violence_category_id = $('#place_violence_category_id').val();
    var violence_sub_category_id = $('#place_violence_sub_category_id').val();
    var violence_name_id = $('#place_violence_name_id').val();
    var violence_reason_id = $('#place_violence_reason_id').val();

    chartdiv8(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id);
  });
</script>

<script type="text/javascript">
  $(document).on('click','#searchpie9',function(){
    var region_id = $('#region_id').val();
    var division_id = $('#division_id').val();
    var district_id = $('#district_id').val();
    var start_date = $('#start_date').val();
    var end_date = $('#end_date').val();

    var violence_category_id = $('#legel_violence_category_id').val();
    var violence_sub_category_id = $('#legel_violence_sub_category_id').val();
    var violence_name_id = $('#legel_violence_name_id').val();
    var violence_reason_id = $('#legel_violence_reason_id').val();

    chartdiv9(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id);
  });
</script>

<script type="text/javascript">
  function chartdiv1(region_id,division_id,district_id,start_date,end_date){
    $.ajax({
      url : "{{route('survivor.all.information.getchart1')}}",
      type : "GET",
      data : {
        region_id:region_id,
        division_id:division_id,
        district_id:district_id,
        start_date:start_date,
        end_date:end_date
      },
      success:function(data){
        $('#chartdiv1Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv1", am4charts.XYChart);
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;
          var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
          categoryAxis.dataFields.category = "horizontal";
          categoryAxis.renderer.grid.template.location = 0;
          var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
          valueAxis.renderer.inside = true;
          valueAxis.renderer.labels.template.disabled = false;
          valueAxis.min = 0;
          function createSeries(field, name) {
            var series = chart.series.push(new am4charts.ColumnSeries());
            series.name = name;
            series.dataFields.valueY = field;
            series.dataFields.categoryX = "horizontal";
            series.sequencedInterpolation = true;
            series.stacked = true;
            series.columns.template.width = am4core.percent(60);
            series.columns.template.tooltipText = "[bold]{name}[/]\n[font-size:14px]{categoryX}: {valueY}";
            var labelBullet = series.bullets.push(new am4charts.LabelBullet());
            labelBullet.label.text = "{valueY}";
            labelBullet.locationY = 0.5;
            labelBullet.label.hideOversized = true;
            return series;
          }

          $.each(data.harasment_type, function( index, value ) {
            createSeries(value, value);
          });

          chart.legend = new am4charts.Legend();
        });
      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv2(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart2')}}",
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
        $('#chartdiv2Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv2", am4charts.PieChart3D);
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;

          var pieSeries = chart.series.push(new am4charts.PieSeries3D());
          pieSeries.dataFields.value = "pie_count";
          pieSeries.dataFields.category = "pie_category";
          // pieSeries.innerRadius = am4core.percent(30);
          // pieSeries.ticks.template.disabled = false;
          // pieSeries.labels.template.disabled = false;
          pieSeries.labels.template.text = "{pie_category} : {pie_count}";


          // var rgm = new am4core.RadialGradientModifier();
          // rgm.brightnesses.push(-1, -1, -0.5, 0, - 0.5);
          // pieSeries.slices.template.fillModifier = rgm;
          // pieSeries.slices.template.strokeModifier = rgm;
          // pieSeries.slices.template.strokeOpacity = 0.4;
          // pieSeries.slices.template.strokeWidth = 0;

          // chart.legend = new am4charts.Legend();
          // chart.legend.position = "right";
          // chart.legend.valueLabels.template.text = "{pie_count}";

        });
      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv3(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart3')}}",
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
        $('#chartdiv3Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv3", am4charts.PieChart);
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;

          var pieSeries = chart.series.push(new am4charts.PieSeries());
          pieSeries.dataFields.value = "pie_count";
          pieSeries.dataFields.category = "pie_category";
          pieSeries.innerRadius = am4core.percent(30);
          pieSeries.ticks.template.disabled = true;
          pieSeries.labels.template.disabled = true;

          var rgm = new am4core.RadialGradientModifier();
          rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
          pieSeries.slices.template.fillModifier = rgm;
          pieSeries.slices.template.strokeModifier = rgm;
          pieSeries.slices.template.strokeOpacity = 0.4;
          pieSeries.slices.template.strokeWidth = 0;

          chart.legend = new am4charts.Legend();
          chart.legend.position = "right";
          chart.legend.valueLabels.template.text = "{pie_count}";

        });
      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv4(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart4')}}",
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
          am4core.useTheme(am4themes_animated);
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
        $('#chartdiv5Display').show();


        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
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
  function chartdiv6(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart6')}}",
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
        $('#chartdiv6Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv6", am4charts.PieChart);
          chart.hiddenState.properties.opacity = 0;
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;

          var pieSeries = chart.series.push(new am4charts.PieSeries());
          pieSeries.dataFields.value = "pie_count";
          pieSeries.dataFields.category = "pie_category";
          // pieSeries.dataFields.category = "pie_count";
          // pieSeries.slices.template.cornerRadius = 6;
          // pieSeries.colors.step = 3;


          pieSeries.innerRadius = am4core.percent(30);
          pieSeries.ticks.template.disabled = true;
          pieSeries.labels.template.disabled = true;

          var rgm = new am4core.RadialGradientModifier();
          rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
          pieSeries.slices.template.fillModifier = rgm;
          pieSeries.slices.template.strokeModifier = rgm;
          pieSeries.slices.template.strokeOpacity = 0.4;
          pieSeries.slices.template.strokeWidth = 0;

          chart.legend = new am4charts.Legend();
          chart.legend.position = "right";
          chart.legend.valueLabels.template.text = "{pie_count}";

        });
      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv12(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart12')}}",
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
        $('#chartdiv12Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv12", am4charts.PieChart);
          chart.hiddenState.properties.opacity = 0;
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;

          var pieSeries = chart.series.push(new am4charts.PieSeries());
          pieSeries.dataFields.value = "pie_count";
          pieSeries.dataFields.category = "pie_category";
          // pieSeries.dataFields.category = "pie_count";
          // pieSeries.slices.template.cornerRadius = 6;
          // pieSeries.colors.step = 3;


          pieSeries.innerRadius = am4core.percent(30);
          pieSeries.ticks.template.disabled = true;
          pieSeries.labels.template.disabled = true;

          var rgm = new am4core.RadialGradientModifier();
          rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
          pieSeries.slices.template.fillModifier = rgm;
          pieSeries.slices.template.strokeModifier = rgm;
          pieSeries.slices.template.strokeOpacity = 0.4;
          pieSeries.slices.template.strokeWidth = 0;

          chart.legend = new am4charts.Legend();
          chart.legend.position = "right";
          chart.legend.valueLabels.template.text = "{pie_count}";

        });
      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv13(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart13')}}",
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
        $('#chartdiv13Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv13", am4charts.PieChart);
          chart.hiddenState.properties.opacity = 0;
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;

          var pieSeries = chart.series.push(new am4charts.PieSeries());
          pieSeries.dataFields.value = "pie_count";
          pieSeries.dataFields.category = "pie_category";
          // pieSeries.dataFields.category = "pie_count";
          // pieSeries.slices.template.cornerRadius = 6;
          // pieSeries.colors.step = 3;


          pieSeries.innerRadius = am4core.percent(30);
          pieSeries.ticks.template.disabled = true;
          pieSeries.labels.template.disabled = true;

          var rgm = new am4core.RadialGradientModifier();
          rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
          pieSeries.slices.template.fillModifier = rgm;
          pieSeries.slices.template.strokeModifier = rgm;
          pieSeries.slices.template.strokeOpacity = 0.4;
          pieSeries.slices.template.strokeWidth = 0;

          chart.legend = new am4charts.Legend();
          chart.legend.position = "right";
          chart.legend.valueLabels.template.text = "{pie_count}";

        });
      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv14(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart14')}}",
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
        $('#chartdiv14Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv14", am4charts.PieChart);
          chart.hiddenState.properties.opacity = 0;
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;

          var pieSeries = chart.series.push(new am4charts.PieSeries());
          pieSeries.dataFields.value = "pie_count";
          pieSeries.dataFields.category = "pie_category";
          // pieSeries.dataFields.category = "pie_count";
          // pieSeries.slices.template.cornerRadius = 6;
          // pieSeries.colors.step = 3;


          pieSeries.innerRadius = am4core.percent(30);
          pieSeries.ticks.template.disabled = true;
          pieSeries.labels.template.disabled = true;

          var rgm = new am4core.RadialGradientModifier();
          rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
          pieSeries.slices.template.fillModifier = rgm;
          pieSeries.slices.template.strokeModifier = rgm;
          pieSeries.slices.template.strokeOpacity = 0.4;
          pieSeries.slices.template.strokeWidth = 0;

          chart.legend = new am4charts.Legend();
          chart.legend.position = "right";
          chart.legend.valueLabels.template.text = "{pie_count}";

        });
      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv15(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart15')}}",
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
        $('#chartdiv15Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv15", am4charts.PieChart);
          chart.hiddenState.properties.opacity = 0;
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;

          var pieSeries = chart.series.push(new am4charts.PieSeries());
          pieSeries.dataFields.value = "pie_count";
          pieSeries.dataFields.category = "pie_category";
          // pieSeries.dataFields.category = "pie_count";
          // pieSeries.slices.template.cornerRadius = 6;
          // pieSeries.colors.step = 3;


          pieSeries.innerRadius = am4core.percent(30);
          pieSeries.ticks.template.disabled = true;
          pieSeries.labels.template.disabled = true;

          var rgm = new am4core.RadialGradientModifier();
          rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
          pieSeries.slices.template.fillModifier = rgm;
          pieSeries.slices.template.strokeModifier = rgm;
          pieSeries.slices.template.strokeOpacity = 0.4;
          pieSeries.slices.template.strokeWidth = 0;

          chart.legend = new am4charts.Legend();
          chart.legend.position = "right";
          chart.legend.valueLabels.template.text = "{pie_count}";

        });
      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv16(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart16')}}",
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
        $('#chartdiv16Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv16", am4charts.PieChart);
          chart.hiddenState.properties.opacity = 0;
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;

          var pieSeries = chart.series.push(new am4charts.PieSeries());
          pieSeries.dataFields.value = "pie_count";
          pieSeries.dataFields.category = "pie_category";
          // pieSeries.dataFields.category = "pie_count";
          // pieSeries.slices.template.cornerRadius = 6;
          // pieSeries.colors.step = 3;


          pieSeries.innerRadius = am4core.percent(30);
          pieSeries.ticks.template.disabled = true;
          pieSeries.labels.template.disabled = true;

          var rgm = new am4core.RadialGradientModifier();
          rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
          pieSeries.slices.template.fillModifier = rgm;
          pieSeries.slices.template.strokeModifier = rgm;
          pieSeries.slices.template.strokeOpacity = 0.4;
          pieSeries.slices.template.strokeWidth = 0;

          chart.legend = new am4charts.Legend();
          chart.legend.position = "right";
          chart.legend.valueLabels.template.text = "{pie_count}";

        });
      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv17(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart17')}}",
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
        $('#chartdiv17Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv17", am4charts.PieChart);
          chart.hiddenState.properties.opacity = 0;
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;

          var pieSeries = chart.series.push(new am4charts.PieSeries());
          pieSeries.dataFields.value = "pie_count";
          pieSeries.dataFields.category = "pie_category";
          // pieSeries.dataFields.category = "pie_count";
          // pieSeries.slices.template.cornerRadius = 6;
          // pieSeries.colors.step = 3;


          pieSeries.innerRadius = am4core.percent(30);
          pieSeries.ticks.template.disabled = true;
          pieSeries.labels.template.disabled = true;

          var rgm = new am4core.RadialGradientModifier();
          rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
          pieSeries.slices.template.fillModifier = rgm;
          pieSeries.slices.template.strokeModifier = rgm;
          pieSeries.slices.template.strokeOpacity = 0.4;
          pieSeries.slices.template.strokeWidth = 0;

          chart.legend = new am4charts.Legend();
          chart.legend.position = "right";
          chart.legend.valueLabels.template.text = "{pie_count}";

        });
      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv18(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart18')}}",
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
        $('#chartdiv18Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv18", am4charts.PieChart);
          chart.hiddenState.properties.opacity = 0;
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;

          var pieSeries = chart.series.push(new am4charts.PieSeries());
          pieSeries.dataFields.value = "pie_count";
          pieSeries.dataFields.category = "pie_category";
          // pieSeries.dataFields.category = "pie_count";
          // pieSeries.slices.template.cornerRadius = 6;
          // pieSeries.colors.step = 3;


          pieSeries.innerRadius = am4core.percent(30);
          pieSeries.ticks.template.disabled = true;
          pieSeries.labels.template.disabled = true;

          var rgm = new am4core.RadialGradientModifier();
          rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
          pieSeries.slices.template.fillModifier = rgm;
          pieSeries.slices.template.strokeModifier = rgm;
          pieSeries.slices.template.strokeOpacity = 0.4;
          pieSeries.slices.template.strokeWidth = 0;

          chart.legend = new am4charts.Legend();
          chart.legend.position = "right";
          chart.legend.valueLabels.template.text = "{pie_count}";

        });
      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv7(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart7')}}",
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
        $('#chartdiv7Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv7", am4charts.PieChart3D);
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;
          chart.innerRadius = 40;

          var pieSeries = chart.series.push(new am4charts.PieSeries3D());
          pieSeries.dataFields.value = "pie_count";
          pieSeries.dataFields.category = "pie_category";
          // pieSeries.innerRadius = am4core.percent(30);
          // pieSeries.ticks.template.disabled = true;
          // pieSeries.labels.template.disabled = true;

          // var rgm = new am4core.RadialGradientModifier();
          // rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
          // pieSeries.slices.template.fillModifier = rgm;
          // pieSeries.slices.template.strokeModifier = rgm;
          // pieSeries.slices.template.strokeOpacity = 0.4;
          // pieSeries.slices.template.strokeWidth = 0;

          // chart.legend = new am4charts.Legend();
          // chart.legend.position = "right";
          // chart.legend.valueLabels.template.text = "{pie_count}";

        });
      }
    });
  }
</script>

<script type="text/javascript">
  function chartdiv8(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart8')}}",
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
        $('#chartdiv8Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv8", am4charts.PieChart);
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;

          var pieSeries = chart.series.push(new am4charts.PieSeries());
          pieSeries.dataFields.value = "pie_count";
          pieSeries.dataFields.category = "pie_category";
          pieSeries.innerRadius = am4core.percent(30);
          // pieSeries.ticks.template.disabled = true;
          // pieSeries.labels.template.disabled = true;

          var rgm = new am4core.RadialGradientModifier();
          rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
          pieSeries.slices.template.fillModifier = rgm;
          pieSeries.slices.template.strokeModifier = rgm;
          pieSeries.slices.template.strokeOpacity = 0.4;
          pieSeries.slices.template.strokeWidth = 0;

          // chart.legend = new am4charts.Legend();
          // chart.legend.position = "right";
          // chart.legend.valueLabels.template.text = "{pie_count}";

        });
      }
    });
  }
</script>


<!-- <script type="text/javascript">
  function chartdiv9(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart9')}}",
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
        $('#chartdiv9Display').show();


        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv9", am4charts.XYChart);
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
          categoryAxis.renderer.labels.template.rotation = 270;
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
</script> -->

<script type="text/javascript">
  function chartdiv9(region_id,division_id,district_id,start_date,end_date,violence_category_id,violence_sub_category_id,violence_name_id,violence_reason_id){
    $.ajax({
      url : "{{route('survivor.all.information.getchart9')}}",
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
        $('#chartdiv9Display').show();
        am4core.ready(function() {
          am4core.useTheme(am4themes_animated);
          var chart = am4core.create("chartdiv9", am4charts.PieChart3D);
          var tmpArr = []
          var key = ''
          for (key in data) {
            tmpArr[tmpArr.length] = data[key];
          }
          var survivor_data = tmpArr;
          chart.data = survivor_data;
          chart.innerRadius = 40;

          var pieSeries = chart.series.push(new am4charts.PieSeries3D());
          pieSeries.dataFields.value = "legel_total";
          pieSeries.dataFields.category = "legel_name";
          // pieSeries.innerRadius = am4core.percent(30);
          // pieSeries.ticks.template.disabled = true;
          // pieSeries.labels.template.disabled = true;
          pieSeries.labels.template.text = "{legel_name} : {legel_total}";

          // var rgm = new am4core.RadialGradientModifier();
          // rgm.brightnesses.push(-0.8, -0.8, -0.5, 0, - 0.5);
          // pieSeries.slices.template.fillModifier = rgm;
          // pieSeries.slices.template.strokeModifier = rgm;
          // pieSeries.slices.template.strokeOpacity = 0.4;
          // pieSeries.slices.template.strokeWidth = 0;

          // chart.legend = new am4charts.Legend();
          // chart.legend.position = "right";
          // chart.legend.valueLabels.template.text = "{pie_count}";

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

<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv10", am4charts.XYChart3D);

// Add data
chart.data = [{
  "country": "USA",
  "visits": 4025
}, {
  "country": "China",
  "visits": 1882
}, {
  "country": "Japan",
  "visits": 1809
}, {
  "country": "Germany",
  "visits": 1322
}, {
  "country": "UK",
  "visits": 1122
}];

// Create axes
let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.renderer.labels.template.hideOversized = false;
categoryAxis.renderer.minGridDistance = 20;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.tooltip.label.rotation = 270;
categoryAxis.tooltip.label.horizontalCenter = "right";
categoryAxis.tooltip.label.verticalCenter = "middle";

let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Countries";
valueAxis.title.fontWeight = "bold";

// Create series
var series = chart.series.push(new am4charts.ColumnSeries3D());
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";
series.name = "Visits";
series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;
columnTemplate.stroke = am4core.color("#FFFFFF");

columnTemplate.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
})

columnTemplate.adapter.add("stroke", function(stroke, target) {
  return chart.colors.getIndex(target.dataItem.index);
})

chart.cursor = new am4charts.XYCursor();
chart.cursor.lineX.strokeOpacity = 0;
chart.cursor.lineY.strokeOpacity = 0;

}); // end am4core.ready()
</script>
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartdiv11", am4charts.PieChart);
chart.hiddenState.properties.opacity = 0; // this creates initial fade-in

chart.data = [
  {
    country: "Lithuania",
    value: 401
  },
  {
    country: "Czech Republic",
    value: 300
  },
  {
    country: "Ireland",
    value: 200
  },
  {
    country: "Germany",
    value: 165
  },
  {
    country: "Australia",
    value: 139
  }
];
chart.radius = am4core.percent(70);
chart.innerRadius = am4core.percent(40);
chart.startAngle = 180;
chart.endAngle = 360;

var series = chart.series.push(new am4charts.PieSeries());
series.dataFields.value = "value";
series.dataFields.category = "country";

series.slices.template.cornerRadius = 10;
series.slices.template.innerCornerRadius = 7;
series.slices.template.draggable = true;
series.slices.template.inert = true;
series.alignLabels = false;

series.hiddenState.properties.startAngle = 90;
series.hiddenState.properties.endAngle = 90;

// chart.legend = new am4charts.Legend();

}); // end am4core.ready()
</script>
<script type="text/javascript">
  $(function(){
    search();
    $('#region_id').trigger('change');
  });
</script>
@endsection