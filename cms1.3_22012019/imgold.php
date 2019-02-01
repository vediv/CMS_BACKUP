<?php
include_once 'corefunction.php';; 
if(isset($_POST['name']))
{
	$name1=$_POST['name'];
	$q_sql="select count(*) as totalcount from slider_image_detail where img_name='$name1'";
	$rw = db_select($conn,$q_sql);
    $img=$rw[0]['totalcount'];
	$total=db_totalRow($conn,$q_sql);
    //$total=mysqli_num_rows($res1);
 
if($img>=1)
{
	//$message= "Image already exist and upload with different name";
	echo 1;
	
}
else{
	     
//$mysqli->query($query);
	echo 2;}

}
?>
       
       
       
       
