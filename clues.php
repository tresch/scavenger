<html> 
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="shshclues.css" />
</head>
<body>
  <div>
    <div class="textDiv">
      <h1>South Hills Scavenger Hunt <br>Help System</h1>
      <p>
	If you are unable to solve a clue, enter the clue number and track letter from the clue here.<br>
	Remember, you will be charged a time penalty if you click "Solve"!
      </p>

      <form method="post" action="process.php">
	<p>
	  <?php 
	     $code = $_GET['code'];
	     //echo($code);
	     $invalidTeam = 'FALSE';

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
              echo "<div class='teamName'>Your team name:<br>" . $teamName . "</div>";
            }
	  } else {
	    $invalidTeam = 'TRUE';
            echo "<div class='teamNameError'>Your team password is not valid, please call in for help with clues.</div>";
	  }
	?>
      </p>

    </div>
    <div style="font-size:20px;padding-left:20px">

<?php
   if($code == 'testpassword') {
       echo('Clue: <select id="clueNumber" name="clueNumber" class="selectClass">');
       echo('<option value="" selected>Select Your Clue Number</option>');
		 echo('<option value="-1">TEST</option>');
		 echo('<option value="1" disabled>1</option>');
		 echo('<option value="2" disabled>2</option>');
		 echo('<option value="3" disabled>3</option>');
		 echo('<option value="4" disabled>4</option>');
		 echo('<option value="5" disabled>5</option>');
		 echo('<option value="6" disabled>6</option>');
		 echo('<option value="7" disabled>7</option>');
		 echo('<option value="8" disabled>8</option>');
            echo('</select>');

   } else {

       echo('Clue: <select id="clueNumber" name="clueNumber" class="selectClass">');
       echo('<option value="" selected>Select Your Clue Number</option>');
       echo('<option value="1">1</option>');
       echo('<option value="2">2</option>');
       echo('<option value="3">3</option>');
       echo('<option value="4">4</option>');
       echo('<option value="5">5</option>');
       echo('<option value="6">6</option>');
       echo('<option value="7">7</option>');
       echo('<option value="8">8</option>');  
      echo('</select>');
}
?>

<br><br>

Track: <select id="trackNumber" name="trackNumber" class="selectClass">
  <option value="" selected>Select Your Track Letter</option>
  <option value="A">A</option>
  <option value="B">B</option>
  <option value="C">C</option>
</select>


<input type="hidden" name="code" value="<?php echo $code;?>" />
<div style="padding-top:20px">
  <?php
     if($invalidTeam !== 'TRUE') {
         echo('<button class="lgButton" type="submit" value="Submit">Solve</button>');
     }
  ?>
</div>
</form>
</div>
</div>
 </body> </html>
