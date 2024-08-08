@extends('backend.layouts.app')
@section('content')
<style>
  .small-box>.inner {
    padding: 10px;
    color:white;
}
.small-box
{
  margin-bottom:10px;
  padding-bottom: 20px;
}

.bg-info {
    background-color: #3db9dc !important;
}

.bg-warning {
    background-color: #f1b53d !important;
}

.bg-success {
    background-color: #1bb99a !important;
}

.bg-danger {
    background-color: #ff5d48 !important;
}
.small-box .icon {
    color: rgba(0,0,0,.15);
    z-index: 0;
}
.small-box .icon>i {
    font-size: 90px;
    position: absolute;
    right: 15px;
    top: 15px;
    transition: all .3s linear;
}

.card-padding {
  padding:2px;!important;
}
.card-footer-padding {
  padding:3px;!important;
}
.btn-custom {
  background-color:#a1a0a0!important;
  border-color:#a1a0a0!important;
  padding:0;
  width:63px;
}

.card-image {
  width: 100px;
  height: 100px;
}
.modal-backdrop{
  z-index: 999;
}

.modal {
  z-index: 1000;
}
#chartdiv9 {
  width: 100%;
  height: 500px;
}
</style>

<div class="container fullbody">
  {{-- Perpetrator Profile --}}
  <div class="row">
    <div class="col-md-12">
      <div class="card bg-light mb-3">
        <div class="card-header card-footer-padding">
          <div class="row mt-3" style="margin: 0">
            <div class="col-md-8 d-flex align-items-center text-start">
              <p class="mb-0" style="color: gray;font-weight:bold;" id="incident-date-filter">Other violence praevented at community level</p>
            </div>
            <div class="col-md-4 d-flex justify-content-end">
              <p id="other_violence_date_display" class="mb-0 mr-2" style="color: gray;font-weight:bold;">Oct 2021-Current</p>
              <button type="button" id="1" class="btn btn-sm btn-secondary btn-custom" style="" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">
                <img src="{{ asset('images/filter.png') }}" width="20" height="20" alt="Filter icon"> Filter
              </button>
            </div>
          </div>
        </div>
        <br>
        <div class="card-body card-padding">
          <div class="row">
            <div class="col-md-12">
              <div class="tab-content">
                <div class="row">
                  <div id="chartdiv9"></div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


    {{-- First Modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Select Filter Criteria</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="get" action="" id="filterForm">
              <input type="hidden" name="hidden_field" id="hidden_field" value=""/>
              <input type="hidden" name="token" id="token" value="{{ csrf_token() }}"/>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label class="control-label">Zone</label>
                  @if(count(session()->get('userareaaccess.sregions'))>0)
                    <select name="region_id" id="region_id" class="region_id form-control form-control-sm select2">
                        <option value="">Select zone</option>
                        @foreach($regions as $key=>$region)
                        @if(in_array($region->id,session()->get('userareaaccess.sregions')) )
                          <option value="{{$region->id}}">{{$region->region_name}}</option>
                        @endif
                        @endforeach
                    </select>
                  @else
                    <select name="region_id" id="region_id" class="region_id form-control form-control-sm select2">
                        <option value="">Select Zone</option>
                      @foreach($regions as $region)
                      <option value="{{$region->id}}">{{$region->region_name}}</option>
                      @endforeach
                    </select>  
                  @endif
                </div>
                <div class="form-group col-md-4">
                  <label class="control-label">Division</label>
                  <select name="division_id" id="division_id" class="division_id form-control form-control-sm">
                    <option value="">Select Division</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label class="control-label">District</label>
                  <select name="district_id" id="district_id" class="district_id form-control form-control-sm">
                    <option value="">Select District</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label class="control-label">Upazila</label>
                  <select name="upazila_id" id="upazila_id" class="upazila_id form-control form-control-sm">
                    <option value="">Select Upazila</option>
                  </select>
                </div>
                <div class="form-group col-sm-4">
                  <label class="control-label">From Date</label>
                  <input type="text" name="from_date" id="from_date" class="form-control form-control-sm modaldatepicker" placeholder="From Date" autocomplete="off">
                </div>
                <div class="form-group col-sm-4">
                  <label class="control-label">To Date</label>
                  <input type="text" name="to_date" id="to_date" class="form-control form-control-sm modaldatepicker" placeholder="To Date" autocomplete="off">
                </div>
                {{-- <div class="form-group col-sm-4">
                  <!-- <a class="btn btn-sm btn-primary" type="submit" style="margin-top: 29px; color: white">Search</a> -->
                  <button type="submit" class="btn btn-success btn-sm"  style="margin-top: 21px; color: white">Search</button>
                </div> --}}
              </div>
              <div class="modal-footer">
                <a href="#" id="modal_close" class="btn btn-secondary" data-dismiss="modal">Close</a>
                <input type="submit"  class="btn btn-success" value="Search"/>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


<script type="text/javascript">
	$(function(){
		$(document).on('click',function(e){
      console.log(e.target.parentNode.id)
      if(e.target.getAttribute('data-target')==="#exampleModal" || e.target.parentNode.getAttribute('data-target')==="#exampleModal" ){

        console.log(e.target.id);
        document.getElementById('hidden_field').value=(e.target.id=='' ?  e.target.parentNode.id : e.target.id);
      } 
      // var hidden_field= document.getElementById('hidden_field').value);
       
       
			
		});
	});
</script>

<script type="text/javascript">
	$(function(){
		$(document).on('submit',function(e){
      console.log(document.getElementById('hidden_field').value);
      e.preventDefault();
      e.stopPropagation();
      var hidden_field    = $('#hidden_field').val();
			var region_id       = $('#region_id').val();
			var division_id     = $('#division_id').val();
			var district_id     = $('#district_id').val();
			var upazila_id      = $('#upazila_id').val();
			var from_date       = $('#from_date').val();
			var to_date         = $('#to_date').val();
			var token           = $('#token').val();
      // console.log(token);
			$.ajax({
				url : "{{route('filterData')}}",
				type : "POST",
				data :  {
                  token:token,
                  hidden_field:hidden_field,
                  region_id:region_id,
                  division_id:division_id,
                  district_id:district_id,
                  upazila_id:upazila_id,
                  from_date:from_date,
                  to_date:to_date
                },
          success:function(data){
            if (hidden_field == 1) {
              $('#incidentData').text(data);
              if (from_date != '') {
                $('#incident-date-filter').text(from_date +" - "+to_date);
              }
            }
            if (hidden_field == 2) {
              $('#throughAdr').text(data);
              if (from_date != '') {
                $('#through-date-filter').text(from_date +" - "+to_date);
              }
            }
            if (hidden_field == 3) {
              $('#takaAdr').text(data);
              if (from_date != '') {
                $('#adr-date-filter').text(from_date +" - "+to_date);
              }
            }
            if (hidden_field == 4) {
              $('#childMarriagePre').text(data);
              if (from_date != '') {
                $('#pre-date-filter').text(from_date +" - "+to_date);
              }
            }
            if (hidden_field == 5) {
              $('#childMarriage').text(data);
              if (from_date != '') {
                $('#reported-date-filter').text(from_date +" - "+to_date);
              }
            }
            // $('#exampleModal').modal('hide');
            document.getElementById('modal_close').click();
				}
			});
		});
	});
</script>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>

{{-- Defendant Occupation --}}
<script>
  let root = am5.Root.new("chartdiv9");
  let d_previous = null;
</script>
<script>
  $(document).ready(function() {
    
    $("#filterForm").submit(function(event) {
      event.preventDefault();
      event.stopPropagation();

      var region_id       = $('#region_id').val();
      var division_id     = $('#division_id').val();
      var district_id     = $('#district_id').val();
      var upazila_id      = $('#upazila_id').val();
      var from_date       = $('#from_date').val();
      var to_date         = $('#to_date').val();
      var token           = $('#token').val();
      // console.log(region_id);
      $.ajax({
        type: "POST",
        data :  {
                  _token:token,
                  region_id:region_id,
                  division_id:division_id,
                  district_id:district_id,
                  upazila_id:upazila_id,
                  from_date:from_date,
                  to_date:to_date
                },
        url : "{{route('filterCummunityViolence')}}",
        success: function(response) {
          // console.log("Data successfully loaded from URL");
          //console.log(response);
          $('#other_violence_date_display').html(from_date +' - '+ to_date);
          if(d_previous != null){
              d_previous.dispose();
          }

          am5.ready(function() {

            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            root = am5.Root.new("chartdiv9");
            d_previous = root;

            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
              am5themes_Animated.new(root)
            ]);

            // Create chart
            // https://www.amcharts.com/docs/v5/charts/xy-chart/
            var chart = root.container.children.push(
              am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                // wheelX: "panX",
                // wheelY: "zoomX"
              })
            );

            // Add cursor
            // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
            var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
            cursor.lineY.set("visible", false);

            // Create axes
            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });

            var xAxis = chart.xAxes.push(
              am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "country",
                renderer: xRenderer,
                tooltip: am5.Tooltip.new(root, {})
              })
            );

            xAxis.children.push(
              am5.Label.new(root, {
                text: "VAWC Preventive initiative",
                x: am5.p50,
                centerX:am5.p50
              })
            );

            xRenderer.grid.template.setAll({
              location: 1
            })

            var yAxis = chart.yAxes.push(
              am5xy.ValueAxis.new(root, {
                maxDeviation: 0.3,
                renderer: am5xy.AxisRendererY.new(root, {
                  strokeOpacity: 0.1
                })
              })
            );

            yAxis.children.unshift(
              am5.Label.new(root, {
                rotation: -90,
                text: "Total Number",
                y: am5.p50,
                centerX: am5.p50
              })
            );

            // Create series
            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
            var series = chart.series.push(
              am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "value",
                sequencedInterpolation: true,
                categoryXField: "country",
                tooltip: am5.Tooltip.new(root, {
                labelText: "{valueY}"
              })
              })
            );

            series.columns.template.setAll({
              width: am5.percent(120),
              fillOpacity: 0.9,
              strokeOpacity: 0
            });
            series.columns.template.adapters.add("fill", (fill, target) => {
              return chart.get("colors").getIndex(series.columns.indexOf(target));
            });

            series.columns.template.adapters.add("stroke", (stroke, target) => {
              return chart.get("colors").getIndex(series.columns.indexOf(target));
            });

            series.columns.template.set("draw", function(display, target) {
              var w = target.getPrivate("width", 0);
              var h = target.getPrivate("height", 0);
              display.moveTo(0, h);
              display.bezierCurveTo(w / 4, h, w / 4, 0, w / 2, 0);
              display.bezierCurveTo(w - w / 4, 0, w - w / 4, h, w, h);
            });

            // Set data
            var data = response;

            xAxis.data.setAll(data);
            series.data.setAll(data);

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            series.appear(1000);
            chart.appear(1000, 100);

            }); // end am5.ready()
          
          },
        error: function(error) {
          console.log("Error loading data from URL");
          console.log(error);
          }
        });
        document.getElementById('modal_close').click();
    });
  });

