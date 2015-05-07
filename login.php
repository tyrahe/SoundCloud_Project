<!-- 

Created by Tyra He.

Login page, lets users either create new username and password (and subsequently
stores their information in the database) or allows returning users to log in.
-->

<?php
require 'utils.php';

session_start();
$status = "ok";

//Check whether the user is signs up or is signing in
if (isset($_POST['signup'])) { 
    $uname = $_POST['username'];
    $pwd = $_POST['pwd'];
    if (user_exist($uname)) {
        $status = "user_exist";
    } else {
        if (!add_user($uname, $pwd)) {
            $_SESSION["username"] = $uname;
            Redirect('aggregate.php',False);
            die();
        } else {
            $status = "db_error";
        }
    }
} elseif (isset($_POST['signin'])) {
    $uname = $_POST['username_ret'];
    $pwd = $_POST['pwd_ret'];
    if (authenticate($uname, $pwd)) {
        $_SESSION["username"] = $uname;
        if (user_rated($_SESSION["username"])) {
            Redirect('userpage.php',False);
        } else {
            Redirect('aggregate.php',False);
        }
        
        die();
    } else {
        $status = "login_fail";
    }
}

?>
<html>
<head>
<title>User Login</title>
</head>
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
    
    <!-- Checks whether the passwords match -->
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
    <script>

    //Validates new user form
    function validateForm() {
        var val = document.getElementById('username').value;
        if (val.length == 0) {
            alert("Empty username");
            return false;
        }
        var val = document.getElementById('pwd').value;
        if (val.length == 0) {
            alert("Empty password");
            return false;
        }
        var val2 = document.getElementById('pwdCheck').value;
        if (val != val2) {
            alert("Two passwords are different.");
            return false;
        }
        return true;
    }
    //Validates returning user from
    function validateForm_ret() {
        var val = document.getElementById('username_ret').value;
        if (val.length == 0) {
            alert("Empty username");
            return false;
        }
        var val = document.getElementById('pwd_ret').value;
        if (val.length == 0) {
            alert("Empty password");
            return false;
        }
        return true;
    }
    </script>


<div class="main-page-wrap">
    <div class="login-header-container">Jameez</div>
    <div class='main-container'><div class='welcome'>

        <?php 
        switch ($status) {
        case "login_fail":
            echo "Authentication failed.";
            break;
        case "user_exist":
            echo "Username is already taken";
            break;
        case "db_error":
            echo "Internal Database Error";
            break;
        default:
            echo "Please log in to use our app!";
        }
        ?>
        
        </div></div>

    <div class="main-container">
        <!-- Login for new users -->
        <div class="col-left">    
            <h1>New Users</h1>
            <form method="post" action="login.php" onsubmit="return validateForm();" >
                <table border="0" cellspacing="1" width="500" align="center">
                    <tr>
                        <td align="right"><label for="username">Username: </label></td>
                        <td><input type="text" name="username" id="username" /></td>
                    </tr>
                    <tr>
                        <td align="right"><label for="pwd">Password: </label></td>
                        <td><input type="password" name="pwd" id="pwd" onChange="checkPasswordMatch();" /></td>
                    </tr>
                    <tr>
                        <td align="right"><label for="pwd">Confirm Password: </label></td>
                        <td><input type="password" id="pwdCheck" onChange="checkPasswordMatch();"/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><div class="registrationFormAlert" id="divCheckPasswordMatch"></div></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><div class="line submit"><input type="submit" name="signup" value="Sign up" /></div></td>
                    </tr>
                </table>
            </form>
        </div>

        <!-- Login for returning users-->
         <div class="col-right">
            <h1>Returning Users</h1>
            <form method="post" action="login.php" onsubmit="return validateForm_ret();">
                <table border="0" cellspacing="1" width="500" align="center">
                    <tr class="tablerow">
                        <td align="right">Username</td>
                        <td><input id='username_ret' type="text" name="username_ret"></td>
                    </tr>
                    <tr class="tablerow">
                        <td align="right">Password</td>
                        <td><input id='pwd_ret' type="password" name="pwd_ret"></td>
                    </tr>
                    <tr class="tableheader">
                        <td align="center" colspan="2"><input type="submit" name="signin" value="Sign in" /></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

</body>
</html>
