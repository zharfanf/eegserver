<?php 
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);  
include_once('./myvars.php');
include_once('./myFunctions_mobileeeg.php');

function processUserRegistration($auth){
	$results['status']=False;
	$results['message']='unknown error';
	$val1='';
	$val2='';
	try {
	    $userId = $auth->register($_POST['email'], $_POST['password'], null);
	    addNewUser($userId, $_POST['nama']);
	    $results['status']=True;
		$results['message']='registration success';
	}
	catch (\Delight\Auth\InvalidEmailException $e) {
		$results['status']=False;
		$results['message']='Invalid email address';
	}
	catch (\Delight\Auth\InvalidPasswordException $e) {
		$results['status']=False;
		$results['message']='Invalid password';
	}
	catch (\Delight\Auth\UserAlreadyExistsException $e) {
		$results['status']=False;
		$results['message']='User already exists';
	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
		$results['status']=False;
		$results['message']='Too many requests';
	}
	return $results;
}
function processUserRegistrationwEmailVerification($auth){
	$results['status']=False;
	$results['message']='unknown error';
	try {
	    $userId = $auth->register($_POST['email'], $_POST['password'], null, function ($selector, $token) use (&$results){
	        #echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email)';
	       	$results['status']=True;
			$results['url']='selector='. \urlencode($selector) . '&token=' . \urlencode($token);
			$results['email']=$_POST['email'];
	    });
	}
	catch (\Delight\Auth\InvalidEmailException $e) {
		$results['status']=False;
		$results['message']='Invalid email address';
	}
	catch (\Delight\Auth\InvalidPasswordException $e) {
		$results['status']=False;
		$results['message']='Invalid password';
	}
	catch (\Delight\Auth\UserAlreadyExistsException $e) {
		$results['status']=False;
		$results['message']='User already exists';
	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
		$results['status']=False;
		$results['message']='Too many requests';
	}
	return $results;
}
function sendConfirmationEmail($address, $url){
	$str="";
	$to = $address;
	$subject = "[mobileEEG] Verify your email address";
	$txt="Hi,\n\n";
	$txt.="Please click in the link below to complete your user registration in mobileEEG.\n\n";
	$txt.=$myvars['baseurl']."/index.php?action=verifyemail&".$url."\n\n";
	$txt.="If you do not remember ever registered at mobileEEG, just ignore this message.\n\n";
	$txt.="Thanks.\n";
	$headers = "From: noreply@mobileeeg.yzd.my.id" . "\r\n";

	mail($to,$subject,$txt,$headers);
}
function processUserLogin($auth){
	$results['status']=False;
	$results['message']='unknown error';
	try {
    $auth->login($_POST['email'], $_POST['password']);
	$results['status']=True;
	$results['message']='Login Success';
	}
	catch (\Delight\Auth\InvalidEmailException $e) {
	    $results['message']='Wrong email address';
	}
	catch (\Delight\Auth\InvalidPasswordException $e) {
	    $results['message']='Wrong password';
	}
	catch (\Delight\Auth\EmailNotVerifiedException $e) {
		$results['message']='Email not verified';

	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
		$results['message']='Too many requests';
	}
	return $results;
}
function verifyConfirmationLink($auth){
	$results['status']=False;
	$results['message']='unknown error';
	try {
    $auth->canResetPasswordOrThrow(\urldecode($_GET['selector']), \urldecode($_GET['token']));
    	$results['status']=True;
    	$results['token']=$_GET['token'];
    	$results['selector']=$_GET['selector'];
	}
	catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    	$results['message']='Invalid token';
	}
	catch (\Delight\Auth\TokenExpiredException $e) {
    	$results['message']='Token expired';
	}
	catch (\Delight\Auth\ResetDisabledException $e) {
    	$results['message']='Password reset is disabled';
	}
	catch (\Delight\Auth\TooManyRequestsException $e) {
    	$results['message']='Too many requests';
	}
	return $results;
}

function processDeleteDevice($auth){
	$results['status']=False;
	$results['message']='unknown error';
	$deviceProfile=getDeviceProfileByID($_POST['deviceid']);
    if($auth->getEmail()==$_POST['email'] && $auth->getUserId()==$deviceProfile[0]['ownerid']){
		deleteDeviceByID($_POST['deviceid']);	
		$results['status']=True;
	}
	elseif($auth->getEmail()!=$_POST['email']){
		$results['message']='Wrong Email';
	}
	elseif($auth->getUserId()!=$deviceProfile[0]['ownerid']){
		$results['message']='Operation not allowed.';
	}
	return($results);
}
function processEditDeviceInfo($auth)
{
	$results['status']=False;
	$results['message']='unknown error';
	$deviceProfile=getDeviceProfileByID($_POST['deviceid']);
	#print_r($deviceProfile);
    if($auth->getEmail()==$_POST['email'] && $auth->getUserId()==$deviceProfile[0]['ownerid']){
		updateDeviceInfoByID($deviceProfile[0]['ownerid'],$_POST['deviceid'],$_POST['modelid'],$_POST['shortname'],$_POST['description'],$_POST['patientid']);	
		$results['status']=True;
		$results['message']='auth ok';

	}
	elseif($auth->getEmail()!=$_POST['email']){
		$results['message']='Wrong Email';
	}
	elseif($auth->getUserId()!=$deviceProfile[0]['ownerid']){
		$results['message']='Operation not allowed.';
	}
	return($results);
}