<?php


    function performQuery($sql) {
      global $mysqli;
      $result = mysqli_query($mysqli, $sql);

      if($result) {
        //echo "Query success <br>";
        return $result;
        }
      else {
        echo "Der gik noget galt";
        return null;
        }
    }

    function emptyInputSignup($f_name, $l_name, $email, $username, $pwd, $pwdrepeat) {
      $result;
      if (empty($f_name) || empty($l_name) || empty($email) || empty($username) || empty($pwd) || empty($pwdrepeat)) {
        $result = true;
      }
      else {
        $result = false;
      }
      return $result;
    }

    function invalidUid($username) {
      $result;
      //preg_match er en søge algoritme der tjekker om det inde i de firkantede paranteser er true. linje 32 tjekker om der er brugt noget der ikke passer inden for a-z OG A-Z OG 0-9, pga ! før preg_match tjekker den om det IKKE er rigtigt om de tegn er der aka. den tjekker om der er fejl i brugernavnet i tilfælde af de vil bruge accenter etc.
      if (!preg_match('/^[a-zA-Z0-9]*$/', $username)) {
        $result = true;
      }
      else {
        $result = false;
      }
      return $result;
    }

    function invalidEmail($email) {
      $result;
      if (!filter_var($email, FILTER_VALIDATE_EMAIL, $username)) {
        $result = true;
      }
      else {
        $result = false;
      }
      return $result;
    }

    function pwdMatch($pwd, $pwdrepeat) {
      $result;
      if ($pwd !== $pwdrepeat) {
        $result = true;
      }
      else {
        $result = false;
      }
      return $result;
    }

    function uidExists($mysqli, $username, $email) {
      $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
      $stmt = mysqli_stmt_init($mysqli);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
      }

      mysqli_stmt_bind_param($stmt, "ss", $username, $email);
      mysqli_stmt_execute($stmt);

      $resultdata = mysqli_stmt_get_result($stmt);
        //tjekker om der er data i assoc ($resultdata) OG assigner det til $row på samme tid
      if ($row = mysqli_fetch_assoc($resultdata)) {
        return $row;
      }
      else {
        $result = false;
        return $result;
      }

      mysqli_stmt_close($stmt);
    }

    function createUser($mysqli, $username, $email, $pwd, $f_name, $l_name, $address, $postal) {
      $sql = "INSERT INTO users (username, email, password, f_name, l_name, address, postal) VALUES(?, ?, ?, ?, ?, ?, ?);";
      $stmt = mysqli_stmt_init($mysqli);
      if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmtfailed");
        exit();
      }

      $hashedpassword = password_hash($pwd, PASSWORD_DEFAULT);

      mysqli_stmt_bind_param($stmt, "ssssssi", $username, $email, $hashedpassword, $f_name, $l_name, $address, $postal);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_close($stmt);

      header("location: ../signup.php?error=none");
      exit();
    }

    function emptyInputLogin($username, $pwd) {
      $result;
      if (empty($username) || empty($pwd)) {
        $result = true;
      }
      else {
        $result = false;
      }
      return $result;
    }

    function loginUser($mysqli, $username, $pwd) {
      $uidExists = uidExists($mysqli, $username, $username);

      if ($uidExists === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
      }

      $pwdHashed = $uidExists["password"];
      $checkPwd = password_verify($pwd, $pwdHashed);

      if ($checkPwd === false) {
        header("location: ../login.php?error=wronglogin");
        exit();
      }
      else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["id"];
        $_SESSION["useruid"] = $uidExists["username"];
        header("location: ../index.php");
        exit();
      }
    }
