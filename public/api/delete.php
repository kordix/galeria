    <?php
// Create image instances

@$folder = $_GET['folder'];
@$image = $_GET['image'];
$imagestring = str_replace('\\','/',$_SERVER["DOCUMENT_ROOT"].'/uploads/upload/'.$image);
echo $imagestring;
unlink(str_replace('\\', '/', $imagestring));



require_once($_SERVER["DOCUMENT_ROOT"].'/api/db.php');


try {
    $sth = $dbh->prepare("delete from files where filename = ?");
} catch(Exception $e) {
    echo $e->getMessage();
    return http_response_code(500);
} finally {
    $sth->execute([$image]);
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($rows);
}




// imagedestroy($dest);
// imagedestroy($src);
?>