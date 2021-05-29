<?php
  $host = "localhost";
  $user = "root";
  $password = "root";
  $database = "ikea";
  $mysqli = mysqli_connect($host, $user, $password, $database);

  if(mysqli_connect_errno()){
    echo "connection falied" . mysqli_connect_errno();
    }
  else {
    echo "connection success! <br>";
    }

    function performQuery($sql) {
      global $mysqli;
      $result = mysqli_query($mysqli, $sql);

      if($result) {
        echo "Query success <br>";
        return $result;
        }
      else {
        echo "Der gik noget galt";
        return null;
        }



    }

?>
