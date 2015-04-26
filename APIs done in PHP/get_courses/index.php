<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 

if($in_login=="yes"){  
    $result = mysqli_query($conn,"SELECT course_id FROM offers WHERE i_id='$in_id'");
    
    while($row = mysqli_fetch_array($result)){
        echo $row['course_id'].",";
    }
}
else if($st_login=="yes"){
    $result = mysqli_query($conn,"SELECT course_id FROM takes WHERE USN='$st_id'");
    
    while($row = mysqli_fetch_array($result)){
        echo $row['course_id'].",";
    }
}
else
    header("location : /");
?>