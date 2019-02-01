<?php
include_once 'corefunction.php';
if($_POST['id'])
{
 $parID=$_POST['id'];
 include_once 'function.inc.publisher.php';
 $del="DELETE from ott_publisher.publisher where par_id='$parID'";
 $r=db_query1($del);
 $delete="DELETE from publisher where par_id='$parID'";
 $res=db_query($conn,$delete);
  /*----------------------------update log file begin-------------------------------------------*/
   //$cdate=date('d/m/Y H:i:s');  $action="Delete dashboard user(".$name.")"; $username=$_SESSION['username'];
   //write_log($cdate,$action,$username);
    /*----------------------------update log file End---------------------------------------------*/ 
echo 1;
 
}

?>