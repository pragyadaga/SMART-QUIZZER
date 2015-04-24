<html ng-app="myapp">
<!-- Make query such as quizPage.php?testID=<some valid test id present in the database> -->
<head>
	<script src="script/angular/angular.js" type="text/javascript"></script>
	<title></title>
</head>
<body>

<div ng-controller="quizControl">
<quizquestion quest="quiz"></quizquestion>
<label>Time Left : {{seconds}} {{quiz.testID}} {{quiz.question}}</label>
</div>

<script>
var mainApp= angular.module('myapp',[]);
mainApp.directive('quizquestion',function(){
var directive = {};
// directive.transclude = true;
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
                           alert("Tab Changed"); 
                        };
        window.addEventListener("blur",$scope.tabChange,false);
	    $scope.seconds = 100;
        var timer = $interval(function(){
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
	// $scope.question = ["ANother question ____________ .","The creator of C++ is ______________ .","C++ supports ________________ .","OOP is a Part of C++. True/False ."];

$http({
    url: "http://localhost/getQuestions.php", 
    method: "GET",
    params: {"testID":$scope.quiz.testID}
 }).success(function(response)
    {
   $scope.quiz.question=response;
    }
  );

	});

</script>
</body>
</html>