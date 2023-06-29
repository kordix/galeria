<?php


return;
// Create image instances

@$folder = $_GET['folder'];

@$image = $_GET['nazwa'];

@$newimage = $_GET['nazwa2'];

$imagestring = '../uploads/'.$folder.'/'.$image;
$targetimagestring = '../uploads/'.$folder.'/'.$newimage;



rename($imagestring,$targetimagestring);


// imagedestroy($dest);
// imagedestroy($src);
?>