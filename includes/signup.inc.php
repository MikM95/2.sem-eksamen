<?php

if (isset($_POST["submit"])) {

    $f_name = $_POST["f_name"];
    $l_name = $_POST["l_name"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $passwordrepeat = $_POST["passwordrepeat"];

    require_once 'dbconnect.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignup($f_name, $l_name, $email, $username, $password, $passwordrepeat) !== false) {
      header("location: ../signup.php?error=emptyinput");
      exit();
    }
    if (invalidUsername($username) !== false) {
      header("location: ../signup.php?error=invalidusername");
      exit();
    }
    if (invalidEmail($email) !== false) {
      header("location: ../signup.php?error=invalidemail");
      exit();
    }
    if (passwordMatch($password, $passwordrepeat) !== false) {
      header("location: ../signup.php?error=passwordsmismatch");
      exit();
    }
    if (usernameExists($mysqli, $username, $email) !== false) {
      header("location: ../signup.php?error=usernametaken");
      exit();
    }
    if (passwordLength($password, $passwordrepeat) <6) {
      header("location: ../signup.php?error=passwordtooshort");
      exit();
    }

    createUser($mysqli, $username, $email, $password, $f_name, $l_name, $address, $postal);


}
else {
  header("location: ../signup.php");
  exit();
}
