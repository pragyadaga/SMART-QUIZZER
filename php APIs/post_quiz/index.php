<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 

if(isset($_SESSION['in-id'])){
    $in_id=base64_decode($_SESSION['in-id']);
}
else if(isset($_COOKIE['in-id'])){
    $in_id=base64_decode($_COOKIE['in-id']);
}
else
    header("location:/");


if(isset($_POST['course_id'])){
    $course_id=$_POST['course_id'];
    $class_id=$_POST['class_id'];
    $questions=$_POST['questions'];
    $date_time=$_POST['date'];
    

    $date_split=explode(' ',$date_time);
    
    $test_date=$date_split[0];
    $test_date=date("Y-m-d", strtotime($test_date));
    
    $test_time=$date_split[1];
    
    if($date_split[2]=='PM'){
        $hrs=explode(':', $test_time);
        $hr=$hrs[0];
        $hr+=12;
        $test_time=$hr.':'.$hrs[1].':'.'00';
    }
    
    for($i=0; $i<sizeof($class_id); $i++){
        mysqli_query($conn, "INSERT INTO test values ('$class_id[$i]','','$course_id','$in_id','$test_date','$test_time')");
        
        $result= mysqli_query($conn, "SELECT MAX(test_id) from test WHERE i_id='$in_id'");
        $row = mysqli_fetch_array($result);
        
        $test_id=$row[0];
        
        //////////////////// Insert into questions table
        
        for($j=0; $j<sizeof($questions); $j++){
            $que_=mysqli_real_escape_string($conn, $questions[$j]['ques']);
            $ans_=mysqli_real_escape_string($conn, $questions[$j]['ans']);
            mysqli_query($conn, "INSERT INTO question values ('','$test_id','$que_','$ans_')");
        }
    }
    
    //date_default_timezone_set('Asia/Kolkata');
    //$dateq = date('m/d/Y h:i:s a', time());
    
}

?>