<?php
include_once('./myheader.php');

if (!$auth->isLoggedIn()) {
    if($_GET['action']=='register'){
    	include('./register.php');
    } 
    elseif($_GET['action']=='doregister') {
    	$results=processUserRegistration($auth);
    	if($results['status']){
            #sendConfirmationEmail($results['email'], $results['url']);
    		$formresponsemessage="<h2>Registration Success!</h2>";
            #$formresponsemessage.="We've sent a confirmation email to your email address.<br>Please click the confirmation link in that email<br>to complete your registration<br>";
            $formresponsemessage.="<a href=\"/index.php?action=login\">Continue to Login Page</a>";

    		include('./form-response1.php');
    	}else {
    		$formresponsemessage="<h2>Registration Failed</h2>Error: ".$results['message']."<br><a href=\"javascript:history.back()\">Go Back</a>";
    		include('./form-response1.php');
    	}
    } 
    elseif($_GET['action']=='dologin'){
    	$results=processUserLogin($auth);
    	if($results['status']){
            header('Location: '.$myvars['baseurl']);
    		
    	} else {
    		$formresponsemessage="<h2>Login Failed</h2>Error: ".$results['message']."<br><a href=\"javascript:history.back()\">Go Back</a>";
    		include('./form-response1.php');    		
    	}
    } 
    elseif($_GET['action']=='verifyemail'){
        $results=verifyConfirmationLink($auth);
        if($results['status']){
            #include('./mainpage.php');
            include('./reset-password.php'); 
        } else {
            $formresponsemessage="<h2>Verification Failed</h2>Error: ".$results['message']."<br>";
            $formresponsemessage.="<a href=\"/index.php?action=login\">Continue to Login Page</a>";
            include('./form-response1.php');            
        }
    }


    else {
    	include('./login.php');
    }
} else {
   if($_GET['action']=='logout'){
      $auth->logOut();
      $auth->destroySession();
      header('Location: '.$myvars['baseurl']);

   } else {
      #get user profile data.
      $userid = $auth->getUserId();
      $userProfile=getUserProfileByID($userid);
      include('./mainpage.php'); 
   }
}
?>