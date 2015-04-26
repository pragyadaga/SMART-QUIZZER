<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; // Include the database connection file

if($st_login!="yes")
    header("location: /");
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
	<script type="text/javascript">
        	window.onbeforeunload = function(){
                	return 'You are about to leave this Page. If you are submitting your answers Please Verify before leaving this page. Do not leave this page without submitting your answers.';
        	};
    	</script>
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
                    <input id="submitbutton" type="submit" class="btn btn-primary pull-right" value="Submit my Answers"></input>
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
                          // alert("Tab Changed"); 
                        };
        window.addEventListener("blur",$scope.tabChange,false);
	    $scope.seconds = 1800;  //////////////// Duration of the quiz
	    
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
