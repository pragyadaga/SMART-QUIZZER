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
    $cur_password=mysqli_real_escape_string($conn, $_POST["cur_password"]);
    $new_password=mysqli_real_escape_string($conn, $_POST["new_password"]);
    
    $result=mysqli_query($conn,"SELECT * FROM instructor WHERE i_id='$in_id' and i_password='$cur_password'");
    
    if (mysqli_num_rows($result)){
        if(mysqli_query($conn, "UPDATE instructor SET i_password='$new_password' WHERE i_id='$in_id'"))
            echo "success";
    }
    else{
        echo "passError";
    }
}
else if($st_login=="yes"){

}

else
    header("location : /");
?>