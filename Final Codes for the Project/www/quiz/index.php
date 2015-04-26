<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; // Include the database connection file

if($st_login!="yes") /////////////// If the student is not logged in go to the login page
    header("location: /");

if(!isset($_GET['testID'])) /////////////// If the test Id is not set
    header('location: /');

$test_id=$_GET['testID'];

date_default_timezone_set('Asia/Kolkata');

$delay=5*60;  //////////////////// The maximum delay a student can make before taking the quiz

$now=date('Y-m-d H:i:s');
$cur_time_now=date('H:i:s');

$cur_time=date('H:i:s', strtotime($cur_time_now)-$delay);
$cur_date=date('Y-m-d', strtotime($cur_time_now)-$delay);

$end_time=date('H:i:s', strtotime($cur_time_now)+$delay);
$end_date=date('Y-m-d', strtotime($cur_time_now)+$delay);

/////////////////////// Check whether the quiz is being conducted

$sql = "SELECT date, time FROM test t where test_id='$test_id' and TIMESTAMP(t.date,t.time)>=TIMESTAMP('$cur_date','$cur_time')";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)){
    $row=mysqli_fetch_array($result);
    $quiz_time=date('h:i:s A', strtotime($row['time']));

    $test_time_now=$row['date']." ".$row['time'];
    $time_left= strtotime($test_time_now)-strtotime($now);

    if($now < $test_time_now){
        header("location: /");
    }
}
else{
    header("location: /");
}

//////////////////// Check if the answers are already submitted
$sql = "SELECT * FROM result WHERE test_id='$test_id' and USN='$st_id'";
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)){
    header("location:/");
}

//////////////////// Check if the student is eligible to take the quiz
$sql="SELECT * FROM test t, student s, list_of_students l, takes tk WHERE t.class_id=l.class_id and t.course_id=tk.course_id and s.USN=tk.USN and s.USN=l.USN and t.test_id='$test_id' and s.USN='$st_id'";
$result = mysqli_query($conn,$sql);
if(!mysqli_num_rows($result)){
    header("location:/");
}

?>
<!DOCTYPE html>
<html ng-app="myapp">
<!-- Make query such as quizPage.php?testID=<some valid test id present in the database> -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
    <title>Smart Quizzer - Test conduction</title>
    
    <link rel="stylesheet" href="/style/bootstrap.min.css">
    <link rel="stylesheet" href="/style/style.css">
    <link rel="stylesheet" href="/style/bootstrap.min.css">

	<script src="/script/angular.js" type="text/javascript"></script>
	<title></title>
</head>
<body>
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
						<a class="navbar-brand"><span ng-controller="quizControl">
                            <label>Time Left : {{min}} minute {{sec}} seconds</label>
                    </span></a>
				</div>
                </div>
           </nav>

            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="quiz-conduction">
                        <div ng-controller="quizControl">
                            <form method="POST" action="eval.php">
                            <quizquestion quest="quiz"></quizquestion>

                        </div>
                    </div>
                </div>
                </div>
                    <input id="submitbutton" type="submit" class="btn btn-primary pull-right" value="Submit my Answers" onclick="return confirm('Do you really want to submit the answers?')"></input>
                </form>
          </div>
        </div>
    </div>
<script>
var mainApp= angular.module('myapp',[]);

    mainApp.directive('quizquestion',function(){
    var directive = {};
    directive.restrict = 'E';
    directive.scope = {
        quiz : "=quest"
    }
    directive.templateUrl = 'question.html';
    return directive;
});

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
    
mainApp.controller("quizControl",function ($interval,$scope,$http) {
        $scope.count=0;
       $scope.tabChange = function(){
                           alert("You can't change the tab"); 
                        };
        window.addEventListener("blur",$scope.tabChange,false);
	    $scope.seconds = 500;  //////////////// Duration of the quiz
	    
        var timer = $interval(function(){
        $scope.sec = $scope.seconds % 60;
        $scope.min = parseInt($scope.seconds / 60, 10);
        $scope.seconds--;
        if($scope.seconds == 0){
            // alert($scope.count);
            $scope.sub = document.getElementById("submitbutton");
            $interval.cancel(timer);
        	alert("Time has ended. Auto Submitting your answers");
            $scope.sub.click();
        }
    }, 1000);
    $scope.quiz = [];
    $scope.quiz.testID = getParameterByName('testID');

    $http({
        url: "http://localhost/api/get_questions/index.php", 
        method: "GET",
        params: {"testID":$scope.quiz.testID}
        }).success(function(response){
        $scope.quiz.question=response;
    });
});
</script>
</body>
</html>