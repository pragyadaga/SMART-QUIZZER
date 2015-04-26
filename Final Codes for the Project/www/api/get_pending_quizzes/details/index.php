<link rel="stylesheet" href="/style/bootstrap.min.css">
<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php";
date_default_timezone_set('Asia/Kolkata');

$cur_date=date('Y-m-d');
$cur_time=date('H:i:s');

$sql="SELECT date, time, c.course_id, c.c_name, class_id FROM test t, course c WHERE TIMESTAMP(t.date, t.time)>TIMESTAMP('$cur_date', '$cur_time') and t.i_id='$in_id' and t.course_id=c.course_id ORDER BY date DESC, time ASC";

echo <<<EOL
        <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Course ID</th>
            <th>Course name</th>
            <th>Class</th>
          </tr>
        </thead>
        <tbody>
EOL;

$result = mysqli_query($conn,$sql);

while($row=mysqli_fetch_array($result)){
    $time_=date('h:i:s A', strtotime($row['time']));
    echo "<tr><td>".$row['date']."</td>";
    echo "<td>".$time_."</td>";
    echo "<td>".$row['course_id']."</td>";
    echo "<td>".$row['c_name']."</td>";
    echo "<td>".$row['class_id']."</td></tr>";
}
echo "</tbody></table>";
?>