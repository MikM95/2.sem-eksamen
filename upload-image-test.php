<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
 ?>


<?php
 $msg ="";

   // hvis upload knap bliver trykket på:
   if (isset($_POST['upload'])) {
     // echo '<pre>';
     // print_r($_FILES);
     // print_r($_FILES['uploadfile']);
     // echo '</pre>';
     $from = $_FILES['uploadfile']['tmp_name'];
     $to = $_FILES["uploadfile"]["name"];
     print_r($to);


          //$_FILES gør at man kan vælge en fil
          // $tempname bruges til copy af original-navnet, som en temp navn hvor billede bliver stored efter ipload
           // $folder definere vejen for billede ind i databasen til den mappe man vil have det gemt
           // $filename bruges til at hente eller uploade billeder

               //tage al data fra felter i "formen"
               $sql = "INSERT INTO image (filename) VALUES ('$to')";

               //lave query
               mysqli_query($mysqli, $sql);
               $last_id = mysqli_insert_id($mysqli);
               //det er det sidste billede om man selv arbejder med og ikke en tilfældig har har lagt noget i db
               //print_r($last_id);

               //Flyt det upload billede til mappen: image
               if (move_uploaded_file(dirname(__FILE__) . '\\uploads\\' . $from, $to))
               {
                   $msg = "Billede tilføjet";
               }else{
                   $msg = "Billede ikke tilføjet";
               }

               $result = mysqli_query($mysqli, "SELECT * FROM image WHERE id = $last_id");
               $test = mysqli_fetch_assoc($result);
               // print_r($test);
               echo '<img src="uploads/'.$test['filename'].'">';
             }


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
          <!-- enctype=... bruges til at kode filer og tillader at man kan sende gennem POST -->
          <input type="file" name="uploadfile"/>


          <div>
            <button type="submit" name="upload"> Upload billede </button>
          </div>
        </form>
      </div>
  </body>
</html>
