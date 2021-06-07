<?php
include 'templates/header.php';
 ?>
<hr>
<div id="frm">
  <section class="signup-form">
    <h2>Log In</h2>
    <div class="signup-form-form">
      <form action="includes/login.inc.php" method="post">
        <input type="text" name="uid" placeholder="Brugernavn/Email">
        <input type="password" name="pwd" placeholder="Password">
        <br>
        <input type="checkbox" name="Remember me">Remember me</input>
        <br>
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
</div>
 <?php
 include 'templates/footer.php';
  ?>
