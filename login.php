<?php
session_start();
$_SESSION["user_name"] = $_GET['name'];
echo "Hello ".$_SESSION["user_name"];

?>


<html>
<head>
<title>User Login</title>
</head>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>
function checkPasswordMatch() {
    var password = $("#pwd").val();
    var confirmPassword = $("#pwdCheck").val();

    if (password != confirmPassword)
        $("#divCheckPasswordMatch").html("Passwords do not match!");
    else
        $("#divCheckPasswordMatch").html("Passwords match.");
}
$(document).ready(function () {
   $("#pwdCheck").keyup(checkPasswordMatch);
});
</script>

<body>
<form name="frmUser" method="post" action="">
<table border="0" cellpadding="10" cellspacing="1" width="500" align="center">
<tr class="tableheader">
<td align="center" colspan="2">Registered User Login</td>
</tr>
<tr class="tablerow">
<td align="right">Username</td>
<td><input type="text" name="userName"></td>
</tr>
<tr class="tablerow">
<td align="right">Password</td>
<td><input type="password" name="password"></td>
</tr>
<tr class="tableheader">
<td align="center" colspan="2"><input type="submit" name="submit" value="Submit"></td>
</tr>
</table>
</form>
</body>
<body>
        <div id="container">
            <form>
                <h4>Create Logon</h4>
                <div class="line"><label for="username">Username: </label><input type="text" id="username" /></div>
                <div class="line"><label for="pwd">Password: </label><input type="password" id="pwd" /></div>
                <!-- You may want to consider adding a "confirm" password box also -->
                <div class="line"><label for="pwd">Conform Password: </label><input type="password" id="pwdCheck" onChange="checkPasswordMatch();"/></div>
                <div class="registrationFormAlert" id="divCheckPasswordMatch"></div>
                <div class="line submit"><input type="submit" value="Submit" /></div>
             </form>
        </div>
    </body>
</html>