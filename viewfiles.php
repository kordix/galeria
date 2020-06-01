<?php
$base =  realpath('');
$dir    = $base.'/uploads';
$files1 = scandir($dir);
// $files2 = scandir($dir, 1);

echo json_encode($files1);
// print_r($files2);
?>