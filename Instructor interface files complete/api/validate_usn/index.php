<?php

include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; // Include the database connection file

if(!isset($_POST["usn"]))
    header("location: /");
else{
    $id_=mysqli_real_escape_string($conn, $_POST["usn"]);
    $course_=$_POST["course_"];
    
    $result=mysqli_query($conn,"SELECT * FROM student WHERE USN='$id_'");
    
    if (mysqli_num_rows($result)){
        $result1=mysqli_query($conn,"SELECT USN FROM takes WHERE USN='$id_' and course_id='$course_'");
        
        if(mysqli_num_rows($result1)){
            echo "success";
        }
        else{
            echo "notexist";
        }
    }
    else{
        echo "invalid";
    }
}
?>