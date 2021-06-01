<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
?>


<?php
  $userid = $_SESSION["userid"];


// echo af profil data
$db_data_profile = performQuery("SELECT username, email, f_name, l_name from users where id= $userid");

while ($profile = mysqli_fetch_assoc($db_data_profile)) { ?>
  <p>Username: <?php echo $profile['username']; ?></p>
  <p>Name: <?php echo $profile['f_name'] . " " . $profile['l_name']; ?></p>
  <p>Email: <?php echo $profile['email']; ?></p>
<?php } ?>


<?php

// echo af egne auktioners data
$db_own_auctions = performQuery("SELECT id, title, created_at, auc_end from user_items where user_id = $userid");
if (mysqli_num_rows($db_own_auctions) > 0) {
  while ($own_auctions = mysqli_fetch_assoc($db_own_auctions)) {
  echo $own_auctions['title'];
  echo $own_auctions['created_at'];
  echo $own_auctions['auc_end'];

  //der skal også printes data af hvem der evt har vundet auktionen, og hvad det vindende bud var på
}
} else {
  echo "You have not created any auctions!";
}

// echo af auktioner du har aktive bud på


// Echo af auktioner du har vundet



if (time() > $row['auc_end']) {
  // code...
  echo "nuværende date er større end slut datoen - auktionen er slut";
}else {
  // code...
  echo "slut datoen er ikke kommet endnu";
}


 ?>

  <?php
  include 'templates/footer.php';
   ?>
