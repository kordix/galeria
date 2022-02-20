<?php

require 'env.php';

@$folder = $_GET['folder'];

$base =  realpath('');
$dir    = $base.$ukosnik.'uploads';

if (isset($folder)){
    $dir .= $ukosnik;
    $dir .= $folder;
}

$files1 = scandir($dir);
// $files2 = scandir($dir, 1);

echo json_encode($files1);
// print_r($files2);
?>