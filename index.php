<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
?>
<div class="index-layout">
<aside class="flex-child-aside">
aside
</aside>
<main class="flex-child-main">
<?php $db_data = performQuery("SELECT id, name, image, auc_end FROM user_items");
while($output_data = mysqli_fetch_assoc($db_data)) { ?>
  <a href="item-single.php?item_id=<?php echo $output_data['id'];?>">
    <div class="flex_child_of_child">
      <p class="bold-big-text"><?php echo $output_data['name']; ?></p>
      <p>Slutter d.:<?php echo $output_data['auc_end']; ?> </p>
        <?php
        $item_id = $output_data['id'];
        $db_bid_data = performQuery("SELECT bid_amount FROM bid WHERE item_id =$item_id ORDER BY bid_amount desc limit 1");
        while($new = mysqli_fetch_assoc($db_bid_data)) { ?>
        <p>Højeste bud: <?php echo $new['bid_amount']; ?> </p>
      <?php } ?>


    </div>
    </a>
<?php } ?>



</main>

</div>
 <?php
 include 'templates/footer.php';
  ?>
