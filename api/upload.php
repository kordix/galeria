<!DOCTYPE html>
<html>

<head>
  <title>Upload plików</title>
</head>

<body>



  <div style="display:flex;width:90%;margin:auto">
    <div>
      <a href="/" style="margin-right:50px;font-size:20px;text-decoration:none;font-family:arial">Main page</a>
      <br><br>
      <form action="/api/upload.php" method="post" enctype="multipart/form-data">
    
        <label for="">Folder</label>
        <select name="folder">
          <option value="journeys">Podróże</option>
          <option value="inne">INNE</option>
        </select>

        <label for="">Nazwa pliku</label>
        <input type="text" name="filename">

        Dodaj plik:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">

      </form>
    </div>
  </div>


  <?php
  define('SITE_ROOT', realpath(dirname(__FILE__)));


  include('dir.php');

  @$folder = $_POST['folder'];

 echo @$folder;

if (count($_FILES) == 0) {
    return;
}

   $target_file = $target_dir . $folder . '/'. basename($_FILES["fileToUpload"]["name"]);
   
   $uploadOk = 1;
   $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
   $target_file = $target_dir . $folder . '/'. basename($_POST['filename'].'.'.$imageFileType);



  // Check if image file is a actual image or fake image
  if (isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if ($check !== false) {
          echo "File is an image - " . $check["mime"] . ".";
          $uploadOk = 1;
      } else {
          // echo "File is not an image.";
          $uploadOk = 1;
      }
  }

  // Check if file already exists
  if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 7000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
  }

  // Allow certain file formats
  // if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  // && $imageFileType != "gif" ) {
  //   echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  //   $uploadOk = 0;
  // }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
      } else {
          echo "Sorry, there was an error uploading your file.";
      }
  }

  ?>