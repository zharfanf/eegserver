<?php 
include_once('myheader.php');
$chartdata=getMainChartData($userProfile[0]['userid'],$_GET['deviceid'],-1); 
$channelnames=getMainChartChannelNames($userProfile[0]['userid'],$_GET['deviceid'],-1); 
$totaldatasegments=getTotalDataSegments($userProfile[0]['userid'],$_GET['deviceid']);
?>

    <style>
      
    #wrapper {
      padding-top: 1px;
      padding-left: 1px;
      background: #fff;
      border: 1px solid #ddd;
      box-shadow: 0 0px 0px 0px rgba(0, 0, 0, 0.1);
      max-width: 90%;
      margin: 0px auto;
    }
    
    #chart-line {
    position: relative;
    margin-top: 0px;
    padding-top: 0px; 
    padding-bottom: 0px;
    margin-top: 0px;
    margin-bottom:0px;

    }
    .table {
    display: table;
    width: 100%;
    border: 0px solid gray;
    padding-top: 0px; 
    padding-bottom: 0px;
    margin-top:-30px;
    margin-bottom:0px;
    }

    .table-cell {
    display: table-cell;
    max-width: 0;
    border: 0px solid gray;
    padding-top: 0px; 
    padding-bottom: 0px;
    margin-top:-30px;
    margin-bottom:0px;
    }
    .float {
    float: left;
    width: 10px;
    height: 10px;
    z-index: 1;
    position: absolute; 
    top: 0; 
    left: 0;
    }
    .myChart {

    }

    </style>

    <script>
      window.Promise ||
        document.write(
          '<script src="https://cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.min.js"><\/script>'
        )
      window.Promise ||
        document.write(
          '<script src="https://cdn.jsdelivr.net/npm/eligrey-classlist-js-polyfill@1.2.20171210/classList.min.js"><\/script>'
        )
      window.Promise ||
        document.write(
          '<script src="https://cdn.jsdelivr.net/npm/findindex_polyfill_mdn"><\/script>'
        )
    </script>

    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <div id="wrapper">
        <div id="slider-nav" class="ui-widget">
        <center>
        <input class="ui-slider ui-widget ui-corner-all" id="slider" type="range" min="1" max="<? echo $totaldatasegments;?>" value="<? echo ($totaldatasegments-1);?>"  style="width: 85%;">
        <button class="ui-button ui-widget ui-corner-all" onclick='updateMyChart(document.getElementById("slider").value)'>Update</button>
        <p>
            Showing data from <span id="data-from"></span> to <span id="data-to"></span>
        </p>
        </center>
        </div>
        <!-- <p id="rangeValue"><? echo $totaldatasegments;?></p> -->
        <div id="chart-line" ></div>
        <? for($i=1;$i<sizeof($chartdata[0]);$i++){ ?>
        <? if($i %2==1){ ?>
        <div class="table">
        <? } ?>
        <div class="table-cell"  id="chart-ch<? echo $i;?>" ></div>

        <? if($i %2==0){ ?>
        </div>
        <? } ?>        
        <? } ?>
    </div>
    <script>
        var cellHeight=110;
        <? for($i=1;$i<sizeof($chartdata[0]);$i++){ ?>
        
        var options<? echo $i;?> = {
          series: [],
          chart: {
          id: 'chart-ch<? echo $i;?>',
          group: 'mychart',
          type: 'line',
          height: cellHeight,
          toolbar: {
            autoSelected: 'pan',
            show: false
          }
        },
        colors: ['#546E7A'],
        stroke: {
          width: 3
        },
        dataLabels: {
          enabled: false,
        },
        fill: {
          opacity: 1,
        },
        markers: {
          size: 0
        },
        xaxis: {
          show: true,
          type: 'datetime',
          datetimeFormatter: {
              year: 'yyyy',
              month: "MMM 'yy",
              day: 'dd MMM',
              hour: 'HH:mm'
          }
        },
        yaxis: {
            show: true,
            seriesName: '<? echo $channelnames[$i];?>',
            forceNiceScale: true,
            floating: true,
            labels: {
                show: false,
                align: 'left'
            },
            title: {
                text: '<? echo $channelnames[$i];?>',
                rotate: 0,
                offsetX: 40,
                offsetY: -20,
                style: {
                    color: '#008FFB'
                },
            },
        },
        tooltip: {
            x: {
                show: false,
                format: ''
            }
        },
        grid: {
            padding: {
            left: 5,
            right: 5,
            top: 0,
            bottom:0
            }

        }
        };
        
        var chart<? echo $i;?> = new ApexCharts(document.querySelector("#chart-ch<? echo $i;?>"), options<? echo $i;?>);
        chart<? echo $i;?>.render();
      <? } ?>

        var optionsLine = {
          series: [],
          chart: {
          id: 'chart1',
          height: 110,
          type: 'area',
          brush:{
            targets: ['chart-ch1'<? for($i=2;$i<sizeof($chartdata[0]);$i++){echo ",'chart-ch".$i."'";}?> ],
            autoScaleYaxis: false,
            enabled: true
          },
          selection: {
            enabled: true,
            
          },
        },
        colors: ['#008FFB'],
        fill: {
          type: 'gradient',
          gradient: {
            opacityFrom: 0.91,
            opacityTo: 0.1,
          }
        },
        xaxis: {
          show: true,
          type: 'datetime',
          datetimeFormatter: {
              year: 'yyyy',
              month: "MMM 'yy",
              day: 'dd MMM',
              hour: 'HH:mm'
          }
        },
        yaxis: {
          show: false
        },
        grid: {
            padding: {
            left: 10,
            right: 10,
            top: 0,
            bottom:0
            }

        }
        };

        var chartLine = new ApexCharts(document.querySelector("#chart-line"), optionsLine);
        chartLine.render();

    </script>
    <!-- <script src="/getchartdata.php?deviceid=<? echo $_GET['deviceid'];?>"></script> -->
    <script src="vendor/jquery-3.2.1.min.js"></script>
    <script>
    

    function updateMyChart(){
    pos=document.querySelector("#slider").value-1;
    var url0 = 'https://mobileeeg.yzd.my.id/getchartdata2.php?deviceid=<? echo $_GET['deviceid'];?>&pos=';
    var url=url0.concat(pos);
    console.log(url);
    $.ajax({
        url: url, 
        type: 'GET',
        success: function(response) {
            dataAll=JSON.parse(response);
            //console.log(JSON.stringify(dataAll[0]));
            <? 
            for($i=1;$i<sizeof($chartdata[0]);$i++){ 
            ?>
                chart<? echo $i;?>.updateSeries([{name: '<? echo $channelnames[$i];?>', data: dataAll[<? echo ($i-1);?>]}]);
            <?
            }
        ?>
            chartLine.updateSeries([{data: dataAll[<? echo (sizeof($chartdata[0])-1);?>]}]);
            var startTime=new Date(dataAll[0][0][0]).toISOString().slice(0, 19).replace('T', ' ');
            var endTime=new Date(dataAll[0][dataAll[0].length-1][0]).toISOString().slice(0, 19).replace('T', ' ');
            document.querySelector("#data-from").innerText=startTime;
            document.querySelector("#data-to").innerText=endTime;
        }
    });
    }
    $(window).on('load', function() {
        updateMyChart();
    })


    </script>
