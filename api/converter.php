<?php
// Create image instances

@$folder = $_GET['folder'];

@$image = $_GET['image'];

$targetimagestring = '../uploads/'.$folder.'/'.$image;

$src = imagecreatefromjpeg($targetimagestring);

// Copy
$image_info = getimagesize($targetimagestring);
$width = $image_info[0] / 3;
$height = $image_info[1] / 3;

echo $width;


$src = imagescale($src, $width,$height);

// Output and free from memory
//header('Content-Type: image/jpg');
imagejpeg($src,'../uploads/'.$folder.'/'.str_replace('.jpg','',$image).'_T.jpg');

// imagedestroy($dest);
// imagedestroy($src);
?>