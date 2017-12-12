<?php if(!$this->session->userdata('user_id'))
  echo "<div style='margin-left:500px; margin-top: 300px;'><h1>Bạn chưa đăng nhập</h1></div>";
  else{
                ?>
<div class="content-wrapper">
  <h3 style="margin-top: -15px; margin-bottom: 10px;">Bảng tổng quan</h3>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <h2 class="box-title">Thống kê tổng quan</h2>
        <div class="card-body">
            <div id="chart" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <h2 class="box-title">Doanh thu theo tháng</h2>
        <div class="card-body">
            <div id="chart1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <h2 class="box-title">Chi phí theo tháng</h2>
        <div class="card-body">
            <div id="chart2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <h2 class="box-title">Lợi nhuận theo tháng</h2>
        <div class="card-body">
            <div id="chart3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php } ?>
<script type="text/javascript">
    $(function () {
    Highcharts.chart('chart1', {
      chart: {
            type: 'spline'
        },
        title: {
            text: 'Doanh thu theo tháng',
        },

        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            }
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Doanh thu'
            },
            plotLines: [{
                value: 0,
                width: 2,
                zIndex: 2,
                label:{text:'0'},
                color: '#808080'
            }]
        },
        tooltip: {
            
            valueSuffix: ' VNĐ',
            crosshairs: true,
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0,
        },
        
        series: [{
            name: 'Doanh thu',
            data: <?php echo $doanhthu ?>
        }],
    });

    Highcharts.chart('chart2', {
      chart: {
            type: 'spline'
        },
        title: {
            text: 'Chi phí theo tháng',
        },

        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            }
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Chi phí'
            },
            plotLines: [{
                value: 0,
                width: 2,
                zIndex: 2,
                label:{text:'0'},
                color: '#808080'
            }]
        },
        tooltip: {
            
            valueSuffix: ' VNĐ',
            crosshairs: true,
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0,
        },
        
        series: [{
            name: 'Chi phí',
            data: <?php echo $chiphi ?>
        }],
    });

    Highcharts.chart('chart3', {
      chart: {
            type: 'spline'
        },
        title: {
            text: 'Lợi nhuận theo tháng',
        },

        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            }
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        yAxis: {
            title: {
                text: 'Lợi nhuận'
            },
            plotLines: [{
                value: 0,
                width: 2,
                zIndex: 2,
                label:{text:'0'},
                color: '#808080'
            }]
        },
        tooltip: {
            
            valueSuffix: ' VNĐ',
            crosshairs: true,
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0,
        },
        
        series: [{
            name: 'Lợi nhuận',
            data: <?php echo $loinhuan ?>
        }],
    });

    Highcharts.chart('chart', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Tổng quan'
    },
    subtitle: {
        text: 'Thống kê theo từng tháng'
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Tiền'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} VNĐ</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Doanh thu',
        data: <?php echo $doanhthu ?>

    }, {
        name: 'Chi phí',
        data: <?php echo $doanhthu ?>

    }, {
        name: 'Lợi nhuận',
        data: <?php echo $doanhthu ?>

    }]
});
  });
</script>