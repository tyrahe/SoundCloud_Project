<?php require 'utils.php'; ?>
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
	   soundcloud.addEventListener('onPlayerReady', function(player, data) {
	     player.api_play();
	   });
	</script>
	<script>
		


		function showSongs(songIndex, choice){

			SC.initialize({
    		client_id: '82bbfbb611ea601c42b750a83a4c0749',
  			});

			SC.get('/playlists/96517157', function(playlist) {
  				index = songIndex -1;
  				$('.player').append("<h3>Choice " + choice + "</h3>" );
  				$('.player').append("<h4>Song " + songIndex + "</h4>" );
  				$('.player').append(playlist.tracks[index].title);
  				$('.player').append("<br>");

  				console.log(playlist.tracks[index].embeddable_by);
  				
			});

			

		};
	</script>
	<script>

		function orderSongs(vote1, vote2, vote3, vote4, vote5){
			SC.initialize({
    		client_id: '82bbfbb611ea601c42b750a83a4c0749',
  			});

			SC.get('/playlists/96517157', function(playlist) {

			var ranked_songs = new Array();
			ranked_songs[5-vote1]=0;
			ranked_songs[5-vote2]=1;
			ranked_songs[5-vote3]=2;
			ranked_songs[5-vote4]=3;
			ranked_songs[5-vote5]=4;

			
			//songs in order
			$('.player').append("<h3>Choice 1 </h3>" );
			$('.player').append("<h4>Song " + (ranked_songs[0]+1) + "</h4>" );
			$('.player').append(playlist.tracks[ranked_songs[1]].title);
			$('.player').append("<br>");

			$('.player').append("<h3>Choice 2 </h3>" );
			$('.player').append("<h4>Song " + (ranked_songs[1]+1) + "</h4>" );
			$('.player').append(playlist.tracks[ranked_songs[2]].title);
			$('.player').append("<br>");

			$('.player').append("<h3>Choice 3 </h3>" );
			$('.player').append("<h4>Song " + (ranked_songs[2]+1) + "</h4>" );
			$('.player').append(playlist.tracks[ranked_songs[3]].title);
			$('.player').append("<br>");

			$('.player').append("<h3>Choice 4 </h3>" );
			$('.player').append("<h4>Song " + (ranked_songs[3]+1) + "</h4>" );
			$('.player').append(playlist.tracks[ranked_songs[4]].title);
			$('.player').append("<br>");

			$('.player').append("<h3>Choice 5 </h3>" );
			$('.player').append("<h4>Song " + (ranked_songs[4]+1) + "</h4>" );
			$('.player').append(playlist.tracks[ranked_songs[5]].title);
			$('.player').append("<br>");

			});


		}
	</script>
  	<title>Ranking</title>
</head>
<body>
<div class="header-container">Tyra and Manav's Web App
        <div class="content">
            <a href="aggregate.php">THE PLAYLIST</a> | <a href="rank.php">RANKING</a> | <a href="userpage.php">USERPAGE</a>
        	| <a href="logout.php">LOGOUT</a>
        </div>
</div>
<div class="page-wrap">
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
	<h1>YOUR Playlist</h1>

    <div class="description">
        On this page you can view the songs in your order of ranking! <br><br>
    </div>
</div>

<?php

//get ranking of songs
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
<object height="81" width="100%" id="yourPlayerId" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000">
  <param name="movie" value="http://player.soundcloud.com/player.swf?url=http%3A%2F%2Fsoundcloud.com%2Fmatas%2Fhobnotropic&enable_api=true&object_id=yourPlayerId"></param>
  <param name="allowscriptaccess" value="always"></param>
  <embed allowscriptaccess="always" height="81" src="http://player.soundcloud.com/player.swf?url=http%3A%2F%2Fsoundcloud.com%2Fmatas%2Fhobnotropic&enable_api=true&object_id=yourPlayerId" type="application/x-shockwave-flash" width="100%" name="yourPlayerId"></embed>
</object>
<div class="player"></div>
<div id='test'></div>
</div>

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