<?php
////////////////////// API to add a student

session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 

$usn=mysqli_real_escape_string($conn, $_POST["usn"]);
$name=mysqli_real_escape_string($conn, $_POST["name"]);
$email=mysqli_real_escape_string($conn, $_POST["email"]);
$class=mysqli_real_escape_string($conn, $_POST["class"]);
$course=mysqli_real_escape_string($conn, $_POST["course"]);
$flag=1;
$status=1;
$name_array=explode(',',$course);
 
$result=mysqli_query($conn,"SELECT * FROM student WHERE USN='$usn'"); /////////////////// Check whether the student already exists
$result1=mysqli_query($conn,"SELECT * FROM student WHERE email='$email'"); /////////////////// Validate the email
$result2=mysqli_query($conn,"SELECT * FROM class WHERE class_id='$class'"); /////////////////// Validate the class ID


if (mysqli_num_rows($result)){
        
            echo "USN";
            $status=0;
    }else if (mysqli_num_rows($result1)){
        
            echo "Email";
            $status=0;
    }else if(!mysqli_num_rows($result2)){
        
            echo "Class";
            $status=0;
    }else if($flag){
            foreach($name_array as $course1){
            $result3=mysqli_query($conn,"SELECT * FROM offers WHERE course_id='$course1'");
            if(!mysqli_num_rows($result3)){
                echo "Course";
                $status=0;
            }
        }
     }
        if($status){
        mysqli_query($conn, "INSERT INTO student VALUES('$usn','$email','$name','$usn','$usn')");
        mysqli_query($conn, "INSERT INTO list_of_students VALUES('$usn','$class')");
        foreach($name_array as $course2){
            mysqli_query($conn, "INSERT INTO takes VALUES('$usn','$course2')");
             
        }
        echo "ok";
}


?>