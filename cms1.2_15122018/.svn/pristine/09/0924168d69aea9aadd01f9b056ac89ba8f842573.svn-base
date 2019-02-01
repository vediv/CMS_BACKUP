<?php
include_once 'corefunction.php';
if($_POST['id'])
{
$id=$_POST['id'];
$ttag=$_POST['tname'];
$delete = "DELETE FROM `home_title_tag` WHERE tags_id='$id'";

/*----------------------------update log file begin-------------------------------------------*/
   //$cdate=date('d/m/Y H:i:s');  $action="Delete Tilte(".$ttag.")"; $username=$_SESSION['username'];
   //write_log($cdate,$action,$username);
    /*----------------------------update log file End---------------------------------------------*/ 
   
$r= db_query($conn,$delete);
echo 1;
}

?>