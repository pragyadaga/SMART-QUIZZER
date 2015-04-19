<?php
date_default_timezone_set('Asia/Kolkata');

$cur_date=date('Y-m-d');
$cur_time=date('h:i:s');

$sql="SELECT count(*) as total FROM test t WHERE TIMESTAMP(t.date, t.time)>=TIMESTAMP('$cur_date', '$cur_time') and t.i_id='$in_id'";
$result = mysqli_query($conn,$sql);

$row=mysqli_fetch_array($result);
$pending_count=$row['total'];
?>