<!-- Styles -->
<style>
  #chartdiv {
    width: 100%;
    height: 500px;
  }
  </style>
  
  <!-- Resources -->
  <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
  <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
  
  <!-- Chart code -->
  <script>
  am5.ready(function() {
    var root = am5.Root.new("chartdiv");
    root.setThemes([am5themes_Animated.new(root)]);
    var chart = root.container.children.push(
      am5xy.XYChart.new(root, {
        panX: false,
        panY: false,
        wheelX: "panX",
        wheelY: "zoomX",
        layout: root.verticalLayout
      })
    );
    chart.set(
      "scrollbarX",
      am5.Scrollbar.new(root, {
        orientation: "horizontal"
      })
    );
    
    var data = [
      {
        month: "January",
        money: 10000
      },
      {
        month: "February",
        money: 12000
      },
      {
        month: "March",
        money: 9000
      },
      {
        month: "April",
        money: 5500
      },
      {
        month: "May",
        money: 15000
      },
      {
        month: "June",
        money: 11000
        
      },
      {
        month: "July",
        money: 4900
      },
      {
        month: "August",
        money: 10000
      },
      {
        month: "September",
        money: 6500
      },
      {
        month: "October",
        money: 8900
      },
      {
        month: "November",
        money: 15000
      },
      {
        month: "December",
        money: 14000
      }
    ];
    var xRenderer = am5xy.AxisRendererX.new(root, {});
    var xAxis = chart.xAxes.push(
      am5xy.CategoryAxis.new(root, {
        categoryField: "month",
        renderer: xRenderer,
        tooltip: am5.Tooltip.new(root, {})
      })
    );
    xRenderer.grid.template.setAll({
      location: 1
    })
    
    xAxis.data.setAll(data);
    
    var yAxis = chart.yAxes.push(
      am5xy.ValueAxis.new(root, {
        min: 0,
        extraMax: 0.1,
        renderer: am5xy.AxisRendererY.new(root, {
          strokeOpacity: 0.1
        })
      })
    );
    
    var series2 = chart.series.push(
      am5xy.LineSeries.new(root, {
        name: "Money",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "money",
        categoryXField: "month",
        tooltip: am5.Tooltip.new(root, {
          pointerOrientation: "horizontal",
          labelText: "{name} in {categoryX}: {valueY} {info}"
        })
      })
    );
    
    series2.strokes.template.setAll({
      strokeWidth: 3,
      templateField: "strokeSettings"
    });
    
    
    series2.data.setAll(data);
    
    series2.bullets.push(function() {
      return am5.Bullet.new(root, {
        sprite: am5.Circle.new(root, {
          strokeWidth: 3,
          stroke: series2.get("stroke"),
          radius: 5,
          fill: root.interfaceColors.get("background")
        })
      });
    });
    
    chart.set("cursor", am5xy.XYCursor.new(root, {}));
    var legend = chart.children.push(
      am5.Legend.new(root, {
        centerX: am5.p50,
        x: am5.p50
      })
    );
    legend.data.setAll(chart.series.values);
    chart.appear(1000, 100);
  });
  </script>
  
  <!-- HTML -->
  <div class="container">
    <div class="row">
      {{-- First --}}
      <div class="col-md-4">
        <div id="chartdiv" class="col-md-4">

        </div>
      </div>
    </div>
  </div>