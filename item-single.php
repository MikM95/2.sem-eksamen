<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
$item_id = $_GET['item_id'];
?>

<?php
$db_data_item_single = performQuery("SELECT title, users.f_name, users.l_name, created_at, start_price, image, description, auc_end, bid.bid_amount from user_items inner join users on user_items.user_id = users.id inner join bid on bid.item_id = user_items.id where user_items.id=$item_id order by bid_amount desc limit 1");
while ($row = mysqli_fetch_assoc($db_data_item_single)) { ?>
  <p>Auktion for: <?php echo $row['title']; ?></p>
  <p>Sælger: <?php echo $row['f_name'] . " " . $row['l_name']; ?></p>
  <p>Auktionen startede d.: <?php echo $row['created_at']; ?></p>
  <p>Nuværende højeste bud: <?php echo $row['bid_amount']; ?></p>
  <?php
    print_r($_POST['bid']);
    $end_of_auction = strtotime($row['auc_end']);
    $sec_left = $end_of_auction - time();
    $days_left = floor($sec_left / (60*60*24));
    $hours_left_minus_days = floor(($sec_left - ($days_left * (60*60*24))) / (60*60));
    $min_left_minus_days_and_hours = floor(($sec_left - $hours_left_minus_days * (60*60)-$days_left * (60*60*24)) / 60);
    $sec_left_minus_everything = floor($sec_left - ($min_left_minus_days_and_hours * 60) - ($hours_left_minus_days * 60*60) - ($days_left * 60*60*24));
  ?>
  <p>Auktionen slutter om: <?php echo $days_left; ?> dage, <?php echo $hours_left_minus_days; ?> timer, <?php echo $min_left_minus_days_and_hours; ?> minutter og <?php echo $sec_left_minus_everything; ?> sekunder! </p>
  <p>Beskrivelse af produktet: <?php echo $row['description']; ?></p>

<?php } ?>

<form method="post">
  <input type="number" name="bid" placeholder="">
  <button type="submit">Afgiv bud</button>
</form>

<?php if(isset($_POST['bid']) and $_POST['bid'] > $row['bid_amount']){
  $bid = $_POST['bid'];
  performQuery("INSERT INTO bid(user_id, item_id, bid_amount) VALUES (1, $item_id,$bid)");
} else {
  echo "Dit bud skal være over det nuværende højeste bud";
}?>


 <?php
 include 'templates/footer.php';
  ?>
