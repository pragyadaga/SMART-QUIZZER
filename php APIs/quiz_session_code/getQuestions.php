<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 
// $result=mysqli_query($conn,"SELECT i_name FROM instructor WHERE i_id='$in_id'");
// $row=mysqli_fetch_array($result);
// $in_name=$row['i_name'];
$questions = array();
$questionID = array();
$tid = $_GET["testID"];
	$result=mysqli_query($conn,"SELECT q_id,question FROM question WHERE test_id='$tid' ORDER BY RAND() LIMIT 30");
	if (!$result) { // add this check.
    die('Invalid query: ' . mysql_error());
	}
	while($row = mysqli_fetch_array($result)){
        array_push($questions, $row['question']);
        array_push($questionID, $row['q_id']);
    };
    $c = count($questions);
$tmp = array();
for ($i=0; $i<$c; $i++) {
  $tmp[$i] = array($questionID[$i], $questions[$i]);
}
shuffle($tmp);
$_SESSION['questionIDs'] = array();
for ($i=0; $i<$c; $i++) {
  array_push($_SESSION['questionIDs'],$tmp[$i][0]);
  $questions[$i] = $tmp[$i][1];
}
	echo json_encode($questions);
	// echo json_encode($questionID);
	// print_r($_SESSION['questionIDs']);
?>
