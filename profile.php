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
  <hr>
<?php } ?>


<?php

// echo af egne auktioners data
$db_own_auctions = performQuery("SELECT id, title, created_at, auc_end from user_items where user_id = $userid");
if (mysqli_num_rows($db_own_auctions) > 0) {
  while ($own_auctions = mysqli_fetch_assoc($db_own_auctions)) {
  echo $own_auctions['title'];
  echo $own_auctions['created_at'];
  echo $own_auctions['auc_end'];
?><hr><?php
  //der skal også printes data af hvem der evt har vundet auktionen, og hvad det vindende bud var på
}
} else {
  echo "You have not created any auctions!";
  ?><hr><?php
}

// echo af auktioner du har aktive bud på
// Det er blevet til noget af en smøre - tænker vi tager den sammen senere
// jeg har brugt group by item id fordi jeg kun ønsker at trække den enkelte auktion ud en gang - hvis man kommer i en bud kamp kan man nemt byde mange gange på et produkt - men vi er kun interesseret i at de auktioner man er i kommer ud en gang. Tænker evt at spørge kenneth og det er den bedste måde at gøre det på.

// $db_active_auction_bids = performQuery("SELECT bid.user_id, bid.item_id, MAX(bid.bid_amount), max(bid.bid_at), user_items.title, user_items.user_id, user_items.created_at, user_items.start_price, user_items.auc_end, user_items.title, users.f_name, users.l_name, users.email from bid
// INNER JOIN user_items on user_items.id = bid.item_id
// INNER JOIN users on user_items.user_id = users.id
// WHERE bid.bid_at < user_items.auc_end and bid.user_id = $userid
// GROUP by bid.item_id


$db_active_auction_bids = performQuery("SELECT bid.user_id, bid.item_id, user_items.title, user_items.user_id, user_items.created_at, user_items.start_price, user_items.auc_end, user_items.title, users.f_name, users.l_name, users.email from bid
INNER JOIN user_items on user_items.id = bid.item_id
INNER JOIN users on user_items.user_id = users.id
WHERE bid.bid_at < user_items.auc_end and bid.user_id = $userid
GROUP by bid.item_id");
  if (mysqli_num_rows($db_active_auction_bids) > 0) {
    // code...
    ?> <p>You have active bids on the following auctions: </p>
    <?php
        while($active_auction_bids = mysqli_fetch_assoc($db_active_auction_bids)){ ?>
          <p>Titel: <?php echo $active_auction_bids['title']; ?></p>
          <?php // echo af image ?>
          <p>The start price was: <?php echo $active_auction_bids['start_price'];  ?></p>
          <p>The auction began at: <?php echo $active_auction_bids['created_at'];  ?></p>
          <p>The auction ends at: <?php echo $active_auction_bids['auc_end'] ?></p>
              <?php
              $item_id = $active_auction_bids['item_id'];
              $db_data_bids = performQuery("SELECT bid.bid_amount, bid.bid_at, users.f_name, users.l_name, users.email FROM bid
                INNER JOIN users ON bid.user_id = users.id
                WHERE item_id = $item_id  ORDER BY bid_amount desc limit 1");
                while ($data_bids = mysqli_fetch_assoc($db_data_bids)) { ?>
                  <p>Currently the highest bid is: <?php echo $data_bids['bid_amount'] ?></p>
                  <p>The higheste bid was placed at: <?php echo $data_bids['bid_at'] ?></p>
                  <p>Currently holds the highest bid: <?php echo $data_bids['f_name'] . " " . $data_bids['l_name']; ?></p>
                <?php } ?>

          <p>The seller is: <?php echo $active_auction_bids['f_name'] . " " . $active_auction_bids['l_name'];  ?></p>
          <p>Mail the seller with further questions: <?php echo $active_auction_bids['email'];  ?></p>
          <hr>
    <?php }
  }
  else {
    // code...
    echo "<br> no active bids";
    ?><hr><?php

  }


// Echo af auktioner du har vundet

$db_won_auctions = performQuery("SELECT bid.bid_amount, title, created_at, start_price, image, auc_end, f_name, l_name, email FROM bid
inner join user_items on user_items.id = bid.item_id
INNER JOIN users on user_items.user_id = users.id
where bid.user_id = $userid and bid.winning_bid= 1");
if (mysqli_num_rows($db_won_auctions) > 0 ) { ?>
    <p> Du har vundet følgende auktioner: </p>
    <?php
        while ($won_auctions = mysqli_fetch_assoc($db_won_auctions)) { ?>
        <p>Titel: <?php echo $won_auctions['title']; ?></p>
        <?php // echo af image ?>
        <p>Auktionen vundet d.: <?php echo $won_auctions['auc_end'];  ?></p>
        <p>Auktionens startpris:  <?php echo $won_auctions['start_price'];  ?></p>
        <p>købt for: <?php echo $won_auctions['bid_amount'];  ?></p>
        <p>Købt af: <?php echo $won_auctions['f_name'] . " " . $won_auctions['l_name'];  ?></p>
        <p>Kontakt sælger på: <?php echo $won_auctions['email'];  ?></p>
        <hr>
        <?php }
} else {
  // Hvis antallet af rows vi får tilbage fra databasen er mindre end nul har brugeren ikke vundet nogle auktioner
  ?>
  <p><?php echo "You have not won any auctions yet"; ?> </p>
  <hr>
  <?php }


 ?>

  <?php
  include 'templates/footer.php';
   ?>
