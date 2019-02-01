<?php
//session_start();
// this session come from core.php page written by santosh 14 feb 2017 5:33 PM
define("SERVICEURL",$_SESSION['publisher_info']['service_url']);  
define("PARTNER_ID", $_SESSION['publisher_info']['partner_id']);
define("PUBLISHER_UNIQUE_ID",$_SESSION['publisher_info']['publisher_unique_id']);
define("DASHBOARD_USER_ID", $_SESSION['publisher_info']['dasbord_user_id']);
define("DASHBOARD_USER_NAME",$_SESSION['publisher_info']['username']);
define("ADMINSECRET",$_SESSION['publisher_info']['adminsecret']);
define("USER_ID", $_SESSION['publisher_info']['kalturaUser']);
// database credential Define
define("DATABASE_HOST_NAME",$_SESSION['publisher_info']['dbHostName']);
define("DATABASE_USER_NAME",$_SESSION['publisher_info']['dbUserName']);
define("DATABASE_PASSWORD",$_SESSION['publisher_info']['dbpassword']);
define("DATABASE_Name",$_SESSION['publisher_info']['databaseName']);
// publisher Folder Folder in data Directory
define("PUBLISHER_DIR",$_SESSION['publisher_info']['databaseName']);

/*define("SERVICEURL",$row[0]['service_url']);  
define("PARTNER_ID",trim($row[0]['partner_id']));
define("PUBLISHER_UNIQUE_ID",$row[0]['publisherID']);
define("DASHBOARD_USER_ID", $row[0]['par_id']);
define("DASHBOARD_USER_NAME",$row[0]['name']);
define("ADMINSECRET",trim($row[0]['admin_secret']));
define("USER_ID", $row[0]['name']);
// database credential Define
define("DATABASE_HOST_NAME",trim($row[0]['dbHostName']));
define("DATABASE_USER_NAME",trim($row[0]['dbUserName']));
define("DATABASE_PASSWORD",trim($row[0]['dbpassword']));
define("DATABASE_Name",trim($row[0]['dbName']));
// publisher Folder Folder in data Directory
define("PUBLISHER_DIR",trim($row[0]['dbName']));
*/
?>