</script>

<script>
  $(document).ready(function() {
    $.ajax({
    type: "GET",
    url : "{{route('cummunityViolence')}}",
    success: function(response) {
      // console.log("Data successfully loaded from URL");
      console.log(response);
      am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        // var root = am5.Root.new("chartdiv9");
        d_previous = root;

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
          am5themes_Animated.new(root)
        ]);

        // For Export
        var exporting = am5plugins_exporting.Exporting.new(root, {
          menu: am5plugins_exporting.ExportingMenu.new(root, {})
        });
        exporting.get("menu").set("items", [{
            type: "format",
            format: "png",
            label: "Export image"
          }
        ]);

        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(
          am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            // wheelX: "panX",
            // wheelY: "zoomX"
          })
        );

        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);

        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });

        var xAxis = chart.xAxes.push(
          am5xy.CategoryAxis.new(root, {
            maxDeviation: 0.3,
            categoryField: "country",
            renderer: xRenderer,
            tooltip: am5.Tooltip.new(root, {})
          })
        );

        xAxis.children.push(
          am5.Label.new(root, {
            text: "VAWC Preventive initiative",
            x: am5.p50,
            centerX:am5.p50
          })
        );

        xRenderer.grid.template.setAll({
          location: 1
        })

        var yAxis = chart.yAxes.push(
          am5xy.ValueAxis.new(root, {
            maxDeviation: 0.3,
            renderer: am5xy.AxisRendererY.new(root, {
              strokeOpacity: 0.1
            })
          })
        );

        yAxis.children.unshift(
          am5.Label.new(root, {
            rotation: -90,
            text: "Total Number",
            y: am5.p50,
            centerX: am5.p50
          })
        );

        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(
          am5xy.ColumnSeries.new(root, {
            name: "Series 1",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            sequencedInterpolation: true,
            categoryXField: "country",
            tooltip: am5.Tooltip.new(root, {
            labelText: "{valueY}"
          })
          })
        );

        series.columns.template.setAll({
          width: am5.percent(120),
          fillOpacity: 0.9,
          strokeOpacity: 0
        });
        series.columns.template.adapters.add("fill", (fill, target) => {
          return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        series.columns.template.adapters.add("stroke", (stroke, target) => {
          return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        series.columns.template.set("draw", function(display, target) {
          var w = target.getPrivate("width", 0);
          var h = target.getPrivate("height", 0);
          display.moveTo(0, h);
          display.bezierCurveTo(w / 4, h, w / 4, 0, w / 2, 0);
          display.bezierCurveTo(w - w / 4, 0, w - w / 4, h, w, h);
        });

        // Set data
        var data = response;

        xAxis.data.setAll(data);
        series.data.setAll(data);

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        chart.appear(1000, 100);

        }); // end am5.ready()
      },
    error: function(error) {
      console.log("Error loading data from URL");
      console.log(error);
      }
    });
  });
