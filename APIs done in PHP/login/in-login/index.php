<?php
session_start();

include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; // Include the database connection file

if(!isset($_POST["id"]))
    header("location: /");
else{
    $id_=mysqli_real_escape_string($conn, $_POST["id"]);
    $password_=mysqli_real_escape_string($conn, $_POST["password"]);
    $remember_=$_POST["remember"];
    
    $result=mysqli_query($conn,"SELECT * FROM instructor WHERE i_id='$id_' and i_password='$password_'");
    
    if (mysqli_num_rows($result)){
        if($remember_=="true"){ // Set Cookie
            setcookie("in-id", base64_encode($id_), time() + (86400 * 30), "/");
        }
        else{ // Set Session
            $_SESSION['in-id']=base64_encode($id_);
        }
    }
    else{
        echo "nameError";
    }
}
?>