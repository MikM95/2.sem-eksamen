<?php

if (isset($_POST["submit"])) {

    $f_name = $_POST["f_name"];
    $l_name = $_POST["l_name"];
    $address = $_POST["address"];
    $postal = $_POST["postal"];
    $email = $_POST["email"];
    $username = $_POST["uid"];
    $pwd = $_POST["pwd"];
    $pwdrepeat = $_POST["pwdrepeat"];

    require_once 'dbconnect.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignup($f_name, $l_name, $email, $username, $pwd, $pwdrepeat) !== false) {
      header("location: ../signup.php?error=emptyinput");
      exit();
    }
    if (invalidUid($uid) !== false) {
      header("location: ../signup.php?error=invaliduid");
      exit();
    }
    if (invalidEmail($email) !== false) {
      header("location: ../signup.php?error=invalidemail");
      exit();
    }
    if (pwdMatch($pwd, $pwdrepeat) !== false) {
      header("location: ../signup.php?error=passwordsmismatch");
      exit();
    }
    if (uidExists($mysqli, $username, $email) !== false) {
      header("location: ../signup.php?error=usernametaken");
      exit();
    }
  /*  if (passwordLength($password, $passwordrepeat) <6) {
      header("location: ../signup.php?error=passwordtooshort");
      exit();
    } */

    createUser($mysqli, $username, $email, $pwd, $f_name, $l_name, $address, $postal);


}
else {
  header("location: ../signup.php");
  exit();
}
