<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 
$st_login="no";
$in_login="no";
if(isset($_SESSION['st-id'])){
    $st_id=base64_decode($_SESSION['st-id']);
    $st_login="yes";
}
else if(isset($_COOKIE['st-id'])){
    $st_id=base64_decode($_COOKIE['st-id']);
    $st_login="yes";
}

if(isset($_SESSION['in-id'])){
    $in_id=base64_decode($_SESSION['in-id']);
    $in_login="yes";
}
else if(isset($_COOKIE['in-id'])){
    $in_id=base64_decode($_COOKIE['in-id']);
    $in_login="yes";
}

if($in_login=="yes"){
    $result=mysqli_query($conn,"SELECT i_name FROM instructor WHERE i_id='$in_id'");
    $row=mysqli_fetch_array($result);
    $in_name=$row['i_name'];
}
?>


<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <title>Smart Quizzer</title>
        
        <script src="/script/jquery-1.11.2.min.js"></script>
        <script src="/script/moment-with-locales.js"></script>
        <script src="/script/bootstrap-datetimepicker.js"></script>
        <script src="/script/bootstrap.min.js"></script>
        <script src="/script/bootstrap-filestyle.min.js"></script>
        <script src="/script/bootstrap-select.js"></script>
        <script src="/script/script.js"></script>
        <script src="/script/responsive-calendar.min.js"></script>

        <link rel="stylesheet" href="/style/bootstrap.min.css">
        <link rel="stylesheet" href="/style/style.css">
        <link rel="stylesheet" href="/style/prettify-1.0.css">
        <link rel="stylesheet" href="/style/bootstrap-datetimepicker.css">
        <link rel="stylesheet" type="text/css" href="/style/bootstrap-select.min.css">
        <link rel="stylesheet" href="/style/responsive-calendar.css">
<?php
if ($st_login=="no" && $in_login=="no")
    echo <<<EOL
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
						<a class="navbar-brand" href="/"><span class="glyphicon glyphicon-log-in"></span> <b> Login</b></a>
				</div>
              </div>
           </nav>
EOL;

else if($st_login=="yes"){
echo <<<EOL
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
                        <div>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a class="navbar-brand" href="/"><b>Home</b></a></li>
                                <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <b>$st_name</b> <span class="caret"></span></a>
                                    <ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu">
                                        <li><a href="/settings/"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
                                          <li class="divider"></li>
                                        <li><a href="/api/logout/"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
EOL;
} 
else if($in_login=="yes"){
   echo <<<EOL
        <script src="/script/instructor_script.js"></script>
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
							<div>
								<ul class="nav navbar-nav navbar-right">
                                    <li><a class="navbar-brand" href="/"><b>Home</b></a></li>
									<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <b>$in_name</b> <span class="caret"></span></a>
										<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu">
											<li><a href="/settings/"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
											  <li class="divider"></li>
											<li><a href="/api/logout/"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
										</ul>
									</li>
								</ul>
							</div>
						</div>
					</nav>

EOL;
}
?>
                  <div class="panel panel-default">
            <div class="panel-body">
              <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                       <img id="group_pic" class="img-thumbnail" src="/images/group.jpg"/>

                        <p><h2 style="font-style:italic;">How did it all start?</h2><br>
                        Team Smart Quizzer,we are a team of 11 who aimed to build a software product from scratch as a part of Software Engineering Project. The idea was born after we analysed the
                        the different ways in which tests/quizzes are conducted in educational institutions. We needed to simplify the conventional pen and paper method of conducting chapter wise quizes.
                        An online product that intends to save the time and effort involved in generation and evaluation of quizzes was something that could solve this problem. The result of this has lead us to builing this product "SmartQuizzer".
                        <br></p>


                        <p>
                        <h2 style="font-style:italic;">Smart Quizzer now..</h2>
                        Online smart quizzer provides flexible learning process.
                        This is product mainly intended for teachers to upload chapter/unit wise test after a week/day of teaching, and for the students to take them and analyse their performance.
                        This is a framework designed to generate questions for simple quizzing sessions that would often be conducted at the end of lectures on a weekly or daily basis .
                        Students can benefit greatly by taking simple online practice quizzes. Teacher can upload the matter out of which questions have to generated. Concerned students who have registered for the subject get notified about the upcoming tests. Student has to login before the deadline and take the test and submit. The student can then also view his/her performance.That's pretty much about us. Hoping you all will enjoy using this!
                                          If you have any queries please do mail us at <b>smartquizzer@gmail.com</b>
                        </p>
                         <div class="top-buffer-sm">&nbsp</div>
                      </div>
                </div>
            </div>
            <div class="panel-footer">
              Copyright - Smart Quizzer<a href="/helpcenter/help/">Help</a><a href="/helpcenter/feedback/">Feedback</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>