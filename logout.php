<!-- 

Created by Manav and Tyra.

Logout page, redirects user to login

-->

<?php
 session_start(); 
 session_unset(); 
 session_destroy(); 
 ?>
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
		
	</head>
<body>
<!-- Header -->
  <div class="page-wrap">
    <div class="header-container">Jameez
      <div class="header-content">
           <a href="aggregate.php">THE PLAYLIST</a> | <a href="rank.php">RANKING</a> | <a href="userpage.php">USERPAGE</a>
      	| <a href="">LOGOUT</a>
      </div>
    </div>

  <!-- Redirect to login page -->
  <div class='main-container'>
    <div class='welcome'>
    Thank you for using Jameez. Redirecting to log in page...
    <script>setTimeout("location.href = 'login.php';", 2000);</script>
    </div>
  </div>

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