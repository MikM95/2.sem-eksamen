<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
 ?>


<<?php
 $msg ="";

   // hvis upload knap bliver trykket på:
   if (isset($_POST['upload'])) {

     $filename = $_FILES["uploadfile"]["name"];
     $tempname = $_FILES["uploadfile"]["tmp_name"];
          $folder = "image/".$filename;

               //tage al data fra felter i "formen"
               $sql = "INSERT INTO image (filename) VALUES ('$filename')";

               //lave query
               mysqli_query($mysqli, $sql);

               //Flyt det upload billede til mappen: image
               if (move_uploaded_file($tempname, $folder)) {
                   $msg = "Billede tilføjet";
               }else{
                   $msg = "Billede ikke tilføjet";
               }
             }
             $result = mysqli_query($mysqli, "SELECT * FROM image");
            ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Image upload test</title>
    <link rel="stylesheet" href="image.css"/>
  </head>
  <body>
    <div id="content">
        <form method="post" action="" enctype="multipart/form-data">
          <input type="file" name="uploadfile"/>


          <div>
            <button type="submit" name="upload"> Upload billede </button>
          </div>
        </form>
      </div>
  </body>
</html>
