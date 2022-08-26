<?php
// Create image instances

@$folder = $_GET['folder'];

@$image = $_GET['image'];

$imagestring = '../uploads/'.$folder.'/'.$image;

echo $imagestring;

unlink($imagestring);


// imagedestroy($dest);
// imagedestroy($src);
?>