<?php
session_start();
//unset($_SESSION['publisher_info']['acess_level']);
unset($_SESSION['publisher_info']['dasbord_user_id']);
unset($_SESSION['publisher_info']['publisher_unique_id']);
//unset($_SESSION['publisher_info']['username']);
//unset($_SESSION['publisher_info']['company']);
//unset($_SESSION['publisher_info']['partner_id']);
//unset($_SESSION['publisher_info']['service_url']);
//unset($_SESSION['publisher_info']['adminsecret']);
//unset($_SESSION['publisher_info']['kalturaUser']);
// database Detail
//unset($_SESSION['publisher_info']['dbHostName']);
//unset($_SESSION['publisher_info']['dbUserName']);
//unset($_SESSION['publisher_info']['dbpassword']);
//unset($_SESSION['publisher_info']['databaseName']);
unset($_SESSION['publisher_info']['sess_for_ref']);
include_once 'function.inc.publisher.php';
$qry="select par_id,publisherID from ott_publisher.publisher where partner_id='$PubID' and par_id='$pid' and email='$pemail'";
$row=db_select1($qry);
$_SESSION['publisher_info']['dasbord_user_id'] = $row[0]['par_id'];
$_SESSION['publisher_info']['publisher_unique_id'] = $row[0]['publisherID'];


/*$_SESSION['publisher_info']['acess_level.'] = $row[0]['acess_level'];
$_SESSION['publisher_info']['dasbord_user_id'] = $row[0]['par_id'];
$_SESSION['publisher_info']['publisher_unique_id'] = $row[0]['publisherID'];
$_SESSION['publisher_info']['username'] = $row[0]['name'];
$_SESSION['publisher_info']['company'] = $row[0]['company'];
$_SESSION['publisher_info']['partner_id'] = trim($row[0]['partner_id']);
$_SESSION['publisher_info']['service_url'] = $row[0]['service_url'];
$_SESSION['publisher_info']['adminsecret'] = trim($row[0]['admin_secret']);
$_SESSION['publisher_info']['kalturaUser'] = $row[0]['name'];
// database Detail
$_SESSION['publisher_info']['dbHostName'] = trim($row[0]['dbHostName']);
$_SESSION['publisher_info']['dbUserName'] = trim($row[0]['dbUserName']);
$_SESSION['publisher_info']['dbpassword'] = trim($row[0]['dbpassword']);
$_SESSION['publisher_info']['databaseName'] = trim($row[0]['dbName']);*/
?>
