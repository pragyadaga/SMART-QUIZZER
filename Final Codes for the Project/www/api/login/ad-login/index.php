<?php

// API for admin login

session_start();

include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; // Include the database connection file

if(isset($_POST['id']) && isset($_POST['password'])){
    $id_=mysql_real_escape_string($_POST['id']);                //Escape the special characters
    $password_=mysql_real_escape_string($_POST['password']);
    $remember_=$_POST["remember"];

    $result=mysqli_query($conn, "SELECT admin_id FROM admin WHERE admin_id='$id_' and admin_password='$password_'");

    if (mysqli_num_rows($result)){   // Check whether the entry exists
        if($remember_=="true"){     // Set Cookie
            setcookie("admin-id", base64_encode($id_), time() + (86400 * 30), "/");
        }
        else{           // Set Session
            $_SESSION['admin-id']=base64_encode($id_);
        }
    }
    else{
        echo "nameError";
    }
}
?>