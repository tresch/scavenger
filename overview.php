<html> 
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="shshclues.css" />
</head>
<body>
<div>
<div>
<h1>South Hills Scavenger Hunt<br>Help System Overview</h1>
<p>
Let's see who needed help...
</p>

<p>
   <?php 

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

      // get the overview data
      $overviewSql = "select teamId, teamName, count(clueId) as numClues, sum(penaltyMins) as totalPenalty from penalty p, team t, clue c where t.id = p.teamId and c.id = p.clueId group by teamId, teamName order by teamName";

      $resultOverview = $mysqli->query($overviewSql);

      if ($resultOverview->num_rows > 0) {
          // output data of each row
          echo "<div class='resultDiv'><table class='tableStyle'><tr><th>Team</th><th># Clues</th><th>Total Penalty</th></tr>";
          while($row = $resultOverview->fetch_assoc()) {
              echo "<tr>";
              $teamName = $row["teamName"];
              $totalPenalty = $row['totalPenalty'];
              $numClues = $row['numClues'];
              echo "<td style='width:150px'>" . $teamName . "</td><td>" . $numClues . "</td><td>" . $totalPenalty . " </td>";
          }
          echo "</tr></table></div>";
      } else {
          print($mysqli->error);
      }

      echo "<br/><br/>";

      // get teh per penalty data
      $selectTeam = "select p.id, teamId, teamName, clueId, penaltyMins, created, track from penalty p, team t, clue c where t.id = p.teamId and c.id = p.clueId order by teamName, clueId";

      $resultTeam = $mysqli->query($selectTeam);

      if ($resultTeam->num_rows > 0) {
          // output data of each row
          echo "<div class='resultDiv'><table class='tableStyle'><tr><th>Team</th><th>Clue</th><th>Track</th><th>Penalty</th><th>Time</th></tr>";
          while($row = $resultTeam->fetch_assoc()) {
              echo "<tr>";
              $teamName = $row["teamName"];
              $penalty = $row['penaltyMins'];
              $clueId = $row['clueId'];
	      $trackId = $row['track'];
	      $created = $row['created'];
              echo "<td style='width:150px'>" . $teamName . "</td><td>" . $clueId . "</td><td>" . $trackId . "</td><td>" . $penalty . " </td><td>" . $created . " </td>";
          }
          echo "</tr></table></div>";
      } else {
          print($mysqli->error);
      }

   ?>
</p>

</div>
</div>
 </body> </html>
