<?php
include_once 'corefunction.php';
if($_POST['id'])
{
$id=$_POST['id'];
$hyper=$_POST['hyp'];
$delete = "DELETE FROM `dashbord_footer` WHERE f_id='$id'";
$r= db_query($conn,$delete);
/*----------------------------update log file begin-------------------------------------------*/
   //$cdate=date('d/m/Y H:i:s');  $action="Delete Footer(".$hyper.")"; $username=$_SESSION['username'];
   //write_log($cdate,$action,$username);
    /*----------------------------update log file End---------------------------------------------*/ 
echo 1;

}

?>