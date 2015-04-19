<link rel="stylesheet" href="/style/bootstrap.min.css">
<?php

include_once $_SERVER['DOCUMENT_ROOT']."/consql3.php"; 

$course=$_GET['course'];
$class=$_GET['class'];

$sql="SELECT t.date, t.test_id, t.time, r.USN, r.score FROM result r, test t WHERE t.test_id=r.test_id and t.course_id='$course' and t.i_id='$in_id' and class_id='$class' ORDER BY t.date DESC, t.time ASC";

$result = mysqli_query($conn,$sql);


$test_id="";
$table_count=0;

while($row=mysqli_fetch_array($result)){
    if($row['test_id']!=$test_id){
        $test_id=$row['test_id'];
        if($table_count!=0){
            echo "</tbody></table>";
        }
        $date_=$row['date'];
        $time_=date('h:i:s A', strtotime($row['time']));
        echo <<<EOL
            <br>
            Quiz conducted on <b> $date_ </b> at <b> $time_ </b>
            <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th>USN</th>
                <th>Marks</th>
              </tr>
            </thead>
            <tbody>
EOL;
    }
    echo "<tr><td>".$row['USN']."</td>";
    echo "<td>".$row['score']."</td></tr>";
    $table_count++;
}
echo "</tbody></table>";
?>