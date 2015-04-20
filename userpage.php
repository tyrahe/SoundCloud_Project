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
  	<title>Ranking</title>
</head>
<body>
<?php

	//Checks if user is logged in.
	session_start();
	if (!isset($_SESSION["userName"])) {
	    
	    echo "Not logged in yet.";
	    exit();
	}

	echo "Hello ".$_SESSION["userName"]."<br>";

	?>
<?php

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "myDB";

	//Connects to soundcloud API
	
	// Create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	} 

?>

<?php
//get ranking of songs
	$sql = "SELECT username,track1,track2,track3,track4,track5 FROM TEST2";
	$result = $conn->query($sql);
	

	if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()){
				 // echo "Track " . $row["track1"] . "<br>"
				 // . "Track " . $row["track2"] . "<br>"
				 // . "Track " . $row["track3"] . "<br>"
				 // . "Track " . $row["track4"] . "<br>"
				 // . "Track " . $row["track5"] . "<br>";
				echo "<script type = 'text/javascript'> "
					. "showSongs(" . $row["track1"] . ", 1) </script>";
				echo "<script type = 'text/javascript'> "
					. "showSongs(" . $row["track2"] . ", 2) </script>";
				echo "<script type = 'text/javascript'> "
					. "showSongs(" . $row["track3"] . ", 3) </script>";
				echo "<script type = 'text/javascript'> "
					. "showSongs(" . $row["track4"] . ", 4) </script>";
				//echo "<script type = 'text/javascript'> "
				//	. "showSongs(" . $row["track5"] . ", 5) </script>";

				echo "<object height='81' width='100%' id='yourPlayerId' 
						classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'>
  						<param name='movie' value='http://player.soundcloud.com/player.swf?url=http%3A%2F%2Fsoundcloud.com%2Fmatas%2Fhobnotropic&enable_api=true&object_id=yourPlayerId'></param>
  						<param name='allowscriptaccess' value='always'></param><embed allowscriptaccess='always' height='81' 
  						src='http://player.soundcloud.com/player.swf?url=http%3A%2F%2Fsoundcloud.com%2Fmatas%2Fhobnotropic&enable_api=true&object_id=yourPlayerId' 
  						type='application/x-shockwave-flash' width='100%'' name='yourPlayerId'></embed>
						</object>
						<div class='player'></div>
						<div id='test'></div>";
			}
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


<h2>Click <a href="aggregate.php">here</a> to view the playlist</h2>
<h2>Click <a href="rank.php">here</a> to rank your favorite songs</a></h2>


</body>
</html>