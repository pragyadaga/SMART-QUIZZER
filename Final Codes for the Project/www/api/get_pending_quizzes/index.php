<?php
////////////////// API to display the list of pending quizzes
date_default_timezone_set('Asia/Kolkata'); ////////////////// Set the current timezone

if($in_login=="yes"){ ////////////////// For instructor
    $duration=(30*60)+(5*60);

    $cur_time_now=date('H:i:s');

    $cur_time=date('H:i:s', strtotime($cur_time_now)-$duration);
    $cur_date=date('Y-m-d', strtotime($cur_time_now)-$duration);
    
    $sql="SELECT count(*) as total FROM test t WHERE TIMESTAMP(t.date,t.time)>=TIMESTAMP('$cur_date','$cur_time') and t.i_id='$in_id'";
    $result = mysqli_query($conn,$sql);

    $row=mysqli_fetch_array($result);
    $pending_count=$row['total']-1; ////////////////// Total number of quizzes pending
}
else if($st_login=="yes"){ ////////////////// For student
    $duration=5*60;

    $cur_time_now=date('H:i:s');

    $cur_time=date('H:i:s', strtotime($cur_time_now)-$duration);
    $cur_date=date('Y-m-d', strtotime($cur_time_now)-$duration);

    $sql = "SELECT t.date, count(*) as total FROM test t, list_of_students l WHERE TIMESTAMP(t.date,t.time)>=TIMESTAMP('$cur_date','$cur_time') and l.USN='$st_id' and l.class_id=t.class_id";
    $result = mysqli_query($conn,$sql);

    $row=mysqli_fetch_array($result);
    
    $pending_count=$row['total']-1; ////////////////// Total number of quizzes pending
}
?>