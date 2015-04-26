<?php
///////////////////API to change the email

session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 

if($in_login=="yes"){ /////////////////// For instructor
    $password=mysqli_real_escape_string($conn, $_POST["password"]);
    $new_email=mysqli_real_escape_string($conn, $_POST["new_email"]);
    
    $result=mysqli_query($conn,"SELECT * FROM instructor WHERE i_id='$in_id' and i_password='$password'");
    
    if (mysqli_num_rows($result)){
        if(mysqli_query($conn, "UPDATE instructor SET email='$new_email' WHERE i_id='$in_id'"))
            echo "success";
    }
    else{
        echo "passError"; /////////////////// Wrong password
    }
}
else if($st_login=="yes"){ /////////////////// For student
    $password=mysqli_real_escape_string($conn, $_POST["password"]);
    $new_email=mysqli_real_escape_string($conn, $_POST["new_email"]);
    
    $result=mysqli_query($conn,"SELECT * FROM student WHERE USN='$st_id' and s_password='$password'");
    
    if (mysqli_num_rows($result)){
        if(mysqli_query($conn, "UPDATE student SET email='$new_email' WHERE USN='$st_id'"))
            echo "success";
    }
    else{
        echo "passError"; /////////////////// Wrong password
    }
}

else
    header("location : /");
?>