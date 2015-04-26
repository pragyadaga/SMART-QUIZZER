<?php
//////////////////// Databse connection program for admin
$servername = "localhost";
$username = "root";
$password = "";
$database="smart_quizzer";

$conn =  mysqli_connect($servername, $username, $password, $database);

$admin_login="no";
$admin_id="";

if(isset($_SESSION['admin-id'])){ //////////////////// Check whether an admin is logged in
    $admin_id=base64_decode($_SESSION['admin-id']);
    $admin_login="yes";
}
else if(isset($_COOKIE['admin-id'])){
    $admin_id=base64_decode($_COOKIE['admin-id']);
    $admin_login="yes";
}
if($admin_login=="yes"){
    $result=mysqli_query($conn,"SELECT admin_name FROM admin WHERE admin_id='$admin_id'"); //////////////////// Get the admin name
    $row=mysqli_fetch_array($result);
    $admin_name=$row['admin_name'];
}
?>