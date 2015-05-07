<!-- 

	Created by Manav.

-->

<?php 
session_start();
require 'utils.php'; 
?>
<html>
<head>
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
	<script src="scwidget.js"></script>
	<script src="soundcloud.player.api.js"></script>
	<script type="text/javascript">
		//Prepares the soundcloud widget
	   soundcloud.addEventListener('onPlayerReady', function(player, data) {
	     player.api_play();
	   });
	</script>

	<script>

		//This function orders the songs in the descending order
		function orderSongs(vote1, vote2, vote3, vote4, vote5){
			//Initialializes our app with the Soundcloud API
			SC.initialize({
    		client_id: '82bbfbb611ea601c42b750a83a4c0749',
  			});

			//Gets the playlist, and acesses the tracks on it.
			SC.get('/playlists/96517157', function(playlist) {

				var ranked_songs = new Array();
				ranked_songs[5-vote1]=0;
				ranked_songs[5-vote2]=1;
				ranked_songs[5-vote3]=2;
				ranked_songs[5-vote4]=3;
				ranked_songs[5-vote5]=4;
	

				//Displays the ranked songs in the correct order
				$('.player').append("<div class='title-container'><div class='song-title'>" + playlist.tracks[ranked_songs[4]].title + "</div></div>");
				$('.player').append("<iframe width='100%'' height='100 scrolling='no' frameborder='no' src='https://w.soundcloud.com/player/?url=https%3A//" + playlist.tracks[ranked_songs[4]].uri.substring(8) + "&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true'></iframe>");

				$('.player').append("<div class='title-container'><div class='song-title'>" + playlist.tracks[ranked_songs[3]].title + "</div></div>");
				$('.player').append("<iframe width='100%'' height='100 scrolling='no' frameborder='no' src='https://w.soundcloud.com/player/?url=https%3A//" + playlist.tracks[ranked_songs[3]].uri.substring(8) + "&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true'></iframe>");

				$('.player').append("<div class='title-container'><div class='song-title'>" + playlist.tracks[ranked_songs[2]].title + "</div></div>");
				$('.player').append("<iframe width='100%'' height='100 scrolling='no' frameborder='no' src='https://w.soundcloud.com/player/?url=https%3A//" + playlist.tracks[ranked_songs[2]].uri.substring(8) + "&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true'></iframe>");
				
				$('.player').append("<div class='title-container'><div class='song-title'>" + playlist.tracks[ranked_songs[1]].title + "</div></div>");
				$('.player').append("<iframe width='100%'' height='100 scrolling='no' frameborder='no' src='https://w.soundcloud.com/player/?url=https%3A//" + playlist.tracks[ranked_songs[1]].uri.substring(8) + "&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true'></iframe>");

				$('.player').append("<div class='title-container'><div class='song-title'>" + playlist.tracks[ranked_songs[0]].title + "</div></div>");
				$('.player').append("<iframe width='100%'' height='100 scrolling='no' frameborder='no' src='https://w.soundcloud.com/player/?url=https%3A//" + playlist.tracks[ranked_songs[0]].uri.substring(8) + "&amp;auto_play=false&amp;hide_related=false&amp;show_comments=true&amp;show_user=true&amp;show_reposts=false&amp;visual=true'></iframe>");				
		
			});


		}
	</script>
  <title>Ranking</title>
</head>
<body>
	<!-- Header -->
	<div class="header-container">Jameez
	    <div class="header-content">
	        <a href="aggregate.php">THE PLAYLIST</a> | <a href="rank.php">RANK</a> | <a href="userpage.php">HOME</a>
	    	| <a href="logout.php">LOGOUT</a>
	    </div>
	</div>

	<div class="page-wrap">

<!-- Checks whether the user is logged in -->
<?php
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
			<h1>YOUR Playlist</h1>
		</div>

<!-- Gets the song ratings from the database and passes them to the orderSongs function,
which displays them in the correct order. -->
<?php
$result = get_rating($_SESSION['username']);

	if ($result) {
		list ($v1,$v2,$v3,$v4,$v5) = $result;
				echo "<script type = 'text/javascript'> "
					. "orderSongs(" . $v1 . "," . 
									 $v2 . "," . 
									 $v3 . "," . 
									 $v4 . "," . 
									 $v5 . ");" . 
						" </script>";

		}
	else{
		echo "you haven't voted yet!";
	}

?>
		<!-- Where the playlist is displayed -->
		<div class="player"></div>	
	</div>


	<!-- The Footer -->
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