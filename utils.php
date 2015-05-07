<?php

/*
 * Created by Tyra He.
 * This file is the checking system for registered users to log in. When a user filled in the password to log into the
 * system, the database checks character-by-character to make sure the password is correct before allowing the user to 
 * get in. Also, when a new user is registering, this file also modifies the database to save the user name and its 
 * password into the database.
 *
 */

/*
 * This function checks the connection between the database and the webpage.
 */
function get_conn() {
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "myDB3";
	return new mysqli($servername, $username, $password, $dbname);
}


if (get_conn()->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

/*
 * This function checks the whether the user exists in the database. 
 */
function user_exist($username) {
	$conn = get_conn();
	$stmt = $conn->prepare("SELECT * FROM TEST2 WHERE username=?");
	$stmt->bind_param('s',$username);
	$stmt->execute();
	$exist = $stmt->fetch();
	$conn->close();
    return $exist;
}

/*
 * This function checks whether the user has already rated all the songs. This is a state check.
 */
function user_rated($username) {
	$conn = get_conn();
	$stmt = $conn->prepare("SELECT * FROM TEST2 WHERE username=? AND rated=1");
	$stmt->bind_param('s',$username);
	$stmt->execute();
	$exist = $stmt->fetch();
	$conn->close();
    return $exist;
}

/*
 * This function checks whether the rating has been updated.
 */
function update_rating($username,$v1,$v2,$v3,$v4,$v5) {
	$conn = get_conn();
	$stmt = $conn->prepare("UPDATE TEST2 SET track1=?,track2=?,track3=?,track4=?,track5=?,rated=1 WHERE username=?");
	$stmt->bind_param('iiiiis',$v1,$v2,$v3,$v4,$v5,$username);
	$stmt->execute();
	$conn->close();
    return $stmt->error;
}


/*
 * This function checks whether the user has the authentication to rate.
 */
function authenticate($username, $password) {
	$conn = get_conn();
	$stmt = $conn->prepare("SELECT * FROM TEST2 WHERE username=? AND password=?");
	$stmt->bind_param('ss',$username,$password);
	$stmt->execute();
	$exist = $stmt->fetch();
	$conn->close();
    return $exist;
}

/*
 * This function allows the database to add a new user.
 */
function add_user($username, $password) {
	$conn = get_conn();
    $stmt = $conn->prepare("INSERT INTO TEST2(username,password) VALUES (?,?)");
	$stmt->bind_param('ss',$username,$password);
	$stmt->execute();
	$conn->close();
    return $stmt->error;
}

/*
 * This function redirects the user to the main page.
 */
function Redirect($url, $permanent = false)
{
    if (headers_sent() === false) {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }
    exit();
}

/*
 * This function works with the sorting function later to enable a list of ordered songs.
 */
function get_rating_list() {
	$conn = get_conn();
	$sql = "SELECT username,track1,track2,track3,track4,track5 FROM TEST2 WHERE rated=1";
	$result = $conn->query($sql);
	return $result;
}

/*
 * This function retrieves the rating order.
 */
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


/*
 * This function calculates the numerical average and display in the form in the rank webpage.
 */
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