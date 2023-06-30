<?php

// Get the uploaded file
@$file = $_FILES['file']['tmp_name'];

# @$folder = $_POST['folder'];

$folder = 'upload';


if ($file) {
    // Set the upload directory


    $upload_dir = "../uploads/" . $folder . '/';

    // Generate a unique filename for the uploaded file
    @$filename = $_FILES['file']['name'];






    $uploadOk = 1;

    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        echo "Jest obrazek - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Plik nie jest obrazkiem. Mam nadzieję że nie chcesz przesłać jakiegoś syfu";

        $uploadedFileExtension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        $allowedExtensions = array('txt', 'doc', 'docx');

        if (in_array($uploadedFileExtension, $allowedExtensions)) {
            echo 'plik nie jest obrazkiem ale jest bezpieczny';
        } else {
            echo 'plik nie jest bezpeiczny';

            $uploadOk = 0;

        }

    }
    // Set the target path for the uploaded file
    @$target_path = $upload_dir . $filename;



    if($uploadOk) {
        sleep(2);

        // Move the uploaded file to the target path
        if (move_uploaded_file($file, $_SERVER["DOCUMENT_ROOT"].'/uploads/upload/'.$filename )) {
            // File was successfully uploaded
            echo "File uploaded successfully: " . $target_path.$filename;

            $dane = new stdClass();
            $dane->category_id = '1';
            $dane->description = 'fdsa';
            $dane->filename = $filename;


            require_once($_SERVER["DOCUMENT_ROOT"].'/api/add.php');




        } else {
            // Error uploading file
            echo "Error uploading file". $_FILES['file']['error'];
        }



    }
}


?>