<?php 
header('Content-Type: text/javascript');
include_once('./myheader.php');
$userid = $auth->getUserId();
$userProfile=getUserProfileByID($userid);
$chartdata=getMainChartData($userProfile[0]['userid'],$_GET['deviceid'],$_GET['pos']); 
$channelnames=getMainChartChannelNames($userProfile[0]['userid'],$_GET['deviceid'],$_GET['pos']); 
$timestamprow=sizeof($chartdata)-1;
$step=3;
?>
[
<?
for($i=1;$i<sizeof($chartdata[0]);$i++){ 
?>
	[
<?
	for($j=0;$j<sizeof($chartdata);$j=$j+$step){
    	echo "[".($chartdata[$j][0]*1000).",".sprintf("%10.2f",$chartdata[$j][$i])."]";
    	if($j<sizeof($chartdata)-$step){ echo ",";}
    	echo "\n";
    }

?>
    ],
<?


} 
?>
[
<? 
$eegchnum=8;
for($j=0;$j<sizeof($chartdata);$j=$j+$step){ 
  	$sumabs=0;
    for($i=1;$i<$eegchnum+1;$i++){
       	$sumabs=$sumabs+$chartdata[$j][$i];
    }
    echo "[".($chartdata[$j][0]*1000).",".sprintf("%10.2f",$sumabs/$eegchnum)."]";
    if($j<sizeof($chartdata)-$step){ echo ",";}
    echo "\n";
} 
?>
   ]
]

