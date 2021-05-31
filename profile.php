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
$db_own_auctions = performQuery("SELECT id, title, created_at, auc_end from user_items where user_id = $userid");
while ($own_auctions = mysqli_fetch_assoc($db_own_auctions)) {
  print_r($db_own_auctions);
  if(empty($db_own_auctions)) {
    echo "You have not created any auctions!";
  }else {
  echo "Virker ikke";
//
  //   echo $own_auctions['title'];
  //   echo $own_auctions['created_at'];
  //   echo $own_auctions['auc_end'];
//}

}
}


 ?>

  <?php
  include 'templates/footer.php';
   ?>
