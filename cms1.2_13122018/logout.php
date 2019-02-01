<?php
session_start() ;
/*----------------------------update log file begin-------------------------------------------*/
   //$cdate=date('d/m/Y H:i:s');  $action="Logout(".$_SESSION['username'].")"; $username=$_SESSION['username'];
   //write_log($cdate,$action,$username);
    /*----------------------------update log file End---------------------------------------------*/ 
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
//session_destroy();
// Jump to login page
header('Location: index.php');
exit;
?>