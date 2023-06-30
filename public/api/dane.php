<?php

require_once($_SERVER["DOCUMENT_ROOT"].'/api/db.php');


try {
    $sth = $dbh->prepare("SELECT * from files");
} catch(Exception $e) {
    echo $e->getMessage();
    return http_response_code(500);
} finally {
    $sth->execute();
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);
}



?>


