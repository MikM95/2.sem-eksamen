<?php
	session_start();
 ?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Ikea genbrugs salg</title>
		<link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="css/nav.css">
	</head>
	<body>
      <ul class="navigation">
				<li> <a href="index.php"><img class="nav_image" src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/c5/Ikea_logo.svg/2560px-Ikea_logo.svg.png" alt="Ikea logo"></a> </li>
        <li> <a href="index.php">Alle auktioner</a> </li>
				<?php
					if (isset($_SESSION["useruid"])) {
						echo "<li> <a href='create-auction.php'>Opret ny auktion</a> </li>";
						echo "<li> <a href='profile.php'>Profil</a> </li>";
		        echo "<li> <a href='includes/logout.inc.php'>Log ud</a> </li>";
					}
					else {
						echo "<li> <a href='signup.php'>Sign up</a> </li>";
		        echo "<li> <a href='login.php'>Log ind</a> </li>";
					}
				 ?>
      </ul>
