<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 


if(isset($_POST['course_id'])){
    $course_id=$_POST['course_id'];
    
    $result = mysqli_query($conn,"SELECT class_id FROM offers WHERE i_id='$in_id' and course_id='$course_id'");
    while($row = mysqli_fetch_array($result)){
        echo $row['class_id'].",";
    }
}
else
    header("location : /");
?>