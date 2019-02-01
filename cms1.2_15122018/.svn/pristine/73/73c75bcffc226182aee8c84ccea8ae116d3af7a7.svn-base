<?php
include_once 'corefunction.php';
if($_POST['id'])
{ $id=$_POST['id']; $email=$_POST['email'];
$delete = "DELETE FROM `user_registration` WHERE uid='$id'";
$r= db_query($conn,$delete);
/*----------------------------update log file begin-------------------------------------------*/
   //$cdate=date('d/m/Y H:i:s');  $action="Delete(".$email.")"; $username=$_SESSION['username'];
   //write_log($cdate,$action,$username);
    /*----------------------------update log file End---------------------------------------------*/ 
   
echo 1;
}

?>
