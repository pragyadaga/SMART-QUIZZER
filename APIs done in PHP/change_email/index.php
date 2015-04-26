<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 
$st_login="no";
$in_login="no";
if(isset($_SESSION['st-id'])){
    $st_id=base64_decode($_SESSION['st-id']);
    $st_login="yes";
}
else if(isset($_COOKIE['st-id'])){
    $st_id=base64_decode($_COOKIE['st-id']);
    $st_login="yes";
}

if(isset($_SESSION['in-id'])){
    $in_id=base64_decode($_SESSION['in-id']);
    $in_login="yes";
}
else if(isset($_COOKIE['in-id'])){
    $in_id=base64_decode($_COOKIE['in-id']);
    $in_login="yes";
}



if($in_login=="yes"){
    $password=mysqli_real_escape_string($conn, $_POST["password"]);
    $new_email=mysqli_real_escape_string($conn, $_POST["new_email"]);
    
    $result=mysqli_query($conn,"SELECT * FROM instructor WHERE i_id='$in_id' and i_password='$password'");
    
    if (mysqli_num_rows($result)){
        if(mysqli_query($conn, "UPDATE instructor SET email='$new_email' WHERE i_id='$in_id'"))
            echo "success";
    }
    else{
        echo "passError";
    }
}
else if($st_login=="yes"){
    $password=mysqli_real_escape_string($conn, $_POST["password"]);
    $new_email=mysqli_real_escape_string($conn, $_POST["new_email"]);
    
    $result=mysqli_query($conn,"SELECT * FROM student WHERE USN='$st_id' and s_password='$password'");
    
    if (mysqli_num_rows($result)){
        if(mysqli_query($conn, "UPDATE student SET email='$new_email' WHERE USN='$st_id'"))
            echo "success";
    }
    else{
        echo "passError";
    }
}

else
    header("location : /");
?>