<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
 ?>
    <p class="formular">
      <form method="POST">
        <p> Opret en ny auktion </p> <br>
        <label for="title">Vælg møbel type </label>  Der skal være en dropdown menu her <br>
        <input type="text" name="start_price" placeholder="Start pris">
        <!-- title i en tabel hvor man selv kan tilføje. skal referer ind til db tabel user_items -->
        <!-- mål skal være description -->


<?php
include 'templates/footer.php';
?>
