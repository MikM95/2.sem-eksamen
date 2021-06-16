<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
?>
<div class="index-layout">
<aside class="flex-child-aside">
<p id="aside_title">Kategorier</p>
<ul class="list_style_type_aside">
  <?php $db_categories_data = performQuery("SELECT * FROM categories");
  while ($categories = mysqli_fetch_assoc($db_categories_data)) { ?>
  <a href="index.php?category_id=<?php echo $categories['id']; ?> "><li><?php echo $categories['name']; ?>
    <?php $category_id = $categories['id'];
     $db_amount_tag = performQuery("SELECT * FROM tag where tag.category_id = $category_id"); echo '('. mysqli_num_rows($db_amount_tag); ?>)</li></a>
  <?php } ?>
</ul>
<p class="aside_title">Varens stand</p>
<ul class="list_style_type_aside">
  <?php $db_cond_data = performQuery("SELECT * FROM cond");
  while ($cond_data = mysqli_fetch_assoc($db_cond_data)) { ?>
    <a href="index.php?cond_id=<?php echo $cond_data['id']; ?> "><li><?php echo $cond_data['name']; ?>
      <?php $cond_id = $cond_data['id'];
       $db_amount_cond = performQuery("SELECT user_items.cond_id FROM user_items where user_items.cond_id = $cond_id"); echo '('.mysqli_num_rows($db_amount_cond); ?>)</li></a>
<?php } ?>
</ul>
<p class="aside_title">Søg på titler</p>
<form method="get" class="aside_form">
  <input type="text" name="search" class="aside_bar">
  <button type="submit">Søg</button>
</form>
<p class="aside_title">Maks pris</p>
<form method="get" class="aside_form">
  <input type="number" name="max_price" class="aside_bar">
  <button type="submit" class="aside_button">Søg</button>
</form>
</aside>
<main class="flex-child-main">
<?php
// valg af database udtræk afhænigt af om der er valt en kategori, om der er søgt ellers tages "standard" database udtrækket
if (isset($_GET['category_id'])) {
  $select_categry = $_GET['category_id'];
  $db_data = performQuery("SELECT user_items.id, title, auc_end, start_price, tag.category_id FROM user_items inner join tag on tag.item_id = user_items.id where tag.category_id = $select_categry");
}elseif (isset($_GET['cond_id'])) {
  // hvis der er valgt en condition skal vi ændre database udtrækket så brger får at se de varer der har den ønskede stand
  $select_cond = $_GET['cond_id'];
  $db_data = performQuery("SELECT user_items.id, title, auc_end, start_price FROM user_items WHERE user_items.cond_id = $select_cond");
}
elseif (isset($_GET['search'])) {
  // søgefunktion
  $search = $_GET['search'];
  $db_data = performQuery("SELECT id, title, auc_end, start_price FROM user_items where title Like '%$search%'");
}
else {
  $db_data = performQuery("SELECT id, title, auc_end, start_price FROM user_items");
}

//begyndelse på at skrive til skærm, "indholdet" er valgt tidligere
while($output_data = mysqli_fetch_assoc($db_data)) { ?>
  <?php
    $item_id = $output_data['id'];
    $db_bid_data = performQuery("SELECT bid_amount FROM bid WHERE item_id =$item_id ORDER BY bid_amount desc limit 1");
//Sidste sorterings tjek - her tjekkes der om der er sat en maks pris
     ?>
  <?php if (isset($_GET['max_price'])) {
    // hvis der er sat en maksimal pris så skal koden kører
    if (mysqli_num_rows($db_bid_data) > 0) {
      // hvis der er bud på varen skal varen kun vises hvis budet er under maksprisen
      while ($bid_data = mysqli_fetch_assoc($db_bid_data)) {
        // vi skal have det højeste bud ud så vi kan arbejde med det
        if ($bid_data['bid_amount'] < $_GET['max_price']) {
          // Hvis prisen kunden vil give er over det nuværende højeste bud så skal auktionen vises
          ?>
          <div class="flex_child_of_child">
            <a href="item-single.php?item_id=<?php echo $output_data['id'];?>">
              <p class="bold"><?php echo $output_data['title']; ?></p>
              <p>Auktion slutter: <?php echo $output_data['auc_end']; ?> </p>
              <p>Start pris: <?php echo $output_data['start_price'];?></p>
              <p>Nuværende højeste bud: <?php echo $bid_data['bid_amount'];?> </p>
            </a>
          </div>
<?php
        } else {
          continue;
        }
      }

    } else {
      //hvis der ikke er et bud på varen skal der sammenlignes med startprisen for at finde ud af om varen skal vises
      if ($output_data['start_price'] < $_GET['max_price']) {
        // hvis den maksimale pris burgeren vil give for varen er større end startprisen så skal varen vises
        ?>
        <div class="flex_child_of_child">
          <a href="item-single.php?item_id=<?php echo $output_data['id'];?>">
            <p class="bold"><?php echo $output_data['title']; ?></p>
            <p>Auktion slutter: <?php echo $output_data['auc_end']; ?> </p>
            <p>Start pris: <?php echo $output_data['start_price'];?></p>
            <p><?php echo "Vær' den første til at byde på denne auktion"; ?></p>
          </a>
        </div>
<?php
      }else {
        //Hvis max_prise er mindre end start prisen skal varen IKKE vises
        continue;
      }
    }
  } else {
    // koden skal køre som normalt hvis der ikke er sat en maks pris
    ?>
    <div class="flex_child_of_child">
      <a href="item-single.php?item_id=<?php echo $output_data['id'];?>">
        <p class="bold"><?php echo $output_data['title']; ?></p>
        <p>Auktion slutter: <?php echo $output_data['auc_end']; ?> </p>
        <p>Start pris: <?php echo $output_data['start_price'];?></p>

        <?php
        if (mysqli_num_rows($db_bid_data) > 0) {
          while($new = mysqli_fetch_assoc($db_bid_data)) { ?>
            <p>Nuværende højeste bud: <?php echo $new['bid_amount'];?> </p>
          <?php }
        }
        else { ?>
          <p><?php echo "Vær' den første til at byde på denne auktion"; ?></p>
        <?php } ?>
      </a>
    </div>

<?php }} ?>
</main>

</div>
 <?php
 include 'templates/footer.php';
  ?>
