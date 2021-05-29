<?php
include 'templates/header.php';
 ?>

  <section class="signup-form">
    <h2>Sign Up</h2>
    <div class="signup-form-form">
      <form action="includes/signup.inc.php" method="post">
        <input type="text" name="f_name" placeholder="Fornavn">
        <input type="text" name="l_name" placeholder="Efternavn">
        <input type="text" name="email" placeholder="Email">
        <input type="text" name="username" placeholder="Brugernavn">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="passwordrepeat" placeholder="Gentag password">
        <button type="submit" name="submit">Sign Up</button>
      </form>
    </div>
  </section>


 <?php
 include 'templates/footer.php';
  ?>
