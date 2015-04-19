<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 
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

$outstr='{"tests": [{';
$first_time=0;

if($in_login=="yes"){
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

else if($st_login=="yes"){

}

else
    header("location : /");
?>