<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
 ?>
<h1>Opret ny auktion</h1>
      <form method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Giv din auktion en titel">
        <br>
        <label for="condition">Vælg standen på varen: </label>
        <select name="condition">
          <?php
          $db_cond = performQuery("SELECT * FROM cond");
          while ($cond = mysqli_fetch_assoc($db_cond)) { ?>
            <option value="<?php echo $cond['id'] ?>"><?php echo $cond['name']; ?></option>
      <?php } ?>
        </select>
        <br>
        <label for="what">Venligst vælg hvad du sælger: </label>
        <select name="what">
          <?php $db_category = performQuery("SELECT * FROM categories");
          while ($category = mysqli_fetch_assoc($db_category)) { ?>
            <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
          <?php } ?>
        </select>
        <br>
        <input type="number" name="start_price" placeholder="Startpris">
        <br>
        <textarea name="description" rows="8" cols="80" placeholder="Beskrivelse af vare"></textarea>
        <br>
        <label for="auc_end">Venligst vælg slut dato og tid for auktionen: </label>
        <input type="datetime-local" name="auc_end" placeholder="Auktion slut">
        <br>
        <input type="file" name="image"/>
        <br>
        <button type="submit" name="upload">Opret auktion</button>
      </form>
</div>
      <?php
        if (isset($_POST['title'], $_POST['condition'],$_POST['what'], $_POST['start_price'], $_POST['description'], $_POST['auc_end'], $_FILES['image']))
        {
          $title = $_POST['title'];
          $userid = $_SESSION["userid"];

          $start_price = $_POST['start_price'];
          $description = $_POST['description'];
          $auc_end = $_POST['auc_end'];
          $condition = $_POST['condition'];

          //file upload ?>
          <!-- først defineres hvor vi ønsker filen skal gemmes -->
          <?php
          $target_directory = "uploads/";
          $file_name = basename($_FILES['image']['name']);
          $target_file_location = $target_directory . $file_name;

          //allowed types
          $allow_types = array('jpg','png','jpeg','gif','pdf');
          $file_type = pathinfo($target_file_location, PATHINFO_EXTENSION);
          if (in_array($file_type,$allow_types)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file_location)) {
              $insert_image = performQuery("INSERT INTO user_items(
                title, user_id, start_price, image, description, auc_end, cond_id) VALUES (
                '$title', $userid, $start_price, '$file_name', '$description', '$auc_end', $condition)");
              if ($insert_image) {
                echo "Filen blev uploadet!";
              } else {
                echo "Fil upload fejlet";
              }
            } else {
              echo "Der var et problem med at uploade billedet";
            }
          } else {
            echo "Kun billed filer";
          }



          $what = $_POST['what'];


          $db_data= performQuery("SELECT id FROM user_items where title = '$title' and auc_end = '$auc_end' and start_price = $start_price");
          while ($row = mysqli_fetch_assoc($db_data)) {
            $id = $row['id'];
            performQuery("INSERT INTO tag(item_id, category_id) VALUES ($id, $what)");
          }

        } else {
          echo "Venligst vælg en fil";
        }
       ?>

<?php
include 'templates/footer.php';
?>
