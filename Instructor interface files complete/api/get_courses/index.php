<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 


if(isset($_POST['request'])){
    
    if(isset($_SESSION['in-id'])){
        $in_id=base64_decode($_SESSION['in-id']);
    }
    else if(isset($_COOKIE['in-id'])){
        $in_id=base64_decode($_COOKIE['in-id']);
    }
    
    $result = mysqli_query($conn,"SELECT course_id FROM offers WHERE i_id='$in_id'");
    while($row = mysqli_fetch_array($result)){
        echo $row['course_id'].",";
    }
}
else
    header("location : /");
?>