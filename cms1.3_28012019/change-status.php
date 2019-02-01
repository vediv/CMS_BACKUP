<?php
include_once 'corefunction.php';
if (isset($_POST['status'])){
     $id = $_POST['id'];
	 $status = ($_POST['status'] == '1') ? 1: 0;
	$query = "update slider_image_detail set img_status = $status where img_id=$id";
//echo $query;
echo $res = db_query($conn,$query);

}
?>
