<?php
include('includes/functions.inc.php');
include('includes/dbconnect.inc.php');
include 'templates/header.php';
$item_id = $_GET['item_id'];
?>

Du er nu på auktions siden for genstanden med id <?php echo $item_id; ?>


 <?php
 include 'templates/footer.php';
  ?>
