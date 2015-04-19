<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 


if(isset($_POST['course_id'])){
    $course_id=$_POST['course_id'];
    if(isset($_SESSION['in-id'])){
        $in_id=base64_decode($_SESSION['in-id']);
    }
    else if(isset($_COOKIE['in-id'])){
        $in_id=base64_decode($_COOKIE['in-id']);
    }
    
    $result = mysqli_query($conn,"SELECT class_id FROM offers WHERE i_id='$in_id' and course_id='$course_id'");
    while($row = mysqli_fetch_array($result)){
        echo $row['class_id'].",";
    }
}
else
    header("location : /");
?>