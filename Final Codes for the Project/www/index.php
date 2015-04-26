<?php
//////////// Home page
session_start();
$in_id="";

include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; //////////////// Incude the database connection files
include_once $_SERVER['DOCUMENT_ROOT']."/api/get_pending_quizzes/index.php";
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
if ($st_login=="no" && $in_login=="no") //////////////// Show the login page
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
              </div>   
           </nav>
          <div class="panel panel-default">
            <div class="top-buffer-sm"></div>
            <div class="panel-body" style="height: 450px;">
              <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                  <div class="panel panel-default text-center">
                    <div class="panel-heading">Welcome, please login</div>
                    <div class="top-buffer-sm"></div>
                    <div class="panel-body">
                      <div>
                        <button type="button" class="btn btn-lg btn-primary btn-margin" id="st-btn">Student</button>
                        <button type="button" class="btn btn-lg btn-warning" id="in-btn">Instructor</button>
                      </div>

                      <div class="top-buffer-sm"></div>

                      <div class="panel panel-default" style="display:none;" id="st-lgn">
                        <div class="panel-body">
                          <form class="form-horizontal" action="/" role="form" onsubmit="return stLogin()" id="st-lgn-form">
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="text">USN:</label>
                              <div class="col-sm-5">
                                <input type="text" class="form-control" id="st-id" name="st-id" placeholder="Enter your USN" data-toggle="popover" data-content="Invalid Username/Password combination">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">Password:</label>
                              <div class="col-sm-5">      
                                <input type="password" class="form-control" id="st-pwd" name="st-pwd" placeholder="Enter your password" data-toggle="popover" data-content="Invalid Username/Password combination">
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                <div class="checkbox">
                                  <label><input type="checkbox" id="st-rem"> Remember me</label>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">        
                              <div class="col-sm-offset-3 col-sm-8">
                                <button type="submit" class="btn btn-info">Login as a Student</button><div class="pull-right"><a href="/helpcenter/help/forgot_password/">Forgot password ?</a></div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>

                      <div class="panel panel-default" style="display:none;" id="in-lgn">
                        <div class="panel-body">
                          <form class="form-horizontal" role="form" onsubmit="return inLogin()" id="in-lgn-form">
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="text">Instructor ID:</label>
                              <div class="col-sm-5">
                                <input type="text" class="form-control" id="in-id" name="in-id" placeholder="Enter your Instructor ID" data-toggle="popover" data-content="Invalid Username/Password Combination">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">Password:</label>
                              <div class="col-sm-5">      
                                <input type="password" id="in-pwd" class="form-control" name="in-pwd" placeholder="Enter your password">
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                <div class="checkbox">
                                  <label><input type="checkbox" id="in-rem"> Remember me</label>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">        
                              <div class="col-sm-offset-3 col-sm-8">
                                <button type="submit"class="btn btn-info">Login as an Instructor</button><div class="pull-right"><a href="/helpcenter/help/forgot_password/">Forgot password ?</a></div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel-footer">
              Copyright - Smart Quizzer<a href="/helpcenter/feedback/">Feedback</a><a href="/helpcenter/aboutus/">About us</a>
            </div>
          </div>
        </div>
      </div>
    </div>
EOL;

