<?php
include 'templates/header.php';
include('includes/dbconnect.inc.php');
include('includes/functions.inc.php');
 ?>

  <section class="signup-form">
    <h2>Sign Up</h2>
    <div class="signup-form-form">
      <form action="includes/signup.inc.php" method="post">
        <input type="text" name="f_name" placeholder="Fornavn">
        <input type="text" name="l_name" placeholder="Efternavn">
        <input type="text" name="address" placeholder="Addresse">
        <label for="postal">Vælg postnummer: </label>
        <select name="postal">
          <?php $data = performQuery("SELECT * FROM cities");
          while($asdf = mysqli_fetch_assoc($data)) { ?>
            <option value="<?php echo $asdf['postal']; ?>"><?php echo $asdf['postal'];?></option>
          <?php } ?>

        </select>
        <input type="email" name="email" placeholder="Email">
        <input type="text" name="uid" placeholder="Brugernavn">
        <input type="password" name="pwd" placeholder="Password">
        <input type="password" name="pwdrepeat" placeholder="Gentag password">
        <button type="submit" name="submit">Sign Up</button>
      </form>
    </div>
    <?php
      if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
          echo "<p> Udfyld alle felter</p>";
        }
        else if ($_GET["error"] == "invaliduid") {
          echo "<p> Invalid brugernavn</p>";
        }
        else if ($_GET["error"] == "invalidemail") {
          echo "<p> Invalid email</p>";
        }
        else if ($_GET["error"] == "passwordsmismatch") {
          echo "<p> Passwords er ikke ens</p>";
        }
        else if ($_GET["error"] == "stmtfailed") {
          echo "<p> Der gik noget galt, prøv igen</p>";
        }
        else if ($_GET["error"] == "usernametaken") {
          echo "<p> Brugernavnet er allerede taget, prøv et nyt</p>";
        }
        else if ($_GET["error"] == "none") {
          echo "<p> Du er oprettet!</p>";
        }
      }

     ?>
  </section>

<?php
include 'templates/footer.php';
 ?>
