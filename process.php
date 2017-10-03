<?php
//process.php

echo '<head><meta name="viewport" content="width=device-width, initial-scale=1.0"><link rel="stylesheet" type="text/css" href="shshclues.css" /></head>';

echo "<body><div class='answerDiv'>";
if ($_SERVER["REQUEST_METHOD"] == "POST") {//Check it is coming from a form
    $clue_number = filter_var($_POST["clueNumber"], FILTER_SANITIZE_STRING); //set PHP variables like this so we can use them anywhere in code below
    $track_number = filter_var($_POST["trackNumber"], FILTER_SANITIZE_STRING);
    $code = filter_var($_POST["code"], FILTER_SANITIZE_STRING);

    if($clue_number == -1) {
        $track_number = "TEST";
    }

    if (empty($clue_number)){
        die("<div class='solution'>You didn't select your clue number</div><br><br><a href='/clues.php?code=" . $code . "'>Start Over</a>");
    }
       
    if (empty($track_number)){
        die("<div class='solution'>You didn't select your track letter</div><br><br><a href='/clues.php?code=" . $code . "'>Start Over</a>");
    }  

    if (empty($code)){
        die("<div class='solution'>Your team code is not valid. Please call in via phone or rescan the qr code.</div>");
    }

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
   
    // determine the team
    $selectTeam = "select id, teamName from team t where password = '" . $code . "'";

    $resultTeam = $mysqli->query($selectTeam);

    if ($resultTeam->num_rows > 0) {
        // output data of each row
        while($row = $resultTeam->fetch_assoc()) {
            $teamName = $row["teamName"];
	    $teamId = $row['id'];

	    if($clue_number == -1) {
	        echo "<p style='font-size:20px'>Ok, " . $teamName . "<br><br>Here is the solution for:<br>Clue TEST on Track " . $track_number . "</p>";
	    } else {
	        echo "<p style='font-size:20px'>Ok, " . $teamName . "<br><br>Here is the solution for:<br>Clue " . $clue_number . " on Track " . $track_number . "</p>";
	    }
        }
    } else {
        echo "There is a problem. Call in for the solution.";
    }


    // get the clue
    $selectClue = "select c.id, c.answer from clue c where clueNumber = " . $clue_number . " and track = '" . $track_number . "'";
    $result = $mysqli->query($selectClue);
    
    if ($result->num_rows > 0) {
        // output data of each row
    	if($row = $result->fetch_assoc()) {
	    echo "<div class='solution'>";
      	    echo "<p>" . $row["answer"]. "</p>";
	    echo "</div>";

	    if($clue_number != -1 && $track_number != 'TEST') {
	        echo "<p style='font-size:20px'>Your team has been assessed a time penalty.</p>";
            } else {
	        echo "<p style='font-size:20px'>If this was not a test, Your team would have been assessed a time penalty.</p>";
	    }

	    echo "<p><a href='/clues.php?code=$code'>Start Over</a></p>";

	    
    	    $sql = "INSERT INTO penalty (teamId, clueId, trackId, penaltyMins, created) VALUES ($teamId, $clue_number, '$track_number', 13, now())";

	    if($clue_number != -1 && $track_number != 'TEST') {
	       echo 'in here';
	        $mysqli->query($sql);
	    }
	}
    } else {
        echo "There is a problem. Call in for the solution.";
    }
    
    echo "</div></body>";

    $mysqli->close();
   
}
?>