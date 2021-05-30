<?php
	session_start();
 ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Ikea secondhand sales</title>
		<link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="../css/nav.css">
	</head>
	<body>


<nav>
    <div class="wrapper">
      <a href="index.php"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/Ikea_logo.svg/2560px-Ikea_logo.svg.png" alt="Ikea logo" style="width:150px;height:auto;"></a>
      <ul class="navigation">
        <li> <a href="index.php">forside</a> </li>
        <li> <a href="">2</a> </li>
				<?php
					if (isset($_SESSION["useruid"])) {
						echo "<li> <a href='profile.php'>Profile</a> </li>";
		        echo "<li> <a href='includes/logout.inc.php'>Log out</a> </li>";
					}
					else {
						echo "<li> <a href='signup.php'>Sign up</a> </li>";
		        echo "<li> <a href='login.php'>Log in</a> </li>";
					}
				 ?>
      </ul>
    </div>
  </nav>
