<?php

require("functions.php");

$notice = "";
$success = "";
$username = "";
$UsernameError = "";
$PasswordError = "";

if(isset($_POST["login"])){

    if (isset($_POST["username"]) and !empty($_POST["username"])){
        $username = $_POST["username"];
    } else {
        $UsernameError = "Please type correct username!";
    }

    if (isset($_POST["password"]) and !empty($_POST["password"])){
        $password = $_POST["password"];
    } else {
        $PasswordError = "Password error!";
    }

    if (empty($UsernameError) and empty($PasswordError)){
        $notice = login($username, $_POST["password"]);
    }
}
?>

<html>
    <head>
        <title>
            Login
        </title>
        </head>

<body>
<form method="POST">
    <input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username"><span><?php echo $UsernameError?></span>
    <input type="password" name="password" value="<?php echo $password; ?>" placeholder="Password"><span><?php echo $PasswordError?></span>
    <input type="submit" value="Let's go!" name="login"><span><?php echo $notice;?></span>
</form>

</body>

</html>