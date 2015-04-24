<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 
// $result=mysqli_query($conn,"SELECT i_name FROM instructor WHERE i_id='$in_id'");
// $row=mysqli_fetch_array($result);
// $in_name=$row['i_name'];
$tid = $_GET["testID"];
$score=0;
$questionCount = count($_SESSION['questionIDs']);
for($x = 0; $x < $questionCount; $x++) {
    $curQId =  $_SESSION['questionIDs'][$x];
    $result=mysqli_query($conn,"SELECT answer FROM question WHERE test_id='$tid' AND q_id='$curQId'");
    $row = mysqli_fetch_array($result);
    if($row['answer'] == null)
    {
    	echo "Your failed to answer this question. Correct answer is ".$row['answer'];
    }
    else
    {
	    echo "Your Answer ".$_GET["answer".$x];

	    if($row['answer']==$_GET["answer".$x])
	    {
	    	echo " is Correct";
	    	$score++;
	    }
	    else
	    {
	    	echo " is False. Correct answer is ".$row['answer'];
	    }
	}
    echo "<br>";
}
echo "Final Score : ".$score."/$questionCount";
// for ($x = 0; $x <= 2; $x++) {
//     echo $_GET["answer".$x];
// }
?>