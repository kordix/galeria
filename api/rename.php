<?php
// Create image instances

@$folder = $_GET['folder'];

@$image = $_GET['nazwa'];

@$newimage = $_GET['nazwa2'];

$imagestring = '../uploads/'.$folder.'/'.$image.'.jpg';
$targetimagestring = '../uploads/'.$folder.'/'.$newimage.'.jpg';



rename($imagestring,$targetimagestring);


// imagedestroy($dest);
// imagedestroy($src);
?>