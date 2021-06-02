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

$db_won_auctions = performQuery("SELECT * FROM bid inner join user_items on user_items.id = bid.item_id where bid.user_id = $userid and bid.winning_bid= 1");
if (mysqli_num_rows($db_won_auctions) > 0 ) {
  while ($won_auctions = mysqli_fetch_assoc($db_won_auctions)) { ?>
    <p> Du har vundet følgende auktion: </p>
    <p>Titel: <?php echo $won_auctions['title']; ?></p>
    <p>Auktionen vundet d.: <?php echo $won_auctions['auc_end'];  ?></p>
    <p>købt for: <?php echo $won_auctions['bid_amount'];  ?></p>
    <?php // I det sidste felt skal der vises hvem sælgeren er ?>
    <p> Købt af: <?php echo $won_auctions[''];  ?></p>

    <?php }
} else {
  // Hvis antallet af rows vi får tilbage fra databasen er mindre end nul har brugeren ikke vundet nogle auktioner
  ?>
  <p><?php echo "You have not won any auctions yet"; ?> </p>
  <?php }


 ?>

  <?php
  include 'templates/footer.php';
   ?>
