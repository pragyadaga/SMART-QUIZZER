<?php
//////////////// Admin interface
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql_admin.php";

if($admin_login=="yes"){
    $result=mysqli_query($conn,"SELECT admin_id,admin_name,admin_email FROM admin  WHERE admin_id='$admin_id'");
    $row=mysqli_fetch_array($result);
    $admin_name=$row['admin_name'];
    $admin_email=$row['admin_email'];
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
        <script src="/script/bootstrap.min.js"></script>
        <script src="/script/admin_script.js"></script>

        <link rel="stylesheet" href="/style/bootstrap.min.css">
        <link rel="stylesheet" href="/style/style.css">

        <script type="text/javascript">

        </script>

        <style type="text/css">
            
		#pb{
                height: 500px;
        
        }

        </style></head>

	<body>
	<?php
	if ($admin_login=="no")
    echo <<<EOL
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
            <div class="panel-body" id="pb" >
              <div class="row">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                  <div class="panel panel-default text-center">
                    <div class="panel-heading">Welcome, Admin Page</div>
                    <div class="top-buffer-sm"></div>
                    <div class="panel-body">

                      <div class="top-buffer-sm"></div>

                      <div class="panel panel-default"  id="admin-lgn">
                        <div class="panel-body">
                          <form class="form-horizontal" method="POST" role="form" onsubmit="return adminLogin()" id="admin-lgn-form">
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="text">Admin ID:</label>
                              <div class="col-sm-5">
                                <input type="text" class="form-control" id="admin-id" name="admin-id" placeholder="Enter your ID" data-toggle="popover" data-content="Invalid ID/Password combination">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">Password:</label>
                              <div class="col-sm-5">      
                                <input type="password" class="form-control" id="admin-pwd" name="admin-pwd" placeholder="Enter your password" data-toggle="popover" data-content="Invalid Username/Password combination">
                              </div>
                            </div>

                            <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                <div class="checkbox">
                                  <label><input type="checkbox" id="admin-rem"> Remember me</label>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">        
                              <div class="col-sm-offset-2 col-sm-6">
                                <button type="submit" class="btn btn-info">Login</button>
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
              Copyright - Smart Quizzer<a href="/helpcenter/help/">Help</a><a href="/helpcenter/feedback/">Feedback</a><a href="/helpcenter/aboutus/">About us</a>
            </div>
          </div>
        </div>
      </div>
    </div>
EOL;
	
	if($admin_login=="yes"){
echo <<<EOL

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
									<li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> <b>$admin_name</b> <span class="caret"></span></a>
										<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu">
											
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
										<li class="active"><a href="#home" data-toggle="tab"><span class="glyphicon glyphicon-home"></span> <b>Home</b></a></li>
										<li><a href="#RegIns" data-toggle="tab"><span class="glyphicon glyphicon-user"></span><span class="glyphicon glyphicon-plus"></span> <b>Register an Instructor</b></a></li>
										<li><a href="#RegStd" data-toggle="tab"><span class="glyphicon glyphicon-plus"></span> <b>Register an Student</b></a></li>	
									</ul>
								</div>
							<div class="col-sm-9 tabwrapper">
								<div id="tabwrapper" class="tab-content ">
								   	<div class="tab-pane fade in active" id="home">
								         <div class="row"><div class="col-sm-2"></div>
                               <div class="col-sm-8" style="margin-top: 30px; margin-bottom:215px;">                      
                                   <div class="list-group">
                                  <a class="list-group-item">
                                    Name : <b>$admin_name</b>
                                  </a>
                                  <a class="list-group-item">
                                    Admin ID : <b>$admin_id</b>
                                  </a>
                                  <a class="list-group-item">
                                    Email ID : <b>$admin_email</b>
                                  </a>
                                </div></div></div>
								   </div>
								   <div class="tab-pane fade" id="RegIns">         
								      <form class="form-horizontal" role="form" onsubmit="return regInstructor()" id="in-settings-form" style="margin-top:50px;">
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="text">ID:</label>
                              <div class="col-sm-5">
                                <input type="text" class="form-control" id="i_id" name="i_id" placeholder="Enter the Unique ID of an Instructor">
                              </div><span class="text-danger" id="in-err"></span>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">Name:</label>
                              <div class="col-sm-5">
                                <input type="text" id="in-name" class="form-control" name="in-name" placeholder="Enter the Name">
                              </div><span class="text-danger" id="in-name-err"></span>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">Email:</label>
                              <div class="col-sm-5">
                                <input type="text" id="in-email" class="form-control" name="in-email" placeholder="Enter Email">
                              </div><span class="text-danger" id="in-email-err"></span>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">Class ID:</label>
                              <div class="col-sm-5">
                                <input type="text" id="in-class" class="form-control" name="in-class" placeholder="Enter Class_ID">
                              </div><span class="text-danger" id="in-class-err"></span>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">Course ID:</label>
                              <div class="col-sm-5">
                                <input type="text" id="in-course" class="form-control" name="in-course" placeholder="Enter Course_ID">
                              </div><span class="text-danger" id="in-course-err"></span>
                            </div>
                                

                           <div class="form-group">        
                              <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info">Register an Instructor</button>
                              </div>
                            </div>
                          </form>
								   </div>
								   <div class="tab-pane fade" id="RegStd">            
									<form class="form-horizontal" role="form" onsubmit="return regStudent()" id="in-settings-form" style="margin-top:50px;">
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="text">USN:</label>
                              <div class="col-sm-5">
                                <input type="text" class="form-control" id="usn" name="usn" placeholder="Enter the USN of the Student">
                              </div><span class="text-danger" id="usn-err"></span>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">Name:</label>
                              <div class="col-sm-5">
                                <input type="text" id="st-name" class="form-control" name="st-name" placeholder="Enter the Name">
                              </div><span class="text-danger" id="st-name-err"></span>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">Email:</label>
                              <div class="col-sm-5">
                                <input type="text" id="st-email" class="form-control" name="st-email" placeholder="Enter Email">
                              </div><span class="text-danger" id="st-email-err"></span>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">Class ID:</label>
                              <div class="col-sm-5">
                                <input type="text" id="st-class" class="form-control" name="st-class" placeholder="Enter Class_ID">
                              </div><span class="text-danger" id="st-class-err"></span>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">Course ID:</label>
                              <div class="col-sm-5">
                                <input type="text" id="st-course" class="form-control" name="st-course" placeholder="Enter Course_ID">
                              </div><span class="text-danger" id="st-course-err"></span>
                            </div>
                           <div class="form-group">        
                              <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info">Register</button>
                              </div>
                            </div>
                          </form>
										</div>
								</div>
							</div>
						</div>
					</div>
						<div class="panel-footer">
							Copyright - Smart Quizzer<a href="/feedback.php">Feedback</a><a href="/helpcenter/aboutus/">About us</a>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<!-- Modal to display success message -->
<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true" id="post-success">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            New student added successfully<b><span id="quiz-date"></span></b>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="post-success" onclick="location.reload()">Ok</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal to display success message -->
  <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true" id="reg-success">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            New student added successfully<b><span id="quiz-date"></span></b>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="post-success" onclick="location.reload()">Ok</button>
        </div>
      </div>
    </div>
  </div>
EOL;

} ?>
 </body>
</html>