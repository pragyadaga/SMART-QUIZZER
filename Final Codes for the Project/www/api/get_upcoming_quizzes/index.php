<link rel="stylesheet" href="/style/bootstrap.min.css">
<link rel="stylesheet" href="/style/flipclock.css">
<link rel="stylesheet" href="/style/style.css">

<script src="/script/jquery-1.11.2.min.js"></script>
<script src="/script/flipclock.min.js"></script>
<div style="overflow-x: hidden">

<?php
////////////////// API to display the list of upcoming quizzes
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; // Include the database connection file

date_default_timezone_set('Asia/Kolkata');

$duration=5*60;  //////////////////// The maximum delay a student can make before taking the quiz

$now=date('Y-m-d H:i:s');

$cur_time_now=date('H:i:s');

$cur_time=date('H:i:s', strtotime($cur_time_now)-$duration);
$cur_date=date('Y-m-d', strtotime($cur_time_now)-$duration);

if($in_login=="yes"){
    header("location:/");
}
else if($st_login=="yes"){
    $i=1;
    $sql = "SELECT t.test_id, t.date, t.time, t.course_id, c.c_name FROM test t, list_of_students l, course c WHERE TIMESTAMP(t.date,t.time)>=TIMESTAMP('$cur_date','$cur_time') and l.USN='$st_id' and l.class_id=t.class_id and c.course_id=t.course_id order by t.date ASC, t.time ASC";
    $result = mysqli_query($conn,$sql);
    while($row=mysqli_fetch_array($result)){     
        $c_name=$row['c_name'];
        $course_id=$row['course_id'];
        $quiz_date=$row['date'];
        $quiz_time=date('h:i:s A', strtotime($row['time']));
        $test_id=$row['test_id'];
        
        $test_time_now=$row['date']." ".$row['time'];
        $time_left= strtotime($test_time_now)-strtotime($now);
        
        $sql1 = "SELECT * FROM result WHERE test_id='$test_id' and USN='$st_id'"; ///////////////// Check whether the test is already conducted
        $result1 = mysqli_query($conn,$sql1);
        if(mysqli_num_rows($result1)){
           continue;
        }
        
        if($now < $test_time_now){ ////////////////// Display the countdown timer
            echo <<<EOL
                <b>$c_name </b> quiz on <b> $quiz_date </b> at <b> $quiz_time </b><br><br>
                <div class="clock$i"></div>
                <hr>
                <script>
                    var clock$i = $('.clock$i').FlipClock($time_left, {
                    clockFace: 'DailyCounter',
                    countdown: true
                    });
                </script>
EOL;
        }
        else{ ////////////////// Display the countdown timer
            echo <<<EOL
                <b>$c_name </b> quiz on <b> $quiz_date </b> at <b> $quiz_time </b><br><br>
                <div class="clock$i"></div>
                <a href="/quiz/?testID=$test_id" class="btn-quiz" target="_blank">Write this Quiz</a>
                <hr>
                <script>
                    var clock$i = $('.clock$i').FlipClock(1, {
                    clockFace: 'DailyCounter',
                    countdown: true
                    });
                </script>
EOL;
        }
         $i++;   
    }
}
?>
</div>