</script>


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
	$(function(){
		$(document).on('change','#district_id',function(){
			var district_id = $(this).val();
			$.ajax({
				url : "{{route('default.get-region-upazila')}}",
				type : "GET",
				data : {district_id:district_id},
				success:function(data){
          console.log(data);
					var html = '<option value="">Select Upazila</option>';
					$.each(data,function(key,v){
            if (v.setup_user_upazila == undefined) {
              html +='<option value="'+v.id+'">'+v.name+'</option>';
            } else {
              html +='<option value="'+v.setup_user_upazila.id+'">'+v.setup_user_upazila.name+'</option>';
            }
					});
					$('#upazila_id').html(html);
				}
			});
		});
	});
</script>

<script type="text/javascript">
  $(function() {
      $('.modaldatepicker').daterangepicker({
          singleDatePicker: true,
          showDropdowns: true,
          autoUpdateInput: false,
          // drops: "up",
          autoApply:true,
          locale: {
              format: 'DD-MM-YYYY',
              daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
              firstDay: 0
          },
          minDate: '01-01-2000',
          maxDate: new Date(),
      },
      function(start) {
          this.element.val(start.format('DD-MM-YYYY'));
          this.element.parent().parent().removeClass('has-error');
      },
      function(chosen_date) {
          this.element.val(chosen_date.format('DD-MM-YYYY'));
      });

      $('.singledatepicker').on('apply.daterangepicker', function(ev, picker) {
          $(this).val(picker.startDate.format('DD-MM-YYYY'));
      });
  });
</script>
    
@endsection