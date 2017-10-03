<html> 
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="shshclues.css" />
</head>
<body>
  <div>
    <div class="textDiv">
      <h1>South Hills Scavenger Hunt <br>Help System<br>Purge Page</h1>
      <p>
	Pressing submit will purge all the penalty data...
      </p>

      <form method="post" action="cleanup.php">
	<p>
	  <?php 
	     $code = "delete";
          ?>
      </p>

    </div>
    <div style="font-size:20px;padding-left:20px">

<input type="hidden" name="code" value="<?php echo $code;?>" />
<div style="padding-top:20px">
   <button class="lgButton" type="submit" value="Submit">Purge</button>
</div>
</form>
</div>
</div>
 </body> </html>
