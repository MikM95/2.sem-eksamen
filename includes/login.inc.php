<?php

if (isset($_POST["submit"])) {

  $username = $_POST["uid"];
  $pwd = $_POST["pwd"];

  require_once 'dbconnect.inc.php';
  require_once 'functions.inc.php';

  if (emptyInputLogin($username, $pwd) == true) {
    header("location: ../login.php?error=emptyinput");
    exit();
  }

  loginUser($mysqli, $username, $pwd);
}
else{
  header("location: ../login.php");
  exit();
}
