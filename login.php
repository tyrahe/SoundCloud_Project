<?php

session_start();
$_SESSION["user_name"] = $_GET['name'];
echo "Hello ".$_SESSION["user_name"];

?>