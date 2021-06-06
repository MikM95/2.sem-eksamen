<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
 ?>
<h1>Create new auction</h1>
      <form method="POST">
        <input type="text" name="title" placeholder="What are you selling?">
        <br>
        <label for="condition">Please select the condition of the item: </label>
        <select name="condition">

        </select>
        <!-- <label for="title">Vælg møbel type </label>  Der skal være en dropdown menu her <br> -->
        <input  type="hidden" name='created_at'>
        <input type="text" name="start_price" placeholder="Start pris"> <br>

        <input type="file" name='image' value=""/>
          <div>
            <button type="submit" name="upload"> UPLOAD </button>
          </div>

        <input type="text" name="description" placeholder="Beskrivelse af produktet"> <br>

        <!-- Dette er ikke rigtigt endnu -->
        <input type="datetime-local" name="auc_end" placeholder="Auktion slut"> <br>


        <button type="submit" >Opret auktion </button>
        <!-- title i en tabel hvor man selv kan tilføje. skal referer ind til db tabel user_items -->
        <!-- mål skal være description -->
      </form>
      <<?php
        if (isset($_POST['title'], $_POST['created_at'], $_POST['start_price'], $_POST['description'], $_POST['auc_end'] ))
        {
          $title = $_POST['title'];
          $start_price = $_POST['start_price'];
          $description = $_POST['description'];
          $auc_end = $_POST['auc_end'];

          performQuery("INSERT INTO user_items(title, description, start_price, auc_end) VALUES ('$title', '$description', '$start_price', $auc_end)");
        }
       ?>

<?php
include 'templates/footer.php';
?>
