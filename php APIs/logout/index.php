<?php
session_start();

session_destroy();

if(isset($_COOKIE['st-id'])){
   setcookie("st-id", "", time()-3600, "/");
}
else if(isset($_COOKIE['in-id'])){
   setcookie("in-id", "", time()-3600, "/");
}

header("location: /");
?>