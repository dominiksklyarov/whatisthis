<?php
//all login details
require("../config.php");

//Start of creating account
function signup($username, $password){
    $notice = "";
    $mysqli = new mysqli($GLOBALS["dbServer"], $GLOBALS["dbUsername"], $GLOBALS["dbPassword"], $GLOBALS["dbName"]);
    $sql = $mysqli->prepare("SELECT id FROM users WHERE username=?");
    echo $mysqli->error;
    $sql-> bind_param("s",$username);
    $sql->execute();
    if($sql->fetch()){
        $notice = "Please choose another username!";
    } else {
        $sql->close();
        $sql = $mysqli->prepare("INSERT INTO users (username, password) VALUES (?,?)");
        echo $mysqli->error;
        $options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
        $pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
        $sql->bind_param("ss", $username, $pwdhash);
        if($sql->execute()) {
            $notice = "Worked!";
            header("Location:index.php?signup=success");
        } else {
            $notice = "Error!";
        }  
    }
    $sql->close();
    $mysqli->close();
    return $notice; 
}
//end of creating an account

//Start of logging into account

function login($username, $password){
$notice = "";
$mysqli = new mysqli($GLOBALS["dbServer"], $GLOBALS["dbUsername"], $GLOBALS["dbPassword"], $GLOBALS["dbName"]);
$sql = $mysqli->prepare("SELECT id, username, password FROM users WHERE username=?");
echo $mysqli->error;
$sql -> bind_param("s", $username);
$sql->bind_result($idFromDb, $usernameFromDb, $passwordFromDb);
if($sql->execute()){
    if($sql->fetch()){
        if(password_verify($password,$passwordFromDb)){
    $notice="Logged in!";
    $_SESSION["user_id"]= $idFromDb;
    $_SESSION["username"] = $usernameFromDb;
    $sql->close();
    $mysqli->close();
    //if you're an admin
    if($usernameFromDb == "administa"){
    header("Location: admin.php");
        }
        else { //if you're not an admin 
            header("Location: welcome.php");
                exit();
            }
        }
    }
}
$sql->close();
$mysqli->close();
return $notice;
}
//End of logging into account!

?>