<?php
#sesuaikan baris 3 dan 4 dengan server yang dipakai
$var_mysqlusername="root";
$var_mysqluserpass="passwordphpmyadmin";
#sesuaikan baris 6 dengan url website yang digunakan
$myvars['baseurl']='http://192.168.1.2/';
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); 

include_once("./myFunctions.php");
function getTotalDataSegments($deviceownerid,$deviceid){
	$sql="SELECT id FROM `waveformdata` WHERE (`deviceid`='".$deviceid."' AND `deviceownerid`='".$deviceownerid."')";
	$rows=runSQLQuery($sql);
	return sizeof($rows);
}	
function getMainChartData($deviceownerid,$deviceid,$pos){
	$data=getDataByOwnerIdDeviceId($deviceownerid,$deviceid,$pos);
	#print_r($data);
	$waveformdata=json_decode($data[0]['data']);
	return $waveformdata;
}
function getMainChartChannelNames($deviceownerid,$deviceid,$pos){
	$data=getDataByOwnerIdDeviceId($deviceownerid,$deviceid,$pos);
	// print_r($data);
	$channelnames=json_decode($data[0]['channelnames']);
	return $channelnames;
}
function getDataByOwnerIdDeviceId($deviceownerid,$deviceid,$pos){
	if($pos<=0){
		$pos=1;
	}
	$sql="SELECT * FROM `waveformdata` WHERE (`deviceid`='".$deviceid."' AND `deviceownerid`='".$deviceownerid."') ORDER BY starttimestamp DESC LIMIT ".$pos.",1;";
	$rows=runSQLQuery($sql);
	return $rows;
}

function getDeviceProfileByShortName($shortname){
	$sql="SELECT * FROM `devices_profile` WHERE `shortname`='".$shortname."';";
	$rows=runSQLQuery($sql);
	return $rows;
}
function getDeviceModelById($modelid){
	$sql="SELECT * FROM `device_models` where `id`='".$modelid."'";
	$rows=runSQLQuery($sql);
	return $rows[0];
}
function getAvailableDeviceModels(){
	$sql="SELECT * FROM `device_models` where `is_available`='1'";
	$rows=runSQLQuery($sql);
	return $rows;
}
function checkToken($token){
	$sql="SELECT * FROM `devices_profile` WHERE `devicetoken`='".$token."';";
	$rows=runSQLQuery($sql);
	return $rows;
}
function addWaveformData($deviceid,$deviceownerid,$patientid,$devicemodelid,$starttimestamp,$endtimestamp,$samplingfreq,$datapoints,$channelnames,$waveformdata){
	$sql="INSERT into waveformdata (deviceid, deviceownerid,patientid,devicemodelid, starttimestamp,endtimestamp,samplingfreq, datapoints, channelnames,data) ";
	$sql.="VALUES ('".$deviceid."','".$deviceownerid."','".$patientid."','".$devicemodelid."','".$starttimestamp."','".$endtimestamp."','".$samplingfreq."','".$datapoints."','".$channelnames."','".$waveformdata."');";
	$rows=runSQLQuery($sql);
	if(sizeof($rows)==0){
		return True;
	} else {
		return False;
	}
}
function connectToDB_this(){
	global $var_mysqlusername, $var_mysqluserpass;
    $host="localhost";
	$user=$var_mysqlusername;
	$password=$var_mysqluserpass;
	$dbname="mobileeeg1_authdb";	
	$conn=connectToDB($host,$user,$password,$dbname);
	return($conn);
}
function deleteDeviceByID($deviceid){
	$sql="DELETE FROM `devices_profile` WHERE `deviceid`='".$deviceid."';";
	$rows=runSQLQuery($sql);
	return $rows;
}
function getDeviceProfileByID($deviceid){
	$sql="SELECT * FROM `devices_profile` WHERE `deviceid`='".$deviceid."';";
	$rows=runSQLQuery($sql);
	return $rows;
}
function getDevicesByOwnerID($ownerid){
	$sql="SELECT * FROM `devices_profile` WHERE `ownerid`='".$ownerid."';";
	$rows=runSQLQuery($sql);
	return $rows;
}

function getDeviceByToken($token){
	$sql="SELECT * FROM `devices_profile` WHERE `devicetoken`='".$token."';";
	$rows=runSQLQuery($sql);
	return $rows[0];
}

