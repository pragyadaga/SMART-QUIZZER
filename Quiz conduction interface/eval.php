<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 

$tid = $_POST["testID"];
$score=0;
$questionCount = count($_SESSION['questionIDs']);
for($x = 0; $x < $questionCount; $x++) {
    $curQId =  $_SESSION['questionIDs'][$x];
    $result=mysqli_query($conn,"SELECT question,answer FROM question WHERE test_id='$tid' AND q_id='$curQId'");
    $row = mysqli_fetch_array($result);
    echo "Question :".$row['question'];
    echo "<br>";
    if($row['answer'] == null)
    {
    	echo "Your failed to answer this question. Correct answer is ".$row['answer'];
    }
    else
    {
	    echo "Your Answer ".$_POST["answer".$x];

	    if($row['answer']==$_POST["answer".$x])
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

/////////// Update the result table

?>
