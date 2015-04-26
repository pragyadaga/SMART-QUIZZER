<?php
/////////////////// API to add a new instructor
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 

$id=mysqli_real_escape_string($conn, $_POST["id"]);
$name=mysqli_real_escape_string($conn, $_POST["name"]);
$email=mysqli_real_escape_string($conn, $_POST["email"]);
$class=mysqli_real_escape_string($conn, $_POST["class"]);
$course=mysqli_real_escape_string($conn, $_POST["course"]);
$flag=1;
$status=1;
$name_array=explode(',',$course);

$result=mysqli_query($conn,"SELECT * FROM instructor WHERE i_id='$id'"); /////////////////// Check whether the instructor already exists
$result1=mysqli_query($conn,"SELECT * FROM instructor WHERE email='$email'"); /////////////////// Validate the email
$result2=mysqli_query($conn,"SELECT * FROM class WHERE class_id='$class'"); /////////////////// Validate the class ID


if (mysqli_num_rows($result)){
            echo "i_id";
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
                break;
            }
            else{
             $result4=mysqli_query($conn,"SELECT * FROM offers WHERE course_id='$course1' and class_id='$class'");   
             if(mysqli_num_rows($result4)){
                echo "took";    
                $status=0;
                break;
             }
                
            }
        }
     }
        if($status){
        mysqli_query($conn, "INSERT INTO instructor VALUES('$id','$name','$email','$id','$id')");
        foreach($name_array as $course2){
            mysqli_query($conn, "INSERT INTO offers VALUES('$course2','$id','$class')");    
        }
        echo "ok";
}


?>