function getUserProfileByID($userid){
	$sql="SELECT * FROM `users_profile` WHERE `userid`='".$userid."';";
	$rows=runSQLQuery($sql);
	return $rows;
}

function updateDeviceInfoByID($ownerid,$deviceid, $modelid, $shortname,$description, $patientid){
	$sql="UPDATE `devices_profile` SET `modelid`='".$modelid."',`shortname`='".$shortname."', `description`='".$description."', `patientid`='".$patientid."' WHERE (`deviceid`='".$deviceid."' AND `ownerid`='".$ownerid."');";
	#echo $sql;
	$rows=runSQLQuery($sql);
	echo $sql;
	return True;
}
function getAllProjects(){
	$sql="SELECT * FROM `projects` WHERE 1;";
	$rows=runSQLQuery($sql);
	return $rows;
}
function addNewUser($userid, $nama){
	$sql="INSERT into users_profile (userid, nama) VALUES ('".$userid."','".$nama."');";
	$rows=runSQLQuery($sql);
	if(sizeof($rows)==0){
		return True;
	} else {
		return False;
	}
}
function addNewDevice($userid, $devicemodel,$deviceshortname,$description){
	$devicetoken=bin2hex(random_bytes(16));
	$sql="INSERT into devices_profile (ownerid, modelid, shortname, description, devicetoken) VALUES ('".$userid."','".$devicemodel."','".$deviceshortname."','".$description."','".$devicetoken."');";
	#echo $sql;
	$rows=runSQLQuery($sql);
	return($rows);
}
function runSQLQuery($sql){
	#print($sql);
	$rows=Array();
	$conn=connectToDB_this();
   	$results = mysqli_query($conn, $sql) or die("<b>Error:</b> runSQLQuery <br/>" . mysqli_error($conn));
    if($results){
    	while($row = mysqli_fetch_assoc($results)){
    		$rows[] = $row;
		}
    }
    if(str_starts_with(strtolower($sql), "insert")){
    	$rows=mysqli_insert_id($conn);
    }
    mysqli_free_result($results);
    mysqli_close($conn);
    #print_r($rows);
    return($rows);
}
function getDataByHash($fHash){
	$sql = "SELECT * FROM literatures WHERE(sha256file='{$fHash}');";
	#print($sql);
	$rows=Array();
	$conn=connectToDB_this();
   	$results = mysqli_query($conn, $sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_error($conn));
    if($results){
    	while($row = mysqli_fetch_assoc($results)){
    		$rows[] = $row;
		}
    }
    mysqli_free_result($results);
    mysqli_close($conn);
    #print_r($rows);
    return($rows);
}
function getDataByColumn($tableName,$columnName,$columnData){
	$sql = "SELECT * FROM ".$tableName." WHERE(".$columnName."='{$columnData}');";
	#print($sql);
	$rows=Array();
	$conn=connectToDB_this();
   	$results = mysqli_query($conn, $sql) or die("<b>Error:</b> Problem on Image Insert<br/>" . mysqli_error($conn));
    if($results){
    	while($row = mysqli_fetch_assoc($results)){
    		$rows[] = $row;
		}
    }
    mysqli_free_result($results);
    mysqli_close($conn);
    #print_r($rows);
    return($rows);
}
function uploadPDFToFIle($pdfFileName, $pdfFileTempName){
	$uploadeddir="../uploaded/";
	$fileHash = hash_file("sha256",$pdfFileTempName);
	$rand=rand(00000,99999).time();
	$pdfPath=$uploadeddir.$fileHash.".pdf";
	$tablename="literatures";
	$dbData=getDataByHash($fileHash);
	#print_r($dbData);
	if(sizeof($dbData)==0){
	if(move_uploaded_file($pdfFileTempName, $pdfPath)){
		$conn=connectToDB_this();
		$sql = "INSERT INTO literatures (filename, filepath, sha256file) VALUES('{$pdfFileName}', '{$pdfPath}','{$fileHash}');";
    	#print($sql);
    	$results = mysqli_query($conn, $sql) or die("<b>Error:</b> Problem on Image Insert<br/>" .$sql."<br>". mysqli_error($conn));
    	mysqli_close($conn);
    } else die("<b>Error:</b> Problem on Image Upload<br/>");
	} #else die("<b>Error:</b> File already uploaded<br/>");

    #if (isset($current_id)) {
    #    header("Location: listImages.php");
    #}
    return($fileHash);
}

?>