else if($st_login=="yes"){ //////////////// Show the student interface
    echo <<<EOL
    <link rel="stylesheet" href="/script/flipclock.css">
    <script src="/script/flipclock.min.js"></script>
    <script src="/script/student_script.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <nav class="navbar navbar-default"> <!-- Navigation menu --> 
                        <div class="container-fluid">
                            <div class="navbar-header">
                                <a class="navbar-brand" href="/">
                                    <img src="/images/logo.png">
                                </a>
                                <a class="navbar-brand" href="/"><b>Smart Quizzer</b></a>
                            </div>
                            <div>
                                <ul class="nav navbar-nav navbar-right">
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
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row wrapper">
                                <div class="col-sm-3"> <!-- Tab navigation--> 
                                    <ul id="tabnav" class="nav nav-tabs nav-pills nav-stacked sideborder">
                                        <li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-home"></span> <b>Home</b></a></li>
                                        <li><a href="#viewresults" data-toggle="tab"><span class="glyphicon glyphicon-signal"></span> <b>View Results</b></a></li>
                                        <li><a href="#upcoming" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span> <b>Upcoming Quizzes </b></a></li>

                                    </ul>
                                </div>
                            <div class="col-sm-9 tabwrapper">
                                <div id="tabwrapper" class="tab-content ">
                                    <div class="tab-pane fade in active" id="home">

                                        <!-- Responsive calendar - START -->
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <div class="responsive-calendar" >
                                                            <div class="controls">
                                                                <a class="pull-left" data-go="prev"><div class="btn btn-primary">Prev</div></a>
                                                                <h4><span data-head-year></span> <span data-head-month></span></h4>
                                                                <a class="pull-right" data-go="next"><div class="btn btn-primary">Next</div></a>
                                                            </div><hr/>
                                                            <div class="day-headers">
                                                              <div class="day header">Mon</div>
                                                              <div class="day header">Tue</div>
                                                              <div class="day header">Wed</div>
                                                              <div class="day header">Thu</div>
                                                              <div class="day header">Fri</div>
                                                              <div class="day header">Sat</div>
                                                              <div class="day header">Sun</div>
                                                            </div>
                                                            <div class="days" data-group="days">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <div class="panel panel-success">
                                                            <div class="panel-heading text-center">Calendar of events</div>
                                                            <div class="panel-body" id="event-details">
                                                                   <div class="text-center text-danger">( Please select a date )</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        <!-- Responsive calendar - END -->
                                   </div>
                                   <div class="tab-pane fade" id="viewresults">
                                       <div class="input-align-for">
                                          <select class="selectpicker" data-width="140px" id="view-result-for">
                                                <option value="subject"> Subject results </option>
                                                <option value="all"> All results </option>
                                            </select>
                                            </div>
                                            <div class="input-align-course" id="select-course-div">
                                            Course : <select class="selectpicker" data-width="140px" title="Select course" id="select-course"></select>
                                        </div>
                                        <div class="input-align-class" id="select-course-div">
                                           View as : <select class="selectpicker" data-width="140px" id="view-as">
                                                <option value="graph"> Graph </option>
                                                <option value="table"> Table </option>
                                            </select>
                                       </div>
                                       <button type="button" class="btn btn-md btn-success" id="result-btn" onclick="showResults()">View</button>
                                       <div id="result-div"></div>
                                       
                                   </div>
                                    <div class="tab-pane fade" id="upcoming">
                                     
                                     <!-- Show the list of upcoming quizzes --> 
                                      
                                       <div id="upcoming-quiz-details"><p><b></b></p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="panel-footer">
                            Copyright - Smart Quizzer<a href="/helpcenter/feedback/">Feedback</a><a href="/helpcenter/aboutus/">About us</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
EOL;
}
else if($in_login=="yes"){ //////////////// Show the instructor interface
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
					<div class="panel panel-default">
						<div class="panel-body">
							<div class="row wrapper">
								<div class="col-sm-3">
									<ul id="tabnav" class="nav nav-tabs nav-pills nav-stacked sideborder">
										<li class="active"><a href="#home" data-toggle="tab" onclick="clearEventList()"><span class="glyphicon glyphicon-home"></span> <b>Home</b></a></li>
										<li><a href="#viewresults" data-toggle="tab"><span class="glyphicon glyphicon-signal"></span> <b>View Results</b></a></li>
										<li><a href="#postquiz" data-toggle="tab"><span class="glyphicon glyphicon-pencil"></span> <b>Post a Quiz</b></a></li>
										<li><a href="#pending" data-toggle="tab"><span class="glyphicon glyphicon-time"></span> <b>Pending Quizzes <kbd> $pending_count</kbd></b></a></li>
									</ul>
								</div>
							<div class="col-sm-9 tabwrapper">
								<div id="tabwrapper" class="tab-content">
								   	<div class="tab-pane fade in active wrapper" id="home">
                                    <!-- Responsive calendar - START -->
                                            <div class="row">
                                                <div class="col-sm-7">
                                                    <div class="responsive-calendar" >
                                                        <div class="controls">
                                                            <a class="pull-left" data-go="prev"><div class="btn btn-primary">Prev</div></a>
                                                            <h4><span data-head-year></span> <span data-head-month></span></h4>
                                                            <a class="pull-right" data-go="next"><div class="btn btn-primary">Next</div></a>
                                                        </div><hr/>
                                                        <div class="day-headers">
                                                          <div class="day header">Mon</div>
                                                          <div class="day header">Tue</div>
                                                          <div class="day header">Wed</div>
                                                          <div class="day header">Thu</div>
                                                          <div class="day header">Fri</div>
                                                          <div class="day header">Sat</div>
                                                          <div class="day header">Sun</div>
                                                        </div>
                                                        <div class="days" data-group="days">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-5">
                                                    <div class="panel panel-success">
                                                        <div class="panel-heading text-center">Calendar of events</div>
                                                        <div class="panel-body" id="event-details">
                                                               <div class="text-center text-danger">( Please select a date )</div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    <!-- Responsive calendar - END --></div>
								   <div class="tab-pane fade" id="viewresults">
                                <div class="row wrapper">
                                <div class="col-sm-12">
									<ul class="nav nav-tabs nav-justified">
										<li class="active"><a href="#class-result" data-toggle="tab"><span class="glyphicon glyphicon-th"></span> <b>Class results</b></a></li>
										<li><a href="#individual-result" data-toggle="tab"><span class="glyphicon glyphicon-zoom-in"></span> <b>Individual results</b></a></li>
									</ul>
                                    </div>
							<div class="col-sm-12" >
								<div class="tab-content" style="border:0;">
								   	<div class="tab-pane fade in active" id="class-result">
                                    <p>
                                   Course : <select class="selectpicker" data-width="140px" title="Select course" multiple data-max-options="1" id="select-course-result"></select>
                                   &nbsp Class : <select class="selectpicker" data-width="140px" title="Select class" disabled id="select-class-result"></select>
                                   &nbsp View as : <select class="selectpicker" data-width="140px" id="view-result-type">
                                    <option value="graph"> Graph </option>
                                    <option value="table"> Table </option>
                                    </select>
                                    
                                    <button type="button" class="btn btn-md btn-success go-btn" id="result-btn">View</button>
                                    <div id="class-result-graph"></div></div>
                                    
                                    <div class="tab-pane fade" id="individual-result">
								      <!-- View individual result -->
                                    
                                    <div class="input-align-for">
                                        For: <select class="selectpicker" data-width="140px" id="view-result-for">
                                            <option value="individual"> Individual </option>
                                            <option value="all"> All students </option>
                                        </select>
                                    </div>
                                    <div class="input-align-course">
                                        Course : <select class="selectpicker" data-width="140px" title="Select course" multiple data-max-options="1" id="select-course-result-1">
                                        </select><span class="error-select" id="course-error"></span>
                                    </div>
                                    
                                    <div class="input-align-class" style="display:none;" id="select-class-div">
                                        Class : <select class="selectpicker" data-width="140px" title="Select class" disabled id="select-class-result-1"></select>
                                    </div>
                                    <div class="input-align-usn" id="usn-div">
                                          <input class="form-control" type="text" placeholder="Enter USN" name="usn" id="usn">
                                          <span class="error-select" id="usn-error"></span>
                                    </div>
                                    
                                    <button type="button" class="btn btn-md btn-success" id="individual-result-btn">View</button>
                                     <div id="individual-result-graph"></div>
                                     
                                     <!-- -------------------- -->
                                      
                                      </div>
                                    </div>
                                   </div>
                                 </div>
                                </div>
								<div class="tab-pane fade wrapper" id="postquiz">
                                   <p>
                                   Course : <select class="selectpicker" title="Select course" multiple data-max-options="1" id="select-course">
                                   </select>
                                   &nbsp &nbsp  Classes : <select class="selectpicker" title="Select classes" multiple disabled id="select-class">
                                   </select>
                                   <p class="error-select" id="error-select-text"></p>
                                   <div class="row page-input"><span class="page-number-label">Enter starting page number : </span>
                                    <div class="input-align-page">
                                          <input class="form-control" type="number" placeholder="Page no." name="start-page" id="start-page">
                                    </div><span class="page-number-label">Enter last page number : </span>
                                    <div class="input-align-page">
                                          <input class="form-control" type="number" placeholder="Page no." name="end-page" id="end-page">
                                    </div>
                                   
                                   </div>
                                   <p class="error-page" id="error-page-number"></p>
                                   <p>Select a file to generate questions.</p>
                                   <form>
                                    <input type="file" class="filestyle" data-buttonName="btn-primary" id="upload-form">
                                   </form>
                                   <p class="error-file" id="error-file-text"></p>
                                   <p>Select a glossary file containing important keywords. (Optional)</p>
                                   <span class="glyphicon glyphicon-remove remove-file" style="float:right;"></span>
                                        <form style="width: 750px;" >
                                            <input type="file" class="filestyle" data-buttonName="btn-primary" id="upload-form2">
                                        </form>
                                    
                                   <p class="error-file" id="error-file-text2"></p>
										<a class="btn btn-success" onclick="uploadQuestions()" id="upload-btn" style="width:200px;">Generate Questions</a>
											<div class="modal bs-example-modal-lg fade" id="ques-modal" tabindex="-1" role="dialog" aria-labelledby="ques-modal" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content" id="modalContent">
														<div class="modal-header"><b><span id="questions-header"></span></b>
                                                        <span id="ques-error"></span>
                                                        <button class="btn btn-success add-more">Add more</button>
                                                        <button type="button" class="close close-modal" data-dismiss="modal" aria-hidden="true">Close</button>

                                                        
														</div>
														<div class="modal-body">
                                                            <div id="ques-edit">
                                                            </div>
                                                        </div>
														<div class="modal-footer">
                                                           <div class="row">
                                                                    <div class='col-sm-5'>
                                                                        <div class="form-group" >
                                                                            <div class='input-group date' id='datetimepicker1'>
                                                                                <input type='text'  placeholder="Select date and time for the quiz" class="form-control" id="date-time"/>
                                                                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <span id="date-error"></span>
                                                                    <button type="button" style="margin-right: 10px;"class="btn btn-primary" id="post-quiz-btn" onclick="validateQuestions()">Post quiz</button>
                                                            </div>
														</div>
													</div>
												</div>
											</div>
                                            
										</div>
									<div class="tab-pane fade" id="pending">
                                    
										<div id="pending-quiz-details"><p><b>List of quizzes to be conducted</b></p>
                                            <iframe src="/api/get_pending_quizzes/details/index.php" id="pending-quiz-frame"></iframe>
                                        </div>
									</div>
								</div>
							</div>
						</div>
					</div>
						<div class="panel-footer">
							Copyright - Smart Quizzer<a href="/helpcenter/feedback/">Feedback</a><a href="/helpcenter/aboutus/">About us</a>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<!-- Modal for showing the success message -->
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true" id="post-success">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            Quiz posted successfully on <b><span id="quiz-date"></span></b>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="post-success" onclick="location.reload()">Ok</button>
        </div>
      </div>
    </div>
  </div>
EOL;
}
?>
  </body>
</html>