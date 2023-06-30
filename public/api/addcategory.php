<?php
require_once($_SERVER["DOCUMENT_ROOT"].'/api/db.php');


$dane = json_decode(file_get_contents('php://input'));


$kwerenda='';
$kolumnystring = '';
$wartosci = [];


$allowed = ['description' , 'title'];

$pytajniki = '';

foreach ($allowed as $key) {
    if (property_exists($dane, $key) && $key != "id") {
        $kolumnystring .= '`'.$key.'`';
        $kolumnystring .= ',';
        $pytajniki .= '?';
        $pytajniki .= ',';
        array_push($wartosci, $dane->$key);
    }
}


    $kolumnystring = substr($kolumnystring, 0, -1);
    $pytajniki = substr($pytajniki, 0, -1);


    $query = "INSERT INTO categories ($kolumnystring ) values ($pytajniki) ";
    $sth = $dbh->prepare($query);
    $sth->execute($wartosci);

?>



