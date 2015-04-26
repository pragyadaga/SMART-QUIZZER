<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 

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
    $cur_password=mysqli_real_escape_string($conn, $_POST["cur_password"]);
    $new_password=mysqli_real_escape_string($conn, $_POST["new_password"]);
    
    $result=mysqli_query($conn,"SELECT * FROM student WHERE USN='$st_id' and s_password='$cur_password'");
    
    if (mysqli_num_rows($result)){
        if(mysqli_query($conn, "UPDATE student SET s_password='$new_password' WHERE USN='$st_id'"))
            echo "success";
    }
    else{
        echo "passError";
    }
}

else
    header("location : /");
?>