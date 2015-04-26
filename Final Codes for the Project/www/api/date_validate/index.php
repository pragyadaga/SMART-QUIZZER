<?php
///////////////// Check for date and time collisions
session_start();

include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; // Include the database connection file
if(!isset($_POST["date"]) && !isset($_POST["class_id"]))
    header("location: /");
else{
    $duration=(30*60)+(10*60);  /////////////// Test duration + Gap between two tests 
    
    $date_time=$_POST['date'];
    $date_split=explode(' ', $date_time);
    
    $test_date=$date_split[0];
    $test_date=date("Y-m-d", strtotime($test_date));
    $test_time=$date_split[1];
    
    if($date_split[2]=='PM'){
        $hrs=explode(':', $test_time);
        $hr=$hrs[0];
        $hr+=12;
        $test_time=$hr.':'.$hrs[1].':'.'00';
    }
    
    $prev_test=date('Y-m-d H:i:s', strtotime($test_date." ".$test_time)-$duration);
    $next_test=date('Y-m-d H:i:s', strtotime($test_date." ".$test_time)+$duration);
    
    $prev_test=explode(' ', $prev_test);
    $prev_test_date=$prev_test[0];
    $prev_test_time=$prev_test[1];
    
    $next_test=explode(' ', $next_test);
    $next_test_date=$next_test[0];
    $next_test_time=$next_test[1];
  
     
        foreach($_POST["class_id"] as $class_id){ ///////////////// Check for date and time collisions
        $result=mysqli_query($conn,"SELECT test_id FROM test WHERE class_id='$class_id' and date>='$prev_test_date' and date<='$next_test_date' and time>='$prev_test_time' and time<='$next_test_time'");
        
        if (mysqli_num_rows($result)){
            echo "invalid"; ///////////////// Already a quiz is scheduled on the given date and time
        }
        
    }
}
echo "valid";
?>