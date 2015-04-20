<html>
<head>
    <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="http://jqueryui.com/resources/demos/style.css">
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
<?php


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


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if(isset($_POST['has_submitted'])){
	$sql = "INSERT INTO TEST2 (username,".
		"track1,track2,track3,track4,track5) VALUES('".
		$_SESSION["userName"]."',".
		$_POST['track1'].",".
		$_POST['track2'].",".
		$_POST['track3'].",".
		$_POST['track4'].",".
		$_POST['track5'].")";
	if ($conn->query($sql) === TRUE) {
	    echo "Record updated successfully";
	} else {
		echo $sql."<br>";
	    echo "Error updating record: " . $conn->error;
	}
}


// here!

$sql = "SELECT username,track1,track2,track3,track4,track5 FROM TEST2";
$result = $conn->query($sql);

$sum_sql = "SELECT SUM(track1), SUM(track2), SUM(track3), SUM(track4), SUM(track5) FROM TEST2";
$sum_result = $conn->query($sum_sql);
?><table border='1' width='200' align = 'center'
         id= "myTable" style="cursor: pointer;"><?php


if ($result->num_rows > 0) {
    // output data of each row
    echo "<tr><td>"."Name"."</td>".
         "<td>"."Track1"."</td>".
         "<td>"."Track2"."</td>".    
         "<td>"."Track3"."</td>".
         "<td>"."Track4"."</td>".
         "<td>"."Track5"."</td>".
         "</tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr><td>". $row["username"]."</td>".
             "<td width='80'>".$row["track1"]."</td>".
             "<td width='80'>".$row["track2"]."</td>".
             "<td width='80'>".$row["track3"]."</td>".
             "<td width='80'>".$row["track4"]."</td>".
             "<td width='80'>".$row["track5"]."</td></tr>";
    }

    while($row2 = $sum_result->fetch_assoc()) {
        echo "<tr><td>"."Aggregation"."</td>".
         "<td>".$row2["SUM(track1)"]."</td>".
         "<td>".$row2["SUM(track2)"]."</td>".
         "<td>".$row2["SUM(track3)"]."</td>".
         "<td>".$row2["SUM(track4)"]."</td>".
         "<td>".$row2["SUM(track5)"]."</td>".
         "</tr>";
    }
} else {
    echo "Nobody has voted yet.";
}

$sql = "SELECT id FROM TEST2 WHERE username='".$_SESSION["userName"]."'";

$result = $conn->query($sql); 
if ($result->num_rows==0) {
	?>
<!-- 
 <form method="post" action="rank.php" onSubmit="return validateForm()" >
            <tr>
                <td><?php echo $_SESSION["user_name"];?></td>
                <td><input type="text" name='track1' id='track1' required></td>
                <td><input type="text" name='track2' id='track2' required></td>
                <td><input type="text" name='track3' id='track3' required></td>
                <td><input type="text" name='track4' id='track4' required></td>
                <td><input type="text" name='track5' id='track5' required></td>
            </tr>
<tr><td> <input type="submit" name="submit"></td></tr>
</form>
 -->
</table>
<tr><td>Rank Your Favorite Track:"<br>";</td></tr>
<ul id="sortable">
  <li class="ui-state-default" id='track_1'><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Track 1</li>
  <li class="ui-state-default" id='track_2'><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Track 2</li>
  <li class="ui-state-default" id='track_3'><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Track 3</li>
  <li class="ui-state-default" id='track_4'><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Track 4</li>
  <li class="ui-state-default" id='track_5'><span class="ui-icon ui-icon-arrowthick-2-n-s"></span>Track 5</li>
</ul>
<button id="submit_form" onclick="submit_form();">Submit</button>

<?php
}

$conn->close();

?>

</body>
</html>