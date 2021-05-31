<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
?>


<?php
  $userid = $_SESSION["userid"];

$db_data_profile = performQuery("SELECT username, email, f_name, l_name from users where id= $userid");

while ($profile = mysqli_fetch_assoc($db_data_profile)) { ?>
  <p>Username: <?php echo $profile['username']; ?></p>
  <p>Name: <?php echo $profile['f_name'] . " " . $profile['l_name']; ?></p>
  <p>Email: <?php echo $profile['email']; ?></p>


<?php } ?>


  <?php
  include 'templates/footer.php';
   ?>
