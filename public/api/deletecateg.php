    <?php
// Create image instances

@$id = $_GET['id'];

require_once($_SERVER["DOCUMENT_ROOT"].'/api/db.php');

try {
    $sth = $dbh->prepare("delete from categories where id = ?");
} catch(Exception $e) {
    echo $e->getMessage();
    return http_response_code(500);
} finally {
    $sth->execute([$id]);
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);
}




// imagedestroy($dest);
// imagedestroy($src);
?>