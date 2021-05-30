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
<?php $db_data = performQuery("SELECT id, title, image, auc_end, start_price FROM user_items");
while($output_data = mysqli_fetch_assoc($db_data)) { ?>
  <a href="item-single.php?item_id=<?php echo $output_data['id'];?>">
    <div class="flex_child_of_child">
      <p class="bold-big-text"><?php echo $output_data['title']; ?></p>
      <p>Slutter d.:<?php echo $output_data['auc_end']; ?> </p>
      <p>Startpris: <?php echo $output_data['start_price'];?></p>
      <?php $item_id = $output_data['id'];
      $start_price = $output_data['start_price'];

        $db_bid_data = performQuery("SELECT bid_amount FROM bid WHERE item_id =$item_id ORDER BY bid_amount desc limit 1");

        while($new = mysqli_fetch_assoc($db_bid_data)) { ?>
          <p>Højeste bud: <?php echo $new['bid_amount'];?> </p>

    <?php }?>


<?php //jeg har det problem at siden ikke vil vise startprisen på en vare hvis der ikke er kommet et bud på varen. På vare 2 har jeg lagt et bud ind i databasen som er under startprisen og så virker det. Det er dog ikke meningen at man skal kunne byde under startprisen. En mulig løsning er at lave det sådan at man opretter et bud på startprisen når man sætter en ting til salg, men det giver problemer hvis ingen byder på varen, så vinder man den selv? der må være en smartere måde at lave det på. spørg kenneth tirsdag ?>








    </div>
  </a>
<?php } ?>



</main>

</div>
 <?php
 include 'templates/footer.php';
  ?>
