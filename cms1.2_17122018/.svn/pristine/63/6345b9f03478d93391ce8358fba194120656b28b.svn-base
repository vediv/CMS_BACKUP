<?php 
//include_once 'core_config.php'; 
//$partnerID=$_SESSION['publisher_info']['partner_id'];
$publisher_unique_id=$_SESSION['publisher_info']['publisher_unique_id'];
$get_user_id=$_SESSION['publisher_info']['dasbord_user_id'];
include_once 'function.inc.publisher.php';
// get Information from 
$qry="select par_id,acess_level,publisherID,name,company,partner_id,service_url,admin_secret,dbHostName,dbUserName,dbpassword,dbName
from ott_publisher.publisher where par_id='$get_user_id' and publisherID='$publisher_unique_id'";
$row=db_select1($qry);
define("SERVICEURL",$row[0]['service_url']);  
define("PARTNER_ID",trim($row[0]['partner_id']));
define("PUBLISHER_UNIQUE_ID",$row[0]['publisherID']); 
define("DASHBOARD_USER_ID", $row[0]['par_id']);
define("DASHBOARD_USER_NAME",$row[0]['name']);
define("COMPANY_NAME",$row[0]['company']);
define("ADMINSECRET",trim($row[0]['admin_secret']));
define("ACCESS_LEVEL", $row[0]['acess_level']);
define("USER_ID", $row[0]['name']);

define("DATABASE_Name",trim($row[0]['dbName']));
// publisher Folder Folder in data Directory
define("PUBLISHER_DIR",trim($row[0]['dbName']));

//$DATABASE_Name=$_SESSION['publisher_info']['databaseName'];
define("PROJECT_TITLE",$row[0]['company']);
define("TEMP_VIDEO_UPLOAD_PATH","/video/data/".DATABASE_Name."/vid_temp/");
define("TEMP_VIDEO_THUMNAIL_PATH","tmp_thumbnail/");
define("TEMP_IMAGE_PATH","../data/".DATABASE_Name."/template/");
define("TEMPLATE_CONFIG_PATH","templates/");
define("SET_TEMPLATE_CONFIG_PATH","/data/".DATABASE_Name."/template/");
?>
