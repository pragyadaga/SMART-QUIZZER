<link rel="stylesheet" href="/style/bootstrap.min.css">
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/consql3.php"; 

$course=$_GET['course'];
    
$result = mysqli_query($conn,"SELECT t.date, t.time, r.score FROM result r, test t WHERE r.USN='$st_id' and r.test_id=t.test_id and t.course_id='$course'");

echo <<<EOL
    Result for the course : $course
    <table class="table table-hover table-bordered">
    <thead>
      <tr>
        <th>Date</th>
        <th>Time</th>
        <th>Score</th>
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