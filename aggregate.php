<!-- 
Created by Manav.
This page displays the playlist for users to rank. You may also listen to the playlist!
-->

<html>
	<head>
		<title>CS105 MUSIC APP</title>
		<!-- Styling -->
		<link rel="stylesheet" type="text/css" href="default.css">
		
		<!-- Fonts -->
  		<link href='http://fonts.googleapis.com/css?family=Arimo:400,700' rel='stylesheet' type='text/css'>
  		<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>  		
		
		<!-- Jquery -->
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
  		
		<!-- Soundcloud SDK -->
		<script src="//connect.soundcloud.com/sdk.js"></script>
		
		<!-- File with scripts-->
  	<script src="global.js"></script>
	</head>
<body>
  <div class="page-wrap">
    <!-- Header -->
    <div class="header-container">Jameez
      <div class="header-content">
          <a href="aggregate.php">THE PLAYLIST</a> | <a href="rank.php">RANK</a> | <a href="userpage.php">HOME</a>
        | <a href="logout.php">LOGOUT</a>
      </div>
    </div>

<!-- Checks whether the user is logged in -->
<?php
  session_start();
  echo "<div class='main-container'><div class='welcome'>";
  if (!isset($_SESSION["username"])) {
      
      echo "Not logged in yet. Redirecting to log in page...";
      ?><script>setTimeout("location.href = 'login.php';", 2000);</script><?php
      exit();
  }
  else{
    echo "Hello ".$_SESSION["username"]."<br>";
  }

  echo "</div></div>";
?>
  <div class="main-container">
  	<h1>The Playlist</h1>

      <div class="description">
          On this page you can view and play the playlist! After checking it out, feel free to go to the 
          ranking page to change the order for your user page!<br><br>
      </div>

  </div>


  <!-- Where the playlist is displayed -->
  <div id="list"></div>
  <div id="player"></div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <div class="col-left">
        Click <a href="https://developers.soundcloud.com/">here</a> to learn more about the Soundcloud API<br>
        Built for CS 135, Distributed Software Architecture
    </div>

    <div class="col-right">
        Designed by Manav Kohli CMC '16 and Tyra He HMC '16  
    </div>

  </div>

</body>
</html>