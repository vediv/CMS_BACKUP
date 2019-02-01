<?php
include_once 'corefunction.php';
//$act=$_POST['action'];
  $filtervalue=$_POST['filtervalue'];
  $tag=$_POST['tag'];
  $up="update filter_setting set filtervalue='".$filtervalue."' where filtertag='".$tag."' and par_id='$get_user_id'";
  $rr=  db_query($conn,$up);
  echo 1;
?>
