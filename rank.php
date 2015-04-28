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
    
    <!-- File with scripts-->
    <script src="global.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>


    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <title>Ranking</title>
    <script>

    function validateForm() {
        var valid_values = ["1","2","3","4","5"];
        var idsInOrder = $("#sortable").sortable("toArray");
        alert(idsInOrder)
        var fields = ["track1","track2","track3","track4","track5"];
        for (var i = 0; i <fields.length;i++) {
            var val = document.getElementById(fields[i]).value;
            if (valid_values.indexOf(val) == -1) {
                alert(val+" is not a valid rating (from 1 to 5)");
                return false;
            }
        }
        return true;
    }
    function myFunction(action, method, input) {
        'use strict';
        var form;
        form = $('<form />', {
            action: action,
            method: method,
            style: 'display: none;'
        });
        if (typeof input !== 'undefined' && input !== null) {
            $.each(input, function (name, value) {
                $('<input />', {
                    type: 'hidden',
                    name: name,
                    value: value
                }).appendTo(form);
            });
        }
        form.appendTo('body').submit();
    }
    </script>
    <script>
    function submit_form() {
      var idsInOrder = $("#sortable").sortable("toArray");
      track1 = 5 - idsInOrder.indexOf("track_1");
      track2 = 5 - idsInOrder.indexOf("track_2");
      track3 = 5 - idsInOrder.indexOf("track_3");
      track4 = 5 - idsInOrder.indexOf("track_4");
      track5 = 5 - idsInOrder.indexOf("track_5");
      myFunction("rank.php","post", {
        track1 : track1,
        track2 : track2,
        track3 : track3,
        track4 : track4,
        track5 : track5,
        has_submitted : 1
      });
    }
    </script>

    <script>
      $(function() {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
      });
      </script>
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
  
$user_rated = user_rated($_SESSION['username']);
  echo "</div></div>";
?>
  <div class="main-container">
  <center><h2>Hi <b><?echo $_SESSION["username"]; ?></b>! 
    <?php echo $user_rated ? "" : "Rank the songs!";?></h2></center>

    <div class="description">
        On this page you can rank the songs in whatever order you like. In addition, you can view other users 
        rankings! Once you've put them in the order you like, feel free to go checkut the ordered list on your
        user page.<br> <em>
        <?php
if(isset($_POST['has_submitted'])){
  $err = update_rating($_SESSION['username'],
    $_POST['track1'],
    $_POST['track2'],
    $_POST['track3'],
    $_POST['track4'],
    $_POST['track5']);
  if (!$err) {
      echo 'Record updated successfully.';
  } else {
      echo "Error updating record: ".$err;
  }
}

?>
   </em>
</div></div>
<?php







$result = get_rating_list();
$sum_result = get_avg_rating();

?><table border='1' width='200' align = 'center'
         id= "myTable" style="cursor: pointer;"><?php


if ($result->num_rows > 0) {
    // output data of each row
    echo "<tr align = 'center'><th>"."Name"."</th>".
         "<th>"."Track1"."</th>".
         "<th>"."Track2"."</th>".    
         "<th>"."Track3"."</th>".
         "<th>"."Track4"."</th>".
         "<th>"."Track5"."</th>".
         "</tr>";
    while($row = $result->fetch_assoc()) {
      $bgcolor = ($row["username"] == $_SESSION['username']) ? 'bgcolor="#9090F0"' : '';
        echo "<tr  align = 'center' ".$bgcolor."><td>". $row["username"]."</td>".
             "<td width='80'>".$row["track1"]."</td>".
             "<td width='80'>".$row["track2"]."</td>".
             "<td width='80'>".$row["track3"]."</td>".
             "<td width='80'>".$row["track4"]."</td>".
             "<td width='80'>".$row["track5"]."</td></tr>";
    }

    while($row2 = $sum_result->fetch_assoc()) {
        echo "<tr  align = 'center' ><th>"."Average"."</th>".
         "<th>".$row2["avg_1"]."</th>".
         "<th>".$row2["avg_2"]."</th>".
         "<th>".$row2["avg_3"]."</th>".
         "<th>".$row2["avg_4"]."</th>".
         "<th>".$row2["avg_5"]."</th>".
         "</tr>";
    }
} else {
    echo "Nobody has voted yet.";
}
?>

</table>
<tr><td>
  <?php echo $user_rated ? "Update Your Ranking" : "Rank Your Favorite Track"; ?>:</td>

<button id="submit_form" onclick="submit_form();">
<?php echo  $user_rated? "Update" : "Submit";?></button>
</tr>
<ul id="sortable">
  <li class="ui-state-default" id='track_1'><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Track 1</li>
  <li class="ui-state-default" id='track_2'><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Track 2</li>
  <li class="ui-state-default" id='track_3'><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Track 3</li>
  <li class="ui-state-default" id='track_4'><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Track 4</li>
  <li class="ui-state-default" id='track_5'><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Track 5</li>
</ul>
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