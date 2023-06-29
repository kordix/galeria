<?php
if($_SERVER['REQUEST_METHOD'] != 'POST') {
 //   return;
}


require_once('db.php');


$dane = new stdClass();
$dane->category_id = '1';
$dane->description = 'fdsa';
$dane->filename = 'test.txt';

$kwerenda='';
$kolumnystring = '';
$wartosci = [];


$allowed = ['category_id' , 'description','filename'];

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


    $query = "INSERT INTO files ($kolumnystring ) values ($pytajniki) ";
    $sth = $dbh->prepare($query);
    $sth->execute($wartosci);

    $announceid = $dbh->lastInsertId();
?>



