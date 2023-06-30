<?php
session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST') {
    return;
}

if (!isset($_SESSION['zalogowany'])) {
    //return;
}

require_once($_SERVER["DOCUMENT_ROOT"].'/api/db.php');



$allowed = ['category_id','description','title'];

//replace
$dane = json_decode(file_get_contents('php://input'));

$params = [];
$params['id'] = $dane->id;
print_r($params);

//


$setStr = "";
foreach ($allowed as $key) {
    if (property_exists($dane, $key) && $key != "id" && $key != "token") {
        $setStr .= "`".str_replace("`", "``", $key)."` = :".$key.",";
        $params[$key] = $dane->$key;
    }
}
$setStr = rtrim($setStr, ",");


echo $setStr;

$query = "UPDATE files SET $setStr WHERE id = :id";

echo $query;
$sth = $dbh->prepare($query)->execute($params);


?>



