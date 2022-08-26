<!DOCTYPE html>
<html>

<head>
  <title>Upload plików</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<style>
  label{
    font-weight:bold;
  }

  .active{
    font-weight:bold;
    border:1px gray solid;
    color: rgba(0,0,0,.7);
  }

</style>
</head>

<body>


<?php require '../navbar.php'; ?> 


  <div class="container mt-2">
    <div>
      <!-- <a href="/" style="margin-right:50px;font-size:20px;text-decoration:none;font-family:arial">Main page</a> -->
      <br><br>
      <form action="/api/upload.php" method="post" enctype="multipart/form-data">
    
        <label for=""> Folder:</label>
        <select name="folder">
          <option value="journeys">Podróże</option>
          <option value="pliki">Pliki</option>
          <option value="various">Różne</option>
          <option value="inne">INNE</option>
        </select>

        <label for="">Nazwa pliku:</label>
        <input type="text" name="filename">

        <label for=""> Dodaj plik:</label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">

      </form>
    </div>
  </div>

  <script>
    document.querySelector('.navbar-nav').querySelector(`a[href="${window.location.pathname}"]`).classList.add('active');
  </script>

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


  if ($imageFileType == 'php'){
    echo 'niedozwolony plik';
    return;
   }


  $nazwapliku = $_POST['filename'];
  if ($nazwapliku == '') {
      $nazwapliku = $_FILES["fileToUpload"]["name"];
  }


  $target_file = $target_dir . $folder . '/'. basename($nazwapliku.'.'.$imageFileType);



  // Check if image file is a actual image or fake image
  if (isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if ($check !== false) {
          echo "Jest obrazek - " . $check["mime"] . ".";
          $uploadOk = 1;
      } else {
          // echo "File is not an image.";
          $uploadOk = 1;
      }
  }

  // Check if file already exists
  if (file_exists($target_file)) {
      echo "JEST JUŻ PLIK O TEJ NAZWIE W TYM FOLDERZE";
      $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 7000000) {
      echo "PLIK JEST ZA DUŻY";
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
      echo "Sorry, plik nie został zuploadowany";
  // if everything is ok, try to upload file
  } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
          echo "Plik " . basename($_FILES["fileToUpload"]["name"]) . " został wrzucony.";
      } else {
          echo "Sory, wystąpił jakiś błąd";
      }
  }

  ?>