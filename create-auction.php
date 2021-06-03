<?php
include('dbconnect.inc.php')
 ?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Opret en auktion</title>
    <link rel="stylesheet" href="css/master.css">

  </head>
  <body>
    <p class="formular">
      <form method="POST">
        <p> Opret en ny auktion </p> <br>
        <label for="title">Vælg møbel type </label>  Der skal være en dropdown menu her <br>
        <input type="text" name="start_price" placeholder="Start pris">
        <!-- title i en tabel hvor man selv kan tilføje. skal referer ind til db tabel user_items -->
        <!-- mål skal være description -->


  </body>
</html>
