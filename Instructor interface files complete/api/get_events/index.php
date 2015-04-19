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
else if(isset($_COOKIE['in-id'])){
    $in_id=base64_decode($_COOKIE['in-id']);
    $in_login="yes";
}


if($in_login=="yes"){
    $outstr="{";
    $first_time=0;
    
    $result = mysqli_query($conn,"SELECT date, count(*) as event_count FROM test WHERE i_id='$in_id' GROUP BY date");
    while($row = mysqli_fetch_array($result)){
        if($first_time!=0)
            $outstr.=',';
        
        $outstr.='"'.$row['date'].'":';
        $outstr.='{"number":'.$row['event_count'].'}';
        $first_time++;
    }
    $outstr.='}';
    echo $outstr;
}
else if($st_login=="yes"){

}

else
    header("location : /");
?>