<?php 
include_once=('./myFunctions_mobileeeg.php')
$results=checkToken($_GET['token']);
if(sizeof($results)>1){
	$deviceID=$results[0]['deviceid'];
	$deviceModel=$results[0]['model'];
	$patientid=$results[0]['patientid'];
	$metadata=$results[0]['metadata'];

	#token OK, process json
	#$data = $_POST['json'];
	$data=file_get_contents('php://input');
	$samplingfrequency=$_GET['samplingfrequency'];
	$datapoints=$_GET['datapoints'];
	addWaveformData($deviceID,$patientID,$samplingfrequency,$datapoints,$data);

}
#token not OK, do not process json.

?>