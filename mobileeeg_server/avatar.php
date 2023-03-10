<?php
include_once('./myheader.php');
$avatar = new LasseRafn\InitialAvatarGenerator\InitialAvatar();
$image = $avatar->name($_GET['nama'])->generate();

// send HTTP header and output image data
echo $image->stream('jpg', 128);
?>