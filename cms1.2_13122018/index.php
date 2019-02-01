<?php
//error_reporting(0);
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', TRUE); 
date_default_timezone_set('Asia/Calcutta');
$PubID =(isset($_GET['PubID']))? $_GET['PubID']:''; //publisher ID
$pid =(isset($_GET['pid']))? $_GET['pid']:''; //publisher Table ID
$pemail=(isset($_GET['email']))? $_GET['email']:'';
// this ID come from SuperAdmin Dasboard
if($PubID!='' && $pemail!='')
{
    include_once 'core.php';
    header("Location:dashboard.php");
    die();
}
/* check if login then redirect to dashboard page.*/
session_start();
$_SESSION['publisher_info']['dasbord_user_id'];
$_SESSION['publisher_info']['publisher_unique_id'];
if(isset($_SESSION['publisher_info']['dasbord_user_id']) && isset($_SESSION['publisher_info']['publisher_unique_id'])){
    header('location:dashboard.php');
    die();
}

//first all session unset and then set new session for every time.
///unset($_SESSION['publisher_info']['acess_level']);
unset($_SESSION['publisher_info']['dasbord_user_id']);
unset($_SESSION['publisher_info']['publisher_unique_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo "OTT | publisher"; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
</head>
<body class="skin-blue layout-top-nav" style="background-color: black;">
<header class="main-header">               
    <nav class="navbar navbar-static-top">
      <a href="#" class="logo"> OTT - Publisher</a>
        <?php //include_once 'header.php'; ?> 
    </nav>
</header>
       <div class="login-box" style="border: 0px solid red;">
      
      <div class="login-box-body">
        <p class="login-box-msg">Login To Your Account</p>
        <span class="error"> </span>
        <form  method="post" >
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="Email Id" maxlength="64" name="email" id="email" required/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <span class="help-block has-error" id="email-error"></span>
          </div>
         <div class="form-group has-feedback">
             <input type="password" class="form-control"   placeholder="Password" name="password" id="password" required/>
             <span class="glyphicon glyphicon-lock form-control-feedback"></span>
             <span class="help-block has-error" id="password-error"></span>
         </div>
          <div class="row">
            <div class="col-xs-8">    
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" name ="submit" class="btn btn-primary btn-block btn-flat">Log In</button>
            </div><!-- /.col -->
            <div class="col-xs-12 text-center" id="response_status" style="border:0px solid red; margin-top: 5px;">
             
            </div><!-- /.col -->
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
<script src="plugins/jQuery/jQuery-2.1.3.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function() {
$('form').submit(function() {
            //$('#response_status').css('color','black');
            $('#response_status').html('<p><img src="img/image_process.gif"> Please Wait for  login....</p>'); 
            var email = $('#email').val();
            var password = $('#password').val();
            $.post('includes/login_core.php',{email: email,password:password,action:'login'},
            function(result){ 
            if(result==1){
               window.location.href="dashboard.php";	
            }
            if(result==2)
            {
                var msg="<p class='login-box-msg'><span style='color: red'>Email-Id or Password is not correct. Please try again.</span></p>";
                $("#response_status").html(msg);

            }
            if(result==0){
               var msg="<p class='login-box-msg'><span style='color: red'>Your login Credential is De-activated. Please contact admin</span></p>";  
               $("#response_status").html(msg);
            }

});
   return false;      // required to not open the page when form is submited
});
});
</script>
</body>
</html>
