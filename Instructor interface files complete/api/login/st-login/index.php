<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; // Include the database connection file

if(!isset($_POST["id"]))
    header("location: /");
else{
    $id_=mysqli_real_escape_string($conn, $_POST["id"]);
    $password_=mysqli_real_escape_string($conn, $_POST["password"]);
    $remember_=$_POST["remember"];
    
    $result=mysqli_query($conn,"SELECT * FROM student WHERE USN='$id_' and s_password='$password_'");
    if (mysqli_num_rows($result)){
        if($remember_=="true"){ // Set Cookie
            setcookie("st-id", base64_encode($id_), time() + (86400 * 30), "/");
        }
        else{ // Set Session
            $_SESSION['st-id']=base64_encode($id_);
        }
    }
    else if(mysqli_num_rows(mysqli_query($conn,"SELECT * FROM student WHERE USN='$id_'"))){
        echo "passError";
    }
    else{
        echo "nameError";
    }
}
?>