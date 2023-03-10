<?php
function str_starts_with ( $haystack, $needle ) {
  return strpos( $haystack , $needle ) === 0;
}
function connectToDB($host, $user, $password, $dbname){


	$mysqli = new mysqli($host,$user,$password,$dbname);
	// Check connection
	if ($mysqli -> connect_errno) {
  		echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  		exit();
	} else {
		return($mysqli);
	}
}
function closeDB($mysqli){
	close($mysqli);
}

function checkFileUpload($formHandle,$maximumFileSize){
	// Undefined | Multiple Files | $_FILES Corruption Attack
    // If this request falls under any of them, treat it invalid.
    $ret=false;
    if (
        !isset($_FILES[$formHandle]['error']) ||
        is_array($_FILES[$formHandle]['error'])
    ) {
    	$ret=false;
        #throw new RuntimeException('Invalid parameters.');
    }

    // Check $_FILES['upfile']['error'] value.
    switch ($_FILES[$formHandle]['error']) {
        case UPLOAD_ERR_OK:
        	$ret=true;
            break;
        case UPLOAD_ERR_NO_FILE:
        	$ret=false;
            #throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            $ret=false;
            #throw new RuntimeException('Exceeded filesize limit.');
        default:
            $ret=false;
            #throw new RuntimeException('Unknown errors.');
    }

    // You should also check filesize here.
    if ($_FILES[$formHandle]['size'] > $maximumFileSize) {
        $ret=false;
        #throw new RuntimeException('Exceeded filesize limit.');
        
    }

    // DO NOT TRUST $_FILES['upfile']['mime'] VALUE !!
    // Check MIME Type by yourself.
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    if (false === $ext = array_search($finfo->file($_FILES[$formHandle]['tmp_name']),
        array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
        ),
        true
    )) {
        #throw new RuntimeException('Invalid file format.');
        $ret=false;
    }

    // You should name it uniquely.
    // DO NOT USE $_FILES['upfile']['name'] WITHOUT ANY VALIDATION !!
    // On this example, obtain safe unique name from its binary data.
    #if (!move_uploaded_file($_FILES[$formHandle]['tmp_name'],sprintf('./uploads/%s.%s',sha1_file($_FILES['upfile']['tmp_name']),$ext))) {
    #    throw new RuntimeException('Failed to move uploaded file.');
    #}

    #echo 'File is uploaded successfully.';
    return $ret;
}
?>
