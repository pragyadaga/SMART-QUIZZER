<?php
$servername = "localhost";
$username = "root";
$password = "";
$database="smart_quizzer";

$conn =  mysqli_connect($servername, $username, $password, $database);

$st_login="no";
$in_login="no";
if(isset($_SESSION['st-id'])){
    $st_id=base64_decode($_SESSION['st-id']);
    $st_login="yes";
}
else if(isset($_COOKIE['st-id'])){
    $st_id=base64_decode($_COOKIE['st-id']);
    $st_login="yes";
}

if(isset($_SESSION['in-id'])){
    $in_id=base64_decode($_SESSION['in-id']);
    $in_login="yes";
}
else if(isset($_COOKIE['in-id'])){
    $in_id=base64_decode($_COOKIE['in-id']);
    $in_login="yes";
}

if($in_login=="yes"){
    $result=mysqli_query($conn,"SELECT i_name FROM instructor WHERE i_id='$in_id'");
    $row=mysqli_fetch_array($result);
    $in_name=$row['i_name'];
}
?>