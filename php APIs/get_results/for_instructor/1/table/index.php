<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql2.php"; 


//if(isset($_POST['course_id'])){
    //$course_id=$_POST['course_id'];
    if(isset($_SESSION['in-id'])){
        $in_id=base64_decode($_SESSION['in-id']);
    }
    else if(isset($_COOKIE['in-id'])){
        $in_id=base64_decode($_COOKIE['in-id']);
    }
    
    $course="12CS351";
    $class="12CSEB";
    
    $result = mysqli_query($conn,"select t.class_id,t.course_id, date, t.test_id as test_id,AVG(r.score) as score,i.i_id from result r,instructor i,test t where i.i_id='".$in_id."' and i.i_id=t.i_id and t.course_id='".$course."' and t.class_id='".$class."' and t.test_id=r.test_id  group by r.test_id");

    $json_testid= array();
    $json_avgscore=array();

    if($result === FALSE){
        echo 'failed';
    }

    while($row=mysqli_fetch_array($result)){
    $row_1['label']= $row['date'];
    $row_2['value']=$row['score'];

    array_push($json_testid,$row_1);
    array_push($json_avgscore,$row_2);
    }
    var_dump($json_testid);
    var_dump($json_avgscore);
   // echo $json_score;
//}
//else
  //  header("location : /");
?>