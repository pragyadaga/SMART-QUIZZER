<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 
ini_set('max_execution_time', 300);
if(isset($_POST['file1'])){
    $pyscript = 'C:\\wamp\\www\\api\\combined_nltk\\combined_nltk.py';
    $python = 'C:\\Python34\\python.exe';
    $file_path ='C:\\wamp\\www\\upload\\files\\'.$_POST['file1'];
    $start_page=$_POST['start_page'];
    $end_page=$_POST['end_page'];

    $cmd = "$python $pyscript $file_path $start_page $end_page";
    exec("$cmd", $output);
    echo $output[0];
}
?>