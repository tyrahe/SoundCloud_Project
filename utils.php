<?php


function get_conn() {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "myDB2";
	return new mysqli($servername, $username, $password, $dbname);
}


if (get_conn()->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

function user_exist($username) {
	$conn = get_conn();
	$stmt = $conn->prepare("SELECT * FROM TEST2 WHERE username=?");
	$stmt->bind_param('s',$username);
	$stmt->execute();
	$exist = $stmt->fetch();
	$conn->close();
    return $exist;
}
function user_rated($username) {
	$conn = get_conn();
	$stmt = $conn->prepare("SELECT * FROM TEST2 WHERE username=? AND rated=1");
	$stmt->bind_param('s',$username);
	$stmt->execute();
	$exist = $stmt->fetch();
	$conn->close();
    return $exist;
}

function update_rating($username,$v1,$v2,$v3,$v4,$v5) {
	$conn = get_conn();
	$stmt = $conn->prepare("UPDATE TEST2 SET track1=?,track2=?,track3=?,track4=?,track5=?,rated=1 WHERE username=?");
	$stmt->bind_param('iiiiis',$v1,$v2,$v3,$v4,$v5,$username);
	$stmt->execute();
	$conn->close();
    return $stmt->error;
}

function authenticate($username, $password) {
	$conn = get_conn();
	$stmt = $conn->prepare("SELECT * FROM TEST2 WHERE username=? AND password=?");
	$stmt->bind_param('ss',$username,$password);
	$stmt->execute();
	$exist = $stmt->fetch();
	$conn->close();
    return $exist;
}

function add_user($username, $password) {
	$conn = get_conn();
    $stmt = $conn->prepare("INSERT INTO TEST2(username,password) VALUES (?,?)");
	$stmt->bind_param('ss',$username,$password);
	$stmt->execute();
	$conn->close();
    return $stmt->error;
}

function Redirect($url, $permanent = false)
{
    if (headers_sent() === false) {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }
    exit();
}

function get_rating_list() {
	$conn = get_conn();
	$sql = "SELECT username,track1,track2,track3,track4,track5 FROM TEST2 WHERE rated=1";
	$result = $conn->query($sql);
	return $result;
}

function get_rating($username) {
	$conn = get_conn();
	$stmt = $conn->prepare("SELECT track1,track2,track3,track4,track5 FROM TEST2 WHERE username=? AND rated=1");
	$stmt->bind_param('s',$username);
	$stmt->execute();
	$stmt->bind_result($v1,$v2,$v3,$v4,$v5);
	$row = $stmt->fetch();
	if (!$row) {
		return false;
	}
	return array($v1,$v2,$v3,$v4,$v5);
}


function get_avg_rating() {
	$conn = get_conn();
	$sql = "SELECT ROUND(AVG(track1),1) AS avg_1,
	ROUND(AVG(track2),1) AS avg_2,
	ROUND(AVG(track3),1) AS avg_3,
	ROUND(AVG(track4),1) AS avg_4,
	ROUND(AVG(track5),1) AS avg_5 FROM TEST2 WHERE rated=1";
	$result = $conn->query($sql);
	return $result;
}




?>