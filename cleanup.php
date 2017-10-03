<?php
//cleanup.php

echo '<head><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" type="text/css" href="shshclues.css" /></head>';

echo "<body><div class='answerDiv'>";
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    $code = filter_var($_POST["code"], FILTER_SANITIZE_STRING);

    //mysql credentials
    $mysql_host = "localhost";
    $mysql_username = "pi";
    $mysql_password = "piTin";
    $mysql_database = "scavenger";
   
    $mysqli = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database);
   
    // Output any connection error
    if ($mysqli->connect_error) {
        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    }  
   
    // get the clue
    $sql = "delete from penalty";
    if($mysqli->query($sql) === TRUE) {
        echo "Penalties Purged!";
    } else {
        echo "Error" . $mysqli->error;
    }

    $mysqli->close();
   
}
?>