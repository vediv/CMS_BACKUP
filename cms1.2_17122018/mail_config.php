<?php  include_once 'corefunction.php';
$commanmsg = isset($_GET['val']) ? $_GET['val'] : '';
$confirmalert=$commanmsg!=''? "alert alert-success":"";
if(isset($_POST['profile_save'])) 
{   
     extract($_POST);
     $pwdmd5=$_POST['pwd'];
     $qmail_config="insert into mail_config(client_email,mail_pass,smtp_server,port) values('$mail','$pwdmd5','$smtp','$port')";
     $r = db_query($conn,$qmail_config);
     { header("Location:mail_config.php?val=successfully_added");  }
        
 }     
//For Update 
$client_id = isset($_GET['client_id']) ? $_GET['client_id'] : '';
$mail_e=''; $pwd_e=''; $port_e=''; $smtp_e=''; $edit_button_disable="disabled";
if($client_id!=''){  $edit_button_disable='';
$pquery="select * from mail_config where client_id='$client_id'";
$rr= db_select($conn,$pquery);
$client_id=$rr[0]['client_id']; $mail_e=$rr[0]['client_email'];  $pwd_e=($rr[0]['mail_pass']);  
$smtp_e=$rr[0]['smtp_server'];  $port_e=$rr[0]['port'];  
$edit_button_enable='';
} 


if(isset($_POST['edit']))
 {
   trim(extract($_POST));
   //$pwdmd5=md5($_POST['pwd']);
   $pwdmd5=$_POST['pwd'];
   $update="update mail_config set client_email='$mail',mail_pass='$pwdmd5',smtp_server='$smtp',port='$port' where client_id='$client_id' ";
   $res = db_query($conn,$update);	
   if($res)
    {
       header("Location:mail_config.php?val=successfully updated");       
    }
 }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title><?php echo ucwords(PROJECT_TITLE)." | SMTP Config";?></title>
  <link href="bootstrap/css/pagingCss.css" rel="stylesheet" type="text/css" />
<style type="text/css">
   	.card {    border-radius: 4px;    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), 0 0 0 1px rgba(63, 63, 68, 0.1); background-color: #FFFFFF; margin: 10px;}
.card .header {    padding: 5px 5px 0;}
.btn-info{background-color: #337ab7 !important}
h4, .title{	color:#337ab7 !important; }
.content {min-height: 209px !important}
hr{
	margin: 0px !important;
}
 </style>

  </head>
  <body class="skin-blue">
    <div class="wrapper">
      <?php include_once 'header.php';
      include_once 'lsidebar.php';?>
    
      <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: 700px !important;">
  <section class="content-header">
    <h1>Mail Configuration
    <!-- <small><span style="color:#3290D4" class="glyphicon glyphicon-plus " ></span></small>-->
    </h1> 
    <ol class="breadcrumb">
      <li><a href="dashbord.php"><i class="fa fa-home" title="Home"></i> Home</a></li>
      <li class="active">Mail Configuration</li>
    </ol>          
   </section>
     <section class="content">
           <div class="row" >
            <!-- left column -->
            <div class="col-md-12" >
              <!-- general form elements -->
              <div class="box box-primary" style="min-height:500px;">
                <div class="box-header">
                <h3 class="box-title">SMTP Configuration</h3>
                </div><!-- /.box-header -->
               
                <form role="form" method="post">
                  <div class="box-body">
                  <div class="<?php echo $confirmalert; ?>" style="margin:10px 10px 10px 10px; "><strong><?php echo $commanmsg; ?></strong></div>

                  <div class="form-group">
                      <label for="pay_value">E-Mail ID</label>
                   <input type="email" name="mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" id="mail" class="form-control" placeholder="Mail ID" value="<?php echo $mail_e;  ?>" required size="40">
                    </div>
                    <div class="form-group">
                      <label for="validity_type">E-Mail Password</label>
                      <input type="password" name="pwd" id="pwd" class="form-control" placeholder="Mail Password" required value="<?php echo $pwd_e;  ?>" size="30">
                    </div>
                    <div class="form-group">
                      <label for="validity_type">SMTP Server</label>
                      <input type="text" class="form-control" required name="smtp" id="smtp" placeholder="SMTP Server" value="<?php echo $smtp_e;  ?>" size="35">
                    </div>
                      <div class="form-group">
                      <label for="validity_type">Port</label>
                    <input type="text" name="port" id="port" required class="form-control" placeholder="Port:25" value="<?php echo $port_e==''?'25':$port_e;  ?>">
                    </div>
                  </div>
               
                 <div class="box-footer">
                  <?php
                  $p="select * from mail_config";
                  $rr1= db_select($conn,$p);
                   $totalCount=  db_totalRow($conn,$p); 
                  $client_id=$rr1[0]['client_id'];  $mail=$rr1[0]['client_email'];   
                   $smtp=$rr1[0]['smtp_server'];  $port=$rr1[0]['port']; 
                  ?>       
                 <?php  if(in_array(1, $UserRight)){ ?>    
                    <?php if($totalCount==0 and $client_id=='') { ?>
                    <input   type="submit"  class="btn btn-primary" name="profile_save"  value="Save" onClick="checkEmail(document.mailconfig.mail.value)"/>
                    <?php }?>
                     <?php if($totalCount>0 and $client_id!='') { ?>
                    <input   type="submit" <?php echo $edit_button_disable; ?>  class="btn btn-primary" name="edit"  value="Update" onClick="checkEmail(document.mailconfig.mail.value)"/>
                     <?php } } else{ ?>
                  <button type="submit" class="btn btn-primary"  name="submit" disabled>Save</button>
                <?php } ?>  
                 </div>
                </form>
                <div class="box-body" style="border: 0px solid red;">
                  
                 <div class="table-responsive">
                        <?php if($totalCount>0){ ?>
                    <table class="table no-margin">
                      <thead>
                        <tr>
                          
                          <th>Mail ID</th>
                          <th>SMTP Server</th>
                          <th>Port</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        
                       <tr>
                          <td><?php echo $mail; ?></td>
                          <td><?php echo $smtp ?></td>
                          <td><?php echo $port; ?></td>
                          <td>
                          <?php  if(in_array(2, $UserRight)){ ?> 
                           <a href="mail_config.php?client_id=<?php echo $client_id ;?>"><i class="fa fa-edit" ></i></a>
                          <?php } ?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                        <?php }?>
                  </div><!-- /.table-responsive -->
                 </div>
              </div>
              
              
            </div><!--/.col (left) -->
            <!-- right column -->
           
          </div>
 </section>
  </div>
    
         <?php 
include_once "footer.php"; 
include_once 'commonJS.php';  
?>
</div><!-- ./wrapper -->
     </body>
</html>
