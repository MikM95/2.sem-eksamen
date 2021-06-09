<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
 ?>
<h1>Opret ny auktion</h1>
      <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Give your auction a title">
        <br>
        <label for="condition">Vælg standen på varen: </label>
        <select name="condition">
          <!-- dette har vi tidligere lavet med php men jeg kunne ikke finde ud af kun at få bestemte muligheder ud af databasen - jeg tror måske vi skulle have lavet flere tabeller - tænker at snakke med kenneth -->
          <option value="5">Som ny</option>
          <option value="7">Næsten ny</option>
          <option value="6">Brugt</option>
        </select>
        <br>
        <!-- dette har vi tidligere lavet med php men jeg kunne ikke finde ud af kun at få bestemte muligheder ud af databasen - jeg tror måske vi skulle have lavet flere tabeller - tænker at snakke med kenneth -->
        <label for="what">Venligst vælg hvad du sælger: </label>
        <select name="what">
          <option value="1">Senge</option>
          <option value="2">Møbler</option>
          <option value="3">Opbevaring</option>
          <option value="4">Køkken</option>
          <option value="8">Belysning</option>
          <option value="9">Dekoration</option>
          <option value="10">Andet</option>
        </select>
        <br>
        <input type="number" name="start_price" placeholder="Startpris">
        <br>
        <textarea name="description" rows="8" cols="80" placeholder="Beskrivelse af vare"></textarea>
        <br>
        <label for="auc_end">Venligst vælg slut data og tid for auktionen: </label>
        <input type="datetime-local" name="auc_end" placeholder="Auktion slut">
        <br>
        <input type="file" name="image"/>
        <br>
        <button type="submit" name="upload">Opret auktion</button>
      </form>
</div>



        <!-- title i en tabel hvor man selv kan tilføje. skal referer ind til db tabel user_items -->
        <!-- mål skal være description -->




      <?php
        if (isset($_POST['title'], $_POST['condition'],$_POST['what'], $_POST['start_price'], $_POST['description'], $_POST['auc_end'], $_FILES['image']))
        {
          $title = $_POST['title'];
          $userid = $_SESSION["userid"];

          $start_price = $_POST['start_price'];
          $description = $_POST['description'];
          $auc_end = $_POST['auc_end'];

          // forsøg på file upload ?>
          <!-- først defineres hvor vi ønsker filen skal gemmes -->
          <?php
          $target_directory = "uploads/";
          $file_name = basename($_FILES['image']['name']);
          $target_file_location = $target_directory . $file_name;

          print_r($auc_end);
          ?><br><?php
          print_r($file_name);



          //allowed types
          $allow_types = array('jpg','png','jpeg','gif','pdf');
          $file_type = pathinfo($target_file_location, PATHINFO_EXTENSION);
          if (in_array($file_type,$allow_types)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file_location)) {
              $insert_image = performQuery("INSERT INTO user_items(
                title, user_id, start_price, image, description, auc_end) VALUES (
                '$title', $userid, $start_price, '$file_name', '$description', '$auc_end')");
              if ($insert_image) {
                echo "file has been uploaded";
              } else {
                echo "file upload failed";
              }
            } else {
              echo "there was an error uploading your file";
            }
          } else {
            echo "only image files please";
          }


          $condition = $_POST['condition'];
          $what = $_POST['what'];


          $db_data= performQuery("SELECT id FROM user_items where title = '$title' and auc_end = '$auc_end' and start_price = $start_price");
          while ($row = mysqli_fetch_assoc($db_data)) {
            $id = $row['id'];
            performQuery("INSERT INTO tag(item_id, category_id) VALUES ($id, $condition)");
            performQuery("INSERT INTO tag(item_id, category_id) VALUES ($id, $what)");
          }

        } else {
          echo "please select a file";
        }
       ?>

<?php
include 'templates/footer.php';
?>
