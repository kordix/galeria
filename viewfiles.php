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

$files2 = [];

// print_r($files1);
// $files2 = scandir($dir, 1);

for($i=0;$i<count($files1);$i++){
    $pushuj = true;
    $ext = pathinfo($files1[$i], PATHINFO_EXTENSION);
    $tmpstring = str_replace('.'.$ext,'',$files1[$i]);

    if($ext == 'jpg'){

        if(substr($tmpstring, -1) == 'T'){
            $pushuj= true;
        }else{
            $pushuj= false;
        }
    }

    if($pushuj){
        array_push($files2,$files1[$i]);
    }
    
}


echo json_encode($files1);
// print_r($files2);
?>