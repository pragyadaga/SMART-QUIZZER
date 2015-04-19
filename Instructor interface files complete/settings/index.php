<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT']."/consql.php"; 

if($in_login=="yes"){
    $result=mysqli_query($conn,"SELECT i_name, email FROM instructor WHERE i_id='$in_id'");
    $row=mysqli_fetch_array($result);
    $in_name=$row['i_name'];
    $in_email=$row['email'];
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

if($st_login=="yes"){
echo <<<EOL
   <a href="/api/logout/">logout student</a>
    $st_id;

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
										<li><a href="#" onclick="window.location.replace('/')"><span class="glyphicon glyphicon-home"></span> <b>Home</b></a></li>
										<li class="active"><a href="#account-details" data-toggle="tab"><span class="glyphicon glyphicon-th-list"></span> <b>Account details</b></a></li>
										<li><a href="#change-pass" data-toggle="tab"><span class="glyphicon glyphicon-edit"></span> <b>Change password</b></a></li>
										<li><a href="#change-email" data-toggle="tab"><span class="glyphicon glyphicon-envelope"></span> <b>Change email ID</b></a></li>
									</ul>
								</div>
							<div class="col-sm-9 tabwrapper">
								<div id="tabwrapper" class="tab-content ">
								   <div class="tab-pane fade in active" id="account-details">
                               <div class="row"><div class="col-sm-2"></div>
                               <div class="col-sm-8" style="margin-top: 30px; margin-bottom:215px;">                      
                                   <div class="list-group">
                                  <a class="list-group-item">
                                    Name : <b>$in_name</b>
                                  </a>
                                  <a class="list-group-item">
                                    Intstructor ID : <b>$in_id</b>
                                  </a>
                                  <a class="list-group-item">
                                    Email ID : <b>$in_email</b>
                                  </a>
                                </div></div></div>
                            
								   </div>
								   <div class="tab-pane fade" id="change-pass">
                            <form class="form-horizontal" role="form" onsubmit="return changePass()" id="in-settings-form" style="margin-top:50px;">
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="text">Current password:</label>
                              <div class="col-sm-5">
                                <input type="password" class="form-control" id="cur-pass" name="cur-pass" placeholder="Enter your current password">
                              </div><span class="text-danger" id="cur-pass-err"></span>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">New password:</label>
                              <div class="col-sm-5">
                                <input type="password" id="new-pass-1" class="form-control" name="new-pass-1" placeholder="Enter new password">
                              </div><span class="text-danger" id="new-pass-1-err"></span>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">New password again:</label>
                              <div class="col-sm-5">
                                <input type="password" id="new-pass-2" class="form-control" name="new-pass-2" placeholder="Enter new password again">
                              </div><span class="text-danger" id="new-pass-2-err"></span>
                            </div>

                           
                            <div class="form-group" style="margin-bottom:240px;">        
                              <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info">Change password</button>
                              </div>
                            </div>
                          </form>
								</div>
									<div class="tab-pane fade" id="change-email">
										 <form class="form-horizontal" role="form" onsubmit="return changeEmail()" id="in-settings-form" style="margin-top:50px;">
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="text">New email Id:</label>
                              <div class="col-sm-5">
                                <input type="text" class="form-control" id="new-email" name="new-email" placeholder="Enter new email ID">
                              </div><span class="text-danger" id="new-email-err"></span>
                            </div>
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="pwd">Password:</label>
                              <div class="col-sm-5">
                                <input type="password" id="new-email-pass" class="form-control" name="new-email-pass" placeholder="Enter password">
                              </div><span class="text-danger" id="new-email-pass-err"></span>
                            </div>
                           
                            <div class="form-group" style="margin-bottom:289px;">        
                              <div class="col-sm-offset-4 col-sm-8">
                                <button type="submit" class="btn btn-info">Change email id</button>
                              </div>
                            </div>
                          </form>
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
		</div>

<div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true" id="change-pass-success">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
             Password changed successfully
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="post-success" onclick="location.reload()">Ok</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" role="dialog" aria-labelledby="gridSystemModalLabel" aria-hidden="true" id="change-email-success">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            Email ID changed successfully
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="post-success" onclick="location.reload()">Ok</button>
        </div>
      </div>
    </div>
  </div>
EOL;
}

else
        header("location:/");
    ?>

  </body>
</html>