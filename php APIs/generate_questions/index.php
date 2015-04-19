<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 

if(isset($_POST['file1'])){
    $pyscript = 'C:\\wamp\\www\\api\\combined_nltk\\combined_nltk.py';
    $python = 'C:\\Python34\\python.exe';
    $filePath ='C:\\wamp\\www\\upload\\files\\'.$_POST['file1'];

    $cmd = "$python $pyscript $filePath 0 10";
    exec("$cmd", $output);
    echo $output[0];
}
?>