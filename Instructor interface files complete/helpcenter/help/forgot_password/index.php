<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon">
        <title>Smart Quizzer</title>

        <script src="/script/jquery-1.11.2.min.js"></script>
        <script src="/script/bootstrap.min.js"></script>
        <script src="/script/script.js"></script>

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
                    <div class="panel-heading">Welcome, Forgot Password Page</div>
                    <div class="top-buffer-sm"></div>
                    <div class="panel-body">

                      <div class="top-buffer-sm"></div>

                      <div class="panel panel-default"  id="st-lgn">
                        <div class="panel-body">
                          <form class="form-horizontal" role="form" action='#' method='Post' >
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="text">EMAIL:</label>
                              <div class="col-sm-5">
                                <input type="text" class="form-control" id="email-id" name="email" placeholder="Enter your Email_ID" data-toggle="popover" data-content="Invalid Username/Password combination">
                              </div>
                            </div>
                            

                            <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                
                              </div>
                            </div>
                            <div class="form-group">        
                              <div class="col-sm-offset-1 col-sm-10">
                                <button type="submit" name='submit' class="btn btn-info">Email the password</button>
                              </div>
                            </div>
                          </form>
						  <?php
						  
if(isset($_POST['submit']))
{ 
 mysql_connect('localhost','root','') or die(mysql_error());
 mysql_select_db('smart_quizzer') or die(mysql_error());
 $mail=$_POST['email'];
 $q=mysql_query("select * from student where email='".$mail."' ") or die(mysql_error());
 $p=mysql_affected_rows();
 $q1=mysql_query("select * from instructor where email='".$mail."' ") or die(mysql_error());
 $p1=mysql_affected_rows();
 if($p!=0) 
 {
  $res=mysql_fetch_array($q);
  $to=$res['email'];
  $subject='Remind password';
  $message='Your password to login the smart quizzer is : '.$res['s_password']; 
  $headers='From:smartquizzer@gmail.com';
  $m=mail($to,$subject,$message,$headers);
  if($m)
  {
    echo'Check your inbox in mail';
  }
  else
  {
   echo'mail is not send';
  }
  echo nl2br("\n");
  echo 'Redirecting in 5 sec';
  header('Refresh: 5;url=index.php');
 }
    else if($p1!=0)
    {
  $res=mysql_fetch_array($q1);
  $to=$res['email'];
  $subject='Remind password';
  $message='Your password to login the smart quizzer is : '.$res['i_password']; 
  $headers='From:smartquizzer@gmail.com';
  $m=mail($to,$subject,$message,$headers);
  if($m)
  {
    echo'Check your inbox in mail';
  }
  else
  {
   echo'mail is not send';
  }
  echo nl2br("\n");
  echo 'Redirecting in 5 sec';
  header('Refresh: 5;url=index.php');
        
        
        
        
    }
 else
 {
	 $mail=$_POST['email'];
	 if($mail=='')
		 echo 'Please enter an email-id';
	 else
		echo'You entered mail id is not registered with smart Quizzer';
 }
}
?>
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
         </body>
</html>