<?php 
header('Content-Type: text/javascript');
include_once('./myheader.php');
$userid = $auth->getUserId();
$userProfile=getUserProfileByID($userid);
$chartdata=getMainChartData($userProfile[0]['userid'],$_GET['deviceid']); 
$channelnames=getMainChartChannelNames($userProfile[0]['userid'],$_GET['deviceid']); 
$timestamprow=sizeof($chartdata)-1;
for($i=1;$i<sizeof($chartdata[0]);$i++){ ?>
data<? echo $i;?>=[
<?
	for($j=0;$j<sizeof($chartdata);$j++){
    	echo "[".($chartdata[$j][0]*1000).",".sprintf("%10.2f",$chartdata[$j][$i])."],\n";
    }
?>
    ];
<?
} 
?>
dataAvgAbs=[
<? 
$eegchnum=8;
for($j=0;$j<sizeof($chartdata);$j++){ 
  	$sumabs=0;
    for($i=1;$i<$eegchnum+1;$i++){
       	$sumabs=$sumabs+$chartdata[$j][$i];
    }
    echo "[".($chartdata[$j][0]*1000).",".sprintf("%10.2f",$sumabs/$eegchnum)."],\n";
} 
?>
   ];

<? for($i=1;$i<sizeof($chartdata[0]);$i++){ ?>
      chart<? echo $i;?>.updateSeries([{name: '<? echo $channelnames[$i];?>', data: data<? echo $i;?> }]);
<? } ?>
chartLine.updateSeries([{data: dataAvgAbs }]);