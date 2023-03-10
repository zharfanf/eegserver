<?php 
include_once('./myheader.php');
#error_reporting(E_NONE);
ini_set('display_errors', '0');
$json = file_get_contents('php://input');
$data = json_decode($json,true);
$apikey=$data["apikey"];
if(strlen(trim($apikey))>0){
	$deviceinfo=getDeviceByToken($apikey);
	print_r($deviceinfo);
	$deviceid=$deviceinfo['deviceid'];
	$deviceownerid=$deviceinfo['ownerid'];
	$devicemodelid=$deviceinfo['modelid'];
	$patientid=$deviceinfo['patientid'];
	$samplingfrequency=$data["samplingfreq"];
	$datapoints=$data["datapoints"];
	$channelnames=json_encode(explode(";",getDeviceModelById($devicemodelid)['channelnames']));

	$starttimestamp=$data["starttimestamp"];
	$endtimestamp=$data["endtimestamp"];
	$waveformdata=json_encode($data["waveformdata"]);
	addWaveformData($deviceid,$deviceownerid,$patientid,$devicemodelid,$starttimestamp,$endtimestamp,$samplingfrequency,$datapoints,$channelnames,$waveformdata);
	#insert waveform
}

?>