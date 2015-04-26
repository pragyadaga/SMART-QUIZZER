<?php

//API for logout

session_start();

if(isset($_SESSION['admin-id'])){    // if admin has logged in
    session_destroy();
    header("location: /admin/");  //redirect to admin login page
}

else{
    session_destroy();
    header("location: /");   //redirect to homepage
}
        // destroying cookoies
if(isset($_COOKIE['st-id'])){
   setcookie("st-id", "", time()-3600, "/");     // negative time will destroy the cookie
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