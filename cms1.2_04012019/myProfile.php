<?php 
include_once 'corefunction.php';
//$get_user_id; $publisher_unique_id;;
$qry="select email,par_id,name,publisher_pass from publisher
      where par_id='".$get_user_id."' and publisherID='".$publisher_unique_id."' "; 
$fetchD= db_select($conn,$qry);
$email=$fetchD[0]['email']; $PublisherName=$fetchD[0]['name']; $publisher_pass=$fetchD[0]['publisher_pass'];
if(isset($_POST['saveProfile']))
{
    $name=$_POST['uname'];
    include_once 'function.inc.publisher.php';
    $up="update ott_publisher.publisher set name='$name' where par_id='".$get_user_id."' and publisherID='".$publisher_unique_id."' ";
    $rr=db_query1($up); 
      /* insert in client DB */
    $upp="update publisher set name='$name' where par_id='".$get_user_id."' and publisherID='".$publisher_unique_id."' ";
    $rr=db_query($conn,$upp); 
     /*----------------------------update log file begin-------------------------------------------*/
    $error_level=1;$msg="update MyProfile($name)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
    $qry='';
    write_log($error_level,$msg,$lusername,$qry);
   /*----------------------------update log file End---------------------------------------------*/
   header("location:myProfile.php?msg=1");
} 
$successMsg=''; $successMsgpass='';

$getMsg=isset($_GET['msg'])?$_GET['msg'] :0;

if($getMsg==1)
{
    $successMsg='<div class="alert alert-success">
    <strong>Success!</strong> Profile Update Successfully.
    </div>';
}   
if($getMsg==2)
{
    $successMsgpass='<div class="alert alert-success">
    <strong>Success!</strong> Password Change Successfully.
    </div>';
}

if(isset($_POST['savePassword']))
  {
     $oldPass=$_POST['oldPass']; $newPass=md5($_POST['newPass']);$confirmPass=md5($_POST['confirmPass']); 
     $MD5oldPass=md5($oldPass);
     if($publisher_pass!=$MD5oldPass)  
     {
         $successMsgpass='<div class="alert alert-danger"> Enter Correct old password.
         </div>';
     }
     else
     {
         include_once 'function.inc.publisher.php';
         $up="update ott_publisher.publisher set publisher_pass='$confirmPass' where par_id='".$get_user_id."' and publisherID='".$publisher_unique_id."' ";
         $rr=db_query1($up); 
         /* Update in client DB */
         $upp="update publisher set publisher_pass='$confirmPass' where par_id='".$get_user_id."' and publisherID='".$publisher_unique_id."' ";
          $rr=db_query($conn,$upp); 
          /*----------------------------update log file begin-------------------------------------------*/
         $error_level=1;$msg="Change password in myProfile($confirmPass)"; $lusername=DASHBOARD_USER_NAME."_".PUBLISHER_UNIQUE_ID;
         $qry='';
         write_log($error_level,$msg,$lusername,$qry);
        /*----------------------------update log file End---------------------------------------------*/ 
        // $successMsgpass='<div class="alert alert-success">
         //<strong>Success!</strong> Matched.
         //</div>';
         header("location:myProfile.php?msg=2");
     }    

  } 
?>
<!DOCTYPE html>
<html>
  <head>
<meta charset="UTF-8">
<title><?php echo PROJECT_TITLE." | PlanDetail";?></title>
<link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<style type="text/css">
.box-header {  padding: 4px 10px 0px 10px !important;  }
.navbar-form .input-group > .form-control {    height: 26px !important; }
h5 {margin-top: 0px  !important;}
.input-group-btn:last-child > .btn, .input-group-btn:last-child > .btn-group {
    height: 26px;
    margin-left: -1px;
    padding: 4px;
}
 
</style>
  </head>
  <body class="skin-blue">
    <div class="wrapper">
   <?php include_once 'header.php';?>
           <!-- Left side column. contains the logo and sidebar -->
      <?php include_once 'lsidebar.php';?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
         <section class="content-header">
         <h1>My Profile
        
         
</h1>
 <ol class="breadcrumb">
   <li><a href="dashboard.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
   <li class="active">My Profile </li>
 </ol>
</section>
        <!-- Main content -->
<section class="content">
           <div class="row" >
            <!-- left column -->
            <div class="col-md-6" >
              <!-- general form elements -->
              <div class="box box-primary" style="min-height:500px;">
                <div class="box-header">
                <h3 class="box-title">Edit Profile</h3>
                </div><!-- /.box-header -->
                <form role="form" method="post">
                  <div class="box-body">
                 <?php echo $successMsg; ?>     
                    <div class="form-group">
                      <label for="uemail">Email</label>
                      <input type="uemail" class="form-control" id="uemail" value="<?php echo $email; ?>" readonly placeholder="Enter email">
                    </div>
                    <div class="form-group">
                      <label for="uname">Name</label>
                      <input type="uname" name="uname" id="uname" maxlength="20" pattern="[a-zA-Z\s]+" value="<?php echo $PublisherName; ?>" class="form-control" required  placeholder="Name">
                    </div>
                   </div><!-- /.box-body -->
                 <div class="box-footer">
                     <button type="submit" name="saveProfile"  class="btn btn-primary">Submit</button>
                 </div>
                </form>
              </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
              <!-- general form elements disabled -->
              <div class="box box-warning" style="min-height:500px;">
                <div class="box-header">
                 <h3 class="box-title">Change Password</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <?php echo $successMsgpass; ?> 
                    <form role="form" method="post" onsubmit="return Validation()">
                    <!-- text input -->
                    <div class="form-group">
                      <label>Old Password</label> 
                      <input type="password" class="form-control" id="oldPass" name="oldPass" placeholder="Enter Old password" required/>
                    </div>
                     <div class="form-group">
                      <label>New Password</label>
                      <input type="password" id="newPass" name="newPass" class="form-control" required placeholder="Enter New Password"/>
                    <span class="help-block has-error" data-error="0" id="newPass-error" style="color:red;"></span>  
                     </div>
                     <div class="form-group">
                      <label>Confirm Password</label>
                      <input type="password" id="confirmPass" name="confirmPass"  required class="form-control" placeholder="Enter Confirm Password"/>
                     <span class="help-block has-error" data-error="0" id="confirmPass-error" style="color:red;"></span>  
                     </div>
                    <div class="box-footer">
                     <button type="submit" name="savePassword"  class="btn btn-primary">Submit</button>
                  </div>
                  </form>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!--/.col (right) -->
          </div>
 </section>
</div>
    <?php include_once "footer.php"; include_once 'commonJS.php'; ?>
    </div>     
      <script type="text/javascript"> 
      function checkPassword(str)
      {
      // at least one number, one lowercase and one uppercase letter
      // at least six characters that are letters, numbers or the underscore
      //var re = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])\w{6,}$/;
      var re = /^(?=.*\d)(?=.*[!@#$%^&*_])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
      return re.test(str);
      }
      function Validation() {
       $(".has-error").html('');   
       var mess="at least one number, one lowercase and one uppercase letter,at \n\
       least six characters that are letters, numbers or special characters @#$%^&*_";
       var newPass=$('#newPass').val();
       var confirmPass=$('#confirmPass').val();
       if(!checkPassword(newPass)) {
        $("#newPass-error").html(mess); return false;
       }
       if(!checkPassword(confirmPass)) {
        $("#confirmPass-error").html(mess); return false;
       }
       if(newPass!=confirmPass)
       {
           $("#confirmPass-error").html("new password and confirmation password do not match."); return false;
       } 
    }
      </script>      
</body>
</html>
