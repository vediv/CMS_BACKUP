<?php
include_once 'corefunction.php';
if (isset($_POST['id'])){
$id = $_POST['id'];
$query1 = "SELECT img_name FROM slider_image_detail  where img_id='$id'";
$res1 =  db_select($query1);
$img_name=$res1[0]['img_name'];
$path = IMG_SLIDER_PATH; // this is define in auths.php
/* remove all imgage file from folder */
$orginalImg =IMG_SLIDER_PATH.$img_name;         unlink($orginalImg);
$Img_480 =IMG_SLIDER_PATH."480_".$img_name;     unlink($Img_480);
$Img_640 =IMG_SLIDER_PATH."640_".$img_name;     unlink($Img_640);
$Img_720 =IMG_SLIDER_PATH."720_".$img_name;     unlink($Img_720);
$Img_1080 =IMG_SLIDER_PATH."1080_".$img_name;   unlink($Img_1080);
$query2 = "DELETE FROM slider_image_detail  where img_id='$id'";
$res =db_query($query2);
 /*----------------------------update log file begin-------------------------------------------*/
   //$cdate=date('d/m/Y H:i:s');  $action="Delete Image(".$img_name.")"; $username=$_SESSION['username'];
   //write_log($cdate,$action,$username);
    /*----------------------------update log file End---------------------------------------------*/ 
}
echo 1;
?>
