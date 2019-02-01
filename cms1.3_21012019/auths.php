<?php
session_start();
if(!isset($_SESSION['publisher_info']['publisher_unique_id']) && !isset($_SESSION['publisher_info']['publisher_unique_id'])){
header("Location:index.php");
	exit;
}

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', TRUE);
//error_reporting(0);
date_default_timezone_set('Asia/Calcutta');
?>
