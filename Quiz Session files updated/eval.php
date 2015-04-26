<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <title>Smart Quizzer - Test conduction</title>

    <link rel="stylesheet" href="/style/bootstrap.min.css">
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/style/bootstrap.min.css">
    
    <script src="/script/jquery-1.11.2.min.js"></script>
<script>
window.history.forward();
             function noBack() { 
                  window.history.forward(); 
             }
    
$(document).on("keydown", function (e) {
    if (e.which === 8 && !$(e.target).is("input, textarea")) {
        e.preventDefault();
    }
});
</script>
</head>
<body onload="noBack();" onpageshow="if (event.persisted) noBack();" onunload="">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-10">
            <nav class="navbar navbar-default">
            <div class="container-fluid">
              <div class="navbar-header">
                <a class="navbar-brand" href="/">
                  <img src="/images/logo.png">
                </a>
                <a class="navbar-brand" href="/"><b>Smart Quizzer</b></a>
                </div>
               
                <div class="nav navbar-nav navbar-right">
						<a class="navbar-brand">Quiz Result Analysis</a>
				</div>
                </div>
           </nav>

            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="quiz-conduction">
                            

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
    echo "<div class='row my-row'>";
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
	    	echo " is <b>Correct</b>";
	    	$score++;
	    }
	    else
	    {
	    	echo " is <b>wrong</b>. Correct answer is <b>".$row['answer']."</b>";
	    }
	}
    echo "<br></div>";
}

/////////// Update the result table
mysqli_query($conn, "INSERT INTO result values ('$tid','$st_id','$score')");
?>
                    </div>
                </div>
                <div class="panel-footer">
                <?php echo "<b>Final Score : $score/$questionCount </b>"; ?>
                </div>
            </div>
          </div>
        </div>
    </div>
</body>
</html>