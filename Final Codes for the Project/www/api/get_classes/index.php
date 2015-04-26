<?php

// Get the classes for a given course taught by the instructor

session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php";		//Connection to the database is done in consql.php, including that file  here 


if(isset($_POST['course_id'])){     // for selected course
    $course_id=$_POST['course_id'];
    
    $result = mysqli_query($conn,"SELECT class_id FROM offers WHERE i_id='$in_id' and course_id='$course_id'");
    while($row = mysqli_fetch_array($result)){   // Check whether the entry exists
        echo $row['class_id'].",";
    }
}
else
    header("location : /");  //redirect to homepage

?>