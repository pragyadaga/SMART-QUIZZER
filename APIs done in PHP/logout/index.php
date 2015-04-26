<?php
session_start();

if(isset($_SESSION['admin-id'])){
    session_destroy();
    header("location: /admin/");
}

else{
    session_destroy();
    header("location: /");
}

if(isset($_COOKIE['st-id'])){
   setcookie("st-id", "", time()-3600, "/");
   header("location: /");
}
else if(isset($_COOKIE['in-id'])){
   setcookie("in-id", "", time()-3600, "/");
   header("location: /");
}
else if(isset($_COOKIE['admin-id'])){
   setcookie("admin-id", "", time()-3600, "/");
   header("location: /admin/");
}
?>