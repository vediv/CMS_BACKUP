<?php
include_once 'corefunction.php';
$currentDate=date('Y-m-d');
$results ="SELECT  status FROM user_registration WHERE DATE(added_date) = '$currentDate'";
$que = db_select($conn,$results);
$num_rows=db_totalRow($conn,$results);
//$num_rows = mysqli_num_rows($results);
if($num_rows==0)
{
	$num_rows=" 0";
	//echo $num_rows;
}else{ $num_rows=$num_rows; echo $num_rows;}
 ?>
 
