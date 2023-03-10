<?php 
include_once('./myFunctions_mobileeeg.php');
if($_GET['action']=='adddevice'){
	$newdeviceid=addNewDevice($userProfile[0]['userid'], $_POST['devicemodel'],$_POST['description']);
	$newdeviceProfile=getDeviceProfileByID($newdeviceid);
	if(sizeof($newdeviceProfile)>0){
		$formresponsemessage="<h2>Device Add Successfull</h2>";
		$formresponsemessage.="Device Token: <br>".$newdeviceProfile[0]['devicetoken']."<br><br>";
        $formresponsemessage.="<a href=\"/index.php?show=devicelist\">Return to Devices List</a>";
        include('./form-response1.php'); 
	}
}