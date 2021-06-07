<?php
include 'templates/header.php';
 ?>

  <section class="signup-form">
    <h2>Log In</h2>
    <div class="signup-form-form">
      <form action="includes/login.inc.php" method="post">
        <input type="text" name="uid" placeholder="Brugernavn/Email">
        <input type="password" name="pwd" placeholder="Password">
        <button type="submit" name="submit">Log In</button>
      </form>
    </div>
    <?php
      if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
          echo "<p> Udylf alle felter</p>";
        }
        else if ($_GET["error"] == "wronglogin") {
          echo "<p> Invalid login information</p>";
        }
      }

     ?>
  </section>



 <?php
 include 'templates/footer.php';
  ?>
