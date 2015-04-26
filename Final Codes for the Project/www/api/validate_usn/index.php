<?php
    
//API for validation of usn

include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; // Include the database connection file

if(!isset($_POST["usn"]))
    header("location: /");
else{
    $id_=mysqli_real_escape_string($conn, $_POST["usn"]);     //Escape the special character
    $course_=$_POST["course_"];
    
    $result=mysqli_query($conn,"SELECT * FROM student WHERE USN='$id_'");  // To check whether the USN exists
      
    if (mysqli_num_rows($result)){     // Check whether the entry exists
        $result1=mysqli_query($conn,"SELECT USN FROM takes WHERE USN='$id_' and course_id='$course_'");   // To check whether the USN has taken the course
        
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