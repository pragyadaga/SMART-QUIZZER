<?php
///////////////////////// APPI to post the quiz
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 

if(isset($_SESSION['in-id'])){
    $in_id=base64_decode($_SESSION['in-id']);
}
else if(isset($_COOKIE['in-id'])){
    $in_id=base64_decode($_COOKIE['in-id']);
}
else
    header("location:/");

$pyscript = 'C:\\wamp\\www\\api\\send_notifications\\mailer.py'; ///////////////////////// Python script to send email notification
$python = 'C:\\Python34\\python.exe';

if(isset($_POST['course_id'])){
    $course_id=$_POST['course_id'];
    $class_id=$_POST['class_id'];
    $questions=$_POST['questions'];
    $date_time=$_POST['date'];
    

    $date_split=explode(' ',$date_time);
    
    $test_date=$date_split[0];
    $test_date=date("Y-m-d", strtotime($test_date));
    
    $test_time=$date_split[1];
    
    if($date_split[2]=='PM'){
        $hrs=explode(':', $test_time);
        $hr=$hrs[0];
        $hr+=12;
        $test_time=$hr.':'.$hrs[1].':'.'00';
    }
    
    for($i=0; $i<sizeof($class_id); $i++){ ///////////////////////// For each class
        mysqli_query($conn, "INSERT INTO test values ('$class_id[$i]','','$course_id','$in_id','$test_date','$test_time')");
        
        $result= mysqli_query($conn, "SELECT MAX(test_id) FROM test WHERE i_id='$in_id'"); ///////////////////////// Get the test ID
        $row = mysqli_fetch_array($result);
        
        $test_id=$row[0];
        
        $mail="";
        $content="";
        $t_time=date('h:i:s A', strtotime($test_time));
        
        $mail_result=mysqli_query($conn, "SELECT c.c_name, s.email FROM student s, list_of_students l, takes tk, test t, course c WHERE t.test_id='390' and t.course_id=tk.course_id and t.class_id=l.class_id and c.course_id=t.course_id and s.USN=tk.USN and s.USN=l.USN");


        while($row = mysqli_fetch_array($mail_result)){  ///////////////////////// Get the list of emails of the concerned students
            $mail.=$row['email'].":";
            $content="\"A new quiz has been scheduled on $test_date at $t_time for ".$row['c_name']."\"";
        }
        
        $cmd = "$python $pyscript $mail $content";
        //exec("$cmd", $output); ///////////////////////// Send the mail
        

    
        
        //////////////////// Insert into questions table
        
        for($j=0; $j<sizeof($questions); $j++){ ///////////////////////// Enter questions one by one
            $que_=mysqli_real_escape_string($conn, $questions[$j]['ques']);
            $ans_=mysqli_real_escape_string($conn, $questions[$j]['ans']);
            mysqli_query($conn, "INSERT INTO question values ('','$test_id','$que_','$ans_')");
        }
    }
}

?>