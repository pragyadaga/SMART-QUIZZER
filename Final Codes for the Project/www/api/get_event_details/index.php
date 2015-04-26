<?php
////////////////// API to get the list of quizzes for a selected dates in the calendar
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 

$outstr='{"tests": [{';
$first_time=0;

if($in_login=="yes"){ ////////////////// For instructor
    $event_date=$_POST['year']."-".$_POST['month']."-".$_POST['day'];
    
    $result = mysqli_query($conn,"SELECT date, time, c_name,  class_id FROM course c, test t WHERE i_id='$in_id' and c.course_id=t.course_id and date='$event_date'");
    while($row = mysqli_fetch_array($result)){
        if($first_time!=0)
            $outstr.=',{';
        $outstr.='"date":"'.$row['date'].'"';
        $outstr.=',"time":"'.$row['time'].'"';
        $outstr.=',"c_name":"'.$row['c_name'].'"';
        $outstr.=',"class_id":"'.$row['class_id'].'"';
        $outstr.='}';
        $first_time++;
    }
    if($first_time==0)
        $outstr='';
    else
        $outstr.=']}';
    echo $outstr;
}

else if($st_login=="yes"){ ////////////////// For student
    $event_date=$_POST['year']."-".$_POST['month']."-".$_POST['day'];
    
    $result = mysqli_query($conn,"SELECT t.date, t.time, c.c_name FROM list_of_students l, test t, course c WHERE l.USN='$st_id' and c.course_id=t.course_id and date='$event_date' and t.class_id=l.class_id");
    while($row = mysqli_fetch_array($result)){
        if($first_time!=0)
            $outstr.=',{';
        $outstr.='"date":"'.$row['date'].'"';
        $outstr.=',"time":"'.$row['time'].'"';
        $outstr.=',"c_name":"'.$row['c_name'].'"';
        $outstr.='}';
        $first_time++;
    }
    if($first_time==0)
        $outstr='';
    else
        $outstr.=']}';
    echo $outstr;
}

else
    header("location : /");
?>