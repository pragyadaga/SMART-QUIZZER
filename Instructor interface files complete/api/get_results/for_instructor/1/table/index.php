<link rel="stylesheet" href="/style/bootstrap.min.css">
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/consql3.php"; 

$course=$_GET['course'];
$class=$_GET['class'];
    
$result = mysqli_query($conn,"select t.class_id,t.course_id, date, time, t.test_id as test_id,AVG(r.score) as score,i.i_id from result r,instructor i,test t where i.i_id='".$in_id."' and i.i_id=t.i_id and t.course_id='".$course."' and t.class_id='".$class."' and t.test_id=r.test_id  group by r.test_id");

echo <<<EOL
    <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Average Score</th>
      </tr>
    </thead>
    <tbody>
EOL;
    while($row=mysqli_fetch_array($result)){
       echo "<tr><td>".$row['date']."</td>";
       echo "<td>".date('h:i:s A', strtotime($row['time']))."</td>";
       echo "<td>".$row['score']."</td></tr>";
    }
echo "</tbody></table>";
?>