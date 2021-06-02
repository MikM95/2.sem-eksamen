<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
$item_id = $_GET['item_id'];
?>
<!--- echo af standard data om auktionen  -->
<?php
$db_data_item_single = performQuery("SELECT user_items.id, title, users.f_name, users.l_name, created_at, start_price, image, description, auc_end from user_items inner join users on user_items.user_id = users.id where user_items.id=$item_id");
while ($row = mysqli_fetch_assoc($db_data_item_single)) { ?>
  <p>Auktion for: <?php echo $row['title']; ?></p>
  <p>Sælger: <?php echo $row['f_name'] . " " . $row['l_name']; ?></p>
  <p>Auktionen startede d.: <?php echo $row['created_at']; ?></p>
  <p>Start pris: <?php echo $row['start_price']; ?></p>
  <?php
    $end_of_auction = strtotime($row['auc_end']);
    $sec_left = $end_of_auction - time();
    $days_left = floor($sec_left / (60*60*24));
    $hours_left_minus_days = floor(($sec_left - ($days_left * (60*60*24))) / (60*60));
    $min_left_minus_days_and_hours = floor(($sec_left - $hours_left_minus_days * (60*60)-$days_left * (60*60*24)) / 60);
    $sec_left_minus_everything = floor($sec_left - ($min_left_minus_days_and_hours * 60) - ($hours_left_minus_days * 60*60) - ($days_left * 60*60*24));
  ?>
  <p>Beskrivelse af produktet: <?php echo $row['description']; ?></p>

<?php
  if ($sec_left < 0) {
    // Når der er mindre end 0 sekunder af nedtællingen, er det ikke længere muligt at byde på auktionen, derfor skal bud indput feltet ikke vises
    echo "The auction is over, it is no longer possible to bid";
    ?>
    <p>The auction ended at: <?php echo $row['auc_end']; ?></p>

    <!-- echo af det vindende bud + fornavn og efternavn på den person der gav det vindende bud -->

    <?php $db_bid_data = performQuery("SELECT bid_id, bid_amount, winning_bid, users.f_name, users.l_name  FROM bid inner join users on users.id = bid.user_id WHERE item_id =$item_id ORDER BY bid_amount desc limit 1");

    if(mysqli_num_rows($db_bid_data) > 0){
      while($new = mysqli_fetch_assoc($db_bid_data)) { ?>
        <p>This item was sold for: <?php echo $new['bid_amount']; ?></p>
        <p>This auction was won by: <?php echo $new['f_name'] . " " . $new['l_name']; ?></p>

        <?php
  // sætter winnig_bid til true i databasen
        $bid_id = $new['bid_id'];
        // det ville være pænere at sætte $new['bid_id'] direkte i query'en men jeg kan ikke få den til at forstå det, det virker som det ser ud nu
         performQuery("UPDATE bid SET winning_bid = 1 where bid_id = $bid_id");


      }
    }
    else {
      echo "No bids were recieved during the auction.";
    }


  } else {
    // Hvis der er mere end 0 sekunder tilbage skal det stadig være muligt at byde som normalt
    echo "Auktionen er stadig igang";

      ?>

    <!-- nedtællingen til auktionen er slut -->

      <p>Auktionen slutter om: <?php echo $days_left; ?> dage, <?php echo $hours_left_minus_days; ?> timer, <?php echo $min_left_minus_days_and_hours; ?> minutter og <?php echo $sec_left_minus_everything; ?> sekunder! </p>

      <!-- visning af bud felt, hvis man er logget ind -->
      <?php

      if (isset($_SESSION["useruid"])) {
        ?>
        <form method="post">
          <input type="number" name="bid" placeholder="">
          <button type="submit">Afgiv bud</button>
        </form>
        <?php
      }
      else {
        echo "You need to be logged in, to be able to bid on items.";
      }
      ?>

      <!-- select bids -->
      <?php
      $db_bid_data = performQuery("SELECT bid_amount FROM bid WHERE item_id =$item_id");
      if (mysqli_num_rows($db_bid_data) == 0) {
        echo "Der er ingen bud i databasen";
        $db_start_price = performQuery("SELECT start_price from user_items where id = $item_id");
        while ($start_price = mysqli_fetch_assoc($db_start_price)) {
          if (isset($_POST['bid']) and $_POST['bid'] > $start_price['start_price']) {
            $bid = $_POST['bid'];
            $userid = $_SESSION["userid"];
            performQuery("INSERT INTO bid(user_id, item_id, bid_amount) VALUES ($userid, $item_id,$bid)");
          }
          if (isset($_POST['bid']) and $_POST['bid'] < $start_price['start_price']){
              echo "Dit bud skal være over det nuværende højeste bud";
            }
          }
        } else {
          echo "Der er bud i databasen";
          $db_bid_data = performQuery("SELECT bid_amount FROM bid WHERE item_id =$item_id ORDER BY bid_amount desc limit 1");
          while($db_highest_bid = mysqli_fetch_assoc($db_bid_data)) {
            if (isset($_POST['bid']) and $_POST['bid'] > $db_highest_bid['bid_amount']) {
              $bid = $_POST['bid'];
              $userid = $_SESSION["userid"];
              performQuery("INSERT INTO bid(user_id, item_id, bid_amount) VALUES ($userid, $item_id,$bid)");
              //header("location: item-single.php?item_id="echo" $row['id']"; ")
                //mangler en form for refresh
              }
              if (isset($_POST['bid']) and $_POST['bid'] < $db_highest_bid['bid_amount']){
                echo "Dit bud skal være over det nuværende højeste bud";
              }
            }
          }
          ?>
          <!-- echo af højeste bud -->

          <?php $db_bid_data = performQuery("SELECT bid_amount FROM bid WHERE item_id =$item_id ORDER BY bid_amount desc limit 1");

          if(mysqli_num_rows($db_bid_data) > 0){
            while($new = mysqli_fetch_assoc($db_bid_data)) { ?>
              <p>Nuværende højeste bud: <?php echo $new['bid_amount']; ?></p>
              <?php
            }
          }
          else {
            echo "There are no bids on this item.";
          }


  }

  ?>

<?php


}




  ?>




<?php $db_category_data = performQuery("SELECT name FROM categories inner join tag on tag.category_id = categories.id WHERE tag.item_id = $item_id"); ?>
<p>This item is included in the following categories:</p>
<ul>
<?php while ($categories_name = mysqli_fetch_assoc($db_category_data)) { ?>
  <li><?php echo $categories_name['name']; ?></li>
<?php } ?>
</ul>




 <?php
 include 'templates/footer.php';
  ?>
