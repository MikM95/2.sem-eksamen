<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
?>
<div class="index-layout">
<aside class="flex-child-aside">
<p id="aside_title">Kategorier</p>
<ul class="list_style_tpye_aside">
  <?php $db_categories_data = performQuery("SELECT * FROM categories");
  while ($categories = mysqli_fetch_assoc($db_categories_data)) { ?>
  <a href="index.php?category_id=<?php echo $categories['id']; ?> "><li><?php echo $categories['name']; ?>
    (<?php $category_id = $categories['id'];
     $db_amount_tag = performQuery("SELECT * FROM tag where tag.category_id = $category_id"); echo mysqli_num_rows($db_amount_tag); ?>)</li></a>
  <?php } ?>
</ul>
<p id="search_title">Søg på titler</p>
<form method="get" class="search_form">
  <input type="text" name="search" class="search_bar">
  <button type="submit">Søg</button>
</form>
</aside>
<main class="flex-child-main">
<?php
if (isset($_GET['category_id'])) {
  $select_categry = $_GET['category_id'];
  $db_data = performQuery("SELECT user_items.id, title, image, auc_end, start_price, tag.category_id FROM user_items inner join tag on tag.item_id = user_items.id where tag.category_id = $select_categry");
} elseif (isset($_GET['search'])) {
  // søgefunktion
  $search = $_GET['search'];
  $db_data = performQuery("SELECT id, title, image, auc_end, start_price FROM user_items where title Like '%$search%'");
}
else {
  $db_data = performQuery("SELECT id, title, image, auc_end, start_price FROM user_items");
}

while($output_data = mysqli_fetch_assoc($db_data)) { ?>

    <div class="flex_child_of_child">
      <a href="item-single.php?item_id=<?php echo $output_data['id'];?>">
      <p class="bold"><?php echo $output_data['title']; ?></p>
      <p>Auktion slutter: <?php echo $output_data['auc_end']; ?> </p>
      <p>Start pris: <?php echo $output_data['start_price'];?></p>
      <?php $item_id = $output_data['id'];
      $start_price = $output_data['start_price'];

        $db_bid_data = performQuery("SELECT bid_amount FROM bid WHERE item_id =$item_id ORDER BY bid_amount desc limit 1");
if (mysqli_num_rows($db_bid_data) > 0) {
  while($new = mysqli_fetch_assoc($db_bid_data)) { ?>
    <p>Nuværende højeste bud: <?php echo $new['bid_amount'];?> </p>

<?php }
} else { ?>
  <p><?php echo "Be the first one to bid on this item"; ?></p>

<?php } ?>

<?php //jeg har det problem at siden ikke vil vise startprisen på en vare hvis der ikke er kommet et bud på varen. På vare 2 har jeg lagt et bud ind i databasen som er under startprisen og så virker det. Det er dog ikke meningen at man skal kunne byde under startprisen. En mulig løsning er at lave det sådan at man opretter et bud på startprisen når man sætter en ting til salg, men det giver problemer hvis ingen byder på varen, så vinder man den selv? der må være en smartere måde at lave det på. spørg kenneth tirsdag ?>
</a>
    </div>

<?php } ?>
</main>

</div>
 <?php
 include 'templates/footer.php';
  ?>
