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
                  <div class="text-center">
                    
                    <div class="top-buffer-sm"></div>
                    <div class="panel-body">

                      <div class="top-buffer-sm"></div>

                      <div class="panel panel-default"  id="st-lgn">
                        <div class="panel-body">
                          <form class="form-horizontal" role="form" action='/helpcenter/feedback/' method='Post' >
                            <div class="form-group">
                              <label class="control-label col-sm-4" for="text">Email:</label>
                              <div class="col-sm-5">
                                <input type="text" class="form-control"  name="Email" placeholder="Enter your Email-Id"><br>
                              </div>
                                <label class="control-label col-sm-4" for="text">FeedBack:</label>
                              <div class="col-sm-5">
									<textarea rows="5" cols="40" name="feedback" id="feedback" placeholder="Write Your FeedBack Here"></textarea>
							  </div>
                            </div>
                            

                            <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-5">
                                
                              </div>
                            </div>
                            <div class="form-group">        
                              <div class="col-sm-offset-1 col-sm-10">
                                <button type="submit" name='submit' class="btn btn-info">Submit</button>
                              </div>
                            </div>
                          </form>
						  <?php
						  ob_start();  
						  
if(isset($_POST['submit'])&& !empty($_POST['Email']) && !empty($_POST['feedback']) )
{
	$pyscript = 'C:\\wamp\\www\\helpcenter\\feedback\\mailer.py';
    $python = 'C:\\Python34\\python.exe';
    $mail=$_POST['Email'];
    $content=$_POST['feedback'];

    $cmd = "$python $pyscript \"$mail\" \"$content\"";
    exec("$cmd", $output);

    echo "FeedBack Recorded";
    echo nl2br("\n");
    echo 'Redirecting in 5 sec';
    header('Refresh: 5;url=/');
 }
    
    
else if(isset($_POST['submit']))
{
	echo 'All fields are required';   
}
ob_end_flush();
?>		  
						  </div>
                      </div>
                    </div>
                </div>
              </div>
            </div>
        </div><div class="panel-footer">Copyright - Smart Quizzer<a href="/helpcenter/aboutus/">About us</a>
        </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>